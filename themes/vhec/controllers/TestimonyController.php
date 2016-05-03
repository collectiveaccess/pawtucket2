<?php
/* ----------------------------------------------------------------------
 * controllers/DefaultController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
	#require_once(__CA_LIB_DIR__."/core/Error.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	
 
 	class TestimonyController extends ActionController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            } 			
 			$this->config = caGetFrontConfig();
 			caSetPageCSSClasses(array("testimony"));
 		}
 		# -------------------------------------------------------
# 		public function __call($ps_method, $pa_path) {
 #			array_unshift($pa_path[0], $ps_method);
 			
 #			$this->view->setVar('response', $this->response);
 			
 #			$this->render(join("/", $pa_path[0]).".php", false);
 #		}
 		# ------------------------------------------------------
 		 public function Index() {
 		 
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);

 			#
 			# --- if there is a set configured to show on the front page, load it now
 			#
 			$va_featured_ids = array();
 			if($vs_set_code = $this->config->get("testimony_set_code")){
 				$t_set = new ca_sets();
 				$t_set->load(array('set_code' => $vs_set_code)); 

				# Enforce access control on set
				if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
					$this->view->setVar('featured_set_id', $t_set->get("set_id"));
					$this->view->setVar('featured_set', $t_set);
					$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
					$this->view->setVar('featured_set_item_ids', $va_featured_ids);
					$this->view->setVar('featured_set_items_as_search_result', caMakeSearchResult('ca_objects', $va_featured_ids));
				}
 			} 		 
 		 
			$this->render("Testimony/Index.php");
 		}
 	}
