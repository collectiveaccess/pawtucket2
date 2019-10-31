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
 		public function index(){		
			$pn_category_id = $this->request->getParameter('item_id', pInteger);
			$t_list = new ca_lists();
			$this->view->setVar("root_id", $t_list->getRootListItemID("categories"));
			if($pn_category_id){
				$this->view->setVar("subcategory", true);
				# --- subcategory items
				$t_list_item = new ca_list_items();
				$t_list_item->load($pn_category_id);
				$this->view->setVar("category_name", $t_list_item->get("ca_list_items.preferred_labels.name_plural"));
				$va_categories = $t_list_item->get("ca_list_items.children.item_id", array("returnAsArray" => true, "checkAccess" => $this->opa_access_values));
			}else{				
				# --- category landing page
				$va_categories = $t_list->getItemsForList("categories", array("extractValuesByUserLocale" => true, "checkAccess" => $this->opa_access_values, "sort" => __CA_LISTS_SORT_BY_LABEL__));				
			}
			$qr_categories = caMakeSearchResult('ca_list_items', array_keys($va_categories));
			$this->view->setVar("categories", $va_categories);
			$this->view->setVar("categories_search", $qr_categories);
			$this->render("Explore/index_html.php");

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
 				'action' => 'Index',
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
