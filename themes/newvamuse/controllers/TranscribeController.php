<?php
/* ----------------------------------------------------------------------
 * controllers/TranscribeController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	require_once(__CA_LIB_DIR__."/ApplicationError.php");
	require_once(__CA_LIB_DIR__."/Datamodel.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_users.php");
 	require_once(__CA_MODELS_DIR__."/ca_representation_transcriptions.php");
 	require_once(__CA_APP_DIR__."/controllers/FindController.php");
 	require_once(__CA_LIB_DIR__.'/Media/MediaViewerManager.php');
 
 	class TranscribeController extends FindController {
 		# -------------------------------------------------------
        /**
         * @var array
         */
 		 protected $opa_access_values;

        /**
         * @var
         */
        protected $opb_is_login_redirect = false;
        
        /**
         * @var HTMLPurifier
         */
        protected $purifier;
        
 		# -------------------------------------------------------
        /**
         * @param RequestHTTP $po_request
         * @param ResponseHTTP $po_response
         * @param null $pa_view_paths
         * @throws ApplicationException
         */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);

            // Catch disabled flag
            if ($this->request->config->get('allow_transcriptions') && $this->request->config->get('allow_transcriptions')) {
 				throw new ApplicationException('Transcription is not enabled');
 			}
 			
 			$this->config = Configuration::load("transcription.conf");
 			if ($this->config->get('require_login')) {
				if (!($this->request->isLoggedIn())) {
					$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
					$this->opb_is_login_redirect = true;
					return;
				}
			}

 			caSetPageCSSClasses(array("sets", "transcribe"));
 			
			$this->purifier = new HTMLPurifier();
			
 			parent::setTableSpecificViewVars();
 		}
 		# ------------------------------------------------------
        /**
         *  Home page – intro, featured collections, navigation
         */
 		function Index($options = null) {
 			AssetLoadManager::register("carousel");
 			
 			$o_context = new ResultContext($this->request, 'ca_objects', 'transcribe', 'collections');	// collections context - next/prev here through collections
 			$o_context->setAsLastFind();
 			
 			$qr_sets = ca_sets::find(["type_id" => "transcription_collection", "featured" => "yes"], ['returnAs' => 'searchResult', 'checkAccess' => $this->opa_access_values]);
			$set_media = $qr_sets ? ca_sets::getFirstItemsFromSets($set_ids = $qr_sets->getAllFieldValues('ca_sets.set_id'), ['version' => 'medium', 'checkAccess' => $this->opa_access_values]) : [];
			if ($qr_sets) { $qr_sets->seek(0); }
			
			$this->view->setVar('sets', $qr_sets);
			$this->view->setVar('set_media', $set_media);
			
			$o_context->setResultList($set_ids);
			$o_context->saveContext();
			
 			$this->render(caGetOption("view", $options, "Transcribe/index_html.php"));
 		}
 		# ------------------------------------------------------
        /**
         * Collections page – list of all available collections (ie. sets)
         */
 		function Collections($options = null) {
			$o_context = new ResultContext($this->request, 'ca_objects', 'transcribe', 'collections');	// collections context - next/prev here through collections
 			$o_context->setAsLastFind();
 			
			$qr_sets = ca_sets::find(["type_id" => "transcription_collection"], ['returnAs' => 'searchResult', 'checkAccess' => $this->opa_access_values]);
			$set_media = ca_sets::getFirstItemsFromSets($set_ids = $qr_sets->getAllFieldValues('ca_sets.set_id'), ['version' => 'medium', 'checkAccess' => $this->opa_access_values]);
			$qr_sets->seek(0);
			
			$this->view->setVar('sets', $qr_sets);
			$this->view->setVar('set_media', $set_media);
			
			$o_context->setResultList($set_ids);
			$o_context->saveContext();
						
 			$this->render(caGetOption("view", $options, "Transcribe/collections_html.php"));
 		}
 		# ------------------------------------------------------
        /**
         * Collection page – list of all items in selected collection (ie. a set)
         */
 		function Collection($options = null) {
			$o_context = new ResultContext($this->request, 'ca_objects', 'transcribe', 'collection');	// set collection-level context here for next/prev navigation at item level
 			
 			if(!($set = $this->_getSet())) {
 				throw new ApplicationException(_t('Collection is invalid'));
 			}
 			
 			$this->view->setVar('items', $items = caExtractValuesByUserLocale($set->getItems(['checkAccess' => $this->opa_access_values, 'thumbnailVersions' => ['medium', 'small']])));
 			
 			$object_ids = array_values(array_map(function($v) { return $v['object_id']; }, $items));
 			$this->view->setVar('transcriptionStatus', $transcription_status = ca_objects::getTranscriptionStatusForIDs($object_ids, $items));
 			
 			$o_context->setResultList($object_ids);
			$o_context->saveContext();
			
			$o_context = new ResultContext($this->request, 'ca_objects', 'transcribe', 'collections');	// collections context - next/prev here through collections
 			$o_context->setAsLastFind();
 			
 			$id = $set->getPrimaryKey();
 			$this->view->setVar('previousID', $previous_id = $o_context->getPreviousID($id));
 			$this->view->setVar('nextID', $next_id = $o_context->getNextID($id));
 		
 			$this->render(caGetOption("view", $options, "Transcribe/collection_html.php"));
 		}
 		# ------------------------------------------------------
        /**
         * Browse page – browse all available transcribable items
         */
 		function Browse($options = null) {
            if($this->opb_is_login_redirect) { return; }
            $this->request->setParameter('callback', null);
            unset($_REQUEST['callback']);

 			AssetLoadManager::register("mediaViewer");
 		
			$o_context = new ResultContext($this->request, 'ca_objects', 'transcribe', 'browse');
 			$o_context->setAsLastFind();

            $this->view->setVar('browse', $o_browse = caGetBrowseInstance("ca_objects"));
			$this->view->setVar("browse_type", "caTranscribe");	// this is only used when loading hierarchy facets and is a way to get around needing a browse type to pull the table in FindController		
		
			//
			// Load existing browse if key is specified
			//
			if ($ps_cache_key = $this->request->getParameter('key', pString)) {
				$o_browse->reload($ps_cache_key);
			}
			
			//
			// Clear criteria if required
			//
			
			if ($vs_remove_criterion = $this->request->getParameter('removeCriterion', pString)) {
				$o_browse->removeCriteria($vs_remove_criterion, array($this->request->getParameter('removeID', pString)));
			}
			
			if ((bool)$this->request->getParameter('clear', pInteger)) {
				// Clear all refine critera but *not* underlying _search criterion
				$va_criteria = $o_browse->getCriteria();
				foreach($va_criteria as $vs_criterion => $va_criterion_info) {
					if ($vs_criterion == '_search') { continue; }
					$o_browse->removeCriteria($vs_criterion, array_keys($va_criterion_info));
				}
			}
			
			//
			// Return filtering facets
			//
			if ($this->request->getParameter('getFacet', pInteger) && $vs_facet = $this->request->getParameter('facet', pString)) {
				$this->view->setVar('facet_name', $vs_facet);
				$this->view->setVar('key', $o_browse->getBrowseID());
				$va_facet_info = $o_browse->getInfoForFacet($vs_facet);
				$this->view->setVar('facet_info', $va_facet_info);
				
				// pull in different views based on format for facet - alphabetical, list, hierarchy
				 switch($va_facet_info["group_mode"]){
					case "alphabetical":
					case "list":
					default:
						$this->view->setVar('facet_content', $o_browse->getFacetContent($vs_facet, array("checkAccess" => $this->opa_access_values)));
						$this->render("Browse/list_facet_html.php");
						break;
					case "hierarchical":
						$this->render("Browse/hierarchy_facet_html.php");
						break;
				}
				return;
			}
			
			//
			// Add criteria and execute
			//
			$vs_search_expression = "ca_object_representations.is_transcribable:1";
			if ($vs_search_refine = $this->request->getParameter('search_refine', pString)) {
				$o_browse->removeAllCriteria();
				$o_browse->addCriteria("_search", array("{$vs_search_expression} AND {$vs_search_refine}"));
			} elseif (($o_browse->numCriteria() == 0) && $vs_search_expression) {
				$o_browse->addCriteria("_search", array($vs_search_expression));
			}
			if ($vs_facet = $this->request->getParameter('facet', pString)) {
				$o_browse->addCriteria($vs_facet, array($this->request->getParameter('id', pString)));
			}
			
			//
			// Sorting
			//
			$vb_sort_changed = false;
			if(!$ps_secondary_sort = $this->request->getParameter("secondary_sort", pString)){
 				$ps_secondary_sort = $o_context->getCurrentSecondarySort();
 			}
 			$va_config_sort = $this->config->getAssoc("sortBy");
			if(!is_array($va_config_sort)){
				$va_config_sort = array();
			}
		
 			if (!($ps_sort = urldecode($this->request->getParameter("sort", pString)))) {
 				if (!$ps_sort && !($ps_sort = $o_context->getCurrentSort())) {
 					if(is_array($va_sort_by)) {
 						$ps_sort = array_shift(array_keys($va_sort_by));
 						$vb_sort_changed = true;
 					}
 				}
 			}else{
 				$vb_sort_changed = true;
 			}
 			if($vb_sort_changed){
				// set the default sortDirection if available
				$va_sort_direction = $this->config->getAssoc("sortDirection");
				if($ps_sort_direction = $va_sort_direction[$ps_sort]){
					$o_context->setCurrentSortDirection($ps_sort_direction);
				}
 				$ps_secondary_sort = "";			
 			}
 			if (!($ps_sort_direction = $this->request->getParameter("direction", pString))) {
 				if (!($ps_sort_direction = $o_context->getCurrentSortDirection())) {
 					$ps_sort_direction = 'asc';
 				}
 			}
 			
 			$o_context->setCurrentSort($ps_sort);
 			$o_context->setCurrentSecondarySort($ps_secondary_sort);
 			$o_context->setCurrentSortDirection($ps_sort_direction);
 			
			$this->view->setVar('sortBy', is_array($va_sort_by) ? $va_sort_by : null);
			$this->view->setVar('sortBySelect', $vs_sort_by_select = (is_array($va_sort_by) ? caHTMLSelect("sort", $va_sort_by, array('id' => "sort"), array("value" => $ps_sort)) : ''));
			$this->view->setVar('sort', $ps_sort);
			$va_secondary_sort_by = $this->config->getAssoc("secondarySortBy");
			$this->view->setVar('secondarySortBy', is_array($va_secondary_sort_by) ? $va_secondary_sort_by : null);
			$this->view->setVar('secondarySortBySelect', $vs_secondary_sort_by_select = (is_array($va_secondary_sort_by) ? caHTMLSelect("secondary_sort", $va_secondary_sort_by, array('id' => "secondary_sort"), array("value" => $ps_secondary_sort)) : ''));
			$this->view->setVar('secondarySort', $ps_secondary_sort);
			$this->view->setVar('sortDirection', $ps_sort_direction);
			
			$va_browse_options = array('checkAccess' => $this->opa_access_values, 'no_cache' => true);

            $o_browse->execute(array_merge($va_browse_options, array('strictPhraseSearching' => true, 'checkAccess' => $this->opa_access_values, 'request' => $this->request)));

	
			//
			// Facets
			//
			if ($vs_facet_group = $this->config->get("setFacetGroup")) {
				$o_browse->setFacetGroup($vs_facet_group);
			}
			$va_available_facet_list = $this->config->get("availableFacets");
			$va_facets = $o_browse->getInfoForAvailableFacets(['checkAccess' => $this->opa_access_values, 'request' => $this->request,]);
			if(is_array($va_available_facet_list) && sizeof($va_available_facet_list)) {
				foreach($va_facets as $vs_facet_name => $va_facet_info) {
					if (!in_array($vs_facet_name, $va_available_facet_list)) {
						unset($va_facets[$vs_facet_name]);
					}
				}
			} 
		
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				$va_facets[$vs_facet_name]['content'] = $o_browse->getFacetContent($vs_facet_name, ['checkAccess' => $this->opa_access_values, 'request' => $this->request]);
			}
		
			$this->view->setVar('facets', $va_facets);
		
			$this->view->setVar('key', $vs_key = $o_browse->getBrowseID());
			Session::setVar('lightbox_last_browse_id', $vs_key);
			
			//
			// Current criteria
			//
			$va_criteria = $o_browse->getCriteriaWithLabels();
			
			$va_criteria_for_display = [];
			foreach($va_criteria as $vs_facet_name => $va_criterion) {
				$va_facet_info = $o_browse->getInfoForFacet($vs_facet_name);
				foreach($va_criterion as $vn_criterion_id => $vs_criterion) {
					if ($vs_facet_name == '_search') {
						$vs_criterion = trim(preg_replace("!ca_object_representations.is_transcribable:1[ ]*(AND)*!", "", $vs_criterion));
					}
					if (!$vs_criterion) { continue; }
					$va_criteria_for_display[] = array('facet' => $va_facet_info['label_singular'], 'facet_name' => $vs_facet_name, 'value' => $vs_criterion, 'id' => $vn_criterion_id);
				}
			}
			
			$this->view->setVar('criteria', $va_criteria_for_display);
			
			// 
			// Results
			//
			$vs_combined_sort = $va_sort_by[$ps_sort];
			
			if($ps_secondary_sort){
				$vs_combined_sort .= ";".$va_secondary_sort_by[$ps_secondary_sort];
			}
			
			$qr_res = $o_browse->getResults(array('sort' => $vs_combined_sort, 'sort_direction' => $ps_sort_direction));
			$this->view->setVar('result', $qr_res);
			
			$object_ids = $qr_res->getAllFieldValues('ca_objects.object_id');
			$qr_res->seek(0);
			
			$this->view->setVar('transcriptionStatus', $transcription_status = ca_objects::getTranscriptionStatusForIDs($object_ids));
 			
			
			if (!($pn_hits_per_block = $this->request->getParameter("n", pString))) {
 				if (!($pn_hits_per_block = $o_context->getItemsPerPage())) {
 					$pn_hits_per_block = ($this->config->get("defaultHitsPerBlock")) ? $this->config->get("defaultHitsPerBlock") : 36;
 				}
 			}
 			$o_context->getItemsPerPage($pn_hits_per_block);
			$this->view->setVar('hits_per_block', $pn_hits_per_block);
			$this->view->setVar('start', $vn_start = $this->request->getParameter('s', pInteger));
			
			$o_context->setParameter('key', $vs_key);
			
			if (($vn_key_start = (int)$vn_start - 1000) < 0) { $vn_key_start = 0; }
			$qr_res->seek($vn_key_start);
			$o_context->setResultList($qr_res->getPrimaryKeyValues(1000));
			$qr_res->seek($vn_start);
			
			$o_context->saveContext();
			
 			
 			$this->render(caGetOption("view", $options, "Transcribe/browse_html.php"));	
 		}
 		# ------------------------------------------------------
        /**
         * Collection page – list of all items in selected collection (ie. a set)
         */
 		function Item($options = null) {
 			AssetLoadManager::register("mediaViewer");
 			AssetLoadManager::register("ckeditor");
 			
			$o_context = new ResultContext($this->request, 'ca_objects', 'transcribe', 'collection');
 			$o_context->setAsLastFind();
 			
 			$id = $this->request->getParameter('id', pInteger);
 			$obj = new ca_objects($id);
 			
 			if (!in_array($obj->get('access'), $this->opa_access_values)) {
 				throw new ApplicationException(_t('Cannot access item'));
 			}
 			
 			if(!($rep_id = $this->request->getParameter('representation_id', pInteger))) {
 				if(is_array($reps = $obj->getRepresentations(['versions' => 'icon'], null, ['checkAccess' => $this->opa_access_values]))) { // default to first transcribeable
 					$reps = array_values(array_filter($reps, function($v) { return $v['is_transcribable']; }));
 					$rep_id = $reps[0]['representation_id'];
 				}
 			}
 			$rep = new ca_object_representations($rep_id);
 			if (!in_array($rep->get('access'), $this->opa_access_values)) {
 				throw new ApplicationException(_t('Cannot access representation'));
 			}
 			// check representation access and whether rep is linked to object
 			$rel_ids = $rep->get('ca_objects.object_id', ['returnAsArray' => true]);
 			if(!in_array($id, array_map("intval", $rel_ids), true)) { 
 				throw new ApplicationException(_t('Invalid representation'));
 			}
 			
 			$this->view->setVar('previousID', $previous_id = $o_context->getPreviousID($id));
 			$this->view->setVar('nextID', $next_id = $o_context->getNextID($id));
 			
 			
 			// Pass current set (aka "collection")
			$t_set = new ca_sets();
			$sets = $t_set->getSetsForItem($obj->tableName(), $obj->getPrimaryKey(), ['restrictToTypes' => 'transcription_collection']);
			$this->view->setVar('set', is_array($sets) ? array_shift(caExtractValuesByUserLocale($sets)) : null);
 			
 			$this->view->setVar('item', $obj);
 			$this->view->setVar('representation', $rep);
 			
 			$transcription = $rep->getTranscription();
 			$this->view->setVar('transcription', $transcription ? $transcription : new ca_representation_transcriptions());
 			
 			
 			$this->render(caGetOption("view", $options, "Transcribe/item_html.php"));
 		}
 		# ------------------------------------------------------
        /**
         * Save transcription (called from item page)
         */
 		function SaveTranscription($options = null) {
 			$transcription_id = $this->request->getParameter('transcription_id', pInteger);
 			$t_transcript = $transcription_id ? ca_representation_transcriptions::find($transcription_id, ['returnAs' => 'firstModelInstance']) : null;
 			
 			if ($t_transcript && $t_transcript->isComplete()) {
				$t_transcript->set('completed_on', null);
				$t_transcript->update();
				$this->notification->addNotification(_t("Reopend transcription for editing"), __NOTIFICATION_TYPE_INFO__);
			
 			} else {
				$id = $this->request->getParameter('id', pInteger);
				$obj = new ca_objects($id);
			
				if (!in_array($obj->get('access'), $this->opa_access_values)) {
					throw new ApplicationException(_t('Cannot access item'));
				}
			
				$rep_id = $this->request->getParameter('representation_id', pInteger);
				$rep = new ca_object_representations($rep_id);
				if (!in_array($rep->get('access'), $this->opa_access_values)) {
					throw new ApplicationException(_t('Cannot access representation'));
				}
				// Check representation access and whether rep is linked to object
				$rel_ids = $rep->get('ca_objects.object_id', ['returnAsArray' => true]);
				if(!in_array($id, array_map("intval", $rel_ids), true)) { 
					throw new ApplicationException(_t('Invalid representation'));
				}
			
				if (($transcription = trim($this->request->getParameter('transcription', pString)))) {
					if ($rep->setTranscription($transcription, $this->request->getParameter('complete', pInteger), ['user_id' => $this->request->getUserID()])) {
						$this->notification->addNotification(_t("Saved transcription"), __NOTIFICATION_TYPE_INFO__);
					}
				}
			}
 			
 			$this->Item();
 		}
 		# -------------------------------------------------------
 		/** 
 		 * Return set_id from request with fallback to user var, or if nothing there then get the users' first set
 		 */
 		private function _getSetID() {
 			$set_id = null;
 			if (!($set_id = $this->request->getActionExtra())) {			// try to get set_id from request
 				if(!$set_id = $this->request->user->getVar('current_set_id')){		// get last used set_id
 					return null;
 				}
 			}
 			return $set_id;
 		}
 		# -------------------------------------------------------
 		/**
 		 * Uses _getSetID() to figure out the ID of the current set, then returns a ca_sets object for it
 		 * and also sets the 'current_set_id' user variable
 		 */
 		private function _getSet() {
 			$t_set = new ca_sets();
 			$set_id = $this->_getSetID();
 			if($set_id){
				$t_set->load($set_id);
				if ($t_set->getPrimaryKey() && (in_array($t_set->get('ca_sets.access'), $this->opa_access_values))) {
					$this->request->user->setVar('current_set_id', $set_id);
					$this->view->setVar('set', $t_set);
					return $t_set;
				}
			}
 			return null;
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = [
 				'module_path' => '',
 				'controller' => 'TranscribeController',
 				'action' => 'Index',
 				'params' => []
 			];
			return $va_ret;
 		}
 		# -------------------------------------------------------
 	}

	/** 
	 *
	 */
	function caGetTranscriptionStatusInfo($transcription_status, $key, $id) {
		if (isset($transcription_status[$key][$id]['status'])) {
			switch($transcription_status[$key][$id]['status']) {
				case __CA_TRANSCRIPTION_STATUS_NOT_STARTED__:
				default:
					$status =  _t("Not started");
					$status_color = 'success';
					break;
				case __CA_TRANSCRIPTION_STATUS_IN_PROGRESS__:
					$status = _t("In progress");
					$status_color = 'warning';
					break;
				case __CA_TRANSCRIPTION_STATUS_COMPLETED__:
					$status = _t("Completed");
					$status_color = 'danger';
					break;
			}
		}
		
		return ['status' => $status, 'color' => $status_color];
	}