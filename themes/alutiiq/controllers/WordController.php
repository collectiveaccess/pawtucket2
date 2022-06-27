<?php
/* ----------------------------------------------------------------------
 * controllers/FrontController.php
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
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
 	class WordController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			#$this->config = caGetFrontConfig();
 			caSetPageCSSClasses(array("front", "word"));
 			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);

 			#$this->view->setVar('config', $this->config);
 			
 			#$o_result_context = new ResultContext($this->request, 'ca_objects', 'front');
 			#$this->view->setVar('result_context', $o_result_context);
 			#$o_result_context->setAsLastFind();
 			
 			//
 			// Try to load selected page if it exists in Front/, otherwise load default Front/front_page_html.php
 			//
 			$ps_function = preg_replace("![^A-Za-z0-9_\-]+!", "", $ps_function);
 			$vs_path = "Front/{$ps_function}_html.php";
 			if (!file_exists(__CA_THEME_DIR__."/views/{$vs_path}")) {
 				$vs_path = "Front/front_page_html.php";
 			}
 			
 			$this->render("Word/index_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Word',
 				'action' => 'Index',
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# ------------------------------------------------------
 	}