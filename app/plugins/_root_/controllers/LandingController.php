<?php
/* ----------------------------------------------------------------------
 * controllers/SplashController.php
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
	require_once(__CA_LIB_DIR__."/core/Error.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_LIB_DIR__."/ca/Browse/ObjectBrowse.php");
	require_once(__CA_LIB_DIR__."/ca/Browse/OccurrenceBrowse.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	require_once(__CA_MODELS_DIR__."/ca_lists.php");
 
 	class LandingController extends BaseBrowseController {
 		# -------------------------------------------------------
 		 /** 
 		 * Name of table for which this browse returns items
 		 */
 		 protected $ops_tablename = null;
 		 
 		/** 
 		 * Number of items per results page
 		 */
 		protected $opa_items_per_page = array(18, 24, 48);
 		#protected $opa_items_per_page = array(18);
 		 
 		/**
 		 * List of result views supported for this browse
 		 * Is associative array: keys are view labels, values are view specifier to be incorporated into view name
 		 */ 
 		protected $opa_views;
 		 
 		 
 		/**
 		 * List of available result sorting fields
 		 * Is associative array: values are display names for fields, keys are full fields names (table.field) to be used as sort
 		 */
 		protected $opa_sorts;
 		
 		
 		protected $ops_find_type = 'basic_browse';
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
		
			// redirect user if not logged in
			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            }
            
			$this->opa_views = array(
				'thumbnail' => _t('Thumbnails'),
				'full' => _t('List')
			);
			 
			$this->opa_sorts = array(
				'ca_object_labels.name' => _t('title'),
				'ca_objects.type_id' => _t('type'),
				'ca_objects.idno' => _t('idno')
			);
 				
 		}
 		# -------------------------------------------------------
 		function artwork() {
			$this->ops_tablename = 'ca_objects';
			
			$t_list = new ca_lists();
			$this->opn_type_restriction_id = $t_list->getItemIDFromList('object_types', 'artwork');
			
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			$this->getDefaults();
 			
 			// set type restrictions for searches 
 			$o_search_result_context = new ResultContext($this->request, $this->ops_tablename, 'basic_search');
 			$o_search_result_context->setTypeRestriction($this->opn_type_restriction_id);
 			$o_search_result_context->saveContext();
 			
 			// Set type restriction (ie. only show objects with type=artworks)
			// the base browse controller Index() method will take care of actually setting the restriction
 			$this->opo_result_context = new ResultContext($this->request, $this->ops_tablename, $this->ops_find_type);
			$this->opo_result_context->setTypeRestriction($this->opn_type_restriction_id);
 			$this->opb_type_restriction_has_changed = true;
 			
 			$this->opo_browse = new ObjectBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');	
 			$this->opo_browse->setTypeRestrictions(array($this->opn_type_restriction_id));
			
			$this->opa_views = array(
				'full' => _t('List')
			);
			 
			$this->opa_sorts = array(
				'ca_object_labels.name' => _t('title'),
				'ca_objects.type_id' => _t('type'),
				'ca_objects.idno' => _t('idno')
			);
 			
 			
 			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
			
			// Set facet group so only "front page" facets are displayed
			$this->opo_browse->setFacetGroup('frontpage');
			
 			parent::Index(true);
 				
 			$this->render('Landing/artwork_html.php');
 		}
 		# -------------------------------------------------------
 		function exhibitions() {
 			$this->ops_tablename = 'ca_occurrences';
 			
			$t_list = new ca_lists();
 			$this->opn_type_restriction_id = $t_list->getItemIDFromList('occurrence_types', 'exhibition');
 			
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			$this->getDefaults();
 			
 			// set type restrictions for searches 
 			$o_search_result_context = new ResultContext($this->request, $this->ops_tablename, 'basic_search');
 			$o_search_result_context->setTypeRestriction($this->opn_type_restriction_id);
 			$o_search_result_context->saveContext();
 			
			// Set type restriction (ie. only show occurrences with type=exhibition)
			// the base browse controller Index() method will take care of actually setting the restriction
 			$this->opo_result_context = new ResultContext($this->request, $this->ops_tablename, $this->ops_find_type);
			$this->opo_result_context->setTypeRestriction($this->opn_type_restriction_id);
			$this->opo_result_context->saveContext();
 			$this->opb_type_restriction_has_changed = true;
 			
 			$this->opo_browse = new OccurrenceBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
 			$this->opo_browse->setTypeRestrictions(array($this->opn_type_restriction_id));
					
 					$this->opa_sorts = array(
						'ca_occurrence_labels.name' => _t('title'),
						'ca_occurrences.idno' => _t('idno')
					);
 			
 			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
			
 			parent::Index(true);
 			
 				
 			$this->render('Landing/exhibitions_html.php');
 		}
 		# -------------------------------------------------------
 		function bibliography() {
			$this->ops_tablename = 'ca_occurrences';
			
			$t_list = new ca_lists();
			$this->opn_type_restriction_id = $t_list->getItemIDFromList('occurrence_types', 'bibliography');
			
 			$va_access_values = caGetUserAccessValues($this->request);
			
			$this->getDefaults();
			
 			// set type restrictions for searches 
 			$o_search_result_context = new ResultContext($this->request, $this->ops_tablename, 'basic_search');
 			$o_search_result_context->setTypeRestriction($this->opn_type_restriction_id);
 			$o_search_result_context->saveContext();
 			
 			// Set type restriction (ie. only show occurrences with type=bibliography)
			// the base browse controller Index() method will take care of actually setting the restriction
 			$this->opo_result_context = new ResultContext($this->request, $this->ops_tablename, $this->ops_find_type);
			$this->opo_result_context->setTypeRestriction($this->opn_type_restriction_id);
			$this->opb_type_restriction_has_changed = true;
			
 			$this->opo_browse = new OccurrenceBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
 			$this->opo_browse->setTypeRestrictions(array($this->opn_type_restriction_id));
 			
 			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
 			
 					$this->opa_sorts = array(
						'ca_occurrence_labels.name' => _t('title'),
						'ca_occurrences.idno' => _t('idno')
					);
 			
			
			parent::Index(true);
 			
 				
 			$this->render('Landing/bibliography_html.php');
 		}
 		# -------------------------------------------------------
 		function chronology() {
 			$this->ops_tablename = 'ca_occurrences';
 			
 			$t_list = new ca_lists();
 			$this->opn_type_restriction_id = $t_list->getItemIDFromList('occurrence_types', 'chronology');
 			
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			$this->getDefaults();
 			
 			// set type restrictions for searches 
 			$o_search_result_context = new ResultContext($this->request, $this->ops_tablename, 'basic_search');
 			$o_search_result_context->setTypeRestriction($this->opn_type_restriction_id);
 			$o_search_result_context->saveContext();
 			
			// Set type restriction (ie. only show occurrences with type=bibliography)
			// the base browse controller Index() method will take care of actually setting the restriction
 			$this->opo_result_context = new ResultContext($this->request, $this->ops_tablename, $this->ops_find_type);
			$this->opo_result_context->setTypeRestriction($this->opn_type_restriction_id);
			
 			$this->opo_browse = new OccurrenceBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
 			$this->opo_browse->setTypeRestrictions(array($this->opn_type_restriction_id));
 			
 					$this->opa_sorts = array(
						'ca_occurrence_labels.name' => _t('title'),
						'ca_occurrences.idno' => _t('idno')
					);
 			
 			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
			
 			parent::Index(true);
 			
 				
 			$this->render('Landing/chronology_html.php');
 		}
 		# -------------------------------------------------------
		public function browseName($ps_mode='singular') {
 			return ($ps_mode == 'singular') ? _t('browse') : _t('browses');
 		}
 		# -------------------------------------------------------
 		private function getDefaults() { 
 		 	if (($vn_items_per_page_default = (int)$this->request->config->get('items_per_page_default_for_'.$this->ops_tablename.'_browse')) > 0) {
				$this->opn_items_per_page_default = $vn_items_per_page_default;
			} else {
				$this->opn_items_per_page_default = $this->opa_items_per_page[0];
			}
		}
 		# -------------------------------------------------------
 	}
 ?>
