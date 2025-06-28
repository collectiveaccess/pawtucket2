<?php
/* ----------------------------------------------------------------------
 * app/controllers/SearchController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2025 Whirl-i-Gig
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
require_once(__CA_APP_DIR__."/helpers/searchHelpers.php");
require_once(__CA_APP_DIR__."/controllers/FindController.php");

class SearchController extends FindController {
	# -------------------------------------------------------
	/**
	 *
	 */
	protected $ops_find_type = "search";

	/**
	 *
	 */
	protected $opo_result_context = null;
	
	/**
	 *
	 */
	protected $ops_view_prefix = 'Search';
	
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$request, &$response, $pa_view_paths=null) {
		$this->config = caGetBrowseConfig();
		$this->view_class = 'AdvancedSearchView';
		
		parent::__construct($request, $response, $pa_view_paths);

		if ($this->request->config->get('pawtucket_requires_login') && !($this->request->isLoggedIn())) {
			$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
		}
		
		$this->view->setVar("find_type", $this->ops_find_type);
		caSetPageCSSClasses(["search", "results"]);
	}
	# -------------------------------------------------------
	/**
	 *
	 */ 
	public function __call($function, $args) {
		$o_search_config = caGetSearchConfig();
		$options = array_shift($args);
		
		$this->view->setVar("config", $this->config);
		$function = strtolower($function);
		$type = $this->request->getActionExtra();
		
		// Try to load browse info assuming advanced, then basic search to get the current table.
		if(!($browse_info = caGetInfoForAdvancedSearchType($function))) {
			if(!($browse_info = caGetInfoForBrowseType($function))) {
				throw new ApplicationException("Invalid browse type $function");
			}
		}
		// Once we have the current table we can figure out if we're really advanced or not
		$class = $this->ops_tablename = $browse_info['table'];
		
		$is_advanced = ((bool)$this->request->getParameter('_advanced', pInteger) || (is_null($this->request->parameterExists('_advanced')) && (strpos(ResultContext::getLastFind($this->request, $class), 'advanced') !== false)));
		$find_type = $is_advanced ? $this->ops_find_type.'_advanced' : $this->ops_find_type;
		
		// Reload browse info once we're sure we're advanced or not
		if($is_advanced) {
			$browse_info = caGetInfoForAdvancedSearchType($function);
		} else {
			$browse_info = caGetInfoForBrowseType($function);
		}
		
		$this->view->setVar('is_advanced', $is_advanced);
		$this->view->setVar("browse_type", $function);
		
		if ($is_advanced) {
			if (!($browse_info = caGetInfoForAdvancedSearchType($function))) {
				// invalid browse type – throw error
				throw new ApplicationException("Invalid advanced search type $function");
			}
		} elseif (!($browse_info = caGetInfoForBrowseType($function))) {
			// invalid browse type – throw error
			throw new ApplicationException("Invalid browse type $function");
		}
		
		// Now that table name is known we can set standard view vars
		parent::setTableSpecificViewVars($browse_info);
		
		$types = caGetOption('restrictToTypes', $browse_info, [], array('castTo' => 'array'));
		
		# --- row id passed when click back button on detail page - used to load results to and jump to last viewed item
		$this->view->setVar('row_id', $pn_row_id = $this->request->getParameter('row_id', pInteger));
		
		$this->opo_result_context = new ResultContext($this->request, $browse_info['table'], $find_type, $function);
		
		// Allow plugins to rewrite search prior to execution
		$qr_res = null;
		$this->opo_app_plugin_manager->hookReplaceSearch(['search' => $function, 'browseInfo' => &$browse_info, 'searchExpression' => &$search_expression, 'result' => &$qr_res]);
		$search_was_replaced = ($qr_res) ? true : false;
		
		$view = $this->request->getParameter('view', pString, ['forcePurify' => true]);
		if ($view == 'jsonData') {
			$this->view->setVar('context', $this->opo_result_context);
			$this->render("Browse/browse_results_data_json.php");
			return;
		}
		
		$search_expression = $this->opo_result_context->getSearchExpression();
		$search_expression = str_replace("::slash::", "/", $search_expression);
		if(!$this->request->isAjax()) {
			if ($label = $this->request->getParameter('label', pString, ['forcePurify' => true])) {
				$this->opo_result_context->setSearchExpressionForDisplay("{$label}: {$search_expression}"); 
				$search_expression_for_display = $this->opo_result_context->getSearchExpressionForDisplay($search_expression); 
			} elseif($named_search=caGetNamedSearch($search_expression, $this->request->getParameter('values', pString, ['forcePurify' => true]))) {
				$search_expression_for_display = caGetNamedSearchForDisplay($search_expression, $this->request->getParameter('values', pString));
				$this->opo_result_context->setSearchExpression($named_search);
				$this->opo_result_context->setSearchExpressionForDisplay($search_expression_for_display);
				$search_expression = $named_search;
			} else {
				$search_expression_for_display = $this->opo_result_context->getSearchExpressionForDisplay($search_expression); 
			}
			
			$this->opo_result_context->setAsLastFind(true);
		}
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Search %1", $browse_info["displayName"]).$this->request->config->get("page_title_delimiter").$this->opo_result_context->getSearchExpressionForDisplay());
		
		//
		// Handle advanced search form submissions
		//
		if($is_advanced) { 
			if (!$this->request->isAjax()) {
				if($adv_search_expression = caGetQueryStringForHTMLFormInput($this->opo_result_context, ['match_on_stem' => $o_search_config->get(['matchOnStem', 'match_on_stem'])])) {
					$this->opo_result_context->setSearchExpression($adv_search_expression); 
					$search_expression = $adv_search_expression;
				}
			}
			if (!$this->request->isAjax() && ($search_expression_for_display = caGetDisplayStringForHTMLFormInput($this->opo_result_context))) {
				$this->opo_result_context->setSearchExpressionForDisplay($search_expression_for_display);
				$this->opo_result_context->setSearchExpression($search_expression);
			}
		}
		
		$this->view->setVar('browseInfo', $browse_info);
		$this->view->setVar('paging', in_array(strtolower($browse_info['paging']), array('continuous', 'nextprevious', 'letter')) ? strtolower($browse_info['paging']) : 'continuous');
		
		$this->view->setVar('options', caGetOption('options', $browse_info, [], array('castTo' => 'array')));
		
		$views = caGetOption('views', $browse_info, [], array('castTo' => 'array'));
		if(!is_array($views) || (sizeof($views) == 0)){
			$views = array('list' => [], 'images' => [], 'timeline' => [], 'map' => [], 'timelineData' => [], 'pdf' => [], 'xlsx' => [], 'pptx' => []);
		} else {
			$views['pdf'] = $views['timelineData'] = $views['xlsx'] = $views['pptx'] = [];
		}
		
		if (!$view) {
			$view = $this->opo_result_context->getCurrentView();
		}
		if(!in_array($view, array_keys($views))) {
			$view = array_shift(array_keys($views));
		}
		# --- only set the current view if it's not an export format
		if(!in_array($view, array("pdf", "xlsx", "pptx", "timelineData"))){
			$this->opo_result_context->setCurrentView($view);
		}
		
		$view_info = $views[$view];

		$format = ($view == 'timelineData') ? 'json' : 'html';
		
		caAddPageCSSClasses(array($class, $function));
		
		$this->view->setVar('isNav', (bool)$this->request->getParameter('isNav', pInteger));	// flag for browses that originate from nav bar
		
		$t_instance = Datamodel::getInstance($class, true);
		if($type){
			$type_id = $t_instance->getTypeIDForCode($type);
		}
		$this->view->setVar('t_instance', $t_instance);
		$this->view->setVar('table', $browse_info['table']);
		$this->view->setVar('primaryKey', $t_instance->primaryKey());
	
		$this->view->setVar('browse', $o_browse = caGetBrowseInstance($class));
		$this->view->setVar('views', caGetOption('views', $browse_info, [], array('castTo' => 'array')));
		$this->view->setVar('view', $view);
		$this->view->setVar('viewIcons', $this->config->getAssoc("views"));
	
		//
		// Load existing browse if key is specified
		//
		if ($cache_key = $this->request->getParameter('key', pString, ['forcePurify' => true])) {
			$o_browse->reload($cache_key);
		}
	
		if (is_array($types) && sizeof($types)) { $o_browse->setTypeRestrictions($types, array('dontExpandHierarchically' => caGetOption('dontExpandTypesHierarchically', $browse_info, false))); }
	
		//
		// Clear criteria if required
		//
		
		if ($remove_criterion = $this->request->getParameter('removeCriterion', pString, ['forcePurify' => true])) {
			$o_browse->removeCriteria($remove_criterion, array($this->request->getParameter('removeID', pString, ['forcePurify' => true])));
			if($remove_criterion == "_search"){
				$this->opo_result_context->setSearchExpression("*");
				$search_expression = $this->opo_result_context->getSearchExpression();
			}
		}
		
		if ((bool)$this->request->getParameter('clear', pInteger)) {
			// Clear all refine critera but *not* underlying _search criterion
			if (is_array($criteria = $o_browse->getCriteria())) {
				foreach($criteria as $criterion => $criterion_info) {
					if ($criterion == '_search') { continue; }
					$o_browse->removeCriteria($criterion, array_keys($criterion_info));
				}
			}
		}
				
		if ($this->request->getParameter('getFacet', pInteger)) {
			$facet = $this->request->getParameter('facet', pString, ['forcePurify' => true]);
			$this->view->setVar('facet_name', $facet);
			$this->view->setVar('key', $o_browse->getBrowseID());
			$facet_info = $o_browse->getInfoForFacet($facet);
			$this->view->setVar('facet_info', $facet_info);
			# --- pull in different views based on format for facet - alphabetical, list, hierarchy
			 switch($facet_info["group_mode"]){
				case "alphabetical":
				case "list":
				default:
					$content = !$search_was_replaced ? $o_browse->getFacetContent($facet, array('checkAccess' => $this->opa_access_values, 'request' => $this->request)) : [];
					$this->view->setVar('facet_content', is_array($content) ? $content : []);
					$this->render("Browse/list_facet_html.php");
					break;
				case "hierarchical":
					$this->render("Browse/hierarchy_facet_html.php");
					break;
			}
			return;
		}
	
		//
		// Add criteria and execute
		//

		if (($facets = $this->request->getParameter('facets', pString, ['forcePurify' => true])) && is_array($facets = explode(';', $facets)) && sizeof($facets)) {
			foreach ($facets as $facet_spec) {
				if (!sizeof($tmp = explode(':', $facet_spec))) { continue; }
				$facet = array_shift($tmp);
				$tmp = array_map(function($v) { 
					return urldecode($v);
				}, $tmp);
				$o_browse->addCriteria($facet, explode("|", join(":", $tmp))); 
			}
		} elseif ($search_refine = $this->request->getParameter('search_refine', pString, ['forcePurify' => true])) {
			$o_browse->addCriteria('_search', [caMatchOnStem($search_refine)], array($search_refine));
		} elseif ($facet = $this->request->getParameter('facet', pString, ['forcePurify' => true])) {
			$o_browse->addCriteria($facet, explode("|", $this->request->getParameter('id', pString, ['forcePurify' => true])));
		}
				
		if (($o_browse->numCriteria() == 0) && $search_expression) {
			$o_browse->addCriteria("_search", [caMatchOnStem($search_expression)], array($search_expression_for_display));
		}
		
		//
		// Add additional base criteria if necessary
		//
		if(($base_criteria = $o_search_config->get('baseCriteria') && ($table_criteria = $base_criteria[$browse_info['table']])) || ($table_criteria = $browse_info['baseCriteria'])){;
			foreach($table_criteria as $facet => $value){
				$o_browse->addCriteria($facet, $value);
			}
		}
		
		//
		// Sorting
		//
		$sort_changed = false;
		$o_block_result_context = null;
		
		$sort_by = caGetOption('sortBy', $browse_info, null);
		
		if (!($sort = urldecode($this->request->getParameter("sort", pString, ['forcePurify' => true])))) {
			// inherit sort setting from multisearch? (used when linking to full results from multisearch result)
			if ($this->request->getParameter("source", pString, ['forcePurify' => true]) === 'multisearch') {
				$o_block_result_context = new ResultContext($this->request, $browse_info['table'], 'multisearch', $function);
				if (($sort !== $o_block_result_context->getCurrentSort()) && $o_block_result_context->getCurrentSort()) {
					$sort = $o_block_result_context->getCurrentSort();
					$sort_changed = true;
				}
			}
			
			if (!$sort){ $sort = $this->opo_result_context->getCurrentSort(); }
		} elseif($sort != $this->opo_result_context->getCurrentSort()){ 
			$sort_changed = true; 
		}
		
		if(preg_match("!^ca_set_items.rank:[\d]+$!", $sort)) {
			$sort = str_replace(":", "/", $sort);
			$sort_by[$sort] = $sort;
		} elseif(is_array($sorts = caGetOption('sortBy', $browse_info, null))) {
			if (!$sort || (!in_array($sort, array_keys($sorts)))) {
				$sort = array_shift(array_keys($sorts));
				$sort_changed = true;
			}
		}
		
		if($sort_changed){
			# --- set the default sortDirection if available
			$sort_direction = caGetOption('sortDirection', $browse_info, null);
			if($sort_direction = $sort_direction[$sort]){
				$this->opo_result_context->setCurrentSortDirection($sort_direction);
			} 			
		}
		if (!($sort_direction = strtolower($this->request->getParameter("direction", pString, ['forcePurify' => true])))) {
			if (!($sort_direction = $this->opo_result_context->getCurrentSortDirection())) {
				$sort_direction = 'asc';
			}
		}
		if(!in_array($sort_direction, ['asc', 'desc'])) {  $sort_direction = 'asc'; }
		
		
		$this->opo_result_context->setCurrentSort($sort);
		$this->opo_result_context->setCurrentSortDirection($sort_direction);
		
		$this->view->setVar('sortBy', is_array($sort_by) ? $sort_by : null);
		$this->view->setVar('sortBySelect', $sort_by_select = (is_array($sort_by) ? caHTMLSelect("sort", $sort_by, array('id' => "sort"), array("value" => $sort)) : ''));
		$this->view->setVar('sortControl', $sort_by_select ? _t('Sort with %1', $sort_by_select) : '');
		$this->view->setVar('sort', $sort);
		$this->view->setVar('sort_direction', $sort_direction);
		
		$options = array('checkAccess' => $this->opa_access_values);
		if ($restrict_to_fields = caGetOption('restrictSearchToFields', $browse_info, null)) {
			$options['restrictSearchToFields'] = $restrict_to_fields;
		}
		if ($exclude_fields_from_search = caGetOption('excludeFieldsFromSearch', $browse_info, null)) {
			$options['excludeFieldsFromSearch'] = $exclude_fields_from_search;
		}
		
		
		if (caGetOption('dontShowChildren', $browse_info, false)) {
			$o_browse->addResultFilter($browse_info['table'].'.parent_id', 'is', 'null');	
		}
		
		$root_records_only = caGetOption('omitChildRecords', $browse_info, [], array('castTo' => 'bool'));
		
		$expand_results_hierarchically = caGetOption('expandResultsHierarchically', $browse_info, [], array('castTo' => 'bool'));
		if (!$search_was_replaced) { $o_browse->execute(array_merge($options, array('checkAccess' => $this->opa_access_values, 'request' => $this->request, 'expandResultsHierarchically' => $expand_results_hierarchically, 'expandToIncludeParents' => caGetOption('expandToIncludeParents', $browse_info, false), 'strictPhraseSearching' => !$is_advanced || (bool)$o_search_config->get('use_strict_phrase_searching_for_advanced_searches'), 'rootRecordsOnly' => $root_records_only))); }
	
		// Set highlight text
		MetaTagManager::setHighlightText($o_browse->getSearchedTerms() ?? $search_expression, ['persist' => !RequestHTTP::isAjax()]); 
	
		//
		// Facets
		//
		if ($facet_group = caGetOption('facetGroup', $browse_info, null)) {
			$o_browse->setFacetGroup($facet_group);
		}
		$available_facet_list = caGetOption('availableFacets', $browse_info, null);
		$facets = $o_browse->getInfoForAvailableFacets(['checkAccess' => $this->opa_access_values, 'request' => $this->request]);
		if(is_array($available_facet_list) && sizeof($available_facet_list)) {
			foreach($facets as $facet_name => $facet_info) {
				if (!in_array($facet_name, $available_facet_list)) {
					unset($facets[$facet_name]);
				}
			}
		} 
	
		if (!$search_was_replaced) {
			foreach($facets as $facet_name => $facet_info) {
				// Enforce role-restricted facets here
				if (isset($facet_info['require_roles']) && is_array($facet_info['require_roles']) && sizeof($facet_info['require_roles'])) {
					if (!$this->request->isLoggedIn() || !sizeof(array_filter($facet_info['require_roles'], function($v) { return $this->request->user->hasUserRole($v); }))) { continue; }
				}
				$facets[$facet_name]['content'] = $o_browse->getFacet($facet_name, array('checkAccess' => $this->opa_access_values, 'request' => $this->request));
			}
		}
	
		$this->view->setVar('facets', $facets);
	
		$this->view->setVar('key', $key = $o_browse->getBrowseID());
		Session::setVar($function.'_last_browse_id', $key);
		
	
		//
		// Current criteria
		//
		$criteria = $o_browse->getCriteriaWithLabels();
		if (isset($criteria['_search']) && (isset($criteria['_search']['*']))) {
			unset($criteria['_search']['*']);
		}
		// remove base criteria from display list
		
		if (is_array($table_criteria)) {
			foreach($table_criteria as $base_facet => $criteria_value) {
				unset($criteria[$base_facet]);
			}
		}
		$criteria_for_display = [];
		foreach($criteria as $facet_name => $criterion) {
			$facet_info = $o_browse->getInfoForFacet($facet_name);
			foreach($criterion as $criterion_id => $criterion) {
				$criteria_for_display[] = array('facet' => $facet_info['label_singular'], 'facet_name' => $facet_name, 'value' => $this->purifier->purify($criterion), 'id' => $criterion_id);
			}
		}
		$this->view->setVar('criteria', $criteria_for_display);
		
		
		$x = [];
		foreach($criteria as $facet => $values) {
			$x[] = $facet.":".join("|", array_keys($values));
		}
		$this->view->setVar('share_url', caNavUrl($this->request, '*', '*', '*', ['facets' => join(";", $x)], ['absolute' => true]));

	
		// 
		// Results
		//
		if (!$search_was_replaced) { $qr_res = $o_browse->getResults(array('sort' => $sort_by[$sort], 'sort_direction' => $sort_direction)); }
	
		$qr_res->doHighlighting($o_search_config->get("do_highlighting"));
		$this->view->setVar('result', $qr_res);
		
		if (!($pn_hits_per_block = $this->request->getParameter("n", pString, ['forcePurify' => true]))) {
			if (!($pn_hits_per_block = $this->opo_result_context->getItemsPerPage())) {
				$pn_hits_per_block = $this->config->get("defaultHitsPerBlock");
			}
		}
		$this->opo_result_context->getItemsPerPage($pn_hits_per_block);
		
		$this->view->setVar('hits_per_block', $pn_hits_per_block);
		
		$this->view->setVar('start', $start = $this->request->getParameter('s', pInteger));
		
		$this->opo_result_context->setParameter('key', $key);
		
		if (($key_start = (int)$start - 5000) < 0) { $key_start = 0; }
		$qr_res->seek($key_start);
		$this->opo_result_context->setResultList($qr_res->getPrimaryKeyValues(5000));
		if ($o_block_result_context) { $o_block_result_context->setResultList($qr_res->getPrimaryKeyValues(5000)); $o_block_result_context->saveContext();}

		$qr_res->seek($start);
		
		$c = 0;
		$hit_ids = [];
		while(($c <= $pn_hits_per_block) && $qr_res->nextHit()) {
			$hit_ids[] = $qr_res->get($qr_res->primaryKey(true));
			$c++;
		}
		
		$qr_res->seek($start);
		
		$result_desc = $o_browse->getResultDesc($hit_ids);
		$this->view->setVar('result_desc', $result_desc);
		$this->opo_result_context->setResultDesc($result_desc);

		$this->opo_result_context->saveContext();
		
		if ($type_id) {
			if ($this->render("Browse/{$class}_{$type}_{$view}_{$format}.php")) { return; }
		} 
		
		// map
		if ($view === 'map') {
			$opts = array(
				'renderLabelAsLink' => false, 
				'request' => $this->request, 
				'color' => '#cc0000', 
				'labelTemplate' => caGetOption('labelTemplate', $view_info['display'], null),
				'contentTemplate' => caGetOption('contentTemplate', $view_info['display'], null),
				//'ajaxContentUrl' => caNavUrl($this->request, '*', '*', 'AjaxGetMapItem', array('browse' => $function,'view' => $view))
			);

			$o_map = new GeographicMap(caGetOption("width", $view_info, "100%"), caGetOption("height", $view_info, "600px"));
			$qr_res->seek(0);
			$o_map->mapFrom($qr_res, $view_info['data'], $opts);
			$this->view->setVar('map', $o_map->render('HTML', array('circle' => 0, 'minZoomLevel' => caGetOption("minZoomLevel", $view_info, 2), 'maxZoomLevel' => caGetOption("maxZoomLevel", $view_info, 12), 'noWrap' => caGetOption("noWrap", $view_info, null), 'request' => $this->request)));
		}
		
		
		switch($view) {
			case 'xlsx':
			case 'pptx':
			case 'pdf':
				$this->_genExport($qr_res, $this->request->getParameter("export_format", pString, ['forcePurify' => true]), caGenerateDownloadFileName(caGetOption('pdfExportTitle', $browse_info, $search_expression)), $this->getCriteriaForDisplay($o_browse));
				break;
			case 'timelineData':
				$this->view->setVar('view', 'timeline');
				$this->render("Browse/browse_results_timelineData_json.php");
				break;
			default:
				$dont_redirect_to_single_search_result = $this->config->get('dont_redirect_to_single_search_result');
				if (($qr_res->numHits() == 1) && (!$dont_redirect_to_single_search_result)) {
					$qr_res->nextHit();
					$this->response->setRedirect(caDetailUrl($this->request, $this->ops_tablename, $qr_res->get($this->ops_tablename.".".$qr_res->primaryKey(true)), false));
				}				
				$this->render("Browse/browse_results_html.php");
				break;
		}
	}
	# -------------------------------------------------------
	# Advanced search
	# -------------------------------------------------------
	/** 
	 * 
	 */
	public function advanced() {
		$function = strtolower($this->request->getActionExtra());
		
		if (!($search_info = caGetInfoForAdvancedSearchType($function))) {
			// invalid advanced search type – throw error
			throw new ApplicationException("Invalid advanced search type");
		}
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Search %1", $search_info["displayName"]));
		caSetPageCSSClasses(array("search results advancedSearch"));

		$types = caGetOption('restrictToTypes', $search_info, array(), array('castTo' => 'array'));
		
		$this->opo_result_context = new ResultContext($this->request, $search_info['table'], $this->ops_find_type.'_advanced', $function);
		$this->opo_result_context->setAsLastFind();
		
		$this->view->setVar('searchInfo', $search_info);
		$this->view->setVar('options', caGetOption('options', $search_info, [], ['castTo' => 'array']));
		
		$this->opo_result_context->saveContext();
		
		$this->render($search_info['view']);
	}
	# ------------------------------------------------------- 
	/**
	 *
	 */
	public function generalSearch(?array $options=null) {
		$search_targets = $this->config->getList('generalSearchTargets');
		$browse_types = $this->config->getAssoc('browseTypes');
		$dont_redirect_to_single_search_result = $this->config->get('dont_redirect_to_single_search_result');
		
		$find_type = "generalsearch";
		$tables = $result_contexts = [];
		
		// Create result context for each target
		foreach($search_targets as $target) {
			if(!isset($browse_types[$target])) { continue; }
			if(!($table = $browse_types[$target]['table'] ?? null)) { continue; }
			
			$tables[$table] = 1;
			$result_contexts[$target] = new ResultContext($this->request, $table, $find_type, $target);
			$result_contexts[$target]->setAsLastFind(false);
		}
		
		// Create generic contexts for each table in generalsearch (no specific target); used to house search history and overall counts
		// when there is more than one target for a given table
		foreach(array_keys($tables) as $table) {
			$result_contexts["_generalsearch_{$table}"] = new ResultContext($request, $table, $find_type);
		}
		
		if (!is_array($result_contexts) || !sizeof($result_contexts)) { 
			// TODO: throw error - no searches are defined
			return false;
		}
		
		$o_first_result_context = array_shift(array_values($result_contexts));
		
		$search = $o_first_result_context->getSearchExpression();
		
		if ($label = $this->request->getParameter('label', pString, ['forcePurify' => true])) {
			$o_first_result_context->setSearchExpressionForDisplay("{$label}: ".caGetDisplayStringForSearch($search, ['omitFieldNames' => true]));
		} else {
			$o_first_result_context->setSearchExpressionForDisplay(caGetDisplayStringForSearch($search)); 
		}
		$search_display = $o_first_result_context->getSearchExpressionForDisplay();
		
		$this->view->setVar('search', $search);
		$this->view->setVar('searchForDisplay', $search_display);
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Search results for '%1'", $search_display));		
		$this->view->setVar('config', $this->config);
		$this->view->setVar('blocks', $search_targets);
		$this->view->setVar('blockNames', $search_targets);
		$this->view->setVar('results', $results = caGeneralSearch($this->request, $search, $search_targets, [
			'access' => $this->opa_access_values, 
			'contexts' => $result_contexts, 
			'matchOnStem' => (bool)$this->config->get('matchOnStem')
		]));
		
		$result_count = 0;
		$redirect_to_only_result = null;
		
		$context_list = [];
		foreach($result_contexts as $target => $o_context) {
			$o_context->setParameter('search', $search);
			$context_list[$o_context->tableName()][$o_context->findType()] = $search;
			if (!isset($results[$target]['ids']) || !is_array($results[$target]['ids'])) { continue; }
			$o_context->setResultList(is_array($results[$target]['ids']) ? $results[$target]['ids'] : array());
			if($results[$target]['sort']) { $o_context->setCurrentSort($results[$target]['sort']); }
			if (isset($results[$target]['sortDirection'])) { $o_context->setCurrentSortDirection($results[$target]['sortDirection']); }
			$o_context->saveContext();
			
			$result_count += sizeof($results[$target]['ids']);
			if ((sizeof($results[$target]['ids']) == 1) && ($result_count == 1) && (!$dont_redirect_to_single_search_result)) {
				$redirect_to_only_result = caDetailUrl($this->request, $results[$target]['table'], $results[$target]['ids'][0], false);
			}
		}
		
		foreach($context_list as $table => $l) {
			foreach($l as $type => $s) {
				$o_context = new ResultContext($this->request, $table, $type);
				$o_context->setParameter('search', $s);
				$o_context->saveContext();
			}
		}
		
		if (($result_count == 1) && $redirect_to_only_result) {
			$this->response->setRedirect($redirect_to_only_result);
			return;
		}		
		$this->render('Search/general_results_html.php');
	}
	# -------------------------------------------------------
	/** 
	 * Generate the URL for the "back to results" link from a browse result item
	 * as an array of path components.
	 */
	public static function getReturnToResultsUrl($request) {
		$browse = $request->getAction();
		$browse_types = caGetBrowseConfig()->get('browseTypes');
		if(is_array($browse_types[$browse])) {
			$table = $browse_types[$browse]['table'] ?? null;
			$find = ResultContext::getLastFind($request, $table);
			$tmp = explode('/', $find);
			if((sizeof($tmp) > 1) && ($tmp[0] === 'search_advanced')) {
				return array(
					'module_path' => '',
					'controller' => 'Search/advanced',
					'action' => $browse,
					'params' => array(
						'key'
					)
				);
				
			}elseif((sizeof($tmp) > 1) && ($tmp[0] === 'generalsearch')){
				return array(
					'module_path' => '',
					'controller' => 'Search',
					'action' => 'GeneralSearch',
					'params' => array(
						'search'
					)
				);
			}
		}
		$ret = array(
			'module_path' => '',
			'controller' => 'Search',
			'action' => $browse,
			'params' => array(
				'key'
			)
		);
		return $ret;
	}
	# -------------------------------------------------------
	/**
	 * Returns summary of current browse parameters suitable for display.
	 *
	 * @return string Summary of current browse criteria ready for display
	 */
	public function getCriteriaForDisplay($browse=null) {
		$criteria = $browse->getCriteriaWithLabels();
		if (!sizeof($criteria)) { return ''; }
		$criteria_info = $browse->getInfoForFacets();
		
		$buf = array();
		foreach($criteria as $facet => $vals) {
			foreach($vals as $i => $val) {
				$vals[$i] = preg_replace("![A-Za-z_\./]+[:]{1}!", "", $val);
				$vals[$i] = trim(preg_replace("![\*].!", "", $vals[$i]));
				$vals[$i] = trim(preg_replace("![\(\)]+!", " ", $vals[$i]));
			}
			$buf[] = caUcFirstUTF8Safe($criteria_info[$facet]['label_singular']).': '.join(", ", $vals);
		}
		
		return join(" / ", $buf);
	}
	# -------------------------------------------------------
}
