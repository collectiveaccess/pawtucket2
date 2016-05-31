<?php
/* ----------------------------------------------------------------------
 * controllers/CirculationController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 	require_once(__CA_APP_DIR__."/plugins/NYSocStatisticsGenerator/controllers/_root_/BaseNYSocFeaturesController.php");
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_entities.php");
 
 	class CirculationController extends BaseNYSocFeaturesController {
 		# -------------------------------------------------------
 		/**
 		 * Colors for each series (match Chartist stylesheet)
 		 */
 		static $chart_series_colors = [
			"999999", "5e9eaa", "f4c63d", "d17905", "453d3f", 
			"59922b", "0544d3", "6b0392", "f05b4f", "dda458", "eacf7d", 
			"86797d", "b2c326", "6188e2", "a748ca"
		];
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			$this->view->setVar('series_colors', CirculationController::$chart_series_colors);
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function Index() {
 			return $this->Readers();
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function Readers() {
 			if (!is_array($va_entity_list = $this->request->session->getVar('entity_list'))) { $va_entity_list = array(); }
 			
			$pn_entity_id = $this->request->getParameter('id', pInteger);
			
			if ($pn_entity_id && !in_array($pn_entity_id, $va_entity_list)) { 
				$va_entity_list[] = $pn_entity_id; 
				
 				$this->request->session->setVar('entity_list', $va_entity_list);
			}
 			
 			$this->view->setVar('entity_list', $va_entity_list);
 			
 			$this->render('Circulation/readers_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function Books() {
 			if (!is_array($va_object_list = $this->request->session->getVar('object_list'))) { $va_object_list = array(); }
 			
			$pn_object_id = $this->request->getParameter('id', pInteger);
			
			if ($pn_object_id && !in_array($pn_object_id, $va_object_list)) { 
				$va_object_list[] = $pn_object_id; 
				
 				$this->request->session->setVar('object_list', $va_object_list);
			}
 			
 			$this->view->setVar('object_list', $va_object_list);
 			
 			$this->render('Circulation/books_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function GetReaders() {
 			if (!is_array($va_entity_list = $this->request->session->getVar('entity_list'))) { $va_entity_list = array(); }
 			
 			$ps_mode = $this->request->getParameter('m', pString);
 			
 			$va_added_entity_ids = $va_removed_entity_ids = array();
 			if ($pn_entity_id = $this->request->getParameter('id', pInteger)) {
 				switch($ps_mode) {
 					case 'remove':
 						if(($vn_i = array_search($pn_entity_id, $va_entity_list)) !== false) {
							unset($va_entity_list[$vn_i]);
							$va_removed_entity_ids[] = $pn_entity_id;
						}
 						break;
 					default:
 						if (!in_array($pn_entity_id, $va_entity_list)) { 
 							$t_entity = new ca_entities($pn_entity_id);
 							
 							$va_entity_list[] = $pn_entity_id; 
 							$va_added_entity_ids[] = $pn_entity_id; 
 						}
 						break;	
 				}
 				
 				$this->request->session->setVar('entity_list', $va_entity_list);
 				 				
				$this->view->setVar('added_entity_ids', $va_added_entity_ids);
				$this->view->setVar('removed_entity_ids', $va_removed_entity_ids);
 			}
			

			$this->view->setVar('entity_list', $va_entity_list);

 			$this->render('Circulation/get_readers_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function GetBooks() {
 			if (!is_array($va_object_list = $this->request->session->getVar('object_list'))) { $va_object_list = array(); }
 			
 			$ps_mode = $this->request->getParameter('m', pString);
 			
 			$va_added_object_ids = $va_removed_object_ids = array();
 			if ($pn_object_id = $this->request->getParameter('id', pInteger)) {
 				switch($ps_mode) {
 					case 'remove':
 						if(($vn_i = array_search($pn_object_id, $va_object_list)) !== false) {
							unset($va_object_list[$vn_i]);
							$va_removed_object_ids[] = $pn_object_id;
						}
 						break;
 					default:
 						if (!in_array($pn_object_id, $va_object_list)) { 
 							$t_object = new ca_objects($pn_object_id);
 							
 							$va_object_list[] = $pn_object_id; 
 							$va_added_object_ids[] = $pn_object_id; 
 						}
 						break;	
 				}
 				
 				$this->request->session->setVar('object_list', $va_object_list);
 				 				
				$this->view->setVar('added_object_ids', $va_added_object_ids);
				$this->view->setVar('removed_object_ids', $va_removed_object_ids);
 			}
			

			$this->view->setVar('object_list', $va_object_list);

 			$this->render('Circulation/get_books_html.php');
 		}
 		# -------------------------------------------------------
 	}