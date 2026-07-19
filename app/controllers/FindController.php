<?php
/* ----------------------------------------------------------------------
 * app/controllers/FindController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2026 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__.'/ApplicationPluginManager.php');
require_once(__CA_APP_DIR__."/helpers/searchHelpers.php");
require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
require_once(__CA_APP_DIR__."/helpers/exportHelpers.php");
require_once(__CA_APP_DIR__."/helpers/printHelpers.php");
require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');

class FindController extends BasePawtucketController {
	# -------------------------------------------------------
	/**
	 * @var Configuration
	 */
	 protected $opo_config;
	 
	/**
	 * @var 
	 */
	 protected $ops_view_prefix=null;
	 
	/**
	 * 
	 */
	protected $opo_app_plugin_manager;
	  
	
	/**
	 * @var HTMLPurifier
	 */
	protected $purifier;
	 
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$request, &$response, $view_paths=null) {
		// Make application plugin manager available to superclasses
		$this->opo_app_plugin_manager = new ApplicationPluginManager();
		
		$this->purifier = caGetHTMLPurifier();
		
		parent::__construct($request, $response, $view_paths);
	}
	# ------------------------------------------------------------------
	/**
	 * 
	 */
	protected function setTableSpecificViewVars(?array $info=null) {
		// merge displays with drop-in print templates
		$export_options = (bool)$this->request->config->get('disable_pdf_output') ? array() : caGetAvailablePrintTemplates('results', array('restrictToTypes' => $info['restrictToTypes'] ?? null, 'table' => $this->ops_tablename)); 
		
		// add Excel/PowerPoint export options configured in app.conf
		$export_config = (bool)$this->request->config->get('disable_export_output') ? array() : $this->request->config->getAssoc('export_formats');

		if(is_array($export_config) && is_array($export_config[$this->ops_tablename])) {
			foreach($export_config[$this->ops_tablename] as $export_code => $export_option) {
				$export_options[] = array(
					'name' => $export_option['name'],
					'code' => $export_code,
					'type' => $export_option['type']
				);
			}
		}
		$this->view->setVar('isNav', $vb_is_nav = (bool)$this->request->getParameter('isNav', pInteger));	// flag for browses that originate from nav bar
		$this->view->setVar('export_formats', $export_options);
		
		$options = array();
		foreach($export_options as $i => $format_info) {
			$options[$format_info['name']] = $format_info['code'];
		}
		
		if(!$this->request->config->get('disable_display_based_exports')) {
			// Get current display list
			$t_display = new ca_bundle_displays();
			foreach(caExtractValuesByUserLocale($t_display->getBundleDisplays(array('restrictToTypes' => $info['restrictToTypes'] ?? null, 'table' => $this->ops_tablename, 'user_id' => $this->request->getUserID(), 'access' => __CA_BUNDLE_DISPLAY_READ_ACCESS__, 'checkAccess' => caGetUserAccessValues($this->request)))) as $display) {
				$options[$display['name']] = "_display_".$display['display_id'];
			}
		}
		ksort($options);
		
		// Set comparison list view vars
		$this->view->setVar('comparison_list', $comparison_list = caGetComparisonList($this->request, $this->ops_tablename));
		
		$this->view->setVar('export_format_select', caHTMLSelect('export_format', $options, array('class' => 'searchToolsSelect'), array('value' => $this->view->getVar('current_export_format'), 'width' => '150px')));
	}
	# ------------------------------------------------------------------
	/**
	 * 
	 */
	protected function getFacet($browse) {
		//
		// Return facet content
		//	
		$this->view->setVar('browse', $browse);
		
		$vb_is_nav = (bool)$this->request->getParameter('isNav', pInteger);
		$this->view->setVar('isNav', $vb_is_nav);
		$facet = $this->request->getParameter('facet', pString, ['forcePurify' => true]);
		$s = $vb_is_nav ? $this->request->getParameter('s', pInteger) : 0;	// start menu-based browse menu facet data at page boundary; all others get the full facet
		$this->view->setVar('start', $s);
		$this->view->setVar('limit', $limit = ($vb_is_nav ? 500 : null));	// break facet into pages for menu-based browse menu
		$this->view->setVar('facet_name', $facet);
		$this->view->setVar('key', $browse->getBrowseID());
		$this->view->setVar('facet_info', $facet_info = $browse->getInfoForFacet($facet));
		
		# --- pull in different views based on format for facet - alphabetical, list, hierarchy
		switch($facet_info["group_mode"]){
			case "alphabetical":
			case "list":
			default:
				$content = $browse->getFacet($facet, ["checkAccess" => $this->opa_access_values, 'start' => $s, 'limit' => $limit]);
				$this->view->setVar('facet_content', is_array($content) ? $content : []);
				if($vb_is_nav && $limit){
					$this->view->setVar('facet_size', sizeof($browse->getFacet($facet, array("checkAccess" => $this->opa_access_values))));					
				}
				$this->render($this->ops_view_prefix."/list_facet_html.php");
				break;
			case "hierarchical":
				$this->render($this->ops_view_prefix."/hierarchy_facet_html.php");
				break;
		}
		return;
	}
	# ------------------------------------------------------------------
	/**
	 * Given a item_id (request parameter 'id') returns a list of direct children for use in the hierarchy browser
	 * Returned data is JSON format
	 */
	public function getFacetHierarchyLevel() {
		$access_values = caGetUserAccessValues($this->request);
		$ps_facet_name = $this->request->getParameter('facet', pString, ['forcePurify' => true]);
		$ps_cache_key = $this->request->getParameter('key', pString, ['forcePurify' => true]);
		$ps_browse_type = $this->request->getParameter('browseType', pString, ['forcePurify' => true]);
		$this->view->setVar('isNav', $vb_is_nav = (bool)$this->request->getParameter('isNav', pInteger));	// flag for browses that originate from nav bar
		
		if($ps_browse_type == "caLightbox"){
			$browse_info['table'] = 'ca_objects';
		}else{
			if (!($browse_info = caGetInfoForBrowseType($ps_browse_type))) {
				// invalid browse type – throw error
				throw new ApplicationException("Invalid browse type");
			} 			
		} 			
		$this->view->setVar("facet_name", $ps_facet_name);
		$this->view->setVar("key", $ps_cache_key);
		$this->view->setVar("browse_type", $ps_browse_type);
		
		$class = $browse_info['table'];
		$o_browse = caGetBrowseInstance($class);
		
		if(!is_array($facet_info = $o_browse->getInfoForFacet($ps_facet_name))) { return null; }
		$this->view->setVar("facet_info", $facet_info);
 		if ($ps_cache_key) {
			$o_browse->reload($ps_cache_key);
		}
		
		$facet = $o_browse->getFacet($ps_facet_name, array('checkAccess' => $access_values));
		
		$ids = explode(";", $ps_ids = $this->request->getParameter('id', pString, ['forcePurify' => true]));
		if (!sizeof($ids)) { $ids = array(null); }
		
		$level_data = array();

		if ((($max_items_per_page = $this->request->getParameter('max', pInteger)) < 1) || ($max_items_per_page > 1000)) {
			$max_items_per_page = null;
		}
					
		foreach($ids as $pn_id) {
			$json_data = array('_primaryKey' => 'item_id');
			
			$tmp = explode(":", $pn_id);
			$id = $tmp[0];
			$start = (int)$tmp[1];
			if($start < 0) { $start = 0; }
			switch($facet_info['type']) {
				case 'attribute':
					// is it a list attribute?
					$t_element = new ca_metadata_elements();
					if ($t_element->load(array('element_code' => $facet_info['element_code']))) {
						if ($t_element->get('datatype') == __CA_ATTRIBUTE_VALUE_LIST__) {
							if (!$id) {
								$t_list = new ca_lists();
								$id = $t_list->getRootListItemID($t_element->get('list_id'));
							}
							
							foreach($facet as $i => $item) {
								if ($item['parent_id'] == $id) {
									$item['item_id'] = $item['id'];
									$item['name'] = $item['label'];
									$item['children'] = $item['child_count'];
									unset($item['label']);
									unset($item['child_count']);
									unset($item['id']);
									$json_data[$item['item_id']] = $item;
								}
							}
						}
					}
					break;
				case 'fieldList':
					if (!$id) {
						$t_item = Datamodel::getInstance($class);
						$list_code = $t_item->getFieldInfo($facet_info['field'], 'LIST_CODE');
						$t_list = new ca_lists(['list_code' => $list_code]);
						$id = $t_list->getRootItemIDForList();
					}
					foreach($facet as $i => $item) {
						if ($item['parent_id'] == $id) {
							$item['item_id'] = $item['id'];
							$item['name'] = $item['label'];
							$item['children'] = $item['child_count'];
							unset($item['label']);
							unset($item['child_count']);
							unset($item['id']);
							$json_data[$item['item_id']] = $item;
						}
					}
					break;
				case 'label':
					// label facet
					$facet_info['table'] = $this->ops_tablename;
					// fall through to default case
				default:
					if(!$id) {
						$hier_ids = $o_browse->getHierarchyIDsForFacet($ps_facet_name, array('checkAccess' => $access_values));
						$t_item = Datamodel::getInstance($facet_info['table']);
						if($t_item->getHierarchyType() == __CA_HIER_TYPE_ADHOC_MONO__){
							# --- there are no roots in adhoc hierarchies
							# --- get all the top level records available in the facet
							$o_db = new Db();
							$qr_top_level = $o_db->query("SELECT ".$t_item->primaryKey()." FROM ".$facet_info['table']." WHERE parent_id IS NULL");
							if($qr_top_level->numRows()){
								$parent_ids = array();
								while($qr_top_level->nextRow()){
									$parent_ids[] = $qr_top_level->get($t_item->primaryKey());
								}
								$r_top_level = caMakeSearchResult($facet_info['table'], $parent_ids);
								$item = array();
								if($r_top_level->numHits()){
									while($r_top_level->nextHit()){
										if (!in_array($r_top_level->get($t_item->primaryKey()), $hier_ids)) { continue; }
										$item["name"] = $r_top_level->get($facet_info['table'].".preferred_labels");
										$item["item_id"] = $r_top_level->get($t_item->primaryKey());
										$item["parent_id"] = null;
										$item["children"] = sizeof($t_item->getHierarchyChildren($item["item_id"], array("idsOnly")));
										$json_data[$item["item_id"]] = $item;
									}
								}
							}
						}else{
							$id = $root = $t_item->getHierarchyRootID();
							$t_item->load($id);
							$hierarchy_list = $t_item->getHierarchyList(true);
						
							$last_id = null;
							$c = 0;
							foreach($hierarchy_list as $i => $item) {
								if (!in_array($i, $hier_ids)) { continue; }	// only show hierarchies that have items in browse result
								if ($start <= $c) {
									$item['item_id'] = $item[$t_item->primaryKey()];
									if (!isset($facet[$item['item_id']]) && ($root == $item['item_id'])) { continue; }
									$item['name'] = $item['label'];
									unset($item['parent_id']);
									unset($item['label']);
									if(!$item["name"]){
										$item["name"] = $item["list_code"];
									}
									$json_data[$item['item_id']] = $item;
									$last_id = $item['item_id'];
								}
								$c++;
								if (!is_null($max_items_per_page) && ($c >= ($max_items_per_page + $start))) { break; }
							}
							if (sizeof($json_data) == 2) {	// if only one hierarchy root (root +  _primaryKey in array) then don't bother showing it
								$id = $last_id;
								unset($json_data[$last_id]);
							}
						}
					}
					if ($id) {
						$c = 0;
						foreach($facet as $i => $item) {
							if ($item['parent_id'] == $id) {
								if ($start <= $c) {
									$item['item_id'] = $item['id'];
									$item['name'] = $item['label'];
									$item['children'] = $item['child_count'];
									unset($item['label']);
									unset($item['child_count']);
									unset($item['id']);
									$json_data[$item['item_id']] = $item;
								}									
								$c++;
								if (!is_null($max_items_per_page) && ($c >= ($max_items_per_page + $start))) { break; }
							}
						}
					}
					break;
			}
			$level_data[$pn_id] = $json_data;
		}
		if (!trim($this->request->getParameter('init', pString, ['forcePurify' => true]))) {
			$this->opo_result_context = new ResultContext($this->request, $browse_info['table'], $this->ops_find_type);
			$this->opo_result_context->setParameter($ps_facet_name.'_browse_last_id', $pn_id);
			$this->opo_result_context->saveContext();
		}
		
		$this->view->setVar('facet_list', $level_data);
		
		switch($this->request->getParameter('returnAs', pString, ['forcePurify' => true])){
			case "json":
				return $this->render('Browse/facet_hierarchy_level_json.php');
				break;
			case "html":
			default:
				return $this->render('Browse/facet_hierarchy_level_html.php');
				break;
		}
	}
	# ------------------------------------------------------------------
	/**
	 * Given a item_id (request parameter 'id') returns a list of ancestors for use in the hierarchy browser
	 * Returned data is JSON format
	 */
	public function getFacetHierarchyAncestorList() {
		$this->view->setVar('isNav', $vb_is_nav = (bool)$this->request->getParameter('isNav', pInteger));	// flag for browses that originate from nav bar
		$pn_id = $this->request->getParameter('id', pInteger);
		$this->view->setVar('id', $pn_id);
		$access_values = caGetUserAccessValues($this->request);
		$ps_facet_name = $this->request->getParameter('facet', pString, ['forcePurify' => true]);
		$this->view->setVar("facet_name", $ps_facet_name);
		$this->view->setVar("key", $this->request->getParameter('key', pString, ['forcePurify' => true]));
		$ps_browse_type = $this->request->getParameter('browseType', pString, ['forcePurify' => true]);
		if (!($browse_info = caGetInfoForBrowseType($ps_browse_type))) {
			// invalid browse type – throw error
			throw new ApplicationException("Invalid browse type");
		} 			
		$this->view->setVar("browse_type", $ps_browse_type);
		$class = $browse_info['table'];
		$o_browse = caGetBrowseInstance($class);
		if(!is_array($facet_info = $o_browse->getInfoForFacet($ps_facet_name))) { return null; }
		if ($ps_cache_key = $this->request->getParameter('key', pString, ['forcePurify' => true])) {
			$o_browse->reload($ps_cache_key);
		}
		
		$ancestors = array();
		switch($facet_info['type']) {
			case 'attribute':
				// is it a list attribute?
				$t_element = new ca_metadata_elements();
				if ($t_element->load(array('element_code' => $facet_info['element_code']))) {
					if ($t_element->get('datatype') == 3) { // 3=list
						$t_list = new ca_lists($t_element->get('list_id'));
						if (!$pn_id) { $pn_id = $t_list->getRootListItemID($t_element->get('list_id')); }
						$t_item = new ca_list_items($pn_id);
						
						if ($t_item->getPrimaryKey()) {
							$primary_key = $t_item->primaryKey();
							$this->view->setVar("primary_key", $primary_key);
							$display_fld = $t_item->getLabelDisplayField();
							$this->view->setVar("display_field", $display_fld);
							$label_table_name = $t_item->getLabelTableName();
							$ancestors = array_reverse($t_item->getHierarchyAncestors(null, array(
									'includeSelf' => true, 
									'additionalTableToJoin' => $label_table_name, 
									'additionalTableJoinType' => 'LEFT',
									'additionalTableSelectFields' => array($display_fld, 'locale_id'),
									'additionalTableWheres' => array('('.$label_table_name.'.is_preferred = 1 OR '.$label_table_name.'.is_preferred IS NULL)')
									)));
							$root = array_shift($ancestors);
							$root['NODE']['name_singular'] = $root['NODE']['name_plural'] = $t_list->get('ca_lists.preferred_labels.name');
							array_unshift($ancestors, $root);
						}
					}
				}
				break;
			case 'fieldList':
				$t_item = Datamodel::getInstance($class);
				$list_code = $t_item->getFieldInfo($facet_info['field'], 'LIST_CODE');
				$t_list = new ca_lists(['list_code' => $list_code]);
				$t_list_item = new ca_list_items();
				$this->view->setVar("display_field", 'name_plural');
				$ancestors = array_reverse($t_list_item->getHierarchyAncestors($pn_id, array(
						'includeSelf' => true, 
						'additionalTableToJoin' => 'ca_list_item_labels', 
						'additionalTableJoinType' => 'LEFT',
						'additionalTableSelectFields' => ['name_singular', 'name_plural', 'locale_id'],
						'additionalTableWheres' => ['(ca_list_item_labels.is_preferred = 1 OR ca_list_item_labels.is_preferred IS NULL)']
						)));
				$root = array_shift($ancestors);
				$root['NODE']['name_singular'] = $root['NODE']['name_plural'] = $t_list->get('ca_lists.preferred_labels.name');
				array_unshift($ancestors, $root);
				break;
			case 'label':
				// label facet
				$facet_info['table'] = $this->ops_tablename;
				// fall through to default case
			default:
				$t_item = Datamodel::getInstance($facet_info['table']);
				$t_item->load($pn_id);
				
				if (method_exists($t_item, "getHierarchyList")) { 
					$access_values = caGetUserAccessValues($this->request);
					$facet = $o_browse->getFacet($ps_facet_name, array('sort' => 'name', 'checkAccess' => $access_values));
					$hierarchy_list = $t_item->getHierarchyList(true);
					
					$hierarchies_in_use = 0;
					foreach($hierarchy_list as $i => $item) {
						if (isset($facet[$item[$t_item->primaryKey()]])) { 
							$hierarchies_in_use++;
							if ($hierarchies_in_use > 1) { break; }
						}
					}
				}
			
				if ($t_item->getPrimaryKey()) { 
					$primary_key = $t_item->primaryKey();
					$this->view->setVar("primary_key", $primary_key);
					$display_fld = $t_item->getLabelDisplayField();
					$this->view->setVar("display_field", $display_fld);
					$label_table_name = $t_item->getLabelTableName();
					$ancestors = array_reverse($t_item->getHierarchyAncestors(null, array(
									'includeSelf' => true, 
									'additionalTableToJoin' => $label_table_name, 
									'additionalTableJoinType' => 'LEFT',
									'additionalTableSelectFields' => array($display_fld, 'locale_id'),
									'additionalTableWheres' => array('('.$label_table_name.'.is_preferred = 1 OR '.$label_table_name.'.is_preferred IS NULL)')
									)));
				}
				if (($hierarchies_in_use <= 1) && ($t_item->getHierarchyType() != __CA_HIER_TYPE_ADHOC_MONO__)) {
					array_shift($ancestors);
				}
				break;
		}
		
		$this->view->setVar('ancestors', $ancestors);
		
		switch($this->request->getParameter('returnAs', pString, ['forcePurify' => true])){
			case "json":
				return $this->render('Browse/facet_hierarchy_ancestors_json.php');
				break;
			case "html":
			default:
				return $this->render('Browse/facet_hierarchy_ancestors_html.php');
				break;
		}
	}
	# -------------------------------------------------------
	# Export
	# -------------------------------------------------------
	/**
	 * Generate  export file of current result
	 */
	protected function _genExport($result, $ps_template, $ps_output_filename, $ps_criteria_summary=null) {
		if ($this->opo_result_context) {
			$this->opo_result_context->setParameter('last_export_type', $ps_output_type);
			$this->opo_result_context->saveContext();
		}
	
		caExportResult($this->request, $result, $ps_template, $ps_output_filename, ['criteriaSummary' => $ps_criteria_summary]);
	}
	# ------------------------------------------------------------------
	/**
	 * Returns summary of search or browse parameters suitable for display.
	 * This is a base implementation and should be overridden to provide more 
	 * detailed and appropriate output where necessary.
	 *
	 * @return string Summary of current search expression or browse criteria ready for display
	 */
	public function getCriteriaForDisplay($browse=null) {
		return $this->opo_result_context ? $this->opo_result_context->getSearchExpression() : '';		// just give back the search expression verbatim; works ok for simple searches	
	}
	# -------------------------------------------------------
	/**
	 * Return text for map item info bubble
	 */
	public function mapContent() {
		if($this->opb_is_login_redirect) { return; }
		
		$ids = explode(";",$this->request->getParameter('ids', pString, ['forcePurify' => true])); 
		$view = $this->request->getParameter('view', pString, ['forcePurify' => true]);
		$browse = $this->request->getParameter('browse', pString, ['forcePurify' => true]);
		$bundle = $this->request->getParameter('bundle', pString, ['forcePurify' => true]);
		if(!$bundle) { $bundle = '__mixed__'; }
		
		if (!($browse_info = caGetInfoForBrowseType($browse))) {
			// invalid browse type – throw error
			throw new ApplicationException("Invalid browse type");
		}
		
		$this->view->setVar('view', $view = caCheckLightboxView(array('request' => $this->request, 'default' => 'map')));
		$this->view->setVar('views', $views = $this->opo_config->getAssoc("views"));
		if (!is_array($view_info = $browse_info['views'][$view])) {
			throw new ApplicationException("Invalid view");
		}
		
		$content_template = $view_info['mapItemInfoTemplates'][$bundle]['template'] ?? $view_info['mapItemInfoTemplate'] ?? '';
		
		$this->view->setVar('items', caProcessTemplateForIDs($content_template, $browse_info['table'], $ids, array('checkAccess' => $this->opa_access_values, 'returnAsArray' => true)));
	
		$this->view->setVar('heading', trim($view_info['display']['heading']) ? caProcessTemplateForIDs($view_info['display']['heading'], $browse_info['table'], [$ids[0]], array('checkAccess' => $this->opa_access_values)) : "");
		$this->view->setVar('table', $browse_info['table']);
		$this->view->setVar('ids', $ids);
		
		$this->render("Browse/ajax_map_item_html.php");   
	}
	# -------------------------------------------------------
}
