<?php
/* ----------------------------------------------------------------------
 * app/controllers/FindController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 	require_once(__CA_APP_DIR__."/helpers/searchHelpers.php");
 	require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
 	require_once(__CA_APP_DIR__."/helpers/printHelpers.php");
 	require_once(__CA_LIB_DIR__.'/core/Parsers/dompdf/dompdf_config.inc.php');
 	
 	class FindController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			// merge default formats with drop-in print templates
			$va_export_options = caGetAvailablePrintTemplates('results', array('table' => $this->ops_tablename)); 
			$this->view->setVar('export_formats', $va_export_options);
			//$this->view->setVar('current_export_format', $this->opo_result_context->getParameter('last_export_type'));
			
			$va_options = array();
			foreach($va_export_options as $vn_i => $va_format_info) {
				$va_options[$va_format_info['name']] = $va_format_info['code'];
			}
			$this->view->setVar('export_format_select', caHTMLSelect('export_format', $va_options, array('class' => 'searchToolsSelect'), array('value' => $this->view->getVar('current_export_format'), 'width' => '150px')));
 		}
 		# ------------------------------------------------------------------
 		/**
 		 * Given a item_id (request parameter 'id') returns a list of direct children for use in the hierarchy browser
 		 * Returned data is JSON format
 		 */
 		public function getFacetHierarchyLevel() {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$ps_facet_name = $this->request->getParameter('facet', pString);
 			$ps_cache_key = $this->request->getParameter('key', pString);
 			$ps_browse_type = $this->request->getParameter('browseType', pString);
 			
 			if (!($va_browse_info = caGetInfoForBrowseType($ps_browse_type))) {
 				// invalid browse type – throw error
 				die("Invalid browse type");
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
 			
			$pa_ids = explode(";", $ps_ids = $this->request->getParameter('id', pString));
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
					case 'label':
						// label facet
						$va_facet_info['table'] = $this->ops_tablename;
						// fall through to default case
					default:
						if(!$vn_id) {
							$va_hier_ids = $o_browse->getHierarchyIDsForFacet($ps_facet_name, array('checkAccess' => $va_access_values));
							$t_item = $this->request->datamodel->getInstanceByTableName($va_facet_info['table']);
							$t_item->load($vn_id);
							$vn_id = $vn_root = $t_item->getHierarchyRootID();
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
 			if (!trim($this->request->getParameter('init', pString))) {
				$this->opo_result_context = new ResultContext($this->request, $va_browse_info['table'], $this->ops_find_type);
				$this->opo_result_context->setParameter($ps_facet_name.'_browse_last_id', $pn_id);
				$this->opo_result_context->saveContext();
			}
 			
 			$this->view->setVar('facet_list', $va_level_data);
 			
 			switch($this->request->getParameter('returnAs', pString)){
 				# ------------------------------------------------
 				case "json":
 					return $this->render('Browse/facet_hierarchy_level_json.php');
 					break;
 				# ------------------------------------------------
 				case "html":
 				default:
 					return $this->render('Browse/facet_hierarchy_level_html.php');
 					break;
 				# ------------------------------------------------
 			}
 		}
 		# ------------------------------------------------------------------
 		/**
 		 * Given a item_id (request parameter 'id') returns a list of ancestors for use in the hierarchy browser
 		 * Returned data is JSON format
 		 */
 		public function getFacetHierarchyAncestorList() {
 			$pn_id = $this->request->getParameter('id', pInteger);
 			$va_access_values = caGetUserAccessValues($this->request);
 			$ps_facet_name = $this->request->getParameter('facet', pString);
 			$this->view->setVar("facet_name", $ps_facet_name);
 			$this->view->setVar("key", $this->request->getParameter('key', pString));
 			$ps_browse_type = $this->request->getParameter('browseType', pString);
 			if (!($va_browse_info = caGetInfoForBrowseType($ps_browse_type))) {
 				// invalid browse type – throw error
 				die("Invalid browse type");
 			} 			
 			$this->view->setVar("browse_type", $ps_browse_type);
 			$vs_class = $va_browse_info['table'];
			$o_browse = caGetBrowseInstance($vs_class);
 			if(!is_array($va_facet_info = $o_browse->getInfoForFacet($ps_facet_name))) { return null; }
 			if ($ps_cache_key = $this->request->getParameter('key', pString)) {
				$o_browse->reload($ps_cache_key);
			}
 			
 			$va_ancestors = array();
 			switch($va_facet_info['type']) {
 				case 'attribute':
 					// is it a list attribute?
 					$t_element = new ca_metadata_elements();
 					if ($t_element->load(array('element_code' => $va_facet_info['element_code']))) {
 						if ($t_element->get('datatype') == 3) { // 3=list
							if (!$pn_id) {
 								$t_list = new ca_lists();
								$pn_id = $t_list->getRootListItemID($t_element->get('list_id'));
							}
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
								array_shift($va_ancestors);
							}
 						}
 					}
 					break;
 				case 'label':
 					// label facet
 					$va_facet_info['table'] = $this->ops_tablename;
 					// fall through to default case
 				default:
					$t_item = $this->request->datamodel->getInstanceByTableName($va_facet_info['table']);
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
					if ($vn_hierarchies_in_use <= 1) {
						array_shift($va_ancestors);
					}
					break;
			}
			
 			$this->view->setVar('ancestors', $va_ancestors);
 			
 			switch($this->request->getParameter('returnAs', pString)){
 				case "json":
 					return $this->render('Browse/facet_hierarchy_ancestors_json.php');
 				break;
 				# ------------------------------------------------
 				case "html":
 				default:
 					return $this->render('Browse/facet_hierarchy_ancestors_html.php');
 				break;
 				# ------------------------------------------------
 			}
 		}
 		# -------------------------------------------------------
		# Export
		# -------------------------------------------------------
		/**
		 * Generate  export file of current result
		 */
		protected function _genExport($po_result, $ps_output_type, $ps_output_filename, $ps_title=null) {
			//$this->view->setVar('criteria_summary', $vs_criteria_summary = $this->getCriteriaForDisplay());	// add displayable description of current search/browse parameters
			//$this->view->setVar('criteria_summary_truncated', mb_substr($vs_criteria_summary, 0, 60).((mb_strlen($vs_criteria_summary) > 60) ? '...' : ''));
			
			$this->opo_result_context->setParameter('last_export_type', $ps_output_type);
			$this->opo_result_context->saveContext();
			
			if(substr($ps_output_type, 0, 4) !== '_pdf') {
				switch($ps_output_type) {
					case '_xlsx':
						require_once(__CA_LIB_DIR__."/core/Parsers/PHPExcel/PHPExcel.php");
						require_once(__CA_LIB_DIR__."/core/Parsers/PHPExcel/PHPExcel/Writer/Excel2007.php");
						$vs_content = $this->render('Results/xlsx_results.php');
						return;
					case '_csv':
						$vs_delimiter = ",";
						$vs_output_file_name = mb_substr(preg_replace("/[^A-Za-z0-9\-]+/", '_', $ps_output_filename.'_csv'), 0, 30);
						$vs_file_extension = 'txt';
						$vs_mimetype = "text/plain";
						break;
					case '_tab':
						$vs_delimiter = "\t";	
						$vs_output_file_name = mb_substr(preg_replace("/[^A-Za-z0-9\-]+/", '_', $ps_output_filename.'_tab'), 0, 30);
						$vs_file_extension = 'txt';
						$vs_mimetype = "text/plain";
					default:
						// TODO add exporter code here
						break;
				}

				header("Content-Disposition: attachment; filename=export_".$vs_output_file_name.".".$vs_file_extension);
				header("Content-type: ".$vs_mimetype);
							
				// get display list
				self::Index(null, null);
				$va_display_list = $this->view->getVar('display_list');
			
				$va_rows = array();
			
				// output header
			
				$va_row = array();
				foreach($va_display_list as $va_display_item) {
					$va_row[] = $va_display_item['display'];
				}
				$va_rows[] = join($vs_delimiter, $va_row);
			
				$po_result->seek(0);
			
				$t_display = $this->view->getVar('t_display');
				while($po_result->nextHit()) {
					$va_row = array();
					foreach($va_display_list as $vn_placement_id => $va_display_item) {
						$vs_value = html_entity_decode($t_display->getDisplayValue($po_result, $vn_placement_id, array('convert_codes_to_display_text' => true, 'convertLineBreaks' => false)), ENT_QUOTES, 'UTF-8');

						// quote values as required
						if (preg_match("![^A-Za-z0-9 .;]+!", $vs_value)) {
							$vs_value = '"'.str_replace('"', '""', $vs_value).'"';
						}
						$va_row[] = $vs_value;
					}
					$va_rows[] = join($vs_delimiter, $va_row);
				}
			
				$this->opo_response->addContent(join("\n", $va_rows), 'view');	
			} else {
				//
				// PDF output
				//
				$va_template_info = caGetPrintTemplateDetails('results', substr($ps_output_type, 5));
				if (!is_array($va_template_info)) {
					$this->postError(3110, _t("Could not find view for PDF"),"BaseFindController->PrintSummary()");
					return;
				}
				
				try {
					$this->view->setVar('base_path', $vs_base_path = pathinfo($va_template_info['path'], PATHINFO_DIRNAME));
					$this->view->addViewPath(array($vs_base_path, "{$vs_base_path}/local"));
					
					$vs_content = $this->render($va_template_info['path']);
					$o_dompdf = new DOMPDF();
					$o_dompdf->load_html($vs_content);
					$o_dompdf->set_paper(caGetOption('pageSize', $va_template_info, 'letter'), caGetOption('pageOrientation', $va_template_info, 'portrait'));
					$o_dompdf->set_base_path(caGetPrintTemplateDirectoryPath('results'));
					$o_dompdf->render();
					$o_dompdf->stream(caGetOption('filename', $va_template_info, 'export_results.pdf'));
		
					$vb_printed_properly = true;
				} catch (Exception $e) {
					$vb_printed_properly = false;
					$this->postError(3100, _t("Could not generate PDF"),"BaseFindController->PrintSummary()");
				}
				return;			
			}		
		}
 		# ------------------------------------------------------------------
 		
 		# ------------------------------------------------------------------
 	}