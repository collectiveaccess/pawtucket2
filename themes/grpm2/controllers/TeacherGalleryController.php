<?php
/* ----------------------------------------------------------------------
 * app/controllers/GalleryController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_object_representations.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	
 	class TeacherGalleryController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            if (($this->request->config->get('deploy_bristol'))&&($this->request->isLoggedIn())) {
            	print "You do not have access to view this page.";
            	die;
            }
            
 			$this->config = caGetGalleryConfig();
 			
 		 	# --- what is the section called - title of page
 			if(!$vs_section_name = $this->config->get('teacher_gallery_section_name')){
 				$vs_section_name = _t("Featured Galleries");
 			}
 			$this->view->setVar("section_name", $vs_section_name);
 			if(!$vs_section_item_name = $this->config->get('teacher_gallery_section_item_name')){
 				$vs_section_item_name = _t("gallery");
 			}
 			$this->view->setVar("section_item_name", $vs_section_item_name);
 			caSetPageCSSClasses(array("gallery"));
 			
 			AssetLoadManager::register("panel");
 			AssetLoadManager::register("mediaViewer");
 			AssetLoadManager::register("carousel");
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$ps_function = strtolower($ps_function);
 			# --- which type of set is configured for display in gallery section
 			$t_list = new ca_lists();
 			$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $this->config->get('teacher_gallery_set_type')); 			
 			$t_set = new ca_sets();
 			if($ps_function == "index"){
 				if($vn_gallery_set_type_id){
					$va_tmp = array('checkAccess' => $this->opa_access_values, 'setType' => $vn_gallery_set_type_id);
					if(!$this->config->get("gallery_include_all_tables")){
						$va_tmp["table"] = "ca_objects";
					}
					$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
					$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "icon", "checkAccess" => $this->opa_access_values));
					
					$o_front_config = caGetFrontConfig();
					$vs_front_page_set = $o_front_config->get('front_page_set_code');
					$vb_omit_front_page_set = (bool)$this->config->get('omit_front_page_set_from_gallery');
					foreach($va_sets as $vn_set_id => $va_set) {
						if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
							unset($va_sets[$vn_set_id]); 
						}
						$va_first_item = $va_set_first_items[$vn_set_id];
						$va_first_item = array_shift($va_first_item);
						$vn_item_id = $va_first_item["item_id"];
						# --- it there isn't a rep and this is not a set of objects, try to get a related object to show something
						if(!$va_set_first_items[$vn_set_id][$vn_item_id]["representation_tag"]){
							if(Datamodel::getTableName($va_set['table_num']) != "ca_objects"){
								$t_instance = Datamodel::getInstanceByTableNum($va_set['table_num']);
								$t_instance->load($va_first_item["row_id"]);
								if($vs_thumbnail = $t_instance->getWithTemplate('<unit relativeTo="ca_objects.related" length="1">^ca_object_representations.media.iconlarge</unit>', array("checkAccess" => $this->opa_access_values))){
 									$va_set_first_items[$vn_set_id][$vn_item_id] = array("representation_tag" => $vs_thumbnail);
 								}
							}
						}
					}
					$this->view->setVar('sets', $va_sets);
					$this->view->setVar('first_items_from_sets', $va_set_first_items);
				}
				MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").(($this->config->get('gallery_section_name')) ? $this->config->get('gallery_section_name') : _t("Gallery")));
 				$this->render("TeacherGallery/index_html.php");
 			}
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'TeacherGallery',
 				'action' => 'Index',
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
