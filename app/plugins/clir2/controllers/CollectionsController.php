<?php
/* ----------------------------------------------------------------------
 * controllers/CollectionsController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_LIB_DIR__."/ca/BaseBrowseController.php");
 	require_once(__CA_LIB_DIR__."/ca/Browse/OccurrenceBrowse.php");

 	class CollectionsController extends BaseBrowseController {
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
 			
 			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/clir2/conf/clir2.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('clir2 plugin is not enabled')); }
 			
 			$this->ops_theme = __CA_THEME__;																		// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/clir2/views/'.$this->ops_theme)) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
			$this->opo_browse = new OccurrenceBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
			
 		}
 		# -------------------------------------------------------
 		public function Index() {
 			JavascriptLoadManager::register('browsable');
			JavascriptLoadManager::register('hierBrowser');
			
			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
			parent::Index(true);
			
 			# --- get the featured collections
 			$va_featured = array();
			$va_access_values = caGetUserAccessValues($this->request);
			$t_featured = new ca_sets();
			$t_featured->load(array('set_code' => "featured_collections"));
			 # Enforce access control on set
			if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured->get("access"), $va_access_values))){
				$va_featured_collections = caExtractValuesByUserLocale($t_featured->getItems(array('checkAccess' => $va_access_values, 'shuffle' => 1)));	// These are the collection ids in the set
			}
			if(is_array($va_featured_collections) && (sizeof($va_featured_collections) > 0)){
				$va_featured_collections = array_slice($va_featured_collections, 0, 5);
				foreach($va_featured_collections as $vn_i => $va_collection_info){
					$va_temp = array();
					$va_temp["idno"] = $va_collection_info["idno"];
					$va_temp["collection_id"] = $va_collection_info["row_id"];
					$va_temp["label"] = $va_collection_info["set_item_label"];
					$va_featured[$va_collection_info["set_item_label"]] = $va_temp;
				}
			}
			arsort($va_featured);
			$this->view->setVar("featured_collections", $va_featured);
 			
 			$this->render('collections_landing_index_html.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>