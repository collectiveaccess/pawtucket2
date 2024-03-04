<?php
/* ----------------------------------------------------------------------
 * app/controllers/BrowseController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);

            $this->opo_config = caGetBrowseConfig();
            
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
 			
 			$user_id = $this->request->isLoggedIn() ? $this->request->getUserID() : null;

 			if (!($va_browse_info = caGetOption('browseInfo', $pa_args, caGetInfoForBrowseType($ps_function)))) {
 				// invalid browse type – throw error
 				throw new ApplicationException("Invalid browse type: $ps_function");
 			}
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Browse %1", $va_browse_info["displayName"]));
 			$this->view->setVar("browse_type", $ps_function);
 			$vs_class = $this->ops_tablename = $va_browse_info['table'];
			$t_instance = Datamodel::getInstance($vs_class, true);

			$items_per_page = caGetOption('itemsPerPage', $va_browse_info, 60, ['castTo' => 'int']);

 			// Now that table name is known we can set standard view vars
 			parent::setTableSpecificViewVars();
 			
 			$va_types = caGetOption('restrictToTypes', $va_browse_info, array(), array('castTo' => 'array'));
 			$vb_omit_child_records = caGetOption('omitChildRecords', $va_browse_info, [], array('castTo' => 'bool'));

			$vs_type_key = caMakeCacheKeyFromOptions($va_types);
			
			# --- row id passed when click back button on detail page - used to load results to and jump to last viewed item
			$this->view->setVar('row_id', $pn_row_id = $this->request->getParameter('row_id', pInteger));
 			
 			$this->opo_result_context = new ResultContext($this->request, $va_browse_info['table'], $this->ops_find_type);
 			
 			// Don't set last find when loading facet (or when the 'dontSetFind' request param is explicitly set)
 			// as some other controllers use this action and setting last find will disrupt ResultContext navigation 
 			// by setting it to "browse" when in fact a search (or some other context) is still in effect.
 			if (!$this->request->getParameter('getFacet', pInteger) && !$this->request->getParameter('dontSetFind', pInteger) && !caGetOption('dontSetFind', $pa_args, false)) {
 				$this->opo_result_context->setAsLastFind();
 			}
 			
 			$this->view->setVar('browseInfo', $va_browse_info);
 			$this->view->setVar('name', $va_browse_info['displayName']);
 			$this->view->setVar('options', caGetOption('options', $va_browse_info, array(), array('castTo' => 'array')));

			if (!($ps_view = $this->request->getParameter("view", pString, ['forcePurify' => true]))) {
 				$ps_view = $this->opo_result_context->getCurrentView();
 			}
 			if(!in_array($ps_view, ['images', 'list', 'pdf', 'xlsx', 'pptx'])) {
 					$ps_view = 'images';
 			}

 			caAddPageCSSClasses(array($vs_class, $ps_function));

			$vn_type_id = $t_instance->getTypeIDForCode($ps_type);
			
			$this->view->setVar('t_instance', $t_instance);
 			$this->view->setVar('table', $va_browse_info['table']);
 			$this->view->setVar('primaryKey', $t_instance->primaryKey());
		
			$this->view->setVar('browse', $o_browse = caGetBrowseInstance($vs_class));
			$this->view->setVar('views', caGetOption('views', $va_browse_info, array(), array('castTo' => 'array')));
			$this->view->setVar('view', $ps_view);

			$use_default_key = false;
			if (!($ps_cache_key = $this->request->getParameter('key', pString, ['forcePurify' => true]))) {
				if($use_default_key = $this->request->getParameter('useDefaultKey', pInteger)) {
					$ps_cache_key = Session::getVar("{$ps_function}_last_browse_id");
				}
			}

			//
			// Load existing browse if key is specified
			//
			if ($ps_cache_key) {
				$o_browse->reload($ps_cache_key);
			}

			if (is_array($va_types) && sizeof($va_types)) { $o_browse->setTypeRestrictions($va_types, array('dontExpandHierarchically' => caGetOption('dontExpandTypesHierarchically', $va_browse_info, false))); }
		
			//
			// Clear criteria if required
			//
			
			if ($vs_remove_criterion = $this->request->getParameter('removeCriterion', pString, ['forcePurify' => true])) {
				$o_browse->removeCriteria($vs_remove_criterion, array($this->request->getParameter('removeID', pString, ['forcePurify' => true])));
			}
			
			if ((bool)$this->request->getParameter('clear', pInteger)) {
				$o_browse->removeAllCriteria();
			}
			
			//
			// Return content for specific facet
			//	
			if ($this->request->getParameter('getFacet', pInteger)) {
				$f = $this->getFacet($o_browse);
				$this->view->setVar('data', $f);
				return $this->render($this->ops_view_prefix."/browse_data_json.php");
			}

			//
			// Return list of available facets
			//
			if ($this->request->getParameter('getFacetList', pInteger)) {
				$this->view->setVar('data', $o_browse->getFacetList());
				return $this->render($this->ops_view_prefix."/browse_data_json.php");
			}
			//
			// Return browse result
			//
			if ($this->request->getParameter('getResult', pInteger)) {
				// Get any preset-criteria
				$va_base_criteria = caGetOption('baseCriteria', $va_browse_info, null);

				if (($vs_facets = $this->request->getParameter('facets', pString, ['forcePurify' => true])) && is_array($va_facets = explode(';', $vs_facets)) && sizeof($va_facets)) {
					if($use_default_key) { $o_browse->removeAllCriteria(); }
					foreach ($va_facets as $vs_facet_spec) {
						if (!sizeof($va_tmp = explode(':', $vs_facet_spec))) {
							continue;
						}
						$vs_facet = array_shift($va_tmp);
						$o_browse->addCriteria($vs_facet, explode("|", join(":", $va_tmp)));
					}
				} elseif (($vs_facet = $this->request->getParameter('facet', pString, ['forcePurify' => true])) && is_array($p = array_filter(explode('|', trim($this->request->getParameter('id', pString, ['forcePurify' => true]))), function ($v) {
						return strlen($v);
					})) && sizeof($p)) {
					if($use_default_key) { $o_browse->removeAllCriteria(); }
					$o_browse->addCriteria($vs_facet, $p);
				} else {
					if ($o_browse->numCriteria() == 0) {
						if (is_array($va_base_criteria)) {
							foreach ($va_base_criteria as $vs_facet => $vs_value) {
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
				if (!($ps_sort = urldecode($this->request->getParameter("sort", pString, ['forcePurify' => true])))) {
					$ps_sort = $this->opo_result_context->getCurrentSort();
				} elseif ($ps_sort != $this->opo_result_context->getCurrentSort()) {
					$vb_sort_changed = true;
				}
				
				if (preg_match("!^ca_set_items.rank/([\d]+)$!", $ps_sort)) {
					// we have a set
					$vb_sort_changed = true;
				} else {
					if (is_array($va_sorts = caGetOption('sortBy', $va_browse_info, null))) {
						if (!$ps_sort || (!in_array($ps_sort, array_keys($va_sorts)))) {
							$ps_sort = array_shift(array_keys($va_sorts));
							$vb_sort_changed = true;
						}
					}
				}
				if ($vb_sort_changed) {
					# --- set the default sortDirection if available
					$va_sort_direction = caGetOption('sortDirection', $va_browse_info, null);
					if ($ps_sort_direction = $va_sort_direction[$ps_sort]) {
						$this->opo_result_context->setCurrentSortDirection($ps_sort_direction);
					}
				}
				if (!($ps_sort_direction = strtolower($this->request->getParameter("direction", pString, ['forcePurify' => true])))) {
					if (!($ps_sort_direction = $this->opo_result_context->getCurrentSortDirection())) {
						$ps_sort_direction = 'asc';
					}
				}
				if (!in_array($ps_sort_direction, ['asc', 'desc'])) {
					$ps_sort_direction = 'asc';
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

				$vb_expand_results_hierarchically = caGetOption('expandResultsHierarchically', $va_browse_info, array(), array('castTo' => 'bool'));

				$o_browse->execute(array('noCache' => caGetOption('noCache', $pa_args, false), 'checkAccess' => $this->opa_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => true, 'expandResultsHierarchically' => $vb_expand_results_hierarchically, 'omitChildRecords' => $vb_omit_child_records, 'omitChildRecordsForTypes' => caGetOption('omitChildRecordsForTypes', $va_browse_info, null), 'excludeFieldsFromSearch' => caGetOption('excludeFieldsFromSearch', $va_browse_info, null)));

				//
				// Facets
				//
				if ($vs_facet_group = caGetOption('facetGroup', $va_browse_info, null)) {
					$o_browse->setFacetGroup($vs_facet_group);
				}

				$va_facets = $o_browse->getInfoForAvailableFacets(['checkAccess' => $this->opa_access_values, 'request' => $this->request]);
				foreach ($va_facets as $vs_facet_name => $va_facet_info) {
					if (isset($va_base_criteria[$vs_facet_name])) {
						continue;
					} // skip base criteria
					$va_facets[$vs_facet_name]['content'] = $o_browse->getFacet($vs_facet_name, array('checkAccess' => $this->opa_access_values, 'request' => $this->request, 'checkAvailabilityOnly' => caGetOption('deferred_load', $va_facet_info, false, array('castTo' => 'bool'))));
				}
				$this->view->setVar('facets', $va_facets);

				// remove base criteria from display list
				if (is_array($va_base_criteria)) {
					foreach ($va_base_criteria as $vs_base_facet => $vs_criteria_value) {
						unset($va_criteria[$vs_base_facet]);
					}
				}

				$va_criteria_for_display = array();
				foreach ($va_criteria as $vs_facet_name => $va_criterion) {
					$va_facet_info = $o_browse->getInfoForFacet($vs_facet_name);
					foreach ($va_criterion as $vn_criterion_id => $vs_criterion) {
						$va_criteria_for_display[] = array('facet' => $va_facet_info['label_singular'], 'facet_name' => $vs_facet_name, 'value' => $vs_criterion, 'id' => $vn_criterion_id);
					}
				}
				$this->view->setVar('criteria', $va_criteria_for_display);

				//
				// Results
				//
				$vs_sort_fld = $va_sort_by[$ps_sort] ? $va_sort_by[$ps_sort] : $ps_sort;
				$qr_res = $o_browse->getResults(array('sort' => $vs_sort_fld, 'sort_direction' => $ps_sort_direction));

				$this->view->setVar('result', $qr_res);
				if(!in_array($ps_view, array('pdf', 'xlsx', 'pptx'))){
					if (!($pn_hits_per_block = $this->request->getParameter("n", pString, ['forcePurify' => true]))) {
						if (!($pn_hits_per_block = $this->opo_result_context->getItemsPerPage())) {
							$pn_hits_per_block = $this->opo_config->get("defaultHitsPerBlock");
						}
					}
					$this->opo_result_context->setItemsPerPage($pn_hits_per_block);

					$this->view->setVar('hits_per_block', $pn_hits_per_block);
					$this->view->setVar('start', $start = (int)$this->request->getParameter('s', pInteger));

					$vs_key = $o_browse->getBrowseID();

					$last_browse_start = $start;
					if($vs_key === $ps_cache_key) {
						$last_browse_start = Session::getVar("{$ps_function}_last_browse_start");
						if ($start > $last_browse_start) {
							Session::setVar("{$ps_function}_last_browse_start", $start);
						}
					} else{
						Session::setVar($qr_res->tableName().'_last_detail_id', null);
						Session::setVar("{$ps_function}_last_browse_start", 0);
					}

					if (($vn_key_start = $start - 1000) < 0) {
						$vn_key_start = 0;
					}
					$qr_res->seek($vn_key_start);
					$this->opo_result_context->setResultList($qr_res->getPrimaryKeyValues(1000));
					$qr_res->seek($start);

					$criteria = $o_browse->getCriteriaWithLabels();
					$facet_info = $o_browse->getInfoForFacets();

					$data = [
						'lastStart' => $last_browse_start,
						'lastViewedID' => Session::getVar($qr_res->tableName().'_last_detail_id'),
						'size' => $qr_res->numHits(),
						'key' => $vs_key,
						'hitsStart' => $start,
						'start' => ($last_browse_start >= $items_per_page) ? $last_browse_start + $items_per_page : $start,
						'itemsPerPage' => $items_per_page,
						'table' => $qr_res->tableName(),
						'pk' => $qr_res->primaryKey(),
						'hits' => [],
						'availableFacets' => $o_browse->getInfoForAvailableFacets(),
						'facetList' => $facet_info,
						'criteria' => $criteria,
						'baseCriteria' => $va_base_criteria,
						'labelSingular' => $va_browse_info['labelSingular'],
						'labelPlural' => $va_browse_info['labelPlural'],
						'sort' => $ps_sort,
						'sortDirection' => $ps_sort_direction
					];

					if (($intro = caGetOption('introduction', $va_browse_info, caGetOption('introduction', $pa_args, null))) && is_array($intro)) {
						// Look for facets
						$intro_set = false;

						// Substitute global vars
						$global_vars = caGetGlobalValuesAsArray();
						foreach($global_vars as $k => $v) {
							$global_vars["_global_var.{$k}"] = $v;
						}

						if(caGetOption('introduction', $pa_args, null)) {
							$intro_set = true;
							$data['introduction']['title'] = caGetOption('title', $intro, null);
							$data['introduction']['description'] = caGetOption('description', $intro, null);
						} else {
							foreach ($intro as $k => $v) {
								if (!isset($criteria[$k])) {
									continue;
								}
								if ($facet_info[$k]['type'] !== 'authority') {
									continue;
								}
								if (!is_array($criteria[$k])) {
									continue;
								}
								$id = array_pop(array_keys($criteria[$k]));

								if (($t_instance = Datamodel::getInstance($facet_info[$k]['table'], true)) && ($t_instance->load($id)) && in_array($t_instance->get('access'), $this->opa_access_values)) {
									$title_template = caProcessTemplate($intro[$k]['title'], $global_vars, ['skipTagsWithoutValues' => true]);
									$description_template = caProcessTemplate($intro[$k]['description'], $global_vars, ['skipTagsWithoutValues' => true]);

									$data['introduction']['title'] = $t_instance->getWithTemplate($title_template, ['checkAccess' => $this->opa_access_values]);
									$data['introduction']['description'] = $t_instance->getWithTemplate($description_template, ['checkAccess' => $this->opa_access_values]);

									$intro_set = true;
									break;
								}
							}
						}
						if (!$intro_set) {
							$data['introduction']['title'] = caProcessTemplate(caGetOption('title', $intro, ''), $global_vars);
							$data['introduction']['description'] = caProcessTemplate(caGetOption('description', $intro, ''), $global_vars);
						}
					}

					$c = 0;

					$table = $qr_res->tableName();
					$idno_fld= $qr_res->getInstance(true)->getProperty('ID_NUMBERING_ID_FIELD');

					if (($last_browse_start >= $items_per_page) && ($start == 0)) { $items_per_page = $last_browse_start + ($items_per_page * 2); }	// return all results up to and including currrent page
					while($qr_res->nextHit()) {
						$d = [
							'id' => $id = $qr_res->getPrimaryKey(),
							'label' => html_entity_decode($qr_res->get('preferred_labels')),
							'idno' => $qr_res->get($idno_fld),
							'detailUrl' => caDetailUrl($table, $id)
						];
						
						$submitter_id = $qr_res->get('submission_user_id');

						// TODO: this is hardcoded to use view "images" until we add support for multiple view types
						if(is_array($va_browse_info['views']['images'])) {
							foreach($va_browse_info['views']['images'] as $k => $tmpl) {
								$d[$k] = $qr_res->getWithTemplate($tmpl, ['checkAccess' => (($submitter_id > 0) && ($submitter_id == $user_id)) ? null : $this->opa_access_values]);
							}
						}

						$data['hits'][] = $d;
						$c++;
						if ($c >= $items_per_page) { break; }
					}
					$this->view->setVar('data', $data);

					Session::setVar("{$ps_function}_last_browse_id", $vs_key = $o_browse->getBrowseID());
					Session::save();
					$this->opo_result_context->setParameter('key', $vs_key);
					$this->opo_result_context->saveContext();
					return $this->render($this->ops_view_prefix."/browse_data_json.php");
				}
			}
			switch($ps_view) {
 				case 'xlsx':
 				case 'pptx':
 				case 'pdf':
 					# --- only downloading hand selected items from results?
 					if($record_ids = $this->request->getParameter('record_ids', pString)){
 						$record_ids = explode(";", $record_ids);
 						$qr_res = caMakeSearchResult($vs_class, $record_ids);
 					}		
 					$this->_genExport($qr_res, $this->request->getParameter("export_format", pString, ['forcePurify' => true]), caGenerateDownloadFileName(caGetOption('pdfExportTitle', $va_browse_info, $ps_search_expression)), $this->getCriteriaForDisplay($o_browse));
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
 			$ps_target = $this->request->getParameter('target', pString, ['forcePurify' => true]);
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
