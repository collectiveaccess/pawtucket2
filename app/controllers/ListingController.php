<?php
/* ----------------------------------------------------------------------
 * app/controllers/ListingController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2014 Whirl-i-Gig
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
 	require_once(__CA_APP_DIR__."/helpers/listingHelpers.php");
 	
 	class ListingController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private $ops_find_type = "listing";
 		
 		/**
 		 *
 		 */
 		private $opo_result_context = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			caSetPageCSSClasses(array("listing"));
 		}
 		# -------------------------------------------------------
 		
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$o_config = caGetListingConfig();
 			
 			$ps_function = strtolower($ps_function);
 			$ps_type = $this->request->getActionExtra();
 			
 			if (!($va_listing_info = caGetInfoForListingType($ps_function))) {
 				// invalid listing type – throw error
 				die("Invalid listing type");
 			}
 		
 			$o_dm = Datamodel::load();
 		
 			$ps_function = strtolower($ps_function);
 			
 			$vs_table = $va_listing_info['table'];
 			
 			
 			$this->opo_result_context = new ResultContext($this->request, $va_browse_info['table'], $this->ops_find_type);
 			$this->opo_result_context->setAsLastFind();
 			
 			if (!($t_instance = $o_dm->getInstanceByTableName($vs_table, true))) {
 				die("Invalid table");
 			}
 			
 			if(!($o_search = caGetSearchInstance($vs_table))) {
 				die("Invalid search");
 			}
 			
 			$va_types = caGetOption('restrictToTypes', $va_listing_info, array(), array('castTo' => 'array'));
 			$va_type_list = $t_instance->getTypeList();
 			
 			if (!is_array($va_types) || !sizeof($va_types)) {
 				$va_types = array_keys($va_type_list);
 			} else {
 				$va_types = caMakeTypeIDList($vs_table, $va_types, array('dontIncludeSubtypesInTypeRestriction' => true));
 			}
 			
 			//
			// Sorting
			//
			if (!($ps_sort = $this->request->getParameter("sort", pString))) {
 				$ps_sort = $this->opo_result_context->getCurrentSort();
 			}
 			
 			$this->opo_result_context->setCurrentSort($ps_sort);
 			
			$va_sort_by = caGetOption('sortBy', $va_listing_info, null);
			$this->view->setVar('sortBy', is_array($va_sort_by) ? $va_sort_by : null);
			$this->view->setVar('sortBySelect', $vs_sort_by_select = (is_array($va_sort_by) ? caHTMLSelect("sort", $va_sort_by, array('id' => "sort"), array("value" => $ps_sort)) : ''));
			$this->view->setVar('sortControl', $vs_sort_by_select ? _t('Sort with %1', $vs_sort_by_select) : '');
			$this->view->setVar('sort', $ps_sort);
			
 			
 			$va_lists = array();
 			$va_res_list = array();
 			foreach($va_types as $vm_type) {
 				$o_search->setTypeRestrictions(array($vm_type));
 				$qr_res = $o_search->search("*", array('sort' => $va_sort_by[$ps_sort]));
 				
 				if ($qr_res->numHits() == 0) { continue; }
 				$va_res_list += $qr_res->getPrimaryKeyValues();
 				$va_lists[$vm_type] = $qr_res; 
 			}
 			
 			$this->view->setVar('table', $vs_table);
 			$this->view->setVar('lists', $va_lists);
 			$this->view->setVar('typeInfo', $va_type_list);
 			$this->view->setVar('listingInfo', $va_listing_info);
 			
 			
			$this->opo_result_context->setResultList($va_res_list);
			$this->opo_result_context->saveContext();
 			
 			
 			$this->render("Listing/listing_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Listing',
 				'action' => $po_request->getAction(),
 				'params' => array(
 					
 				)
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
 ?>