<?php
/* ----------------------------------------------------------------------
 * FindingAidPlugin.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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
 
	class FindingAidPlugin extends BaseApplicationPlugin {
		# -------------------------------------------------------
		public function __construct($ps_plugin_path) {
			$this->description = _t('Provides a finding-aid view for your Pawtucket installation');
			if (__CA_THEME_DIR__.'/conf/FindingAid.conf') {
				$this->opo_config = Configuration::load(__CA_THEME_DIR__.'/conf/FindingAid.conf');
			} else {
				$this->opo_config = Configuration::load($ps_plugin_path.'/conf/FindingAid.conf');
			}
			#$this->opo_config = Configuration::load($ps_plugin_path.'/conf/FindingAid.conf');
			parent::__construct();
		}
		# -------------------------------------------------------
		/**
		 * Override checkStatus() to return plugin status
		 */
		public function checkStatus() {
			return array(
				'description' => $this->getDescription(),
				'errors' => array(),
				'warnings' => array(),
				'available' => ((bool)$this->opo_config->get('enabled'))
			);
		}
		# -------------------------------------------------------
		/**
		 * Get plugin user actions
		 */
		static public function getRoleActionList() {
			return array();
		}
		
 		/**
 		 *
 		 */
 		static public function hookCanHandleGetAsLinkTarget(&$pa_params) {
 			return (strtolower($pa_params['target']) == 'findingaid');
 		}
 		# ------------------------------------------------------
 		/**
 		 *
 		 */
 		static public function hookGetAsLink(&$pa_params) {
 			
 			$pa_params['tag'] = caNavLink($pa_params['request'], $pa_params['content'], '', '*', '*', '*', array('id' => $pa_params['id']));
 			
 			return $pa_params;
 		}
 		# ------------------------------------------------------
	}