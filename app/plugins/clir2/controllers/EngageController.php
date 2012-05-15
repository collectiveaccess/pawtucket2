<?php
/* ----------------------------------------------------------------------
 * includes/EngageController.php
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

	require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	
 	class EngageController extends ActionController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/clir2/conf/clir2.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('clir2 plugin is not enabled')); }
 			
 			$this->ops_theme = __CA_THEME__;																		// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/clir2/views/'.$this->ops_theme)) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 		}
 		# -------------------------------------------------------
 		public function Index() { 			
 			$t_occurrence = new ca_occurrences();
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			} 			
 			# --- get the most viewed occ records
			$va_occ_info = array();
			$va_most_viewed_occs = $t_occurrence->getMostViewedItems(3, array('checkAccess' => $va_access_values));
 			foreach($va_most_viewed_occs as $vn_occurrence_id => $va_occ_info){
				$t_occurrence->load($vn_occurrence_id);
				$va_occ_info['title'] = $t_occurrence->getLabelForDisplay();
				$va_preview_stills = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "widepreview", "showMediaInfo" => false, "returnAsArray" => true));
				if(sizeof($va_preview_stills) > 0){
					$va_occ_info["mediaPreview"] = array_shift($va_preview_stills);
				}
				$va_medium_stills = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "medium", "showMediaInfo" => false, "returnAsArray" => true));
				if(sizeof($va_medium_stills) > 0){
					$va_occ_info["mediaMedium"] = array_shift($va_medium_stills);
				}
				$va_occ_info["repository"] = $t_occurrence->get("CLIR2_institution", array('convertCodesToDisplayText' => true));
				$va_most_viewed_occs[$vn_occurrence_id] = $va_occ_info;
			}
			$this->view->setVar('most_viewed_occs', $va_most_viewed_occs);
 			
 			$this->render('Engage/engage_index_html.php');
 		}
 		# -------------------------------------------------------
 		public function Essays() { 			
 			$this->render('Engage/engage_essays_html.php');
 		}
 		# -------------------------------------------------------
 		public function More() { 			
 			$this->render('Engage/engage_more_html.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>