<?php
/* ----------------------------------------------------------------------
 * controllers/TravelersController.php
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
 
 	require_once(__CA_APP_DIR__."/plugins/_root_/controllers/BaseItineraController.php");
 	require_once(__CA_THEME_DIR__."/helpers/dataHelpers.php");
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_entities.php");
 
 	class TravelersController extends BaseItineraController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			AssetLoadManager::register('viz');
 			
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function Index() {
 			$pn_entity_id = null;
 			if (!($pn_object_id = $this->request->getParameter('object_id', pIntger))) {
 				$pn_entity_id = $this->request->getParameter('id', pInteger);
 			}
 			if (!$pn_object_id && !$pn_entity_id) { $pn_entity_id = itineraGetRandomTravelerID(); }
 			
			$this->view->setVar('entity_id', $pn_entity_id);
			$this->view->setVar('object_id', $pn_object_id);
			
 			$this->render('Travelers/index_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function Get() {
			
 			$this->render('Travelers/get_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function GetData() {
 			if (!($pn_object_id = $this->request->getParameter('object_id', pInteger))) {
 				$pn_entity_id = $this->request->getParameter('id', pInteger);
 				$t_entity = new ca_entities($pn_entity_id);
			
				$this->view->setVar('entity_id', $pn_entity_id);
				$this->view->setVar('t_entity', $t_entity);
			} else {
 				$t_object = new ca_objects($pn_object_id);
			
				$this->view->setVar('object_id', $pn_object_id);
				$this->view->setVar('t_object', $t_object);
			}
			$this->view->setVar('levels', 1);
 			$this->render('Travelers/get_data_json.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 * Entities only (for now)
 		 */
 		function GetCard() {
 			$pn_entity_id = $this->request->getParameter('id', pInteger);
 			$t_entity = new ca_entities($pn_entity_id);
			
			$this->view->setVar('entity_id', $pn_entity_id);
			$this->view->setVar('t_entity', $t_entity);
 			$this->render('Travelers/get_card_html.php');
 		}
 		# -------------------------------------------------------
 	}