<?php
/* ----------------------------------------------------------------------
 * app/controllers/ThemesController.php : 
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
 
class ThemesController extends BasePawtucketController {
	# -------------------------------------------------------
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		parent::__construct($po_request, $po_response, $pa_view_paths);
		caSetPageCSSClasses(array("themes"));
		$this->view->setVar('access_values', $this->opa_access_values);
	
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
	}
	# -------------------------------------------------------
	public function Index() {
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")."Themes");

		$t_list = new ca_lists();
		
		$va_themes = $t_list->getItemsForList("dictionarythemes", array("directChildrenOnly" => "1"));
		$va_themes_for_display = array();
		if(is_array($va_themes) && sizeof($va_themes)){
			$t_list_item = new ca_list_items();
			foreach($va_themes as $vn_item_id => $va_theme){
				$va_theme = array_pop($va_theme);
				$t_list_item->load($vn_item_id);
				$va_themes_for_display[$vn_item_id] = array("name" => $va_theme["name_singular"], "image" => $t_list_item->get("ca_list_items.icon.large"), "children" => (($t_list_item->get("ca_list_items.children.item_id")) ? true : false));
			}
		}
				
		$this->view->setVar("themes", $va_themes_for_display);
		caSetPageCSSClasses(array("themes", "landing"));
		$this->render("Themes/index_html.php");
	}
	# -------------------------------------------------------
	public function Detail() {
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")."Themes");

		$t_list = new ca_lists();
		
		$pn_theme_id = $this->request->getParameter('theme_id', pInteger);
		if(!$pn_theme_id){
			$this->Index();
			return;
		}
		$vs_theme_name = $t_list->getItemForDisplayByItemID($pn_theme_id, array("return" => "plural"));
		$va_themes = $t_list->getChildItemsForList("dictionarythemes", $pn_theme_id, array("directChildrenOnly" => "1"));
		$va_levels = $t_list->getItemsForList("dictionarythemes", array("returnHierarchyLevels" => true));
		$va_level_info = array_pop($va_levels[$pn_theme_id]);
		$vs_level = $va_level_info["LEVEL"];
		$this->view->setVar("level", $vs_level);
		$t_list_item = new ca_list_items();
		$t_list_item->load($pn_theme_id);
		$vn_root_id = $t_list->getRootItemIDForList("dictionarythemes");
		$vn_parent_id = $t_list_item->get("ca_list_items.parent_id");
		
		if($vn_root_id != $vn_parent_id){
			$this->view->setVar("parent_id", $vn_parent_id);
		}
		
		$va_themes_for_display = array();
		if(is_array($va_themes) && sizeof($va_themes)){
			foreach($va_themes as $vn_item_id => $va_theme){
				$va_theme = array_pop($va_theme);
				$t_list_item->load($vn_item_id);
				$va_themes_for_display[$vn_item_id] = array("name" => $va_theme["name_singular"], "image" => $t_list_item->get("ca_list_items.icon.large"), "children" => (($t_list_item->get("ca_list_items.children.item_id")) ? true : false));
			}
		}
				
		$this->view->setVar("themes", $va_themes_for_display);
		$this->view->setVar("theme_name", $vs_theme_name);
		
		caSetPageCSSClasses(array("themes"));
		$this->render("Themes/detail_html.php");
	}
	# -------------------------------------------------------
}