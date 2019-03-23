<?php
/* ----------------------------------------------------------------------
 * app/controllers/CollectionsController.php : 
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
 	require_once(__CA_MODELS_DIR__."/ca_collections.php");
 	require_once(__CA_MODELS_DIR__."/ca_lists.php");
 	
 	class CollectionsController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private $ops_find_type = "collections";
 		private $opo_result_context = null;
 		private $opa_access_values = null;
 		private $opo_config = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            
 			$this->opo_config = caGetCollectionsConfig();
 			$this->view->setVar("collections_config", $this->opo_config);
 			$this->opa_access_values = caGetUserAccessValues($this->request);
 		 	$this->view->setVar("access_values", $this->opa_access_values);
 		 	# --- what is the section called - title of page
 			if(!$vs_section_name = $this->opo_config->get('collections_section_name')){
 				$vs_section_name = _t("Collections");
 			}
 			$this->view->setVar("section_name", $vs_section_name);
 			
 			# --- convert type idnos to id's
 			$va_non_linkable_collection_type_ids = array();
			$t_list = new ca_lists();
			if($va_non_linkable_collection_type_idnos = $this->opo_config->get("non_linkable_collection_types")){
				# --- convert to type_ids
				$va_non_linkable_collection_type_ids = $t_list->getItemIDsFromList("collection_types", $va_non_linkable_collection_type_idnos, array("dontIncludeSubItems" => true));
			}
			$this->view->setVar("non_linkable_collection_type_ids", $va_non_linkable_collection_type_ids);
			$va_exclude_collection_type_ids = array();
			if($va_exclude_collection_type_idnos = $this->opo_config->get("exclude_collection_types")){
				# --- convert to type_ids
				$va_exclude_collection_type_ids = $t_list->getItemIDsFromList("collection_types", $va_exclude_collection_type_idnos, array("dontIncludeSubItems" => true));
			}
			$this->view->setVar("exclude_collection_type_ids", $va_exclude_collection_type_ids);
			$va_collection_type_icons = array();
			$va_collection_type_icons_by_idnos = $this->opo_config->get("collection_type_icons");
			if(is_array($va_collection_type_icons_by_idnos) && sizeof($va_collection_type_icons_by_idnos)){
				foreach($va_collection_type_icons_by_idnos as $vs_idno => $vs_icon){
					$va_collection_type_icons[$t_list->getItemId("collection_types", $vs_idno)] = $vs_icon;
				}
			}
			$this->view->setVar("collection_type_icons", $va_collection_type_icons);
			
 			caSetPageCSSClasses(array("collections", "detail"));
 		}
 		# -------------------------------------------------------
 		
 		/**
 		 *
 		 */ 
 		public function Index() {
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").$this->opo_config->get("section_title"));
 			
 			$this->opo_result_context = new ResultContext($this->request, "ca_collections", "collections");
 			$this->opo_result_context->setAsLastFind();
 			
 			$t_list = new ca_lists();
			$vn_collection_type_id = $t_list->getItemIDFromList("collection_types", ($this->opo_config->get("landing_page_collection_type")) ? $this->opo_config->get("landing_page_collection_type") : "collection");
			$vs_sort = ($this->opo_config->get("landing_page_sort")) ? $this->opo_config->get("landing_page_sort") : "ca_collections.preferred_labels.name";
			$qr_collections = ca_collections::find(array('type_id' => $vn_collection_type_id, 'preferred_labels' => ['is_preferred' => 1]), array('returnAs' => 'searchResult', 'checkAccess' => $this->opa_access_values, 'sort' => $vs_sort));
			$this->view->setVar("collection_results", $qr_collections);
			caSetPageCSSClasses(array("collections", "landing"));
 			$this->render("Collections/index_html.php");
 		}
 		# -------------------------------------------------------
 		public function CollectionHierarchy(){
 			$vn_collection_id = $this->request->getParameter('collection_id', pInteger);
 			if($vn_collection_id){
 				$t_item = new ca_collections($vn_collection_id);
 				$this->view->setVar("item", $t_item);
 				$this->view->setVar("collection_id", $vn_collection_id);
 			}else{
 				throw new ApplicationException("Invalid collection_id");
 			}
 			$this->render("Collections/collection_hierarchy_html.php");
 		}
 		# -------------------------------------------------------
 		public function ChildList(){
 			$vn_collection_id = $this->request->getParameter('collection_id', pInteger);
 			if($vn_collection_id){
 				$t_item = new ca_collections($vn_collection_id);
 				$this->view->setVar("item", $t_item);
 				$this->view->setVar("collection_id", $vn_collection_id);
 			}else{
 				throw new ApplicationException("Invalid collection_id");
 			}
			$this->render("Collections/child_list_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Collections',
 				'action' => 'Index',
 				'params' => array(
 					
 				)
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
 ?>