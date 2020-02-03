<?php
/* ----------------------------------------------------------------------
 * app/controllers/FeaturedController.php : 
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
 	
 	class FeaturedController extends BasePawtucketController {
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
            
 			$this->config = Configuration::load(__CA_THEME_DIR__.'/conf/featured.conf');
 			$this->view->setVar("config", $this->config);
 			
 		 	# --- what is the section called - title of page
 			if(!$vs_section_name = $this->config->get('featured_section_name')){
 				$vs_section_name = _t("Featured");
 			}
 			$this->view->setVar("section_name", $vs_section_name);
 			if(!$vs_section_item_name = $this->config->get('featured_section_item_name')){
 				$vs_section_item_name = _t("feature");
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
 		}
 		# -------------------------------------------------------
 		public function index() {
			$va_access_values = caGetUserAccessValues($this->request);
			$vn_featured_set_id = "";
 			$va_featured_ids = array();
 			if($vs_set_code = $this->config->get("featured_set_code")){
 				$t_set = new ca_sets();
 				$t_set->load(array('set_code' => $vs_set_code));
 				$vn_featured_set_id = $t_set->get("ca_sets.set_id");
 				$this->view->setVar('featured_set_id', $vn_featured_set_id);
 				$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("checkAccess" => $this->opa_access_values)));
 				$this->view->setVar("set_items", $va_set_items);
 				$va_row_to_item = array();
 				foreach($va_set_items as $vn_item_id => $va_set_item){
 					$va_item_to_row[$va_set_item["row_id"]] = $vn_item_id;
 				}
 				$this->view->setVar("row_to_items", $va_item_to_row);
				# Enforce access control on set
				if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
					$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
					$qr_res = caMakeSearchResult('ca_objects', $va_featured_ids);
					$this->view->setVar("featured_set_results", $qr_res);
				}
 			}

			$t_list = new ca_lists();
			
			# --- which type of set is configured for display in featured section
 			$vn_featured_set_type_id = $t_list->getItemIDFromList('set_types', $this->config->get('featured_set_type')); 			
 			$va_set_media_for_theme = array();
				
 			$t_set = new ca_sets();
 			if($vn_featured_set_type_id){
				$va_tmp = array('checkAccess' => $this->opa_access_values, 'setType' => $vn_featured_set_type_id, $va_tmp["table"] = "ca_objects");
				
				$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
				$va_set_first_items_media = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $this->opa_access_values));
	
				$va_set_ids = array_keys($va_sets);
				shuffle($va_set_ids);
				$qr_sets = caMakeSearchResult("ca_sets", $va_set_ids);
			
				$vs_landing_featured_set_code = $this->config->get("featured_set_code");
				if($qr_sets && $qr_sets->numHits()){
					while($qr_sets->nextHit()) {
						if (!$va_set_media_for_theme[$qr_sets->get('ca_sets.featured_theme')] && ($qr_sets->get('set_code') != $vs_landing_featured_set_code)) { 
							$va_tmp = array_shift($va_set_first_items_media[$qr_sets->get('ca_sets.set_id')]);
							$va_set_media_for_theme[$qr_sets->get('ca_sets.featured_theme')] = $va_tmp['representation_tag'];
						}
					}
				}
			}
			$va_tmp = $t_list->getItemsForList("featured_set_themes", array("extractValuesByUserLocale" => true));

			$t_list_item = new ca_list_items();
			$va_themes = array();
			foreach($va_tmp as $vn_theme_id => $va_theme_info){
				$t_list_item->load($vn_theme_id);
				$va_themes[] = array(
					"theme_id" => $vn_theme_id,
					"name" => $va_theme_info["name_singular"],
					"media" => $va_set_media_for_theme[$vn_theme_id]
				);
			}
			$this->view->setVar('themes', $va_themes);
			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").(($this->config->get('featured_section_name')) ? $this->config->get('featured_section_name') : _t("Featured")));
			$this->render("Featured/index_html.php"); 		
 		}
 		# --------------------------------------------------------
 		public function theme(){
 			$vn_theme_id = $this->request->getParameter('theme_id', pInteger);
			$t_list_item = new ca_list_items($vn_theme_id);
			$this->view->setVar('theme_id', $vn_theme_id);
			$this->view->setVar('theme', $t_list_item->get("ca_list_items.preferred_labels"));
			$this->view->setVar('theme_description', $t_list_item->get("ca_list_items.description"));
				
 			# --- which type of set is configured for display in featured section
 			$t_list = new ca_lists();
 			$vn_featured_set_type_id = $t_list->getItemIDFromList('set_types', $this->config->get('featured_set_type')); 			
 			
 			$t_set = new ca_sets();
 			if($vn_featured_set_type_id){
				$va_tmp = array('checkAccess' => $this->opa_access_values, 'setType' => $vn_featured_set_type_id, $va_tmp["table"] = "ca_objects");
				
				$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
				$va_set_first_items_media = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $this->opa_access_values));
	
				$qr_sets = caMakeSearchResult("ca_sets", array_keys($va_sets));
			
				$vs_landing_featured_set_code = $this->config->get("featured_set_code");
				$va_sets_for_theme = array();
				$vs_set_desc_code = $this->config->get('featured_set_description_element_code');
				if($qr_sets && $qr_sets->numHits()){
					while($qr_sets->nextHit()) {
						if (($qr_sets->get('ca_sets.featured_theme') ==  $vn_theme_id) && ($qr_sets->get('set_code') != $vs_landing_featured_set_code)) { 
							$va_tmp = array_shift($va_set_first_items_media[$qr_sets->get('ca_sets.set_id')]);
							$vs_media = $va_tmp['representation_tag'];
							$va_sets_for_theme[$qr_sets->get('ca_sets.set_id')] = array(
								"title" => $qr_sets->get('ca_sets.preferred_labels.name'),
								"description" => $qr_sets->get('ca_sets.'.$vs_set_desc_code),
								"media" => $vs_media
							);
						}
					}
				}
				$this->view->setVar('sets', $va_sets_for_theme);
			}
			$this->render('Featured/theme_html.php');
 		}
 		# --------------------------------------------------------
 		public function detail(){
 			$t_set = new ca_sets();
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
			$this->view->setVar("set_id", $pn_set_id);
			$t_set->load($pn_set_id);
			$this->view->setVar("set", $t_set);
			
			$vs_table = Datamodel::getTableName($t_set->get('table_num'));
			# --- don't save the featured context when loaded via ajax
			if (!$this->request->isAjax()){
				$o_context = new ResultContext($this->request, $vs_table, 'featured');
				$o_context->setAsLastFind();
				$o_context->setResultList(array_keys($t_set->getItemRowIDs(array("checkAccess" => $this->opa_access_values))));
				$o_context->saveContext();
			} 				 				
			$this->view->setVar("label", $t_set->getLabelForDisplay());
			$this->view->setVar("description", $t_set->get($this->config->get('featured_set_description_element_code')));
			$this->view->setVar("set_items", caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersions" => array("icon", "iconlarge"), "checkAccess" => $this->opa_access_values))));
			$pn_set_item_id = $this->request->getParameter('set_item_id', pInteger);
			if(!in_array($pn_set_item_id, array_keys($t_set->getItemIDs(array("checkAccess" => $this->opa_access_values))))){
				$pn_set_item_id = "";	
			}
			$this->view->setVar("set_item_id", $pn_set_item_id);
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").(($this->config->get('featured_section_name')) ? $this->config->get('featured_section_name') : _t("Featured")).$this->request->config->get("page_title_delimiter").$t_set->getLabelForDisplay());
			$vs_display_attribute = $this->config->get('featured_set_presentation_element_code');
			$vs_display = "";
			if($vs_display_attribute){
				$vs_display = $t_set->get('ca_sets.'.$vs_display_attribute, ['convertCodesToIdno' => true]);
			}
			switch($vs_display) {
				case 'timeline':
					AssetLoadManager::register('timeline');
					$this->render('Featured/set_detail_timeline_html.php');
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
	
						$va_opts['ajaxContentUrl'] = caNavUrl($this->request, '*', '*', 'AjaxGetMapItem', array('set_id' => $pn_set_id));
		
						$o_map = new GeographicMap(caGetOption("width", $va_views_info, "100%"), caGetOption("height", $va_views_info, "600px"));
						$o_map->mapFrom($o_res, $va_views_info['data'], $va_opts);
						$this->view->setVar('map', $o_map->render('HTML', array('circle' => 0, 'minZoomLevel' => caGetOption("minZoomLevel", $va_views_info, 2), 'maxZoomLevel' => caGetOption("maxZoomLevel", $va_views_info, 12), 'request' => $this->request)));
						$this->render("Featured/set_detail_map_html.php");
					}else{
						$this->render("Featured/detail_html.php");
					}
					break;
				case 'slideshow':
				default:
					$this->render("Featured/detail_html.php");
					break;
			}
 		}
 		# --------------------------------------------------------
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
 			$this->view->setVar("description", $t_set->get($this->config->get('featured_set_description_element_code')));
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
 			$this->render("Fetaured/set_info_html.php");
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
					$this->render('Featured/set_detail_timeline_json.php');
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
            $vs_content_template = $va_view_info['display']['icon'].$va_view_info['display']['title_template'].$va_view_info['display']['description_template'];
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
				$this->view->setVar("repToolBar", caRepToolbar($this->request, $t_rep, $va_set_items[$pn_item_id]["row_id"], ['context' => 'fetaured']));
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
 			$this->render("Featured/set_item_rep_html.php");
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
 			
 			$this->view->setVar("t_set_item", $t_set_item);
 			
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
 			$va_tag_list = $this->getTagListForView("Featured/set_item_info_html.php");				// get list of tags in view
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
 			
 			$this->render("Featured/set_item_info_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Featured',
 				'action' => 'Index',
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
