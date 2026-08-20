<?php
/* ----------------------------------------------------------------------
 * PillowPlugin.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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

class PillowPlugin extends BaseApplicationPlugin {
	# -------------------------------------------------------
	public function __construct($ps_plugin_path) {
		$this->description = _t('Handles custom theme functionality');
		
		$this->opo_config = Configuration::load(__CA_THEMES_DIR__.'/plugins/Pillow/conf/pillow.conf');
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
			'available' => true
		);
	}
	# -------------------------------------------------------
	/**
	 * Insert activity menu
	 */
	public function hookRepToolBarZoomButton(&$params) {
		if($set_id = caGetOption('set_id', $params['options'], null)) {
			if($t_item = ca_set_items::findAsInstance(['set_id' => $set_id, 'row_id' => $params['subject_id']])) {
				if($v = $t_item->get('ca_set_items.set_item_media', ['includeValueIDs' => true, 'returnWithStructure' => true])) {
					$v = array_shift($v);
					$v = array_shift($v);
					$v_id = $v['set_item_media_value_id'];
					$params['zoomParams']['value_id'] = $v_id;
					unset($params['zoomParams']['representation_id']);
				}
			}
		}
	
		return $params;
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
