<?php
/* ----------------------------------------------------------------------
 * controllers/ArtistBrowser.php
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
	require_once(__CA_LIB_DIR__."/ca/Browse/EntityBrowse.php");
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 
 	class ArtistBrowserController extends BaseBrowseController {
 		# -------------------------------------------------------
 		 /** 
 		 * Name of table for which this browse returns items
 		 */
 		 protected $ops_tablename = 'ca_entities';
 		 
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
 		
 		
 		protected $ops_find_type = 'artist_browse';
 		
 		protected $opo_plugin_config;			// plugin config file
 		protected $opo_result_context;			// current result context
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			$this->ops_theme = __CA_THEME__;																	// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/eastend/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			parent::__construct($po_request, $po_response, array(__CA_APP_DIR__.'/plugins/eastend/themes/'.$this->ops_theme.'/views'));
 			
 			MetaTagManager::addLink('stylesheet', $po_request->getBaseUrlPath()."/app/plugins/eastend/themes/".$this->ops_theme."/css/eastend.css",'text/css');
 		 	
 		 	$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/eastend/conf/eastend.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('eastend plugin is not enabled')); }

			// redirect user if not logged in
			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            }
            
			$po_request->session->setVar('pawtucket2_browse_target', "ca_entities");
			
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
 				$this->opa_access_values = array();
 			}else{
 				$this->opa_access_values = caGetUserAccessValues($this->request);
 			}
 			$this->view->setVar('access_values', $va_access_values);


			$this->opo_result_context = new ResultContext($po_request, $this->ops_tablename, $this->ops_find_type);
			$this->opo_browse = new EntityBrowse();
			
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
						
 		}
 		# -------------------------------------------------------
 		public function index() {
			#print $this->ops_tablename;
			JavascriptLoadManager::register('cycle');
 			$this->getDefaults();
 			
 			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
			
 			parent::Index(true);
 			
			$this->render('artist_browser_html.php');
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
 		/**
 		 *
 		 * This is a version of the getfacet function in the main browse controller.
 		 * Difference are: this clears all criteria before generating the facet since the artist browser only supports single level browsing, we need all facets to show up all the time
 		 * this facet view that is included is in the plugin's views/Browse folder - *not* the theme's views/Browse folder
 		 *
 		 * Looks for 'view' parameter and sets browse facet view to alternate based upon parameter value if specified.
 		 * This lets you set a custom browse facet view from a link.
 		 * Note that the view parameter is NOT a full view name. Rather it is a simple text string (letters, numbers and underscores only)
 		 * that is inserted between "ajax_browse_facet_" and "_html.php" to construct a view name in themes/<theme_name>/views/Browse.
 		 * If a view with this name exists it will be used, otherwise the default view in Browse/ajax_browse_facet_html.php.
 		 *
 		 */
 		public function getFacet($pa_options=null) {
 			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
			if (!is_array($pa_options)) { $pa_options = array(); }
 			if ($ps_view = preg_replace('![^A-Za-z0-9_]+!', '', $this->request->getParameter('view', pString))) {
 				$vs_relative_path = 'Browse/ajax_browse_facet_'.$ps_view.'_html.php';
 				
 				if (file_exists($this->request->getAppConfig()->get('application_plugins').'/eastend/themes/eastend2/views/'.$vs_relative_path)) {
 					$pa_options['view'] = $vs_relative_path; 
 				}
 			}
 			parent::getFacet($pa_options);
 		}
		# -------------------------------------------------------
		public function getFeaturedArtistSlideshow(){
			$va_featured_ids = array();
 			$t_featured = new ca_sets();
 			# --- featured artists set - set name assigned in eastend.conf - plugin conf file
			$t_featured->load(array('set_code' => $this->opo_plugin_config->get('featured_artists_set_name')));
			 # Enforce access control on set
 			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_featured->get("access"), $this->opa_access_values))){
  				$this->view->setVar('featured_set_id', $t_featured->get("set_id"));
 				$va_featured_ids = array_keys(is_array($va_tmp = $t_featured->getItemRowIDs(array('checkAccess' => $this->opa_access_values, 'shuffle' => 1))) ? $va_tmp : array());	// These are the entity ids in the set
 			}
 			if(!is_array($va_featured_ids) || (sizeof($va_featured_ids) == 0)){
				# put random entities in the features variable
 				$o_db = new Db();
 				$q_entities = $o_db->query("SELECT e.entity_id from ca_entities e WHERE e.access IN (".implode($this->opa_access_values, ", ").") ORDER BY RAND() LIMIT 10");
 				if($q_entities->numRows() > 0){
 					while($q_entities->nextRow()){
 						$va_featured_ids[] = $q_entities->get("entity_id");
 					}
 				}
			}
			
			# --- loop through featured ids and grab the entity's name, portrait, lifespan -lifespans_date, indexing_notes (brief description abouthow they relate to the east end)
			$t_entity = new ca_entities();
			$t_object = new ca_objects();
			$va_featured_artists = array();
			foreach($va_featured_ids as $vn_featured_entity_id){
				$va_tmp = array();
				$t_entity->load($vn_featured_entity_id);
				$va_tmp["entity_id"] = $vn_featured_entity_id;
				$va_tmp["lifespan"] = $t_entity->get("lifespans_date");
				$va_tmp["indexing_notes"] = $t_entity->get("indexing_notes");
				$va_tmp["name"] = $t_entity->getLabelForDisplay();
				$va_objects = $t_entity->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $this->opa_access_values, 'restrict_to_relationship_types' => array('depicts')));
				$va_object = array_shift($va_objects);
				$t_object->load($va_object["object_id"]);
				$va_portrait = $t_object->getPrimaryRepresentation(array("medium"));
				$va_tmp["image"] = $va_portrait["tags"]["medium"];
				$va_featured_artists[$vn_featured_entity_id] = $va_tmp;
			}
			$this->view->setVar("featured_artists", $va_featured_artists);
			$this->render('featured_artists_html.php');
		}
		# -------------------------------------------------------
 	}
 ?>
