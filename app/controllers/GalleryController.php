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
 	
 	class GalleryController extends BasePawtucketController {
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
 			if(!$vs_section_name = $this->config->get('gallery_section_name')){
 				$vs_section_name = _t("Featured Galleries");
 			}
 			$this->view->setVar("section_name", $vs_section_name);
 			if(!$vs_section_item_name = $this->config->get('gallery_section_item_name')){
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
 			$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $this->config->get('gallery_set_type')); 			
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
 				$this->render("Gallery/index_html.php");
 			}else{
 				$ps_set_id = $ps_function;
 				$this->view->setVar("set_id", $ps_set_id);
 				$t_set->load($ps_set_id);
 				$this->view->setVar("set", $t_set);
 				
				$vs_table = Datamodel::getTableName($t_set->get('table_num'));
				# --- don't save the gallery context when loaded via ajax
				if (!$this->request->isAjax()){
					$o_context = new ResultContext($this->request, $vs_table, 'gallery');
					$o_context->setAsLastFind();
					$o_context->setResultList(array_keys($t_set->getItemRowIDs(array("checkAccess" => $this->opa_access_values))));
					$o_context->saveContext();
				} 				 				
 				$this->view->setVar("label", $t_set->getLabelForDisplay());
 				$this->view->setVar("description", $t_set->get($this->config->get('gallery_set_description_element_code')));
 				$this->view->setVar("set_items", caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersions" => array("icon", "iconlarge"), "checkAccess" => $this->opa_access_values))));
 				$pn_set_item_id = $this->request->getParameter('set_item_id', pInteger);
 				if(!in_array($pn_set_item_id, array_keys($t_set->getItemIDs(array("checkAccess" => $this->opa_access_values))))){
 					$pn_set_item_id = "";	
 				}
 				$this->view->setVar("set_item_id", $pn_set_item_id);
 				MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").(($this->config->get('gallery_section_name')) ? $this->config->get('gallery_section_name') : _t("Gallery")).$this->request->config->get("page_title_delimiter").$t_set->getLabelForDisplay());
 				$vs_display_attribute = $this->config->get('gallery_set_presentation_element_code');
 				$vs_display = "";
 				if($vs_display_attribute){
 					$vs_display = $t_set->get('ca_sets.'.$vs_display_attribute, ['convertCodesToIdno' => true]);
 				}
 				switch($vs_display) {
					case 'timeline':
						AssetLoadManager::register('timeline');
						$this->render('Gallery/set_detail_timeline_html.php');
						break;
					case 'map':
						AssetLoadManager::register("maps");
						$va_views = $this->config->get('views');
						$va_views_info = $va_views['map'][$vs_table];
						if($va_views_info['data']){
							$o_res = caMakeSearchResult(
								$t_set->get('table_num'),
								array_keys($t_set->getItemRowIDs(array("checkAccess" => $this->opa_access_values))),
								['checkAccess' => $this->opa_access_values]
							);

							$va_opts = array('renderLabelAsLink' => false, 'request' => $this->request, 'color' => '#cc0000', 'label' => 'ca_places.preferred_labels.name', 'content' => 'ca_places.preferred_labels.name');
		
							$va_opts['ajaxContentUrl'] = caNavUrl($this->request, '*', '*', 'AjaxGetMapItem', array('set_id' => $ps_set_id));
			
							$o_map = new GeographicMap(caGetOption("width", $va_views_info, "100%"), caGetOption("height", $va_views_info, "600px"));
							$o_map->mapFrom($o_res, $va_views_info['data'], $va_opts);
							$this->view->setVar('map', $o_map->render('HTML', array('circle' => 0, 'minZoomLevel' => caGetOption("minZoomLevel", $va_views_info, 2), 'maxZoomLevel' => caGetOption("maxZoomLevel", $va_views_info, 12), 'request' => $this->request)));
							$this->render("Gallery/set_detail_map_html.php");
						}else{
							$this->render("Gallery/detail_html.php");
						}
						break;
					case 'slideshow':
					default:
						$this->render("Gallery/detail_html.php");
						break;
				}
 			}
 		}
 		# -------------------------------------------------------
 		
 		/**
 		 *
 		 */ 
 		public function getSetInfo() {
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = new ca_sets($pn_set_id);
 			$t_set->load($pn_set_id);
 			$this->view->setVar("set", $t_set);
 			$this->view->setVar("set_id", $pn_set_id);
 			$this->view->setVar("label", $t_set->getLabelForDisplay());
 			$this->view->setVar("description", $t_set->get($this->config->get('gallery_set_description_element_code')));
 			$this->view->setVar("num_items", $t_set->getItemCount(array("checkAccess" => $this->opa_access_values)));
 			#$this->view->setVar("set_item", array_shift(array_shift($t_set->getFirstItemsFromSets(array($pn_set_id), array("version" => "large", "checkAccess" => $this->opa_access_values)))));
 			$va_set_item = array_shift(array_shift($t_set->getPrimaryItemsFromSets(array($pn_set_id), array("version" => "large", "checkAccess" => $this->opa_access_values))));
 			if(!$va_set_item){
 				$va_set_item = array_shift(array_shift($t_set->getFirstItemsFromSets(array($pn_set_id), array("version" => "large", "checkAccess" => $this->opa_access_values))));
 			}
 			if(is_array($va_set_item) && !$va_set_item["representation_tag"]){
				if(Datamodel::getTableName($t_set->get('table_num')) != "ca_objects"){
					$t_instance = Datamodel::getInstanceByTableNum($t_set->get('table_num'));
					$t_instance->load($va_set_item["row_id"]);
						if($vs_thumbnail = $t_instance->getWithTemplate('<unit relativeTo="ca_objects.related" length="1">^ca_object_representations.media.large</unit>', array("checkAccess" => $this->opa_access_values))){
							$va_set_item["representation_tag"] = $vs_thumbnail;
							$va_set_item["representation_id"] = $t_instance->getWithTemplate('<unit relativeTo="ca_objects.related" length="1">^ca_object_representations.representation_id</unit>', array("checkAccess" => $this->opa_access_values));
						}
					}
 			}
 			$this->view->setVar("set_item", $va_set_item);
 			$this->render("Gallery/set_info_html.php");
 		}
		# -------------------------------------------------------
		public function getSetInfoAsJSON() {
			$ps_mode = $this->getRequest()->getParameter('mode', pString);
			if(!$ps_mode) { $ps_mode = 'timeline'; }

			$pn_set_id = $this->getRequest()->getParameter('set_id', pInteger);
			$t_set = new ca_sets($pn_set_id);
			$this->getView()->setVar('set', $t_set);
			$vs_table = Datamodel::getTableName($t_set->get('table_num'));
			$va_views = $this->config->get('views');
			$this->getView()->setVar('table', $vs_table);
			$this->getView()->setVar('views', $va_views);

			$o_res = caMakeSearchResult(
				$t_set->get('table_num'),
				array_keys($t_set->getItemRowIDs(array("checkAccess" => $this->opa_access_values))),
				['checkAccess' => $this->opa_access_values]
			);

			$this->getView()->setVar('result', $o_res);

			switch($ps_mode) {
				case 'timeline':
				default:
					$this->getView()->setVar('view', 'timeline');
					$this->render('Gallery/set_detail_timeline_json.php');
			}
		}
 		# -------------------------------------------------------
        /**
         * Return text for map item info bubble
         */
 		public function ajaxGetMapItem() {
            if($this->opb_is_login_redirect) { return; }
            $pn_set_id = $this->getRequest()->getParameter('set_id', pInteger);
			$t_set = new ca_sets($pn_set_id);
			$vs_table = Datamodel::getTableName($t_set->get('table_num'));
			
            $pa_ids = explode(";",$this->request->getParameter('id', pString)); 
            $va_views_info = $this->config->get('views');
            $va_view_info = $va_views_info["map"][$vs_table];
            $vs_content_template = $va_view_info['display']['labelTemplate'].$va_view_info['display']['contentTemplate'];
			$this->view->setVar('contentTemplate', caProcessTemplateForIDs($vs_content_template, $vs_table, $pa_ids, array('checkAccess' => $this->opa_access_values, 'delimiter' => "<br style='clear:both;'/>")));
							
			$this->view->setVar('heading', trim($va_view_info['display']['heading']) ? caProcessTemplateForIDs($va_view_info['display']['heading'], $vs_table, [$pa_ids[0]], array('checkAccess' => $this->opa_access_values)) : "");
			$this->view->setVar('table', $vs_table);
			$this->view->setVar('ids', $pa_ids);
         	$this->render("Browse/ajax_map_item_html.php");   
        }
		# -------------------------------------------------------
 		public function getSetItemRep(){
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = new ca_sets($pn_set_id);
 			$t_set->load($pn_set_id);
			$vs_table = Datamodel::getTableName($t_set->get('table_num'));
			$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersions" => array("icon", "iconlarge"), "checkAccess" => $this->opa_access_values)));
 			$this->view->setVar("set_id", $pn_set_id);
 			
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$this->view->setVar("set_item_id", $pn_item_id); 
 			$t_rep = new ca_object_representations($va_set_items[$pn_item_id]["representation_id"]);
			if(!(is_array($this->opa_access_values) && sizeof($this->opa_access_values) && !in_array($t_rep->get("access"), $this->opa_access_values))){
				$va_rep_info = $t_rep->getMediaInfo("media", "mediumlarge");
				$this->view->setVar("rep_object", $t_rep);
				$this->view->setVar("rep", $t_rep->getMediaTag("media", "mediumlarge"));
				$this->view->setVar("repToolBar", caRepToolbar($this->request, $t_rep, $va_set_items[$pn_item_id]["row_id"], ['context' => 'gallery']));
				$this->view->setVar("representation_id", $va_set_items[$pn_item_id]["representation_id"]);
			}
 			$this->view->setVar("object_id", $va_set_items[$pn_item_id]["row_id"]);
 			$this->view->setVar("row_id", $va_set_items[$pn_item_id]["row_id"]);
 			$this->view->setVar("table", $vs_table);
 			$pn_previous_id = 0;
 			$pn_next_id = 0;
 			$va_set_item_ids = array_keys($va_set_items);
 			$vn_current_index = array_search($pn_item_id, $va_set_item_ids);
 			if($va_set_item_ids[$vn_current_index - 1]){
 				$pn_previous_id = $va_set_item_ids[$vn_current_index - 1];
 			}
 			if($va_set_item_ids[$vn_current_index + 1]){
 				$pn_next_id = $va_set_item_ids[$vn_current_index + 1];
 			}
 			$this->view->setVar("next_item_id", $pn_next_id);
 			$this->view->setVar("previous_item_id", $pn_previous_id);
 			$this->render("Gallery/set_item_rep_html.php");
 		}
 		# -------------------------------------------------------
 		public function getSetItemInfo(){
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = new ca_sets($pn_set_id);
 			$t_set_item = new ca_set_items($pn_item_id);
			$t_instance = Datamodel::getInstanceByTableNum($t_set->get("table_num"));
			$vs_table = Datamodel::getTableName($t_set_item->get('table_num'));
			$t_instance->load($t_set_item->get("row_id"));
 			$va_set_item_ids = array_keys($t_set->getItemIDs(array("checkAccess" => $this->opa_access_values)));
 			$this->view->setVar("item_id", $pn_item_id);
 			$this->view->setVar("set_num_items", sizeof($va_set_item_ids));
 			$this->view->setVar("set_item_num", (array_search($pn_item_id, $va_set_item_ids) + 1));
 			
 			$this->view->setVar("set_item", $t_set_item);
 			$this->view->setVar("object", $t_instance);
 			$this->view->setVar("instance", $t_instance);
 			$this->view->setVar("object_id", $t_set_item->get("row_id"));
 			$this->view->setVar("row_id", $t_set_item->get("row_id"));
 			$this->view->setVar("label", $t_instance->getLabelForDisplay());
 			$this->view->setVar("table", $vs_table);
 			
 			//
 			// Tag substitution
 			//
 			// Views can contain tags in the form {{{tagname}}}. Some tags, such as "label" are defined by
 			// this controller. More usefully, you can pull data from the item being detailed by using a valid "get" expression
 			// as a tag (Eg. {{{ca_objects.idno}}}. Even more usefully for some, you can also use a valid bundle display template
 			// (see http://docs.collectiveaccess.org/wiki/Bundle_Display_Templates) as a tag. The template will be evaluated in the 
 			// context of the item being detailed.
 			//
 			$va_defined_vars = array_keys($this->view->getAllVars());		// get list defined vars (we don't want to copy over them)
 			$va_tag_list = $this->getTagListForView("Gallery/set_item_info_html.php");				// get list of tags in view
 			foreach($va_tag_list as $vs_tag) {
 				if (in_array($vs_tag, $va_defined_vars)) { continue; }
 				if ((strpos($vs_tag, "^") !== false) || (strpos($vs_tag, "<") !== false)) {
 					$this->view->setVar($vs_tag, $t_instance->getWithTemplate($vs_tag, array('checkAccess' => $this->opa_access_values)));
 				} elseif (strpos($vs_tag, ".") !== false) {
 					$this->view->setVar($vs_tag, $t_instance->get($vs_tag, array('checkAccess' => $this->opa_access_values)));
 				} else {
 					$this->view->setVar($vs_tag, "?{$vs_tag}");
 				}
 			}
 			
 			$this->render("Gallery/set_item_info_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Gallery',
 				'action' => 'Index',
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
