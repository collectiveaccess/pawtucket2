<?php
/* ----------------------------------------------------------------------
 * app/controllers/DetailController.php : controller for object search request handling - processes searches from top search bar
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2014 Whirl-i-Gig
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
 	require_once(__CA_LIB_DIR__."/ca/BaseSearchController.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_LIB_DIR__."/ca/MediaContentLocationIndexer.php");
 	require_once(__CA_APP_DIR__."/helpers/printHelpers.php");
 	require_once(__CA_LIB_DIR__.'/core/Parsers/dompdf/dompdf_config.inc.php');
 	
 	class DetailController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		protected $opa_detail_types = null;
 		
 		/**
 		 *
 		 */
 		protected $config = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 		 	
 		 	if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
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
 			
 			$this->opo_datamodel = Datamodel::load();
 			$va_access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $va_access_values;
 		 	$this->view->setVar("access_values", $va_access_values);
 		 	
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
 			
 			$ps_function = strtolower($ps_function);
 			$ps_id = urldecode($this->request->getActionExtra()); 
 			if (!isset($this->opa_detail_types[$ps_function]) || !isset($this->opa_detail_types[$ps_function]['table']) || (!($vs_table = $this->opa_detail_types[$ps_function]['table']))) {
 				// invalid detail type – throw error
 				die("Invalid detail type");
 			}
 			
 			$t_table = $this->opo_datamodel->getInstanceByTableName($vs_table, true);
 			if (($vb_use_identifiers_in_urls = caUseIdentifiersInUrls()) && (substr($ps_id, 0, 3) == "id:")) {
 				$va_tmp = explode(":", $ps_id);
 				$ps_id = (int)$va_tmp[1];
 				$vb_use_identifiers_in_urls = false;
 			}
 			if (!$t_table->load(($vb_use_identifiers_in_urls && $t_table->getProperty('ID_NUMBERING_ID_FIELD')) ? (($t_table->hasField('deleted')) ? array($t_table->getProperty('ID_NUMBERING_ID_FIELD') => $ps_id, 'deleted' => 0) : array($t_table->getProperty('ID_NUMBERING_ID_FIELD') => $ps_id)) : (($t_table->hasField('deleted')) ? array($t_table->primaryKey() => (int)$ps_id, 'deleted' => 0) : array($t_table->primaryKey() => (int)$ps_id)))) {
 				// invalid id - throw error
 				die("Invalid id");
 			} 
 			
 			// Printables
 		 	// 	merge displays with drop-in print templates
 		 	//
			$va_export_options = caGetAvailablePrintTemplates('summary', array('table' => $t_table->tableName())); 
			$this->view->setVar('export_formats', $va_export_options);
			
			$va_options = array();
			foreach($va_export_options as $vn_i => $va_format_info) {
				$va_options[$va_format_info['name']] = $va_format_info['code'];
			}
			// Get current display list
			$t_display = new ca_bundle_displays();
 			foreach(caExtractValuesByUserLocale($t_display->getBundleDisplays(array('table' => $this->ops_tablename, 'user_id' => $this->request->getUserID(), 'access' => __CA_BUNDLE_DISPLAY_READ_ACCESS__, 'checkAccess' => caGetUserAccessValues($this->request)))) as $va_display) {
 				$va_options[$va_display['name']] = "_display_".$va_display['display_id'];
 			}
 			ksort($va_options);
 			$this->view->setVar('export_format_select', caHTMLSelect('export_format', $va_options, array('class' => 'searchToolsSelect'), array('value' => $this->view->getVar('current_export_format'), 'width' => '150px')));
 		
		
 			
			#
 			# Enforce access control
 			#
 			if(sizeof($this->opa_access_values) && ($t_table->hasField('access')) && (!in_array($t_table->get("access"), $this->opa_access_values))){
  				$this->notification->addNotification(_t("This item is not available for view"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": ".$t_table->getTypeName().": ".$t_table->get('preferred_labels').(($vs_idno = $t_table->get($t_table->getProperty('ID_NUMBERING_ID_FIELD'))) ? " [{$vs_idno}]" : ""));
 			
 			$vs_type = $t_table->getTypeCode();
 			
 			$this->view->setVar('detailType', $vs_table);
 			$this->view->setVar('item', $t_table);
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
 			
 			$this->view->setVar('previousID', $vn_previous_id = $o_context->getPreviousID($t_table->getPrimaryKey()));
 			$this->view->setVar('nextID', $vn_next_id = $o_context->getNextID($t_table->getPrimaryKey()));
 			$this->view->setVar('previousURL', caDetailUrl($this->request, $vs_table, $vn_previous_id));
 			$this->view->setVar('nextURL', caDetailUrl($this->request, $vs_table, $vn_next_id));
 			$this->view->setVar('resultsURL', ResultContext::getResultsUrlForLastFind($this->request, $vs_table));
 			
 			$va_options = (isset($this->opa_detail_types[$ps_function]['options']) && is_array($this->opa_detail_types[$ps_function]['options'])) ? $this->opa_detail_types[$ps_function]['options'] : array();
 			
 			$this->view->setVar('previousLink', ($vn_previous_id > 0) ? caDetailLink($this->request, caGetOption('previousLink', $va_options, _t('Previous')), '', $vs_table, $vn_previous_id) : '');
 			$this->view->setVar('nextLink', ($vn_next_id > 0) ? caDetailLink($this->request, caGetOption('nextLink', $va_options, _t('Next')), '', $vs_table, $vn_next_id) : '');
 			$this->view->setVar('resultsLink', ResultContext::getResultsLinkForLastFind($this->request, $vs_table, caGetOption('resultsLink', $va_options, _t('Back'))));
 			
 			$this->view->setVar('commentsEnabled', (bool)$va_options['enableComments']);
 			
 			//
 			//
 			//
 			if (method_exists($t_table, 'getPrimaryRepresentationInstance')) {
 				if($pn_representation_id = $this->request->getParameter('representation_id', pInteger)){
 					$t_representation = $this->opo_datamodel->getInstanceByTableName("ca_object_representations", true);
 					$t_representation->load($pn_representation_id);
 				}else{
 					$t_representation = $t_table->getPrimaryRepresentationInstance(array("checkAccess" => $this->opa_access_values));
 				}
				if ($t_representation) {
					$this->view->setVar("t_representation", $t_representation);
					$this->view->setVar("representation_id", $t_representation->get("representation_id"));
				}else{
					$t_representation = $this->opo_datamodel->getInstanceByTableName("ca_object_representations", true);
				}
				$this->view->setVar("representationViewer", caObjectDetailMedia($this->request, $t_table->getPrimaryKey(), $t_representation, $t_table, array_merge(caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE')), array("primaryOnly" => caGetOption('representationViewerPrimaryOnly', $va_options, false), "dontShowPlaceholder" => caGetOption('representationViewerDontShowPlaceholder', $va_options, false)))));
			}
			//
			// map
			//
			if (!is_array($va_map_attributes = caGetOption('map_attributes', $va_options, array())) || !sizeof($va_map_attributes)) {
				if ($vs_map_attribute = caGetOption('map_attribute', $va_options, false)) { $va_map_attributes = array($vs_map_attribute); }
			}
			
			$this->view->setVar("map", "");
			if(is_array($va_map_attributes) && sizeof($va_map_attributes)) {
				$o_map = new GeographicMap((($vn_width = caGetOption('map_width', $va_options, false)) ? $vn_width : 285), (($vn_height = caGetOption('map_height', $va_options, false)) ? $vn_height : 200), 'map');
					
				$vn_mapped_count = 0;	
				foreach($va_map_attributes as $vs_map_attribute) {
					if ($t_table->get($vs_map_attribute)){
						$o_map->mapFrom($t_table, $vs_map_attribute);
						$vn_mapped_count++;
					}
				}
				
				if ($vn_mapped_count > 0) { 
					$this->view->setVar("map", $o_map->render('HTML', array('zoomLevel' => caGetOption('zoom_level', $va_options, 12))));
				}
			}
			
 			//
 			// comments, tags, rank
 			//
 			$this->view->setVar('averageRank', $t_table->getAverageRating(true));
 			$this->view->setVar('numRank', $t_table->getNumRatings(true));
 			#
 			# User-generated comments, tags and ratings
 			#
 			$va_user_comments = $t_table->getComments(null, true);
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
 			
 			$va_user_tags = $t_table->getTags(null, true);
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
 			
 			$this->view->setVar("itemComments", caDetailItemComments($this->request, $t_table->getPrimaryKey(), $t_table, $va_comments, $va_tags));
 			
 			//
 			// share link
 			//
 			$this->view->setVar("shareLink", "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'ShareForm', array("tablename" => $t_table->tableName(), "item_id" => $t_table->getPrimaryKey()))."\"); return false;'>Share</a>");

 			// find view
 			//		first look for type-specific view
 			if (!$this->viewExists($vs_path = "Details/{$vs_table}_{$vs_type}_html.php")) {
 				// If no type specific view use the default
 				$vs_path = "Details/{$vs_table}_default_html.php";
 			}
 			
 	
			switch($ps_view = $this->request->getParameter('view', pString)) {
 				case 'pdf':
 					$this->_genExport($t_table, $this->request->getParameter("export_format", pString), 'Detail', 'Detail');
 					break;
 				default:
 					//
					// Tag substitution
					//
					// Views can contain tags in the form {{{tagname}}}. Some tags, such as "itemType" and "detailType" are defined by
					// the detail controller. More usefully, you can pull data from the item being detailed by using a valid "get" expression
					// as a tag (Eg. {{{ca_objects.idno}}}. Even more usefully for some, you can also use a valid bundle display template
					// (see http://docs.collectiveaccess.org/wiki/Bundle_Display_Templates) as a tag. The template will be evaluated in the 
					// context of the item being detailed.
					//
					$va_defined_vars = array_keys($this->view->getAllVars());		// get list defined vars (we don't want to copy over them)
					$va_tag_list = $this->getTagListForView($vs_path);				// get list of tags in view
					foreach($va_tag_list as $vs_tag) {
						if (in_array($vs_tag, $va_defined_vars)) { continue; }
						if ((strpos($vs_tag, "^") !== false) || (strpos($vs_tag, "<") !== false)) {
							$this->view->setVar($vs_tag, $t_table->getWithTemplate($vs_tag, array('checkAccess' => $this->opa_access_values)));
						} elseif (strpos($vs_tag, ".") !== false) {
							$this->view->setVar($vs_tag, $t_table->get($vs_tag, array('checkAccess' => $this->opa_access_values)));
						} else {
							$this->view->setVar($vs_tag, "?{$vs_tag}");
						}
					}
 					$this->render($vs_path);
 					break;
 			}
 		}
 		# -------------------------------------------------------
 		/**
 		 * Returns content for overlay containing details for object representation
 		 *
 		 * Expects the following request parameters: 
 		 *		object_id = the id of the ca_objects record to display
 		 *		representation_id = the id of the ca_object_representations record to display; the representation must belong to the specified object
 		 *
 		 *	Optional request parameters:
 		 *		version = The version of the representation to display. If omitted the display version configured in media_display.conf is used
 		 *		order_item_id = ca_commerce_order_items.item_id value to limit representation display to
 		 *
 		 */ 
 		public function GetRepresentationInfo() {
 			$pn_object_id 			= $this->request->getParameter('object_id', pInteger);
 			$pn_representation_id 	= $this->request->getParameter('representation_id', pInteger);
 			if (!$ps_display_type 	= trim($this->request->getParameter('display_type', pString))) { $ps_display_type = 'media_overlay'; }
 			if (!$ps_containerID 	= trim($this->request->getParameter('containerID', pString))) { $ps_containerID = 'caMediaPanelContentArea'; }
 			
 			if(!$pn_object_id) { $pn_object_id = 0; }
 			$t_rep = new ca_object_representations($pn_representation_id);
 			if (!$t_rep->getPrimaryKey()) { 
 				$this->postError(1100, _t('Invalid object/representation'), 'DetailController->GetRepresentationInfo');
 				return;
 			}
 			$va_opts = array('display' => $ps_display_type, 'object_id' => $pn_object_id, 'containerID' => $ps_containerID, 'access' => caGetUserAccessValues($this->request));
 			if (strlen($vs_use_book_viewer = $this->request->getParameter('use_book_viewer', pInteger))) { $va_opts['use_book_viewer'] = (bool)$vs_use_book_viewer; }

			$vs_output = $t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts);
			if ($this->request->getParameter('include_tool_bar', pInteger)) {
				$vs_output = "<div class='repViewerContCont'><div id='cont{$vn_rep_id}' class='repViewerCont'>".$vs_output.caRepToolbar($this->request, $t_rep, $pn_object_id)."</div></div>";
			}

 			$this->response->addContent($vs_output);
 		}
		# -------------------------------------------------------
 		/**
 		 * 
 		 */ 
 		public function GetPageListAsJSON() {
 			if (!($vs_table = $this->request->getActionExtra())) { $vs_table = 'ca_objects'; }
 			if (!($t_subject = $this->opo_datamodel->getInstanceByTableName($vs_table, true))) { 
 				$this->postError(1100, _t('Invalid table'), 'DetailController->GetPage');
 				return;
 			}
 			$pn_subject_id = $this->request->getParameter($t_subject->primaryKey(), pInteger);
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			$pn_value_id = $this->request->getParameter('value_id', pInteger);
 			$ps_content_mode = $this->request->getParameter('content_mode', pString);
 			
 			$t_subject->load($pn_subject_id);
 			
 			$vs_page_cache_key = md5($pn_subject_id.'/'.$pn_representation_id.'/'.$pn_value_id);
 			
 			$this->view->setVar('page_cache_key', $vs_page_cache_key);
 			$this->view->setVar('t_subject', $t_subject);
 			$this->view->setVar('t_representation', new ca_object_representations($pn_representation_id));
 			$this->view->setVar('t_attribute_value', new ca_attribute_values($pn_value_id));
 			$this->view->setVar('content_mode', $ps_content_mode);
 			
 			$va_page_list_cache = $this->request->session->getVar('caDocumentViewerPageListCache');
 			
 			$va_pages = $va_page_list_cache[$vs_page_cache_key];
 			if (!isset($va_pages)) {
 				// Page cache not set?
 				$this->postError(1100, _t('Invalid object/representation'), 'DetailController->GetPage');
 				return;
 			}
 			
 			$va_section_cache = $this->request->session->getVar('caDocumentViewerSectionCache');
 			$this->view->setVar('pages', $va_pages);
 			$this->view->setVar('sections', $va_section_cache[$vs_page_cache_key]);
 			
 			$this->view->setVar('is_searchable', MediaContentLocationIndexer::hasIndexing('ca_object_representations', $pn_representation_id));
 			
 			$this->render('bundles/media_page_list_json.php');
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
		 * Download all media attached to specified object (not necessarily open for editing)
		 * Includes all representation media attached to the specified object + any media attached to oter
		 * objects in the same object hierarchy as the specified object. Used by the book viewer interfacce to 
		 * initiate a download.
		 */ 
		public function DownloadMedia() {
			if (!caObjectsDisplayDownloadLink($this->request)) {
				$this->postError(1100, _t('Cannot download media'), 'DetailController->DownloadMedia');
				return;
			}
			$pn_object_id = $this->request->getParameter('object_id', pInteger);
			$pn_value_id = $this->request->getParameter('value_id', pInteger);
			if ($pn_value_id) {
 				return $this->DownloadAttributeMedia();
 			}
			$t_object = new ca_objects($pn_object_id);
			if (!($vn_object_id = $t_object->getPrimaryKey())) { return; }
			
			$ps_version = $this->request->getParameter('version', pString);
			
			if (!$ps_version) { $ps_version = 'original'; }
			$this->view->setVar('version', $ps_version);
			
			$va_ancestor_ids = $t_object->getHierarchyAncestors(null, array('idsOnly' => true, 'includeSelf' => true));
			if ($vn_parent_id = array_pop($va_ancestor_ids)) {
				$t_object->load($vn_parent_id);
				array_unshift($va_ancestor_ids, $vn_parent_id);
			}
			
			$va_child_ids = $t_object->getHierarchyChildren(null, array('idsOnly' => true));
			
			foreach($va_ancestor_ids as $vn_id) {
				array_unshift($va_child_ids, $vn_id);
			}
			
			$vn_c = 1;
			$va_file_names = array();
			$va_file_paths = array();
			
			foreach($va_child_ids as $vn_object_id) {
				$t_object = new ca_objects($vn_object_id);
				if (!$t_object->getPrimaryKey()) { continue; }
				
				$va_reps = $t_object->getRepresentations(array($ps_version));
				$vs_idno = $t_object->get('idno');
				
				foreach($va_reps as $vn_representation_id => $va_rep) {
					$va_rep_info = $va_rep['info'][$ps_version];
					$vs_idno_proc = preg_replace('![^A-Za-z0-9_\-]+!', '_', $vs_idno);
					switch($this->request->user->getPreference('downloaded_file_naming')) {
						case 'idno':
							$vs_file_name = $vs_idno_proc.'_'.$vn_c.'.'.$va_rep_info['EXTENSION'];
							break;
						case 'idno_and_version':
							$vs_file_name = $vs_idno_proc.'_'.$ps_version.'_'.$vn_c.'.'.$va_rep_info['EXTENSION'];
							break;
						case 'idno_and_rep_id_and_version':
							$vs_file_name = $vs_idno_proc.'_representation_'.$vn_representation_id.'_'.$ps_version.'.'.$va_rep_info['EXTENSION'];
							break;
						case 'original_name':
						default:
							if ($va_rep['info']['original_filename']) {
								$va_tmp = explode('.', $va_rep['info']['original_filename']);
								if (sizeof($va_tmp) > 1) { 
									if (strlen($vs_ext = array_pop($va_tmp)) < 3) {
										$va_tmp[] = $vs_ext;
									}
								}
								$vs_file_name = join('_', $va_tmp); 					
							} else {
								$vs_file_name = $vs_idno_proc.'_representation_'.$vn_representation_id.'_'.$ps_version;
							}
							
							if (isset($va_file_names[$vs_file_name.'.'.$va_rep_info['EXTENSION']])) {
								$vs_file_name.= "_{$vn_c}";
							}
							$vs_file_name .= '.'.$va_rep_info['EXTENSION'];
							break;
					} 
					
					$va_file_names[$vs_file_name] = true;
					$this->view->setVar('version_download_name', $vs_file_name);
				
					//
					// Perform metadata embedding
					$t_rep = new ca_object_representations($va_rep['representation_id']);
					if (!($vs_path = caEmbedMetadataIntoRepresentation($t_object, $t_rep, $ps_version))) {
						$vs_path = $t_rep->getMediaPath('media', $ps_version);
					}
					$va_file_paths[$vs_path] = $vs_file_name;
					
					$vn_c++;
				}
			}
			
			if (sizeof($va_file_paths) > 1) {
				if (!($vn_limit = ini_get('max_execution_time'))) { $vn_limit = 30; }
				set_time_limit($vn_limit * 2);
				$o_zip = new ZipFile();
				foreach($va_file_paths as $vs_path => $vs_name) {
					$o_zip->addFile($vs_path, $vs_name, null, array('compression' => 0));	// don't try to compress
				}
				$this->view->setVar('archive_path', $vs_path = $o_zip->output(ZIPFILE_FILEPATH));
				$this->view->setVar('archive_name', preg_replace('![^A-Za-z0-9\.\-]+!', '_', $t_object->get('idno')).'.zip');
				
				$this->response->sendHeaders();
				$vn_rc = $this->render('Details/object_download_media_binary.php');
				$this->response->sendContent();
				
				if ($vs_path) { unlink($vs_path); }
			} else {
				foreach($va_file_paths as $vs_path => $vs_name) {
					$this->view->setVar('archive_path', $vs_path);
					$this->view->setVar('archive_name', $vs_name);
				}
				$this->response->sendHeaders();
				$vn_rc = $this->render('Details/object_download_media_binary.php');
				$this->response->sendContent();
			}
			
			return $vn_rc;
		}
		# -------------------------------------------------------
		/**
		 * Download single representation from currently open object
		 */ 
		public function DownloadRepresentation() {
			if (!caObjectsDisplayDownloadLink($this->request)) {
				$this->postError(1100, _t('Cannot download media'), 'DetailController->DownloadMedia');
				return;
			}
			$vn_object_id = $this->request->getParameter('object_id', pInteger);
			$t_object = new ca_objects($vn_object_id);
			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
			$ps_version = $this->request->getParameter('version', pString);
			
			$this->view->setVar('representation_id', $pn_representation_id);
			$t_rep = new ca_object_representations($pn_representation_id);
			$this->view->setVar('t_object_representation', $t_rep);
			
			$va_versions = $t_rep->getMediaVersions('media');
			
			if (!in_array($ps_version, $va_versions)) { $ps_version = $va_versions[0]; }
			$this->view->setVar('version', $ps_version);
			
			$va_rep_info = $t_rep->getMediaInfo('media', $ps_version);
			$this->view->setVar('version_info', $va_rep_info);
			
			$va_info = $t_rep->getMediaInfo('media');
			$vs_idno_proc = preg_replace('![^A-Za-z0-9_\-]+!', '_', $t_object->get('idno'));
			switch($this->request->user->getPreference('downloaded_file_naming')) {
				case 'idno':
					$this->view->setVar('version_download_name', $vs_idno_proc.'.'.$va_rep_info['EXTENSION']);
					break;
				case 'idno_and_version':
					$this->view->setVar('version_download_name', $vs_idno_proc.'_'.$ps_version.'.'.$va_rep_info['EXTENSION']);
					break;
				case 'idno_and_rep_id_and_version':
					$this->view->setVar('version_download_name', $vs_idno_proc.'_representation_'.$pn_representation_id.'_'.$ps_version.'.'.$va_rep_info['EXTENSION']);
					break;
				case 'original_name':
				default:
					if ($va_info['ORIGINAL_FILENAME']) {
						$va_tmp = explode('.', $va_info['ORIGINAL_FILENAME']);
						if (sizeof($va_tmp) > 1) { 
							if (strlen($vs_ext = array_pop($va_tmp)) < 3) {
								$va_tmp[] = $vs_ext;
							}
						}
						$this->view->setVar('version_download_name', str_replace(" ", "_", join('_', $va_tmp).'.'.$va_rep_info['EXTENSION']));					
					} else {
						$this->view->setVar('version_download_name', $vs_idno_proc.'_representation_'.$pn_representation_id.'_'.$ps_version.'.'.$va_rep_info['EXTENSION']);
					}
					break;
			} 
			
			//
			// Perform metadata embedding
			if ($vs_path = caEmbedMetadataIntoRepresentation($t_object, $t_rep, $ps_version)) {
				$this->view->setVar('version_path', $vs_path);
			} else {
				$this->view->setVar('version_path', $t_rep->getMediaPath('media', $ps_version));
			}
			$this->response->sendHeaders();
			$vn_rc = $this->render('Details/object_representation_download_binary.php');
			$this->response->sendContent();
			if ($vs_path) { unlink($vs_path); }
			return $vn_rc;
		}
		# -------------------------------------------------------
 		# 
 		# -------------------------------------------------------
 		/**
 		 * Returns content for overlay containing details for media attribute
 		 *
 		 * Expects the following request parameters: 
 		 *		value_id = the id of the attribute value (ca_attribute_values) record to display
 		 *
 		 *	Optional request parameters:
 		 *		version = The version of the representation to display. If omitted the display version configured in media_display.conf is used
 		 *
 		 */ 
 		public function GetMediaInfo() {
 			$pn_representation_id 	= $this->request->getParameter('representation_id', pInteger);
 			$pn_value_id 	= $this->request->getParameter('value_id', pInteger);
 			if ($pn_value_id) {
 				$t_rep = new ca_object_representations();
 				
 				$t_attr_val = new ca_attribute_values($pn_value_id);
 				$t_attr = new ca_attributes($t_attr_val->get('attribute_id'));
 				$t_subject = $this->opo_datamodel->getInstanceByTableNum($t_attr->get('table_num'), true);
 				$t_subject->load($t_attr->get('row_id'));
 				
				$va_rep_display_info = caGetMediaDisplayInfo('media_overlay', $t_attr_val->getMediaInfo('value_blob', 'INPUT', 'MIMETYPE'));
 			
				// check subject_id here
 				$va_opts = array('t_attribute_value' => $t_attr_val, 'display' => 'media_overlay', 't_subject' => $t_subject, 'containerID' => 'caMediaPanelContentArea');
 				if (strlen($vs_use_book_viewer = $this->request->getParameter('use_book_viewer', pInteger))) { $va_opts['use_book_viewer'] = (bool)$vs_use_book_viewer; }

 				$this->response->addContent(caGetMediaViewerHTMLBundle($this->request, $va_opts));
 			} elseif ($pn_representation_id) { 
 				$t_rep = new ca_object_representations($pn_representation_id);
 			
 				$t_subject = new ca_objects($vn_subject_id = $this->request->getParameter('object_id', pInteger));
				if(!$vn_subject_id) { 
					if (is_array($va_subject_ids = $t_rep->get($t_subject->tableName().'.'.$t_subject->primaryKey(), array('returnAsArray' => true))) && sizeof($va_subject_ids)) {
						$vn_subject_id = array_shift($va_subject_ids);
					} else {
						$this->postError(1100, _t('Invalid object/representation'), 'ObjectEditorController->GetRepresentationInfo');
						return;
					}
				}
 				$va_opts = array('display' => 'media_overlay', 't_subject' => $t_subject, 't_representation' => $t_rep, 'containerID' => 'caMediaPanelContentArea');
 				if (strlen($vs_use_book_viewer = $this->request->getParameter('use_book_viewer', pInteger))) { $va_opts['use_book_viewer'] = (bool)$vs_use_book_viewer; }
 
 				$this->response->addContent(caGetMediaViewerHTMLBundle($this->request, $va_opts));
 			} else {
 				//
 			}
 			//$pn_value_id 	= $this->request->getParameter('value_id', pInteger);
 			//$this->response->addContent(caGetMediaViewerHTMLBundle($this->request, array('display' => 'media_overlay', 't_attribute_value' => $pn_value_id, 'containerID' => 'caMediaPanelContentArea')));
 		}
		# ------------------------------------------------------
		/**
		 * 
		 */
		public function GetMediaAttributeViewerHTMLBundle($po_request, $pa_options=null) {
			$va_access_values = (isset($pa_options['access']) && is_array($pa_options['access'])) ? $pa_options['access'] : array();	
			$vs_display_type = (isset($pa_options['display']) && $pa_options['display']) ? $pa_options['display'] : 'media_overlay';	
			$vs_container_dom_id = (isset($pa_options['containerID']) && $pa_options['containerID']) ? $pa_options['containerID'] : null;	
			
			$pn_value_id = (isset($pa_options['value_id']) && $pa_options['value_id']) ? $pa_options['value_id'] : null;
			
			$t_attr_val = new ca_attribute_values();
			$t_attr_val->load($pn_value_id);
			$t_attr_val->useBlobAsMediaField(true);
			
			$o_view = new View($po_request, $po_request->getViewsDirectoryPath().'/bundles/');
			
			$o_view->setVar('containerID', $vs_container_dom_id);
			
			$va_rep_display_info = caGetMediaDisplayInfo('media_overlay', $t_attr_val->getMediaInfo('value_blob', 'INPUT', 'MIMETYPE'));
			$va_rep_display_info['poster_frame_url'] = $t_attr_val->getMediaUrl('value_blob', $va_rep_display_info['poster_frame_version']);
			
			$o_view->setVar('display_options', $va_rep_display_info);
			$o_view->setVar('representation_id', $pn_representation_id);
			$o_view->setVar('t_attribute_value', $t_attr_val);
			$o_view->setVar('versions', $va_versions = $t_attr_val->getMediaVersions('value_blob'));
			
			$t_media = new Media();
	
			$ps_version 	= $po_request->getParameter('version', pString);
			if (!in_array($ps_version, $va_versions)) { 
				if (!($ps_version = $va_rep_display_info['display_version'])) { $ps_version = null; }
			}
			$o_view->setVar('version', $ps_version);
			$o_view->setVar('version_info', $t_attr_val->getMediaInfo('value_blob', $ps_version));
			$o_view->setVar('version_type', $t_media->getMimetypeTypename($t_attr_val->getMediaInfo('value_blob', $ps_version, 'MIMETYPE')));
			$o_view->setVar('mimetype', $t_attr_val->getMediaInfo('value_blob', 'INPUT', 'MIMETYPE'));			
			
			
			return $o_view->render('media_attribute_viewer_html.php');
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
 			# --- inline is passed to indicate form appears embedded in detail page, not in overlay
			$vn_inline_form = $this->request->getParameter("inline", pInteger);
			if(!$t_item = $this->opo_datamodel->getInstanceByTableName($this->request->getParameter("tablename", pString), true)) {
 				die("Invalid table name ".$this->request->getParameter("tablename", pString)." for saving comment");
 			}
			$ps_table = $this->request->getParameter("tablename", pString);
			if(!($vn_item_id = $this->request->getParameter("item_id", pInteger))){
 				if($vn_inline_form){
 					$this->notification->addNotification(_t("Invalid ID"), __NOTIFICATION_TYPE_ERROR__);
 					$this->response->setRedirect(caDetailUrl($this->request, $ps_table, $vn_item_id));
 				}else{
 					$this->view->setVar("message", _t("Invalid ID"));
 					$this->render("Form/reload_html.php");
 				}
 				return;
 			}
 			if(!$t_item->load($vn_item_id)){
  				if($vn_inline_form){
 					$this->notification->addNotification(_t("ID does not exist"), __NOTIFICATION_TYPE_ERROR__);
 					$this->response->setRedirect(caDetailUrl($this->request, $ps_table, $vn_item_id));
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
					#$this->response->setRedirect(caDetailUrl($this->request, $ps_table, $vn_item_id));
				}else{
					$this->view->setVar("errors", $va_errors);
					$this->render('Details/form_comments_html.php');
				}
			}else{
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
							$this->notification->addNotification(_t("Thank you for contributing."), __NOTIFICATION_TYPE_INFO__);
 							$this->response->setRedirect(caDetailUrl($this->request, $ps_table, $vn_item_id));
							return;
						}else{
							$this->view->setVar("message", _t("Thank you for contributing."));
 							$this->render("Form/reload_html.php");
						}
 					}else{
 						if($vn_inline_form){
							$this->notification->addNotification(_t("Thank you for contributing.  Your comments will be posted on this page after review by site staff."), __NOTIFICATION_TYPE_INFO__);
 							$this->response->setRedirect(caDetailUrl($this->request, $ps_table, $vn_item_id));
							return;
						}else{
							$this->view->setVar("message", _t("Thank you for contributing.  Your comments will be posted on this page after review by site staff."));
 							$this->render("Form/reload_html.php");
						}
 					}
 				}else{
 					if($vn_inline_form){
						$this->notification->addNotification(_t("Thank you for your contribution."), __NOTIFICATION_TYPE_INFO__);
 						$this->response->setRedirect(caDetailUrl($this->request, $ps_table, $vn_item_id));
						return;
					}else{
						$this->view->setVar("message", _t("Thank you for your contribution."));
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
			if(!$t_item = $this->opo_datamodel->getInstanceByTableName($ps_tablename, true)) {
 				die("Invalid table name ".$ps_tablename." for detail");		// shouldn't happen
 			}
			if(!$t_item->load($pn_item_id)){
  				die("ID does not exist");		// shouldn't happen
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
			if(!$t_item = $this->opo_datamodel->getInstanceByTableName($ps_tablename, true)) {
 				die("Invalid table name ".$ps_tablename." for detail");		// shouldn't happen
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
					$vs_mail_message_html = $o_view->render("/mailTemplates/share_object_email_html.tpl");
				}else{
					$vs_mail_message_html = $o_view->render("/mailTemplates/share_email_html.tpl");
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
 		/**
		 * Generate  export file of current result
		 */
		protected function _genExport($pt_subject, $ps_template, $ps_output_filename, $ps_title=null) {
			$this->view->setVar('t_subject', $pt_subject);
			
			if (substr($ps_template, 0, 5) === '_pdf_') {
				$va_template_info = caGetPrintTemplateDetails('summary', substr($ps_template, 5));
			} elseif (substr($ps_template, 0, 9) === '_display_') {
				$vn_display_id = substr($ps_template, 9);
				$t_display = new ca_bundle_displays($vn_display_id);
				
				if ($vn_display_id && ($t_display->haveAccessToDisplay($this->request->getUserID(), __CA_BUNDLE_DISPLAY_READ_ACCESS__))) {
					$this->view->setVar('t_display', $t_display);
					$this->view->setVar('display_id', $vn_display_id);
				
					$va_display_list = array();
					$va_placements = $t_display->getPlacements(array('settingsOnly' => true));
					foreach($va_placements as $vn_placement_id => $va_display_item) {
						$va_settings = caUnserializeForDatabase($va_display_item['settings']);
					
						// get column header text
						$vs_header = $va_display_item['display'];
						if (isset($va_settings['label']) && is_array($va_settings['label'])) {
							$va_tmp = caExtractValuesByUserLocale(array($va_settings['label']));
							if ($vs_tmp = array_shift($va_tmp)) { $vs_header = $vs_tmp; }
						}
					
						$va_display_list[$vn_placement_id] = array(
							'placement_id' => $vn_placement_id,
							'bundle_name' => $va_display_item['bundle_name'],
							'display' => $vs_header,
							'settings' => $va_settings
						);
					}
					$this->view->setVar('placements', $va_display_list);
				} else {
					$this->postError(3100, _t("Invalid format %1", $ps_template),"DetailController->_genExport()");
					return;
				}
				$va_template_info = caGetPrintTemplateDetails('summary', 'summary');
			} else {
				$this->postError(3100, _t("Invalid format %1", $ps_template),"DetailController->_genExport()");
				return;
			}
			
			//
			// PDF output
			//
			if (!is_array($va_template_info)) {
				$this->postError(3110, _t("Could not find view for PDF"),"DetailController->_genExport()");
				return;
			}
			
			//
			// Tag substitution
			//
			// Views can contain tags in the form {{{tagname}}}. Some tags, such as "itemType" and "detailType" are defined by
			// the detail controller. More usefully, you can pull data from the item being detailed by using a valid "get" expression
			// as a tag (Eg. {{{ca_objects.idno}}}. Even more usefully for some, you can also use a valid bundle display template
			// (see http://docs.collectiveaccess.org/wiki/Bundle_Display_Templates) as a tag. The template will be evaluated in the 
			// context of the item being detailed.
			//
			$va_defined_vars = array_keys($this->view->getAllVars());		// get list defined vars (we don't want to copy over them)
			$va_tag_list = $this->getTagListForView($va_template_info['path']);				// get list of tags in view
			foreach($va_tag_list as $vs_tag) {
				if (in_array($vs_tag, $va_defined_vars)) { continue; }
				if ((strpos($vs_tag, "^") !== false) || (strpos($vs_tag, "<") !== false)) {
					$this->view->setVar($vs_tag, $pt_subject->getWithTemplate($vs_tag, array('checkAccess' => $this->opa_access_values)));
				} elseif (strpos($vs_tag, ".") !== false) {
					$this->view->setVar($vs_tag, $pt_subject->get($vs_tag, array('checkAccess' => $this->opa_access_values)));
				} else {
					$this->view->setVar($vs_tag, "?{$vs_tag}");
				}
			}
			
			try {
				$this->view->setVar('base_path', $vs_base_path = pathinfo($va_template_info['path'], PATHINFO_DIRNAME));
				$this->view->addViewPath(array($vs_base_path, "{$vs_base_path}/local"));
			
				$vs_content = $this->render($va_template_info['path']);
				$o_dompdf = new DOMPDF();
				$o_dompdf->load_html($vs_content);
				$o_dompdf->set_paper(caGetOption('pageSize', $va_template_info, 'letter'), caGetOption('pageOrientation', $va_template_info, 'portrait'));
				$o_dompdf->set_base_path(caGetPrintTemplateDirectoryPath('summary'));
				$o_dompdf->render();
				$o_dompdf->stream(caGetOption('filename', $va_template_info, 'export_results.pdf'));

				$vb_printed_properly = true;
			} catch (Exception $e) {
				$vb_printed_properly = false;
				$this->postError(3100, _t("Could not generate PDF"),"DetailController->_genExport()");
			}
				
			return;
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
 		
 			$vn_table_num = $this->opo_datamodel->getTableNum($this->ops_table_name);
 			if ($t_attr->get('table_num') !=  $vn_table_num) { 
 				$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2580?r='.urlencode($this->request->getFullUrlPath()));
 				return;
 			}
 			$t_element = new ca_metadata_elements($t_attr->get('element_id'));
 			$this->request->setParameter($this->opo_datamodel->getTablePrimaryKeyName($vn_table_num), $t_attr->get('row_id'));
 			
 			list($vn_subject_id, $t_subject) = $this->_initView($pa_options);
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
 			
 			$o_view->setVar('file_path', $t_attr_val->getFilePath('value_blob'));
 			$o_view->setVar('file_name', ($vs_name = trim($t_attr_val->get('value_longtext2'))) ? $vs_name : _t("downloaded_file"));
 			
 			// send download
 			$this->response->addContent($o_view->render('ca_attributes_download_file.php'));
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
 			$this->request->setParameter($this->opo_datamodel->getTablePrimaryKeyName($vn_table_num), $t_attr->get('row_id'));
 			
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
 			
 			$o_view->setVar('file_path', $vs_path);
 			$o_view->setVar('file_name', $vs_name);
 			
 			// send download
 			$this->response->addContent($o_view->render('ca_attributes_download_media.php'));
 		}
 		# -------------------------------------------------------
	}
