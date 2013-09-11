<?php
/* ----------------------------------------------------------------------
 * app/controllers/SearchController.php : controller for object search request handling - processes searches from top search bar
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
 	require_once(__CA_LIB_DIR__."/ca/BaseSearchController.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/ObjectBrowse.php");
	require_once(__CA_LIB_DIR__."/ca/Search/DidYouMean.php");
	require_once(__CA_LIB_DIR__."/core/Datamodel.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/ObjectSearch.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/EntitySearch.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/PlaceSearch.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/OccurrenceSearch.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/CollectionSearch.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/ObjectBrowse.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/EntityBrowse.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/PlaceBrowse.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/CollectionBrowse.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/OccurrenceBrowse.php");
 	require_once(__CA_LIB_DIR__.'/core/GeographicMap.php');
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	
 	class SearchController extends BaseSearchController {
 		# -------------------------------------------------------
 		/**
 		 * Name of subject table (ex. for an object search this is 'ca_objects')
 		 */
 		protected $ops_tablename = null;
 		
 		/** 
 		 * Number of items per search results page
 		 */
 		protected $opa_items_per_page = array(12, 24, 36);
 		
 		/** 
 		 * Default number of items per search results page
 		 */
 		protected $opn_items_per_page_default = 12;
 		 
 		/** 
 		 * Number of items per secondary search results page
 		 */
 		protected $opa_items_per_secondary_search_page = 8;
 		 
 		/**
 		 * List of search-result views supported for this find
 		 * Is associative array: keys are view labels, values are view specifier to be incorporated into view name
 		 */ 
 		protected $opa_views;
 		
 		/**
 		 * List of search-result view options
 		 * Is associative array: keys are view labels, arrays for each view contain description and icon graphic name for use in view
 		 */ 
 		protected $opa_views_options;
 		 
 		 
 		/**
 		 * List of available search-result sorting fields
 		 * Is associative array: values are display names for fields, keys are full fields names (table.field) to be used as sort
 		 */
 		protected $opa_sorts;
 		
 		protected $ops_find_type = 'basic_search';
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			
 			
 			//
 			// Minimal view list (all targets have a "full" results view)
 			//
 			$this->opa_views = array(
				'full' => _t('List')
			);
			$this->opa_views_options = array(
				'full' => array("description" => _t("View results in a list"), "icon" => "icon_list.gif")
			);
 			
 					$this->ops_tablename = 'ca_objects';
 					$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
 					$this->opo_browse = new ObjectBrowse($this->opo_result_context->getParameter('browse_id', true), 'pawtucket2');	
 					
						$this->opa_views = array(
							'thumbnail' => _t('Thumbnails'),
							'full' => _t('List')
						 );
					
						$this->opa_sorts = array(
							'ca_object_labels.name' => _t('Title'),
							'ca_objects.type_id' => _t('Type'),
							'ca_objects.idno_sort' => _t('Idno')
						);
 		}
 		# -------------------------------------------------------
 		/**
 		 * Search handler (returns search form and results, if any)
 		 * Most logic is contained in the BaseSearchController->Search() method; all you usually
 		 * need to do here is instantiate a new subject-appropriate subclass of BaseSearch 
 		 * (eg. ObjectSearch for objects, EntitySearch for entities) and pass it to BaseSearchController->Search() 
 		 */ 
 		public function Index($pa_options=null) {
 			$ps_search = $this->opo_result_context->getSearchExpression();
 			$va_access_values = caGetUserAccessValues($this->request);
 			$pa_options['search'] = $this->opo_browse;
 			return parent::Index($pa_options);
 		}
 		# -------------------------------------------------------
		public function searchName($ps_mode='singular') {
 			return ($ps_mode == 'singular') ? _t('search') : _t('searches');
 		}
		# -------------------------------------------------------
	}
 ?>