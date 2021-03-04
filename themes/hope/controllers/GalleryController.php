<?php
/* ----------------------------------------------------------------------
 * app/controllers/GalleryController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2020 Whirl-i-Gig
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
  		/**
 		 *
 		 */ 
 		public function __construct(&$request, &$response, $view_paths=null) {
 			parent::__construct($request, $response, $view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            
 			$this->config = caGetGalleryConfig();
 			
 			switch(strToLower($function)){
				case "user":
					$gallery_set_type_id = "user_curated";
					$section_name = $this->config->get('gallery_section_name_user');
				break;
				# -----------------------------
				case "index":
				case "kam":
				default:
					$gallery_set_type_id = "kam_curated";
					$section_name = $this->config->get('gallery_section_name_kam');
				break;
				# -----------------------------
			}
			# --- what is the section called - title of page
			if(!$section_name){
				$section_name = _t("Featured Galleries");
			}
			$this->view->setVar("section_name", $section_name);
			if(!$section_item_name = $this->config->get('gallery_section_item_name')){
				$section_item_name = _t("gallery");
			}
			$this->view->setVar("section_item_name", $section_item_name);
 			
 			caSetPageCSSClasses(array("gallery"));
 			
 			AssetLoadManager::register("panel");
 			AssetLoadManager::register("mediaViewer");
 			AssetLoadManager::register("carousel");
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
 			#$gallery_set_type_id = $t_list->getItemIDFromList('set_types', $this->config->get('gallery_set_type')); 		
 			
 			if(in_array(strToLower($function), array("index", "kam", "user"))){
 				switch(strToLower($function)){
 					case "user":
 						$gallery_set_type_id = "user_curated";
 					break;
 					# -----------------------------
 					case "index":
 					case "kam":
 					default:
 						$gallery_set_type_id = "kam_curated";
 					break;
 					# -----------------------------
 				}
 				
 				if($gallery_set_type_id){
					$set_opts = array('checkAccess' => $this->opa_access_values, 'setType' => $gallery_set_type_id);
					if(!$this->config->get("gallery_include_all_tables")){
						$set_opts["table"] = "ca_objects";
					}
					$sets = caExtractValuesByUserLocale($t_set->getSets($set_opts));
		
					# --- remove child sets
					foreach($sets as $set_id => $set){
						if($set["parent_id"]){
							unset($sets[$set_id]);
						}
					}
					$set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($sets), array("version" => "icon", "checkAccess" => $this->opa_access_values));
					
					$vs_front_page_set = $o_front_config->get('front_page_set_code');
					$vb_omit_front_page_set = (bool)$this->config->get('omit_front_page_set_from_gallery');
					$o_db = new Db();
					foreach($sets as $set_id => $va_set) {
						if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
							unset($sets[$set_id]); 
						}
						
						# --- if this is a set of sets, the representative image should be from the child set
						$q_sets = $o_db->query("SELECT s.set_id FROM ca_sets s WHERE s.parent_id = ? AND s.deleted = 0 AND s.access IN (".join(", ", $this->opa_access_values).") ORDER BY s.rank ASC LIMIT 1", $set_id);
						if($q_sets->numRows()){
							while($q_sets->nextRow()){
								$t_child = new ca_sets($q_sets->get("ca_sets.set_id"));
								$set_first_items[$set_id] = array_shift($t_child->getPrimaryItemsFromSets(array($q_sets->get("ca_sets.set_id")), array("version" => "large", "checkAccess" => $this->opa_access_values)));
							}
						}
					}
					$this->view->setVar('sets', $sets);
					$this->view->setVar('first_items_from_sets', $set_first_items);
				}
				MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").(($this->config->get('gallery_section_name')) ? $this->config->get('gallery_section_name') : _t("Gallery")));
 				$this->render("Gallery/index_html.php");
 			}else{
 				$set_id = (int)$function;
 				$t_set = $this->_getSet($set_id);
 				if (!($table = Datamodel::getTableName($t_set->get('table_num')))) { throw new ApplicationException(_t('Invalid set')); }
 				
 				$this->view->setVar("set_id", $set_id);
 				$this->view->setVar("set", $t_set);
 				
 				# --- is this set a child or parent?  Get all the siblings/children/parents
 				$va_sets_navigation = array();
 				$vs_parent_name = "";
 				$vs_parent_description = "";
 				if($parent_id = $t_set->get("ca_sets.parent_id")){
 					$t_parent = new ca_sets($parent_id);
 					#$va_sets_navigation[$parent_id] = $t_parent->getLabelForDisplay();
 					$vs_parent_name = $t_parent->getLabelForDisplay();
 					$vs_parent_description = $t_parent->get($this->config->get('gallery_set_description_element_code'));
				}else{
					$parent_id = $t_set->get("ca_sets.set_id");
					#$va_sets_navigation[$parent_id] = $t_set->getLabelForDisplay();
 					$vs_parent_name = $t_set->getLabelForDisplay();
 					$vs_parent_description = $t_set->get($this->config->get('gallery_set_description_element_code'));
				}
				$this->view->setVar("parent_id", $parent_id);
				$this->view->setVar("parent_name", $vs_parent_name);
 				$this->view->setVar("parent_description", $vs_parent_description);
				# --- get all children or siblings of this set
				$o_db = new Db();
				$q_sets = $o_db->query("SELECT s.set_id, csl.name FROM ca_sets s INNER JOIN ca_set_labels AS csl ON s.set_id = csl.set_id WHERE s.parent_id = ? AND s.deleted = 0 AND s.access IN (".join(", ", $this->opa_access_values).")", $parent_id);
				$va_children = array();
				if($q_sets->numRows()){
					while($q_sets->nextRow()){
						$va_sets_navigation[$q_sets->get("set_id")] = $q_sets->get("name");
						# --- if the current set is the parent, show the first child
						if($parent_id == $set_id){
							$set_id = $q_sets->get("set_id");
							$t_set = $this->_getSet($set_id);
							$this->view->setVar("set_id", $set_id);
 							$this->view->setVar("set", $t_set);
						}
					}
					$this->view->setVar("set_navigation", $va_sets_navigation);
				}
 				
				# Don't save the gallery context when loaded via ajax
				if (!$this->request->isAjax()){
					$o_context = new ResultContext($this->request, $table, 'gallery');
					$o_context->setAsLastFind();
					$o_context->setResultList(array_keys($t_set->getItemRowIDs(array("checkAccess" => $this->opa_access_values))));
					$o_context->saveContext();
				} 				 				
 				$this->view->setVar("label", $t_set->getLabelForDisplay());
 				$this->view->setVar("description", $t_set->get($this->config->get('gallery_set_description_element_code')));
 				$this->view->setVar("set_items", caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersions" => array("icon", "iconlarge"), "checkAccess" => $this->opa_access_values))));
 				
 				$set_item_id = $this->request->getParameter('set_item_id', pInteger);
 				if(!in_array($set_item_id, array_keys($t_set->getItemIDs(array("checkAccess" => $this->opa_access_values))))){
 					$set_item_id = "";	
 				}
 				$this->view->setVar("set_item_id", $set_item_id);
 				
 				$display_attribute = $this->config->get('gallery_set_presentation_element_code');
 				$display = $display_attribute? $t_set->get("ca_sets.{$display_attribute}", ['convertCodesToIdno' => true]) : $display;
 			
 				switch($display) {
					case 'timeline':
						AssetLoadManager::register('timeline');
						$this->render('Gallery/set_detail_timeline_html.php');
						break;
					case 'map':
						AssetLoadManager::register("maps");
						$views = $this->config->get('views');
						$views_info = $views['map'][$table];
						if($views_info['data']){
							$o_res = caMakeSearchResult(
								$t_set->get('table_num'),
								array_keys($t_set->getItemRowIDs(array("checkAccess" => $this->opa_access_values))),
								['checkAccess' => $this->opa_access_values]
							);

							$opts = array(
								'renderLabelAsLink' => false, 
								'request' => $this->request, 
								'color' => '#cc0000', 
								'label' => 'ca_places.preferred_labels.name', 
								'content' => 'ca_places.preferred_labels.name',
								'ajaxContentUrl' => caNavUrl($this->request, '*', '*', 'AjaxGetMapItem', ['set_id' => $set_id])
							);
			
							$o_map = new GeographicMap(caGetOption("width", $views_info, "100%"), caGetOption("height", $views_info, "600px"));
							$o_map->mapFrom($o_res, $views_info['data'], $opts);
							$this->view->setVar('map', $o_map->render('HTML', array('circle' => 0, 'minZoomLevel' => caGetOption("minZoomLevel", $views_info, 2), 'maxZoomLevel' => caGetOption("maxZoomLevel", $views_info, 12), 'request' => $this->request)));
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
				
				MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").(($this->config->get('gallery_section_name')) ? $this->config->get('gallery_section_name') : _t("Gallery")).$this->request->config->get("page_title_delimiter").$t_set->getLabelForDisplay());
 			}
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function getSetInfo() {
 			$set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = $this->_getSet($set_id);
 			
 			$this->view->setVar("set", $t_set);
 			$this->view->setVar("set_id", $set_id);
 			$this->view->setVar("label", $t_set->getLabelForDisplay());
 			$this->view->setVar("description", $t_set->get($this->config->get('gallery_set_description_element_code')));
 			#$this->view->setVar("num_items", $t_set->getItemCount(array("checkAccess" => $this->opa_access_values)));
 			
 			# --- if this is a set of sets, the representative image should be from the child set
			$o_db = new Db();
			$q_sets = $o_db->query("SELECT s.set_id FROM ca_sets s WHERE s.parent_id = ? AND s.deleted = 0 AND s.access IN (".join(", ", $this->opa_access_values).") ORDER BY s.rank ASC LIMIT 1", $set_id);
			if($q_sets->numRows()){
				while($q_sets->nextRow()){
					$t_child = new ca_sets($q_sets->get("ca_sets.set_id"));
					$set_item = array_shift(array_shift($t_child->getPrimaryItemsFromSets(array($q_sets->get("ca_sets.set_id")), array("version" => "large", "checkAccess" => $this->opa_access_values))));
 				}
			}else{
				$set_item = array_shift(array_shift($t_set->getPrimaryItemsFromSets(array($set_id), array("version" => "large", "checkAccess" => $this->opa_access_values))));
			}
 			
 			
 			if(is_array($set_item) && !$set_item["representation_tag"]){
				if(Datamodel::getTableName($t_set->get('table_num')) != "ca_objects"){
					if (!($t_instance = Datamodel::getInstanceByTableNum($t_set->get('table_num')))) { throw new ApplicationException(_t('Invalid item')); }
					
					$t_instance->load($set_item["row_id"]);
						if($vs_thumbnail = $t_instance->getWithTemplate('<unit relativeTo="ca_objects.related" length="1">^ca_object_representations.media.large</unit>', array("checkAccess" => $this->opa_access_values))){
							$set_item["representation_tag"] = $vs_thumbnail;
							$set_item["representation_id"] = $t_instance->getWithTemplate('<unit relativeTo="ca_objects.related" length="1">^ca_object_representations.representation_id</unit>', array("checkAccess" => $this->opa_access_values));
						}
					}
 			}
 			$this->view->setVar("set_item", $set_item);
 			$this->render("Gallery/set_info_html.php");
 		}
		# -------------------------------------------------------
		/**
 		 *
 		 */ 
		public function getSetInfoAsJSON() {
			$ps_mode = $this->getRequest()->getParameter('mode', pString);
			if(!$ps_mode) { $ps_mode = 'timeline'; }

			$set_id = $this->getRequest()->getParameter('set_id', pInteger);
			$t_set = $this->_getSet($set_id);
 				
			$this->getView()->setVar('set', $t_set);
			$table = Datamodel::getTableName($t_set->get('table_num'));
			$views = $this->config->get('views');
			$this->getView()->setVar('table', $table);
			$this->getView()->setVar('views', $views);

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
            $set_id = $this->getRequest()->getParameter('set_id', pInteger);
			$t_set = $this->_getSet($set_id);
			
			if (!($table = Datamodel::getTableName($t_set->get('table_num')))) { throw new ApplicationException(_t('Invalid set')); }
			
            $pa_ids = explode(";",$this->request->getParameter('id', pString)); 
            $views_info = $this->config->get('views');
            $view_info = $views_info["map"][$table];
            $content_template = $view_info['display']['icon'].$view_info['display']['title_template'].$view_info['display']['description_template'];
			$this->view->setVar('contentTemplate', caProcessTemplateForIDs($content_template, $table, $pa_ids, array('checkAccess' => $this->opa_access_values, 'delimiter' => "<br style='clear:both;'/>")));
			
			$this->view->setVar('heading', trim($view_info['display']['heading']) ? caProcessTemplateForIDs($view_info['display']['heading'], $table, [$pa_ids[0]], array('checkAccess' => $this->opa_access_values)) : "");
			$this->view->setVar('table', $table);
			$this->view->setVar('ids', $pa_ids);
			
         	$this->render("Browse/ajax_map_item_html.php");   
        }
		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function getSetItemRep(){
 			$set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = $this->_getSet($set_id);
 			
			if (!($table = Datamodel::getTableName($t_set->get('table_num')))) { throw new ApplicationException(_t('Invalid set')); }
			
			$set_items = caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersions" => array("icon", "iconlarge"), "checkAccess" => $this->opa_access_values)));
 			$this->view->setVar("set_id", $set_id);
 			
 			$item_id = $this->request->getParameter('item_id', pInteger);
 			$t_set_item = $this->_getSetItem($set_id, $item_id); // will throw exception if item is not valid for set or publicaly accessible
 			
 			$this->view->setVar("set_item_id", $item_id); 
 			$t_rep = new ca_object_representations($set_items[$item_id]["representation_id"]);
 			
			if(!(is_array($this->opa_access_values) && sizeof($this->opa_access_values) && !in_array($t_rep->get("access"), $this->opa_access_values))){
				$this->view->setVar("rep_object", $t_rep);
				$this->view->setVar("rep", $t_rep->getMediaTag("media", "mediumlarge"));
				$this->view->setVar("repToolBar", caRepToolbar($this->request, $t_rep, $set_items[$item_id]["row_id"], ['context' => 'gallery', 'set_id' => $set_id]));
				$this->view->setVar("representation_id", $set_items[$item_id]["representation_id"]);
			}
 			$this->view->setVar("object_id", $set_items[$item_id]["row_id"]);
 			$this->view->setVar("row_id", $set_items[$item_id]["row_id"]);
 			$this->view->setVar("table", $table);
 			
 			$previous_id = $next_id = 0;
 			$set_item_ids = array_keys($set_items);
 			$vn_current_index = array_search($item_id, $set_item_ids);
 			if($set_item_ids[$vn_current_index - 1]){
 				$previous_id = $set_item_ids[$vn_current_index - 1];
 			}
 			if($set_item_ids[$vn_current_index + 1]){
 				$next_id = $set_item_ids[$vn_current_index + 1];
 			}
 			$this->view->setVar("next_item_id", $next_id);
 			$this->view->setVar("previous_item_id", $previous_id);
 			
 			$this->view->setVar("next_row_id", $set_items[$next_id]["row_id"]);
 			$this->view->setVar("previous_row_id", $set_items[$previous_id]["row_id"]);
 			$this->view->setVar("next_representation_id", $set_items[$next_id]["representation_id"]);
 			$this->view->setVar("previous_representation_id", $set_items[$previous_id]["representation_id"]);
 			
 			$this->render("Gallery/set_item_rep_html.php");
 		}
 		# -------------------------------------------------------
 	 	/**
 		 *
 		 */ 
 		public function getSetItemInfo(){
 			$item_id = $this->request->getParameter('item_id', pInteger);
 			$set_id = $this->request->getParameter('set_id', pInteger);
 			
 			$t_set = $this->_getSet($set_id);
 			$t_set_item = $this->_getSetItem($set_id, $item_id);
 			
			if (!($t_instance = Datamodel::getInstanceByTableNum($t_set->get("table_num")))) { throw new ApplicationException(_t('Invalid set type')); }
			if (!($table = Datamodel::getTableName($t_set_item->get('table_num')))) { throw new ApplicationException(_t('Invalid set type')); }
			if (!$t_instance->load($t_set_item->get("row_id"))) { throw new ApplicationException(_t('Invalid item')); }
			
 			$set_item_ids = array_keys($t_set->getItemIDs(array("checkAccess" => $this->opa_access_values)));
 			$this->view->setVar("item_id", $item_id);
 			$this->view->setVar("set_num_items", sizeof($set_item_ids));
 			$this->view->setVar("set_item_num", (array_search($item_id, $set_item_ids) + 1));
 			
 			$this->view->setVar("set_item", $t_set_item);
 			$this->view->setVar("object", $t_instance);
 			$this->view->setVar("instance", $t_instance);
 			$this->view->setVar("object_id", $t_set_item->get("row_id"));
 			$this->view->setVar("row_id", $t_set_item->get("row_id"));
 			$this->view->setVar("label", $t_instance->getLabelForDisplay());
 			$this->view->setVar("table", $table);
 			
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
 					$this->view->setVar($vs_tag, $t_set_item->getWithTemplate($vs_tag, array('checkAccess' => $this->opa_access_values)));
 				} elseif (strpos($vs_tag, ".") !== false) {
 					if(!strlen($v = $t_set_item->get($vs_tag, array('checkAccess' => $this->opa_access_values)))) {
 						$v = $t_instance->get($vs_tag, array('checkAccess' => $this->opa_access_values));
 					}
 					$this->view->setVar($vs_tag, $v);
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
 		public static function getReturnToResultsUrl($request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Gallery',
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
 			if (!$t_set->load($set_id) || (sizeof($this->opa_access_values) && !in_array($t_set->get('ca_sets.access'), $this->opa_access_values))) { throw new ApplicationException(_t('Invalid set')); }
 			return $t_set;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _getSetItem($set_id, $item_id) {
 			$t_set = $this->_getSet($set_id);
 			
 			$t_item = new ca_set_items($item_id);
 			if (!$t_item->isLoaded() || ((int)$t_item->get('ca_set_items.set_id') !== (int)$set_id)) { throw new ApplicationException(_t('Invalid item')); }
 			return $t_item;
 		}
 		# -------------------------------------------------------
	}
