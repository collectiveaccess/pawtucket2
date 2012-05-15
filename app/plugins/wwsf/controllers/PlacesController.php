<?php
/* ----------------------------------------------------------------------
 * includes/PlacesController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
 	require_once(__CA_MODELS_DIR__.'/ca_sets.php');
 	require_once(__CA_MODELS_DIR__.'/ca_objects.php');
 	require_once(__CA_MODELS_DIR__.'/ca_set_items.php');
 	require_once(__CA_MODELS_DIR__.'/ca_lists.php');
 	require_once(__CA_LIB_DIR__.'/core/GeographicMap.php');
 	require_once(__CA_LIB_DIR__.'/ca/Search/ObjectSearch.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php'); 
 	require_once(__CA_LIB_DIR__.'/core/Zend/Cache.php');
 
 	class PlacesController extends ActionController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			JavascriptLoadManager::register('panel');
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/wwsf/conf/wwsf.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('wwsf plugin is not enabled')); }
 			
 			$this->ops_theme = __CA_THEME__;																		// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/wwsf/views/'.$this->ops_theme)) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			$this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'places');
			$this->opo_result_context->setAsLastFind();
			$this->opo_result_context->saveContext();
			
			JavascriptLoadManager::register('maps');
 		}
 		# -------------------------------------------------------
 		public function Index() {
 			$va_map_options = array(
 				'showScaleControls' => true, 
 				'showMapTypeControls' => false,
 				'mapType' => 'TERRAIN',
 				'minZoomLevel' => 5,
 				'maxZoomLevel' => 8
 			);
 		
 			$va_access_values = caGetUserAccessValues($this->request);
 			// get sets
 			# --- we'll show 3 sets with type city and 3 sets with type village
 			$t_list = new ca_lists();

 			$vn_set_type_city = $t_list->getItemIDFromList('set_types', $this->request->config->get("places_set_type_city"));
 			$vn_set_type_village = $t_list->getItemIDFromList('set_types', $this->request->config->get("places_set_type_village"));
 			
 			$t_set = new ca_sets();
 			$va_all_city_sets = array();
 			$va_all_city_sets = caExtractValuesByUserLocale($t_set->getSets(array("table" => "ca_objects", "checkAccess" => $va_access_values, "setType" => $vn_set_type_city)));
 			$va_city_sets_ids = array_keys($va_all_city_sets);
 			shuffle($va_city_sets_ids);
 			if(sizeof($va_city_sets_ids) > 3){
 				$va_city_sets_ids = array_slice($va_city_sets_ids, 0, 3, TRUE);
 			}

 			foreach($va_city_sets_ids as $vn_city_set_id){
 				$o_map = new GeographicMap(160, 160, 'map'.$vn_city_set_id);
 				$t_set->load($vn_city_set_id);
 				$o_map->mapFrom($t_set, "set_georeference"); 
 				$va_all_city_sets[$vn_city_set_id]["map"] = $o_map->render('HTML', $va_map_options);
 				#print $o_map->render('HTML');
 				$va_city_sets[$vn_city_set_id] = $va_all_city_sets[$vn_city_set_id];
 			}
 			
 			$this->view->setVar('city_sets', $va_city_sets);
 			$va_city_set_first_items = $t_set->getFirstItemsFromSets($va_city_sets_ids, array("version" => "preview160", "checkAccess" => $va_access_values));
			$this->view->setVar('first_items_from_city_sets', $va_city_set_first_items);
 			
 			$va_all_village_sets = array();
 			$va_all_village_sets = caExtractValuesByUserLocale($t_set->getSets(array("table" => "ca_objects", "checkAccess" => $va_access_values, "setType" => $vn_set_type_village)));
 			$va_village_sets_ids = array_keys($va_all_village_sets);
 			shuffle($va_village_sets_ids);
 			if(sizeof($va_village_sets_ids) > 3){
 				$va_village_sets_ids = array_slice($va_village_sets_ids, 0, 3, TRUE);
 			}
 			foreach($va_village_sets_ids as $vn_village_set_id){
 				$o_map = new GeographicMap(160, 160, 'map'.$vn_village_set_id);
 				$t_set->load($vn_village_set_id);
 				$o_map->mapFrom($t_set, "set_georeference"); 
 				$va_all_village_sets[$vn_village_set_id]["map"] = $o_map->render('HTML', $va_map_options);
 				$va_village_sets[$vn_village_set_id] = $va_all_village_sets[$vn_village_set_id];
 			}
 			
 			$this->view->setVar('village_sets', $va_village_sets);
 			$va_village_set_first_items = $t_set->getFirstItemsFromSets($va_village_sets_ids, array("version" => "preview160", "checkAccess" => $va_access_values));
			$this->view->setVar('first_items_from_village_sets', $va_village_set_first_items);
 			
 			$this->render('places_landing_html.php');
 		}
 		# -------------------------------------------------------
 		public function Map() {
 			$va_map_options = array(
 				'showScaleControls' => true, 
 				'showMapTypeControls' => false,
 				'mapType' => 'TERRAIN',
 				'minZoomLevel' => 5,
 				'maxZoomLevel' => 8
 			);
 			
 			$o_cache = PlacesController::_getCacheObject();
 			if (!($vs_map = $o_cache->load("wwsf_map"))) {
 				$o_map = new GeographicMap(500, 500, 'placesMap');
 				$o_search = new ObjectSearch();
 				$qr_res = $o_search->search("*", array("limit" => 10000));
 				$o_map->mapFrom($qr_res, "georeference", array("ajaxContentUrl" => caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'getMapItemInfo'), 'request' => $this->request, 'checkAccess' => $va_access_values)); 
 				$o_map->fitExtentsToMapItems();
 				$o_cache->save($vs_map = $o_map->render('HTML', $va_map_options), "wwsf_map");
 			}
 			$this->view->setVar('map', $vs_map);
 			$this->render('places_map_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 * Ajax action that returns info on a mapped location based upon the 'id' request parameter.
 		 * 'id' is a list of object_ids to display information before. Each integer id is separated by a semicolon (";")
 		 * The "ca_objects_results_map_balloon_html" view in Results/ is used to render the content.
 		 */ 
 		public function getMapItemInfo() {
 			$pa_object_ids = explode(';', $this->request->getParameter('id', pString));
 			
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			$this->view->setVar('ids', $pa_object_ids);
 			$this->view->setVar('access_values', $va_access_values);
 			
 		 	$this->render("map_balloon_html.php");
 		 }
 		 # ------------------------------------------------------
		/**
		  *
		  */
		static public function _getCacheObject() {
			$va_frontend_options = array(
				'lifetime' => 3600, 				/* cache lives 1 hour */
				'logging' => false,					/* do not use Zend_Log to log what happens */
				'write_control' => true,			/* immediate read after write is enabled (we don't write often) */
				'automatic_cleaning_factor' => 100, 	/* automatic cache cleaning */
				'automatic_serialization' => true	/* we store arrays, so we have to enable that */
			);
			
			$o_config = Configuration::load();
			$va_backend_options = array(
				'cache_dir' =>  __CA_APP_DIR__.'/tmp',		/* where to store cache data? */
				'file_locking' => true,				/* cache corruption avoidance */
				'read_control' => false,			/* no read control */
				'file_name_prefix' => 'ca_browse_'.$o_config->get('app_name'),	/* prefix of cache files */
				'cache_file_umask' => 0700			/* permissions of cache files */
			);


			try {
				return Zend_Cache::factory('Core', 'File', $va_frontend_options, $va_backend_options);
			} catch (exception $e) {
				return null;
			}
		}
		# -------------------------------------------------------
 	}
 ?>
