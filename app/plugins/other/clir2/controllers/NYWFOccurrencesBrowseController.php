<?php
/* ----------------------------------------------------------------------
 * controllers/NYWFOccurrenceBrowseController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011 Whirl-i-Gig
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
 
 
 	require_once(__CA_LIB_DIR__."/ca/BaseBrowseController.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/OccurrenceBrowse.php");
 
 	class NYWFOccurrencesBrowseController extends BaseBrowseController {
 		# -------------------------------------------------------
 		 /** 
 		 * Name of table for which this browse returns items
 		 */
 		 protected $ops_tablename = 'ca_occurrences';
 		 
 		/** 
 		 * Number of items per results page
 		 */
 		protected $opa_items_per_page = array(12, 24, 36);
 		
 		/** 
 		 * Default number of items per search results page
 		 */
 		protected $opn_items_per_page_default = 12;
 		 
 		/**
 		 * List of result views supported for this browse
 		 * Is associative array: keys are view labels, values are view specifier to be incorporated into view name
 		 */ 
 		protected $opa_views;
 		
 		/**
 		 * List of search-result view options
 		 * Is associative array: keys are view labels, arrays for each view contain description and icon graphic name for use in view
 		 */ 
 		protected $opa_views_options;
 		 
 		 
 		/**
 		 * List of available result sorting fields
 		 * Is associative array: values are display names for fields, keys are full fields names (table.field) to be used as sort
 		 */
 		protected $opa_sorts;
 		
 		
 		protected $ops_find_type = 'nywf_occurences_browse';
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
			$this->opo_browse = new OccurrenceBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
			
			//
			// SET FACET GROUP
			//
			$this->opo_browse->setFacetGroup("nywf");
			
			//
			// ADD "curatorial_selection" CRITERIA IF IT'S A NEW BROWSE
			//
			$this->addCuratorialSelectionFacet();
			
			// get configured result views, if specified
			if ($va_result_views_for_ca_occurrences = $po_request->config->getAssoc('result_views_for_ca_occurrences')) {
				$this->opa_views = $va_result_views_for_ca_occurrences;
			}
			// get configured result views options, if specified
			if ($va_result_views_options_for_ca_occurrences = $po_request->config->getAssoc('result_views_options_for_ca_occurrences')) {
				$this->opa_views_options = $va_result_views_options_for_ca_occurrences;
			}
			// get configured result sort options, if specified
			if ($va_sort_options_for_ca_occurrences = $po_request->config->getAssoc('result_sort_options_for_ca_occurrences')) {
				$this->opa_sorts = $va_sort_options_for_ca_occurrences;
			}else{
				$this->opa_sorts = array(
					'ca_occurrence_labels.name' => _t('Name'),
					'ca_occurrences.type_id' => _t('Type'),
					'ca_occurrences.idno_sort' => _t('Idno')
				);
			}
 				// get configured items per page options, if specified
 			if ($va_items_per_page = $po_request->config->getList('items_per_page_options_for_'.$vs_browse_target.'_browse')) {
 				$this->opa_items_per_page = $va_items_per_page;
 			}
 			if (($vn_items_per_page_default = (int)$po_request->config->get('items_per_page_default_for_'.$this->ops_tablename.'_browse')) > 0) {
				$this->opn_items_per_page_default = $vn_items_per_page_default;
			} else {
				$this->opn_items_per_page_default = $this->opa_items_per_page[0];
			}
 			
 			// set current result view options so can check we are including a configured result view
 			$this->view->setVar('result_views', $this->opa_views);
 			$this->view->setVar('result_views_options', $this->opa_views_options);
 			
 			if ($this->opn_type_restriction_id = $this->opo_result_context->getTypeRestriction($pb_type_restriction_has_changed)) {
 				$_GET['type_id'] = $this->opn_type_restriction_id;								// push type_id into globals so breadcrumb trail can pick it up
 				$this->opb_type_restriction_has_changed =  $pb_type_restriction_has_changed;	// get change status
 			}
 		}
 		# -------------------------------------------------------
		public function browseName($ps_mode='singular') {
 			return ($ps_mode == 'singular') ? _t('New York World\'s Fair Films Browse') : _t('New York World\'s Fair Films Browses');
 		}
 		# -------------------------------------------------------
 		public function clearCriteria() {
 			$this->opo_browse->removeAllCriteria();
 			$this->addCuratorialSelectionFacet();
 			$this->Index();
 		}
 		# -------------------------------------------------------
 		public function clearAndAddCriteria() {
 			$this->opo_browse->removeAllCriteria();
			
			$this->addCuratorialSelectionFacet();
			
 			$ps_facet_name = $this->request->getParameter('facet', pString);
 			$this->opo_browse->addCriteria($ps_facet_name, array($this->request->getParameter('id', pString)));
 			$this->Index();
 		}
 		# -------------------------------------------------------
 		public function removeCriteria() {
 			$ps_facet_name = $this->request->getParameter('facet', pString);
 			$this->opo_browse->removeCriteria($ps_facet_name, array($this->request->getParameter('id', pString)));
 			$this->addCuratorialSelectionFacet();
 				
 			$this->Index();
 		}
 		# -------------------------------------------------------
 		private function addCuratorialSelectionFacet() {
 			//
			// ADD "curatorial_selection" CRITERIA IF IT'S A NEW BROWSE
			//
 			if ($this->opo_browse->numCriteria() == 0) {
				$t_list = new ca_lists();
				$vn_curatorial_selection_id = $t_list->getItemIDFromList('curatorial_selection2', 'NYWF');
				$this->opo_browse->addCriteria('curatorial_selection_facet', array($vn_curatorial_selection_id));
			}
 		}
 		# -------------------------------------------------------
 	}
 ?>