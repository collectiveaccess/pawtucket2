<?php
/* ----------------------------------------------------------------------
 * catalogingPlugin.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
 
	class CatalogingPlugin extends BaseApplicationPlugin {
		# -------------------------------------------------------
		static $s_ui_code;
		static $s_ui_info;
		# -------------------------------------------------------
		public function __construct($ps_plugin_path) {
			$this->description = _t('Enabled users to create CollectiveAccess records from within Pawtucket');
			
			$this->opo_config = Configuration::load($ps_plugin_path.'/conf/cataloging.conf');
			parent::__construct();
		}
		# -------------------------------------------------------
		/**
		 * Override checkStatus() to return true
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
		 * Insert activity menu
		 */
		public function hookRenderMenuBar($pa_menu_bar) {
			if ($o_req = $this->getRequest()) {
				$vs_put_before_menu_code = $this->opo_config->get('position_top_level_nav_item_before');
				$va_menu = array(
					'displayName' => _t('Cataloging'),
					'default' => array(
						'module' => 'Cataloging',
						'controller' => 'Form',
						'action' => 'Edit'
					),
					'requires' => array()
				);
				
				if (!isset($pa_menu_bar[$vs_put_before_menu_code])) {
					$pa_menu_bar['cataloging'] = $va_menu;
				} else {
					$va_new_menu_bar = array();
					foreach($pa_menu_bar as $vs_menu_code => $va_menu_info) {
						if ($vs_menu_code === $vs_put_before_menu_code) {
							$va_new_menu_bar['cataloging'] = $va_menu;
						}
						$va_new_menu_bar[$vs_menu_code] = $va_menu_info;
					}
					return $va_new_menu_bar;
				}
			}
			return $pa_menu_bar;
		}
		# -------------------------------------------------------
		/**
		 * Get plugin user actions
		 */
		static public function getRoleActionList() {
			return array();
		}
		# -------------------------------------------------------
		/**
		 *
		 */
		static public function setUIInfo($ps_ui_code, $pa_ui_info) {
			CatalogingPlugin::$s_ui_code = $ps_ui_code;
			CatalogingPlugin::$s_ui_info = $pa_ui_info;
		}
		# -------------------------------------------------------
		/**
		 *
		 */
		static public function getFormSetting($ps_setting) {
			return isset(CatalogingPlugin::$s_ui_info[$ps_setting]) ? CatalogingPlugin::$s_ui_info[$ps_setting] : null;
		}
		# -------------------------------------------------------
	}
?>
