<?php
/* ----------------------------------------------------------------------
 * controllers/EducationalResourcesController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2020 Whirl-i-Gig
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
 	require_once(__CA_APP_DIR__."/controllers/DetailController.php");
 	require_once(__CA_LIB_DIR__.'/Media/MediaViewerManager.php');
 
 	class EducationalResourcesController extends DetailController {
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

           
 			caSetPageCSSClasses(array("sets", "eductionalresources"));
 			$this->config = Configuration::load("educational_resources.conf");
 			
			$this->purifier = new HTMLPurifier();
			
 			parent::setTableSpecificViewVars();
 		}
 		# ------------------------------------------------------
        /**
         * Landing page 
         */
 		function Index($options = null) {
 			AssetLoadManager::register("carousel");
 			$this->render(caGetOption("view", $options, "EducationalResources/index_html.php"));
 		}
 		# ------------------------------------------------------
        /**
         * Browse page – browse all available educational resources
         */
 		function Browse($options = null) {
            if($this->opb_is_login_redirect) { return; }
            $this->request->setParameter('callback', null);
            unset($_REQUEST['callback']);

 			AssetLoadManager::register("mediaViewer");
 		
			$o_context = new ResultContext($this->request, 'ca_occurrences', 'educationalresources');
 			$o_context->setAsLastFind();

            $this->view->setVar('browse', $o_browse = caGetBrowseInstance("ca_occurrences"));
			
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
				$va_criteria = $o_browse->getCriteria();
				foreach($va_criteria as $vs_criterion => $va_criterion_info) {
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
							
				$this->view->setVar('facet_content', $o_browse->getFacetContent($vs_facet, array("checkAccess" => $this->opa_access_values)));
				$this->render("Browse/list_facet_html.php");
					
				return;
			}
			
			//
			// Add criteria and execute
			//
			if ($vs_search_refine = $this->request->getParameter('search_refine', pString)) {
				$o_browse->removeAllCriteria();
				$o_browse->addCriteria("_search", [$vs_search_refine]);
			}
			if ($vs_facet = $this->request->getParameter('facet', pString)) {
				$o_browse->addCriteria($vs_facet, array($this->request->getParameter('id', pString)));
			}
			
 			$o_context->setCurrentSort('ca_occurrences.date_added');
 			$o_context->setCurrentSortDirection('desc');
 			
			$this->view->setVar('sort', 'ca_occurrences.date_added');
			$this->view->setVar('sortDirection', 'desc');
			
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
					if (!$vs_criterion) { continue; }
					$va_criteria_for_display[] = array('facet' => $va_facet_info['label_singular'], 'facet_name' => $vs_facet_name, 'value' => $vs_criterion, 'id' => $vn_criterion_id);
				}
			}
			
			$this->view->setVar('criteria', $va_criteria_for_display);
			
			// 
			// Results
			//
			$qr_res = $o_browse->getResults(['sort' => 'ca_occurrences.date_added', 'sort_direction' => 'desc', 'limit' => sizeof($va_criteria_for_display) ? null : 12]);
			$this->view->setVar('result', $qr_res);
			
			$object_ids = $qr_res->getAllFieldValues('ca_occurrences.occurrence_id');
			$qr_res->seek(0);
			
			
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
			
 			
 			$this->render(caGetOption("view", $options, "EducationalResources/browse_html.php"));	
 		}
 		# ------------------------------------------------------
        /**
         * Collection page – list of all items in selected collection (ie. a set)
         */
 		function Resource($options = null) {
 			AssetLoadManager::register("mediaViewer");
 			AssetLoadManager::register("ckeditor");
 			
			$o_context = new ResultContext($this->request, 'ca_occurrences', 'educationalresources');
 			
 			$id = $this->request->getParameter('id', pInteger);
 			$rep_id = $this->request->getParameter('representation_id', pInteger);
 			$occ = new ca_occurrences($id);
 			
 			if (!in_array($occ->get('access'), $this->opa_access_values)) {
 				throw new ApplicationException(_t('Cannot access resource'));
 			}
 			
 			
 			$this->view->setVar('previousID', $previous_id = $o_context->getPreviousID($id));
 			$this->view->setVar('nextID', $next_id = $o_context->getNextID($id));
 			
 			$this->view->setVar('resource', $occ);
 			$this->view->setVar('representation_id', $rep_id);
 			
 			
 			$this->render(caGetOption("view", $options, "EducationalResources/item_html.php"));
 		}
 		# -------------------------------------------------------
		/**
		 * Download all media attached to specified resource
		 */ 
		public function Download() {
			$id = $this->request->getParameter('id', pInteger);
			$rep_id = $this->request->getParameter('representation_id', pInteger);
		
			$occ = new ca_occurrences($id);
			if (!($occ_id = $occ->getPrimaryKey())) { 
				throw new ApplicationException(_t('Invalid ID'));; 
			}
			if(sizeof($this->opa_access_values) && (!in_array($occ->get("access"), $this->opa_access_values))){
  				throw new ApplicationException(_t('Cannot download'));
 			}
			
			$c = 1;
			$file_names = [];
			$file_paths = [];
			
			$t_download_log = new Downloadlog();
			
				
			$t_download_log->log(array(
					"user_id" => $this->request->getUserID() ? $this->request->getUserID() : null, 
					"ip_addr" => RequestHTTP::ip(), 
					"table_num" => $occ->tableNum(), 
					"row_id" => $id, 
					"representation_id" => null, 
					"download_source" => "pawtucket"
			));
			$va_reps = $occ->getRepresentations(['original'], null, array("checkAccess" => $this->opa_access_values));
				
			foreach($va_reps as $vn_representation_id => $va_rep) {
				if (($rep_id > 0) && ($va_rep['representation_id'] != $rep_id)) { continue; }
				$va_rep_info = $va_rep['info']['original'];
				$vs_idno_proc = preg_replace('![^A-Za-z0-9_\-]+!', '_', $vs_idno);
				
				if ($va_rep['info']['original_filename']) {
					$va_tmp = explode('.', $va_rep['info']['original_filename']);
					if (sizeof($va_tmp) > 1) { 
						if (strlen($vs_ext = array_pop($va_tmp)) < 3) {
							$va_tmp[] = $vs_ext;
						}
					}
					$vs_file_name = join('_', $va_tmp); 					
				} else {
					$vs_file_name = $vs_idno_proc.'_representation_'.$vn_representation_id.'_'.'original';
				}
				
				if (isset($va_file_names[$vs_file_name.'.'.$va_rep_info['EXTENSION']])) {
					$vs_file_name.= "_{$vn_c}";
				}
				$vs_file_name .= '.'.$va_rep_info['EXTENSION'];
				
				
				$file_names[$vs_file_name] = true;
				$this->view->setVar('version_download_name', $vs_file_name);
			
				
				$file_paths[$va_rep['paths']['original']] = $vs_file_name;
				
				$c++;
			}
			
			if (sizeof($file_paths) > 1) {
				if (!($vn_limit = ini_get('max_execution_time'))) { $vn_limit = 30; }
				set_time_limit($vn_limit * 2);
				$o_zip = new ZipStream();
				foreach($file_paths as $vs_path => $vs_name) {
					$o_zip->addFile($vs_path, $vs_name);
				}
				$this->view->setVar('zip_stream', $o_zip);
				$this->view->setVar('archive_name', preg_replace('![^A-Za-z0-9\.\-]+!', '_', $occ->get('idno')).'.zip');
				
				$vn_rc = $this->render('Details/download_file_binary.php');
				
				if ($vs_path) { unlink($vs_path); }
			} else {
				foreach($file_paths as $vs_path => $vs_name) {
					$this->view->setVar('archive_path', $vs_path);
					$this->view->setVar('archive_name', $vs_name);
				}
				$vn_rc = $this->render('Details/download_file_binary.php');
			}
			
			return $vn_rc;
		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = [
 				'module_path' => '',
 				'controller' => 'EducationalResources',
 				'action' => 'Index',
 				'params' => ['key']
 			];
			return $va_ret;
 		}
 		# -------------------------------------------------------
 	}