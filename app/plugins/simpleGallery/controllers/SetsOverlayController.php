<?php
/* ----------------------------------------------------------------------
 * pawtucket2/app/plugins/simpleGallery/controllers/SetsOverlayController.php : controller for sets overlay
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2012 Whirl-i-Gig
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
 	require_once(__CA_LIB_DIR__.'/pawtucket/BaseDetailController.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	
 	class SetsOverlayController extends BaseDetailController {
		# -------------------------------------------------------
 		private $ops_theme;						// current theme
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/simpleGallery/conf/simpleGallery.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('simpleGallery plugin is not enabled')); }
 			
 			$this->ops_theme = __CA_THEME__;																		// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/simpleGallery/views/'.$this->ops_theme)) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			$this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'simple_gallery');
 		}
		# -------------------------------------------------------
 		/**
 		 * Returns content for overlay containing details for object representation linked to occurrence
 		 */ 
 		public function getSetsOverlay() {
 			$this->view->setVar('display_type', 'media_overlay');
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
 			$this->view->setVar('object_id', $pn_object_id);
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/simpleGallery/conf/simpleGallery.conf');
 			
 			$this->view->setVar('set_id', $pn_set_id);
 			$t_set = new ca_sets($pn_set_id);

 			$pn_set_item_id = $this->request->getParameter('set_item_id', pInteger);
			$this->view->setVar('set_item_id', $pn_set_item_id);
			
			$ps_set_item_description_code = $this->opo_plugin_config->get('set_item_description_element_code');
 			$this->view->setVar('set_item_description', $ps_set_item_description_code);
 			
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
 			
 			if (!$t_set->getPrimaryKey()) { die("Invalid set_id"); }
 			if (!$t_object->getPrimaryKey()) { die("Invalid object_id"); }
 			if (!$t_rep->getPrimaryKey()) { die("Invalid representation_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_set->get('access'), $va_access_values))) { die("Invalid set_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_object->get('access'), $va_access_values))) { die("Invalid object_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_rep->get('access'), $va_access_values))) { die("Invalid rep_id"); }
 			
			// Get media for display using configured rules
			$va_rep_display_info = caGetMediaDisplayInfo("media_overlay", $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			
			// set version
			$this->view->setVar('version', $va_rep_display_info['display_version']);
			unset($va_display_info['display_version']);
			
			// set other options
			$this->view->setVar('display_options', $va_rep_display_info);
					
			if (!$ps_containerID 	= trim($this->request->getParameter('containerID', pString))) { $ps_containerID = 'caMediaPanelContentArea'; }
 			$this->view->setVar("containerID", $ps_containerID);
	
			// Get all objects asscoiated with this set and show primary reps as icons for navigation
			$va_set_items = $t_set->getItems(array("checkAccess" => $va_access_values));
			#print "<pre>";
			#print_r($va_set_items);
			#print "</pre>";
			if(sizeof($va_set_items) > 0){
				$t_image_objects = new ca_objects();
				$i = 1;
				foreach($va_set_items as $vn_rel_id => $va_inter){
					foreach ($va_inter as $id => $va_info) {	
						$t_image_objects->load($va_info["row_id"]);
						if ($t_primary_rep = $t_image_objects->getPrimaryRepresentationInstance()){
							$va_temp =  array();
							if (!sizeof($va_access_values) || in_array($t_primary_rep->get('access'), $va_access_values)) {
								$va_temp["representation_id"] = $t_primary_rep->get("representation_id");
								$va_temp["rep_icon"] = $t_primary_rep->getMediaTag('media', 'icon');
								$va_temp["rep_tinyicon"] = $t_primary_rep->getMediaTag('media', 'tinyicon');
								$va_temp["object_id"] = $va_info["object_id"];
								$va_temp["set_item_id"] = $va_info['item_id'];
	
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
									$this->view->setVar("set_item_id", $va_info['item_id']);
									$vn_getNext = 1;
								}

								$vn_prev_obj_id = $va_info["object_id"];
								$vn_prev_rep_id = $t_primary_rep->get("representation_id");
								$i++;
							}
						}
					}
				}				
			}
			
			$this->view->setVar('reps', $va_thumbnails);

 			return $this->render($this->ops_theme."/ajax_ca_sets_media_overlay_html.php");
 		}
 		# -------------------------------------------------------
 	}