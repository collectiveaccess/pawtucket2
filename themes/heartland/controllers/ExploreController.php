<?php
/* ----------------------------------------------------------------------
 * controllers/ExploreController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2016 Whirl-i-Gig
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
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
 	class ExploreController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			$this->config = Configuration::load(__CA_THEME_DIR__.'/conf/explore.conf');
 			caSetPageCSSClasses(array("explore"));
 			
 			$this->view->setVar('config', $this->config);
 			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function index() {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);

			$t_list = new ca_lists();
			$va_types = $t_list->getItemsForList("object_types");
			$this->view->setVar('types', $va_types);
 			
 			$this->render("Explore/index_html.php");
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function type() {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);

			$vn_type_id = $this->request->getParameter('type_id', pInteger);
 			if(!$vn_type_id){
 				$this->index();
 				return;
 			}
 			$this->view->setVar("type_id", $vn_type_id);
 			$t_list_item = new ca_list_items();
 			$t_list_item->load($vn_type_id);
 			if(!$t_list_item->get("item_id")){
 				$this->index();
 				return;
 			}
 			$this->view->setVar("type_name_plural", $t_list_item->get("ca_list_item_labels.name_plural"));
 			$this->view->setVar("type_name_singular", $t_list_item->get("ca_list_item_labels.name_singular"));
 			
			#
			# --- no configured set/items in set so grab random objects with media
			#
			if(!is_array($va_featured_ids) || (sizeof($va_featured_ids) == 0)){
				$t_object = new ca_objects();
				$va_featured_ids = array_keys($t_object->getRandomItems(12, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1, 'restrictByIntrinsic' => array("type_id" => $vn_type_id))));
				$this->view->setVar('type_item_ids', $va_featured_ids);
				$this->view->setVar('type_items_as_search_result', caMakeSearchResult('ca_objects', $va_featured_ids));
			}
		
			$o_result_context = new ResultContext($this->request, 'ca_objects', 'explore');
			$this->view->setVar('result_context', $o_result_context);
			$o_result_context->setAsLastFind();

		
			$this->render("Explore/detail_html.php");
 			
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Explore',
 				'action' => 'Index',
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# ------------------------------------------------------
 	}
