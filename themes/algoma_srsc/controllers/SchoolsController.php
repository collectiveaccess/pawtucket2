<?php
/* ----------------------------------------------------------------------
 * /controllers/SchoolsController.php : 
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
 	require_once(__CA_MODELS_DIR__."/ca_entities.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	require_once(__CA_LIB_DIR__.'/Search/EntitySearch.php');
 	
 	class SchoolsController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$request, &$response, $view_paths=null) {
 			parent::__construct($request, $response, $view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            
            caSetPageCSSClasses(array("schools"));
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Schools");
 			
 			$this->config = Configuration::load("schools.conf");
 			
 			$t_list = new ca_lists();
 		 	$this->opn_school_id = $t_list->getItemIDFromList('entity_types', $this->config->get("entity_type"));
 		 	
 		 	$access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $access_values;
			$this->view->setVar('access_values', $access_values);
			$this->view->setVar('config', $this->config);
 		}
 		# -------------------------------------------------------
 		public function __call($function, $args){
 			$o_search = new EntitySearch();
 		 	if(is_array($this->opa_access_values) && sizeof($this->opa_access_values)){
 		 		$o_search->addResultFilter("ca_entities.access", "IN", join(',', $this->opa_access_values));
			}
			$qr_res = $o_search->search("ca_entities.type_id:".$this->opn_school_id, array("sort" => "ca_entity_labels.displayname"));
 			
 			$map_info = $this->config->get("map_info");
 		 	if (!is_array($map_attributes = caGetOption(['data', 'mapAttributes', 'map_attributes'], $map_info, array())) || !sizeof($map_attributes)) {
				if ($map_attribute = caGetOption('data', $map_info, false)) { $map_attributes = array($map_attribute); }
			}
			
			if(is_array($map_attributes) && sizeof($map_attributes)) {			
				$map_options = [
					'width' => caGetOption(['mapWidth', 'map_width'], $map_info, 300),
					'height' => caGetOption(['mapHeight', 'map_height'], $map_info, 300),
					'zoom' => caGetOption(['mapZoomLevel', 'zoom_level'], $map_info, 5), 
					'minZoom' => caGetOption(['mapMinZoomLevel'], $map_info, 1), 
					'maxZoom' => caGetOption(['mapMaxZoomLevel'], $map_info, 15),
					'infoTemplate' => caGetOption(['mapItemInfoTemplate'], $map_info, ''),
					'themePath' => __CA_THEMES_URL__.'/default'
				];
				$this->view->setVar('mapOptions', $map_options);
				
				$map_data = [];
				foreach($map_attributes as $map_attribute) {
					$adata = caGetCoordinateDataFromResult($qr_res, $map_attribute, $map_options);
					$map_data = array_merge($map_data ?? [], $adata['coordinates'] ?? []);
				}
				if (sizeof($map_data ?? []) > 0) {
					$this->view->setVar("showMap", true);
					$this->view->setVar('mapData', $map_data);
					$map_options['data'] = $map_data;
					$this->view->setVar('mapOptions', $map_options);
				}
			}
			$qr_res->seek(0);
 		 	$context = new ResultContext($this->request, "ca_entities", "schools");
			$context->setAsLastFind();
			$context->setResultList($qr_res->getPrimaryKeyValues(200));
			$context->saveContext();
 			$this->view->setVar("school_results", $qr_res);

 			$this->render("Schools/schools_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($request) {
 			$ret = array(
 				'module_path' => '',
 				'controller' => 'Schools',
 				'action' => $request->getAction(),
 				'params' => array(
 					
 				)
 			);
			return $ret;
 		}
 	}
