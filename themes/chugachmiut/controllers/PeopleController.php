<?php
/* ----------------------------------------------------------------------
 * controllers/PeopleController.php
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
 
 	class PeopleController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			$this->config = caGetFrontConfig();
 			caSetPageCSSClasses(array("people"));
 			$this->view->setVar('access_values', $this->opa_access_values);
 			AssetLoadManager::register("carousel");
 			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
 		}
 		# -------------------------------------------------------
 		public function Index() {
 			# --- what is the set code of the featured people set?
 			$vs_set_code = $this->request->config->get("people_page_set_code");
			
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => $vs_set_code));
			# Enforce access control on set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('people_set', $t_set);
				$va_row_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values))) ? $va_tmp : array());
				$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("checkAccess" => $this->opa_access_values)));
				$va_row_to_item_ids = array();
				foreach($va_set_items as $vn_item_id => $va_item_info){
					$va_row_to_item_ids[$va_item_info["row_id"]] = $vn_item_id;
				}
				$this->view->setVar('set_id', $t_set->get("ca_sets.set_id"));
				$this->view->setVar('set_items', $va_set_items);
				$this->view->setVar('row_to_item_ids', $va_row_to_item_ids);
				$this->view->setVar('set_item_row_ids', $va_row_ids);
				$this->view->setVar('set_items_as_search_result', caMakeSearchResult('ca_entities', $va_row_ids));
			}
			
			
			$this->render("People/index_html.php");
 		}
 		# -------------------------------------------------------
 	}