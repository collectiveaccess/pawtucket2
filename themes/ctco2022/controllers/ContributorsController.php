<?php
/* ----------------------------------------------------------------------
 * app/controllers/ContributorsController.php : 
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
 	require_once(__CA_MODELS_DIR__."/ca_entities.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	require_once(__CA_LIB_DIR__.'/Search/EntitySearch.php');
 	
 	class ContributorsController extends BasePawtucketController {
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
            caSetPageCSSClasses(array("contributors"));
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Contributors");
 			
 			AssetLoadManager::register("panel");
 			AssetLoadManager::register("mediaViewer");
 			AssetLoadManager::register('maps');
 			
 			$this->config = Configuration::load("contributors.conf");
 			
 			$t_list = new ca_lists();
 		 	$this->opn_contributor_id = $t_list->getItemIDFromList('entity_types', $this->config->get("contributor_entity_type"));
 		 	
 		 	$va_access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $va_access_values;
			$this->view->setVar('access_values', $va_access_values);
			$this->view->setVar('config', $this->config);
 		}
 		# -------------------------------------------------------
 		public function __call($ps_function, $pa_args){
 			$o_search = new EntitySearch();
 		 	if(is_array($this->opa_access_values) && sizeof($this->opa_access_values)){
 		 		$o_search->addResultFilter("ca_entities.access", "IN", join(',', $this->opa_access_values));
			}
			$qr_res = $o_search->search("ca_entities.type_id:".$this->opn_contributor_id, array("sort" => "ca_entity_labels.name_sort"));
 			
 			$this->opo_result_context = new ResultContext($this->request, "ca_entities", "contributors");
			$this->opo_result_context->setAsLastFind();
			
 			$o_map = new GeographicMap('100%', $this->config->get("contributor_map_height"), 'map');
			$va_map_stats = $o_map->mapFrom($qr_res, $this->config->get("contributor_map_georeference_field"), array("labelTemplate" => $this->config->get("contributor_map_label_template"), "contentTemplate" => $this->config->get("contributor_map_content_template"), "request" => $this->request, "checkAccess" => $this->opa_access_values));
			$this->view->setVar("map", $o_map->render('HTML', array('delimiter' => "<br/>")));

			$this->view->setVar("timeline_set_id", $vn_timeline_set_id);
			
			$qr_res->seek(0);
			
			$this->opo_result_context->setResultList($qr_res->getPrimaryKeyValues(200));
			$this->opo_result_context->saveContext();
			
			$this->view->setVar("contributor_results", $qr_res);

 			$this->render("Contributors/index_html.php");
 		}
 		
 		# -------------------------------------------------------
 		public function map(){
 			$o_search = new EntitySearch();
 		 	if(is_array($this->opa_access_values) && sizeof($this->opa_access_values)){
 		 		$o_search->addResultFilter("ca_entities.access", "IN", join(',', $this->opa_access_values));
			}
			$qr_res = $o_search->search("ca_entities.type_id:".$this->opn_contributor_id, array("sort" => "ca_entity_labels.name_sort"));
 			
 			$this->opo_result_context = new ResultContext($this->request, "ca_entities", "contributors");
			$this->opo_result_context->setAsLastFind();
			
 			$o_map = new GeographicMap('100%', $this->config->get("contributor_map_height"), 'map');
			$va_map_stats = $o_map->mapFrom($qr_res, $this->config->get("contributor_map_georeference_field"), array("labelTemplate" => $this->config->get("contributor_map_label_template"), "contentTemplate" => $this->config->get("contributor_map_content_template"), "request" => $this->request, "checkAccess" => $this->opa_access_values));
			$this->view->setVar("map", $o_map->render('HTML', array('delimiter' => "<br/>")));

			$qr_res->seek(0);
			
			$this->opo_result_context->setResultList($qr_res->getPrimaryKeyValues(200));
			$this->opo_result_context->saveContext();
			
			$this->view->setVar("contributor_results", $qr_res);

 			$this->render("Contributors/map_html.php");
 		}
 		
 		# -------------------------------------------------------
 		public function list(){
 			$o_search = new EntitySearch();
 		 	if(is_array($this->opa_access_values) && sizeof($this->opa_access_values)){
 		 		$o_search->addResultFilter("ca_entities.access", "IN", join(',', $this->opa_access_values));
			}
			$qr_res = $o_search->search("ca_entities.type_id:".$this->opn_contributor_id, array("sort" => "ca_entity_labels.name_sort"));
 			
 			$this->opo_result_context = new ResultContext($this->request, "ca_entities", "contributors");
			$this->opo_result_context->setAsLastFind();
			
 			$this->opo_result_context->setResultList($qr_res->getPrimaryKeyValues(200));
			$this->opo_result_context->saveContext();
			
			$this->view->setVar("contributor_results", $qr_res);

 			$this->render("Contributors/list_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Contributors',
 				'action' => $po_request->getAction(),
 				'params' => array(
 					
 				)
 			);
			return $va_ret;
 		}
 	}
