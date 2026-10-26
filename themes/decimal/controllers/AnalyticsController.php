<?php
/* ----------------------------------------------------------------------
 * controllers/AnalyticsController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 	require_once(__CA_APP_DIR__."/controllers/FindController.php");
 	require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
 
 	class AnalyticsController extends FindController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			$this->opo_config = caGetBrowseConfig();
            caSetPageCSSClasses(array("analytics"));
  			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Analytcis");
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);
			
			$va_analytics_facets_to_display = $this->request->config->get("analyticsFacets");
			if(!is_array($va_analytics_facets_to_display)){
				$va_analytics_facets_to_display = array();
			}
			$va_analytics_facets_to_display_hierarchical = $this->request->config->get("analyticsFacetsHierarchical");
			if(!is_array($va_analytics_facets_to_display_hierarchical)){
				$va_analytics_facets_to_display_hierarchical = array();
			}
			$va_analytics_facets_to_chart = $this->request->config->get("analyticsFacetCharts");
			if(!is_array($va_analytics_facets_to_chart)){
				$va_analytics_facets_to_chart = array();
			}
			
			$va_browse_info = caGetInfoForBrowseType('analytics');			
			$o_browse = caGetBrowseInstance($va_browse_info['table']);
			$o_browse->removeAllCriteria();
			$o_browse->setFacetGroup("analytics");
			$va_facets = $o_browse->getFacetsWithContentList();
			$va_analytics_facets = array();
			$va_analytics_chart_facets = array();
			foreach($va_facets as $vs_facet_name) {
				$va_facet_info = $o_browse->getInfoForFacet($vs_facet_name);
				if(in_array($vs_facet_name, $va_analytics_facets_to_display)){
					if(in_array($vs_facet_name, $va_analytics_facets_to_display_hierarchical)){
						# --- group it hierarchical
						$va_tmp = $o_browse->getFacet($vs_facet_name, array("checkAccess" => $this->opa_access_values, 'checkAvailabilityOnly' => caGetOption('deferred_load', $va_facet_info, false, array('castTo' => 'bool'))));
						# --- get the root list id
						$t_element = new ca_metadata_elements();
						if ($t_element->load(array('element_code' => $va_facet_info['element_code']))) {
							if ($t_element->get('datatype') == __CA_ATTRIBUTE_VALUE_LIST__) {
								$t_list = new ca_lists();
								$vn_root_id = $t_list->getRootListItemID($t_element->get('list_id'));
								foreach($va_tmp as $vn_term_id => $va_term_info){
									if($va_term_info["parent_id"] != $vn_root_id){
										$va_tmp[$va_term_info["parent_id"]]["children"][$vn_term_id] = $va_term_info;
										unset($va_tmp[$vn_term_id]);
									}
								}
								$va_analytics_facets[$vs_facet_name]['content'] = $va_tmp;
								
							}
						}					
					}else{
						$va_analytics_facets[$vs_facet_name]['content'] = $o_browse->getFacet($vs_facet_name, array("checkAccess" => $this->opa_access_values, 'checkAvailabilityOnly' => caGetOption('deferred_load', $va_facet_info, false, array('castTo' => 'bool'))));
					}					
					$va_analytics_facets[$vs_facet_name]['label_singular'] = $va_facet_info['label_singular'];
					$va_analytics_facets[$vs_facet_name]['label_plural'] = $va_facet_info['label_plural'];
					if(in_array($vs_facet_name, $va_analytics_facets_to_chart)){
						$va_analytics_chart_facets[$vs_facet_name] = $va_analytics_facets[$vs_facet_name];
					}
				}
			}
			$this->view->setVar("analytics_facets", $va_analytics_facets);
			$this->view->setVar("analytics_chart_facets", $va_analytics_chart_facets);
			
			# -- total number of records for % stats
			if(ExternalCache::contains("{$vs_class}totalRecordsAvailable")) {
				$this->view->setVar('totalRecordsAvailable', ExternalCache::fetch("{$vs_class}totalRecordsAvailable"));
			} else {
				ExternalCache::save("{$vs_class}totalRecordsAvailable", $vn_count = ca_objects::find(['deleted' => 0, 'access' => $this->opa_access_values], ['returnAs' => 'count']));
				$this->view->setVar('totalRecordsAvailable', $vn_count);
			}
			
			$o_search = caGetSearchInstance("ca_objects");
 			$qr_res = $o_search->search("ca_objects.use:359", array("checkAccess" => $va_access_values));
 			
 			$this->render("Analytics/index_html.php");
 		}
 		# -------------------------------------------------------
 	}
 ?>
