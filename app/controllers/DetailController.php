<?php
/* ----------------------------------------------------------------------
 * app/controllers/DetailController.php : controller for object search request handling - processes searches from top search bar
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__."/BaseSearchController.php");
require_once(__CA_LIB_DIR__."/MediaContentLocationIndexer.php");
require_once(__CA_LIB_DIR__.'/Media/MediaViewerManager.php');

require_once(__CA_LIB_DIR__.'/ApplicationPluginManager.php');
require_once(__CA_APP_DIR__."/controllers/FindController.php");
require_once(__CA_APP_DIR__."/helpers/printHelpers.php");
require_once(__CA_APP_DIR__."/helpers/exportHelpers.php");
require_once(__CA_MODELS_DIR__."/ca_objects.php");
require_once(__CA_LIB_DIR__.'/Logging/Downloadlog.php');
require_once(__CA_LIB_DIR__.'/Parsers/ZipStream.php');

class DetailController extends FindController {
	# -------------------------------------------------------
	/**
	 *
	 */
	protected $opa_detail_types = null;
	
	/**
	 *
	 */
	protected $config = null;
	
	/**
	 *
	 */
	protected $ops_view_prefix = 'Details';
	
	/**
	 * Path to temporary download scratch file
	 */
	protected $ops_tmp_download_file_path = null;
	
	# -------------------------------------------------------
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		parent::__construct($po_request, $po_response, $pa_view_paths);
		
		if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
			$this->response->setRedirect(caNavUrl("", "LoginReg", "LoginForm"));
		}

		$this->config = caGetDetailConfig();
		$this->opa_detail_types = $this->config->getAssoc('detailTypes');
		
		// expand to aliases
		foreach($this->opa_detail_types as $vs_code => $va_info) {
			if(is_array($va_aliases = caGetOption('aliases', $va_info, null))) {
				foreach($va_aliases as $vs_alias) {
					$this->opa_detail_types[$vs_alias] =& $this->opa_detail_types[$vs_code];
				}
			}
		}
		
		caSetPageCSSClasses(array("detail"));
	}
	# -------------------------------------------------------
	/**
	 *
	 */ 
	public function __call($ps_function, $pa_args) {
		AssetLoadManager::register("panel");
		AssetLoadManager::register("mediaViewer");
		AssetLoadManager::register("carousel");
		AssetLoadManager::register("readmore");
		AssetLoadManager::register("maps");
		
		
		$user_id = null;
		if($this->request->isLoggedIn()) {
			$this->view->setVar('key', GraphQLServices\GraphQLServiceController::encodeJWTRefresh(['id' => $this->request->user->getPrimaryKey()]));
			$user_id = $this->request->getUserID();
		}
		
		//
		// Media viewer
		//
		if ($this->request->getActionExtra() == 'GetMediaInline') {
			return $this->GetMediaInline();
		}
		if ($this->request->getActionExtra() == 'GetMediaOverlay') {
			return $this->GetMediaOverlay();
		}
		if ($this->request->getActionExtra() == 'GetMediaData') {
			return $this->GetMediaData();
		}
		
		//
		// Return facet content
		//	
		if(($ps_facet = $this->request->getParameter('facet', pString)) || ($ps_remove_facet = $this->request->getParameter('removeCriterion', pString))) {
			$vs_browse_type = $this->request->getParameter('browseType', pString);
			if (
				($vs_browse_table = ((isset($this->opa_detail_types[$vs_browse_type]) && isset($this->opa_detail_types[$vs_browse_type]['table']))) ? $this->opa_detail_types[$vs_browse_type]['table'] : null)
				&&
				($o_browse = caGetBrowseInstance($vs_browse_table))
			) {
				if (!($this->request->getParameter('getFacet', pInteger))) {
					if ($ps_cache_key = $this->request->getParameter('key', pString)) {
						$o_browse->reload($ps_cache_key);
					}
					
					if ($ps_facet) { 
						$o_browse->addCriteria($ps_facet, array($this->request->getParameter('id', pString))); 
					} else {
						$o_browse->removeCriteria($ps_remove_facet, array($this->request->getParameter('removeID', pString)));
					}
					$o_browse->execute();
					$ps_cache_key = $o_browse->getBrowseID();
					$this->request->setParameter('key', $ps_cache_key);
				} else {
					$o_browse = caGetBrowseInstance('ca_objects');
					if ($ps_cache_key = $this->request->getParameter('key', pString)) {
						$o_browse->reload($ps_cache_key);
					} else {
						$o_browse->addCriteria("collection_facet", $t_subject->getPrimaryKey() ); 
						$o_browse->execute();
					}
					return $this->getFacet($o_browse);
				}
			}
		}
		
		$ps_function = strtolower($ps_function);
		$ps_id = urldecode($this->request->getActionExtra()); 
	
		if (!isset($this->opa_detail_types[$ps_function]) || !isset($this->opa_detail_types[$ps_function]['table']) || (!($vs_table = $this->opa_detail_types[$ps_function]['table']))) {
			// invalid detail type – throw error
			throw new ApplicationException("Invalid detail type");
		}
		
		$t_subject = Datamodel::getInstance($vs_table, true);
		$vs_use_alt_identifier_in_urls = caUseAltIdentifierInUrls($vs_table);
		if ((($vb_use_identifiers_in_urls = caUseIdentifiersInUrls()) || ($vs_use_alt_identifier_in_urls)) && (substr($ps_id, 0, 3) == "id:")) {
			$va_tmp = explode(":", $ps_id);
			$ps_id = (int)$va_tmp[1];
			$vb_use_identifiers_in_urls = $vs_use_alt_identifier_in_urls = false;
		}

		if($vs_use_alt_identifier_in_urls && $t_subject->hasElement($vs_use_alt_identifier_in_urls)) {
			$va_load_params = [$vs_use_alt_identifier_in_urls => $ps_id];
		} elseif ($vb_use_identifiers_in_urls && $t_subject->getProperty('ID_NUMBERING_ID_FIELD')) {
			$va_load_params = [$t_subject->getProperty('ID_NUMBERING_ID_FIELD') => $ps_id];
		} else {
			$va_load_params = [$t_subject->primaryKey() => (int)$ps_id];
		}
		
		if (!($t_subject = call_user_func_array($t_subject->tableName().'::find', array($va_load_params, ['returnAs' => 'firstModelInstance'])))) {
			// invalid id - throw error
			throw new ApplicationException("Invalid id");
		} 
		
		// Increment view counter
		$t_subject->registerItemView();
		
		$va_options = (isset($this->opa_detail_types[$ps_function]['options']) && is_array($this->opa_detail_types[$ps_function]['options'])) ? $this->opa_detail_types[$ps_function]['options'] : array();
		$this->view->setVar("config_options", $va_options);
		
		if (!caGetOption('disableExport', $va_options, false)) {
			// Exportables/printables
			// 	merge displays with drop-in print templates
			//
			$va_available_export_options = caGetAvailablePrintTemplates('summary', array('table' => $t_subject->tableName())); 
			$this->view->setVar('export_formats', $va_available_export_options);
		
			$va_export_options = array();
			foreach($va_available_export_options as $vn_i => $va_format_info) {
				$va_export_options[$va_format_info['name']] = $va_format_info['code'];
			}
			// Get current display list
			$t_display = new ca_bundle_displays();
			foreach(caExtractValuesByUserLocale($t_display->getBundleDisplays(array('table' => $this->ops_tablename, 'user_id' => $this->request->getUserID(), 'access' => __CA_BUNDLE_DISPLAY_READ_ACCESS__, 'checkAccess' => caGetUserAccessValues()))) as $va_display) {
				$va_export_options[$va_display['name']] = "_display_".$va_display['display_id'];
			}
			ksort($va_export_options);
			$this->view->setVar('export_format_select', caHTMLSelect('export_format', $va_export_options, array('class' => 'searchToolsSelect'), array('value' => $this->view->getVar('current_export_format'), 'width' => '150px')));
		}
		
		#
		# Enforce access control
		#
		$user_is_submitter = ($user_id && $t_subject->hasField('submission_user_id') && $t_subject->get('submission_user_id') == $user_id);
		if(!$user_is_submitter && is_array($this->opa_access_values) && sizeof($this->opa_access_values) && ($t_subject->hasField('access')) && (!in_array($t_subject->get("access"), $this->opa_access_values))){
			$this->notification->addNotification(_t("This item is not available for view"), "message");
			$this->response->setRedirect(caNavUrl("", "", "", ""));
			return;
		}
		
		if ($this->request->config->get("{$vs_table}_dont_use_labels")) { 
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").$t_subject->getTypeName().$this->request->config->get("page_title_delimiter").(($vs_idno = $t_subject->get($t_subject->getProperty('ID_NUMBERING_ID_FIELD'))) ? "{$vs_idno}" : ""));
		} else {
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").$t_subject->getTypeName().$this->request->config->get("page_title_delimiter").$t_subject->get('preferred_labels').(($vs_idno = $t_subject->get($t_subject->getProperty('ID_NUMBERING_ID_FIELD'))) ? " [{$vs_idno}]" : ""));
		}
		$vs_type = $t_subject->getTypeCode();
		
		$this->view->setVar('detailType', $vs_table);
		$this->view->setVar('item', $t_subject);
		$this->view->setVar('itemType', $vs_type);
		
		caAddPageCSSClasses(array($vs_table, $ps_function, $vs_type));
		
		
		// Do we need to pull in the multisearch result set?
		if ((ResultContext::getLastFind($this->request, $vs_table, array('noSubtype' => true))) === 'multisearch') {
			$o_context = new ResultContext($this->request, $vs_table, 'multisearch', $ps_function);
			$o_context->setAsLastFind(false);
			$o_context->saveContext();
		} else {
			$o_context = ResultContext::getResultContextForLastFind($this->request, $vs_table);
		}
		
		$this->view->setVar('previousID', $vn_previous_id = $o_context->getPreviousID($t_subject->getPrimaryKey()));
		$this->view->setVar('nextID', $vn_next_id = $o_context->getNextID($t_subject->getPrimaryKey()));
		$this->view->setVar('previousURL', caDetailUrl($vs_table, $vn_previous_id));
		$this->view->setVar('nextURL', caDetailUrl($vs_table, $vn_next_id));
		
		$this->view->setVar('previousLink', ($vn_previous_id > 0) ? caDetailLink(caGetOption('previousLink', $va_options, _t('Previous')), '', $vs_table, $vn_previous_id) : '');
		$this->view->setVar('nextLink', ($vn_next_id > 0) ? caDetailLink(caGetOption('nextLink', $va_options, _t('Next')), '', $vs_table, $vn_next_id) : '');
		$va_params = array();
		$va_params["row_id"] = $t_subject->getPrimaryKey(); # --- used to jump to the last viewed item in the search/browse results
		$this->view->setVar('resultsLink', ResultContext::getResultsLinkForLastFind($this->request, $vs_table, caGetOption('resultsLink', $va_options, _t('Back')), null, $va_params));
		$this->view->setVar('resultsURL', ResultContext::getResultsUrlForLastFind($this->request, $vs_table, $va_params));
		
		
		//
		// Representation viewer
		//
		if (method_exists($t_subject, 'getPrimaryRepresentationInstance')) {
			if($pn_representation_id = $this->request->getParameter('representation_id', pInteger)){
				$t_representation = Datamodel::getInstance("ca_object_representations", true);
				$t_representation->load($pn_representation_id);
			}else{
				$t_representation = $t_subject->getPrimaryRepresentationInstance(array("checkAccess" => $user_is_submitter ? null : $this->opa_access_values));
			}
			if ($t_representation) {
				$this->view->setVar("t_representation", $t_representation);
				$this->view->setVar("representation_id", $t_representation->get("representation_id"));
				
				if (!($vs_viewer_name = MediaViewerManager::getViewerForMimetype("detail", $vs_mimetype = $t_representation->getMediaInfo('media', 'original', 'MIMETYPE')))) {
					throw new ApplicationException(_t('Invalid viewer %1 for %2', $vs_viewer_name, $vs_mimetype));
				}
				if(!is_array($va_media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE')))) { $va_media_display_info = []; }

				$this->view->setVar('mediaViewer', $vs_viewer_name::getViewerHTML(
					$this->request,
					"representation:".$t_representation->getPrimaryKey(),
					['context' => 'detail', 't_instance' => $t_representation, 't_subject' => $t_subject, 't_media' => $t_subject, 'display' => $va_media_display_info])
				);

			}else{
				$t_representation = Datamodel::getInstance("ca_object_representations", true);
				$this->view->setVar("representation_id", null);
			}
		
# --- PASS ALL REPS
			$va_rep_ids = $t_subject->get("ca_object_representations.representation_id", array("returnAsArray" => true, "checkAccess" => $user_is_submitter ? null : $this->opa_access_values, "filterNonPrimaryRepresentations" => false));
			$va_reps = array();
			if(is_array($va_rep_ids) && sizeof($va_rep_ids)){
				$qr_reps = ca_object_representations::createResultSet($va_rep_ids);
				if($qr_reps->numHits()){
					while($qr_reps->nextHit()) {
						$t_representation = new ca_object_representations($qr_reps->get("ca_object_representations.representation_id"));
						#$va_rep_display_info = caGetMediaDisplayInfo('detail', $qr_reps->getMediaInfo('ca_object_representations.media', 'INPUT', 'MIMETYPE'));
						#print_r($va_rep_display_info);
						#$vs_media_version = $va_rep_display_info['display_version'];
						
						if (!($vs_viewer_name = MediaViewerManager::getViewerForMimetype("detail", $vs_mimetype = $t_representation->getMediaInfo('media', 'original', 'MIMETYPE')))) {
							throw new ApplicationException(_t('Invalid viewer'));
						}
						if(!is_array($va_media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE')))) { $va_media_display_info = []; }
						
						$va_reps[$qr_reps->get("ca_object_representations.representation_id")] = $vs_viewer_name::getViewerHTML(
																																$this->request,
																																"representation:".$t_representation->getPrimaryKey(),
																																['inline' => true, 'context' => 'detail', 't_instance' => $t_representation, 't_subject' => $t_subject, 't_media' => $t_subject, 'display' => $va_media_display_info]);					


					}
				}
				$this->view->setVar("representation_tags", $va_reps);
			}
		}

		//
		// map
		//
		if (!is_array($va_map_attributes = caGetOption(['mapAttributes', 'map_attributes'], $va_options, array())) || !sizeof($va_map_attributes)) {
			if ($vs_map_attribute = caGetOption(['mapAttribute', 'map_attribute'], $va_options, false)) { $va_map_attributes = array($vs_map_attribute); }
		}
		
		$this->view->setVar("map", "");
		if(is_array($va_map_attributes) && sizeof($va_map_attributes)) {
			$o_map = new GeographicMap((($vn_width = caGetOption(['mapWidth', 'map_width'], $va_options, false)) ? $vn_width : 285), (($vn_height = caGetOption(['mapHeight', 'map_height'], $va_options, false)) ? $vn_height : 200), 'map');
				
			$vn_mapped_count = 0;	
			foreach($va_map_attributes as $vs_map_attribute) {
				if ($t_subject->get($vs_map_attribute)){
					$va_ret = $o_map->mapFrom($t_subject, $vs_map_attribute, array('contentTemplate' => caGetOption('mapContentTemplate', $va_options, false)));
					$vn_mapped_count += $va_ret['items'];
				}
			}
			
			if ($vn_mapped_count > 0) { 
				$this->view->setVar("map", $o_map->render('HTML', array('zoomLevel' => caGetOption(['mapZoomLevel', 'zoom_level'], $va_options, 12))));
			}
		}
		
		// Filtering of related items
		if (($t_subject->tableName() != 'ca_objects') && (!$this->opa_detail_types[$ps_function]['disableRelatedItemsBrowse'])) {

			$o_browse = caGetBrowseInstance('ca_objects');
			if ($ps_cache_key = $this->request->getParameter('key', pString)) {
				$o_browse->reload($ps_cache_key);
			} else {
				$o_browse->addCriteria("collection_facet", $t_subject->getPrimaryKey() );
				$ps_cache_key = $o_browse->getBrowseID();
			}
			$o_browse->execute();
			
			$this->view->setVar('key', $o_browse->getBrowseID());
			$this->view->setVar('browse', $o_browse);
			//
			// Facets
			//
			if ($vs_facet_group = caGetOption('facetGroup', $va_browse_info, null)) {
				$o_browse->setFacetGroup($vs_facet_group);
			}
		
			$o_browse->execute();
			$va_available_facet_list = caGetOption('availableFacets', $va_browse_info, null);
			$va_facets = $o_browse->getInfoForAvailableFacets();
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				if(isset($va_base_criteria[$vs_facet_name])) { continue; } // skip base criteria 
				$va_facets[$vs_facet_name]['content'] = $o_browse->getFacet($vs_facet_name, array("checkAccess" => $this->opa_access_values, 'checkAvailabilityOnly' => caGetOption('deferred_load', $va_facet_info, false, array('castTo' => 'bool'))));
			}
			$this->view->setVar('facets', $va_facets);
	
			$this->view->setVar('key', $vs_key = $o_browse->getBrowseID());
		
			Session::setVar('ca_objects_last_browse_id', $vs_key);
		
		
			// remove base criteria from display list
			if (is_array($va_base_criteria)) {
				foreach($va_base_criteria as $vs_base_facet => $vs_criteria_value) {
					unset($va_criteria[$vs_base_facet]);
				}
			}
			$va_criteria = $o_browse->getCriteriaWithLabels();
		
			$va_criteria_for_display = array();
			foreach($va_criteria as $vs_facet_name => $va_criterion) {
				$va_facet_info = $o_browse->getInfoForFacet($vs_facet_name);
				foreach($va_criterion as $vn_criterion_id => $vs_criterion) {
					$va_criteria_for_display[] = array('facet' => $va_facet_info['label_singular'], 'facet_name' => $vs_facet_name, 'value' => $vs_criterion, 'id' => $vn_criterion_id);
				}
			}
			$this->view->setVar('criteria', $va_criteria_for_display);
			
			$o_rel_context = new ResultContext($this->request, 'ca_objects', 'detailrelated', $ps_function);
			$o_rel_context->setParameter('key', $vs_key);
			$o_rel_context->setAsLastFind(false);
			
			$qr_rel_res = $o_browse->getResults();
			$o_rel_context->setResultList($qr_rel_res->getAllFieldValues('ca_objects.object_id'));
			
			$o_rel_context->saveContext();
		}
		
		//
		// comments, tags, rank
		//
		$this->view->setVar('commentsEnabled', (bool)$va_options['enableComments']);
		
		if ((bool)$va_options['enableComments']) {
			$this->view->setVar('averageRank', $t_subject->getAverageRating(true));
			$this->view->setVar('numRank', $t_subject->getNumRatings(true));
		
			#
			# User-generated comments, tags and ratings
			#
			$va_user_comments = $t_subject->getComments(null, true);
			$va_comments = array();
			if (is_array($va_user_comments)) {
				foreach($va_user_comments as $va_user_comment){
					if($va_user_comment["comment"] || $va_user_comment["media1"] || $va_user_comment["media2"] || $va_user_comment["media3"] || $va_user_comment["media4"]){
						# TODO: format date based on locale
						$va_user_comment["date"] = date("n/j/Y", $va_user_comment["created_on"]);
					
						# -- get name of commenter
						if($va_user_comment["user_id"]){
							$t_user = new ca_users($va_user_comment["user_id"]);
							$va_user_comment["author"] = $t_user->getName();
						}elseif($va_user_comment["name"]){
							$va_user_comment["author"] = $va_user_comment["name"];
						}
						$va_comments[] = $va_user_comment;
					}
				}
			}
			$this->view->setVar('comments', $va_comments);
		
		
			$va_user_tags = $t_subject->getTags(null, true);
			$va_tags = array();
		
			if (is_array($va_user_tags)) {
				foreach($va_user_tags as $va_user_tag){
					if(!in_array($va_user_tag["tag"], $va_tags)){
						$va_tags[] = $va_user_tag["tag"];
					}
				}
			}
			$this->view->setVar('tags_array', $va_tags);
			$this->view->setVar('tags', implode(", ", $va_tags));
		
			$this->view->setVar("itemComments", caDetailItemComments($t_subject->getPrimaryKey(), $t_subject, $va_comments, $va_tags));
		} else {
			$this->view->setVar("itemComments", '');
		}
		
		//
		// Set row_id for use within the view
		//
		$this->view->setVar('id', $ps_id);
		$this->view->setVar($t_subject->primaryKey(), $ps_id);

		if($this->request->isLoggedIn()) {
			//
			// Lightbox membership
			//
			$t_set = new ca_sets();
			$in_lightboxes = array_map(function ($v) {
				return [
					'isMember' => 1, 'set_id' => $v['set_id'], 'label' => $v['name']
				];
			}, caExtractValuesByUserLocale($t_set->getSetsForItem($t_subject->tableName(), $t_subject->getPrimaryKey(), ['user_id' => $this->request->getUserID(), 'checkAccess' => $this->opa_access_values, 'access' => __CA_SET_EDIT_ACCESS__])));

			$available_lightboxes = array_map(function ($v) {
				return [
					'isMember' => 0, 'set_id' => $v['set_id'], 'label' => $v['name']
				];
			}, caExtractValuesByUserLocale($t_set->getAvailableSetsForItem($t_subject->tableName(), $t_subject->getPrimaryKey(), ['user_id' => $this->request->getUserID(), 'checkAccess' => $this->opa_access_values, 'access' => __CA_SET_EDIT_ACCESS__])));

			$this->view->setVar('lightboxes', array_merge($in_lightboxes, $available_lightboxes));
		} else {
			$this->view->setVar('lightboxes', []);
		}

		//
		// share link
		//
		$this->view->setVar('shareEnabled', (bool)$va_options['enableShare']);
		
		$va_options['shareLabel'] ? $ps_label = $va_options['shareLabel'] : $ps_label = 'Share';

		$this->view->setVar("shareLink", "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl('', 'Detail', 'ShareForm', array("tablename" => $t_subject->tableName(), "item_id" => $t_subject->getPrimaryKey()))."\"); return false;'>".$ps_label."</a>");

		// find view
		//		first look for type-specific view
		$vs_path = "Details/{$vs_table}_default_html.php";		// If no type specific view use the default
		if ($subject_type_code = $t_subject->getTypeCode()) {
			if (is_array($va_type_codes = caMakeTypeList($vs_table, [$subject_type_code]))) {
				$va_type_codes = array_merge($va_type_codes, caMakeTypeList($vs_table, $t_subject->getTypeInstance()->getHierarchyAncestors($t_subject->getTypeID(), ['idsOnly' => true]), ['dontIncludeSubtypesInTypeRestriction' => true]));
				foreach(array_reverse($va_type_codes) as $vs_type_code) {   // reverse list to try more specific types first
					if ($this->viewExists("Details/{$vs_table}_{$vs_type_code}_html.php")) {
						$vs_path = "Details/{$vs_table}_{$vs_type_code}_html.php";
						break;
					}
				}
			}
		}
		
		// inquire link
		//
		$this->view->setVar('inquireEnabled', (bool)$va_options['enableInquire']);
		
		//
		// pdf link
		//
		$this->view->setVar('pdfEnabled', (bool)$va_options['enablePDF']);
		$this->view->setVar('downloadAllEnabled', (bool)$va_options['enableDownloadAll']);
		$this->view->setVar('downloadAllTypes', $va_options['downloadAllTypes']);
		
		switch($ps_view = $this->request->getParameter('view', pString)) {
			case 'pdf':
				if (!($vn_limit = ini_get('max_execution_time'))) { $vn_limit = 30; }
				set_time_limit($vn_limit * 6);
			
				caExportItemAsPDF($this->request, $t_subject, $this->request->getParameter("export_format", pString), caGenerateDownloadFileName(caGetOption('pdfExportTitle', $va_options, null), ['t_subject' => $t_subject]), ['checkAccess' => $this->opa_access_values]);
				break;
			default:
				Session::setVar($t_subject->tableName()."_last_detail_id", $t_subject->getPrimaryKey());
				caDoTemplateTagSubstitution($this->view, $t_subject, $vs_path, ['checkAccess' => $user_is_submitter ? null : $this->opa_access_values]);
				$this->render($vs_path);
				break;
		}
	}
	# -------------------------------------------------------
	/**
	 * Returns list of *timebased* (audio/video) annotations to display
	 *
	 * Expects the following request parameters: 
	 *		object_id = the id of the ca_objects record to display
	 *		representation_id = the id of the ca_object_representations record to display; the representation must belong to the specified object
	 *
	 *	Optional request parameters:
	 *		version = The version of the representation to display. If omitted the display version configured in media_display.conf is used
	 *
 		 */ 
 		public function GetTimebasedRepresentationAnnotationList() {
 			$pn_id 			= $this->request->getParameter('id', pInteger);
 			$pn_representation_id 	= $this->request->getParameter('representation_id', pInteger);
 			$ps_detail_type			= $this->request->getParameter('context', pString);
 			$va_detail_options 		= (isset($this->opa_detail_types[$ps_detail_type]['options']) && is_array($this->opa_detail_types[$ps_detail_type]['options'])) ? $this->opa_detail_types[$ps_detail_type]['options'] : array();
 			
 			if(!$pn_id) { $pn_id = 0; }
 			$t_rep = new ca_object_representations($pn_representation_id);
 			if (!$t_rep->getPrimaryKey()) { 
 				$this->postError(1100, _t('Invalid object/representation'), 'DetailController->GetTimebasedRepresentationAnnotationList');
 				return;
 			}
 			
 			if (!($vs_template = $va_detail_options['displayAnnotationTemplate'])) { $vs_template = '^ca_representation_annotations.preferred_labels.name'; }
 			
 			$va_props = $t_rep->getMediaInfo('media', 'original', 'PROPERTIES');
 			$va_annotation_list = $va_annotation_times = array();
 			if (
				is_array($va_annotations = $t_rep->getAnnotations(array('idsOnly' => true))) //$t_rep->get('ca_representation_annotations.annotation_id', array('returnAsArray' => true))) 
				&& 
				sizeof($va_annotations)
				&&
				($qr_annotations = caMakeSearchResult('ca_representation_annotations', $va_annotations))
			) {
				while($qr_annotations->nextHit()) {
					if (!preg_match('!^TimeBased!', $qr_annotations->getAnnotationType())) { continue; }
					$va_annotation_list[] = $qr_annotations->getWithTemplate($vs_template);
					$va_annotation_times[] = array((float)$qr_annotations->getPropertyValue('startTimecode', true) - (float)$va_props['timecode_offset'], (float)$qr_annotations->getPropertyValue('endTimecode', true) - (float)$va_props['timecode_offset']);
				}
				$qr_annotations->seek(0);
			}
			
			$this->view->setVar('representation_id', $pn_representation_id);
			$this->view->setVar('annotation_list', $va_annotation_list);
			$this->view->setVar('annotation_times', $va_annotation_times);
			$this->view->setVar('annotations_search_results', $qr_annotations);
			$this->view->setVar('player_name', "caMediaOverlayTimebased_{$pn_representation_id}_detail");
			
			$this->render('Details/annotations_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 * 
 		 */ 
 		public function SearchWithinMedia() {
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			$ps_q = $this->request->getParameter('q', pString);
 			
 			$va_results = MediaContentLocationIndexer::SearchWithinMedia($ps_q, 'ca_object_representations', $pn_representation_id, 'media');
 			$this->view->setVar('results', $va_results);
 			
 			$this->render('Details/object_representation_within_media_search_results_json.php');
		}
 		# -------------------------------------------------------
		/**
		 * Download all media attached to specified record (not necessarily open for editing)
		 * Includes all representation media attached to the specified object + any media attached to other
		 * objects in the same object hierarchy as the specified object. Used by the book viewer interfacce to 
		 * initiate a download.
		 *
		 * TODO: make configurable 
		 */ 
		public function DownloadMedia() {
			if (!caObjectsDisplayDownloadLink($this->request)) {
				$this->postError(1100, _t('Cannot download media'), 'DetailController->DownloadMedia');
				return;
			}
			
			if($this->request->getParameter('value_id', pInteger)) {
				return $this->DownloadAttributeMedia();
			}
			
			$o_app_plugin_manager = new ApplicationPluginManager();
			
			$table = $this->request->getParameter('table', pString);
			if (!$table || !($t_instance = Datamodel::getInstance($table, true)) || !is_a($t_instance, 'RepresentableBaseModel')) {
				$table = 'ca_objects';
				$t_instance = Datamodel::getInstance($table, true);
			}
			$ids = array_filter(preg_split('![;,\| ]+!', $this->request->getParameter('ids', pString)), 'strlen');
			$include_children = (bool)$this->request->getParameter('include_children', pInteger);
			
			// Support old object_id calls
			if (!is_array($ids) || !sizeof($ids)) {
				$ids =  [$this->request->getParameter(['object_id', 'id'], pInteger)];
			}
			$download_type = $this->request->getParameter('download_type', pString);
			
			$version = $this->request->getParameter('version', pString);
			if (!$version && !$download_type) { $version = 'original'; }
			$this->view->setVar('version', $version);
			
			$a = (is_array($this->opa_access_values) && sizeof($this->opa_access_values)) ? $this->opa_access_values : null;
			
			$qr = caMakeSearchResult($table, $ids);
			
			$ids_to_download = [];
			while($qr->nextHit()) {
				if($a && (!in_array($qr->get("{$table}.access"), $a))){
					continue;
				}
				$ids_to_download[] = $qr->getPrimaryKey();
				
				if ($include_children && is_array($child_ids = $qr->get("{$table}.children.".$t_instance->primaryKey(), ['returnAsArray' => true])) && sizeof($child_ids)) {
					$qr_children = caMakeSearchResult($table, $child_ids);
					while($qr_children->nextHit()) {
						if($a && (!in_array($qr_children->get("{$table}.access"), $a))){
							continue;
						}
						$ids_to_download[] = $qr_children->getPrimaryKey();
					}
				}
			}
			$c = 1;
			$file_names = $file_paths = [];
			
			// Allow plugins to modify object_id list
			$ids_to_download =  $o_app_plugin_manager->hookDetailDownloadMediaObjectIDs($ids_to_download);
			$ids_to_download = array_unique($ids_to_download);
			
			$t_download_log = new DownloadLog();
			
			$qr = caMakeSearchResult($table, $ids_to_download);
			while($qr->nextHit()) {
				$id = $qr->getPrimaryKey();
				$t_download_log->log([
						"user_id" => $this->request->getUserID() ? $this->request->getUserID() : null, 
						"ip_addr" => RequestHTTP::ip(), 
						"table_num" => $t_instance->tableNum(), 
						"row_id" => $id, 
						"representation_id" => null, 
						"download_source" => "pawtucket"
				]);
				$idno = $qr->get("{$table}.idno");
				if (!($idno_proc = preg_replace('![^A-Za-z0-9_\-]+!', '_', $idno))) {
					$idno_proc = $id;
				}

				$rep_ids = $qr->get("ca_object_representations.representation_id", array("filterNonPrimaryRepresentations" => false, "returnAsArray" => true, "checkAccess" => $a));
				
				if(is_array($rep_ids) && sizeof($rep_ids)){
					$qr_reps = caMakeSearchResult('ca_object_representations', $rep_ids);
					while($qr_reps->nextHit()) {
						$rep_id = $qr_reps->getPrimaryKey();
						
						if(!$version){
							# --- look up the version for each rep using the download_type - the download type maps to an array in media_display.conf
							$rep_display_info = caGetMediaDisplayInfo($download_type, $qr_reps->getMediaInfo('ca_object_representations.media', 'INPUT', 'MIMETYPE'));
							$media_version = $rep_display_info['download_version'];
						}else{
							$media_version = $version;
						}
						$info = $qr_reps->getMediaInfo('ca_object_representations.media');
						$rep_info = $qr_reps->getMediaInfo('ca_object_representations.media', $media_version);
				
						$vals = ['idno' => $idno_proc];
						foreach(array_merge($rep_info ?? [], $info ?? []) as $k => $v) {
							if (is_array($v)) { continue; }
							if (strtolower($k) == 'original_filename') { $v = pathinfo($v, PATHINFO_FILENAME); }
							$vals[strtolower($k)] = preg_replace('![^A-Za-z0-9_\-]+!', '_', $v);
						}
						
						$mode = $this->request->getAppConfig()->get('downloaded_file_naming');
						
						$filename = preg_replace('![^A-Za-z0-9_\-]+!', '_', preg_replace('!\.[A-Za-z].[A-Za-z0-9]{1,3}$!', '', caProcessTemplateForIDs($mode, 'ca_object_representations', [$rep_id]))).'.'.$rep_info['EXTENSION'];
							
						$file_names[$filename] = true;
			
						//
						// Perform metadata embedding
						if (!($path = $this->ops_tmp_download_file_path = caEmbedMediaMetadataIntoFile($qr->getMediaPath('media', $media_version), $table, $id, $qr->get("{$table}.type_id", ['convertCodesToIdnos' => true]), $rep_id, $qr_reps->get('ca_object_representations.type_id', ['convertCodesToIdnos' => true])))) {
							$path = $qr_reps->getMediaPath('ca_object_representations.media', $media_version);
						}
						if(!$path) { 
							if(!($path = $qr_reps->getMediaPath('ca_object_representations.media', 'full'))) {
								$path = $qr_reps->getMediaPath('ca_object_representations.media', 'large');
							}
						}
						$file_paths[$path] = $filename;
				
						$c++;
						
					}
				}
				
			}
			// Allow plugins to modify file path list
			$file_paths = $o_app_plugin_manager->hookDetailDownloadMediaFilePaths($file_paths);
			
			if (sizeof($file_paths) > 1) {
				$idnos = $t_instance->getFieldValuesForIDs($ids_to_download, ['idno']);
				// Generate ZIP for multiple files
				if (!($limit = ini_get('max_execution_time'))) { $limit = 30; }
				set_time_limit($limit * 4);
				
				$o_zip = new ZipStream();
				foreach($file_paths as $path => $name) {
					$o_zip->addFile($path, $name);	
				}
				
				$this->view->setVar('zip_stream', $o_zip);
				$tmp = preg_replace('![^A-Za-z0-9\.\-]+!', '_', substr(join('_', array_slice(array_keys($idnos), 0, 10)), 0, 30));
				$this->view->setVar('archive_name', $z=($tmp ? $tmp : 'MediaDownload').'.zip');
				
				$rc = $this->render('bundles/download_file_binary.php');
				if ($path) { unlink($path); }
			} elseif(sizeof($file_paths) === 1) {
				// Single file
				foreach($file_paths as $path => $name) {
					$this->view->setVar('archive_path', $path);
					$this->view->setVar('archive_name', $name);
					break;
				}
				$rc = $this->render('bundles/download_file_binary.php');
			} else {
				throw new ApplicationException(_t('No files to download'));
			}
			return $rc;
		}
 		# -------------------------------------------------------
 		# Tagging and commenting
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function SaveCommentTaggingJS() {
 			caValidateCSRFToken($this->request);
 			$o_purifier = new HTMLPurifier();
 			$vb_errors = false;
 			$field_errors = [];
 			if(!$t_item = Datamodel::getInstance($this->request->getParameter("tablename", pString), true)) {
 				throw new ApplicationException("Invalid table name ".$this->request->getParameter("tablename", pString)." for saving comment");
 			}
			$ps_table = $this->request->getParameter("tablename", pString);
			if(!($vn_item_id = $this->request->getParameter("item_id", pInteger))){
 				$this->view->setVar('data', [
					'status' => 'err', 'error' => _t("Invalid ID")
				]);
				$vb_errors = true;
 			}
 			if(!$t_item->load($vn_item_id)){
  				$this->view->setVar('data', [
					'status' => 'err', 'error' => _t("ID does not exist")
				]);
				$vb_errors = true;
 			}
			if(!$vb_errors){
				# --- get params from form
				$ps_comment = $this->request->getParameter('comment', pString);
				$pn_rank = $this->request->getParameter('rank', pInteger);
				$ps_tags = $this->request->getParameter('tags', pString);
				$ps_email = $this->request->getParameter('email', pString);
				$ps_name = $this->request->getParameter('name', pString);
				$ps_location = $this->request->getParameter('location', pString);
				$ps_media1 = $_FILES['media1']['tmp_name'];
				$ps_media1_original_name = $_FILES['media1']['name'];
				$vs_error = "";
			
				if(!$this->request->getUserID() && !$ps_name && !$ps_email){
					$vs_error = _t("Please enter your name and email");
					$vb_errors = true;
				}
				if(!$ps_comment && !$pn_rank && !$ps_tags && !$ps_media1){
					$vs_error = _t("Please enter your contribution");
					if(!$ps_comment){
						$field_errors["comment"] = _t("Please enter your comment");
					}
					$vb_errors = true;
				}
				if($vb_errors){
					$this->view->setVar('data', [
						'status' => 'err', 'error' => $vs_error, 'fieldErrors' => $field_errors
					]);
#					$this->view->setVar("form_comment", $ps_comment);
#					$this->view->setVar("form_rank", $pn_rank);
#					$this->view->setVar("form_tags", $ps_tags);
#					$this->view->setVar("form_email", $ps_email);
#					$this->view->setVar("form_name", $ps_name);
#					$this->view->setVar("form_location", $ps_location);
#					$this->view->setVar("item_id", $vn_item_id);
#					$this->view->setVar("tablename", $ps_table);
#					if($vn_inline_form){
#						$this->notification->addNotification($va_errors["general"], __NOTIFICATION_TYPE_ERROR__);
#						$this->request->setActionExtra($vn_item_id);
#						$this->__call(caGetDetailForType($ps_table), null);
						#$this->response->setRedirect(caDetailUrl($ps_table, $vn_item_id));
#					}else{
#						$this->view->setVar("errors", $va_errors);
#						$this->render('Details/form_comments_html.php');
#					}
				}else{
					# --- if there is already a rank set from this user/IP don't let another
					$t_item_comment = new ca_item_comments();
					$vs_dup_rank_message = "";
					$vb_dup_rank = false;
					if($this->request->getUserID() && $t_item_comment->load(array("row_id" => $vn_item_id, "user_id" => $this->request->getUserID()))){
						if($t_item_comment->get("comment_id")){
							$pn_rank = null;
							$vb_dup_rank = true;
						}
					}
					if($t_item_comment->load(array("row_id" => $vn_item_id, "ip_addr" => $_SERVER['REMOTE_ADDR']))){
						$pn_rank = null;
						$vb_dup_rank = true;
					}
					if($vb_dup_rank && $pn_rank){
						$vs_dup_rank_message = " "._t("You can only rate an item once.");
					}
					if(!(($pn_rank > 0) && ($pn_rank <= 5))){
						$pn_rank = null;
					}
					if($ps_comment || $pn_rank || $ps_media1){
						$t_item->addComment($ps_comment, $pn_rank, $this->request->getUserID(), null, $ps_name, $ps_email, ((in_array($ps_table, array("ca_sets", "ca_set_items"))) || $this->request->config->get("dont_moderate_comments")) ? 1:0, null, array('media1_original_filename' => $ps_media1_original_name), $ps_media1, null, null, null, $ps_location);
					}
					if($ps_tags){
						$va_tags = array();
						$va_tags = explode(",", $ps_tags);
						foreach($va_tags as $vs_tag){
							$t_item->addTag(trim($vs_tag), $this->request->getUserID(), null, ((in_array($ps_table, array("ca_sets", "ca_set_items"))) || $this->request->config->get("dont_moderate_comments")) ? 1:0, null);
						}
					}
					if($ps_comment || $ps_tags || $ps_media1){
						# --- set/lightbox comments should be emailed to everyone with access to the set
						if(in_array($ps_table, array("ca_sets", "ca_set_items"))){
							$va_set_users = $t_item->getSetUsers();
							$va_emails = array();
							# --- gather array of users to send comment notification to
							foreach($va_set_users as $va_set_user){
								if($this->request->getUserID() != $va_set_user["user_id"]){
									$va_emails[$va_set_user["email"]] = $va_set_user["name"];
								}
							}
							if(sizeof($va_emails) > 0){
								# --- send email to other users with access to set
								$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
								$o_view->setVar("comment", $ps_comment);
								$o_view->setVar("tags", $ps_tags);
								$o_view->setVar("name", $ps_name);
								$o_view->setVar("email", $ps_email);
								$o_view->setVar("item", $t_item);
					
								# -- generate email subject line from template
								$vs_subject_line = $o_view->render("mailTemplates/set_comment_notification_subject.tpl");
						
								# -- generate mail text from template - get both the text and the html versions
								$vs_mail_message_text = $o_view->render("mailTemplates/set_comment_notification.tpl");
								$vs_mail_message_html = $o_view->render("mailTemplates/set_comment_notification_html.tpl");
					
								caSendmail($va_emails, $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
								
							}
						}else{
							# --- check if email notification should be sent to admin - don't send for set/ligthbox comments
							if(!$this->request->config->get("dont_email_notification_for_new_comments")){
								# --- send email confirmation
								$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
								$o_view->setVar("comment", $ps_comment);
								$o_view->setVar("tags", $ps_tags);
								$o_view->setVar("name", $ps_name);
								$o_view->setVar("email", $ps_email);
								$o_view->setVar("item", $t_item);
					
								# -- generate email subject line from template
								$vs_subject_line = $o_view->render("mailTemplates/admin_comment_notification_subject.tpl");
						
								# -- generate mail text from template - get both the text and the html versions
								$vs_mail_message_text = $o_view->render("mailTemplates/admin_comment_notification.tpl");
								$vs_mail_message_html = $o_view->render("mailTemplates/admin_comment_notification_html.tpl");
					
								caSendmail($this->request->config->get("ca_admin_email"), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
							}
						}
						if(($ps_table == "ca_sets") || $this->request->config->get("dont_moderate_comments")){
							$this->view->setVar('data', [
								'status' => 'ok', 'message' => _t("Thank you for contributing.").$vs_dup_rank_message
							]);
						}else{
							$this->view->setVar('data', [
								'status' => 'ok', 'message' => _t("Thank you for contributing.  Your comments will be posted on this page after review by site staff.").$vs_dup_rank_message
							]);
						}
					}else{
						$this->view->setVar('data', [
							'status' => 'ok', 'message' => _t("Thank you for your contribution.").$vs_dup_rank_message
						]);
					}
				}
			}
			
			$this->render('Details/comments_data_json.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function getCommentsTagsJS() {
 			$vb_errors = false;
 			if(!$t_subject = Datamodel::getInstance($this->request->getParameter("tablename", pString), true)) {
 				throw new ApplicationException("Invalid table name ".$this->request->getParameter("tablename", pString)." for getting comment and tags");
 			}
			$ps_table = $this->request->getParameter("tablename", pString);
			if(!($vn_item_id = $this->request->getParameter("item_id", pInteger))){
 				$this->view->setVar('data', [
					'status' => 'err', 'error' => _t("Invalid ID")
				]);
				$vb_errors = true;
 			}
 			if(!$t_subject->load($vn_item_id)){
  				$this->view->setVar('data', [
					'status' => 'err', 'error' => _t("ID does not exist")
				]);
				$vb_errors = true;
 			}
			#
			# User-generated comments, tags and ratings
			#
			$va_user_comments = $t_subject->getComments(null, true);
			$va_comments = array();
			if (is_array($va_user_comments)) {
				$va_user_comments = array_reverse($va_user_comments);
				foreach($va_user_comments as $va_user_comment){
					if($va_user_comment["comment"] || $va_user_comment["media1"] || $va_user_comment["media2"] || $va_user_comment["media3"] || $va_user_comment["media4"]){
						$va_user_comment["date"] = date("n/j/Y", $va_user_comment["created_on"]);
					
						# -- get name of commenter
						if($va_user_comment["user_id"]){
							$t_user = new ca_users($va_user_comment["user_id"]);
							$va_user_comment["author"] = $t_user->getName();
							$va_user_comment["fname"] = $t_user->get("fname");
							$va_user_comment["lname"] = $t_user->get("lname");
							$va_user_comment["email"] = $t_user->get("lname");
						}elseif($va_user_comment["name"]){
							$va_user_comment["author"] = $va_user_comment["name"];
						}
						$va_comments[] = $va_user_comment;
					}
				}
			}
		
		
			$va_user_tags = $t_subject->getTags(null, true);
			$va_tags = array();
		
			if (is_array($va_user_tags)) {
				foreach($va_user_tags as $va_user_tag){
					if(!in_array($va_user_tag["tag"], $va_tags)){
						$va_tags[] = $va_user_tag["tag"];
					}
				}
			}
			$this->view->setVar('data', [
				'status' => 'ok', 'comments' => $va_comments, 'tags' => $va_tags, 'tagsText' =>implode(", ", $va_tags)
			]);
			
			$this->render('Details/comments_data_json.php');
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function SaveCommentTagging() {
 			# --- inline is passed to indicate form appears embedded in detail page, not in overlay
			$vn_inline_form = $this->request->getParameter("inline", pInteger);
			if(!$t_item = Datamodel::getInstance($this->request->getParameter("tablename", pString), true)) {
 				throw new ApplicationException("Invalid table name ".$this->request->getParameter("tablename", pString)." for saving comment");
 			}
			$ps_table = $this->request->getParameter("tablename", pString);
			if(!($vn_item_id = $this->request->getParameter("item_id", pInteger))){
 				if($vn_inline_form){
 					$this->notification->addNotification(_t("Invalid ID"), __NOTIFICATION_TYPE_ERROR__);
 					$this->response->setRedirect(caDetailUrl($ps_table, $vn_item_id));
 				}else{
 					$this->view->setVar("message", _t("Invalid ID"));
 					$this->render("Form/reload_html.php");
 				}
 				return;
 			}
 			if(!$t_item->load($vn_item_id)){
  				if($vn_inline_form){
 					$this->notification->addNotification(_t("ID does not exist"), __NOTIFICATION_TYPE_ERROR__);
 					$this->response->setRedirect(caDetailUrl($ps_table, $vn_item_id));
 				}else{
 					$this->view->setVar("message", _t("ID does not exist"));
 					$this->render("Form/reload_html.php");
 				}
 				return;
 			}
 			
 			# --- get params from form
 			$ps_comment = $this->request->getParameter('comment', pString);
 			$pn_rank = $this->request->getParameter('rank', pInteger);
 			$ps_tags = $this->request->getParameter('tags', pString);
 			$ps_email = $this->request->getParameter('email', pString);
 			$ps_name = $this->request->getParameter('name', pString);
 			$ps_location = $this->request->getParameter('location', pString);
 			$ps_media1 = $_FILES['media1']['tmp_name'];
 			$ps_media1_original_name = $_FILES['media1']['name'];
 			$va_errors = array();
 			
 			if(!$this->request->getUserID() && !$ps_name && !$ps_email){
				$va_errors["general"] = _t("Please enter your name and email");
			}
			if(!$ps_comment && !$pn_rank && !$ps_tags && !$ps_media1){
				$va_errors["general"] = _t("Please enter your contribution");
			}
			if(sizeof($va_errors)){
				$this->view->setVar("form_comment", $ps_comment);
				$this->view->setVar("form_rank", $pn_rank);
				$this->view->setVar("form_tags", $ps_tags);
				$this->view->setVar("form_email", $ps_email);
				$this->view->setVar("form_name", $ps_name);
				$this->view->setVar("form_location", $ps_location);
				$this->view->setVar("item_id", $vn_item_id);
 				$this->view->setVar("tablename", $ps_table);
				if($vn_inline_form){
					$this->notification->addNotification($va_errors["general"], __NOTIFICATION_TYPE_ERROR__);
					$this->request->setActionExtra($vn_item_id);
					$this->__call(caGetDetailForType($ps_table), null);
					#$this->response->setRedirect(caDetailUrl($ps_table, $vn_item_id));
				}else{
					$this->view->setVar("errors", $va_errors);
					$this->render('Details/form_comments_html.php');
				}
			}else{
				# --- if there is already a rank set from this user/IP don't let another
				$t_item_comment = new ca_item_comments();
				$vs_dup_rank_message = "";
				$vb_dup_rank = false;
				if($this->request->getUserID() && $t_item_comment->load(array("row_id" => $vn_item_id, "user_id" => $this->request->getUserID()))){
					if($t_item_comment->get("comment_id")){
						$pn_rank = null;
						$vb_dup_rank = true;
					}
				}
				if($t_item_comment->load(array("row_id" => $vn_item_id, "ip_addr" => $_SERVER['REMOTE_ADDR']))){
					$pn_rank = null;
					$vb_dup_rank = true;
				}
				if($vb_dup_rank){
					$vs_dup_rank_message = " "._t("You can only rate an item once.");
				}
 				if(!(($pn_rank > 0) && ($pn_rank <= 5))){
 					$pn_rank = null;
 				}
 				if($ps_comment || $pn_rank || $ps_media1){
 					$t_item->addComment($ps_comment, $pn_rank, $this->request->getUserID(), null, $ps_name, $ps_email, ($this->request->config->get("dont_moderate_comments")) ? 1:0, null, array('media1_original_filename' => $ps_media1_original_name), $ps_media1, null, null, null, $ps_location);
 				}
 				if($ps_tags){
 					$va_tags = array();
 					$va_tags = explode(",", $ps_tags);
 					foreach($va_tags as $vs_tag){
 						$t_item->addTag(trim($vs_tag), $this->request->getUserID(), null, ($this->request->config->get("dont_moderate_comments")) ? 1:0, null);
 					}
 				}
 				if($ps_comment || $ps_tags || $ps_media1){
 					# --- check if email notification should be sent to admin
					if(!$this->request->config->get("dont_email_notification_for_new_comments")){
						# --- send email confirmation
						$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
 						$o_view->setVar("comment", $ps_comment);
 						$o_view->setVar("tags", $ps_tags);
 						$o_view->setVar("name", $ps_name);
 						$o_view->setVar("email", $ps_email);
 						$o_view->setVar("item", $t_item);
 					
 					
 						# -- generate email subject line from template
						$vs_subject_line = $o_view->render("mailTemplates/admin_comment_notification_subject.tpl");
						
						# -- generate mail text from template - get both the text and the html versions
						$vs_mail_message_text = $o_view->render("mailTemplates/admin_comment_notification.tpl");
						$vs_mail_message_html = $o_view->render("mailTemplates/admin_comment_notification_html.tpl");
					
						caSendmail($this->request->config->get("ca_admin_email"), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
					}
 					if($this->request->config->get("dont_moderate_comments")){
 						if($vn_inline_form){
							$this->notification->addNotification(_t("Thank you for contributing.").$vs_dup_rank_message, __NOTIFICATION_TYPE_INFO__);
 							$this->response->setRedirect(caDetailUrl($ps_table, $vn_item_id));
							return;
						}else{
							$this->view->setVar("message", _t("Thank you for contributing.").$vs_dup_rank_message);
 							$this->render("Form/reload_html.php");
						}
 					}else{
 						if($vn_inline_form){
							$this->notification->addNotification(_t("Thank you for contributing.  Your comments will be posted on this page after review by site staff.").$vs_dup_rank_message, __NOTIFICATION_TYPE_INFO__);
 							$this->response->setRedirect(caDetailUrl($ps_table, $vn_item_id));
							return;
						}else{
							$this->view->setVar("message", _t("Thank you for contributing.  Your comments will be posted on this page after review by site staff.").$vs_dup_rank_message);
 							$this->render("Form/reload_html.php");
						}
 					}
 				}else{
 					if($vn_inline_form){
						$this->notification->addNotification(_t("Thank you for your contribution.").$vs_dup_rank_message, __NOTIFICATION_TYPE_INFO__);
 						$this->response->setRedirect(caDetailUrl($ps_table, $vn_item_id));
						return;
					}else{
						$this->view->setVar("message", _t("Thank you for your contribution.").$vs_dup_rank_message);
 						$this->render("Form/reload_html.php");
					}
 				}
 			}
 		}
 		# -------------------------------------------------------
 		# share - email item
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function ShareForm() {
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
			if(!$t_item = Datamodel::getInstance($ps_tablename, true)) {
 				throw new ApplicationException("Invalid table name ".$ps_tablename." for detail");		// shouldn't happen
 			}
			if(!$t_item->load($pn_item_id)){
  				throw new ApplicationException("ID does not exist");		// shouldn't happen
 			}
 			
 			$this->view->setVar('t_item', $t_item);
 			$this->view->setVar('item_id', $pn_item_id);
 			$this->view->setVar('tablename', $ps_tablename);
 			$this->render("Details/form_share_html.php");
 		}
 		# ------------------------------------------------------
 		/**
 		 *
 		 */
 		public function SendShare() {
 			$va_errors = array();
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
			if(!$t_item = Datamodel::getInstance($ps_tablename, true)) {
 				throw new ApplicationException("Invalid table name ".$ps_tablename." for detail");		// shouldn't happen
 			}
			if(!$t_item->load($pn_item_id)){
  				$this->view->setVar("message", _t("ID does not exist"));
 				$this->render("Form/reload_html.php");
 				return;
 			}
 			$o_purifier = new HTMLPurifier();
    		$ps_to_email = $o_purifier->purify($this->request->getParameter('to_email', pString));
 			$ps_from_email = $o_purifier->purify($this->request->getParameter('from_email', pString));
 			$ps_from_name = $o_purifier->purify($this->request->getParameter('from_name', pString));
 			$ps_subject = $o_purifier->purify($this->request->getParameter('subject', pString));
 			$ps_message = $o_purifier->purify($this->request->getParameter('message', pString));
 			$pn_security = $this->request->getParameter('security', pInteger);
 			$pn_sum = $this->request->getParameter('sum', pInteger);
			
			# --- check vars are set and email addresses are valid
			$va_to_email = array();
			$va_to_email_process = array();
			if(!$ps_to_email){
				$va_errors["to_email"] = _t("Please enter a valid email address or multiple addresses separated by commas");
			}else{
				# --- explode on commas to support multiple addresses - then check each one
				$va_to_email_process = explode(",", $ps_to_email);
				foreach($va_to_email_process as $vs_email_to_verify){
					$vs_email_to_verify = trim($vs_email_to_verify);
					if(caCheckEmailAddress($vs_email_to_verify)){
						$va_to_email[$vs_email_to_verify] = "";
					}else{
						$ps_to_email = "";
						$va_errors["to_email"] = _t("Please enter a valid email address or multiple addresses separated by commas");
					}
				}
			}
			if(!$ps_from_email || !caCheckEmailAddress($ps_from_email)){
				$ps_from_email = "";
				$va_errors["from_email"] = _t("Please enter a valid email address");
			}
			if(!$ps_from_name){
				$va_errors["from_name"] = _t("Please enter your name");
			}
			if(!$ps_subject){
				$va_errors["subject"] = _t("Please enter a subject");
			}
			if(!$ps_message){
				$va_errors["message"] = _t("Please enter a message");
			}
			if(!$this->request->isLoggedIn()){
				# --- check for security answer if not logged in
				if ((!$pn_security)) {
					$va_errors["security"] = _t("Please answer the security question.");
				}else{
					if($pn_security != $pn_sum){
						$va_errors["security"] = _t("Your answer was incorrect, please try again");
					}
				}
			}
 			
 			$this->view->setVar('t_item', $t_item);
 			$this->view->setVar('item_id', $pn_item_id);
 			$this->view->setVar('tablename', $ps_tablename);

 			if(sizeof($va_errors) == 0){
				$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
				$o_view->setVar("item", $t_item);
				$o_view->setVar("item_id", $pn_item_id);
				$o_view->setVar("from_name", $ps_from_name);
				$o_view->setVar("message", $ps_message);
				$o_view->setVar("detailConfig", $this->config);
				# -- generate mail text from template - get both html and text versions
				if($ps_tablename == "ca_objects"){
					$vs_mail_message_text = $o_view->render("mailTemplates/share_object_email_text.tpl");
				}else{
					$vs_mail_message_text = $o_view->render("mailTemplates/share_email_text.tpl");
				}
				if($ps_tablename == "ca_objects"){
					$vs_mail_message_html = $o_view->render("mailTemplates/share_object_email_html.tpl");
				}else{
					$vs_mail_message_html = $o_view->render("mailTemplates/share_email_html.tpl");
				}
				
				$va_media = null;
				if($ps_tablename == "ca_objects"){
					# --- get media for attachment
					$vs_media_version = "";
					# Media representation to email
					# --- version is set in media_display.conf.
					if (method_exists($t_item, 'getPrimaryRepresentationInstance')) {
						if ($t_primary_rep = $t_item->getPrimaryRepresentationInstance()) {
							if (!sizeof($this->opa_access_values) || in_array($t_primary_rep->get('access'), $this->opa_access_values)) { 		// check rep access
								$va_media = array();
								$va_rep_display_info = caGetMediaDisplayInfo('email', $t_primary_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
								
								$vs_media_version = $va_rep_display_info['display_version'];
								
								$va_media['path'] = $t_primary_rep->getMediaPath('media', $vs_media_version);
								$va_media_info = $t_primary_rep->getFileInfo('media', $vs_media_version);
								if(!$va_media['name'] = $va_media_info['ORIGINAL_FILENAME']){
									$va_media['name'] = $va_media_info[$vs_media_version]['FILENAME'];
								}
								# --- this is the mimetype of the version being downloaded
								$va_media["mimetype"] = $va_media_info[$vs_media_version]['MIMETYPE'];
							}
						}
					}		
				}
				if(caSendmail($va_to_email, array($ps_from_email => $ps_from_name), $ps_subject, $vs_mail_message_text, $vs_mail_message_html, null, null, $va_media)){
 					$this->view->setVar("message", _t("Your email was sent"));
					$this->render("Form/reload_html.php");
					return;
 				}else{
 					$va_errors["general"] = _t("Your email could not be sent");
 				}
 			}
 			if(sizeof($va_errors)){
 				# --- there were errors in the form data, so reload form with errors displayed - pass params to preload form
 				$this->view->setVar('to_email', $ps_to_email);
 				$this->view->setVar('from_email', $ps_from_email);
 				$this->view->setVar('from_name', $ps_from_name);
 				$this->view->setVar('subject', $ps_subject);
 				$this->view->setVar('message', $ps_message);
 				$this->view->setVar('errors', $va_errors);
 				
 				$va_errors["general"] = _t("There were errors in your form");
 				$this->ShareForm(); 			
 			}else{
 				$this->view->setVar("message", _t("Your message was sent"));
 				$this->render("Form/reload_html.php");
 				return;
 			}
 		}
		# -------------------------------------------------------
 		# File attribute bundle download
 		# -------------------------------------------------------
 		/**
 		 * Initiates user download of file stored in a file attribute, returning file in response to request.
 		 * Adds download output to response directly. No view is used.
 		 *
 		 * @param array $pa_options Array of options passed through to _initView 
 		 */
 		public function DownloadAttributeFile($pa_options=null) {
 			if (!($pn_value_id = $this->request->getParameter('value_id', pInteger))) { return; }
 			$t_attr_val = new ca_attribute_values($pn_value_id);
 			if (!$t_attr_val->getPrimaryKey()) { return; }
 			$t_attr = new ca_attributes($t_attr_val->get('attribute_id'));
 		
 			$vn_table_num = Datamodel::getTableNum($this->ops_table_name);
 			if ($t_attr->get('table_num') !=  $vn_table_num) { 
 				$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2580?r='.urlencode($this->request->getFullUrlPath()));
 				return;
 			}
 			$t_element = new ca_metadata_elements($t_attr->get('element_id'));
 			$this->request->setParameter(Datamodel::primaryKey($vn_table_num), $t_attr->get('row_id'));
 			
 			list($vn_subject_id, $t_subject) = $this->_initView($pa_options);
 			$ps_version = $this->request->getParameter('version', pString);
 			
 			
 			//if (!$this->_checkAccess($t_subject)) { return false; }
 			
 			//
 			// Does user have access to bundle?
 			//
 			if (($this->request->user->getBundleAccessLevel($this->ops_table_name, $t_element->get('element_code'))) < __CA_BUNDLE_ACCESS_READONLY__) {
 				$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2580?r='.urlencode($this->request->getFullUrlPath()));
 				return;
 			}
 			
 			$t_attr_val->useBlobAsFileField(true);
 			
 			$o_view = new View($this->request, $this->request->getViewsDirectoryPath().'/bundles/');
 			
 			// get value
 			$t_element = new ca_metadata_elements($t_attr_val->get('element_id'));
 			// check that value is a file attribute
 			if ($t_element->get('datatype') != 15) { 	// 15=file
 				return;
 			} 
 			$o_view->setVar('archive_path', $t_attr_val->getFilePath('value_blob'));
 			$o_view->setVar('archive_name', ($vs_name = trim($t_attr_val->get('value_longtext2'))) ? $vs_name : _t("downloaded_file"));
 			
 			// send download
 			$this->response->addContent($o_view->render('download_file_binary.php'));
 		}
 		# -------------------------------------------------------
 		# Media attribute bundle download
 		# -------------------------------------------------------
 		/**
 		 * Initiates user download of media stored in a media attribute, returning file in response to request.
 		 * Adds download output to response directly. No view is used.
 		 *
 		 * @param array $pa_options Array of options passed through to _initView 
 		 */
 		public function DownloadAttributeMedia($pa_options=null) {
 			if (!($pn_value_id = $this->request->getParameter('value_id', pInteger))) { return; }
 			$t_attr_val = new ca_attribute_values($pn_value_id);
 			if (!$t_attr_val->getPrimaryKey()) { return; }
 			$t_attr = new ca_attributes($t_attr_val->get('attribute_id'));
 		
 			$t_element = new ca_metadata_elements($t_attr->get('element_id'));
 			$this->request->setParameter(Datamodel::primaryKey($vn_table_num), $t_attr->get('row_id'));
 			
 			$vn_subject_id = $this->request->getParameter("subject_id", pInteger);
 			//list($vn_subject_id, $t_subject) = $this->_initView($pa_options);
 			$ps_version = $this->request->getParameter('version', pString);
 			
 			
 			//if (!$this->_checkAccess($t_subject)) { return false; }
 			
 			
 			//
 			// Does user have access to bundle?
 			//
 			if (($this->request->user->getBundleAccessLevel($this->ops_table_name, $t_element->get('element_code'))) < __CA_BUNDLE_ACCESS_READONLY__) {
 				$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2580?r='.urlencode($this->request->getFullUrlPath()));
 				return;
 			}
 			
 			$t_attr_val->useBlobAsMediaField(true);
 			if (!in_array($ps_version, $t_attr_val->getMediaVersions('value_blob'))) { $ps_version = 'original'; }
 			
 			$o_view = new View($this->request, $this->request->getViewsDirectoryPath().'/bundles/');
 			
 			// get value
 			$t_element = new ca_metadata_elements($t_attr_val->get('element_id'));
 			
 			// check that value is a media attribute
 			if ($t_element->get('datatype') != 16) { 	// 16=media
 				return;
 			}
 			
 			$vs_path = $t_attr_val->getMediaPath('value_blob', $ps_version);
 			$vs_path_ext = pathinfo($vs_path, PATHINFO_EXTENSION);
 			if ($vs_name = trim($t_attr_val->get('value_longtext2'))) {
 				$vs_file_name = pathinfo($vs_name, PATHINFO_FILENAME);
 				$vs_name = "{$vs_file_name}.{$vs_path_ext}";
 			} else {
 				$vs_name = _t("downloaded_file.%1", $vs_path_ext);
 			}
 			
 			$o_view->setVar('archive_path', $vs_path);
 			$o_view->setVar('archive_name', $vs_name);
 			
 			// send download
 			$this->response->addContent($o_view->render('download_file_binary.php'));
 		}
 		# -------------------------------------------------------
 		# User annotations
 		# -------------------------------------------------------
		/**
		 * Returns JSON feed of annotations on an object representation
		 *
		 * Expects the following request parameters:
		 *		representation_id = the id of the ca_object_representations record to display; the representation must belong to the specified object
		 *
		 */
		public function GetAnnotations() {
			if (!$this->request->isLoggedIn()) { throw new ApplicationException(_t('Must be logged in')); }
			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
			$t_rep = new ca_object_representations($pn_representation_id);
			$t_rep->annotationMode('user');

			$va_annotations_raw = $t_rep->getAnnotations(array('user_id' => $this->request->getUserID(), 'item_id' => $this->request->getParameter('item_id', pInteger)));
			$va_annotations = array();

			if (is_array($va_annotations_raw)) {
				foreach($va_annotations_raw as $vn_annotation_id => $va_annotation) {
					$va_annotations[] = array(
						'annotation_id' => $va_annotation['annotation_id'],
						'x' => 				caGetOption('x', $va_annotation, 0, array('castTo' => 'float')),
						'y' => 				caGetOption('y', $va_annotation, 0, array('castTo' => 'float')),
						'w' => 				caGetOption('w', $va_annotation, 0, array('castTo' => 'float')),
						'h' => 				caGetOption('h', $va_annotation, 0, array('castTo' => 'float')),
						'tx' => 			caGetOption('tx', $va_annotation, 0, array('castTo' => 'float')),
						'ty' => 			caGetOption('ty', $va_annotation, 0, array('castTo' => 'float')),
						'tw' => 			caGetOption('tw', $va_annotation, 0, array('castTo' => 'float')),
						'th' => 			caGetOption('th', $va_annotation, 0, array('castTo' => 'float')),
						'points' => 		caGetOption('points', $va_annotation, array(), array('castTo' => 'array')),
						'label' => 			caGetOption('label', $va_annotation, '', array('castTo' => 'string')),
						'description' => 	caGetOption('description', $va_annotation, '', array('castTo' => 'string')),
						'type' => 			caGetOption('type', $va_annotation, 'rect', array('castTo' => 'string')),
						'locked' => 		caGetOption('locked', $va_annotation, '0', array('castTo' => 'string')),
						'options' => 		caGetOption('options', $va_annotation, array(), array('castTo' => 'array')),
						'key' =>			caGetOption('key', $va_annotation, null)
					);
				}
			}

			if (is_array($va_media_scale = $t_rep->getMediaScale('media'))) {
				$va_annotations[] = $va_media_scale;
			}

			$this->view->setVar('annotations', $va_annotations);
			$this->render('Details/ajax_representation_annotations_json.php');
		}
		# -------------------------------------------------------
		/**
		 * Saves annotations to an object representation
		 *
		 * Expects the following request parameters:
		 *		representation_id = the id of the ca_object_representations record to save annotations to; the representation must belong to the specified object
		 *
		 */
		public function SaveAnnotations() {
			global $g_ui_locale_id;
			if (!$this->request->isLoggedIn()) { throw new ApplicationException(_t('Must be logged in')); }
			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
			$vn_item_id = $this->request->getParameter('item_id', pInteger);
			
			$t_rep = new ca_object_representations($pn_representation_id);
			if (!$t_rep->getPrimaryKey()) { throw new ApplicationException(_t('Invalid representation_id')); }
			
			$t_rep->annotationMode('user');
			$pa_annotations = $this->request->getParameter('save', pArray);

			$va_annotation_ids = array();
			if (is_array($pa_annotations)) {
				foreach($pa_annotations as $vn_i => $va_annotation) {
					$vs_label = (isset($va_annotation['label']) && ($va_annotation['label'])) ? $va_annotation['label'] : '';
					if (isset($va_annotation['annotation_id']) && ($vn_annotation_id = $va_annotation['annotation_id'])) {
						// edit existing annotation
						$t_rep->editAnnotation($vn_annotation_id, $g_ui_locale_id, $va_annotation, 0, 0);
						$va_annotation_ids[$va_annotation['index']] = $vn_annotation_id;
					} else {
						// new annotation
						$va_annotation_ids[$va_annotation['index']] = $t_rep->addAnnotation($vs_label, $g_ui_locale_id, $this->request->getUserID(), $va_annotation, 0, 0, null, array('item_id' => $vn_item_id));
					}
				}
			}
			$va_annotations = array(
				'error' => $t_rep->numErrors() ? join("; ", $t_rep->getErrors()) : null,
				'annotation_ids' => $va_annotation_ids
			);

			$pa_annotations = $this->request->getParameter('delete', pArray);

			if (is_array($pa_annotations)) {
				foreach($pa_annotations as $vn_to_delete_annotation_id) {
					$t_rep->removeAnnotation($vn_to_delete_annotation_id);
				}
			}
			
			// save scale if set
			if (
				($vs_measurement = $this->request->getParameter('measurement', pString))
				&&
				(strlen($vn_width = $this->request->getParameter('width', pFloat)))
				&&
				(strlen($vn_height = $this->request->getParameter('height', pFloat)))
			) {
				$t_rep = new ca_object_representations($pn_representation_id);
				$vn_image_width = (int)$t_rep->getMediaInfo('media', 'original', 'WIDTH');
				$vn_image_height = (int)$t_rep->getMediaInfo('media', 'original', 'HEIGHT');
				$t_rep->setMediaScale('media', $vs_measurement, sqrt(pow($vn_width * $vn_image_width, 2) + pow($vn_height * $vn_image_height, 2))/$vn_image_width);
				$va_annotations = array_merge($va_annotations, $t_rep->getMediaScale('media'));
			}

			$this->view->setVar('annotations', $va_annotations);
			$this->render('Details/ajax_representation_annotations_json.php');
		}
		# -------------------------------------------------------
		/**
		 * Returns media viewer help text for display
		 */
		public function ViewerHelp() {
			$this->render('Details/viewer_help_html.php');
		}
		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Detail',
 				'action' => $po_request->getAction(),
 				'params' => array(
 					'key'
 				)
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
		# AJAX media display handlers
		# -------------------------------------------------------
		/**
		 * Returns content for overlay containing details for object representation or attribute values of type "media"
		 *
		 *	Optional parameters:
		 *		display = The type of media_display.conf display configuration to be used (Eg. "detail", "media_overlay"). [Default is "media_overlay"]
		 */
		public function GetMediaOverlay($pa_options=null) {
			$ps_context = $this->request->getParameter('context', pString);
			
			if ($ps_context == 'gallery') {
				$va_context = [
					'table' => 'ca_objects'
				];
			} elseif (!is_array($va_context = $this->opa_detail_types[$ps_context])) { 
				throw new ApplicationException(_t('Invalid context'));
			}
			
			if (!($pt_subject = Datamodel::getInstance($vs_subject = $va_context['table']))) {
				throw new ApplicationException(_t('Invalid detail type %1', $this->request->getAction()));
			}
			if (!($pn_subject_id = $this->request->getParameter('id', pInteger))) { $pn_subject_id = $this->request->getParameter($pt_subject->primaryKey(), pInteger); }
			if (!$pt_subject->load($pn_subject_id)) { 
				throw new ApplicationException(_t('Invalid id %1', $pn_subject_id));
			}
			
			if (!($ps_display_type = $this->request->getParameter('display', pString))) { $ps_display_type = 'media_overlay'; }
			$pa_options['display'] = $ps_display_type;
			$pa_options['context'] = $this->request->getParameter('context', pString);
			
			$va_options = (isset($this->opa_detail_types[$pa_options['context']]['options']) && is_array($this->opa_detail_types[$pa_options['context']]['options'])) ? $this->opa_detail_types[$pa_options['context']]['options'] : array();
			$pa_options['captionTemplate'] = caGetOption('representationViewerCaptionTemplate', $va_options, false);
			
			if (!$pt_subject->isReadable($this->request)) { 
				throw new ApplicationException(_t('Cannot view media'));
			}
			
			$va_merged_options = array_merge($va_options, $pa_options, ['noOverlay' => true, 'showAnnotations' => true, 'checkAccess' => $this->opa_access_values]);
			if($va_merged_options['inline']){
				$va_merged_options['noOverlay'] = false;
			}
			
			$this->response->addContent(caGetMediaViewerHTML($this->request, caGetMediaIdentifier($this->request), $pt_subject, $va_merged_options));
		}
		# -------------------------------------------------------
		/** 
		 * Return media viewer HTML for use inline on a detail.
		 */
		public function GetMediaInline() {
			$this->GetMediaOverlay(['inline' => true]);
		}
		# -------------------------------------------------------
		/**
		 * Return media viewer data via AJAX callback for viewers that require it.
		 */
		public function GetMediaData() {
			$ps_context = $this->request->getParameter('context', pString);
			
			if (!($ps_display_type = $this->request->getParameter('display', pString))) { $ps_display_type = 'detail'; }
		
			switch($ps_context) {
				case 'gallery':
				case 'GetMediaInline':
				case 'GetMediaOverlay':
					$va_context = ['table' => 'ca_objects'];
					break;
				default:
					if(!is_array($va_context = $this->opa_detail_types[$ps_context])) { 
						throw new ApplicationException(_t('Invalid context'));
					}
					break;
			}
			
			if (!($pt_subject = Datamodel::getInstance($vs_subject = $va_context['table']))) {
				throw new ApplicationException(_t('Invalid detail type %1', $this->request->getAction()));
			}
			
			if (!($pn_subject_id = $this->request->getParameter('id', pInteger))) { $pn_subject_id = $this->request->getParameter($pt_subject->primaryKey(), pInteger); }
			if (!$pt_subject->load($pn_subject_id)) { 
				throw new ApplicationException(_t('Invalid id %1', $pn_subject_id));
			}
			
			if (!$pt_subject->isReadable($this->request)) { 
				throw new ApplicationException(_t('Cannot view media'));
			}
		
			$this->response->addContent(caGetMediaViewerData($this->request, caGetMediaIdentifier($this->request), $pt_subject, ['display' => $ps_display_type, 'context' => $ps_context, 'checkAccess' => $this->opa_access_values]));
		}
		# -------------------------------------------------------
        /**
         * Provide in-viewer search for those that support it (Eg. UniversalViewer)
         */
        public function SearchMediaData() {
           $ps_context = $this->request->getParameter('context', pString);
            
            if (!($ps_display_type = $this->request->getParameter('display', pString))) { $ps_display_type = 'media_overlay'; }
    
            switch($ps_context) {
                case 'gallery':
                case 'GetMediaInline':
                case 'GetMediaOverlay':
                    $va_context = ['table' => 'ca_objects'];
                    break;
                default:
                    if(!is_array($va_context = $this->opa_detail_types[$ps_context])) { 
                        throw new ApplicationException(_t('Invalid context'));
                    }
                    break;
            }
        
            if (!($pt_subject = Datamodel::getInstance($vs_subject = $va_context['table']))) {
                throw new ApplicationException(_t('Invalid detail type %1', $this->request->getAction()));
            }
        
            if (!($pn_subject_id = $this->request->getParameter('id', pInteger))) { $pn_subject_id = $this->request->getParameter($pt_subject->primaryKey(), pInteger); }
            if (!$pt_subject->load($pn_subject_id)) { 
                throw new ApplicationException(_t('Invalid id %1', $pn_subject_id));
            }
        
            if (!$pt_subject->isReadable($this->request)) { 
                throw new ApplicationException(_t('Cannot view media'));
            }
    
            $this->response->addContent(caSearchMediaData($this->request, caGetMediaIdentifier($this->request), $pt_subject, ['display' => $ps_display_type, 'context' => $this->request->getParameter('context', pString)]));
        }
        # -------------------------------------------------------
        /**
         * Provide in-viewer search for those that support it (Eg. UniversalViewer)
         */
        public function MediaDataAutocomplete() {
           $ps_context = $this->request->getParameter('context', pString);
            
            if (!($ps_display_type = $this->request->getParameter('display', pString))) { $ps_display_type = 'media_overlay'; }
    
            switch($ps_context) {
                case 'gallery':
                case 'GetMediaInline':
                case 'GetMediaOverlay':
                    $va_context = ['table' => 'ca_objects'];
                    break;
                default:
                    if(!is_array($va_context = $this->opa_detail_types[$ps_context])) { 
                        throw new ApplicationException(_t('Invalid context'));
                    }
                    break;
            }
        
            if (!($pt_subject = Datamodel::getInstance($vs_subject = $va_context['table']))) {
                throw new ApplicationException(_t('Invalid detail type %1', $this->request->getAction()));
            }
        
            if (!($pn_subject_id = $this->request->getParameter('id', pInteger))) { $pn_subject_id = $this->request->getParameter($pt_subject->primaryKey(), pInteger); }
            if (!$pt_subject->load($pn_subject_id)) { 
                throw new ApplicationException(_t('Invalid id %1', $pn_subject_id));
            }
        
            if (!$pt_subject->isReadable($this->request)) { 
                throw new ApplicationException(_t('Cannot view media'));
            }
    
            $this->response->addContent(caMediaDataAutocomplete($this->request, caGetMediaIdentifier($this->request), $pt_subject, ['display' => $ps_display_type, 'context' => $this->request->getParameter('context', pString)]));
        }
		# -------------------------------------------------------
		/**
		 * Clean up tmp files
		 */
		public function __destruct() {
			if($this->ops_tmp_download_file_path) { @unlink($this->ops_tmp_download_file_path); }
		}
 		# -------------------------------------------------------
	}
