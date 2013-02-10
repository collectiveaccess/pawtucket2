<?php
/* ----------------------------------------------------------------------
 * includes/MemberMapController.php
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
 	require_once(__CA_LIB_DIR__.'/ca/ResultContext.php');
 	require_once(__CA_LIB_DIR__.'/core/GeographicMap.php');
 	require_once(__CA_LIB_DIR__.'/ca/Search/EntitySearch.php');
 
 	class MemberMapController extends ActionController {
 		# -------------------------------------------------------
 		private $opo_plugin_config;			// plugin config file
 		private $ops_theme;						// current theme
 		private $opo_result_context;			// current result context
 		
 		private $opn_member_institution_id = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			
 			$this->ops_theme = __CA_THEME__;																	// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/NovaMuse/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			parent::__construct($po_request, $po_response, array(__CA_APP_DIR__.'/plugins/NovaMuse/themes/'.$this->ops_theme.'/views'));
 			
			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/NovaMuse/conf/NovaMuse.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('NovaMuse plugin is not enabled')); }
 			
 			MetaTagManager::addLink('stylesheet', $po_request->getBaseUrlPath()."/app/plugins/NovaMuse/themes/".$this->ops_theme."/css/memberMap.css",'text/css');
 			JavascriptLoadManager::register('maps');
 			
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
 			
			$o_search = new EntitySearch();
 		 	#$o_search->setTypeRestrictions(array($this->opn_member_institution_id));
 			$o_search->addResultFilter("ca_entities.access", "IN", join(',', $this->opa_access_values));
			//$qr_res = $o_search->search("*", array('sort' => 'ca_entity_labels.name', 'sort_direction' => 'asc'));
 			$qr_res = $o_search->search("ca_entities.type_id:".$this->opn_member_institution_id);		// This is fastest
 			$o_map = new GeographicMap(900, 500, 'map');
			$va_map_stats = $o_map->mapFrom($qr_res, "georeference", array("ajaxContentUrl" => caNavUrl($this->request, "NovaMuse", "MemberMap", "getMapItemInfo"), "request" => $this->request, "checkAccess" => $this->opa_access_values));
			$this->view->setVar("map", $o_map->render('HTML', array('delimiter' => "<br/>")));
 			
 			$this->render('member_map_html.php');
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function getMapItemInfo() {
 			$pa_entity_ids = explode(';', $this->request->getParameter('id', pString));
 			
 			$this->view->setVar('entity_ids', $pa_entity_ids);
 			$this->view->setVar('access_values', $this->opa_access_values);
 			
 		 	$this->render("member_map_balloon_html.php");		
 		}
 		
 		# -------------------------------------------------------
 	}
 ?>
