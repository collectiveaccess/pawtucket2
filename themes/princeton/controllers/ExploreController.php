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
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")."Explore");

		$t_list = new ca_lists();
		
		$va_types = $t_list->getItemsForList("item_type", array("directChildrenOnly" => "1"));
		$va_types_for_display = array();
		if(is_array($va_types) && sizeof($va_types)){
			$t_list_item = new ca_list_items();
			foreach($va_types as $vn_item_id => $va_type){
				$va_type = array_pop($va_type);
				$t_list_item->load($vn_item_id);
				$va_types_for_display[$vn_item_id] = array("name" => $va_type["name_singular"], "image" => $t_list_item->get("ca_list_items.icon.large"), "children" => (($t_list_item->get("ca_list_items.children.item_id")) ? true : false));
			}
		}
				
		$this->view->setVar("types", $va_types_for_display);
		caSetPageCSSClasses(array("types", "landing"));
		$this->render("Explore/types_index_html.php");
	}
	# -------------------------------------------------------
	public function TypesDetail() {
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")."Types");

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
				$va_types_for_display[$vn_item_id] = array("name" => $va_type["name_singular"], "image" => $t_list_item->get("ca_list_items.icon.large"), "children" => (($t_list_item->get("ca_list_items.children.item_id")) ? true : false));
			}
		}
				
		$this->view->setVar("types", $va_types_for_display);
		$this->view->setVar("type_name", $vs_type_name);
		
		caSetPageCSSClasses(array("types"));
		$this->render("Explore/types_detail_html.php");
	}
	# -------------------------------------------------------
}