<?php
/* ----------------------------------------------------------------------
 * NCEPPlugin.php : 
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
 
	class NCEPPlugin extends BaseApplicationPlugin {
		# -------------------------------------------------------
		public function __construct($ps_plugin_path) {
			$this->description = _t('Adds NCEP-specific site functionality');
			
			$this->opo_config = Configuration::load($ps_plugin_path.'/conf/plugin.conf');
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
		 *
		 */
		public function hookDetailDownloadMediaObjectIDs($pa_object_ids) {
			
			// The object_ids from which representation media will downloaded, as set by the DetailController::DownloadMedia(),
			// are passed in $pa_object_ids. You can modify this array however is required and then return it.
			if(is_array($pa_object_ids) && sizeof($pa_object_ids)){
				$po_request = $this->getRequest();
				$t_list = new ca_lists();
				$va_verified_object_ids = array();
				$q_objects = caMakeSearchResult("ca_objects", $pa_object_ids);
				# --- these are the object types that require login AND educator access
				$va_requires_login = array($t_list->getItemIDFromList("object_types", "Presentation"), $t_list->getItemIDFromList("object_types", "EvaluationTool"), $t_list->getItemIDFromList("object_types", "Solutions"), $t_list->getItemIDFromList("object_types", "TeachingNotes"));
				$vb_logged_in_educator = false;
				if($po_request->isLoggedIn() && $po_request->user->getPreference("user_profile_classroom_role") == "EDUCATOR"){
					$vb_logged_in_educator = true;
				}
				if($q_objects->numHits()){
					while($q_objects->nextHit()){
						if(!in_array($q_objects->get("ca_objects.type_id"), $va_requires_login) || $vb_logged_in_educator){
							$va_verified_object_ids[] = $q_objects->get("ca_objects.object_id");
						}
					}
				}
			}
			return $va_verified_object_ids;
		}
		# -------------------------------------------------------
		/**
		 *
		 */
		public function hookDetailDownloadMediaFilePaths($pa_paths) {
		
			// The file paths to download as set by the DetailController::DownloadMedia() are passed in $pa_paths
			// You can modify the array however is required and then return it
		
			return $pa_paths;
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