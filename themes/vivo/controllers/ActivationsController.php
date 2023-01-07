<?php
/* ----------------------------------------------------------------------
 * app/controllers/ActivationsController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 	
 	class ActivationsController extends BasePawtucketController {
 		# -------------------------------------------------------
  		/**
 		 *
 		 */ 
 		public function __construct(&$request, &$response, $view_paths=null) {
 			parent::__construct($request, $response, $view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            
 			$this->config = caGetGalleryConfig();
 			
 		 	
 			$this->view->setVar("section_item_name", $section_item_name);
 			caSetPageCSSClasses(array("activations"));
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Activations"));
 				
 			
 			AssetLoadManager::register("panel");
 			AssetLoadManager::register("mediaViewer");
 			AssetLoadManager::register("readmore");
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function __call($function, $pa_args) {
 			$function = strtolower($function);
 			
 			$o_front_config = caGetFrontConfig();
 			$t_set = new ca_sets();
 			$t_list = new ca_lists();
 			
 			# Which type of set is configured for display in gallery section? 		
 			$gallery_set_type_id = $t_list->getItemIDFromList('set_types', $this->config->get('gallery_set_type')); 		
 			
 			if($function == "index"){
 				if($gallery_set_type_id){
					$set_opts = array('checkAccess' => $this->opa_access_values, 'setType' => $gallery_set_type_id);
					if(!$this->config->get("gallery_include_all_tables")){
						$set_opts["table"] = "ca_objects";
					}
					$sets = caExtractValuesByUserLocale($t_set->getSets($set_opts));
					uksort($sets, function() { return rand() > rand(); });
					$set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($sets), array("version" => "iconlarge", "checkAccess" => $this->opa_access_values));
				
					$vs_front_page_set = $o_front_config->get('front_page_set_code');
					$vb_omit_front_page_set = (bool)$this->config->get('omit_front_page_set_from_gallery');
					foreach($sets as $set_id => $va_set) {
						if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
							unset($sets[$set_id]); 
						}
						$first_item = $set_first_items[$set_id];
						$first_item = array_shift($first_item);
						$vn_item_id = $first_item["item_id"];
						# --- if there isn't a rep and this is not a set of objects, try to get a related object to show something
						if(!$set_first_items[$set_id][$vn_item_id]["representation_tag"]){
							if(Datamodel::getTableName($va_set['table_num']) != "ca_objects"){
								if (!($t_instance = Datamodel::getInstanceByTableNum($va_set['table_num']))) { throw new ApplicationException(_t('Invalid item')); }
								$t_instance->load($first_item["row_id"]);
								if($vs_thumbnail = $t_instance->getWithTemplate('<unit relativeTo="ca_objects.related" length="1">^ca_object_representations.media.iconlarge</unit>', array("checkAccess" => $this->opa_access_values))){
 									$set_first_items[$set_id][$vn_item_id] = array("representation_tag" => $vs_thumbnail);
 								}
							}
						}
					}
				}
				$this->view->setVar('sets', $sets);
				$this->view->setVar('first_items_from_sets', $set_first_items);
				
				# --- Subject Guides
				$va_types = caMakeTypeIDList('ca_occurrences', array("subject_guide"), array('dontIncludeSubtypesInTypeRestriction' => true));
				$o_browse = caGetBrowseInstance("ca_occurrences");
				$o_browse->setTypeRestrictions($va_types, array('dontExpandHierarchically' => true));
				$o_browse->addCriteria("_search", array("*"));
				$o_browse->execute(array('checkAccess' => $this->opa_access_values));
				$qr_res = $o_browse->getResults();
				$va_subject_guide_ids = array();
				if($qr_res->numHits()){
					$i = 0;
					while($qr_res->nextHit()){
						$va_subject_guide_ids[] = $qr_res->get("ca_occurrences.occurrence_id");
						$i++;
						if($i == 20){
							break;
						}
					}
					shuffle($va_subject_guide_ids);
					$q_guides = caMakeSearchResult('ca_occurrences', $va_subject_guide_ids);
				}
				$this->view->setVar('subject_guides', $q_guides);
				
				# --- featured events
				$this->view->setVar('access_values', $this->opa_access_values);

				#
				# --- if there is a set configured to show on the front page, load it now
				#
				$va_featured_ids = array();
				if($vs_set_code = $this->request->config->get("activations_events_set_code")){
					$t_set = new ca_sets();
					$t_set->load(array('set_code' => $vs_set_code));
					$vn_shuffle = 1;
					# Enforce access control on set
					if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
						$this->view->setVar('featured_set_id', $t_set->get("set_id"));
						$this->view->setVar('featured_set', $t_set);
						$this->view->setVar('featured_set_name', $t_set->get("ca_sets.preferred_labels"));
						$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
						$this->view->setVar('featured_set_item_ids', $va_featured_ids);
						$this->view->setVar('featured_set_items_as_search_result', caMakeSearchResult('ca_occurrences', $va_featured_ids));
					}
				}
				$this->render("Activations/index_html.php");
 			}
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Activation',
 				'action' => 'Index',
 				'params' => []
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _getSet($set_id) {
 			$t_set = new ca_sets();
 			if (!$t_set->load($set_id) || (sizeof($this->opa_access_values) && !in_array((int)$t_set->get('access'), $this->opa_access_values, true))) { throw new ApplicationException(_t('Invalid set')); }
 			return $t_set;
 		}
 		# -------------------------------------------------------
	}
