<?php
/* ----------------------------------------------------------------------
 * pawtucket2/app/controllers/OccurrenceMediaOverlayController.php : controller for object detail page
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
 	require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
 	require_once(__CA_MODELS_DIR__."/ca_relationship_types.php");
 	require_once(__CA_MODELS_DIR__."/ca_object_representations.php");
 	require_once(__CA_LIB_DIR__.'/pawtucket/BaseDetailController.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	
 	class OccurrenceMediaOverlayController extends BaseDetailController {
		# -------------------------------------------------------
 		/**
 		 * Returns content for overlay containing details for object representation linked to occurrence
 		 */ 
 		public function getOccurrenceMediaOverlay() {
 			$pn_occurrence_id = $this->request->getParameter('occurrence_id', pInteger);
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
 			$this->view->setVar('object_id', $pn_object_id);
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			
 			$this->view->setVar('occurrence_id', $pn_occurrence_id);
 			$t_occurrence = new ca_occurrences($pn_occurrence_id);
 			
 			$this->view->setVar('object_id', $pn_object_id);
 			$t_object = new ca_objects($pn_object_id);
 			$this->view->setVar('t_object', $t_object);
 			
 			$t_rep = new ca_object_representations($pn_representation_id);
 			$this->view->setVar('representation_id', $pn_representation_id);
 			$this->view->setVar('t_object_representation', $t_rep);
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			
 			if (!$t_occurrence->getPrimaryKey()) { die("Invalid occurrence_id"); }
 			if (!$t_object->getPrimaryKey()) { die("Invalid object_id"); }
 			if (!$t_rep->getPrimaryKey()) { die("Invalid representation_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_occurrence->get('access'), $va_access_values))) { die("Invalid occurrence_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_object->get('access'), $va_access_values))) { die("Invalid object_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_rep->get('access'), $va_access_values))) { die("Invalid rep_id"); }
 			
			// Get media for display using configured rules
			$va_rep_display_info = caGetMediaDisplayInfo("media_overlay", $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			
			// set version
			$this->view->setVar('version', $va_rep_display_info['display_version']);
			unset($va_display_info['display_version']);
			
			// set poster frame URL
			//$va_rep_display_info['poster_frame_url'] = $t_rep->getMediaUrl('media', $va_rep_display_info['poster_frame_version']);
			//unset($va_display_info['poster_frame_version']);
			
			//$va_rep_display_info['viewer_base_url'] = $t_rep->getAppConfig()->get('ca_url_root');
			
			// set other options
			$this->view->setVar('display_options', $va_rep_display_info);
			
			if (!$ps_display_type 	= trim($this->request->getParameter('display_type', pString))) { $ps_display_type = 'media_overlay'; }
 			if (!$ps_containerID 	= trim($this->request->getParameter('containerID', pString))) { $ps_containerID = 'caMediaPanelContentArea'; }
 			$this->view->setVar("display_type", $ps_display_type);
			$this->view->setVar("containerID", $ps_containerID);
	
			// Get all objects asscoiated with this occurrence and show primary reps as icons for navigation
			$va_exhibition_images = $t_occurrence->get("ca_objects", array('restrict_to_relationship_types' => array('describes'), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_exhibition_images) > 0){
				$t_image_objects = new ca_objects();
				$i = 1;
				foreach($va_exhibition_images as $vn_rel_id => $va_info){
					$t_image_objects->load($va_info["object_id"]);
					if ($t_primary_rep = $t_image_objects->getPrimaryRepresentationInstance()){
						$va_temp =  array();
						if (!sizeof($va_access_values) || in_array($t_primary_rep->get('access'), $va_access_values)) {
							$va_temp["representation_id"] = $t_primary_rep->get("representation_id");
							$va_temp["rep_icon"] = $t_primary_rep->getMediaTag('media', 'icon');
							$va_temp["rep_tinyicon"] = $t_primary_rep->getMediaTag('media', 'tinyicon');
							$va_temp["object_id"] = $va_info["object_id"];

							$va_thumbnails[$va_info["object_id"]] = $va_temp;
							if($vn_getNext == 1){
								$this->view->setVar("next_object_id", $va_info["object_id"]);
								$this->view->setVar("next_representation_id", $t_primary_rep->get("representation_id"));
								$vn_getNext = 0;
							}
							if($va_info["object_id"] == $pn_object_id){
								$this->view->setVar("representation_index", $i);
								$this->view->setVar("previous_object_id", $vn_prev_obj_id);
								$this->view->setVar("previous_representation_id", $vn_prev_rep_id);
								$vn_getNext = 1;
							}
							$vn_prev_obj_id = $va_info["object_id"];
							$vn_prev_rep_id = $t_primary_rep->get("representation_id");
							
							$i++;
						}
					}
				}				
			}
			
			$this->view->setVar('reps', $va_thumbnails);

 			return $this->render("Detail/ajax_ca_occurrences_media_overlay_html.php");
 		}
 	}