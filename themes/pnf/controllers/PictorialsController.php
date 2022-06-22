<?php
/* ----------------------------------------------------------------------
 * app/controllers/PictorialsController.php : 
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
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	
 	class PictorialsController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            if (($this->request->config->get('deploy_bristol'))&&($this->request->isLoggedIn())) {
            	print "You do not have access to view this page.";
            	die;
            }
            caSetPageCSSClasses(array("pictorials"));
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Pictorials");
 			
 		 	$va_access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $va_access_values;
			$this->view->setVar('access_values', $va_access_values);
 		}
 		# -------------------------------------------------------
 		public function Ornaments(){
			$t_list = new ca_lists();
			$va_categories = $t_list->getItemsForList("type_category", array("directChildrenOnly" => true, "extractValuesByUserLocale" => true, "checkAccess" => $this->opa_access_values, "sort" => "ca_list_item_labels.name_sort"));
			$qr_categories = caMakeSearchResult('ca_list_items', array_keys($va_categories));
			$this->view->setVar("categories", $va_categories);
			$this->view->setVar("categories_search", $qr_categories);

 			$this->render("Pictorials/ornaments_html.php");
 			
 			
 		}
 		# -------------------------------------------------------
 		public function Illustrations(){
			$this->render("Pictorials/illustrations_html.php");
 		}
 		# -------------------------------------------------------
 		public function PrintersDevices(){
			$this->render("Pictorials/printers_devices_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Pictorials',
 				'action' => 'Intro',
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
