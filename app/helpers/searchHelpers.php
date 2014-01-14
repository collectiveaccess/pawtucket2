<?php
/** ---------------------------------------------------------------------
 * app/helpers/searchHelpers.php : miscellaneous functions
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011-2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage utils
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 * 
 * ----------------------------------------------------------------------
 */

 /**
   *
   */
   
require_once(__CA_MODELS_DIR__.'/ca_lists.php');


	# ---------------------------------------
	/**
	 * 
	 *
	 * @return string 
	 */
	function caGetSearchInstance($pm_table_name_or_num, $pa_options=null) {
		$o_dm = Datamodel::load();
		
		$vs_table = (is_numeric($pm_table_name_or_num)) ? $o_dm->getTableName((int)$pm_table_name_or_num) : $pm_table_name_or_num;
		
		switch($vs_table) {
			case 'ca_objects':
				require_once(__CA_LIB_DIR__.'/ca/Search/ObjectSearch.php');
				return new ObjectSearch();
				break;
			case 'ca_entities':
				require_once(__CA_LIB_DIR__.'/ca/Search/EntitySearch.php');
				return new EntitySearch();
				break;
			case 'ca_places':
				require_once(__CA_LIB_DIR__.'/ca/Search/PlaceSearch.php');
				return new PlaceSearch();
				break;
			case 'ca_occurrences':
				require_once(__CA_LIB_DIR__.'/ca/Search/OccurrenceSearch.php');
				return new OccurrenceSearch();
				break;
			case 'ca_collections':
				require_once(__CA_LIB_DIR__.'/ca/Search/CollectionSearch.php');
				return new CollectionSearch();
				break;
			case 'ca_loans':
				require_once(__CA_LIB_DIR__.'/ca/Search/LoanSearch.php');
				return new LoanSearch();
				break;
			case 'ca_movements':
				require_once(__CA_LIB_DIR__.'/ca/Search/MovementSearch.php');
				return new MovementSearch();
				break;
			case 'ca_lists':
				require_once(__CA_LIB_DIR__.'/ca/Search/ListSearch.php');
				return new ListSearch();
				break;
			case 'ca_list_items':
				require_once(__CA_LIB_DIR__.'/ca/Search/ListItemSearch.php');
				return new ListItemSearch();
				break;
			case 'ca_object_lots':
				require_once(__CA_LIB_DIR__.'/ca/Search/ObjectLotSearch.php');
				return new ObjectLotSearch();
				break;
			case 'ca_object_representations':
				require_once(__CA_LIB_DIR__.'/ca/Search/ObjectRepresentationSearch.php');
				return new ObjectRepresentationSearch();
				break;
			case 'ca_representation_annotations':
				require_once(__CA_LIB_DIR__.'/ca/Search/RepresentationAnnotationSearch.php');
				return new RepresentationAnnotationSearch();
				break;
			case 'ca_item_comments':
				require_once(__CA_LIB_DIR__.'/ca/Search/ItemCommentSearch.php');
				return new ItemCommentSearch();
				break;
			case 'ca_item_tags':
				require_once(__CA_LIB_DIR__.'/ca/Search/ItemTagSearch.php');
				return new ItemTagSearch();
				break;
			case 'ca_relationship_types':
				require_once(__CA_LIB_DIR__.'/ca/Search/RelationshipTypeSearch.php');
				return new RelationshipTypeSearch();
				break;
			case 'ca_sets':
				require_once(__CA_LIB_DIR__.'/ca/Search/SetSearch.php');
				return new SetSearch();
				break;
			case 'ca_tours':
				require_once(__CA_LIB_DIR__.'/ca/Search/TourSearch.php');
				return new TourSearch();
				break;
			case 'ca_tour_stops':
				require_once(__CA_LIB_DIR__.'/ca/Search/TourStopSearch.php');
				return new TourStopSearch();
				break;
			case 'ca_storage_locations':
				require_once(__CA_LIB_DIR__.'/ca/Search/StorageLocationSearch.php');
				return new StorageLocationSearch();
				break;
			case 'ca_users':
				require_once(__CA_LIB_DIR__.'/ca/Search/UserSearch.php');
				return new UserSearch();
				break;
			case 'ca_user_groups':
				require_once(__CA_LIB_DIR__.'/ca/Search/UserGroupSearch.php');
				return new UserGroupSearch();
				break;
			default:
				return null;
				break;
		}
	}
	# ---------------------------------------
	/**
	 * 
	 *
	 * @return string 
	 */
	function caSearchUrl($po_request, $ps_table, $ps_search=null, $pb_return_url_as_pieces=false, $pa_additional_parameters=null, $pa_options=null) {
		$o_dm = Datamodel::load();
		
		if (is_numeric($ps_table)) {
			if (!($t_table = $o_dm->getInstanceByTableNum($ps_table, true))) { return null; }
		} else {
			if (!($t_table = $o_dm->getInstanceByTableName($ps_table, true))) { return null; }
		}
		
		$vb_return_advanced = isset($pa_options['returnAdvanced']) && $pa_options['returnAdvanced'];
		
		switch($ps_table) {
			case 'ca_objects':
			case 57:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchObjectsAdvanced' : 'SearchObjects';
				$vs_action = 'Index';
				break;
			case 'ca_object_lots':
			case 51:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchObjectLotsAdvanced' : 'SearchObjectLots';
				$vs_action = 'Index';
				break;
			case 'ca_object_events':
			case 45:
                $vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchObjectEventsAdvanced' : 'SearchObjectEvents';
				$vs_action = 'Index';
                break;
			case 'ca_entities':
			case 20:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchEntitiesAdvanced' : 'SearchEntities';
				$vs_action = 'Index';
				break;
			case 'ca_places':
			case 72:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchPlacesAdvanced' : 'SearchPlaces';
				$vs_action = 'Index';
				break;
			case 'ca_occurrences':
			case 67:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchOccurrencesAdvanced' : 'SearchOccurrences';
				$vs_action = 'Index';
				break;
			case 'ca_collections':
			case 13:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchCollectionsAdvanced' : 'SearchCollections';
				$vs_action = 'Index';
				break;
			case 'ca_storage_locations':
			case 89:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchStorageLocationsAdvanced' : 'SearchStorageLocations';
				$vs_action = 'Index';
				break;
			case 'ca_list_items':
			case 33:
				$vs_module = 'administrate/setup';
				$vs_controller = ($vb_return_advanced) ? '' : 'Lists';
				$vs_action = 'Index';
				break;
			case 'ca_object_representations':
			case 56:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchObjectRepresentationsAdvanced' : 'SearchObjectRepresentations';
				$vs_action = 'Index';
				break;
			case 'ca_representation_annotations':
			case 82:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchRepresentationAnnotationsAdvanced' : 'SearchRepresentationAnnotations';
				$vs_action = 'Index';
				break;
			case 'ca_relationship_types':
			case 79:
				$vs_module = 'administrate/setup';
				$vs_controller = ($vb_return_advanced) ? '' : 'RelationshipTypes';
				$vs_action = 'Index';
				break;
			case 'ca_loans':
			case 133:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchLoansAdvanced' : 'SearchLoans';
				$vs_action = 'Index';
				break;
			case 'ca_movements':
			case 137:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchMovementsAdvanced' : 'SearchMovements';
				$vs_action = 'Index';
				break;
			case 'ca_tours':
			case 153:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchToursAdvanced' : 'SearchTours';
				$vs_action = 'Index';
				break;
			case 'ca_tour_stops':
			case 155:
				$vs_module = 'find';
				$vs_controller = ($vb_return_advanced) ? 'SearchTourStopsAdvanced' : 'SearchTourStops';
				$vs_action = 'Index';
				break;
			default:
				return null;
				break;
		}
		if ($pb_return_url_as_pieces) {
			return array(
				'module' => $vs_module,
				'controller' => $vs_controller,
				'action' => $vs_action
			);
		} else {
			if (!is_array($pa_additional_parameters)) { $pa_additional_parameters = array(); }
			$pa_additional_parameters = array_merge(array('search' => $ps_search), $pa_additional_parameters);
			return caNavUrl($po_request, $vs_module, $vs_controller, $vs_action, $pa_additional_parameters);
		}
	}
	# ---------------------------------------
	/**
	 * 
	 *
	 * @return array 
	 */
	function caSearchGetAccessPoints($ps_search_expression) {
		if(preg_match("!\b([A-Za-z0-9\-\_]+):!", $ps_search_expression, $va_matches)) {
			array_shift($va_matches);
			return $va_matches;
		}
		return array();
	}
	# ---------------------------------------
	/**
	 * 
	 *
	 * @return array 
	 */
	function caSearchGetTablesForAccessPoints($pa_access_points) {
		$o_config = Configuration::load();
		$o_search_config = Configuration::load($o_config->get("search_config"));
		$o_search_indexing_config = Configuration::load($o_search_config->get("search_indexing_config"));	
			
		$va_tables = $o_search_indexing_config->getAssocKeys();
		
		$va_aps = array();
		foreach($va_tables as $vs_table) {
			$va_config = $o_search_indexing_config->getAssoc($vs_table);
			if(is_array($va_config) && is_array($va_config['_access_points'])) {
				if (array_intersect($pa_access_points, array_keys($va_config['_access_points']))) {
					$va_aps[$vs_table] = true;	
				}
			}
		}
		
		return array_keys($va_aps);
	}
	# ---------------------------------------
	/**
	 * Performs search using expression for each provided search "block." A block defines a
	 * search on a specific item (Eg. ca_objects, ca_entities), with or without type restriction, with
	 * results rendered using a provided view. The results for all blocks are returned in an array.
	 * 
	 * Used by MultiSearch to generate results. Blame Sophie for the function name.
	 *
	 * @param RequestHTTP $po_request
	 * @param string $ps_search_expression
	 * @param array $pa_blocks
	 * @param array $pa_options
	 *			itemsPerPage =
	 *			itemsPerColumn =
	 *			contexts =
	 *			... any other options passed through as-is to SearchEngine::search()
	 *
	 * @return array 
	 */
	function caPuppySearch($po_request, $ps_search_expression, $pa_blocks, $pa_options=null) {
		if (!is_array($pa_options)) { $pa_options = array(); }
		
		$vn_items_per_page_default = caGetOption('itemsPerPage', $pa_options, 10);
		$vn_items_per_column_default = caGetOption('itemsPerColumn', $pa_options, 1);
		
		$va_contexts = caGetOption('contexts', $pa_options, array(), array('castTo' => 'array'));
		unset($pa_options['contexts']);
		
		//
		// Block are lazy-loaded using Ajax requests with additional items as they are scrolled.
		// "Ajax mode" is used by caPuppySearch to render a single block when it is scrolled
		// The block to be rendered is specified in the "block" request parameter. The offset
		// from the beginning of the result to start rendering from is specified in the "s" request parameter.
		//
		$vb_ajax_mode = false;
		if ($po_request->isAjax() && ($ps_block = $po_request->getParameter('block', pString)) && isset($pa_blocks[$ps_block])) {
			$pa_blocks = array($ps_block => $pa_blocks[$ps_block]);
			$vb_ajax_mode = true;
		}
		
		$va_ret = array();
		$vn_i = 0;
		$vn_total_cnt = 0;
		foreach($pa_blocks as $vs_block => $va_block_info) {
			if (!($o_search = caGetSearchInstance($va_block_info['table']))) { continue; }
			
			if (!is_array($va_block_info['options'])) { $va_block_info['options'] = array(); }
			$va_options = array_merge($pa_options, $va_block_info['options']);
			
			
 			if (!($ps_sort = $po_request->getParameter("{$vs_block}Sort", pString))) {
 				if (isset($va_contexts[$vs_block])) {
 					$ps_sort = $va_contexts[$vs_block]->getCurrentSort();
 				}
 			}
 			
 			
 			$va_options['sort'] = $ps_sort;
		
			$qr_res = $o_search->search($ps_search_expression, $va_options);
			
			
			// In Ajax mode we scroll to an offset
			$vn_start = 0;
			if ($vb_ajax_mode) {
				if (($vn_start = $po_request->getParameter('s', pInteger)) < $qr_res->numHits()) {
					$qr_res->seek($vn_start);
					if (isset($va_contexts[$vs_block])) {
						$va_contexts[$vs_block]->setParameter('start', $vn_start);
						$va_contexts[$vs_block]->saveContext();
					}
				} else {
					// If the offset is past the end of the result return an empty string to halt the continuous scrolling
					return '';
				}
			} else {				
				//
				// Reset start if it's a new search
				//
				if ($va_contexts[$vs_block]->getSearchExpression(true) != $ps_search_expression) {
					$va_contexts[$vs_block]->setParameter('start', 0);
					$va_contexts[$vs_block]->saveContext();
				}
			}
			
			
			$vn_items_per_page = caGetOption('itemsPerPage', $va_block_info, $vn_items_per_page_default);
			$vn_items_per_column = caGetOption('itemsPerColumn', $va_block_info, $vn_items_per_column_default);
			
			$vn_count = $qr_res->numHits();
			$va_sort_by = ($vn_count > 1) ? caGetOption('sortBy', $va_block_info, null) : null;
			
			$o_view = new View($po_request, $po_request->getViewsDirectoryPath());
			$o_view->setVar('result', $qr_res);
			$o_view->setVar('count', $vn_count);
			$o_view->setVar('block', $vs_block);
			$o_view->setVar('blockInfo', $va_block_info);
			$o_view->setVar('blockIndex', $vn_i);
			$o_view->setVar('start', $vn_start);
			$o_view->setVar('itemsPerPage', $vn_items_per_page);
			$o_view->setVar('itemsPerColumn', $vn_items_per_column);
			$o_view->setVar('hasMore', (bool)($vn_count > $vn_start + $vn_items_per_page));
			$o_view->setVar('sortBy', is_array($va_sort_by) ? $va_sort_by : null);
			$o_view->setVar('sortBySelect', $vs_sort_by_select = (is_array($va_sort_by) ? caHTMLSelect("{$vs_block}_sort", $va_sort_by, array('id' => "{$vs_block}_sort"), array("value" => $ps_sort)) : ''));
			$o_view->setVar('sortByControl', $vs_sort_by_select ? _t('Sort with %1', $vs_sort_by_select) : '');
			$o_view->setVar('sort', $ps_sort);
			$o_view->setVar('search', $ps_search_expression);
			$o_view->setVar('cacheKey', md5($ps_search_expression));
			
			if (!$vb_ajax_mode) {
				if (isset($va_contexts[$vs_block])) {
					$o_view->setVar('initializeWithStart', (int)$va_contexts[$vs_block]->getParameter('start'));
				} else {
					$o_view->setVar('initializeWithStart', 0);
				}
			}
			
			$vs_html = $o_view->render($va_block_info['view']);
			
			$va_ret[$vs_block] = array(
				'count' => $vn_count,
				'html' => $vs_html,
				'displayName' => $va_block_info['displayName'],
				'ids' => $qr_res->getPrimaryKeyValues(),
				'sort' => $ps_sort
			);
			$vn_total_cnt += $vn_count;
			$vn_i++;
			
			if ($vb_ajax_mode) {
				// In Ajax mode return rendered HTML for the single block
				return $va_ret;
			}
		}
		$va_ret['_info_'] = array(
			'totalCount' => $vn_total_cnt
		);
		
		return $va_ret;
	}
	# ---------------------------------------
	/**
	 * 
	 *
	 * @return array 
	 */
	function caSplitSearchResultByType($pr_res, $pa_options=null) {
		$o_dm = Datamodel::load();
		if (!($t_instance = $o_dm->getInstanceByTableName($pr_res->tableName(), true))) { return null; }
		
		if (!($vs_type_fld = $t_instance->getTypeFieldName())) { return null; }
		$vs_table = $t_instance->tableName();
		$va_types = $t_instance->getTypeList();
		
		$pr_res->seek(0);
		$va_type_ids = array();
		while($pr_res->nextHit()) {
			$va_type_ids[$pr_res->get($vs_type_fld)]++;
		}
		
		$va_results = array();
		foreach($va_type_ids as $vn_type_id => $vn_count) {
			$qr_res = $pr_res->getClone();
			$qr_res->filterResult("{$vs_table}.{$vs_type_fld}", array($vn_type_id));
			$qr_res->seek(0);
			$va_results[$vn_type_id] = array(
				'type' => $va_types[$vn_type_id],
				'result' =>$qr_res
			);
		}
		return $va_results;
	}
	# ---------------------------------------
	/**
	 * 
	 *
	 * @return Configuration 
	 */
	function caGetSearchConfig() {
		$o_config = Configuration::load();
		return Configuration::load($o_config->get('search_config'));
	}
	# ---------------------------------------
	/**
	 * 
	 *
	 * @return array 
	 */
	function caGetInfoForSearchType($ps_search_type) {
		$o_browse_config = caGetSearchConfig();
		
		$va_search_types = $o_browse_config->getAssoc('searchTypes');
		$ps_search_type = strtolower($ps_search_type);
		
		if (isset($va_search_types[$ps_search_type])) {
			return $va_search_types[$ps_search_type];
		}
		return null;
	}
	# ---------------------------------------
?>