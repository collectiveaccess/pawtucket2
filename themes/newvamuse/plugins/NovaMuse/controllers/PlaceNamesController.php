<?php
/* ----------------------------------------------------------------------
 * includes/PlaceNamesController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
 
require_once(__CA_MODELS_DIR__.'/ca_entities.php');
require_once(__CA_MODELS_DIR__.'/ca_lists.php');
require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
require_once(__CA_LIB_DIR__.'/ResultContext.php');
require_once(__CA_LIB_DIR__.'/GeographicMap.php');
require_once(__CA_LIB_DIR__.'/Search/EntitySearch.php');

class PlaceNamesController extends ActionController {
	# -------------------------------------------------------
	private $opo_plugin_config;			// plugin config file
	private $ops_theme;						// current theme
	private $opo_result_context;			// current result context
	
	private $opn_member_institution_id = null;
	
	# -------------------------------------------------------
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		
		$this->ops_theme = __CA_THEME__;																	// get current theme
		if(!is_dir(__CA_THEMES_DIR__.'/newvamuse/plugins/NovaMuse/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
			$this->ops_theme = 'default';
		}
		parent::__construct($po_request, $po_response, array(__CA_THEMES_DIR__.'/newvamuse/plugins/NovaMuse/themes/'.$this->ops_theme.'/views'));
		
		$this->opo_plugin_config = Configuration::load(__CA_THEMES_DIR__.'/newvamuse/plugins/NovaMuse/conf/NovaMuse.conf');
		
		if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('NovaMuse plugin is not enabled')); }
		
		MetaTagManager::addLink('stylesheet', __CA_THEMES_URL__."/newvamuse/plugins/NovaMuse/themes/".$this->ops_theme."/css/memberMap.css",'text/css');
		AssetLoadManager::register('maps');
		
		$this->opo_result_context = new ResultContext($po_request, 'ca_entities', 'member_map');
		
		$t_list = new ca_lists();
		$this->opn_member_institution_id = $t_list->getItemIDFromList('entity_types', 'member_institution');
		
		$va_access_values = caGetUserAccessValues($this->request);
		$this->opa_access_values = $va_access_values;
		$this->view->setVar('access_values', $va_access_values);
		
	}
	# -------------------------------------------------------
	/**
	 * Displays map of all member inst
	 */
	public function Index() {
		
		$o_search = new PlaceSearch();
		#$o_search->setTypeRestrictions(array($this->opn_member_institution_id));
		$o_search->addResultFilter("ca_places.access", "IN", join(',', $this->opa_access_values));
		
		$o_map = new GeographicMap('100%', 500, 'map');
		
		$place_hierarchies = caGetListItems('place_hierarchies');
		$this->view->setVar('layers', $place_hierarchies);
		foreach($place_hierarchies as $place_hier_id => $place_hier_name) {
			$qr_res = ca_places::findAsSearchResult(['hierarchy_id' => $place_hier_id]);
		
			$va_map_stats = $o_map->mapFrom($qr_res, "georeference", array("group" => $place_hier_id, "ajaxContentUrl" => caNavUrl($this->request, "*", "*", "getMapItemInfo"), "request" => $this->request, "checkAccess" => $this->opa_access_values));
		}
		$this->view->setVar("map", $o_map->render('HTML', array('delimiter' => "<br/>")));
		
		$this->render('place_map_html.php');
	}
	
	# -------------------------------------------------------
	/**
	 *
	 */
	public function getMapItemInfo() {
		$place_ids = explode(';', $this->request->getParameter('id', pString));
		
		$this->view->setVar('place_ids', $place_ids);
		$this->view->setVar('access_values', $this->opa_access_values);
		
		$this->render("place_map_balloon_html.php");		
	}
	
	# -------------------------------------------------------
}
