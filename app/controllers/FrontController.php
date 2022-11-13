<?php
/* ----------------------------------------------------------------------
 * controllers/FrontController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
 	class FrontController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			$this->config = caGetFrontConfig();
 			caSetPageCSSClasses(array("front"));
 			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
 		}
 		# -------------------------------------------------------
 		/**
 		 *$this->config
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$va_access_values = caGetUserAccessValues();
 			$this->view->setVar('access_values', $va_access_values);

            $set_codes = $this->config->getList('set_codes');
            
            $t_set = new ca_sets();
            if(!is_array($media_versions = $this->config->get('media_versions'))) { $media_versions = ['icon', 'small']; }

            $sets = caExtractValuesByUserLocale($t_set->getSets(['checkAccess' => $va_access_values, 'codes' => $set_codes, 'thumbnailVersions' => $media_versions]));
            
            $this->view->setVar('sets', $sets);
            
 			#
 			# --- if there is a set configured to show on the front page, load it now
 			#
 			$va_featured_ids = array();
 			$set_table = null;
 			if($vs_set_code = $this->config->get("front_page_set_code")){
 				$t_set = new ca_sets();
 				if ($t_set->load(['set_code' => $vs_set_code])) {
					$set_table = $t_set->getItemType();
					$vn_shuffle = 0;
					if($this->config->get("front_page_set_random")){
						$vn_shuffle = 1;
					}
					# Enforce access control on set
					if((!is_array($va_access_values) || (sizeof($va_access_values) == 0)) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
						$this->view->setVar('featured_set_id', $t_set->get("set_id"));
						$this->view->setVar('featured_set', $t_set);
						$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
						$this->view->setVar('featured_set_item_ids', $va_featured_ids);
						$this->view->setVar('featured_set_items_as_search_result', caMakeSearchResult($set_table, $va_featured_ids));
					}
				}
 			}
 			#
 			# --- no configured set/items in set so grab random objects with media
 			#
 			if(sizeof($va_featured_ids) == 0){
 				$t_object = new ca_objects();
 				$set_table = 'ca_objects'; 
 				if($va_intrinsic_values = $this->config->get("front_page_intrinsic_filter")){
 					foreach($va_intrinsic_values as $vs_instrinsic_field => $vs_intrinsic_value){
 						$va_intrinsic_restrictions[$vs_instrinsic_field] = $vs_intrinsic_value;
 					}
 				}
 				$va_featured_ids = array_keys($t_object->getRandomItems(10, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1, 'restrictByIntrinsic' => $va_intrinsic_restrictions)));
 				$this->view->setVar('featured_set_item_ids', $va_featured_ids);
				$this->view->setVar('featured_set_items_as_search_result', caMakeSearchResult($set_table, $va_featured_ids));
 			}
 			
 			$this->view->setVar('config', $this->config);
 			
 			$o_result_context = new ResultContext($this->request, $set_table, 'front');
 			$this->view->setVar('result_context', $o_result_context);
 			$o_result_context->setAsLastFind();
 			
 			//
 			// Try to load selected page if it exists in Front/, otherwise load default Front/front_page_html.php
 			//
 			$ps_function = preg_replace("![^A-Za-z0-9_\-]+!", "", $ps_function);
 			$vs_path = "Front/{$ps_function}_html.php";
 			if (!file_exists(__CA_THEME_DIR__."/views/{$vs_path}")) {
 				$vs_path = "Front/front_page_html.php";
 			}
 			
 			$this->render($vs_path);
 		}
 		# -------------------------------------------------------
 		/**
 		 * Prototype service for "frontpage" React app
 		 */
 		public function getData() {
 			$this->request->isDownload(true);
 			header("Access-Control-Allow-Origin: *");
			$o_front_config = caGetFrontConfig();
 			header("Content-type: application/json");
 			
 			$items = ca_sets::setContents($o_front_config->get("front_page_set_code"), [
 				'template' => ($vs_tmp = $o_front_config->get("front_page_set_item_caption_template")) ? $vs_tmp : '<l>^ca_objects.preferred_labels.name (^ca_objects.idno)</l>']
 			);
 			
 			print json_encode([['key' => 1, 'set' => 'Front page', 'items' => $items]]);
 			
 			global $app;
 			$app->removeAllPlugins();
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Front',
 				'action' => 'Index',
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# ------------------------------------------------------
 	}
