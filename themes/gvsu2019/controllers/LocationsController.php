<?php
/* ----------------------------------------------------------------------
 * app/controllers/LocationsController.php : 
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
 	require_once(__CA_APP_DIR__."/helpers/themeHelpers.php");
 	require_once(__CA_MODELS_DIR__."/ca_storage_locations.php");
 	require_once(__CA_MODELS_DIR__."/ca_lists.php");
 	
 	class LocationsController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private $ops_find_type = "locations";
 		private $opo_result_context = null;
 		private $opa_access_values = null;
 		private $opo_config = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
 			$this->opo_config = Configuration::load(__CA_THEME_DIR__.'/conf/locations.conf');
 			$this->view->setVar("locations_config", $this->opo_config);
 			$this->opa_access_values = caGetUserAccessValues($this->request);
 		 	$this->view->setVar("access_values", $this->opa_access_values);
 		 	# --- what is the section called - title of page
 			if(!$vs_section_name = $this->opo_config->get('locations_section_name')){
 				$vs_section_name = _t("Locations");
 			}
 			$this->view->setVar("section_name", $vs_section_name);
 			
 			# --- convert type idnos to id's
 			$va_non_linkable_location_type_ids = array();
			$t_list = new ca_lists();
			if($va_non_linkable_location_type_idnos = $this->opo_config->get("non_linkable_location_types")){
				# --- convert to type_ids
				$va_non_linkable_location_type_ids = $t_list->getItemIDsFromList("location_types", $va_non_linkable_location_type_idnos, array("dontIncludeSubItems" => true));
			}
			$this->view->setVar("non_linkable_location_type_ids", $va_non_linkable_location_type_ids);
			$va_exclude_location_type_ids = array();
			if($va_exclude_location_type_idnos = $this->opo_config->get("exclude_location_types")){
				# --- convert to type_ids
				$va_exclude_location_type_ids = $t_list->getItemIDsFromList("location_types", $va_exclude_location_type_idnos, array("dontIncludeSubItems" => true));
			}
			$this->view->setVar("exclude_location_type_ids", $va_exclude_location_type_ids);
			$va_location_type_icons = array();
			$va_location_type_icons_by_idnos = $this->opo_config->get("location_type_icons");
			if(is_array($va_location_type_icons_by_idnos) && sizeof($va_location_type_icons_by_idnos)){
				foreach($va_location_type_icons_by_idnos as $vs_idno => $vs_icon){
					$va_location_type_icons[$t_list->getItemId("location_types", $vs_idno)] = $vs_icon;
				}
			}
			$this->view->setVar("location_type_icons", $va_location_type_icons);
			
 			caSetPageCSSClasses(array("locations", "detail"));
 		}
 		# -------------------------------------------------------
 		
 		/**
 		 *
 		 */ 
 		public function Index() {
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").$this->opo_config->get("section_title"));
 			
 			$this->opo_result_context = new ResultContext($this->request, "ca_storage_locations", "locations");
 			$this->opo_result_context->setAsLastFind();
 			
 			$t_list = new ca_lists();
			$vn_storage_location_type_id = $t_list->getItemIDFromList("storage_location_types", ($this->opo_config->get("landing_page_location_type")) ? $this->opo_config->get("landing_page_location_type") : "campus");
			$vs_sort = ($this->opo_config->get("landing_page_sort")) ? $this->opo_config->get("landing_page_sort") : "ca_storage_locations.preferred_labels.name";
			$qr_locations = ca_storage_locations::find(array('type_id' => $vn_storage_location_type_id, 'preferred_labels' => ['is_preferred' => 1]), array('returnAs' => 'searchResult', 'checkAccess' => $this->opa_access_values, 'sort' => $vs_sort));
			$this->view->setVar("location_results", $qr_locations);
			
			caSetPageCSSClasses(array("locations", "landing"));
 			$this->render("Locations/index_html.php");
 		}
 		# -------------------------------------------------------
 		public function LocationHierarchy(){
 			$vn_location_id = $this->request->getParameter('location_id', pInteger);
 			if($vn_location_id){
 				$t_item = new ca_storage_locations($vn_location_id);
 				$this->view->setVar("item", $t_item);
 				$this->view->setVar("location_id", $vn_location_id);
 			}else{
 				throw new ApplicationException("Invalid location_id");
 			}
 			$this->render("Locations/location_hierarchy_html.php");
 		}
 		# -------------------------------------------------------
 		public function ChildList(){
 			$vn_location_id = $this->request->getParameter('location_id', pInteger);
 			if($vn_location_id){
 				$t_item = new ca_storage_locations($vn_location_id);
 				$this->view->setVar("item", $t_item);
 				$this->view->setVar("location_id", $vn_location_id);
 			}else{
 				throw new ApplicationException("Invalid location_id");
 			}
			$this->render("Locations/child_list_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Locations',
 				'action' => 'Index',
 				'params' => array(
 					
 				)
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
 ?>