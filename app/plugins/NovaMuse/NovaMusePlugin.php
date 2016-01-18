<?php
/* ----------------------------------------------------------------------
 * NovaMusePlugin.php : 
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
 
	class NovaMusePlugin extends BaseApplicationPlugin {
		# -------------------------------------------------------
		public function __construct($ps_plugin_path) {
			$this->description = _t('Adds member map and stats dashboard to NovaMuse site');
			
			$this->opo_config = Configuration::load($ps_plugin_path.'/conf/NovaMuse.conf');
			parent::__construct();
		}
		# -------------------------------------------------------
		/**
		 * Override checkStatus() to return true - the historyMenu plugin always initializes ok
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
				$va_menuMembers = array(
					'displayName' => _t('member map'),
					'default' => array(
						'module' => 'NovaMuse',
						'controller' => 'MemberMap',
						'action' => 'Index'
					),
					'requires' => array()
				);
				$va_menuDashboard = array(
					'displayName' => _t('dashboard'),
					'default' => array(
						'module' => 'NovaMuse',
						'controller' => 'Dashboard',
						'action' => 'Index'
					),
					'requires' => array()
				);
				
				if (!isset($pa_menu_bar[$vs_put_before_menu_code])) {
					$pa_menu_bar['NovaMuse'] = $va_menu;
				} else {
					$va_new_menu_bar = array();
					foreach($pa_menu_bar as $vs_menu_code => $va_menu_info) {
						if ($vs_menu_code === $vs_put_before_menu_code) {
							$va_new_menu_bar['NovaMuseDashboard'] = $va_menuDashboard;
							$va_new_menu_bar['NovaMuseMembers'] = $va_menuMembers;
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
	}
?>