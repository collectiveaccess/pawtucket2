<?php
/* ----------------------------------------------------------------------
 * /controllers/OccupationsController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 	
 #require_once(__CA_MODELS_DIR__."/ca_list_items.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 #require_once(__CA_LIB_DIR__.'/Search/EntitySearch.php');
 	
 	class OccupationsController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$request, &$response, $view_paths=null) {
 			parent::__construct($request, $response, $view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            
            caSetPageCSSClasses(array("occupations"));
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Partners");
 			
 			$this->config = Configuration::load("browse.conf");
 			$this->ops_facet = $this->config->get("occupations_list_facet");
 			$this->ops_browse_target = $this->config->get("occupations_list_browse_target");
 		 	
 			$access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $access_values;
			$this->view->setVar('access_values', $access_values);
			$this->view->setVar('config', $this->config);
			$this->view->setVar('facet', $this->ops_facet);
 		}
 		# -------------------------------------------------------
 		public function __call($function, $args){
 			if (!($browse_info = caGetInfoForBrowseType($this->ops_browse_target))) {
				// invalid browse type – throw error
				throw new ApplicationException("Invalid browse type");
			}
			$class = $this->ops_tablename = $browse_info['table'];
			$types = caGetOption('restrictToTypes', $browse_info, [], array('castTo' => 'array'));
			$omit_child_records = caGetOption('omitChildRecords', $browse_info, [], array('castTo' => 'bool'));
			$expand_results_hierarchically = caGetOption('expandResultsHierarchically', $browse_info, [], array('castTo' => 'bool'));

 			$o_browse = caGetBrowseInstance($class);
			if (is_array($types) && sizeof($types)) { $o_browse->setTypeRestrictions($types, array('dontExpandHierarchically' => caGetOption('dontExpandTypesHierarchically', $browse_info, false))); }
	 		$o_browse->execute(array('checkAccess' => $this->opa_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => true, 'expandResultsHierarchically' => $expand_results_hierarchically, 'omitChildRecords' => $omit_child_records, 'omitChildRecordsForTypes' => caGetOption('omitChildRecordsForTypes', $browse_info, null)));
			$facet = $o_browse->getFacet($this->ops_facet, array('checkAccess' => $this->opa_access_values, 'request' => $this->request));			
			$qr_res = caMakeSearchResult("ca_list_items", array_keys($facet), array('checkAccess' => $this->opa_access_values));
 			
 			$this->view->setVar("results", $qr_res);

 			$this->render("Occupations/occupations_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($request) {
 			$ret = array(
 				'module_path' => '',
 				'controller' => 'Occupations',
 				'action' => $request->getAction(),
 				'params' => array(
 					
 				)
 			);
			return $ret;
 		}
 	}
