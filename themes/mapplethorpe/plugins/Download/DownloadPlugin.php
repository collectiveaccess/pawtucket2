<?php
/* ----------------------------------------------------------------------
 * DownloadPlugin.php : 
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
 
class DownloadPlugin extends BaseApplicationPlugin {
	# -------------------------------------------------------
	public function __construct($ps_plugin_path) {
		$this->description = _t('Manage download for Mapplethorpe theme');
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
			'available' => true
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
	static public function hookDetailDownloadMediaObjectIDs(&$pa_params) {
		global $g_request;
		$valid_ids = [];
		if ($g_request) {
			foreach($pa_params as $object_id) {
				if($t_object = ca_objects::findAsInstance(['object_id' => $object_id])) {
					if(($t_object->get('ca_objects.download_for_artestar', ['convertCodesToIdno' => true]) === 'yes') && $g_request->user->hasRole('full_access')) {
						$valid_ids[] = $object_id;
					}
				}
			}
		} else {
			return $pa_params;
		}
		return $valid_ids;
 	}
 	# ------------------------------------------------------
}