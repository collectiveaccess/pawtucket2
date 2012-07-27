<?php
/* ----------------------------------------------------------------------
 * includes/DashboardController.php
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
 	require_once(__CA_LIB_DIR__.'/ca/Search/EntitySearch.php');
 	require_once(__CA_LIB_DIR__.'/ca/Search/ObjectSearch.php');
 
 	class DashboardController extends ActionController {
 		# -------------------------------------------------------
 		private $opo_plugin_config;			// plugin config file
 		private $ops_theme;						// current theme
 		private $opo_result_context;			// current result context
 		
 		private $opn_member_institution_id = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			
 			$this->ops_theme = __CA_THEME__;																	// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/NovaStory/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			parent::__construct($po_request, $po_response, array(__CA_APP_DIR__.'/plugins/NovaStory/themes/'.$this->ops_theme.'/views'));
 			
			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/NovaStory/conf/NovaStory.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('NovaStory plugin is not enabled')); }
 			
 			MetaTagManager::addLink('stylesheet', $po_request->getBaseUrlPath()."/app/plugins/NovaStory/themes/".$this->ops_theme."/css/dashboard.css",'text/css');
 			
 			$this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'dashboard');

 			$t_list = new ca_lists();
 		 	$this->opn_member_institution_id = $t_list->getItemIDFromList('entity_types', 'member_institution');
 		 	$this->opn_individual_id = $t_list->getItemIDFromList('entity_types', 'ind');
 		 	$this->opn_family_id = $t_list->getItemIDFromList('entity_types', 'fam');
 		 	$this->opn_organization_id = $t_list->getItemIDFromList('entity_types', 'org');
 		 	 			
 			$va_access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $va_access_values;
			$this->view->setVar('access_values', $va_access_values);
			
 		}
 		# -------------------------------------------------------
 		/**
 		 * Displays site stats
 		 */
 		public function Index() {
 			
			$this->view->setVar("num_objects", $this->numObjects());
			$this->view->setVar("num_objects_60_days", $this->numObjects(time() - (60*24*60*60)));
			$this->view->setVar("num_members", $this->numEntities(array($this->opn_member_institution_id)));
 			$this->view->setVar("num_entities", $this->numEntities(array($this->opn_organization_id, $this->opn_family_id, $this->opn_individual_id)));
 			
 			$this->render('dashboard_html.php');
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 * num entities - returns count of all public entities by default
 		 * pass an array of type_ids to restrict to type
 		 */
 		private function numEntities($va_type_ids = array()) {
 			$o_search = new EntitySearch();
 			if(is_array($va_type_ids) && sizeof($va_type_ids)){
 				$o_search->setTypeRestrictions($va_type_ids);
 			}
			$o_search->addResultFilter("ca_entities.access", "IN", join(',', $this->opa_access_values));
			$qr_res = $o_search->search("*");
 			
 			return $qr_res->numHits();
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 * objects - accept timestamp to find num objects since a time
 		 */
 		private function numObjects($vn_since_timestamp = "") {
 			
			$o_search = new ObjectSearch();
 		 	$o_search->addResultFilter("ca_objects.access", "IN", join(',', $this->opa_access_values));
 		 	if($vn_since_timestamp){
 		 		#$o_search->addResultFilter("ca_objects.dates", ">", $vn_since_timestamp);
 		 	}
			$qr_res = $o_search->search("*");
 			
 			
 			return $qr_res->numHits();
 		}
 		
 		# -------------------------------------------------------
 	}
 ?>
