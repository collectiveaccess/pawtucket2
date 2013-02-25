<?php
/* ----------------------------------------------------------------------
 * pawtucket2/app/controllers/ObjectDetailController.php : controller for object detail page
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2013 Whirl-i-Gig
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
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_set_items.php");
 	require_once(__CA_MODELS_DIR__."/ca_relationship_types.php");
 	require_once(__CA_MODELS_DIR__."/ca_object_representations.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/ObjectSearch.php");
 	require_once(__CA_LIB_DIR__.'/pawtucket/BaseDetailController.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_APP_DIR__.'/helpers/mediaPluginHelpers.php');
 	
 	class ObjectController extends BaseDetailController {
 		# -------------------------------------------------------
 		/** 
 		 * Number of similar items to show
 		 */
 		 protected $opn_similar_items_per_page = 12;
 		 /**
 		 * Name of subject table (ex. for an object search this is 'ca_objects')
 		 */
 		protected $ops_tablename = 'ca_objects';
 		
 		/**
 		 * Name of application (eg. providence, pawtucket, etc.)
 		 */
 		protected $ops_appname = 'pawtucket2';
 		# -------------------------------------------------------
 		/**
 		 * Displays the basic info for an object
 		 */ 
 		public function Show($pa_options=null) {
 			JavascriptLoadManager::register('panel');
 			parent::Show($pa_options);
 			
 			// redirect user if not logged in
			if (($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn()))||($this->request->config->get('show_bristol_only')&&!($this->request->isLoggedIn()))) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            } elseif (($this->request->config->get('show_bristol_only'))&&($this->request->isLoggedIn())) {
            	$this->response->setRedirect(caNavUrl($this->request, "bristol", "Show", "Index"));
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
 			$vn_object_id 	= $this->request->getParameter('object_id', pInteger);
 			$pn_representation_id 	= $this->request->getParameter('representation_id', pInteger);
 			$pn_order_item_id 	= $this->request->getParameter('order_item_id', pInteger);
 			if (!$ps_display_type 	= trim($this->request->getParameter('display_type', pString))) { $ps_display_type = 'media_overlay'; }
 			if (!$ps_containerID 	= trim($this->request->getParameter('containerID', pString))) { $ps_containerID = 'caMediaPanelContentArea'; }
 			
 			if(!$vn_object_id) { $vn_object_id = 0; }
 			$t_rep = new ca_object_representations($pn_representation_id);
 			
 			$va_opts = array('display' => $ps_display_type, 'object_id' => $vn_object_id, 'order_item_id' => $pn_order_item_id, 'onlyShowRepresentationsInOrder' => ($pn_order_item_id ? true : false), 'containerID' => $ps_containerID, 'access' => caGetUserAccessValues($this->request));
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
 			
 			$this->render('object_representation_page_list_json.php');
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
				
				$vn_rc = $this->render('object_download_media_binary.php');
				
				if ($vs_path) { unlink($vs_path); }
			} else {
				foreach($va_file_paths as $vs_path => $vs_name) {
					$this->view->setVar('archive_path', $vs_path);
					$this->view->setVar('archive_name', $vs_name);
				}
				$vn_rc = $this->render('object_download_media_binary.php');
			}
			
			return $vn_rc;
		}
		# -------------------------------------------------------
		/**
		 * Download single representation from currently open object
		 */ 
		public function DownloadRepresentation() {
			if (!caObjectsDisplayDownloadLink($this->request)) {
				$this->postError(1100, _t('Cannot download media'), 'ObjectEditorController->DownloadMedia');
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
			$vn_rc = $this->render('object_representation_download_binary.php');
			if ($vs_path) { unlink($vs_path); }
			return $vn_rc;
		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function GetObjectDetailMedia() {
 			$this->show(array('view' => 'ajax_ca_objects_detail_image_html.php'));
			
 		}
 		# -------------------------------------------------------
 		public function RecordRepresentationSelection() {
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			$pn_selected = $this->request->getParameter('selected', pInteger);
 			
 			$va_errors = array();
 			$t_set_item = new ca_set_items($pn_item_id);
 			$t_set = new ca_sets($t_set_item->get('set_id'));
 			if (!$t_set->getPrimaryKey() || (!$t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__))) {
 				// TODO: proper error reporting or redirect?
 				return;
 			}
 			if (!$t_set_item->getPrimaryKey()) {
 				$va_errors[] = _t("Invalid set item");
 			}
 			if (!sizeof($va_errors)) {
				$t_set = new ca_sets($t_set_item->get('set_id'));
				if (!$t_set->getPrimaryKey()) {
					$va_errors[] = _t("Invalid set");
				}
				if (!$t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
					$va_errors[] = _t("You do not have access to this set");
				}
				if (!sizeof($va_errors)) {
					if ((bool)$pn_selected) {
						$t_set_item->addSelectedRepresentation($pn_representation_id);
					} else {
						$t_set_item->removeSelectedRepresentation($pn_representation_id);
					}
					$t_set_item->update();
					
					$va_errors = $t_set_item->getErrors();
				}
			}
			$this->view->setVar("errors", $va_errors);
 			$this->view->setVar('representation_id', $pn_representation_id);
 			$this->view->setVar('item_id', $pn_item_id);
 			$this->render("ajax_select_representation_json.php");
 		}
 		# -------------------------------------------------------
		public function jumpToDetail() {
			$o_search = new ObjectSearch();
			
			$qr_res = $o_search->search($this->request->getParameter('search', pString));
			
			$va_ids = array();
			while($qr_res->nextHit()) {
				$va_ids[] = $qr_res->get('ca_objects.object_id');
			}
			
			$this->view->setVar('ids', $va_ids);
			
			$this->render('ajax_object_lookup_json.php');
		}
  		# -------------------------------------------------------
 	}
 ?>
