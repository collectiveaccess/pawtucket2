<?php
/* ----------------------------------------------------------------------
 * pawtucket2/app/controllers/ObjectDetailController.php : controller for object detail page
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
 	require_once(__CA_MODELS_DIR__."/ca_relationship_types.php");
 	require_once(__CA_MODELS_DIR__."/ca_object_representations.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/ObjectSearch.php");
 	require_once(__CA_LIB_DIR__.'/pawtucket/BaseDetailController.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	
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
 		 * shows the basic info for an object
 		 */ 
 		public function Show() {
 			JavascriptLoadManager::register('panel');
 			parent::Show();
 			
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
 		 */ 
 		public function GetObjectMediaOverlay() {
 			$this->_renderMediaView("ajax_ca_objects_media_overlay_html", "media_overlay");
 		}
 		# -------------------------------------------------------
 		/**
 		 * Returns content for ajax-based detail media display
 		 */ 
 		public function GetObjectDetailMedia() {
 			$this->_renderMediaView("ajax_ca_objects_detail_image_html", "detail");
 		}
 		# -------------------------------------------------------
 		/**
 		 * Returns content for overlay containing details for object representation
 		 */ 
 		private function _renderMediaView($ps_view_name, $ps_media_context) {
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			
 			$this->view->setVar('object_id', $pn_object_id);
 			$t_object = new ca_objects($pn_object_id);
 			
 			$t_rep = new ca_object_representations($pn_representation_id);
 			$this->view->setVar('representation_id', $pn_representation_id);
 			$this->view->setVar('t_object_representation', $t_rep);
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			if (!$t_object->getPrimaryKey()) { die("Invalid object_id"); }
 			if (!$t_rep->getPrimaryKey()) { die("Invalid representation_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_object->get('access'), $va_access_values))) { die("Invalid object_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_rep->get('access'), $va_access_values))) { die("Invalid rep_id"); }
 			
			$this->view->setVar('t_display_rep', $t_rep);
			
			// Get media for display using configured rules
			$va_rep_display_info = caGetMediaDisplayInfo($ps_media_context, $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			
			// set version
			$this->view->setVar('rep_display_version', $va_rep_display_info['display_version']);
			unset($va_display_info['display_version']);
			
			// set poster frame URL
			$va_rep_display_info['poster_frame_url'] = $t_rep->getMediaUrl('media', $va_rep_display_info['poster_frame_version']);
			unset($va_display_info['poster_frame_version']);
			
			$va_rep_display_info['viewer_base_url'] = $t_rep->getAppConfig()->get('ca_url_root');
			
			// set other options
			$this->view->setVar('rep_display_options', $va_rep_display_info);
	
			// Get all representation as icons for navigation
 			$va_reps = $t_object->getRepresentations(array('icon'), null, array('return_with_access' => $va_access_values));
 			$this->view->setVar('reps', $va_reps);
 			
 			$vn_previous_id = $pn_previous_id = $pn_next_id = null;
 			if(sizeof($va_reps) > 0){
 				foreach($va_reps as $va_rep){
 					if($vn_get_next > 0){
 					 	$pn_next_id = $va_rep['representation_id'];
 					 	break;
 					 }
 					 if($va_rep['representation_id'] == $pn_representation_id){
 					 	$pn_previous_id = $vn_previous_id;
 					 	$vn_get_next = 1;
 					 }
 					 $vn_previous_id = $va_rep['representation_id'];
 				}
 			}
 			$this->view->setVar('previous_rep_id', $pn_previous_id);
 			$this->view->setVar('next_rep_id', $pn_next_id);
 			
 			return $this->render("{$ps_view_name}.php");
 		}
 		# -------------------------------------------------------
 		# Ajax
 		# -------------------------------------------------------
 		public function DownloadRepresentation() {
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			$t_object = new ca_objects($pn_object_id);
 			$t_rep = new ca_object_representations($pn_representation_id);
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			if (!$t_object->getPrimaryKey()) { die("Invalid object_id"); }
 			if (!$t_rep->getPrimaryKey()) { die("Invalid representation_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_object->get('access'), $va_access_values))) { die("Invalid object_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_rep->get('access'), $va_access_values))) { die("Invalid rep_id"); }
 			
 			
 			$this->view->setVar('representation_id', $pn_representation_id);
 			$this->view->setVar('t_object_representation', $t_rep);
 			
 			$va_versions = $t_rep->getMediaVersions('media');
 			$ps_version = 'original';
 			
 			if (!in_array($ps_version, $va_versions)) { $ps_version = $va_versions[0]; }
 			$this->view->setVar('version', $ps_version);
 			
 			$va_rep_info = $t_rep->getMediaInfo('media', $ps_version);
 			$this->view->setVar('version_info', $va_rep_info);
 			$this->view->setVar('version_path', $t_rep->getMediaPath('media', $ps_version));
 			
 			$va_info = $t_rep->getMediaInfo('media');
 			if ($va_info['ORIGINAL_FILENAME']) {
				$this->view->setVar('version_download_name', $va_info['ORIGINAL_FILENAME'].'.'.$va_rep_info['EXTENSION']);
			} else {
				$this->view->setVar('version_download_name', $pn_representation_id.'_'.$ps_version.'.'.$va_rep_info['EXTENSION']);
			}
 					
 			return $this->render('object_representation_download_binary.php');
 		}

 	}
 	# -------------------------------------------------------
 ?>
