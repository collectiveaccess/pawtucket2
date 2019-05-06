<?php
/* ----------------------------------------------------------------------
 * app/controllers/FindController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2016 Whirl-i-Gig
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
 	require_once(__CA_MODELS_DIR__."/ca_bundle_displays.php");
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
 		 
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			// Make application plugin manager available to superclasses
 			$this->opo_app_plugin_manager = new ApplicationPluginManager();
 			
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 		}
 		# ------------------------------------------------------------------
 		/**
 		 * 
 		 */
 		protected function setTableSpecificViewVars() {
 			// merge displays with drop-in print templates
			$va_export_options = (bool)$this->request->config->get('disable_pdf_output') ? array() : caGetAvailablePrintTemplates('results', array('table' => $this->ops_tablename)); 
			
			// add Excel/PowerPoint export options configured in app.conf
			$va_export_config = (bool)$this->request->config->get('disable_export_output') ? array() : $this->request->config->getAssoc('export_formats');
	
			if(is_array($va_export_config) && is_array($va_export_config[$this->ops_tablename])) {
				foreach($va_export_config[$this->ops_tablename] as $vs_export_code => $va_export_option) {
					$va_export_options[] = array(
						'name' => $va_export_option['name'],
						'code' => $vs_export_code,
						'type' => $va_export_option['type']
					);
				}
			}
			$this->view->setVar('isNav', $vb_is_nav = (bool)$this->request->getParameter('isNav', pInteger));	// flag for browses that originate from nav bar
			$this->view->setVar('export_formats', $va_export_options);
			
			$va_options = array();
			foreach($va_export_options as $vn_i => $va_format_info) {
				$va_options[$va_format_info['name']] = $va_format_info['code'];
			}
			// Get current display list
			$t_display = new ca_bundle_displays();
 			foreach(caExtractValuesByUserLocale($t_display->getBundleDisplays(array('table' => $this->ops_tablename, 'user_id' => $this->request->getUserID(), 'access' => __CA_BUNDLE_DISPLAY_READ_ACCESS__, 'checkAccess' => caGetUserAccessValues($this->request)))) as $va_display) {
 				$va_options[$va_display['name']] = "_display_".$va_display['display_id'];
 			}
 			ksort($va_options);
 			
 			// Set comparison list view vars
 			$this->view->setVar('comparison_list', $va_comparison_list = caGetComparisonList($this->request, $this->ops_tablename));
 			
			$this->view->setVar('export_format_select', caHTMLSelect('export_format', $va_options, array('class' => 'searchToolsSelect'), array('value' => $this->view->getVar('current_export_format'), 'width' => '150px')));
 		}
 		# ------------------------------------------------------------------
 		/**
 		 * 
 		 */
 		protected function getFacet($po_browse) {
 			//
			// Return facet content
			//	
			$this->view->setVar('browse', $po_browse);
			
			$vb_is_nav = (bool)$this->request->getParameter('isNav', pInteger);
			$this->view->setVar('isNav', $vb_is_nav);
			$vs_facet = $this->request->getParameter('facet', pString, ['forcePurify' => true]);
			$vn_s = $vb_is_nav ? $this->request->getParameter('s', pInteger) : 0;	// start menu-based browse menu facet data at page boundary; all others get the full facet
			$this->view->setVar('start', $vn_s);
			$this->view->setVar('limit', $vn_limit = ($vb_is_nav ? 500 : null));	// break facet into pages for menu-based browse menu
			$this->view->setVar('facet_name', $vs_facet);
			$this->view->setVar('key', $po_browse->getBrowseID());
			$this->view->setVar('facet_info', $va_facet_info = $po_browse->getInfoForFacet($vs_facet));
			
			# --- pull in different views based on format for facet - alphabetical, list, hierarchy
			switch($va_facet_info["group_mode"]){
				case "alphabetical":
				case "list":
				default:
				    $content = $po_browse->getFacet($vs_facet, ["checkAccess" => $this->opa_access_values, 'start' => $vn_s, 'limit' => $vn_limit]);
					$this->view->setVar('facet_content', is_array($content) ? $content : []);
					if($vb_is_nav && $vn_limit){
						$this->view->setVar('facet_size', sizeof($po_browse->getFacet($vs_facet, array("checkAccess" => $this->opa_access_values))));					
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
 			$va_access_values = caGetUserAccessValues($this->request);
 			$ps_facet_name = $this->request->getParameter('facet', pString, ['forcePurify' => true]);
 			$ps_cache_key = $this->request->getParameter('key', pString, ['forcePurify' => true]);
 			$ps_browse_type = $this->request->getParameter('browseType', pString, ['forcePurify' => true]);
 			$this->view->setVar('isNav', $vb_is_nav = (bool)$this->request->getParameter('isNav', pInteger));	// flag for browses that originate from nav bar
			
 			if($ps_browse_type == "caLightbox"){
 				$va_browse_info['table'] = 'ca_objects';
 			}else{
				if (!($va_browse_info = caGetInfoForBrowseType($ps_browse_type))) {
					// invalid browse type – throw error
					throw new ApplicationException("Invalid browse type");
				} 			
			} 			
 			$this->view->setVar("facet_name", $ps_facet_name);
 			$this->view->setVar("key", $ps_cache_key);
 			$this->view->setVar("browse_type", $ps_browse_type);
 			
 			$vs_class = $va_browse_info['table'];
			$o_browse = caGetBrowseInstance($vs_class);
			
 			if(!is_array($va_facet_info = $o_browse->getInfoForFacet($ps_facet_name))) { return null; }
 			if ($ps_cache_key) {
				$o_browse->reload($ps_cache_key);
			}
			
 			$va_facet = $o_browse->getFacet($ps_facet_name, array('checkAccess' => $va_access_values));
 			
			$pa_ids = explode(";", $ps_ids = $this->request->getParameter('id', pString, ['forcePurify' => true]));
			if (!sizeof($pa_ids)) { $pa_ids = array(null); }
 			
			$va_level_data = array();
 	
 			if ((($vn_max_items_per_page = $this->request->getParameter('max', pInteger)) < 1) || ($vn_max_items_per_page > 1000)) {
				$vn_max_items_per_page = null;
			}
						
 			foreach($pa_ids as $pn_id) {
 				$va_json_data = array('_primaryKey' => 'item_id');
				
				$va_tmp = explode(":", $pn_id);
				$vn_id = $va_tmp[0];
				$vn_start = (int)$va_tmp[1];
				if($vn_start < 0) { $vn_start = 0; }
 				switch($va_facet_info['type']) {
					case 'attribute':
						// is it a list attribute?
						$t_element = new ca_metadata_elements();
						if ($t_element->load(array('element_code' => $va_facet_info['element_code']))) {
							if ($t_element->get('datatype') == __CA_ATTRIBUTE_VALUE_LIST__) {
								if (!$vn_id) {
									$t_list = new ca_lists();
									$vn_id = $t_list->getRootListItemID($t_element->get('list_id'));
								}
								
								foreach($va_facet as $vn_i => $va_item) {
									if ($va_item['parent_id'] == $vn_id) {
										$va_item['item_id'] = $va_item['id'];
										$va_item['name'] = $va_item['label'];
										$va_item['children'] = $va_item['child_count'];
										unset($va_item['label']);
										unset($va_item['child_count']);
										unset($va_item['id']);
										$va_json_data[$va_item['item_id']] = $va_item;
									}
								}
							}
						}
						break;
					case 'fieldList':
					    if (!$vn_id) {
                            $t_item = Datamodel::getInstance($vs_class);
                            $vs_list_code = $t_item->getFieldInfo($va_facet_info['field'], 'LIST_CODE');
                            $t_list = new ca_lists(['list_code' => $vs_list_code]);
					        $vn_id = $t_list->getRootItemIDForList();
					    }
					    foreach($va_facet as $vn_i => $va_item) {
                            if ($va_item['parent_id'] == $vn_id) {
                                $va_item['item_id'] = $va_item['id'];
                                $va_item['name'] = $va_item['label'];
                                $va_item['children'] = $va_item['child_count'];
                                unset($va_item['label']);
                                unset($va_item['child_count']);
                                unset($va_item['id']);
                                $va_json_data[$va_item['item_id']] = $va_item;
                            }
                        }
                        break;
					case 'label':
						// label facet
						$va_facet_info['table'] = $this->ops_tablename;
						// fall through to default case
					default:
						if(!$vn_id) {
							$va_hier_ids = $o_browse->getHierarchyIDsForFacet($ps_facet_name, array('checkAccess' => $va_access_values));
							$t_item = Datamodel::getInstance($va_facet_info['table']);
							if($t_item->getHierarchyType() == __CA_HIER_TYPE_ADHOC_MONO__){
								# --- there are no roots in adhoc hierarchies
								# --- get all the top level records available in the facet
								$o_db = new Db();
								$qr_top_level = $o_db->query("SELECT ".$t_item->primaryKey()." FROM ".$va_facet_info['table']." WHERE parent_id IS NULL");
								if($qr_top_level->numRows()){
									$va_parent_ids = array();
									while($qr_top_level->nextRow()){
										$va_parent_ids[] = $qr_top_level->get($t_item->primaryKey());
									}
									$r_top_level = caMakeSearchResult($va_facet_info['table'], $va_parent_ids);
									$va_item = array();
									if($r_top_level->numHits()){
										while($r_top_level->nextHit()){
											if (!in_array($r_top_level->get($t_item->primaryKey()), $va_hier_ids)) { continue; }
											$va_item["name"] = $r_top_level->get($va_facet_info['table'].".preferred_labels");
											$va_item["item_id"] = $r_top_level->get($t_item->primaryKey());
											$va_item["parent_id"] = null;
											$va_item["children"] = sizeof($t_item->getHierarchyChildren($va_item["item_id"], array("idsOnly")));
											$va_json_data[$va_item["item_id"]] = $va_item;
										}
									}
								}
							}else{
								$vn_id = $vn_root = $t_item->getHierarchyRootID();
								$t_item->load($vn_id);
								$va_hierarchy_list = $t_item->getHierarchyList(true);
							
								$vn_last_id = null;
								$vn_c = 0;
								foreach($va_hierarchy_list as $vn_i => $va_item) {
									if (!in_array($vn_i, $va_hier_ids)) { continue; }	// only show hierarchies that have items in browse result
									if ($vn_start <= $vn_c) {
										$va_item['item_id'] = $va_item[$t_item->primaryKey()];
										if (!isset($va_facet[$va_item['item_id']]) && ($vn_root == $va_item['item_id'])) { continue; }
										$va_item['name'] = $va_item['label'];
										unset($va_item['parent_id']);
										unset($va_item['label']);
										if(!$va_item["name"]){
											$va_item["name"] = $va_item["list_code"];
										}
										$va_json_data[$va_item['item_id']] = $va_item;
										$vn_last_id = $va_item['item_id'];
									}
									$vn_c++;
									if (!is_null($vn_max_items_per_page) && ($vn_c >= ($vn_max_items_per_page + $vn_start))) { break; }
								}
								if (sizeof($va_json_data) == 2) {	// if only one hierarchy root (root +  _primaryKey in array) then don't bother showing it
									$vn_id = $vn_last_id;
									unset($va_json_data[$vn_last_id]);
								}
							}
						}
						if ($vn_id) {
							$vn_c = 0;
							foreach($va_facet as $vn_i => $va_item) {
								if ($va_item['parent_id'] == $vn_id) {
									if ($vn_start <= $vn_c) {
										$va_item['item_id'] = $va_item['id'];
										$va_item['name'] = $va_item['label'];
										$va_item['children'] = $va_item['child_count'];
										unset($va_item['label']);
										unset($va_item['child_count']);
										unset($va_item['id']);
										$va_json_data[$va_item['item_id']] = $va_item;
									}									
									$vn_c++;
									if (!is_null($vn_max_items_per_page) && ($vn_c >= ($vn_max_items_per_page + $vn_start))) { break; }
								}
							}
						}
						break;
				}
				$va_level_data[$pn_id] = $va_json_data;
			}
 			if (!trim($this->request->getParameter('init', pString, ['forcePurify' => true]))) {
				$this->opo_result_context = new ResultContext($this->request, $va_browse_info['table'], $this->ops_find_type);
				$this->opo_result_context->setParameter($ps_facet_name.'_browse_last_id', $pn_id);
				$this->opo_result_context->saveContext();
			}
 			
 			$this->view->setVar('facet_list', $va_level_data);
 			
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
 			$va_access_values = caGetUserAccessValues($this->request);
 			$ps_facet_name = $this->request->getParameter('facet', pString, ['forcePurify' => true]);
 			$this->view->setVar("facet_name", $ps_facet_name);
 			$this->view->setVar("key", $this->request->getParameter('key', pString, ['forcePurify' => true]));
 			$ps_browse_type = $this->request->getParameter('browseType', pString, ['forcePurify' => true]);
 			if (!($va_browse_info = caGetInfoForBrowseType($ps_browse_type))) {
 				// invalid browse type – throw error
 				throw new ApplicationException("Invalid browse type");
 			} 			
 			$this->view->setVar("browse_type", $ps_browse_type);
 			$vs_class = $va_browse_info['table'];
			$o_browse = caGetBrowseInstance($vs_class);
 			if(!is_array($va_facet_info = $o_browse->getInfoForFacet($ps_facet_name))) { return null; }
 			if ($ps_cache_key = $this->request->getParameter('key', pString, ['forcePurify' => true])) {
				$o_browse->reload($ps_cache_key);
			}
 			
 			$va_ancestors = array();
 			switch($va_facet_info['type']) {
 				case 'attribute':
 					// is it a list attribute?
 					$t_element = new ca_metadata_elements();
 					if ($t_element->load(array('element_code' => $va_facet_info['element_code']))) {
 						if ($t_element->get('datatype') == 3) { // 3=list
 							$t_list = new ca_lists($t_element->get('list_id'));
							if (!$pn_id) { $pn_id = $t_list->getRootListItemID($t_element->get('list_id')); }
							$t_item = new ca_list_items($pn_id);
							
							if ($t_item->getPrimaryKey()) {
								$vs_primary_key = $t_item->primaryKey();
								$this->view->setVar("primary_key", $vs_primary_key);
								$vs_display_fld = $t_item->getLabelDisplayField();
								$this->view->setVar("display_field", $vs_display_fld);
								$vs_label_table_name = $t_item->getLabelTableName();
								$va_ancestors = array_reverse($t_item->getHierarchyAncestors(null, array(
										'includeSelf' => true, 
										'additionalTableToJoin' => $vs_label_table_name, 
										'additionalTableJoinType' => 'LEFT',
										'additionalTableSelectFields' => array($vs_display_fld, 'locale_id'),
										'additionalTableWheres' => array('('.$vs_label_table_name.'.is_preferred = 1 OR '.$vs_label_table_name.'.is_preferred IS NULL)')
										)));
								$va_root = array_shift($va_ancestors);
								$va_root['NODE']['name_singular'] = $va_root['NODE']['name_plural'] = $t_list->get('ca_lists.preferred_labels.name');
								array_unshift($va_ancestors, $va_root);
							}
 						}
 					}
 					break;
 				case 'fieldList':
					$t_item = Datamodel::getInstance($vs_class);
					$vs_list_code = $t_item->getFieldInfo($va_facet_info['field'], 'LIST_CODE');
					$t_list = new ca_lists(['list_code' => $vs_list_code]);
					$t_list_item = new ca_list_items();
					$this->view->setVar("display_field", 'name_plural');
 				    $va_ancestors = array_reverse($t_list_item->getHierarchyAncestors($pn_id, array(
                            'includeSelf' => true, 
                            'additionalTableToJoin' => 'ca_list_item_labels', 
                            'additionalTableJoinType' => 'LEFT',
                            'additionalTableSelectFields' => array('name_singular', 'name_plural', 'locale_id'),
                            'additionalTableWheres' => array('(ca_list_item_labels.is_preferred = 1 OR ca_list_item_labels.is_preferred IS NULL)')
                            )));
                    $va_root = array_shift($va_ancestors);
                    $va_root['NODE']['name_singular'] = $va_root['NODE']['name_plural'] = $t_list->get('ca_lists.preferred_labels.name');
                    array_unshift($va_ancestors, $va_root);
 				    break;
 				case 'label':
 					// label facet
 					$va_facet_info['table'] = $this->ops_tablename;
 					// fall through to default case
 				default:
					$t_item = Datamodel::getInstance($va_facet_info['table']);
					$t_item->load($pn_id);
					
					if (method_exists($t_item, "getHierarchyList")) { 
						$va_access_values = caGetUserAccessValues($this->request);
						$va_facet = $o_browse->getFacet($ps_facet_name, array('sort' => 'name', 'checkAccess' => $va_access_values));
						$va_hierarchy_list = $t_item->getHierarchyList(true);
						
						$vn_hierarchies_in_use = 0;
						foreach($va_hierarchy_list as $vn_i => $va_item) {
							if (isset($va_facet[$va_item[$t_item->primaryKey()]])) { 
								$vn_hierarchies_in_use++;
								if ($vn_hierarchies_in_use > 1) { break; }
							}
						}
					}
 				
					if ($t_item->getPrimaryKey()) { 
						$vs_primary_key = $t_item->primaryKey();
						$this->view->setVar("primary_key", $vs_primary_key);
						$vs_display_fld = $t_item->getLabelDisplayField();
						$this->view->setVar("display_field", $vs_display_fld);
						$vs_label_table_name = $t_item->getLabelTableName();
						$va_ancestors = array_reverse($t_item->getHierarchyAncestors(null, array(
										'includeSelf' => true, 
										'additionalTableToJoin' => $vs_label_table_name, 
										'additionalTableJoinType' => 'LEFT',
										'additionalTableSelectFields' => array($vs_display_fld, 'locale_id'),
										'additionalTableWheres' => array('('.$vs_label_table_name.'.is_preferred = 1 OR '.$vs_label_table_name.'.is_preferred IS NULL)')
										)));
					}
					if (($vn_hierarchies_in_use <= 1) && ($t_item->getHierarchyType() != __CA_HIER_TYPE_ADHOC_MONO__)) {
						array_shift($va_ancestors);
					}
					break;
			}
			
 			$this->view->setVar('ancestors', $va_ancestors);
 			
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
		protected function _genExport($po_result, $ps_template, $ps_output_filename, $ps_criteria_summary=null) {
			if ($this->opo_result_context) {
				$this->opo_result_context->setParameter('last_export_type', $ps_output_type);
				$this->opo_result_context->saveContext();
			}
		
			caExportResult($this->request, $po_result, $ps_template, $ps_output_filename, ['criteriaSummary' => $ps_criteria_summary]);
		}
		# ------------------------------------------------------------------
 		/**
 		 * Returns summary of search or browse parameters suitable for display.
 		 * This is a base implementation and should be overridden to provide more 
 		 * detailed and appropriate output where necessary.
 		 *
 		 * @return string Summary of current search expression or browse criteria ready for display
 		 */
 		public function getCriteriaForDisplay($po_browse=null) {
 			return $this->opo_result_context ? $this->opo_result_context->getSearchExpression() : '';		// just give back the search expression verbatim; works ok for simple searches	
 		}
 		# -------------------------------------------------------
        /**
         * Return text for map item info bubble
         */
 		public function ajaxGetMapItem() {
            if($this->opb_is_login_redirect) { return; }
            
            $pa_ids = explode(";",$this->request->getParameter('id', pString, ['forcePurify' => true])); 
            $ps_view = $this->request->getParameter('view', pString, ['forcePurify' => true]);
            $ps_browse = $this->request->getParameter('browse', pString, ['forcePurify' => true]);
            if (!($va_browse_info = caGetInfoForBrowseType($ps_browse))) {
 				// invalid browse type – throw error
 				throw new ApplicationException("Invalid browse type");
 			}
 			
 			$this->view->setVar('view', $ps_view = caCheckLightboxView(array('request' => $this->request, 'default' => 'map')));
			$this->view->setVar('views', $va_views = $this->opo_config->getAssoc("views"));
			if (!is_array($va_view_info = $va_browse_info['views'][$ps_view])) {
				throw new ApplicationException("Invalid view");
			}
            
			$vs_content_template = $va_view_info['display']['icon'].$va_view_info['display']['title_template'].$va_view_info['display']['description_template'];
			
			$this->view->setVar('contentTemplate', caProcessTemplateForIDs($vs_content_template, $va_browse_info['table'], $pa_ids, array('checkAccess' => $this->opa_access_values, 'delimiter' => "<br style='clear:both;'/>")));
			
			$this->view->setVar('heading', trim($va_view_info['display']['heading']) ? caProcessTemplateForIDs($va_view_info['display']['heading'], $va_browse_info['table'], [$pa_ids[0]], array('checkAccess' => $this->opa_access_values)) : "");
			$this->view->setVar('table', $va_browse_info['table']);
			$this->view->setVar('ids', $pa_ids);
         	$this->render("Browse/ajax_map_item_html.php");   
        }
 		# -------------------------------------------------------
 	}