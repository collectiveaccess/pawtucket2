<?php
/* ----------------------------------------------------------------------
 * ExhibitsController.php
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
 
 	require_once(__CA_MODELS_DIR__.'/ca_sets.php');
 	require_once(__CA_MODELS_DIR__.'/ca_occurrences.php');
 	require_once(__CA_MODELS_DIR__.'/ca_set_items.php');
 	require_once(__CA_MODELS_DIR__.'/ca_lists.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_LIB_DIR__.'/ca/ResultContext.php');
 
 	class ExhibitsController extends ActionController {
 		# -------------------------------------------------------
 		private $opo_plugin_config;			// plugin config file
 		private $ops_theme;						// current theme
 		private $opo_result_context;			// current result context
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			JavascriptLoadManager::register('panel');
 			JavascriptLoadManager::register('jquery', 'expander');
 			
 			parent::__construct($po_request, $po_response, $pa_view_paths);
			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/clir2/conf/clir2.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('clir2 plugin is not enabled')); }
 			
 			$this->ops_theme = __CA_THEME__;																		// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/clir2/views/'.$this->ops_theme)) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			$this->opo_result_context = new ResultContext($po_request, 'ca_occurrences', 'exhibits');
 		}
 		# -------------------------------------------------------
 		public function Index() {
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			// get sets for public display
 			$t_list = new ca_lists();
 			$vn_set_type_id = $t_list->getItemIDFromList('set_types', $t_list->getAppConfig()->get('exhibits_set_type'));
 			
 			$t_set = new ca_sets();
 			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_occurrences', 'access' => $va_access_values, 'setType' => $vn_set_type_id)));
 			$va_set_first_items = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("checkAccess" => $va_access_values));
 			$va_set_descriptions = $t_set->getAttributeFromSets($this->opo_plugin_config->get('set_description_element_code'), array_keys($va_sets), array("checkAccess" => $va_access_values));

 			$this->view->setVar('sets', $va_sets);
 			$this->view->setVar('first_items_from_sets', $va_set_first_items);
 			$this->view->setVar('set_descriptions', $va_set_descriptions);
 			$this->render('Exhibits/landing_html.php');
 		}
 		# -------------------------------------------------------
 		public function displaySet() {
 			# --- set info
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = new ca_sets($pn_set_id);
 			
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			# Enforce access control
 			if(sizeof($va_access_values) && !in_array($t_set->get("access"), $va_access_values)){
  				$this->notification->addNotification(_t("This set is not available for view"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			
 			$this->view->setVar('t_set', $t_set);
 			$va_items = caExtractValuesByUserLocale($t_set->getItems(array("checkAccess" => $va_access_values)));
 			$this->view->setVar('items', $va_items);
 			
 			$va_row_ids = array();
 			foreach($va_items as $vn_item_id => $va_item_info) {
 				$va_row_ids[] = $va_item_info['row_id'];
 			}
 			
 			
 			# --- all featured sets - for display in right hand column
 			
 			// get sets for public display
 			$t_list = new ca_lists();
 			$vn_set_type_id = $t_list->getItemIDFromList('set_types', $t_list->getAppConfig()->get('exhibits_set_type'));
 			
 			$t_set = new ca_sets($pn_set_id);
 			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_occurrences', 'access' => $va_access_values, 'setType' => $vn_set_type_id)));
 		
 			$va_set_first_items = array();
 			$va_set_first_items = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("checkAccess" => $va_access_values));
 		
 			$this->view->setVar('sets', $va_sets);
 			$this->view->setVar('first_items_from_sets', $va_set_first_items);
 			
 			$this->view->setVar('set_title', $t_set->getLabelForDisplay());
 			$this->view->setVar('set_description', $t_set->get($this->opo_plugin_config->get('set_description_element_code'), array('convertLinkBreaks' => true)));
 			
 			
 			// Needed to figure out what result context to use on details
			$this->opo_result_context->setParameter('set_id', $pn_set_id);
			$this->opo_result_context->setResultList($va_row_ids);
			$this->opo_result_context->setAsLastFind();
			$this->opo_result_context->saveContext();
 			
 			$this->render('Exhibits/set_info_html.php');
 		}
 		# -------------------------------------------------------
 		# --- returns set item info in panel - used with small image list results
 		public function setItemInfo(){
 			$va_access_values = caGetUserAccessValues($this->request);
 
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = new ca_sets($pn_set_id);
 			$this->view->setVar('set_id', $pn_set_id);
 			
 			$pn_set_item_id = $this->request->getParameter('set_item_id', pInteger);
 			$t_set_item = new ca_set_items($pn_set_item_id);
 			
 			$va_set_item_info = array();
 			$va_items = $t_set->getItemIDs(array("checkAccess" => $va_access_values));
 			$pn_previous_id = "";
 			foreach($va_items as $vn_item_id => $va_item_info){
 				if($va_set_item_info["item_id"]){
 					$va_set_item_info["next_id"] = $vn_item_id;
 					break;
 				}
 				if($pn_set_item_id == $vn_item_id){
 					$va_set_item_info["previous_id"] = $pn_previous_id;
 					$va_set_item_info["item_id"] = $vn_item_id;
 				}
 				$pn_previous_id = $vn_item_id;
 			}
 			
 			
 			$va_set_item_info["item_id"] = $t_set_item->get("item_id");
			$va_set_item_info["info"] = $va_rep[0]['info'];
			$va_set_item_info["label"] = $t_set_item->getLabelForDisplay();
			$va_set_item_info["description"] = $t_set_item->get($this->opo_plugin_config->get('set_description_element_code'), array('convertLineBreaks' => true));
			$va_set_item_info["row_id"] = $t_set_item->get("row_id");
			
			$t_occurrence = new ca_occurrences($t_set_item->get("row_id"));
			$va_set_item_info["label"] = $t_occurrence->getLabelForDisplay();
			
			
			$va_mediumlarge_stills = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "mediumlarge", "showMediaInfo" => false, "returnAsArray" => true));
			if(sizeof($va_mediumlarge_stills) > 0){
				$va_set_item_info["media_still"] = array_shift($va_mediumlarge_stills);
				$va_image_caption = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_credit', array("returnAsArray" => true));
				$vs_image_caption = array_shift($va_image_caption);
				if($vs_image_caption){
					$va_set_item_info["media_still_caption"] = $vs_image_caption;
				}
			}
			if($vs_video = $t_occurrence->get('ca_occurrences.ic_moving_images.ic_moving_images_media', array('version' => 'original', 'showMediaInfo' => false, 'viewer_width'=> 580, 'viewer_height' => 450, 'poster_frame_version' => 'mediumlarge'))){
				$va_set_item_info["media_video"] = $vs_video;
				if($vs_video_caption = $t_occurrence->get('ca_occurrences.ic_moving_images.ic_moving_images_credit')){
					$va_set_item_info["media_video_caption"] = $vs_video_caption;
				}
			}
			
 			$this->view->setVar('item_info', $va_set_item_info);
 			
 			$this->render('Exhibits/ajax_item_info_html.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>