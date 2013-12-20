<?php
/* ----------------------------------------------------------------------
 * app/lib/pawtucket/BaseMultiSearchController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 	require_once(__CA_LIB_DIR__.'/ca/ResultContext.php');
 
 	class BaseMultiSearchController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 * 
 		 */
 		protected $ops_find_type = 'basic_search';
 		
 		/**
 		 * 
 		 */
 		protected $opa_result_contexts = array();
 		
 		/**
 		 * List of searches to execute
 		 */
 		protected $opa_search_blocks = array();
 		
 		/**
 		 *
 		 */
 		protected $opa_access_values = array();
 		
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
 			foreach($this->opa_search_blocks as $vs_block => $va_block_info) {
 				$this->opa_result_contexts[$vs_block] = new ResultContext($po_request, $va_block_info['table'], $this->ops_find_type.'_'.$vs_block);
 			}
 			
 			$this->opa_access_values = caGetUserAccessValues($po_request);
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
 			
 			$this->view->setVar('search', $vs_search);
 			$this->view->setVar('blocks', $this->opa_search_blocks);
 			$this->view->setVar('blockNames', array_keys($this->opa_search_blocks));
 			$this->view->setVar('results', caPuppySearch($this->request, $vs_search, $this->opa_search_blocks, array('access' => $this->opa_access_values)));
 			
 			$this->render('Search/search_results_html.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>