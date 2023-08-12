<?php
/* ----------------------------------------------------------------------
 * app/controllers/DetailController.php : controller for object search request handling - processes searches from top search bar
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2023 Whirl-i-Gig
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
			$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
		}
		if (($this->request->config->get('deploy_bristol'))&&($this->request->isLoggedIn())) {
			if (!($id = urldecode($this->request->getActionExtra()))) { $id = $this->request->getParameter('id', pInteger); }
			
			$t_set_list = new ca_sets();
			$t_set = new ca_sets();
			$va_sets = $t_set_list->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "checkAccess" => $this->opa_access_values));
			$va_user_has_access = false;
			if (sizeof($va_sets) > 0) {
				foreach ($va_sets as $va_key => $va_set) {
					if($t_set->isInSet('ca_objects', $id, $va_set['set_id'])) {
						$va_user_has_access = true;
					}
				}
			}
			if ($va_user_has_access == false) {
				print "You do not have access to view this page.";
				die;
			}
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
	public function __call($function, $args) {
		AssetLoadManager::register("panel");
		AssetLoadManager::register("mediaViewer");
		AssetLoadManager::register("carousel");
		AssetLoadManager::register("readmore");
		AssetLoadManager::register("maps");
		
		$o_search_config = caGetSearchConfig();
		
		$options = (isset($this->opa_detail_types[$function]['options']) && is_array($this->opa_detail_types[$function]['options'])) ? $this->opa_detail_types[$function]['options'] : array();
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
		
		$function = strtolower($function);
		$id = urldecode($this->request->getActionExtra()); 
	
		if (!isset($this->opa_detail_types[$function]) || !isset($this->opa_detail_types[$function]['table']) || (!($table = $this->opa_detail_types[$function]['table']))) {
			// invalid detail type – throw error
			throw new ApplicationException("Invalid detail type");
		}
		
		if (!($t_subject = Datamodel::getInstance($table, true))) {
			throw new ApplicationException("Invalid detail table");
		}
		$this->ops_tablename = $table;
		
		$use_alt_identifier_in_urls = caUseAltIdentifierInUrls($table);
		if ((($use_identifiers_in_urls = caUseIdentifiersInUrls()) || ($use_alt_identifier_in_urls)) && (substr($id, 0, 3) == "id:")) {
			$tmp = explode(":", $id);
			$id = (int)$tmp[1];
			$use_identifiers_in_urls = $use_alt_identifier_in_urls = false;
		}

		if($use_alt_identifier_in_urls && $t_subject->hasElement($use_alt_identifier_in_urls)) {
			$load_params = [$use_alt_identifier_in_urls => $id];
		} elseif ($use_identifiers_in_urls && $t_subject->getProperty('ID_NUMBERING_ID_FIELD')) {
			$load_params = [$t_subject->getProperty('ID_NUMBERING_ID_FIELD') => $id];
		} else {
			$load_params = [$t_subject->primaryKey() => (int)$id];
		}
		
		if (!($t_subject = call_user_func_array($t_subject->tableName().'::find', array($load_params, ['returnAs' => 'firstModelInstance'])))) {
			// invalid id - throw error
			throw new ApplicationException("Invalid id");
		} 
		$t_subject->autoConvertLineBreaks(true);
		
		$ps_view = $this->request->getParameter('view', pString);
		if($ps_view === 'pdf') {
			if (!($vn_limit = ini_get('max_execution_time'))) { $vn_limit = 30; }
			set_time_limit($vn_limit * 6);
		
			caExportItemAsPDF(
				$this->request, 
				$t_subject, 
				$this->request->getParameter("export_format", pString), 
				caGenerateDownloadFileName(caGetOption('pdfExportTitle', $options, $t_subject->get('preferred_labels')), ['t_subject' => $t_subject]), 
				['checkAccess' => $this->opa_access_values]
			);
			return;
		}		
		
		//
		// Return facet content
		//	
		if(($ps_facet = $this->request->getParameter('facet', pString)) || ($ps_remove_facet = $this->request->getParameter('removeCriterion', pString))) {
			$browse_type = $this->request->getParameter('browseType', pString);
			if (
				($browse_table = ((isset($this->opa_detail_types[$browse_type]) && isset($this->opa_detail_types[$browse_type]['table']))) ? $this->opa_detail_types[$browse_type]['table'] : null)
				&&
				($o_browse = caGetBrowseInstance($browse_table))
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
					$class = 'ca_objects';
					$o_browse = caGetBrowseInstance($class);
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
		
		// Record view
		$t_subject->registerItemView();
		
		$this->view->setVar("config_options", $options);
		
		if (!caGetOption('disableExport', $options, false)) {
			// Exportables/printables
			// 	merge displays with drop-in print templates
			//
			$available_export_options = caGetAvailablePrintTemplates('summary', array('table' => $t_subject->tableName())); 
			$this->view->setVar('export_formats', $available_export_options);
		
			$export_options = array();
			foreach($available_export_options as $vn_i => $format_info) {
				$export_options[$format_info['name']] = $format_info['code'];
			}
			// Get current display list
			$t_display = new ca_bundle_displays();
			foreach(caExtractValuesByUserLocale($t_display->getBundleDisplays(array('table' => $this->ops_tablename, 'user_id' => $this->request->getUserID(), 'access' => __CA_BUNDLE_DISPLAY_READ_ACCESS__, 'checkAccess' => caGetUserAccessValues($this->request)))) as $display) {
				$export_options[$display['name']] = "_display_".$display['display_id'];
			}
			ksort($export_options);
			$this->view->setVar('export_format_select', caHTMLSelect('export_format', $export_options, array('class' => 'searchToolsSelect'), array('value' => $this->view->getVar('current_export_format'), 'width' => '150px')));
		}
		
		#
		# Enforce access control
		#
		if(sizeof($this->opa_access_values) && ($t_subject->hasField('access')) && (!in_array($t_subject->get("access"), $this->opa_access_values))){
			$this->notification->addNotification(_t("This item is not available for view"), __NOTIFICATION_TYPE_INFO__);
			$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
			return;
		}
		
		if ($this->request->config->get("{$table}_dont_use_labels")) { 
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").$t_subject->getTypeName().$this->request->config->get("page_title_delimiter").(($idno = $t_subject->get($t_subject->getProperty('ID_NUMBERING_ID_FIELD'))) ? "{$idno}" : ""));
		} else {
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").$t_subject->getTypeName().$this->request->config->get("page_title_delimiter").$t_subject->get('preferred_labels').(($idno = $t_subject->get($t_subject->getProperty('ID_NUMBERING_ID_FIELD'))) ? " [{$idno}]" : ""));
		}
		$type = $t_subject->getTypeCode();
		
		$t_subject->doHighlighting($o_search_config->get("do_highlighting"));
		
		$this->view->setVar('detailType', $table);
		$this->view->setVar('item', $t_subject);
		$this->view->setVar('itemType', $type);
		
		caAddPageCSSClasses(array($table, $function, $type));
		
		$o_context = ResultContext::getResultContextForLastFind($this->request, $table);
		
		
		$result_desc = $o_context->getResultDescription();
		$this->view->setVar('resultDesc', $result_desc[$t_subject->getPrimaryKey()] ?? null);
		
		if($o_context->findType() === 'multisearch') {
			if(!in_array($t_subject->getPrimaryKey(), $o_context->getResultList())) {
				// try to find context that contains item
				$search_config = caGetSearchConfig();
				$blocks = array_filter($search_config->getAssoc('multisearchTypes') ?? [], function($v) use ($table) {
					return ($v['table'] === $table);
				});
				foreach($blocks as $block => $block_info) {
					if($block === $o_context->findSubType()) { continue; }
					if($o_new_context = new ResultContext($this->request, $table, 'multisearch', $block)) {
						if(in_array($t_subject->getPrimaryKey(), $o_new_context->getResultList())) {
							$o_context = $o_new_context;
							break;
						}
					}
				}
			}
		}
		
		$this->view->setVar('previousID', $vn_previous_id = $o_context->getPreviousID($t_subject->getPrimaryKey()));
		$this->view->setVar('nextID', $vn_next_id = $o_context->getNextID($t_subject->getPrimaryKey()));
		$this->view->setVar('previousURL', caDetailUrl($this->request, $table, $vn_previous_id));
		$this->view->setVar('nextURL', caDetailUrl($this->request, $table, $vn_next_id));
		
		$this->view->setVar('previousLink', ($vn_previous_id > 0) ? caDetailLink($this->request, caGetOption('previousLink', $options, _t('Previous')), '', $table, $vn_previous_id, [], ['aria-label' => _t('Previous')]) : '');
		$this->view->setVar('nextLink', ($vn_next_id > 0) ? caDetailLink($this->request, caGetOption('nextLink', $options, _t('Next')), '', $table, $vn_next_id, [], ['aria-label' => _t('Next')]) : '');
		
		$params = [];
		$params["row_id"] = $t_subject->getPrimaryKey(); # --- used to jump to the last viewed item in the search/browse results
		$this->view->setVar('resultsLink', ResultContext::getResultsLinkForLastFind($this->request, $table, caGetOption('resultsLink', $options, _t('Back')), null, $params, ['aria-label' => _t('Back')]));
		$this->view->setVar('resultsURL', ResultContext::getResultsUrlForLastFind($this->request, $table, $params));
		
		
		//
		// Representation viewer
		//
		if (method_exists($t_subject, 'getPrimaryRepresentationInstance')) {
			if($pn_representation_id = $this->request->getParameter('representation_id', pInteger)){
				$t_representation = Datamodel::getInstance("ca_object_representations", true);
				$t_representation->load($pn_representation_id);
			}else{
				$t_representation = $t_subject->getPrimaryRepresentationInstance(array("checkAccess" => $this->opa_access_values));
			}
			if ($t_representation) {
				$this->view->setVar("t_representation", $t_representation);
				$this->view->setVar("representation_id", $t_representation->get("representation_id"));
			}else{
				$t_representation = Datamodel::getInstance("ca_object_representations", true);
				$this->view->setVar("representation_id", null);
			}
			if(!is_array($media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE')))) { $media_display_info = []; }
			
			$default_annotation_id = $start_timecode = null;
			
			if($start_timecode = $this->request->getParameter('start', pString)) {
				// Timecode specified
			} elseif(
				($annotation_identifier = $this->request->getParameter(['annotation', 'clip'], pString)) &&
				(($options['annotationIdentifier'] ?? null) && 
				($t_instance = ca_representation_annotations::findAsInstance([$options['annotationIdentifier'] => $annotation_identifier])))
			) {
				$default_annotation_id = $t_instance->get('ca_representation_annotations.annotation_id');
			} elseif($item_match_desc = $result_desc[$t_subject->getPrimaryKey()] ?? null) {
				// Search matched annotation?
				foreach($item_match_desc['desc'] as $m) {
					if($m['table'] === 'ca_representation_annotations') {
						$default_annotation_id = $m['field_row_id'];
						break;
					}
					if($m['table'] === 'ca_representation_annotation_labels') {
						if($t_instance = ca_representation_annotation_labels::findAsInstance($m['field_row_id'])) {
							$default_annotation_id = $t_instance->get('ca_representation_annotation_labels.annotation_id');
							break;
						}
					}
				}
			}
			$this->view->setVar('representationViewerPrimaryOnly', $rep_viewer_primary_only = caGetOption('representationViewerPrimaryOnly', $options, false));
			$this->view->setVar('representationViewer', 
				caRepresentationViewer(
					$this->request, 
					$t_subject, 
					$t_subject,
					array_merge($options, $media_display_info, 
						[
							'display' => 'detail',
							'showAnnotations' => true, 
							'defaultAnnotationID' => $default_annotation_id,	// jump to specific annotation?
							'startTimecode' => $start_timecode,				// jump to specific time?
							'primaryOnly' => caGetOption('representationViewerPrimaryOnly', $options, false), 
							'dontShowPlaceholder' => caGetOption('representationViewerDontShowPlaceholder', $options, false), 
							'captionTemplate' => caGetOption('representationViewerCaptionTemplate', $options, false),
							'checkAccess' => $this->opa_access_values
						]
					)
				)
			);
			$this->view->setVar('representationViewerThumbnailBar', 
				caObjectRepresentationThumbnails($this->request, $this->view->getVar("representation_id"), $t_subject, array_merge($options, ["returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $rep_viewer_primary_only ? 1 : 0]))
			);
		}
		
		//
		// map
		//
		if (!is_array($map_attributes = caGetOption(['mapAttributes', 'map_attributes'], $options, array())) || !sizeof($map_attributes)) {
			if ($map_attribute = caGetOption(['mapAttribute', 'map_attribute'], $options, false)) { $map_attributes = array($map_attribute); }
		}
		
		$this->view->setVar("map", "");
		if(is_array($map_attributes) && sizeof($map_attributes)) {
			$o_map = new GeographicMap((($vn_width = caGetOption(['mapWidth', 'map_width'], $options, false)) ? $vn_width : 285), (($vn_height = caGetOption(['mapHeight', 'map_height'], $options, false)) ? $vn_height : 200), 'map');
				
			$vn_mapped_count = 0;	
			foreach($map_attributes as $map_attribute) {
				if ($t_subject->get($map_attribute)){
					$map_fuzz_level = null;
					if(is_array($map_fuzz_config = caGetOption('mapFuzz', $options, null))) {
						$when = $map_fuzz_config['when'] ?? null;
						if(($when && $t_subject->evaluateExpression($map_fuzz_config['when'])) || !$when) {
							$map_fuzz_level = $map_fuzz_config['level'] ?? null;
						}
					} else{
						$map_fuzz_level = $map_fuzz_config;
					}
					$ret = $o_map->mapFrom($t_subject, $map_attribute, array('labelTemplate' => caGetOption('mapLabelTemplate', $options, false), 'contentTemplate' => caGetOption('mapContentTemplate', $options, false), 'fuzz' => (int)$map_fuzz_level));
					$vn_mapped_count += $ret['items'];
				}
			}
			
			if ($vn_mapped_count > 0) { 
				$this->view->setVar("map", $o_map->render('HTML', array('zoomLevel' => caGetOption(['mapZoomLevel', 'zoom_level'], $options, null), 'minZoomLevel' => caGetOption(['mapMinZoomLevel'], $options, null), 'maxZoomLevel' => caGetOption(['mapMaxZoomLevel'], $options, null))));
			}
		}
		
		// Filtering of related items
		if (($t_subject->tableName() != 'ca_objects') && (!$this->opa_detail_types[$function]['disableRelatedItemsBrowse'])) {
			$class = 'ca_objects';
			$o_browse = caGetBrowseInstance($class);
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
			if ($facet_group = caGetOption('facetGroup', $browse_info, null)) {
				$o_browse->setFacetGroup($facet_group);
			}
		
			$o_browse->execute();
			$available_facet_list = caGetOption('availableFacets', $browse_info, null);
			$facets = $o_browse->getInfoForAvailableFacets();
			foreach($facets as $facet_name => $facet_info) {
				if(isset($base_criteria[$facet_name])) { continue; } // skip base criteria 
				$facets[$facet_name]['content'] = $o_browse->getFacet($facet_name, array("checkAccess" => $this->opa_access_values, 'checkAvailabilityOnly' => caGetOption('deferred_load', $facet_info, false, array('castTo' => 'bool'))));
			}
			$this->view->setVar('facets', $facets);
	
			$this->view->setVar('key', $key = $o_browse->getBrowseID());
		
			Session::setVar($function.'_last_browse_id', $key);
		
		
			// remove base criteria from display list
			if (is_array($base_criteria)) {
				foreach($base_criteria as $base_facet => $criteria_value) {
					unset($criteria[$base_facet]);
				}
			}
			$criteria = $o_browse->getCriteriaWithLabels();
		
			$criteria_for_display = array();
			foreach($criteria as $facet_name => $criterion) {
				$facet_info = $o_browse->getInfoForFacet($facet_name);
				foreach($criterion as $vn_criterion_id => $criterion) {
					$criteria_for_display[] = array('facet' => $facet_info['label_singular'], 'facet_name' => $facet_name, 'value' => $criterion, 'id' => $vn_criterion_id);
				}
			}
			$this->view->setVar('criteria', $criteria_for_display);
			
			$o_rel_context = new ResultContext($this->request, 'ca_objects', 'detailrelated', $function);
			$o_rel_context->setParameter('key', $key);
			$o_rel_context->setAsLastFind(true);
			
			$qr_rel_res = $o_browse->getResults();
			$o_rel_context->setResultList($qr_rel_res->getPrimaryKeyValues(1000));
			
			$o_rel_context->saveContext();
		}
		
		//
		// comments, tags, rank
		//
		$this->view->setVar('commentsEnabled', (bool)$options['enableComments']);
		
		if ((bool)$options['enableComments']) {
			$this->view->setVar('averageRank', $t_subject->getAverageRating(true));
			$this->view->setVar('numRank', $t_subject->getNumRatings(true));
		
			#
			# User-generated comments, tags and ratings
			#
			$user_comments = $t_subject->getComments(null, true);
			$comments = array();
			if (is_array($user_comments)) {
				foreach($user_comments as $user_comment){
					if($user_comment["comment"] || $user_comment["media1"] || $user_comment["media2"] || $user_comment["media3"] || $user_comment["media4"]){
						# TODO: format date based on locale
						$user_comment["date"] = date("n/j/Y", $user_comment["created_on"]);
					
						# -- get name of commenter
						if($user_comment["user_id"]){
							$t_user = new ca_users($user_comment["user_id"]);
							$user_comment["author"] = $t_user->getName();
						}elseif($user_comment["name"]){
							$user_comment["author"] = $user_comment["name"];
						}
						$comments[] = $user_comment;
					}
				}
			}
			$this->view->setVar('comments', $comments);
		
		
			$user_tags = $t_subject->getTags(null, true);
			$tags = array();
		
			if (is_array($user_tags)) {
				foreach($user_tags as $user_tag){
					if(!in_array($user_tag["tag"], $tags)){
						$tags[] = $user_tag["tag"];
					}
				}
			}
			$this->view->setVar('tags_array', $tags);
			$this->view->setVar('tags', implode(", ", $tags));
		
			$this->view->setVar("itemComments", caDetailItemComments($this->request, $t_subject->getPrimaryKey(), $t_subject, $comments, $tags));
		} else {
			$this->view->setVar("itemComments", '');
		}
		
		//
		// Set row_id for use within the view
		//
		$this->view->setVar('id', $id);
		$this->view->setVar($t_subject->primaryKey(), $id);
		
		
		//
		// share link
		//
		$this->view->setVar('shareEnabled', (bool)$options['enableShare']);
		
		$options['shareLabel'] ? $ps_label = $options['shareLabel'] : $ps_label = 'Share';

		$this->view->setVar("shareLink", "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'ShareForm', array("tablename" => $t_subject->tableName(), "item_id" => $t_subject->getPrimaryKey()))."\"); return false;'>".$ps_label."</a>");

		// find view
		//		first look for type-specific view
		$path = "Details/{$table}_default_html.php";		// If no type specific view use the default
		if ($subject_type_code = $t_subject->getTypeCode()) {
			if (is_array($type_codes = caMakeTypeList($table, [$subject_type_code]))) {
				$type_codes = array_merge($type_codes, caMakeTypeList($table, $t_subject->getTypeInstance()->getHierarchyAncestors($t_subject->getTypeID(), ['idsOnly' => true]), ['dontIncludeSubtypesInTypeRestriction' => true]));
				foreach($type_codes as $type_code) {   // try more specific types first
					if ($this->viewExists("Details/{$table}_{$type_code}_html.php")) {
						$path = "Details/{$table}_{$type_code}_html.php";
						break;
					}
				}
			}
		}

		$this->view->setVar('pdfEnabled', (bool)$options['enablePDF']);
		caDoTemplateTagSubstitution($this->view, $t_subject, $path, ['checkAccess' => $this->opa_access_values]);
		$this->render($path);
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
		$id 					= $this->request->getParameter('id', pInteger);
		$representation_id 		= $this->request->getParameter('representation_id', pInteger);
		$detail_type			= $this->request->getParameter('context', pString);
		$default_annotation_id 	= $this->request->getParameter('default_annotation_id', pInteger);
		$start_timecode 		= $this->request->getParameter('start_timecode', pString);
		
		$start_time = null;
		if($start_timecode) {
			$tc = new TimecodeParser($start_timecode);
			$start_time = $tc->getSeconds();
		}
		$detail_options 		= (isset($this->opa_detail_types[$detail_type]['options']) && is_array($this->opa_detail_types[$detail_type]['options'])) ? $this->opa_detail_types[$detail_type]['options'] : array();
		
		if(!$id) { $id = 0; }
		$t_rep = new ca_object_representations($representation_id);
		if (!$t_rep->getPrimaryKey()) { 
			$this->postError(1100, _t('Invalid object/representation'), 'DetailController->GetTimebasedRepresentationAnnotationList');
			return;
		}
		
		if (!($vs_template = $detail_options['displayAnnotationTemplate'])) { $vs_template = '^ca_representation_annotations.preferred_labels.name'; }
		
		$props = $t_rep->getMediaInfo('media', 'original', 'PROPERTIES');
		$annotation_list = $annotation_times = array();
		if (
			is_array($annotations = $t_rep->getAnnotations(array('idsOnly' => true))) //$t_rep->get('ca_representation_annotations.annotation_id', array('returnAsArray' => true))) 
			&& 
			sizeof($annotations)
			&&
			($qr_annotations = caMakeSearchResult('ca_representation_annotations', $annotations))
		) {
			while($qr_annotations->nextHit()) {
				if (!preg_match('!^TimeBased!', $qr_annotations->getAnnotationType())) { continue; }
				$annotation_list[$qr_annotations->getPrimaryKey()] = $qr_annotations->getWithTemplate($vs_template);
				$annotation_times[] = array((float)$qr_annotations->getPropertyValue('startTimecode', true) - (float)$props['timecode_offset'], (float)$qr_annotations->getPropertyValue('endTimecode', true) - (float)$props['timecode_offset']);
			}
			$qr_annotations->seek(0);
		}
		
		$this->view->setVar('representation_id', $representation_id);
		$this->view->setVar('annotation_list', $annotation_list);
		$this->view->setVar('annotation_times', $annotation_times);
		$this->view->setVar('default_annotation_id', $default_annotation_id);
		$this->view->setVar('start_time', $start_time);
		$this->view->setVar('annotations_search_results', $qr_annotations);
		$this->view->setVar('player_name', "caMediaOverlayTimebased_{$representation_id}_detail");
		
		$this->render('Details/annotations_html.php');
	}
	# -------------------------------------------------------
	/**
	 * 
	 */ 
	public function SearchWithinMedia() {
		$representation_id = $this->request->getParameter('representation_id', pInteger);
		$q = $this->request->getParameter('q', pString);
		
		$results = MediaContentLocationIndexer::SearchWithinMedia($q, 'ca_object_representations', $representation_id, 'media');
		$this->view->setVar('results', $results);
		
		$this->render('Details/object_representation_within_media_search_results_json.php');
	}
	# -------------------------------------------------------
	/**
	 * Download all media attached to specified object (not necessarily open for editing)
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
		
		$o_app_plugin_manager = new ApplicationPluginManager();
		
		$pn_object_id = $this->request->getParameter('object_id', pInteger);
		$pb_exclude_ancestors = $this->request->getParameter('exclude_ancestors', pInteger);
		$pn_value_id = $this->request->getParameter('value_id', pInteger);
		if ($pn_value_id) {
			return $this->DownloadAttributeMedia();
		}
		$t_object = new ca_objects($pn_object_id);
		if (!($vn_object_id = $t_object->getPrimaryKey())) { return; }
		if(sizeof($this->opa_access_values) && (!in_array($t_object->get("access"), $this->opa_access_values))){
			return;
		}
		
		$ps_version = $this->request->getParameter('version', pString);
		
		if (!$ps_version) { $ps_version = 'original'; }
		$this->view->setVar('version', $ps_version);
		
		if($pb_exclude_ancestors){
			$va_ancestor_ids = array($pn_object_id);
		}else{
			$va_ancestor_ids = $t_object->getHierarchyAncestors(null, array('idsOnly' => true, 'includeSelf' => true));
			if ($vn_parent_id = array_pop($va_ancestor_ids)) {
				$t_object->load($vn_parent_id);
				if(!sizeof($this->opa_access_values) || (in_array($t_object->get("access"), $this->opa_access_values))){
					array_unshift($va_ancestor_ids, $vn_parent_id);
				}
			}
		}			
		$va_child_ids = $t_object->get("ca_objects.children.object_id", array("returnWithStructure" => true, "checkAccess" => $this->opa_access_values));
		
		foreach($va_ancestor_ids as $vn_id) {
			array_unshift($va_child_ids, $vn_id);
		}
		
		$vn_c = 1;
		$va_file_names = array();
		$va_file_paths = array();
		
		// Allow plugins to modify object_id list
		$va_child_ids =  $o_app_plugin_manager->hookDetailDownloadMediaObjectIDs($va_child_ids);
		$va_child_ids = array_unique($va_child_ids);
		$t_download_log = new Downloadlog();
		foreach($va_child_ids as $vn_object_id) {
			$t_child_object = new ca_objects($vn_object_id);
			if (!$t_child_object->getPrimaryKey()) { continue; }
			
			$t_download_log->log(array(
					"user_id" => $this->request->getUserID() ? $this->request->getUserID() : null, 
					"ip_addr" => RequestHTTP::ip(), 
					"table_num" => $t_object->TableNum(), 
					"row_id" => $vn_object_id, 
					"representation_id" => null, 
					"download_source" => "pawtucket"
			));
			$va_reps = $t_child_object->getRepresentations(array($ps_version), null, array("checkAccess" => $this->opa_access_values));
			$vs_idno = $t_child_object->get('idno');
			
			foreach($va_reps as $vn_representation_id => $va_rep) {
				$va_rep_info = $va_rep['info'][$ps_version];
				
				$vs_filename = caGetRepresentationDownloadFileName('ca_objects', ['idno' => $vs_idno, 'index' => $vn_c, 'version' => $ps_version, 'extension' => $va_rep_info['EXTENSION'], 'original_filename' => $va_rep['info']['original_filename'], 'representation_id' => $vn_representation_id]);
				
				$va_file_names[$vs_filename] = true;
				$this->view->setVar('version_download_name', $vs_filename);
			
				//
				// Perform metadata embedding
				$t_rep = new ca_object_representations($va_rep['representation_id']);
				if (!($vs_path = $this->ops_tmp_download_file_path = caEmbedMediaMetadataIntoFile($t_rep->getMediaPath('media', $ps_version), 'ca_objects', $t_child_object->getPrimaryKey(), $t_child_object->getTypeCode(), $t_rep->getPrimaryKey(), $t_rep->getTypeCode()))) {
					$vs_path = $t_rep->getMediaPath('media', $ps_version);
				}
				$va_file_paths[$vs_path] = $vs_filename;
				
				$vn_c++;
			}
		}
		
		// Allow plugins to modify file path list
		$va_file_paths = $o_app_plugin_manager->hookDetailDownloadMediaFilePaths($va_file_paths);
		
		if (sizeof($va_file_paths) > 1) {
			if (!($vn_limit = ini_get('max_execution_time'))) { $vn_limit = 30; }
			set_time_limit($vn_limit * 2);
			$o_zip = new ZipStream();
			foreach($va_file_paths as $vs_path => $vs_name) {
				$o_zip->addFile($vs_path, $vs_name);
			}
			$this->view->setVar('zip_stream', $o_zip);
			$this->view->setVar('archive_name', preg_replace('![^A-Za-z0-9\.\-]+!', '_', $t_object->get('idno')).'.zip');
			
			$vn_rc = $this->render('Details/download_file_binary.php');
			
			if ($vs_path) { unlink($vs_path); }
		} else {
			foreach($va_file_paths as $vs_path => $vs_name) {
				$this->view->setVar('archive_path', $vs_path);
				$this->view->setVar('archive_name', $vs_name);
			}
			$vn_rc = $this->render('Details/download_file_binary.php');
		}
		
		return $vn_rc;
	}
	# -------------------------------------------------------
	/**
	 * Download single representation from currently open object
	 *
	 * TODO: remove and route all references to DownloadMedia()
	 */ 
	public function DownloadRepresentation() {
		if (!caObjectsDisplayDownloadLink($this->request)) {
			$this->postError(1100, _t('Cannot download media'), 'DetailController->DownloadMedia');
			return;
		}
		
		$ps_context = $this->request->getParameter('context', pString);
		
		if ($ps_context == 'gallery') {
			$va_context = [
				'table' => 'ca_objects'
			];
		} elseif (!is_array($va_context = $this->opa_detail_types[$ps_context])) { 
			throw new ApplicationException(_t('Invalid context'));
		}
		
		if (!($t_instance = Datamodel::getInstance($va_context['table'], true))) {
			throw new ApplicationException(_t('Invalid context'));
		}
		
		
		if (!($vn_object_id = $this->request->getParameter('object_id', pInteger))) {
			$vn_object_id = $this->request->getParameter('id', pInteger);
		}
		$t_instance->load($vn_object_id);
		if (!$t_instance->isLoaded()) {
			throw new ApplicationException(_t('Cannot download media'));
		}
		if(sizeof($this->opa_access_values) && (!in_array($t_instance->get("access"), $this->opa_access_values))){
			return;
		}
		$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
		$ps_version = $this->request->getParameter('version', pString);
		
		$this->view->setVar('representation_id', $pn_representation_id);
		$t_rep = new ca_object_representations($pn_representation_id);
		if(sizeof($this->opa_access_values) && (!in_array($t_rep->get("access"), $this->opa_access_values))){
			return;
		}
		$this->view->setVar('t_object_representation', $t_rep);
		
		$t_download_log = new Downloadlog();
		$t_download_log->log(array(
				"user_id" => $this->request->getUserID() ? $this->request->getUserID() : null, 
				"ip_addr" => $_SERVER['REMOTE_ADDR'] ?  $_SERVER['REMOTE_ADDR'] : null, 
				"table_num" => $t_instance->tableNum(), 
				"row_id" => $vn_object_id, 
				"representation_id" => $pn_representation_id, 
				"download_source" => "pawtucket"
		));
			
		$va_versions = $t_rep->getMediaVersions('media');
		
		if (!in_array($ps_version, $va_versions)) { $ps_version = $va_versions[0]; }
		$this->view->setVar('version', $ps_version);
		
		$va_rep_info = $t_rep->getMediaInfo('media', $ps_version);
		$this->view->setVar('version_info', $va_rep_info);
		
		$va_info = $t_rep->getMediaInfo('media');
		
		$vals = ['idno' => $vs_idno_proc];
		foreach(array_merge($va_rep_info, $va_info) as $k => $v) {
			if (is_array($v)) { continue; }
			if (strtolower($k) == 'original_filename') { $v = pathinfo($v, PATHINFO_FILENAME); }
			$vals[strtolower($k)] = preg_replace('![^A-Za-z0-9_\-]+!', '_', $v);
		}
		
		$vs_filename = caGetRepresentationDownloadFileName($va_context['table'], ['idno' => $t_instance->get('idno'), 'index' => null, 'version' => $ps_version, 'extension' => $va_rep_info['EXTENSION'], 'original_filename' => $va_info['ORIGINAL_FILENAME'], 'representation_id' => $pn_representation_id]);
		$this->view->setVar('version_download_name', $vs_filename);
		
		
		//
		// Perform metadata embedding
		if ($this->ops_tmp_download_file_path = caEmbedMediaMetadataIntoFile($t_rep->getMediaPath('media', $ps_version), 'ca_objects', $t_instance->getPrimaryKey(), $t_instance->getTypeCode(), $t_rep->getPrimaryKey(), $t_rep->getTypeCode())) {
			$this->view->setVar('version_path', $this->ops_tmp_download_file_path);
		} else {
			$this->view->setVar('version_path', $t_rep->getMediaPath('media', $ps_version));
		}
		$this->render('Details/object_representation_download_binary.php', true);
	}
	# -------------------------------------------------------
	# Tagging and commenting
	# -------------------------------------------------------
	/**
	 *
	 */
	public function CommentForm(){
		if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
		$this->view->setVar("item_id", $this->request->getParameter('item_id', pInteger));
		$this->view->setVar("tablename", $this->request->getParameter('tablename', pString));
		$this->render('Details/form_comments_html.php');
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function SaveCommentTagging() {
		if (!caValidateCSRFToken($this->request)) {
			throw new ApplicationException(_t("Invalid CSRF token"));
		}
		
		# --- inline is passed to indicate form appears embedded in detail page, not in overlay
		$inline_form = $this->request->getParameter("inline", pInteger);
		if(!$t_item = Datamodel::getInstance($this->request->getParameter("tablename", pString), true)) {
			throw new ApplicationException("Invalid table name ".$this->request->getParameter("tablename", pString)." for saving comment");
		}
		$table = $this->request->getParameter("tablename", pString);
		if(!($item_id = $this->request->getParameter("item_id", pInteger))){
			if($inline_form){
				$this->notification->addNotification(_t("Invalid ID"), __NOTIFICATION_TYPE_ERROR__);
				$this->response->setRedirect(caDetailUrl($this->request, $table, $item_id));
			}else{
				$this->view->setVar("message", _t("Invalid ID"));
				$this->render("Form/reload_html.php");
			}
			return;
		}
		if(!$t_item->load($item_id)){
			if($inline_form){
				$this->notification->addNotification(_t("ID does not exist"), __NOTIFICATION_TYPE_ERROR__);
				$this->response->setRedirect(caDetailUrl($this->request, $table, $item_id));
			}else{
				$this->view->setVar("message", _t("ID does not exist"));
				$this->render("Form/reload_html.php");
			}
			return;
		}
		
		# --- get params from form
		$comment = strip_tags($this->request->getParameter('comment', pString));
		$rank = $this->request->getParameter('rank', pInteger);
		$tags = strip_tags($this->request->getParameter('tags', pString));
		$email = strip_tags($this->request->getParameter('email', pString));
		$name = strip_tags($this->request->getParameter('name', pString));
		$location = strip_tags($this->request->getParameter('location', pString));
		$media1 = $_FILES['media1']['tmp_name'];
		$media1_original_name = $_FILES['media1']['name'];
		
		$errors = [];
		
		if(!$this->request->getUserID() && !$name && !$email){
			$errors["general"] = _t("Please enter your name and email");
		}
		if(!$comment && !$rank && !$tags && !$media1){
			$errors["general"] = _t("Please enter your contribution");
		}
		if(sizeof($errors)){
			$this->view->setVar("form_comment", $comment);
			$this->view->setVar("form_rank", $rank);
			$this->view->setVar("form_tags", $tags);
			$this->view->setVar("form_email", $email);
			$this->view->setVar("form_name", $name);
			$this->view->setVar("form_location", $location);
			$this->view->setVar("item_id", $item_id);
			$this->view->setVar("tablename", $table);
			if($inline_form){
				$this->notification->addNotification($errors["general"], __NOTIFICATION_TYPE_ERROR__);
				$this->request->setActionExtra($item_id);
				$this->__call(caGetDetailForType($table), null);
				#$this->response->setRedirect(caDetailUrl($this->request, $table, $item_id));
			}else{
				$this->view->setVar("errors", $errors);
				$this->render('Details/form_comments_html.php');
			}
		}else{
			# --- if there is already a rank set from this user/IP don't let another
			$t_item_comment = new ca_item_comments();
			$dup_rank_message = "";
			$vb_dup_rank = false;
			if($this->request->getUserID() && $t_item_comment->load(array("row_id" => $item_id, "user_id" => $this->request->getUserID()))){
				if($t_item_comment->get("comment_id")){
					$rank = null;
					$vb_dup_rank = true;
				}
			}
			if($t_item_comment->load(array("row_id" => $item_id, "ip_addr" => $_SERVER['REMOTE_ADDR']))){
				$rank = null;
				$vb_dup_rank = true;
			}
			if($vb_dup_rank){
				$dup_rank_message = " "._t("You can only rate an item once.");
			}
			if(!(($rank > 0) && ($rank <= 5))){
				$rank = null;
			}
			if($comment || $rank || $media1){
				$t_item->addComment($comment, $rank, $this->request->getUserID(), null, $name, $email, ($this->request->config->get("dont_moderate_comments")) ? 1:0, null, array('media1_original_filename' => $media1_original_name), $media1, null, null, null, $location);
			}
			if(is_string($tags) && strlen($tags)){
				$tags = explode(",", $tags);
				foreach($tags as $tag){
					$t_item->addTag(trim($tag), $this->request->getUserID(), null, ($this->request->config->get("dont_moderate_comments")) ? 1:0, null);
				}
			}
			if($comment || $tags || $media1){
				# --- check if email notification should be sent to admin
				if(!$this->request->config->get("dont_email_notification_for_new_comments")){
					# --- send email confirmation
					$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
					$o_view->setVar("comment", $comment);
					$o_view->setVar("tags", $tags);
					$o_view->setVar("name", $name);
					$o_view->setVar("email", $email);
					$o_view->setVar("item", $t_item);
				
				
					# -- generate email subject line from template
					$subject_line = $o_view->render("mailTemplates/admin_comment_notification_subject.tpl");
					
					# -- generate mail text from template - get both the text and the html versions
					$mail_message_text = $o_view->render("mailTemplates/admin_comment_notification.tpl");
					$mail_message_html = $o_view->render("mailTemplates/admin_comment_notification_html.tpl");
				
					caSendmail($this->request->config->get("ca_admin_email"), $this->request->config->get("ca_admin_email"), $subject_line, $mail_message_text, $mail_message_html);
				}
				if($this->request->config->get("dont_moderate_comments")){
					if($inline_form){
						$this->notification->addNotification(_t("Thank you for contributing.").$dup_rank_message, __NOTIFICATION_TYPE_INFO__);
						$this->response->setRedirect(caDetailUrl($this->request, $table, $item_id));
						return;
					}else{
						$this->view->setVar("message", _t("Thank you for contributing.").$dup_rank_message);
						$this->render("Form/reload_html.php");
					}
				}else{
					if($inline_form){
						$this->notification->addNotification(_t("Thank you for contributing.  Your comments will be posted on this page after review by site staff.").$dup_rank_message, __NOTIFICATION_TYPE_INFO__);
						$this->response->setRedirect(caDetailUrl($this->request, $table, $item_id));
						return;
					}else{
						$this->view->setVar("message", _t("Thank you for contributing.  Your comments will be posted on this page after review by site staff.").$dup_rank_message);
						$this->render("Form/reload_html.php");
					}
				}
			}else{
				if($inline_form){
					$this->notification->addNotification(_t("Thank you for your contribution.").$dup_rank_message, __NOTIFICATION_TYPE_INFO__);
					$this->response->setRedirect(caDetailUrl($this->request, $table, $item_id));
					return;
				}else{
					$this->view->setVar("message", _t("Thank you for your contribution.").$dup_rank_message);
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
		$tablename = $this->request->getParameter('tablename', pString);
		$item_id = $this->request->getParameter('item_id', pInteger);
		if(!$t_item = Datamodel::getInstance($tablename, true)) {
			throw new ApplicationException("Invalid table name ".$tablename." for detail");		// shouldn't happen
		}
		if(!$t_item->load($item_id)){
			throw new ApplicationException("ID does not exist");		// shouldn't happen
		}
		
		$this->view->setVar('t_item', $t_item);
		$this->view->setVar('item_id', $item_id);
		$this->view->setVar('tablename', $tablename);
		$this->render("Details/form_share_html.php");
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	public function SendShare() {
		$errors = array();
		$tablename = $this->request->getParameter('tablename', pString);
		$item_id = $this->request->getParameter('item_id', pInteger);
		if(!$t_item = Datamodel::getInstance($tablename, true)) {
			throw new ApplicationException("Invalid table name ".$tablename." for detail");		// shouldn't happen
		}
		if(!$t_item->load($item_id)){
			$this->view->setVar("message", _t("ID does not exist"));
			$this->render("Form/reload_html.php");
			return;
		}
		$o_purifier = caGetHTMLPurifier();
		$to_email = $o_purifier->purify($this->request->getParameter('to_email', pString));
		$from_email = $o_purifier->purify($this->request->getParameter('from_email', pString));
		$from_name = $o_purifier->purify($this->request->getParameter('from_name', pString));
		$subject = $o_purifier->purify($this->request->getParameter('subject', pString));
		$message = $o_purifier->purify($this->request->getParameter('message', pString));
		$security = $this->request->getParameter('security', pInteger);
		$sum = $this->request->getParameter('sum', pInteger);
		
		# --- check vars are set and email addresses are valid
		$to_email_process = array();
		if(!$to_email){
			$errors["to_email"] = _t("Please enter a valid email address or multiple addresses separated by commas");
		}else{
			# --- explode on commas to support multiple addresses - then check each one
			$to_email_process = explode(",", $to_email);
			foreach($to_email_process as $email_to_verify){
				$email_to_verify = trim($email_to_verify);
				if(caCheckEmailAddress($email_to_verify)){
					$to_email_process[$email_to_verify] = "";
				}
			}
		}
		if(!$from_email || !caCheckEmailAddress($from_email)){
			$from_email = "";
			$errors["from_email"] = _t("Please enter a valid email address");
		}
		if(!$from_name){
			$errors["from_name"] = _t("Please enter your name");
		}
		if(!$subject){
			$errors["subject"] = _t("Please enter a subject");
		}
		if(!$message){
			$errors["message"] = _t("Please enter a message");
		}
		if(!$this->request->isLoggedIn()){
			# --- check for security answer if not logged in
			if ((!$security)) {
				$errors["security"] = _t("Please answer the security question.");
			}else{
				if($security != $sum){
					$errors["security"] = _t("Your answer was incorrect, please try again");
				}
			}
		}
		
		$this->view->setVar('t_item', $t_item);
		$this->view->setVar('item_id', $item_id);
		$this->view->setVar('tablename', $tablename);

		if(sizeof($errors) == 0){
			$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
			$o_view->setVar("item", $t_item);
			$o_view->setVar("item_id", $item_id);
			$o_view->setVar("from_name", $from_name);
			$o_view->setVar("message", $message);
			$o_view->setVar("detailConfig", $this->config);
			# -- generate mail text from template - get both html and text versions
			if($tablename == "ca_objects"){
				$mail_message_text = $o_view->render("mailTemplates/share_object_email_text.tpl");
			}else{
				$mail_message_text = $o_view->render("mailTemplates/share_email_text.tpl");
			}
			if($tablename == "ca_objects"){
				$mail_message_html = $o_view->render("mailTemplates/share_object_email_html.tpl");
			}else{
				$mail_message_html = $o_view->render("mailTemplates/share_email_html.tpl");
			}
			
			$media = null;
			if($tablename == "ca_objects"){
				# --- get media for attachment
				$media_version = "";
				# Media representation to email
				# --- version is set in media_display.conf.
				if (method_exists($t_item, 'getPrimaryRepresentationInstance')) {
					if ($t_primary_rep = $t_item->getPrimaryRepresentationInstance()) {
						if (!sizeof($this->opa_access_values) || in_array($t_primary_rep->get('access'), $this->opa_access_values)) { 		// check rep access
							$media = array();
							$rep_display_info = caGetMediaDisplayInfo('email', $t_primary_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
							
							$media_version = $rep_display_info['display_version'];
							
							$media['path'] = $t_primary_rep->getMediaPath('media', $media_version);
							$media_info = $t_primary_rep->getMediaInfo('media');
						
							if(!($media['name'] = $media_info['ORIGINAL_FILENAME'])){
								$media['name'] = $media_info[$media_version]['FILENAME'];
							}
							# --- this is the mimetype of the version being downloaded
							$media["mimetype"] = $media_info[$media_version]['MIMETYPE'];
						}
					}
				}		
			}
			
			if(caSendmail($to_email, array($from_email => $from_name), $subject, $mail_message_text, $mail_message_html, null, null, $media)){
				$this->view->setVar("message", _t("Your email was sent"));
				$this->render("Form/reload_html.php");
				return;
			}else{
				$errors["general"] = _t("Your email could not be sent");
			}
		}
		if(sizeof($errors)){
			# --- there were errors in the form data, so reload form with errors displayed - pass params to preload form
			$this->view->setVar('to_email', $to_email);
			$this->view->setVar('from_email', $from_email);
			$this->view->setVar('from_name', $from_name);
			$this->view->setVar('subject', $subject);
			$this->view->setVar('message', $message);
			$this->view->setVar('errors', $errors);
			
			$errors["general"] = _t("There were errors in your form");
			$this->ShareForm(); 			
		} else {
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
		if (!($value_id = $this->request->getParameter('value_id', pInteger))) { return; }
		$t_attr_val = new ca_attribute_values($value_id);
		if (!$t_attr_val->getPrimaryKey()) { return; }
		$t_attr = new ca_attributes($t_attr_val->get('attribute_id'));
	
		$table_num = Datamodel::getTableNum($this->ops_table_name);
		if ($t_attr->get('table_num') !=  $table_num) { 
			$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2580?r='.urlencode($this->request->getFullUrlPath()));
			return;
		}
		$t_element = new ca_metadata_elements($t_attr->get('element_id'));
		$this->request->setParameter(Datamodel::primaryKey($table_num), $t_attr->get('row_id'));
		
		list($subject_id, $t_subject) = $this->_initView($options);
		$ps_version = $this->request->getParameter('version', pString);
		
		
		if (!$this->_checkAccess($t_subject)) { return false; }
		
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
		$o_view->setVar('archive_name', ($name = trim($t_attr_val->get('value_longtext2'))) ? $name : _t("downloaded_file"));
		
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
	public function DownloadAttributeMedia($options=null) {
		if (!($value_id = $this->request->getParameter('value_id', pInteger))) { return; }
		$t_attr_val = new ca_attribute_values($value_id);
		if (!$t_attr_val->getPrimaryKey()) { return; }
		$t_attr = new ca_attributes($t_attr_val->get('attribute_id'));
	
		$t_element = new ca_metadata_elements($t_attr->get('element_id'));
		$this->request->setParameter(Datamodel::primaryKey($table_num), $t_attr->get('row_id'));
		
		$subject_id = $this->request->getParameter("subject_id", pInteger);
		list($subject_id, $t_subject) = $this->_initView($options);
		$version = $this->request->getParameter('version', pString);
			
		if (!$this->_checkAccess($t_subject)) { return false; }

		
		//
		// Does user have access to bundle?
		//
		if (($this->request->user->getBundleAccessLevel($this->ops_table_name, $t_element->get('element_code'))) < __CA_BUNDLE_ACCESS_READONLY__) {
			$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2580?r='.urlencode($this->request->getFullUrlPath()));
			return;
		}
		
		$t_attr_val->useBlobAsMediaField(true);
		if (!in_array($version, $t_attr_val->getMediaVersions('value_blob'))) { $version = 'original'; }
		
		$o_view = new View($this->request, $this->request->getViewsDirectoryPath().'/bundles/');
		
		// get value
		$t_element = new ca_metadata_elements($t_attr_val->get('element_id'));
		
		// check that value is a media attribute
		if ($t_element->get('datatype') != 16) { 	// 16=media
			return;
		}
		
		$path = $t_attr_val->getMediaPath('value_blob', $version);
		$path_ext = pathinfo($path, PATHINFO_EXTENSION);
		if ($name = trim($t_attr_val->get('value_longtext2'))) {
			$filename = pathinfo($name, PATHINFO_FILENAME);
			$name = "{$filename}.{$path_ext}";
		} else {
			$name = _t("downloaded_file.%1", $path_ext);
		}
		
		$o_view->setVar('archive_path', $path);
		$o_view->setVar('archive_name', $name);
		
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
		$representation_id = $this->request->getParameter('representation_id', pInteger);
		$t_rep = new ca_object_representations($representation_id);
		
		$annotations_raw = array_map(function($v) { $v['locked'] = 1; return $v; }, $t_rep->getAnnotations());
		if($this->request->isLoggedIn()) {
			$t_rep->annotationMode('user');

			$annotations_raw = array_merge($annotations_raw, $t_rep->getAnnotations(array('user_id' => $this->request->getUserID(), 'item_id' => $this->request->getParameter('item_id', pInteger))));
		}
		$annotations = array();

		if (is_array($annotations_raw)) {
			foreach($annotations_raw as $vn_annotation_id => $annotation) {
				$annotations[] = array(
					'annotation_id' => $annotation['annotation_id'],
					'x' => 				caGetOption('x', $annotation, 0, array('castTo' => 'float')),
					'y' => 				caGetOption('y', $annotation, 0, array('castTo' => 'float')),
					'w' => 				caGetOption('w', $annotation, 0, array('castTo' => 'float')),
					'h' => 				caGetOption('h', $annotation, 0, array('castTo' => 'float')),
					'tx' => 			caGetOption('tx', $annotation, 0, array('castTo' => 'float')),
					'ty' => 			caGetOption('ty', $annotation, 0, array('castTo' => 'float')),
					'tw' => 			caGetOption('tw', $annotation, 0, array('castTo' => 'float')),
					'th' => 			caGetOption('th', $annotation, 0, array('castTo' => 'float')),
					'points' => 		caGetOption('points', $annotation, array(), array('castTo' => 'array')),
					'label' => 			caGetOption('label', $annotation, '', array('castTo' => 'string')),
					'description' => 	caGetOption('description', $annotation, '', array('castTo' => 'string')),
					'type' => 			caGetOption('type', $annotation, 'rect', array('castTo' => 'string')),
					'locked' => 		caGetOption('locked', $annotation, '0', array('castTo' => 'string')),
					'options' => 		caGetOption('options', $annotation, array(), array('castTo' => 'array')),
					'key' =>			caGetOption('key', $annotation, null)
				);
			}
		}

		if (is_array($media_scale = $t_rep->getMediaScale('media'))) {
			$annotations[] = $media_scale;
		}

		$this->view->setVar('annotations', $annotations);
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
	public function GetMediaOverlay($options=null) {
		$context = $this->request->getParameter('context', pString);
		
		if ($context == 'gallery') {
			$context_info = [
				'table' => 'ca_objects'
			];
		} elseif (!is_array($context_info = $this->opa_detail_types[$context])) { 
			throw new ApplicationException(_t('Invalid context %1', $context));
		}
		$o_context = ResultContext::getResultContextForLastFind($this->request, $context_info['table']);
		
		if (!($pt_subject = Datamodel::getInstance($subject = $context_info['table']))) {
			throw new ApplicationException(_t('Invalid detail type %1', $this->request->getAction()));
		}
		if (!($subject_id = $this->request->getParameter('id', pInteger))) { $subject_id = $this->request->getParameter($pt_subject->primaryKey(), pInteger); }
		if (!$pt_subject->load($subject_id)) { 
			throw new ApplicationException(_t('Invalid id %1', $subject_id));
		}
		
		if (!($display_type = $this->request->getParameter('display', pString))) { $display_type = 'media_overlay'; }
		$options['display'] = $display_type;
		$options['context'] = $this->request->getParameter('context', pString);
		
		$local_options = (isset($this->opa_detail_types[$options['context']]['options']) && is_array($this->opa_detail_types[$options['context']]['options'])) ? $this->opa_detail_types[$options['context']]['options'] : array();
		$options['captionTemplate'] = caGetOption('representationViewerCaptionTemplate', $local_options, false);
		
		if (!$pt_subject->isReadable($this->request)) { 
			throw new ApplicationException(_t('Cannot view media'));
		}
		
		$merged_options = array_merge($local_options, $options, ['noOverlay' => true, 'showAnnotations' => true, 'checkAccess' => $this->opa_access_values]);
		if($merged_options['inline']){
			$merged_options['noOverlay'] = false;
		}
		
		$merged_options['resultList'] = $o_context->getResultList();
		
		$this->response->addContent(caGetMediaViewerHTML($this->request, caGetMediaIdentifier($this->request), $pt_subject, $merged_options));
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
		$context = $this->request->getParameter('context', pString);
		
		if (!($display_type = $this->request->getParameter('display', pString))) { $display_type = 'media_overlay'; }
	
		switch($context) {
			case 'gallery':
			case 'GetMediaInline':
			case 'GetMediaOverlay':
				$context = ['table' => 'ca_objects'];
				break;
			default:
				if(!is_array($context = $this->opa_detail_types[$context])) { 
					throw new ApplicationException(_t('Invalid context'));
				}
				break;
		}
		
		if (!($pt_subject = Datamodel::getInstance($vs_subject = $context['table']))) {
			throw new ApplicationException(_t('Invalid detail type %1', $this->request->getAction()));
		}
		
		if (!($subject_id = $this->request->getParameter('id', pInteger))) { $subject_id = $this->request->getParameter($pt_subject->primaryKey(), pInteger); }
		if (!$pt_subject->load($subject_id)) { 
			throw new ApplicationException(_t('Invalid id %1', $subject_id));
		}
		
		if (!$pt_subject->isReadable($this->request)) { 
			throw new ApplicationException(_t('Cannot view media'));
		}
	
		$this->response->addContent(caGetMediaViewerData($this->request, caGetMediaIdentifier($this->request), $pt_subject, ['display' => $display_type, 'context' => $context, 'checkAccess' => $this->opa_access_values]));
	}
	# -------------------------------------------------------
	/**
	 * Provide in-viewer search for those that support it (Eg. UniversalViewer)
	 */
	public function SearchMediaData() {
	   $context = $this->request->getParameter('context', pString);
		
		if (!($display_type = $this->request->getParameter('display', pString))) { $display_type = 'media_overlay'; }

		switch($context) {
			case 'gallery':
			case 'GetMediaInline':
			case 'GetMediaOverlay':
				$context = ['table' => 'ca_objects'];
				break;
			default:
				if(!is_array($context = $this->opa_detail_types[$context])) { 
					throw new ApplicationException(_t('Invalid context'));
				}
				break;
		}
	
		if (!($pt_subject = Datamodel::getInstance($vs_subject = $context['table']))) {
			throw new ApplicationException(_t('Invalid detail type %1', $this->request->getAction()));
		}
	
		if (!($subject_id = $this->request->getParameter('id', pInteger))) { $subject_id = $this->request->getParameter($pt_subject->primaryKey(), pInteger); }
		if (!$pt_subject->load($subject_id)) { 
			throw new ApplicationException(_t('Invalid id %1', $subject_id));
		}
	
		if (!$pt_subject->isReadable($this->request)) { 
			throw new ApplicationException(_t('Cannot view media'));
		}

		$this->response->addContent(caSearchMediaData($this->request, caGetMediaIdentifier($this->request), $pt_subject, ['display' => $display_type, 'context' => $this->request->getParameter('context', pString)]));
	}
	# -------------------------------------------------------
	/**
	 * Access to sidecar data (primarily used by 3d viewer)
	 * Will only return sidecars that are images (for 3d textures), MTL files (for 3d OBJ-format files) or 
	 * binary (for GLTF .bin buffer data)
	 */
	public function GetMediaSidecarData() {
		caReturnMediaSidecarData($this->request->getParameter('sidecar_id', pInteger), $this->request->user);
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
