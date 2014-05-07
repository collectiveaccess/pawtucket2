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
 			
 			$this->config = caGetDetailConfig();
 			$this->opa_detail_types = $this->config->getAssoc('detailTypes');
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
 			
 			$ps_function = strtolower($ps_function);
 			$ps_id = $this->request->getActionExtra(); 
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
 			
 			if (!$t_table->load($x=$vb_use_identifiers_in_urls ? array($t_table->getProperty('ID_NUMBERING_ID_FIELD') => $ps_id, 'deleted' => 0) : array($t_table->primaryKey() => (int)$ps_id, 'deleted' => 0))) {
 				// invalid id - throw error
 				die("Invalid id");
 			} 			
 			
			#
 			# Enforce access control
 			#
 			if(sizeof($this->opa_access_values) && !in_array($t_table->get("access"), $this->opa_access_values)){
  				$this->notification->addNotification(_t("This item is not available for view"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			
 			MetaTagManager::setWindowTitle($t_table->getTypeName().": ".$t_table->get('preferred_labels').(($vs_idno = $t_table->get($t_table->getProperty('ID_NUMBERING_ID_FIELD'))) ? " [{$vs_idno}]" : ""));
 			
 			$vs_type = $t_table->getTypeCode();
 			
 			$this->view->setVar('detailType', $vs_table);
 			$this->view->setVar('item', $t_table);
 			$this->view->setVar('itemType', $vs_type);
 			
 			caAddPageCSSClasses(array($vs_table, $ps_function, $vs_type));
 			
 			
 			//
 			//
 			//
 			$vs_last_find = ResultContext::getLastFind($this->request, $vs_table);
 			$o_context = new ResultContext($this->request, $vs_table, $vs_last_find);
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
 					$t_representation = $t_table->getPrimaryRepresentationInstance();
 				}
				if ($t_representation) {
					$this->view->setVar("t_representation", $t_representation);
				}
				$this->view->setVar("representationViewer", caObjectDetailMedia($this->request, $t_table->getPrimaryKey(), $t_representation, array()));
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
 				$this->postError(1100, _t('Invalid object/representation'), 'ObjectEditorController->GetRepresentationInfo');
 				return;
 			}
 			$va_opts = array('display' => $ps_display_type, 'object_id' => $pn_object_id, 'containerID' => $ps_containerID, 'access' => caGetUserAccessValues($this->request));
 			if (strlen($vs_use_book_viewer = $this->request->getParameter('use_book_viewer', pInteger))) { $va_opts['use_book_viewer'] = (bool)$vs_use_book_viewer; }

 			$this->response->addContent($t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts));
 		}
		# -------------------------------------------------------
 		/**
 		 * 
 		 */ 
 		public function GetPageListAsJSON() {
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			$ps_content_mode = $this->request->getParameter('content_mode', pString);
 			
 			$this->view->setVar('object_id', $pn_object_id);
 			$this->view->setVar('representation_id', $pn_representation_id);
 			$this->view->setVar('content_mode', $ps_content_mode);
 			
 			$t_rep = new ca_object_representations($pn_representation_id);
 			$va_download_display_info = caGetMediaDisplayInfo('download', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			$vs_download_version = $va_download_display_info['display_version'];
 			$this->view->setVar('download_version', $vs_download_version);
 			
 			$va_page_list_cache = $this->request->session->getVar('caDocumentViewerPageListCache');
 			
 			$va_pages = $va_page_list_cache[$pn_object_id.'/'.$pn_representation_id];
 			if (!isset($va_pages)) {
 				// Page cache not set?
 				$this->postError(1100, _t('Invalid object/representation'), 'ObjectEditorController->GetPage');
 				return;
 			}
 			
 			$va_section_cache = $this->request->session->getVar('caDocumentViewerSectionCache');
 			$this->view->setVar('pages', $va_pages);
 			$this->view->setVar('sections', $va_section_cache[$pn_object_id.'/'.$pn_representation_id]);
 			
 			$this->view->setVar('is_searchable', MediaContentLocationIndexer::hasIndexing('ca_object_representations', $pn_representation_id));
 			
 			$this->render('Details/object_representation_page_list_json.php');
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
				$this->postError(1100, _t('Cannot download media'), 'ObjectEditorController->DownloadMedia');
				return;
			}
			$pn_object_id = $this->request->getParameter('object_id', pInteger);
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
						$this->view->setVar('version_download_name', join('_', $va_tmp).'.'.$va_rep_info['EXTENSION']);					
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
 		# Tagging and commenting
 		# -------------------------------------------------------
 		public function CommentForm(){
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			$this->view->setVar("item_id", $this->request->getParameter('item_id', pInteger));
 			$this->view->setVar("tablename", $this->request->getParameter('tablename', pString));
 			$this->render('Details/form_comments_html.php');
 		}
 		# -------------------------------------------------------
 		public function saveCommentTagging() {
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
 		 public function sendShare() {
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
 		# ------------------------------------------------------
	}
 ?>