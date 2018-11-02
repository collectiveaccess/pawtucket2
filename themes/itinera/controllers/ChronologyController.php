<?php
/* ----------------------------------------------------------------------
 * controllers/TimelineController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
	#require_once(__CA_LIB_DIR__."/core/Error.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	require_once(__CA_APP_DIR__."/plugins/_root_/controllers/BaseItineraController.php");
 
	class ChronologyController extends BaseItineraController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            } 			
 			caSetPageCSSClasses(array("chronology"));
 			
 			AssetLoadManager::register('timeline');
 		}
 		# ------------------------------------------------------
 		 public function Index() {
			$this->render("Chronology/Index.php");
		}
		# ------------------------------------------------------
 		 public function Get() {
 		 	if (!is_array($va_entity_list = Session::getVar('itinera_entity_list'))) { $va_entity_list = array(); }
 			if (!is_array($va_object_list = Session::getVar('itinera_object_list'))) { $va_object_list = array(); }
 					
 		 	$ps_mode = $this->request->getParameter('m', pString);
 			$this->view->setVar('mode', $ps_mode);
 			switch($ps_mode){
 				case "add":
 					$pn_entity_id = $this->request->getParameter('id', pInteger);
			
					if ($pn_entity_id && !in_array($pn_entity_id, $va_entity_list)) { 
						$t_entity = new ca_entities($pn_entity_id);
				
						$vs_color = itineraGetUnusedColor($va_entity_list, $t_entity->get('ca_entities.color'));
				
						$va_entity_list[$vs_color] = $pn_entity_id; 
				
						Session::setVar('itinera_entity_list', $va_entity_list);
						# --- just set the entity list to the one entity you want to add on
						$this->view->setVar('entity_list', array($vs_color => $pn_entity_id));
					}
					$pn_object_id = $this->request->getParameter('object_id', pInteger);
			
					if ($pn_object_id && !in_array($pn_object_id, $va_object_list)) { 
						$t_object = new ca_objects($pn_object_id);
				
						$vs_color = itineraGetUnusedColor($va_object_list, 'cc0000');
				
						$va_object_list[$vs_color] = $pn_object_id; 
				
						Session::setVar('itinera_object_list', $va_object_list);
						# --- just set the object list to the one object you want to add on
						$this->view->setVar('object_list', array($vs_color => $pn_object_id));
					}
 				break;
 				# ------------------------------
 				case "remove":
 					$pn_entity_id = $this->request->getParameter('id', pInteger);
 					if(($vn_i = array_search($pn_entity_id, $va_entity_list)) !== false) {
						unset($va_entity_list[$vn_i]);
						Session::setVar('itinera_entity_list', $va_entity_list);
					}
					$pn_object_id = $this->request->getParameter('object_id', pInteger);
 					if(($vn_i = array_search($pn_object_id, $va_object_list)) !== false) {
						unset($va_object_list[$vn_i]);
						Session::setVar('itinera_object_list', $va_object_list);
					}
 				break;
 				# ------------------------------
 				default:
 					$this->view->setVar('entity_list', $va_entity_list);
 					$this->view->setVar('object_list', $va_object_list); 			
 				break;
 				# ------------------------------
 			}
 			
 			
			
			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);

 		 	if($ps_mode != "remove"){
				$this->render("Chronology/get_html.php");
			}
			
			
 		}
		# ------------------------------------------------------
		public function getTimelineData(){
			if (!is_array($va_entity_list = Session::getVar('itinera_entity_list'))) { $va_entity_list = array(); }
			if (!is_array($va_object_list = Session::getVar('itinera_object_list'))) { $va_object_list = array(); }
			$va_timeline_data = array();
			
			$vn_first_date = null;
			$vs_first_date = null;
			$vs_first_year = null;
			$vn_end_date = null;
			$vs_end_date = null;
			$vs_end_year = null;
			# --- first loop through the entities
			foreach ($va_entity_list as $vs_color => $vn_id) {
				$t_entity = new ca_entities($vn_id);
				$va_stops = $t_entity->get('ca_tour_stops.stop_id', ['returnAsArray' => true]);
				$qr_stops = caMakeSearchResult('ca_tour_stops', $va_stops, array('sort' => 'ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate'));
				while($qr_stops->nextHit()) {
					$va_raw_dates = array_shift(array_shift($qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate', array('rawDate' => 1, 'returnWithStructure' => 1))));
					$va_dates = array();
					$vs_start = "";
					if($vs_start = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['start'], array('timeOmit' => true))){
						$va_dates[] = $vs_start;
						if(!$vn_first_date || $vn_first_date > $va_raw_dates['tourStopDateIndexingDate']['start']){
							$vs_first_date = $vs_start;
							$vn_first_date = $va_raw_dates['tourStopDateIndexingDate']['start'];
							$vs_first_year = floor($va_raw_dates['tourStopDateIndexingDate']['start']);
						}
					}
					$vs_end = "";
					if($vs_end = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['end'], array('timeOmit' => true))){
						if($vs_end != $vs_start){
							$va_dates[] = $vs_end;
						}
						if(!$vn_end_date || $vn_end_date < $va_raw_dates['tourStopDateIndexingDate']['end']){
							$vs_end_date = $vs_end;
							$vn_end_date = $va_raw_dates['tourStopDateIndexingDate']['end'];
							$vs_end_year = ceil($va_raw_dates['tourStopDateIndexingDate']['end']);
						}
					}
					$vs_date = $qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate');
					if(is_array($va_dates) && sizeof($va_dates)){
						$va_timeline_data[] = array(
								"dates" => $va_dates,
								"title" => $vs_date."<br/>".$t_entity->get('ca_entities.preferred_labels')."<br/>".$qr_stops->get('ca_tour_stops.preferred_labels'),
								"color" => "#".$vs_color
							);
					}
				}
			}
			# --- objects
			foreach ($va_object_list as $vs_color => $vn_id) {
				$t_object = new ca_objects($vn_id);
				$va_stops = $t_object->get('ca_tour_stops.stop_id', ['returnAsArray' => true]);
				$qr_stops = caMakeSearchResult('ca_tour_stops', $va_stops, array('sort' => 'ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate'));
				while($qr_stops->nextHit()) {
					$va_raw_dates = array_shift(array_shift($qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate', array('rawDate' => 1, 'returnWithStructure' => 1))));
					$va_dates = array();
					$vs_start = "";
					if($vs_start = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['start'], array('timeOmit' => true))){
						if($va_raw_dates['tourStopDateIndexingDate']['start'] < 0){
							# --- bc dates are problems - this is super hacky!
							$vs_start = "January 1 101";
						}
						$va_dates[] = $vs_start;
						if(!$vn_first_date || $vn_first_date > $va_raw_dates['tourStopDateIndexingDate']['start']){
							$vs_first_date = $vs_start;
							if($va_raw_dates['tourStopDateIndexingDate']['start'] < 0){
								# --- bc dates are problems - this is super hacky!
								$vn_first_date = 101.0101;
							}else{
								$vn_first_date = $va_raw_dates['tourStopDateIndexingDate']['start'];
							}
							$vs_first_year = floor($va_raw_dates['tourStopDateIndexingDate']['start']);
							
						}
					}
					$vs_end = "";
					if($vs_end = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['end'], array('timeOmit' => true))){
						if($vs_end != $vs_start){
							$va_dates[] = $vs_end;
						}
						if(!$vn_end_date || $vn_end_date < $va_raw_dates['tourStopDateIndexingDate']['end']){
							$vs_end_date = $vs_end;
							$vn_end_date = $va_raw_dates['tourStopDateIndexingDate']['end'];
							$vs_end_year = ceil($va_raw_dates['tourStopDateIndexingDate']['end']);
						}
					}
					$vs_date = $qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate');
					if(is_array($va_dates) && sizeof($va_dates)){
						$va_timeline_data[] = array(
								"dates" => $va_dates,
								"title" => $vs_date."<br/>".$t_object->get('ca_objects.preferred_labels')."<br/>".$qr_stops->get('ca_tour_stops.preferred_labels'),
								"color" => "#".$vs_color
							);
					}
				}
			}
			
			
			
			
			
			
			
			# --- make the start a little early since the timeline chops it some
			$vs_first_date = caGetLocalizedHistoricDate($vn_first_date - 1, array('timeOmit' => true));
			# --- figure out the range of years so can show the entire timeline on load
			$vn_year_span = $vs_end_year - ($vs_first_year - 1);
			$this->view->setVar('timeline_data', array("events" => $va_timeline_data, "start" => $vs_first_date, "end" => $vs_end_date, "yearSpan" => $vn_year_span));
 			
 			$this->render('Chronology/get_timeline_data_json.php');
		}
		# ------------------------------------------------------
 	}
