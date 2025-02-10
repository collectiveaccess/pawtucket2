<?php
/* ----------------------------------------------------------------------
 * app/controllers/GalleryController.php : 
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
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	
 	class ExploreController extends BasePawtucketController {
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
            caSetPageCSSClasses(array("explore"));
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Explore");
 		 	
 		 	$va_access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $va_access_values;
			$this->view->setVar('access_values', $va_access_values);
 		}
 		# -------------------------------------------------------
 		public function products(){		
			# --- products landing page - shows brands
			$t_list = new ca_lists();
			$va_brands = $t_list->getItemsForList("brand", array("extractValuesByUserLocale" => true, "checkAccess" => $this->opa_access_values, "sort" => __CA_LISTS_SORT_BY_RANK__));
			if(is_array($va_brands) && sizeof($va_brands)){
				$qr_brands = caMakeSearchResult('ca_list_items', array_keys($va_brands));
				$this->view->setVar("brands_search", $qr_brands);
			}
			$this->view->setVar("brands", $va_brands);
		
			$this->render("Explore/products_html.php");

 		}
 		# -------------------------------------------------------
 		public function archival(){		
			# --- archival items landing page
			$t_list = new ca_lists();
			$va_archival_types = $t_list->getItemsForList("archival_types", array("extractValuesByUserLocale" => true, "checkAccess" => $this->opa_access_values, "sort" => __CA_LISTS_SORT_BY_RANK__));
			if(is_array($va_archival_types) && sizeof($va_archival_types)){
				$qr_archival_types = caMakeSearchResult('ca_list_items', array_keys($va_archival_types));
				$this->view->setVar("archival_types_search", $qr_archival_types);
			}
			$this->view->setVar("archival_types", $va_archival_types);
		
			$this->render("Explore/archival_html.php");

 		}
 		# -------------------------------------------------------
 		public function brands(){		
			# --- all objects landing page - shows brands
			$t_list = new ca_lists();
			$va_brands = $t_list->getItemsForList("brand", array("dontCache" => true, "extractValuesByUserLocale" => true, "checkAccess" => $this->opa_access_values, "sort" => __CA_LISTS_SORT_BY_RANK__));
			if(is_array($va_brands) && sizeof($va_brands)){
				$qr_brands = caMakeSearchResult('ca_list_items', array_keys($va_brands));
				$this->view->setVar("brands_search", $qr_brands);
			}
			$this->view->setVar("brands", $va_brands);
		
			$this->render("Explore/brands_html.php");

 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Explore',
 				'action' => $this->request->getAction(),
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
