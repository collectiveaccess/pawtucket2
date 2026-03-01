<?php
/* ----------------------------------------------------------------------
 * app/controllers/BrowseController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2026 Whirl-i-Gig
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
	protected $opa_access_values = [];
	
	/**
	 *
	 */
	protected $ops_view_prefix = 'Browse';
	
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$po_request, &$po_response, $view_paths=null) {
		parent::__construct($po_request, $po_response, $view_paths);
		if (!$this->request->isAjax() && $this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
			$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
		}
	   
		$this->opo_config = caGetBrowseConfig();
		
		$this->view->setVar("find_type", $this->ops_find_type);
		caSetPageCSSClasses(array("browse", "results"));
	}
	# -------------------------------------------------------
	/**
	 *
	 */ 
	public function __call($function, $args) {
		$this->view->setVar("config", $this->opo_config);
		$function = strtolower($function);
		$type = $this->request->getActionExtra();
		
		$o_search_config = caGetSearchConfig();
		
		if (!($browse_info = caGetInfoForBrowseType($function))) {
			// invalid browse type – throw error
			throw new ApplicationException("Invalid browse type");
		}
		$this->opa_access_values = caGetOption('checkAccess', $browse_info, $this->opa_access_values);
		
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Browse %1", $browse_info["displayName"]));
		$this->view->setVar("browse_type", $function);
		$class = $this->ops_tablename = $browse_info['table'];
		$t_instance = Datamodel::getInstance($class, true);
		
		// Now that table name is known we can set standard view vars
		parent::setTableSpecificViewVars($browse_info);
		
		$types = caGetOption('restrictToTypes', $browse_info, [], array('castTo' => 'array'));
		$omit_child_records = caGetOption('omitChildRecords', $browse_info, [], array('castTo' => 'bool'));
		
		
		$is_nav = (bool)$this->request->getParameter('isNav', pString, ['forcePurify' => true]);
		
		$type_key = caMakeCacheKeyFromOptions($types);
		if(ExternalCache::contains("{$class}totalRecordsAvailable{$type_key}")) {
			$this->view->setVar('totalRecordsAvailable', ExternalCache::fetch("{$class}totalRecordsAvailable{$type_key}"));
		} else {
			$params = ['deleted' => 0];
			if ($omit_child_records && ($f = $t_instance->getProperty('HIERARCHY_PARENT_ID_FLD'))) { $params[$f] = null; }
			ExternalCache::save("{$class}totalRecordsAvailable{$type_key}", $count = $class::find($params, ['checkAccess' => $this->opa_access_values, 'returnAs' => 'count', 'restrictToTypes' => (sizeof($types)) ? $types : null]));
			$this->view->setVar('totalRecordsAvailable', $count);
		}
		
		# --- row id passed when click back button on detail page - used to load results to and jump to last viewed item
		$this->view->setVar('row_id', $row_id = $this->request->getParameter('row_id', pInteger));
		
		$this->opo_result_context = new ResultContext($this->request, $browse_info['table'], $this->ops_find_type);
		
		// Don't set last find when loading facet (or when the 'dontSetFind' request param is explicitly set)
		// as some other controllers use this action and setting last find will disrupt ResultContext navigation 
		// by setting it to "browse" when in fact a search (or some other context) is still in effect.
		if (!$this->request->getParameter('getFacet', pInteger) && !$this->request->getParameter('dontSetFind', pInteger)) {
			$this->opo_result_context->setAsLastFind();
		}
		
		$this->view->setVar('browseInfo', $browse_info);
		$this->view->setVar('paging', in_array(strtolower($browse_info['paging']), array('continous', 'nextprevious', 'letter')) ? strtolower($browse_info['paging']) : 'continous');
		
		$this->view->setVar('name', $browse_info['displayName']);
		$this->view->setVar('options', caGetOption('options', $browse_info, [], array('castTo' => 'array')));
		
		$views = caGetOption('views', $browse_info, [], array('castTo' => 'array'));
		if(!is_array($views) || (sizeof($views) == 0)){
			$views = ['list' => [], 'images' => [], 'chronology' => [], 'chronology_images' => [], 'timeline' => [], 'map' => [], 'timelineData' => [], 'pdf' => [], 'xlsx' => [], 'pptx' => []];
		} else {
			$views['pdf'] = $views['timelineData'] = $views['xlsx'] = $views['pptx'] = $views['chronology_images'] = [];
		}
		
		if (!($view = $this->request->getParameter("view", pString, ['forcePurify' => true]))) {
			$view = $this->opo_result_context->getCurrentView();
		}
		if(!in_array($view, array_keys($views))) {
			$view = array_shift(array_keys($views));
		}
		# --- only set the current view if it's not an export format
		if(!$this->request->isAjax() && !in_array($view, ["pdf", "xlsx", "pptx", "timelineData", "chronology_images"])){
			$this->opo_result_context->setCurrentView($view);
			
			$search_result_context = new ResultContext($this->request, $browse_info['table'], 'search', $function);
			$search_adv_result_context = new ResultContext($this->request, $browse_info['table'], 'search_advanced', $function);
			$search_result_context->setCurrentView($view);
			$search_result_context->saveContext();
			$search_adv_result_context->setCurrentView($view);
			$search_adv_result_context->saveContext();
		}
		
		$view_info = $views[$view];
		
		$format = ($view == 'timelineData') ? 'json' : 'html';

		caAddPageCSSClasses(array($class, $function));

		$type_id = $t_instance->getTypeIDForCode($type);
		
		$this->view->setVar('t_instance', $t_instance);
		$this->view->setVar('table', $browse_info['table']);
		$this->view->setVar('primaryKey', $t_instance->primaryKey());
	
		$this->view->setVar('browse', $o_browse = caGetBrowseInstance($class));
		$this->view->setVar('views', caGetOption('views', $browse_info, [], array('castTo' => 'array')));
		$this->view->setVar('view', $view);
		$this->view->setVar('viewIcons', $this->opo_config->getAssoc("views"));
	
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
		$base_criteria = caGetOption('baseCriteria', $browse_info, null);
		$show_base_criteria = caGetOption('showBaseCriteria', $browse_info, false);
		
		if(!$remove_criterion) {
			$o_browse->setBaseCriteria($browse_info, [
				'view' => $view
			]);
		}
		if (($facets = $this->request->getParameter('facets', pString, ['forcePurify' => true])) && is_array($facets = explode(';', $facets)) && sizeof($facets)) {
			foreach ($facets as $facet_spec) {
				if (!sizeof($tmp = explode(':', $facet_spec))) { continue; }
				$facet = array_shift($tmp);
				$o_browse->addCriteria($facet, preg_split("![\|,]+!", join(":", array_map(function($v) { 
					return urldecode($v);
				}, $tmp)))); 
			}
		} elseif ($search_refine = $this->request->getParameter('search_refine', pString, ['forcePurify' => true])) {
			if($search_refine_prefix = $this->request->getParameter('search_refine_prefix', pString, ['forcePurify' => true])) {
				$search_refine = $search_refine_prefix.':"'.addslashes($search_refine).'"';
			}
			$o_browse->removeAllCriteria('_search');
			$o_browse->addCriteria('_search', [caMatchOnStem($search_refine)], array($search_refine));
		} elseif (($facet = $this->request->getParameter('facet', pString, ['forcePurify' => true])) && is_array($p = array_filter(explode('|', trim($this->request->getParameter('id', pString, ['forcePurify' => true]))), function($v) { return strlen($v); })) && sizeof($p)) {
			$p = array_map('urldecode', $p);
			$o_browse->addCriteria($facet, $p);
		} else { 
			if (($o_browse->numCriteria() == 0)) {
				$o_browse->addCriteria("_search", array("*"));
			}
		}
		$o_browse->setSelectiveBaseCriteria($browse_info, [
			'view' => $view
		]);
		
		//
		// Sorting
		//
		$sort_changed = false;
		if (!($sort = urldecode($this->request->getParameter("sort", pString, ['forcePurify' => true])))) {
			$sort = $this->opo_result_context->getCurrentSort();
		}elseif($sort != $this->opo_result_context->getCurrentSort()){ 
			$sort_changed = true; 
		}
		if(is_array($sorts = caGetOption('sortBy', $browse_info, null))) {
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
		
		$sort_by = caGetOption('sortBy', $browse_info, null);
		$this->view->setVar('sortBy', is_array($sort_by) ? $sort_by : null);
		$this->view->setVar('sortBySelect', $sort_by_select = (is_array($sort_by) ? caHTMLSelect("sort", $sort_by, array('id' => "sort"), array("value" => $sort)) : ''));
		$this->view->setVar('sortControl', $sort_by_select ? _t('Sort with %1', $sort_by_select) : '');
		$this->view->setVar('sort', $sort);
		$this->view->setVar('sort_direction', $sort_direction);

		if (caGetOption('dontShowChildren', $browse_info, false)) {
			$o_browse->addResultFilter('ca_objects.parent_id', 'is', 'null');	
		}
		
		//
		// Current criteria
		//
		$criteria = $o_browse->getCriteriaWithLabels();
		if (isset($criteria['_search']) && (isset($criteria['_search']['*']))) {
			unset($criteria['_search']);
		} 
		
		$x = [];
		foreach($criteria as $facet => $values) {
			$x[] = $facet.":".join("|", array_keys($values));
		}
		
		$this->view->setVar('share_url', caNavUrl($this->request, '*', '*', '*', ['facets' => join(";", $x)], ['absolute' => true]));

		$expand_results_hierarchically = caGetOption('expandResultsHierarchically', $browse_info, [], array('castTo' => 'bool'));
		
		$o_browse->execute(array('checkAccess' => $this->opa_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => true, 'expandResultsHierarchically' => $expand_results_hierarchically, 'omitChildRecords' => $omit_child_records, 'omitChildRecordsForTypes' => caGetOption('omitChildRecordsForTypes', $browse_info, null)));
		
		//
		// Set highlight text
		//
		MetaTagManager::setHighlightText($o_browse->getSearchedTerms() ?? $criteria['_search'] ?? '', ['persist' => !RequestHTTP::isAjax()]);
		
		//
		// Facets
		//
		if ($facet_group = caGetOption('facetGroup', $browse_info, null)) {
			$o_browse->setFacetGroup($facet_group);
		}
		
		$available_facet_list = caGetOption('availableFacets', $browse_info, null);
		$facets = $o_browse->getInfoForAvailableFacets(['checkAccess' => $this->opa_access_values, 'request' => $this->request]);
		foreach($facets as $facet_name => $facet_info) {
			if(!$show_base_criteria && isset($base_criteria[$facet_name])) { continue; } // skip base criteria 
			
			// Enforce role-restricted facets here
			if (isset($facet_info['require_roles']) && is_array($facet_info['require_roles']) && sizeof($facet_info['require_roles'])) {
				if (!$this->request->isLoggedIn() || !sizeof(array_filter($facet_info['require_roles'], function($v) { return $this->request->user->hasUserRole($v); }))) { continue; }
			}
			$facets[$facet_name]['content'] = $o_browse->getFacet($facet_name, array('checkAccess' => $this->opa_access_values, 'request' => $this->request, 'checkAvailabilityOnly' => caGetOption('deferred_load', $facet_info, false, array('castTo' => 'bool'))));
		}
		$this->view->setVar('facets', $facets);
	
		$this->view->setVar('key', $key = $o_browse->getBrowseID());
		if(!$this->request->isAjax()) { Session::setVar($function.'_last_browse_id', $key); }
		
		
		// remove base criteria from display list
		if (!$show_base_criteria && is_array($base_criteria)) {
			foreach($base_criteria as $base_facet => $criteria_value) {
				unset($criteria[$base_facet]);
			}
		}
		
		$criteria_for_display = [];
		foreach($criteria as $facet_name => $criterion) {
			$facet_info = $o_browse->getInfoForFacet($facet_name);
			foreach($criterion as $criterion_id => $criterion) {
				$criteria_for_display[] = ['facet' => $facet_info['label_singular'], 'facet_name' => $facet_name, 'value' => $criterion, 'id' => $criterion_id, 'hide' => $facet_info['hide'] ?? false];
			}
		}
		$this->view->setVar('criteria', $criteria_for_display);
		
		// 
		// Results
		//
		
		$sort_fld = $sort_by[$sort];
		if ($view == 'timelineData') {
			$sort_fld = $browse_info['views']['timeline']['data'];
			$sort_direction = 'asc';
		}
		$qr_res = $o_browse->getResults(array('sort' => $sort_fld, 'sort_direction' => $sort_direction));
		
		$show_letter_bar_sorts = caGetOption('showLetterBarSorts', $browse_info, null);
		if(is_array($show_letter_bar_sorts) && in_array($sort_fld, $show_letter_bar_sorts)){
			if ($letter_bar_field = caGetOption('showLetterBarFrom', $browse_info, null)) { // generate letter bar
				$letters = [];
				while($qr_res->nextHit()) {
					$letters[caRemoveAccents(mb_strtolower(mb_substr(trim(trim($qr_res->get($letter_bar_field), "0")), 0, 1)))]++;
				}
				ksort($letters, SORT_STRING);
				$this->view->setVar('letterBar', $letters);
				$qr_res->seek(0);
			}
		}
		$this->view->setVar('showLetterBar', (bool)$letter_bar_field);
		if($this->request->getParameter('l', pString, ['forcePurify' => true])){
			$l = trim(mb_strtolower($this->request->getParameter('l', pString, ['forcePurify' => true])));
			if($l == "all"){
				$l = "";
			}
		}else{
			$l = $this->opo_result_context->getLetterBarPage();
		}
		$this->opo_result_context->setLetterBarPage($l);
		
		$this->view->setVar('letter', $l);			
		
		if ($letter_bar_field && ($l)) {
			$filtered_ids = [];
			while($qr_res->nextHit()) {
				if (caRemoveAccents(mb_strtolower(mb_substr(trim(trim($qr_res->get($letter_bar_field), "0")), 0, 1))) == $l) {
					$filtered_ids[] = $qr_res->getPrimaryKey();
				}
			}
			if (sizeof($filtered_ids) > 0) {
				$qr_res = caMakeSearchResult($class, $filtered_ids);
			}
		}
		
		$qr_res->doHighlighting($o_search_config->get("do_highlighting"));
		$this->view->setVar('result', $qr_res);
			
		if (!($hits_per_block = $this->request->getParameter("n", pString, ['forcePurify' => true]))) {
			if (!($hits_per_block = $this->opo_result_context->getItemsPerPage())) {
				$hits_per_block = $this->opo_config->get("defaultHitsPerBlock");
			}
		}
		$this->opo_result_context->setItemsPerPage($hits_per_block);
		
		$this->view->setVar('hits_per_block', $hits_per_block);

		$this->view->setVar('start', $start = (int)$this->request->getParameter('s', pInteger));
		
		$this->opo_result_context->setParameter('key', $key);
		
		if (!$this->request->isAjax()) {
			if (($max_result_count = $this->request->config->get('maximum_find_result_list_values')) < 10) {
				$max_result_count = 1000;
			}
			if (($key_start = $start - $max_result_count) < 0) { $key_start = 0; }
			$qr_res->seek($key_start);
			$this->opo_result_context->setResultList($qr_res->getPrimaryKeyValues($max_result_count));
			$qr_res->seek($start);
		}
			
		$this->opo_result_context->saveContext();
		
		if ($type) {
			if ($this->render($this->ops_view_prefix."/{$class}_{$type}_{$view}_{$format}.php")) { return; }
		} 

		//
		// Maps
		//
		if ($view === 'map') {
			$this->view->setVar("showMap", false);
			if (!is_array($map_attributes = caGetOption(['data', 'mapAttributes', 'map_attributes'], $view_info, [])) || !sizeof($map_attributes)) {
				if ($map_attribute = caGetOption('data', $view_info, false)) { $map_attributes = array($map_attribute); }
			}
			
			if(is_array($map_attributes) && sizeof($map_attributes)) {			
				$map_options = [
					'width' => caGetOption(['mapWidth', 'map_width'], $view_info, 300),
					'width' => caGetOption(['mapHeight', 'map_height'], $view_info, 300),
					'zoom' => caGetOption(['mapZoomLevel', 'zoom_level'], $view_info, null), 
					'minZoom' => caGetOption(['mapMinZoomLevel'], $view_info, 1), 
					'maxZoom' => caGetOption(['mapMaxZoomLevel'], $view_info, 15),
					'infoTemplate' => caGetOption(['mapItemInfoTemplate'], $view_info, ''),
					'ajaxContentUrl' => caNavUrl($this->request, '*', '*', 'mapContent', ['browse' => $function]),
					'searchUrl' => caNavUrl($this->request, '*', 'Search', '*', ['search_refine_prefix' => 'Address']),
					'themePath' => __CA_THEME_URL__
				];
				$this->view->setVar('mapOptions', $map_options);
				
				$map_data = [];
				foreach($map_attributes as $map_attribute) {
					$adata = caGetCoordinateDataFromResult($qr_res, $map_attribute, $map_options);
					$map_data = array_merge($map_data ?? [], $adata['coordinates'] ?? []);
				}
				if (sizeof($map_data ?? []) > 0) {
					$this->view->setVar("showMap", true);
					$this->view->setVar('mapData', $map_data);
					$map_options['data'] = $map_data;
					$this->view->setVar('mapOptions', $map_options);
				}
			}
		}
		
		switch($view) {
			case 'xlsx':
			case 'pptx':
			case 'pdf':
				$this->_genExport($qr_res, $this->request->getParameter("export_format", pString, ['forcePurify' => true]), caGenerateDownloadFileName(caGetOption('pdfExportTitle', $browse_info, $search_expression ?? 'browse')), $this->getCriteriaForDisplay($o_browse));
				break;
			case 'timelineData':
				$this->view->setVar('view', 'timeline');
				$this->render($this->ops_view_prefix."/browse_results_timelineData_json.php");
				break;
			default:
				$this->render($this->ops_view_prefix."/browse_results_html.php");
				break;
		}
	}
	# -------------------------------------------------------
	/** 
	 * Generate the URL for the "back to results" link from a browse result item
	 * as an array of path components.
	 */
	public static function getReturnToResultsUrl($request, $table) {
		$browse = $request->getAction();
		$browse_types = caGetBrowseConfig()->get('browseTypes');
		
		if(!is_array($browse_types[$browse])) {
			foreach($browse_types as $bt => $bti) {
				if($bti['table'] === $table) {
					$browse = $bt;
					break;
				}
			}
		}
		$ret = [
			'module_path' => '',
			'controller' => 'Browse',
			'action' => $browse,
			'params' => array(
				'key'
			)
		];
		return $ret;
	}
	# -------------------------------------------------------
	/** 
	 * Return content for map bubble
	 */
	public function mapContent() {
		$ids = explode(';', $this->request->getParameter('ids', pString, ['forcePurify' => true]));
		$browse = $this->request->getParameter('browse', pString, ['forcePurify' => true]);
		
		if(!is_array($browse_info = caGetInfoForBrowseType($browse))) {
			throw new ApplicationException(_t('Invalid browse'));
		}
		$t = $browse_info['views']['map']['mapItemInfoTemplate'] ?? "???";
		$acc = [];
		if(sizeof($ids)) {
			if($qr = caMakeSearchResult($browse_info['table'], $ids)) {
				while($qr->nextHit()) {
					$acc[] = $qr->getWithTemplate($t);
				}
			}
		}
		$this->view->setVar('items', $acc);
		$this->render("Browse/ajax_map_item_html.php");
	}
	# -------------------------------------------------------
	/** 
	 * return nav bar code for specified browse target
	 */
	public function getBrowseNavBarByTarget() {
		$target = $this->request->getParameter('target', pString, ['forcePurify' => true]);
		$this->view->setVar("target", $target);
		if (!($browse_info = caGetInfoForBrowseType($target))) {
			// invalid browse type – throw error
			throw new ApplicationException("Invalid browse type");
		}
		$this->view->setVar("browse_name", $browse_info["displayName"]);
		$this->render("pageFormat/browseMenuFacets.php");
	}
	# ------------------------------------------------------------------
	/**
	 * Returns summary of current browse parameters suitable for display.
	 *
	 * @return string Summary of current browse criteria ready for display
	 */
	public function getCriteriaForDisplay($po_browse=null) {
		$criteria = $po_browse->getCriteriaWithLabels();
		if (!sizeof($criteria)) { return ''; }
		$criteria_info = $po_browse->getInfoForFacets();
		
		$buf = [];
		foreach($criteria as $facet => $vals) {
			$buf[] = caUcFirstUTF8Safe($criteria_info[$facet]['label_singular']).': '.join(", ", $vals);
		}
		
		return join(" / ", $buf);
	}
	# -------------------------------------------------------
}
