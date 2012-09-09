<?php
/* ----------------------------------------------------------------------
 * includes/BrowseController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
 	require_once(__CA_LIB_DIR__."/ca/Browse/ObjectBrowse.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/EntityBrowse.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/PlaceBrowse.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/CollectionBrowse.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/OccurrenceBrowse.php");
 	require_once(__CA_LIB_DIR__.'/core/GeographicMap.php');
 
 	class BrowseController extends BaseBrowseController {
 		# -------------------------------------------------------
 		 /** 
 		 * Name of table for which this browse returns items
 		 */
 		 protected $ops_tablename = null;
 		 
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
 		
 		
 		protected $ops_find_type = 'basic_browse';
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			//
 			// Get browse target
 			//
 			$va_browse_targets = $this->request->config->getList('browse_targets');
 			if (!($vs_browse_target = $po_request->getParameter('target', pString)) || ($vs_browse_target == 'null')) {
 				if (!($vs_browse_target = $po_request->session->getVar('pawtucket2_browse_target'))) {
 					if (is_array($va_browse_targets)) {
 						$vs_browse_target = array_shift($va_browse_targets);
 					}
 				}
 			}
 			
 			$va_target_list = array();
 			foreach($this->request->config->getList('browse_targets') as $vs_target) {
 				$va_tmp = explode(":", $vs_target);
 				$va_target_list[$vs_target] = caGetBrowseInstance($va_tmp[0]);
 				if (sizeof($va_tmp) > 1) {
 					$va_target_list[$vs_target]->setTypeRestrictions(array($va_tmp[1]));
 				}
 				
 				if ($vs_facet_group = $po_request->config->get($va_tmp[0].'_browse_facet_group')) {
 					$va_target_list[$vs_target]->setFacetGroup($vs_facet_group);
 				}
 			}
 			$this->view->setVar('targets', $va_target_list);
 			
 			// redirect user if not logged in
			if (($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn()))||($this->request->config->get('show_bristol_only')&&!($this->request->isLoggedIn()))) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            } elseif (($this->request->config->get('show_bristol_only'))&&($this->request->isLoggedIn())) {
            	$this->response->setRedirect(caNavUrl($this->request, "bristol", "Show", "Index"));
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
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			$this->view->setVar('access_values', $va_access_values);
			//
 			// Set up for browse target
 			//
 			$va_tmp = explode(":", $vs_browse_target);
 			switch($va_tmp[0]) {
 				case 'ca_entities':
 					$this->ops_tablename = 'ca_entities';
 					$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
 					$this->opo_browse = new EntityBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
 					
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
 					$this->ops_tablename = 'ca_places';
 					$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
 					$this->opo_browse = new PlaceBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
 					
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
 					$this->ops_tablename = 'ca_occurrences';
 					$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
 					$this->opo_browse = new OccurrenceBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
 					
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
 					$this->ops_tablename = 'ca_collections';
 					$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
 					$this->opo_browse = new CollectionBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
 					
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
 					$this->ops_tablename = 'ca_objects';
 					$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
 					$this->opo_browse = new ObjectBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');	
 					
 					// get configured result views, if specified
					if ($va_result_views_for_ca_objects = $po_request->config->getAssoc('result_views_for_ca_objects')) {
						$this->opa_views = $va_result_views_for_ca_objects;
					} else {
						$this->opa_views = array(
							'full' => _t('List'),
							'thumbnail' => _t('Thumbnails')
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
 			
 			// if target changes we need clear out all browse criteria as they are no longer valid
 			if ($vs_browse_target != $po_request->session->getVar('pawtucket2_browse_target')) {
				$this->opo_browse->removeAllCriteria();
			}
			
 			
 			if ($va_tmp[1]) {	// set type restriction off of target
 				$this->opo_result_context->setTypeRestriction($va_tmp[1]);
 			}
			
			// Set up target vars and controls
 			$po_request->session->setVar('pawtucket2_browse_target', $vs_browse_target);
 			
 			if (sizeof($va_browse_targets = $this->request->config->getList('browse_targets')) > 1) {
				$va_browse_options = array();
				foreach($va_browse_targets as $vs_possible_browse_target) {
					if ($vs_browse_target_name = $this->opo_browse->getBrowseSubjectName($vs_possible_browse_target)) {
						$va_browse_options[$vs_browse_target_name] = $vs_possible_browse_target;
					}
				}
				$this->view->setVar('browse_selector',  "<form action='#'>".caHTMLSelect('target', $va_browse_options, array('id' => 'caBrowseTargetSelectorSelect', 'onchange' => 'window.location = \''.caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'Index', array('target' => '')).'\' + jQuery(\'#caBrowseTargetSelectorSelect\').val();'), array('value' => $vs_browse_target, 'dontConvertAttributeQuotesToEntities' => true))."</form>\n");
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
 		/**
 		 * Override browse index to check if we need to honor the "use_splash_page_for_start_of_browse" setting and  redirect user to the splash page
 		 */
 		public function Index() {
			if ($this->request->config->get('use_splash_page_for_start_of_browse') && !$this->opo_browse->numCriteria()) { $this->response->setRedirect(caNavUrl($this->request, '', 'Splash', 'Index')); return; }
			parent::Index();
		}
 		# -------------------------------------------------------
 		/**
 		 * Ajax action that returns info on a mapped location based upon the 'id' request parameter.
 		 * 'id' is a list of object_ids to display information before. Each integer id is separated by a semicolon (";")
 		 * The "ca_objects_results_map_balloon_html" view in Results/ is used to render the content.
 		 */ 
 		public function getMapItemInfo() {
 			$pa_object_ids = explode(';', $this->request->getParameter('id', pString));
 			
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			$this->view->setVar('ids', $pa_object_ids);
 			$this->view->setVar('access_values', $va_access_values);
 			
 		 	$this->render("Results/ca_objects_results_map_balloon_html.php");
 		 }
 		# -------------------------------------------------------
		public function browseName($ps_mode='singular') {
 			return ($ps_mode == 'singular') ? _t('browse') : _t('browses');
 		}
 		# -------------------------------------------------------
 		/**
 		 * Looks for 'view' parameter and sets browse facet view to alternate based upon parameter value if specified.
 		 * This lets you set a custom browse facet view from a link.
 		 * Note that the view parameter is NOT a full view name. Rather it is a simple text string (letters, numbers and underscores only)
 		 * that is inserted between "ajax_browse_facet_" and "_html.php" to construct a view name in themes/<theme_name>/views/Browse.
 		 * If a view with this name exists it will be used, otherwise the default view in Browse/ajax_browse_facet_html.php.
 		 *
 		 */
 		public function getFacet($pa_options=null) {
 			if (!is_array($pa_options)) { $pa_options = array(); }
 			if ($ps_view = preg_replace('![^A-Za-z0-9_]+!', '', $this->request->getParameter('view', pString))) {
 				$vs_relative_path = 'Browse/ajax_browse_facet_'.$ps_view.'_html.php';
 				
 				if (file_exists($this->request->getThemeDirectoryPath().'/views/'.$vs_relative_path)) {
 					$pa_options['view'] = $vs_relative_path; 
 				}
 			}
 			parent::getFacet($pa_options);
 		}
		# -------------------------------------------------------
 	}
 ?>