<?php
/* ----------------------------------------------------------------------
 * app/controllers/ListingController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	
 	class ListingController extends BasePawtucketController {
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
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
				$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            if (($this->request->config->get('deploy_bristol'))&&($this->request->isLoggedIn())) {
            	print "You do not have access to view this page.";
            	die;
            }
 			
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
 				throw new ApplicationException("Invalid listing type");
 			}
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").$va_listing_info["displayName"]);
 			
 			$ps_function = strtolower($ps_function);
 			
 			$vs_table = $va_listing_info['table'];
 			$vs_search = caGetOption('search', $va_listing_info, '*');
 			$vs_segment_by = caGetOption('segmentBy', $va_listing_info, '');
 			
 			$this->opo_result_context = new ResultContext($this->request, $vs_table, $this->ops_find_type);
 			$this->opo_result_context->setAsLastFind();
 			
 			if (!($t_instance = Datamodel::getInstance($vs_table, true))) {
 				throw new ApplicationException("Invalid table");
 			}
 			
 			if(!($o_browse = caGetBrowseInstance($vs_table))) {
 				throw new ApplicationException("Invalid listing");
 			}
 			
 			// Set browse facet group
 			if ($vs_facet_group = caGetOption('browseFacetGroup', $va_listing_info, null)) {
 				$o_browse->setFacetGroup($vs_facet_group);
 			}
 			
 			$va_types = caGetOption('restrictToTypes', $va_listing_info, array(), array('castTo' => 'array'));
 			$va_type_list = $t_instance->getTypeList();
 			
 			if (!is_array($va_types) || !sizeof($va_types)) {
 				$va_types = array_keys($va_type_list);
 			} else {
 				$va_types = caMakeTypeIDList($vs_table, $va_types, array('dontIncludeSubtypesInTypeRestriction' => true));
 			}
 			$o_browse->setTypeRestrictions($va_types, array('dontExpandHierarchically' => true));
 			
 			$va_relationship_types = caGetOption('restrictToRelationshipTypes', $va_listing_info, array(), array('castTo' => 'array'));
 		
 			$o_browse->addCriteria("_search", array($vs_search));
 			
 			foreach($va_relationship_types as $vs_x => $va_rel_types) {
 				if (!is_array($va_rel_types)) { continue; }
 				$o_browse->addCriteria("_reltypes", "{$vs_x}:".join(",", $va_rel_types));
 			}
 			$o_browse->execute(array('checkAccess' => $this->opa_access_values));
			
			//
			// Facets for search 
			//
			$va_facets = $o_browse->getInfoForAvailableFacets();
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				$va_facets[$vs_facet_name]['content'] = $o_browse->getFacetContent($vs_facet_name, array('checkAccess' => $this->opa_access_values));
			}
		
			$this->view->setVar('facets', $va_facets);
			
			
			//
			// Add criteria and execute
			//
			if ($vs_facet = $this->request->getParameter('facet', pString)) {
				$o_browse->addCriteria($vs_facet, array($vn_facet_id = $this->request->getParameter('id', pString)));
				
				$this->view->setVar('facet', $vs_facet);
				$this->view->setVar('facet_id', $vn_facet_id);
			}


			//
			// Sorting
			//
			$vb_sort_changed = false;
 			if (!($ps_sort = $this->request->getParameter("sort", pString))) {
 				if (!($ps_sort = $this->opo_result_context->getCurrentSort())) {
 					if(is_array(($va_sorts = caGetOption('sortBy', $va_listing_info, null)))) {
 						$ps_sort = array_shift(array_keys($va_sorts));
 						$vb_sort_changed = true;
 					}
 				}
 			}else{
 				$vb_sort_changed = true;
 			}
 			$va_sort_direction = caGetOption('sortDirection', $va_listing_info, null);
 			
  			if (!($ps_sort_direction = $this->request->getParameter("direction", pString))) {  			    
                # --- set the default sortDirection if available
                if(!($ps_sort_direction = $va_sort_direction[$ps_sort])){
                    $ps_sort_direction = 'asc';
                } 
                $this->opo_result_context->setCurrentSortDirection($ps_sort_direction);
 			}
 			
 			$this->opo_result_context->setCurrentSort($ps_sort);
 			$this->opo_result_context->setCurrentSortDirection($ps_sort_direction);
 			
			$va_sort_by = caGetOption('sortBy', $va_listing_info, null);
			$this->view->setVar('sortBy', is_array($va_sort_by) ? $va_sort_by : null);
			$this->view->setVar('sortBySelect', $vs_sort_by_select = (is_array($va_sort_by) ? caHTMLSelect("sort", $va_sort_by, array('id' => "sort"), array("value" => $ps_sort)) : ''));
			$this->view->setVar('sortControl', $vs_sort_by_select ? _t('Sort with %1', $vs_sort_by_select) : '');
			$this->view->setVar('sort', $ps_sort);
			$this->view->setVar('sort_direction', $ps_sort_direction);


 			$va_lists = array();
 			$va_res_list = array();
 			
			$o_browse->execute(array('checkAccess' => $this->opa_access_values));
			
			$qr_res = $o_browse->getResults(array('sort' => $va_sort_by[$ps_sort], 'sort_direction' => $ps_sort_direction));
 			while($qr_res->nextHit()) {
 				$vs_key = $qr_res->getWithTemplate($vs_segment_by);
 				$va_lists[$vs_key][] = $va_res_list[] = $qr_res->getPrimaryKey();
 			}
 			
 			foreach($va_lists as $vs_key => $va_ids) {
 				$va_lists[$vs_key] = caMakeSearchResult($vs_table, $va_ids);
 			}
 			
 			$this->view->setVar('table', $vs_table);
 			$this->view->setVar('lists', $va_lists);
 			$this->view->setVar('typeInfo', $va_type_list);
 			$this->view->setVar('listingInfo', $va_listing_info);
 			
 			//
			// Current criteria
			//
			$va_criteria = $o_browse->getCriteriaWithLabels();
			unset($va_criteria['_search']);
		
			$va_criteria_for_checking = array();
			foreach($va_criteria as $vs_facet_name => $va_criterion) {
				$va_facet_info = $o_browse->getInfoForFacet($vs_facet_name);
				foreach($va_criterion as $vn_criterion_id => $vs_criterion) {
					$va_criteria_for_checking[$vs_facet_name] = $vn_criterion_id;
				}
			}
			
			$this->view->setVar('hasCriteria', sizeof($va_criteria_for_checking) > 0);
			$this->view->setVar('criteria', $va_criteria_for_checking);
			
 			
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