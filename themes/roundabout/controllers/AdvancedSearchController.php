<?php
/* ----------------------------------------------------------------------
 * pawtucket2/app/controllers/AdvancedSearchController.php : controller for object search request handling - processes searches from advanced search forms
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
 	require_once(__CA_APP_DIR__.'/helpers/advancedSearchHelpers.php');
 	
 	class AdvancedSearchController extends BaseSearchController {
 		# -------------------------------------------------------
 		/**
 		 * Name of subject table (ex. for an object search this is 'ca_objects')
 		 */
 		protected $ops_tablename = 'ca_objects';
 		
 		/** 
 		 * Number of items per search results page
 		 */
 		protected $opa_items_per_page = array(12, 24, 36);
 		 
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
 		
 		protected $ops_find_type = 'advanced_search';
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);

 			JavascriptLoadManager::register('tabUI');
 			
 			// get configured items per page options, if specified
 			if ($va_items_per_page_for_ca_objects = $po_request->config->getList('items_per_page_options_for_ca_objects_search')) {
 				$this->opa_items_per_page = $va_items_per_page_for_ca_objects;
 			}
 			
 			// redirect user if not logged in
			if (($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn()))||($this->request->config->get('show_bristol_only')&&!($this->request->isLoggedIn()))) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            } elseif (($this->request->config->get('show_bristol_only'))&&($this->request->isLoggedIn())) {
            	$this->response->setRedirect(caNavUrl($this->request, "bristol", "Show", "Index"));
            }	
            
 			if (!($vs_search_target = $po_request->getParameter('target', pString))) {
 				$vs_search_target = $po_request->session->getVar('pawtucket2_adv_search_target');
 			}
 			
 			//
 			// Minimal view list (all targets have a "full" results view)
 			//
 			$this->opa_views = array(
				'full' => _t('List')
			);
			$this->opa_views_options = array(
				'full' => array("description" => _t("View results in a list"), "icon" => "icon_list.gif")
			);
 			
 			switch($vs_search_target) {
 				case 'ca_entities':
 					$this->opo_browse = new EntityBrowse($this->opo_result_context->getParameter('browse_id'), 'pawtucket2');
 					$this->ops_tablename = 'ca_entities';
 					
 					// get configured result views, if specified
					if ($va_result_views_for_ca_entities = $po_request->config->getAssoc('result_views_for_ca_entities')) {
						$this->opa_views = $va_result_views_for_ca_entities;
					}
					// get configured result views options, if specified
					if ($va_result_views_options_for_ca_entities = $po_request->config->getAssoc('result_views_options_for_ca_entities')) {
						$this->opa_views_options = $va_result_views_options_for_ca_entities;
					}
					
					// get configured result sort options, if specified
					if ($va_sort_options_for_ca_entities = $po_request->config->getAssoc('result_sort_options_for_ca_entities')) {
						$this->opa_sorts = $va_sort_options_for_ca_entities;
					}else{						
						$this->opa_sorts = array(
							'ca_entity_labels.displayname' => _t('Name'),
							'ca_entities.type_id' => _t('Type'),
							'ca_entities.idno_sort' => _t('Idno')
						);
					}
 					break;
 				case 'ca_places':
 					$this->opo_browse = new PlaceBrowse($this->opo_result_context->getParameter('browse_id'), 'pawtucket2');
 					$this->ops_tablename = 'ca_places';
 					
 					// get configured result views, if specified
					if ($va_result_views_for_ca_places = $po_request->config->getAssoc('result_views_for_ca_places')) {
						$this->opa_views = $va_result_views_for_ca_places;
					}
					// get configured result views options, if specified
					if ($va_result_views_options_for_ca_places = $po_request->config->getAssoc('result_views_options_for_ca_places')) {
						$this->opa_views_options = $va_result_views_options_for_ca_places;
					}
					// get configured result sort options, if specified
					if ($va_sort_options_for_ca_places = $po_request->config->getAssoc('result_sort_options_for_ca_places')) {
						$this->opa_sorts = $va_sort_options_for_ca_places;
					}else{						
						$this->opa_sorts = array(
							'ca_place_labels.name' => _t('Name'),
							'ca_places.type_id' => _t('Type'),
							'ca_places.idno_sort' => _t('Idno')
						);
					}
 					break;
 				case 'ca_occurrences':
 					$this->opo_browse = new OccurrenceBrowse($this->opo_result_context->getParameter('browse_id'), 'pawtucket2');
 					$this->ops_tablename = 'ca_occurrences';
 					
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
							'ca_occurrence_labels.name' => _t('Title'),
							'ca_occurrences.idno_sort' => _t('Idno')
						);
					}
 					break;
 				case 'ca_collections':
 					$this->opo_browse = new CollectionBrowse($this->opo_result_context->getParameter('browse_id'), 'pawtucket2');
 					$this->ops_tablename = 'ca_collections';
 					
 					// get configured result views, if specified
					if ($va_result_views_for_ca_collections = $po_request->config->getAssoc('result_views_for_ca_collections')) {
						$this->opa_views = $va_result_views_for_ca_collections;
					}
					// get configured result views options, if specified
					if ($va_result_views_options_for_ca_collections = $po_request->config->getAssoc('result_views_options_for_ca_collections')) {
						$this->opa_views_options = $va_result_views_options_for_ca_collections;
					}
					// get configured result sort options, if specified
					if ($va_sort_options_for_ca_collections = $po_request->config->getAssoc('result_sort_options_for_ca_collections')) {
						$this->opa_sorts = $va_sort_options_for_ca_collections;
					}else{						
						$this->opa_sorts = array(
							'ca_collection_labels.name' => _t('Name'),
							'ca_collections.type_id' => _t('Type'),
							'ca_collections.idno_sort' => _t('Idno')
						);
					}
 					break;
 				default:
 					$this->opo_browse = new ObjectBrowse($this->opo_result_context->getParameter('browse_id'), 'pawtucket2');	
 					// get configured result views, if specified
					if ($va_result_views_for_ca_objects = $po_request->config->getAssoc('result_views_for_ca_objects')) {
						$this->opa_views = $va_result_views_for_ca_objects;
					}else{
						$this->opa_views = array(
							'thumbnail' => _t('Thumbnails'),
							'full' => _t('List')
						 );
					}
					// get configured result views options, if specified
					if ($va_result_views_options_for_ca_objects = $po_request->config->getAssoc('result_views_options_for_ca_objects')) {
						$this->opa_views_options = $va_result_views_options_for_ca_objects;
					} else {
						$this->opa_views_options = array(
							'thumbnail' => array("description" => _t("View thumbnails with brief captions"), "icon" => "icon_thumbnail.gif"),
							'full' => array("description" => _t("View images with full captions"), "icon" => "icon_full.gif")
						 );
					}
					// get configured result sort options, if specified
					if ($va_sort_options_for_ca_objects = $po_request->config->getAssoc('result_sort_options_for_ca_objects')) {
						$this->opa_sorts = $va_sort_options_for_ca_objects;
					}else{
						$this->opa_sorts = array(
							'ca_object_labels.name' => _t('Title'),
							'ca_objects.type_id' => _t('Type'),
							'ca_objects.idno_sort' => _t('Idno')
						);
					}
					
					if($po_request->config->get("show_map_object_search_results")){
 						JavascriptLoadManager::register('maps');
						$this->opa_views['map'] = _t('Map');
						if(!$this->opa_views_options['map']){
							$this->opa_views_options['map'] = array("description" => _t("View results plotted on a map"), "icon" => "icon_map.gif");
						}
					}
 					break;
 			}
 			// set current result view options so can check we are including a configured result view
 			$this->view->setVar('result_views', $this->opa_views);
 			$this->view->setVar('result_views_options', $this->opa_views_options);
 			
 			if ($vs_search_target != $po_request->session->getVar('pawtucket2_adv_search_target')) {
				$this->opo_browse->removeAllCriteria();
			}
 			$po_request->session->setVar('pawtucket2_adv_search_target', $vs_search_target);
 			
 			$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
 			
 			if ($this->opn_type_restriction_id = $this->opo_result_context->getTypeRestriction($pb_type_restriction_has_changed)) {
 				$_GET['type_id'] = $this->opn_type_restriction_id;								// push type_id into globals so breadcrumb trail can pick it up
 				$this->opb_type_restriction_has_changed =  $pb_type_restriction_has_changed;	// get change status
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
 			if (!is_array($pa_options)) { $pa_options = array(); }
 			
 			$pa_form_codes = caGetAvailableAdvancedSearchFormCodes($this->ops_tablename);
 			$ps_form = $this->_getFormName();
 			
 			
 			$va_form_info = caGetSearchExpressionFromAdvancedSearchForm($_REQUEST);

			$is_restricted = $_POST['access'];
			
 			if (!($ps_search = $va_form_info['expression'])) {
 				$ps_search = $this->opo_result_context->getSearchExpression();
 			} else {
 				$this->opo_result_context->isNewSearch(true);
 				$this->opo_result_context->setParameter('form_data', $va_form_info['form_data']);
 			}
 			$this->opo_result_context->setSearchExpression($ps_search);
 			$this->opo_result_context->saveContext(true);
 			
 			return parent::Index($this->opo_browse, array_merge($pa_options, array('view' => 'Search/ca_objects_search_advanced_html.php', 'vars' => array('form' => $ps_form, 'form_codes' => $pa_form_codes, 'is_restricted' => $is_restricted))));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function getAdvancedSearchForm() {
 			$pa_form_codes = caGetAvailableAdvancedSearchFormCodes($this->ops_tablename);
 			$ps_form = $this->_getFormName();
 			
 			$va_form_info = caGetSearchExpressionFromAdvancedSearchForm($_REQUEST);
 			
 			$t_model = $this->opo_datamodel->getInstanceByTableName($this->ops_tablename, true);
			
			$this->view->setVar('t_subject', $t_model);
			$this->view->setVar('result_context', $this->opo_result_context);
 			$this->view->setVar('form', $ps_form);
 			$this->view->setVar('form_codes', $pa_form_codes);
 			$this->view->setVar('form_data', $va_form_info['form_data']);
 			$this->render('Search/search_advanced_controls_html.php');
 		}
 		# -------------------------------------------------------
		public function searchName($ps_mode='singular') {
 			return ($ps_mode == 'singular') ? _t('search') : _t('searches');
 		}
 		# -------------------------------------------------------
 		private function _getFormName() {
 			$pa_form_codes = caGetAvailableAdvancedSearchFormCodes($this->ops_tablename);
 			if (!($ps_form = $this->request->getParameter('form', pString)) || (!in_array($ps_form, $pa_form_codes))) {
 				if ((!($ps_form = $this->opo_result_context->getParameter('form'))) || (!in_array($ps_form, $pa_form_codes))) {
 					$ps_form = array_shift(array_values($pa_form_codes));
 				}
 			}
 			$this->opo_result_context->setParameter('form', $ps_form);
 			$this->opo_result_context->saveContext();
 			
 			return $ps_form;
 		}
		# ----------------------------------------------------------------------
	}
 ?>