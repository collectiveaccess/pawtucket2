<?php
/* ----------------------------------------------------------------------
 * app/controllers/BrowseController.php : 
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
 	require_once(__CA_MODELS_DIR__."/ca_collections.php");
 	require_once(__CA_APP_DIR__."/controllers/FindController.php");
 	require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
 	
 	class BrowseController extends FindController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		protected $ops_find_type = "browse";
 		
 		/**
 		 *
 		 */
 		protected $opo_result_context = null;
 		
 		/**
 		 *
 		 */
 		protected $opa_access_values = array();
 		
 		/**
 		 *
 		 */
 		protected $ops_view_prefix = 'Browse';
 		
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			if (!$this->request->isAjax() && $this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            $this->opo_config = caGetBrowseConfig();
            
 			$this->opa_access_values = caGetUserAccessValues($po_request);
 		 	$this->view->setVar("access_values", $this->opa_access_values);
 			$this->view->setVar("find_type", $this->ops_find_type);
 			caSetPageCSSClasses(array("browse", "results"));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$this->view->setVar("config", $this->opo_config);
 			$ps_function = strtolower($ps_function);
 			$ps_type = $this->request->getActionExtra();
 			
 			if (!($va_browse_info = caGetInfoForBrowseType($ps_function))) {
 				// invalid browse type – throw error
 				throw new ApplicationException("Invalid browse type");
 			}
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": "._t("Browse %1", $va_browse_info["displayName"]));
 			$this->view->setVar("browse_type", $ps_function);
 			$vs_class = $this->ops_tablename = $va_browse_info['table'];
 			$va_types = caGetOption('restrictToTypes', $va_browse_info, array(), array('castTo' => 'array'));
 			
			$vb_is_nav = (bool)$this->request->getParameter('isNav', pString);
 			
 			$this->opo_result_context = new ResultContext($this->request, $va_browse_info['table'], $this->ops_find_type);
 			
 			// Don't set last find when loading facet (or when the 'dontSetFind' request param is explicitly set)
 			// as some other controllers use this action and setting last find will disrupt ResultContext navigation 
 			// by setting it to "browse" when in fact a search (or some other context) is still in effect.
 			if (!$this->request->getParameter('getFacet', pInteger) && !$this->request->getParameter('dontSetFind', pInteger)) {
 				$this->opo_result_context->setAsLastFind();
 			}
 			
 			$this->view->setVar('browseInfo', $va_browse_info);
			$this->view->setVar('paging', in_array(strtolower($va_browse_info['paging']), array('continous', 'nextprevious', 'letter')) ? strtolower($va_browse_info['paging']) : 'continous');
			
 			$this->view->setVar('name', $va_browse_info['displayName']);
 			$this->view->setVar('options', caGetOption('options', $va_browse_info, array(), array('castTo' => 'array')));
 			
 			$ps_view = $this->request->getParameter('view', pString);
 			$va_views = caGetOption('views', $va_browse_info, array(), array('castTo' => 'array'));
 			if(!is_array($va_views) || (sizeof($va_views) == 0)){
 				$va_views = array('list' => array(), 'images' => array(), 'timeline' => array(), 'map' => array(), 'timelineData' => array(), 'pdf' => array(), 'xlsx' => array(), 'pptx' => array());
 			} else {
				$va_views['pdf'] = $va_views['timelineData'] = $va_views['xlsx'] = $va_views['pptx'] = array();
			}
			
			$va_view_info = $va_views[$ps_view];
			
 			if(!in_array($ps_view, array_keys($va_views))) {
 				$ps_view = array_shift(array_keys($va_views));
 			}
 			
 			$vs_format = ($ps_view == 'timelineData') ? 'json' : 'html';

 			caAddPageCSSClasses(array($vs_class, $ps_function));

			$t_instance = $this->getAppDatamodel()->getInstanceByTableName($vs_class, true);
			$vn_type_id = $t_instance->getTypeIDForCode($ps_type);
			
			$this->view->setVar('t_instance', $t_instance);
 			$this->view->setVar('table', $va_browse_info['table']);
 			$this->view->setVar('primaryKey', $t_instance->primaryKey());
		
			$this->view->setVar('browse', $o_browse = caGetBrowseInstance($vs_class));
			$this->view->setVar('views', caGetOption('views', $va_browse_info, array(), array('castTo' => 'array')));
			$this->view->setVar('view', $ps_view);
			$this->view->setVar('viewIcons', $this->opo_config->getAssoc("views"));
		
			//
			// Load existing browse if key is specified
			//
			if ($ps_cache_key = $this->request->getParameter('key', pString)) {
				$o_browse->reload($ps_cache_key);
			}
		
			if (is_array($va_types) && sizeof($va_types)) { $o_browse->setTypeRestrictions($va_types, array('dontExpandHierarchically' => caGetOption('dontExpandTypesHierarchically', $va_browse_info, false))); }
		
			//
			// Clear criteria if required
			//
			
			if ($vs_remove_criterion = $this->request->getParameter('removeCriterion', pString)) {
				$o_browse->removeCriteria($vs_remove_criterion, array($this->request->getParameter('removeID', pString)));
			}
			
			if ((bool)$this->request->getParameter('clear', pInteger)) {
				$o_browse->removeAllCriteria();
			}
			
			//
			// Return facet content
			//	
			if ($this->request->getParameter('getFacet', pInteger)) {
				return $this->getFacet($o_browse);
			}
		
			//
			// Add criteria and execute
			//
			
			// Get any preset-criteria
			$va_base_criteria = caGetOption('baseCriteria', $va_browse_info, null);
			
			if ($vs_facet = $this->request->getParameter('facet', pString)) {
				$o_browse->addCriteria($vs_facet, array($this->request->getParameter('id', pString)));
			} else { 
				if ($o_browse->numCriteria() == 0) {
					if (is_array($va_base_criteria)) {
						foreach($va_base_criteria as $vs_facet => $vs_value) {
							$o_browse->addCriteria($vs_facet, $vs_value);
						}
					} else {
						$o_browse->addCriteria("_search", array("*"));
					}
				}
			}
			
			//
			// Sorting
			//
			$vb_sort_changed = false;
 			if (!($ps_sort = $this->request->getParameter("sort", pString))) {
 				if (!($ps_sort = $this->opo_result_context->getCurrentSort())) {
 					if(is_array(($va_sorts = caGetOption('sortBy', $va_browse_info, null)))) {
 						$ps_sort = array_shift(array_keys($va_sorts));
 						$vb_sort_changed = true;
 					}
 				}
 			}else{
 				$vb_sort_changed = true;
 			}
 			if($vb_sort_changed){
				# --- set the default sortDirection if available
				$va_sort_direction = caGetOption('sortDirection', $va_browse_info, null);
				if($ps_sort_direction = $va_sort_direction[$ps_sort]){
					$this->opo_result_context->setCurrentSortDirection($ps_sort_direction);
				} 			
 			}
  			if (!($ps_sort_direction = $this->request->getParameter("direction", pString))) {
 				if (!($ps_sort_direction = $this->opo_result_context->getCurrentSortDirection())) {
 					$ps_sort_direction = 'asc';
 				}
 			}
 			
 			$this->opo_result_context->setCurrentSort($ps_sort);
 			$this->opo_result_context->setCurrentSortDirection($ps_sort_direction);
 			
			$va_sort_by = caGetOption('sortBy', $va_browse_info, null);
			$this->view->setVar('sortBy', is_array($va_sort_by) ? $va_sort_by : null);
			$this->view->setVar('sortBySelect', $vs_sort_by_select = (is_array($va_sort_by) ? caHTMLSelect("sort", $va_sort_by, array('id' => "sort"), array("value" => $ps_sort)) : ''));
			$this->view->setVar('sortControl', $vs_sort_by_select ? _t('Sort with %1', $vs_sort_by_select) : '');
			$this->view->setVar('sort', $ps_sort);
			$this->view->setVar('sort_direction', $ps_sort_direction);

			if (caGetOption('dontShowChildren', $va_browse_info, false)) {
				$o_browse->addResultFilter('ca_objects.parent_id', 'is', 'null');	
			}
		
			//
			// Current criteria
			//
			$va_criteria = $o_browse->getCriteriaWithLabels();
			if (isset($va_criteria['_search']) && (isset($va_criteria['_search']['*']))) {
				unset($va_criteria['_search']);
			} 

			$o_browse->execute(array('checkAccess' => $this->opa_access_values, 'showAllForNoCriteriaBrowse' => true));
			
			//
			// Facets
			//
			if ($vs_facet_group = caGetOption('facetGroup', $va_browse_info, null)) {
				$o_browse->setFacetGroup($vs_facet_group);
			}
			
			$va_available_facet_list = caGetOption('availableFacets', $va_browse_info, null);
			$va_facets = $o_browse->getInfoForAvailableFacets();
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				if(isset($va_base_criteria[$vs_facet_name])) { continue; } // skip base criteria 
				$va_facets[$vs_facet_name]['content'] = $o_browse->getFacet($vs_facet_name, array("checkAccess" => $this->opa_access_values, 'checkAvailabilityOnly' => caGetOption('deferred_load', $va_facet_info, false, array('castTo' => 'bool'))));
			}
			$this->view->setVar('facets', $va_facets);
		
			$this->view->setVar('key', $vs_key = $o_browse->getBrowseID());
			
			$this->request->session->setVar($ps_function.'_last_browse_id', $vs_key);
			
			
			// remove base criteria from display list
			if (is_array($va_base_criteria)) {
				foreach($va_base_criteria as $vs_base_facet => $vs_criteria_value) {
					unset($va_criteria[$vs_base_facet]);
				}
			}
			
			$va_criteria_for_display = array();
			foreach($va_criteria as $vs_facet_name => $va_criterion) {
				$va_facet_info = $o_browse->getInfoForFacet($vs_facet_name);
				foreach($va_criterion as $vn_criterion_id => $vs_criterion) {
					$va_criteria_for_display[] = array('facet' => $va_facet_info['label_singular'], 'facet_name' => $vs_facet_name, 'value' => $vs_criterion, 'id' => $vn_criterion_id);
				}
			}
			$this->view->setVar('criteria', $va_criteria_for_display);
			
			// 
			// Results
			//
			
			$qr_res = $o_browse->getResults(array('sort' => $va_sort_by[$ps_sort], 'sort_direction' => $ps_sort_direction));
			
			if ($vs_letter_bar_field = caGetOption('showLetterBarFrom', $va_browse_info, null)) { // generate letter bar
				$va_letters = array();
				while($qr_res->nextHit()) {
					$va_letters[caRemoveAccents(mb_strtolower(mb_substr($qr_res->get($vs_letter_bar_field), 0, 1)))]++;
				}
				$this->view->setVar('letterBar', $va_letters);
				$qr_res->seek(0);
			}
			$this->view->setVar('showLetterBar', (bool)$vs_letter_bar_field);
			
						
			if ($vs_letter_bar_field && ($vs_l = mb_strtolower($this->request->getParameter('l', pString)))) {
				$va_filtered_ids = array();
				while($qr_res->nextHit()) {
					if (caRemoveAccents(mb_strtolower(mb_substr($qr_res->get($vs_letter_bar_field), 0, 1))) == $vs_l) {
						$va_filtered_ids[] = $qr_res->getPrimaryKey();
					}
				}
				if (sizeof($va_filtered_ids) > 0) {
					$qr_res = caMakeSearchResult($vs_class, $va_filtered_ids);
				}
			}
			$this->view->setVar('letter', $vs_l);
			
			
			$this->view->setVar('result', $qr_res);
				
			if (!($pn_hits_per_block = $this->request->getParameter("n", pString))) {
 				if (!($pn_hits_per_block = $this->opo_result_context->getItemsPerPage())) {
 					$pn_hits_per_block = $this->opo_config->get("defaultHitsPerBlock");
 				}
 			}
 			$this->opo_result_context->getItemsPerPage($pn_hits_per_block);
			
			$this->view->setVar('hits_per_block', $pn_hits_per_block);

			$this->view->setVar('start', $vn_start = $this->request->getParameter('s', pInteger));
			

			$this->opo_result_context->setParameter('key', $vs_key);
			
			if (!$this->request->isAjax()) {
				if (($vn_key_start = $vn_start - 500) < 0) { $vn_key_start = 0; }
				$qr_res->seek($vn_key_start);
				$this->opo_result_context->setResultList($qr_res->getPrimaryKeyValues(500));
				$qr_res->seek($vn_start);
			}
				
			$this->opo_result_context->saveContext();
 			
 			if ($ps_type) {
 				if ($this->render($this->ops_view_prefix."/{$vs_class}_{$ps_type}_{$ps_view}_{$vs_format}.php")) { return; }
 			} 
 			
 			// map
			if ($ps_view === 'map') {
				$va_opts = array('renderLabelAsLink' => false, 'request' => $this->request, 'color' => '#cc0000');
		
				$va_opts['ajaxContentUrl'] = caNavUrl($this->request, '*', '*', 'AjaxGetMapItem', array('browse' => $ps_function,'view' => $ps_view));
			
				$o_map = new GeographicMap(caGetOption("width", $va_view_info, "100%"), caGetOption("height", $va_view_info, "600px"));
				$qr_res->seek(0);
				$o_map->mapFrom($qr_res, $va_view_info['data'], $va_opts);
				$this->view->setVar('map', $o_map->render('HTML', array()));
			}
 			
 			switch($ps_view) {
 				case 'xlsx':
 				case 'pptx':
 				case 'pdf':
 					$this->_genExport($qr_res, $this->request->getParameter("export_format", pString), $vs_search_expression, $this->getCriteriaForDisplay($o_browse));
 					break;
 				case 'timelineData':
 					$this->view->setVar('view', 'timeline');
 					$this->render($this->ops_view_prefix."/browse_results_timelineData_json.php");
 					break;
 				default:
 					$this->opo_result_context->setCurrentView($ps_view);
 					$this->render($this->ops_view_prefix."/browse_results_html.php");
 					break;
 			}
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Browse',
 				'action' => $po_request->getAction(),
 				'params' => array(
 					'key'
 				)
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
		/** 
		 * return nav bar code for specified browse target
		 */
 		public function getBrowseNavBarByTarget() {
 			$ps_target = $this->request->getParameter('target', pString);
 			$this->view->setVar("target", $ps_target);
 			if (!($va_browse_info = caGetInfoForBrowseType($ps_target))) {
 				// invalid browse type – throw error
 				throw new ApplicationException("Invalid browse type");
 			}
 			$this->view->setVar("browse_name", $va_browse_info["displayName"]);
			$this->render("pageFormat/browseMenuFacets.php");
 		}
 		# ------------------------------------------------------------------
 		/**
 		 * Returns summary of current browse parameters suitable for display.
 		 *
 		 * @return string Summary of current browse criteria ready for display
 		 */
 		public function getCriteriaForDisplay($po_browse=null) {
 			$va_criteria = $po_browse->getCriteriaWithLabels();
 			if (!sizeof($va_criteria)) { return ''; }
 			$va_criteria_info = $po_browse->getInfoForFacets();
 			
 			$va_buf = array();
 			foreach($va_criteria as $vs_facet => $va_vals) {
 				$va_buf[] = caUcFirstUTF8Safe($va_criteria_info[$vs_facet]['label_singular']).': '.join(", ", $va_vals);
 			}
 			
 			return join(" / ", $va_buf);
  		}
 		# -------------------------------------------------------
	}
