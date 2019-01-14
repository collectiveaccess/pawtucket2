<?php
/* ----------------------------------------------------------------------
 * themes/uga/controllers/FindingAidController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 	require_once(__CA_MODELS_DIR__."/ca_collections.php");
 	require_once(__CA_APP_DIR__."/controllers/BrowseController.php");
 	require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
 	
 	class FindingAidsController extends BrowseController {
		/**
 		 *
 		 */
 		protected $ops_find_type = "findingaids";
 		
 		/**
 		 *
 		 */
 		protected $ops_view_prefix = 'FindingAids'; 	
 		
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function __call($ps_function, $pa_args) {
 			$vn_rc = parent::__call($ps_function, $pa_args);
 			$this->opo_result_context = new ResultContext($this->request, 'ca_collections', 'findingaids');
 			$this->opo_result_context->setAsLastFind();
 			$this->opo_result_context->saveContext();
 			return $vn_rc;
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'FindingAids',
 				'action' => 'Index',
 				'params' => array(
 					
 				)
 			);
			return $va_ret;
 		}
		# -------------------------------------------------------
 	}