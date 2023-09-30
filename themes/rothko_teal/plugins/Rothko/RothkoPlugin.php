<?php
/* ----------------------------------------------------------------------
 * RothkoPlugin.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016 Whirl-i-Gig
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
 

	class RothkoPlugin extends BaseApplicationPlugin {
		# -------------------------------------------------------
		public function __construct($ps_plugin_path) {
			$this->description = _t('Handle Rothko-specific functionalty');
			
			$this->opo_config = Configuration::load($ps_plugin_path.'/conf/rothko.conf');
			parent::__construct();
		}
		# -------------------------------------------------------
		/**
		 * Override checkStatus() to return true - the historyMenu plugin always initializes ok
		 */
		public function checkStatus() {
			return array(
				'description' => $this->getDescription(),
				'errors' => [],
				'warnings' => [],
				'available' => ((bool)$this->opo_config->get('enabled'))
			);
		}
		# -------------------------------------------------------
		/**
		 * Insert activity menu
		 */
		public function hookReplaceSearch(&$pa_params) {
			switch($pa_params['search']) {
				case 'artworks':
					if (preg_match("!ca_collections.collection_id:([0-9]+)!", $pa_params['searchExpression'], $va_matches)) {
						$vn_collection_id = (int)$va_matches[1];
						require_once(__CA_MODELS_DIR__."/ca_objects_x_collections.php");
						
						if ((preg_match("!ca_objects_x_collections.current_collection:([A-Za-z]+)!", $pa_params['searchExpression'], $va_matches)) && ($vn_current_collection_id = caGetListItemID('yes_no', $va_matches[1]))) {
							$pa_params['searchWasReplaced'] = true;
							if ($qr_res = ca_objects_x_collections::find(['collection_id' => $vn_collection_id, 'current_collection' => $vn_current_collection_id], ['returnAs' => 'searchResult'])) {
								$t_object = new ca_objects();
								$pa_params['result'] = caMakeSearchResult('ca_objects', $t_object->getHierarchyChildrenForIDs($qr_res->getAllFieldValues('object_id'), ['ids' => true]));
							} else {
								$pa_params['result'] = caMakeSearchResult('ca_objects', []);
							}
						}
					}
					break;
			}
			return $pa_params;
		}
		# -------------------------------------------------------
		/**
		 * Get plugin user actions
		 */
		static public function getRoleActionList() {
			return [];
		}
		# -------------------------------------------------------
	}