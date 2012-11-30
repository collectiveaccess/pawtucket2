<?php
/* ----------------------------------------------------------------------
 * app/controllers/lookup/MetadataElementController.php : 
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
 	require_once(__CA_LIB_DIR__."/core/Controller/ActionController.php");
 	require_once(__CA_MODELS_DIR__."/ca_metadata_elements.php");
 
 	//
 	// This lookup controller doesn't extend BaseLookupController
 	// since direct lookups on attributes are handled specially – not via the search engine
 	class AttributeValueController extends ActionController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			$this->ops_theme = __CA_THEME__;																	// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/Contribute/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			$this->opo_plugin_config = Configuration::load($po_request->getAppConfig()->get('application_plugins').'/Contribute/conf/contribute.conf');
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('Contribute plugin is not enabled')); }
 			
 			parent::__construct($po_request, $po_response, array(__CA_APP_DIR__.'/plugins/Contribute/themes/'.$this->ops_theme.'/views'));
 		}
 		# -------------------------------------------------------
 		# AJAX handlers
 		# -------------------------------------------------------
		public function Get($pa_additional_query_params=null, $pa_options=null) {
			$ps_query = $this->request->getParameter('q', pString);
			$ps_bundle = $this->request->getParameter('bundle', pString);
			
			$va_tmp = explode('.', $ps_bundle);
			
			$o_dm = Datamodel::load();
			
			if (!($t_table = $o_dm->getInstanceByTableName($va_tmp[0], true))) {
				// bad table name
				print _t("Invalid table name");
				return null;
			}
			
			$t_element = new ca_metadata_elements();
			if (!($t_element->load(array('element_code' => $va_tmp[1])))) {
				print _t("Invalid element code");
				return null;
			}
			
			if ((int)$t_element->getSetting('suggestExistingValues') !== 1) {
				print _t("Value suggestion is not supported for this metadata element");
				return null;
			}
			
			$va_type_restrictions = $t_element->getTypeRestrictions($t_table->tableNum());
			if (!$va_type_restrictions || !is_array($va_type_restrictions) || !sizeof($va_type_restrictions)) {
				print _t("Element code is not bound to the specified table");
				return null;
			}
			
			$o_db = new Db();
			
			switch($t_element->getSetting('suggestExistingValueSort')) {
				case 'recent':		// date/time entered
					$vs_sort_field = 'value_id DESC';
					$vn_max_returned_values = 10;
					break;
				default:				// alphabetically
					$vs_sort_field = 'value_longtext1 ASC';
					$vn_max_returned_values = 50;
					break;
			}
			
			$qr_res = $o_db->query("
				SELECT DISTINCT value_longtext1
				FROM ca_attribute_values
				WHERE
					element_id = ?
					AND
					(value_longtext1 LIKE ?)
				ORDER BY
					{$vs_sort_field}
				LIMIT {$vn_max_returned_values}
			", (int)$t_element->getPrimaryKey(), (string)$ps_query.'%');
			
			$this->view->setVar('attribute_value_list', $qr_res->getAllFieldValues('value_longtext1'));
			return $this->render('lookup/ajax_attribute_value_list_html.php');
		}
		# -------------------------------------------------------
 		/**
 		 * Given a item_id (request parameter 'id') returns a list of direct children for use in the hierarchy browser
 		 * Returned data is JSON format
 		 */
 		public function GetHierarchyLevel() {
 			// Not implemented
 			return null;
 		}
 		# -------------------------------------------------------
 		/**
 		 * Given a item_id (request parameter 'id') returns a list of ancestors for use in the hierarchy browser
 		 * Returned data is JSON format
 		 */
 		public function GetHierarchyAncestorList() {
 			// Not implemented
 			return null;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
		public function IDNo() {
			// Not implemented
			return null;
		}
		# -------------------------------------------------------
 		/**
 		 * Checks value of instrinsic field and return list of primary keys that use the specified value
 		 * Can be used to determine if a value that needs to be unique is actually unique.
 		 */
		public function Intrinsic() {
			// Not implemented
			return null;
		}
 		# -------------------------------------------------------
 	}
 ?>