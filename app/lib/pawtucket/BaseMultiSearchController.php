<?php
/* ----------------------------------------------------------------------
 * app/lib/pawtucket/BaseMultiSearchController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
 	require_once(__CA_APP_DIR__.'/helpers/searchHelpers.php');
 	require_once(__CA_LIB_DIR__.'/ResultContext.php');
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
 	abstract class BaseMultiSearchController extends BasePawtucketController {
 		# -------------------------------------------------------
 		/**
 		 * 
 		 */
 		protected $ops_find_type = 'multisearch';
 		
 		/**
 		 * 
 		 */
 		protected $opa_result_contexts = array();
 		
 		/**
 		 * List of searches to execute
 		 */
 		protected $opa_search_blocks = array();
 		
 		/**
 		 * Search configuation file
 		 */
 		protected $config = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			$this->config = Configuration::load(__CA_THEME_DIR__.'/conf/search.conf');
 			$this->opa_search_blocks = $this->config->getAssoc('multisearchTypes');
 			
 			// Create result context for each block
 			$va_tables = array();
 			foreach($this->opa_search_blocks as $vs_block => $va_block_info) {
 				$va_tables[$va_block_info['table']] = 1;
 				$this->opa_result_contexts[$vs_block] = new ResultContext($po_request, $va_block_info['table'], $this->ops_find_type, $vs_block);
 				$this->opa_result_contexts[$vs_block]->setAsLastFind(false);
 			}
 			
 			// Create generic contexts for each table in multisearch (no specific block); used to house search history and overall counts
 			// when there is more than one block for a given table
 			foreach(array_keys($va_tables) as $vs_table) {
 				$this->opa_result_contexts["_multisearch_{$vs_table}"] = new ResultContext($po_request, $vs_table, $this->ops_find_type);
 			}
 		}
 		# -------------------------------------------------------
 		/**
 		 * Search handler (returns search form and results, if any)
 		 * Most logic is contained in the BaseSearchController->Search() method; all you usually
 		 * need to do here is instantiate a new subject-appropriate subclass of BaseSearch 
 		 * (eg. ObjectSearch for objects, EntitySearch for entities) and pass it to BaseSearchController->Search() 
 		 */ 
 		public function Index($pa_options=null) {
 			if (!is_array($this->opa_result_contexts) || !sizeof($this->opa_result_contexts)) { 
 				// TODO: throw error - no searches are defined
 				return false;
 			}
 			
 			$o_first_result_context = array_shift(array_values($this->opa_result_contexts));
 			
 			$vs_search = $o_first_result_context->getSearchExpression();
 			
 			if ($ps_label = $this->request->getParameter('label', pString, ['forcePurify' => true])) {
				$o_first_result_context->setSearchExpressionForDisplay("{$ps_label}: ".caGetDisplayStringForSearch($vs_search, ['omitFieldNames' => true]));
 			} else {
 			    $o_first_result_context->setSearchExpressionForDisplay(caGetDisplayStringForSearch($vs_search)); 
 			}
 			$vs_search_display = $o_first_result_context->getSearchExpressionForDisplay();
 			
 			$this->view->setVar('search', $vs_search);
 			$this->view->setVar('searchForDisplay', $vs_search_display);
 			$this->view->setVar("config", $this->config);
 			$this->view->setVar('blocks', $this->opa_search_blocks);
 			$this->view->setVar('blockNames', array_keys($this->opa_search_blocks));
 			$this->view->setVar('results', $va_results = caPuppySearch($this->request, $vs_search, $this->opa_search_blocks, array('access' => $this->opa_access_values, 'contexts' => $this->opa_result_contexts, 'matchOnStem' => (bool)$this->config->get('matchOnStem'))));
 			
 			if ($this->request->isAjax() && ($vs_block = $this->request->getParameter('block', pString, ['forcePurify' => true]))) { 
 				if (!isset($va_results[$vs_block]['html'])) {
 					// TODO: throw error - no results
 					return false;
 				}
 				$this->response->addContent($va_results[$vs_block]['html']); 
 				
				if (($o_context = $this->opa_result_contexts[$vs_block])) {
					if (isset($va_results[$vs_block]['sort'])) { $o_context->setCurrentSort($va_results[$vs_block]['sort']); }
					if (isset($va_results[$vs_block]['sortDirection'])) { $o_context->setCurrentSortDirection($va_results[$vs_block]['sortDirection']); }
					$o_context->setResultList(is_array($va_results[$vs_block]['ids']) ? $va_results[$vs_block]['ids'] : array());
					$o_context->saveContext();
				}
 				return; 
 			} 
 			
 			$vn_result_count = 0;
 			$vs_redirect_to_only_result = null;
 			
 			$va_context_list = [];
 			foreach($this->opa_result_contexts as $vs_block => $o_context) {
 				$o_context->setParameter('search', $vs_search);
 				$va_context_list[$o_context->tableName()][$o_context->findType()] = $vs_search;
 				if (!isset($va_results[$vs_block]['ids']) || !is_array($va_results[$vs_block]['ids'])) { continue; }
 				$o_context->setResultList(is_array($va_results[$vs_block]['ids']) ? $va_results[$vs_block]['ids'] : array());
 				if($va_results[$vs_block]['sort']) { $o_context->setCurrentSort($va_results[$vs_block]['sort']); }
				if (isset($va_results[$vs_block]['sortDirection'])) { $o_context->setCurrentSortDirection($va_results[$vs_block]['sortDirection']); }
 				$o_context->saveContext();
 				
 				$vn_result_count += sizeof($va_results[$vs_block]['ids']);
 				
 				if ((sizeof($va_results[$vs_block]['ids']) == 1) && ($vn_result_count == 1) && (!$this->config->get('dont_redirect_to_single_search_result'))) {
 					$vs_redirect_to_only_result = caDetailUrl($this->request, $va_results[$vs_block]['table'], $va_results[$vs_block]['ids'][0], false);
 				}
 			}
 			
 			foreach($va_context_list as $table => $l) {
 			    foreach($l as $type => $s) {
 			        $o_context = new ResultContext($this->request, $table, $type);
 			        $o_context->setParameter('search', $s);
 			        $o_context->saveContext();
 			    }
 			}
 			
 			if (($vn_result_count == 1) && ($vs_redirect_to_only_result)) {
 				$this->response->setRedirect($vs_redirect_to_only_result);
 				return;
 			}
 			
 			$this->render('Search/multisearch_results_html.php');
 		}
 		# -------------------------------------------------------
 		abstract public static function getReturnToResultsUrl($po_request);
 		# -------------------------------------------------------
 	}