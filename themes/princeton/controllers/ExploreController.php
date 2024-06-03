<?php
/* ----------------------------------------------------------------------
 * app/controllers/ExploreController.php : 
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
	require_once(__CA_LIB_DIR__."/ApplicationError.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
class ExploreController extends BasePawtucketController {
	# -------------------------------------------------------
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		parent::__construct($po_request, $po_response, $pa_view_paths);
		caSetPageCSSClasses(array("explore"));
		$this->view->setVar('access_values', $this->opa_access_values);
	
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
	}
	# -------------------------------------------------------
	public function Types() {
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")."Explore Types");

		$t_list = new ca_lists();
		
		$va_types = $t_list->getItemsForList("item_type", array("directChildrenOnly" => "1"));
		$va_types_for_display = array();
		if(is_array($va_types) && sizeof($va_types)){
			$t_list_item = new ca_list_items();
			foreach($va_types as $vn_item_id => $va_type){
				$va_type = array_pop($va_type);
				$t_list_item->load($vn_item_id);
				$va_types_for_display[$vn_item_id] = array("name" => $va_type["name_singular"], "image" => $t_list_item->get("ca_list_items.icon.largeicon", array("alt" => "Image for ".$va_type["name_singular"])), "children" => (($t_list_item->get("ca_list_items.children.item_id")) ? true : false));
			}
		}
				
		$this->view->setVar("types", $va_types_for_display);
		caSetPageCSSClasses(array("types", "landing"));
		$this->render("Explore/types_index_html.php");
	}
	# -------------------------------------------------------
	public function TypesDetail() {
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")."Explore Types");

		$t_list = new ca_lists();
		
		$pn_type_id = $this->request->getParameter('type_id', pInteger);
		if(!$pn_type_id){
			$this->Index();
			return;
		}
		$vs_type_name = $t_list->getItemForDisplayByItemID($pn_type_id, array("return" => "plural"));
		$va_types = $t_list->getChildItemsForList("item_type", $pn_type_id, array("directChildrenOnly" => "1"));
		$va_levels = $t_list->getItemsForList("item_type", array("returnHierarchyLevels" => true));
		$va_level_info = array_pop($va_levels[$pn_type_id]);
		$vs_level = $va_level_info["LEVEL"];
		$this->view->setVar("level", $vs_level);
		$t_list_item = new ca_list_items();
		$t_list_item->load($pn_type_id);
		$vn_root_id = $t_list->getRootItemIDForList("item_type");
		$vn_parent_id = $t_list_item->get("ca_list_items.parent_id");
		
		if($vn_root_id != $vn_parent_id){
			$this->view->setVar("parent_id", $vn_parent_id);
		}
		
		$va_types_for_display = array();
		if(is_array($va_types) && sizeof($va_types)){
			foreach($va_types as $vn_item_id => $va_type){
				$va_type = array_pop($va_type);
				$t_list_item->load($vn_item_id);
				$va_types_for_display[$vn_item_id] = array("name" => $va_type["name_singular"], "image" => $t_list_item->get("ca_list_items.icon.largeicon", array("alt" => "Image for ".$va_type["name_singular"])), "children" => (($t_list_item->get("ca_list_items.children.item_id")) ? true : false));
			}
		}
				
		$this->view->setVar("types", $va_types_for_display);
		$this->view->setVar("type_name", $vs_type_name);
		
		caSetPageCSSClasses(array("types"));
		$this->render("Explore/types_detail_html.php");
	}
	# -------------------------------------------------------
	public function Places() {
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")."Explore Places");
		AssetLoadManager::register("maps");
		$vs_set_code = $this->request->config->get("explore_places_set_code");
		if($vs_set_code){
			$t_set = new ca_sets();
 			$t_set->load(array('set_code' => $vs_set_code));
 			if($t_set->get("ca_sets.set_id")){
				# Enforce access control on set
				if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
					$va_set_items = $t_set->getItemRowIDs(array("checkAccess" => $this->opa_access_values));
					if(is_array($va_set_items) && sizeof($va_set_items)){
						$this->view->setVar("set", $t_set);
							$o_res = caMakeSearchResult(
								$t_set->get('table_num'),
								array_keys($va_set_items),
								['checkAccess' => $this->opa_access_values]
							);
				
						$o_map = new GeographicMap('100%', 500, 'map');
						$va_map_stats = $o_map->mapFrom($o_res, "ca_places.georeference", array("labelTemplate" => "^ca_places.preferred_labels%delimiter=; ", "ajaxContentUrl" => caNavUrl($this->request, "", "Explore", "getMapItemInfo"), "request" => $this->request, "checkAccess" => $this->opa_access_values));
						$this->view->setVar("map", $o_map->render('HTML', array('delimiter' => "<br/>")));	
					}
				}
			}
		}
		
		
		caSetPageCSSClasses(array("places", "landing"));
		$this->render("Explore/places_index_html.php");
	}
	# -------------------------------------------------------
	public function getMapItemInfo() {
		$pa_place_ids = explode(';', $this->request->getParameter('id', pString));
		
		$this->view->setVar('place_ids', $pa_place_ids);
		$this->view->setVar('access_values', $this->opa_access_values);
		
		$this->render("Explore/map_balloon_html.php");		
	}	
	# -------------------------------------------------------
}