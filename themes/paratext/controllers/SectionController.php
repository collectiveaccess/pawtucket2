<?php
/* ----------------------------------------------------------------------
 * controllers/SectionController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2016 Whirl-i-Gig
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
 
	require_once(__CA_LIB_DIR__."/ApplicationError.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
 	class SectionController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			$this->config = caGetDetailConfig();
 			caSetPageCSSClasses(array("section"));
 			
 			AssetLoadManager::register("panel");
 			AssetLoadManager::register("mediaViewer");
 			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);
			$ps_section_idno = strtolower($ps_function);
			if(strToLower($ps_section_idno) == "exhibition"){
				$this->render("Section/exhibition_landing_html.php");
			}else{
				$t_section = new ca_occurrences(array("idno" => $ps_section_idno));
				if(!$t_section->get("ca_occurrences.occurrence_id")){
					throw new ApplicationException("Invalid id");
				}
				if((is_array($va_access_values) && sizeof($va_access_values)) && !in_array($t_section->get("ca_occurrences.access"), $va_access_values)){
					throw new ApplicationException("Section not available to the public");
				}
				$this->view->setVar('current_section', $ps_section_idno);
				$this->view->setVar('section', $t_section);
				$this->view->setVar('section_title', $t_section->get("ca_occurrences.preferred_labels.name"));
				$this->view->setVar('section_text', $t_section->get("ca_occurrences.description"));
				$va_related_object_ids = $t_section->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("paratext_illustration")));
				if(is_array($va_related_object_ids) && sizeof($va_related_object_ids)){
					$this->view->setVar('illustration_ids', $va_related_object_ids);
					$q_objects_as_search_result = caMakeSearchResult('ca_objects', $va_related_object_ids);
					$this->view->setVar('illustrations_as_search_result', $q_objects_as_search_result);
					if($this->request->getParameter("view", pString) == "grid"){
						$this->render("Section/section_media_grid_html.php");	
					}else{
						$this->render("Section/section_media_html.php");
					}
				}else{
					$this->render("Section/section_html.php");
				}
			}
		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Section',
 				'action' => 'Index',
 				'params' => array()
 			);
			return $va_ret;
 		}
 		# ------------------------------------------------------
 	}