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
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	
 	class DetailController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private $opa_url_names_to_tables = array(
 			'objects' 		=> 'ca_objects',
 			'entities' 		=> 'ca_entities',
 			'places' 		=> 'ca_places',
 			'occurrences' 	=> 'ca_occurrences',
 			'collections' 	=> 'ca_collections'
 		);
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$ps_function = strtolower($ps_function);
 			$ps_id = $this->request->getActionExtra(); //$this->request->getParameter('id', pString);
 			if (!isset($this->opa_url_names_to_tables[$ps_function]) || (!($vs_table = $this->opa_url_names_to_tables[$ps_function]))) {
 				// invalid detail type – throw error
 				die("Invalid detail type");
 			}
 			
 			$o_dm = Datamodel::load();
 			
 			$t_table = $o_dm->getInstanceByTableName($vs_table, true);
 			if (!$t_table->load(caUseIdentifiersInUrls() ? array('idno' => $ps_id) : (int)$ps_id)) {
 				// invalid id - throw error
 			}
 			
 			$vs_type = $t_table->getTypeCode();
 			
 			$this->view->setVar('detailType', $vs_table);
 			$this->view->setVar('item', $t_table);
 			$this->view->setVar('itemType', $vs_type);
 			
 			// find view
 			//		first look for type-specific view
 			if ($this->viewExists($vs_path = "Details/{$vs_table}_{$vs_type}_html.php")) {
 				$this->render($vs_path);
 			} else {
 				// If no type specific view use the default
 				$this->render("Details/{$vs_table}_default_html.php");
 			}
 		}
 		# -------------------------------------------------------
	}
 ?>