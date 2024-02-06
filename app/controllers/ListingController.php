<?php
/* ----------------------------------------------------------------------
 * app/controllers/ListingController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2024 Whirl-i-Gig
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
	/**
	 *
	 */
	public function __construct($request, $response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
			$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
		}
		if (($this->request->config->get('deploy_bristol'))&&($this->request->isLoggedIn())) {
			print "You do not have access to view this page.";
			die;
		}
		
		caSetPageCSSClasses(['listing']);
	}
	# -------------------------------------------------------
	/**
	 *
	 */ 
	public function __call($function, $args) {
		$o_config = caGetListingConfig();
		
		$function = strtolower($function);
		$type = $this->request->getActionExtra();
		
		if (!($listing_info = caGetInfoForListingType($function))) {
			// invalid listing type – throw error
			throw new ApplicationException("Invalid listing type");
		}
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").$listing_info["displayName"]);
		
		$function = strtolower($function);
		
		$table = $listing_info['table'];
		$search = caGetOption('search', $listing_info, '*');
		$segment_by = caGetOption('segmentBy', $listing_info, '');
		
		$this->opo_result_context = new ResultContext($this->request, $table, $this->ops_find_type);
		$this->opo_result_context->setAsLastFind();
		
		if (!($t_instance = Datamodel::getInstance($table, true))) {
			throw new ApplicationException("Invalid table");
		}
		
		if(!($o_browse = caGetBrowseInstance($table))) {
			throw new ApplicationException("Invalid listing");
		}
		
		// Set browse facet group
		if ($facet_group = caGetOption('browseFacetGroup', $listing_info, null)) {
			$o_browse->setFacetGroup($facet_group);
		}
		
		$types = caGetOption('restrictToTypes', $listing_info, [], ['castTo' => 'array']);
		$type_list = $t_instance->getTypeList();
		
		if (!is_array($types) || !sizeof($types)) {
			$types = array_keys($type_list);
		} else {
			$types = caMakeTypeIDList($table, $types, array('dontIncludeSubtypesInTypeRestriction' => true));
		}
		$o_browse->setTypeRestrictions($types, array('dontExpandHierarchically' => true));
		
		$relationship_types = caGetOption('restrictToRelationshipTypes', $listing_info, [], ['castTo' => 'array']);
	
		$o_browse->addCriteria("_search", [$search]);
		
		foreach($relationship_types as $x => $rel_types) {
			if (!is_array($rel_types)) { continue; }
			$o_browse->addCriteria("_reltypes", "{$x}:".join(",", $rel_types));
		}
		$o_browse->execute(['checkAccess' => $this->opa_access_values]);
		
		//
		// Facets for search 
		//
		$facets = $o_browse->getInfoForAvailableFacets();
		foreach($facets as $facet_name => $facet_info) {
			$facets[$facet_name]['content'] = $o_browse->getFacetContent($facet_name, ['checkAccess' => $this->opa_access_values]);
		}
	
		$this->view->setVar('facets', $facets);
		
		
		//
		// Add criteria and execute
		//
		if ($facet = $this->request->getParameter('facet', pString)) {
			$o_browse->addCriteria($facet, [$facet_id = $this->request->getParameter('id', pString)]);
			
			$this->view->setVar('facet', $facet);
			$this->view->setVar('facet_id', $facet_id);
		}


		//
		// Sorting
		//
		$sort_changed = false;
		if (!($sort = $this->request->getParameter("sort", pString))) {
			if (!($sort = $this->opo_result_context->getCurrentSort())) {
				if(is_array(($sorts = caGetOption('sortBy', $listing_info, null)))) {
					$sort = array_shift(array_keys($sorts));
					$sort_changed = true;
				}
			}
		}else{
			$sort_changed = true;
		}
		$sort_direction = caGetOption('sortDirection', $listing_info, null);
		
		if (!($sort_direction = $this->request->getParameter("direction", pString))) {  			    
			# --- set the default sortDirection if available
			if(!($sort_direction = $sort_direction[$sort])){
				$sort_direction = 'asc';
			} 
			$this->opo_result_context->setCurrentSortDirection($sort_direction);
		}
		
		$this->opo_result_context->setCurrentSort($sort);
		$this->opo_result_context->setCurrentSortDirection($sort_direction);
		
		$sort_by = caGetOption('sortBy', $listing_info, null);
		$this->view->setVar('sortBy', is_array($sort_by) ? $sort_by : null);
		$this->view->setVar('sortBySelect', $sort_by_select = (is_array($sort_by) ? caHTMLSelect("sort", $sort_by, ['id' => "sort"], ["value" => $sort]) : ''));
		$this->view->setVar('sortControl', $sort_by_select ? _t('Sort with %1', $sort_by_select) : '');
		$this->view->setVar('sort', $sort);
		$this->view->setVar('sort_direction', $sort_direction);


		$lists = [];
		$res_list = [];
		
		$o_browse->execute(['checkAccess' => $this->opa_access_values]);
		
		$qr_res = $o_browse->getResults(['sort' => $sort_by[$sort], 'sort_direction' => $sort_direction]);
		while($qr_res->nextHit()) {
			$key = $qr_res->getWithTemplate($segment_by);
			$lists[$key][] = $res_list[] = $qr_res->getPrimaryKey();
		}
		
		foreach($lists as $key => $ids) {
			$lists[$key] = caMakeSearchResult($table, $ids);
		}
		
		$this->view->setVar('table', $table);
		$this->view->setVar('lists', $lists);
		$this->view->setVar('typeInfo', $type_list);
		$this->view->setVar('listingInfo', $listing_info);
		
		//
		// Current criteria
		//
		$criteria = $o_browse->getCriteriaWithLabels();
		unset($criteria['_search']);
	
		$criteria_for_checking = [];
		foreach($criteria as $facet_name => $criterion) {
			$facet_info = $o_browse->getInfoForFacet($facet_name);
			foreach($criterion as $criterion_id => $criterion) {
				$criteria_for_checking[$facet_name] = $criterion_id;
			}
		}
		
		$this->view->setVar('hasCriteria', sizeof($criteria_for_checking) > 0);
		$this->view->setVar('criteria', $criteria_for_checking);
		
		
		$this->opo_result_context->setResultList($res_list);
		$this->opo_result_context->saveContext();
		
		$this->render("Listing/listing_html.php");
	}
	# -------------------------------------------------------
	/** 
	 * Generate the URL for the "back to results" link from a browse result item
	 * as an array of path components.
	 */
	public static function getReturnToResultsUrl($request) {
		$ret = [
			'module_path' => '',
			'controller' => 'Listing',
			'action' => $request->getAction(),
			'params' => []
		];
		return $ret;
	}
	# -------------------------------------------------------
}
