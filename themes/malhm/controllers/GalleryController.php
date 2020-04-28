<?php
/* ----------------------------------------------------------------------
 * app/controllers/GalleryController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2016 Whirl-i-Gig
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
 			$this->opo_datamodel = Datamodel::load();
 			
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
 			$va_sets_by_type = array();
 			$va_all_set_ids = array();
 			$t_list = new ca_lists();
 			$t_set = new ca_sets();
 			if($ps_function == "index"){
 				$va_set_confs = $this->config->get('set_types');
				if(is_array($va_set_confs) && sizeof($va_set_confs)){
					foreach ($va_set_confs as $va_set_types => $vs_set_conf) {
						$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $vs_set_conf['type']); 
						if($vn_gallery_set_type_id){
							$va_sets_by_type[$vs_set_conf['type']] = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $this->opa_access_values, 'setType' => $vs_set_conf['type'], 'sort' => 'ca_sets.set_rank')));
							array_push( $va_all_set_ids, caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $this->opa_access_values, 'setType' => $vs_set_conf['type']))));
						}
					} 
				}
				
				$this->view->setVar('sets_by_type', $va_sets_by_type);
				#$this->view->setVar('first_items_from_sets', $va_set_first_items);
				
				MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": ".(($this->config->get('gallery_section_name')) ? $this->config->get('gallery_section_name') : _t("Gallery")));
 				$this->render("Gallery/index_html.php");
 			}elseif ($ps_function == "featured") {
 				$va_set_confs = $this->config->get('set_types');
 				$this->view->setVar('sets_typename', $this->request->getActionExtra());
 				$this->view->setVar('sets_type_config', $va_set_confs);
 				$this->render("Gallery/featured_types_html.php");
 			} else {
 				$ps_set_id = $ps_function;
 				$this->view->setVar("set_id", $ps_set_id);
 				$t_set->load($ps_set_id);
 				$this->view->setVar("set", $t_set);
 				
 				$o_context = new ResultContext($this->request, 'ca_objects', 'gallery');
 				$o_context->setAsLastFind();
 				$o_context->setResultList(array_keys($t_set->getItemRowIDs()));
 				$o_context->saveContext();
 				 				
 				$this->view->setVar("label", $t_set->getLabelForDisplay());
 				$this->view->setVar("description", $t_set->get($this->config->get('gallery_set_description_element_code')));
 				$this->view->setVar("set_items", caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersions" => array("icon", "iconlarge"), "checkAccess" => $this->opa_access_values))));
 				$pn_set_item_id = $this->request->getParameter('set_item_id', pInteger);
 				if(!in_array($pn_set_item_id, array_keys($t_set->getItemIDs()))){
 					$pn_set_item_id = "";	
 				}
 				$this->view->setVar("set_item_id", $pn_set_item_id);
 				
 				# --- section name
 				$va_set_confs = $this->config->get('set_types');
 				$t_list_item = new ca_list_items(array("item_id" => $t_set->get("type_id")));
 				if($vs_section_name = $va_set_confs[$t_list_item->get("idno")]["name"]){
 					$this->view->setVar("section_name", $vs_section_name);
 				}
 				MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": ".(($this->config->get('gallery_section_name')) ? $this->config->get('gallery_section_name') : _t("Gallery")).": ".$t_set->getLabelForDisplay());
 				$this->render("Gallery/detail_html.php");
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
 			$this->view->setVar("set_item", array_shift(array_shift($t_set->getPrimaryItemsFromSets(array($pn_set_id), array("version" => "large", "checkAccess" => $this->opa_access_values)))));
 			
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
 			$t_object = new ca_objects($t_set_item->get("row_id"));
 			$va_set_item_ids = array_keys($t_set->getItemIDs(array("checkAccess" => $this->opa_access_values)));
 			$this->view->setVar("item_id", $pn_item_id);
 			$this->view->setVar("set_num_items", sizeof($va_set_item_ids));
 			$this->view->setVar("set_item_num", (array_search($pn_item_id, $va_set_item_ids) + 1));
 			
 			$this->view->setVar("object", $t_object);
 			$this->view->setVar("object_id", $t_set_item->get("row_id"));
 			$this->view->setVar("label", $t_object->getLabelForDisplay());
 			
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
 					$this->view->setVar($vs_tag, $t_object->getWithTemplate($vs_tag, array('checkAccess' => $this->opa_access_values)));
 				} elseif (strpos($vs_tag, ".") !== false) {
 					$this->view->setVar($vs_tag, $t_object->get($vs_tag, array('checkAccess' => $this->opa_access_values)));
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
