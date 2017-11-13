<?php
/* ----------------------------------------------------------------------
 * controllers/RoutesController.php
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
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_entities.php");
 
 	class RoutesController extends BaseItineraController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			AssetLoadManager::register('leaflet');
 			AssetLoadManager::register('slider');
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function Index() {
 			if (!is_array($va_entity_list = $this->request->session->getVar('itinera_entity_list'))) { $va_entity_list = array(); }
 			if (!is_array($va_object_list = $this->request->session->getVar('itinera_object_list'))) { $va_object_list = array(); }
 			
			$pn_entity_id = $this->request->getParameter('id', pInteger);
			
			if ($pn_entity_id && !in_array($pn_entity_id, $va_entity_list)) { 
				$t_entity = new ca_entities($pn_entity_id);
				
				$vs_color = itineraGetUnusedColor($va_entity_list, $t_entity->get('ca_entities.color'));
				
				$va_entity_list[$vs_color] = $pn_entity_id; 
				
 				$this->request->session->setVar('itinera_entity_list', $va_entity_list);
			}
			
			$pn_object_id = $this->request->getParameter('object_id', pInteger);
			
			if ($pn_object_id && !in_array($pn_object_id, $va_object_list)) { 
				$t_object = new ca_objects($pn_object_id);
				
				$vs_color = itineraGetUnusedColor($va_object_list, 'cc0000');
				
				$va_object_list[$vs_color] = $pn_object_id; 
				
 				$this->request->session->setVar('itinera_object_list', $va_object_list);
			}
 			
 			$this->render('Routes/index_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function Get() {
 			if (!is_array($va_entity_list = $this->request->session->getVar('itinera_entity_list'))) { $va_entity_list = array(); }
 			if (!is_array($va_object_list = $this->request->session->getVar('itinera_object_list'))) { $va_object_list = array(); }
 			
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
 							
 							$vs_color = itineraGetUnusedColor($va_entity_list, $t_entity->get('ca_entities.color'));
							
 							$va_entity_list[$vs_color] = $pn_entity_id; 
 							$va_added_entity_ids[] = $pn_entity_id; 
 						}
 						break;	
 				}
 				
 				$this->request->session->setVar('itinera_entity_list', $va_entity_list);
 				 				
				$this->view->setVar('added_entity_ids', $va_added_entity_ids);
				$this->view->setVar('removed_entity_ids', $va_removed_entity_ids);
 			}
 			
 			$va_added_object_ids = $va_removed_object_ids = array();
 			if ($pn_object_id = $this->request->getParameter('object_id', pInteger)) {
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
 							
 							$vs_color = itineraGetUnusedColor($va_object_list, $t_object->get('ca_objects.color'));
							
 							$va_object_list[$vs_color] = $pn_object_id; 
 							$va_added_object_ids[] = $pn_object_id; 
 						}
 						break;	
 				}
 				
 				$this->request->session->setVar('itinera_object_list', $va_object_list);
 				 				
				$this->view->setVar('added_object_ids', $va_added_object_ids);
				$this->view->setVar('removed_object_ids', $va_removed_object_ids);
 			}
			

			$this->view->setVar('entity_list', $va_entity_list);
			$this->view->setVar('object_list', $va_object_list);

 			$this->render('Routes/get_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function GetMapDataOLD() {
 			$ps_entity_ids = $this->request->getParameter('ids', pString);	// if set return data for a specific entity rather than the list
 			$pa_entity_ids = $ps_entity_ids ? explode(';', $ps_entity_ids) : array();
 			if (!is_array($va_entity_list = $this->request->session->getVar('itinera_entity_list'))) { $va_entity_list = array(); }
 			
 			$ps_object_ids = $this->request->getParameter('object_ids', pString);	// if set return data for a specific object rather than the list
 			$pa_object_ids = $ps_object_ids ? explode(';', $ps_object_ids) : array();
 			if (!is_array($va_object_list = $this->request->session->getVar('itinera_object_list'))) { $va_object_list = array(); }
 			
 			$va_map_data = array();
 			
 			$va_used_colors = array_flip($va_entity_list);
 			if (sizeof($pa_entity_ids) > 0) { 
 				// assign colors
 				$va_tmp = array();
 				foreach($pa_entity_ids as $vn_entity_id) {
 					$vs_color = itineraGetUnusedColor($va_entity_list, $va_used_colors[$vn_entity_id]);
 					$va_tmp[$vs_color] = $vn_entity_id;
 				}
 				$va_entity_list = $va_tmp; 
 			}
 			
 			if (sizeof($va_entity_list) > 0) {
 				$qr_res = caMakeSearchResult('ca_entities', array_values($va_entity_list));
 			
 				while($qr_res->nextHit()) {
 					$vn_entity_id = $qr_res->get('ca_entities.entity_id');
 					
 					$va_coord_list = array();
 					
 					if (is_array($va_stop_ids = $qr_res->get('ca_tour_stops.stop_id', array('returnAsArray' => true))) && sizeof($va_stop_ids)) {
 						$qr_stops = caMakeSearchResult('ca_tour_stops', $va_stop_ids);
 						while($qr_stops->nextHit()) {
 							$va_georefs = $qr_stops->get('ca_places.georeference', array('returnWithStructure' => true,'returnAsArray' => true));
 							$va_dates = $qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate', array('returnWithStructure' => true, 'returnAsArray' => true, 'rawDate' => true));
 							
 							$vn_start = $vn_end = null;
 							foreach(array_shift($va_dates) as $va_date_by_id) {
 								foreach($va_date_by_id as $vn_id => $va_date) {
 									$vn_start = $va_date['start'];
 									$vn_end = $va_date['end'];
 									break(2);
 								}
 							}
 							
 							if (is_array($va_georefs) && (is_array($va_georef_list = array_shift($va_georefs)))) {
								foreach($va_georef_list as $vn_i => $va_coord) {
									//$vs_coord_proc = preg_replace("![\[\]]+!", "", $va_coord['georeference']);
									if(preg_match('!\[([^\]]+)\]!', $va_coord['georeference'], $va_matches)) {
										$vs_coord_proc = $va_matches[1];
									} else {
										$vs_coord_proc = preg_replace("![\[\]]+!", "", $va_coord['georeference']);
									}
									$va_points = explode(';', $vs_coord_proc);
									$va_parsed_points = array();
									foreach($va_points as $vs_point) {
										$va_parsed_points[] = explode(',', $vs_point);
									}
								
									$vs_stop = $qr_stops->getWithTemplate('<div class="travelerMapListArtistPopupImage">^ca_entities.agentMedia</div> <strong>^ca_entities.preferred_labels.name</strong><br/>^ca_tour_stops.preferred_labels.name</br>^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate<br/>^ca_tour_stops.tour_stop_description<br/><br/><ifdef code="ca_list_items.preferred_labels"><em>Source: ^ca_list_items.preferred_labels</em></ifdef>');
								
									if (sizeof($va_points) > 1) {
										$va_coord_list[] = array('type' => 'polygon', 'text' => $vs_stop, 'coordinates' => $va_parsed_points, 'start' => $vn_start, 'end' => $vn_end);
									} else {
										$va_coord_list[] = array('type' => 'point', 'text' => $vs_stop, 'coordinates' => $va_parsed_points[0], 'start' => $vn_start, 'end' => $vn_end);
									}
								}
							}
 						}
 					}
 					
 					
 					$va_map_data['entity_'.$vn_entity_id] = array(
 						'id' => $vn_entity_id,
 						'name' => $qr_res->get('ca_entities.preferred_labels.displayname'),
 						'color' => $va_used_colors[$vn_entity_id],
 						'stops' => $va_coord_list
 					);
 				}
 			}
 			
 			$va_used_colors = array_flip($va_object_list);
 			if (sizeof($pa_object_ids) > 0) { 
 				// assign colors
 				$va_tmp = array();
 				foreach($pa_object_ids as $vn_object_id) {
 					$vs_color = itineraGetUnusedColor($va_object_list, $va_used_colors[$vn_object_id]);
 					$va_tmp[$vs_color] = $vn_object_id;
 				}
 				$va_object_list = $va_tmp; 
 			}
 			
 			if (sizeof($va_object_list) > 0) {
 				$qr_res = caMakeSearchResult('ca_objects', array_values($va_object_list));
 			
 				while($qr_res->nextHit()) {
 					$vn_object_id = $qr_res->get('ca_objects.object_id');
 					
 					$va_coord_list = array();
 					
 					if (is_array($va_stop_ids = $qr_res->get('ca_tour_stops.stop_id', array('returnAsArray' => true))) && sizeof($va_stop_ids)) {
 						$qr_stops = caMakeSearchResult('ca_tour_stops', $va_stop_ids);
 						while($qr_stops->nextHit()) {
 							$va_georefs = $qr_stops->get('ca_places.georeference', array('returnWithStructure' => true,'returnAsArray' => true));
 							
 							$va_dates = $qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate', array('returnWithStructure' => true, 'returnAsArray' => true, 'rawDate' => true));
 							$vn_start = $vn_end = null;
 							foreach(array_shift($va_dates) as $va_date_by_id) {
 								foreach($va_date_by_id as $vn_id => $va_date) {
 									$vn_start = $va_date['start'];
 									$vn_end = $va_date['end'];
 									break(2);
 								}
 							}
 							
 							if (is_array($va_georefs) && (is_array($va_georef_list = array_shift($va_georefs)))) {
								foreach($va_georef_list as $vn_i => $va_coord) {
									if(preg_match('!\[([^\]]+)\]!', $va_coord['georeference'], $va_matches)) {
										$vs_coord_proc = $va_matches[1];
									} else {
										$vs_coord_proc = preg_replace("![\[\]]+!", "", $va_coord['georeference']);
									}
									$va_points = explode(';', $vs_coord_proc);
									$va_parsed_points = array();
									foreach($va_points as $vs_point) {
										$va_parsed_points[] = explode(',', $vs_point);
									}
								
									$vs_stop = $qr_stops->getWithTemplate('<div class="travelerMapListArtistPopupImage">^ca_object_representations.media.icon</div> <strong>^ca_objects.preferred_labels.name</strong><br/>^ca_tour_stops.preferred_labels.name</br>^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate<br/>^ca_tour_stops.tour_stop_description<br/><br/><ifdef code="ca_list_items.preferred_labels"><em>Source: ^ca_list_items.preferred_labels</em></ifdef>');
								
									if (sizeof($va_points) > 1) {
										$va_coord_list[] = array('type' => 'polygon', 'text' => $vs_stop, 'coordinates' => $va_parsed_points, 'start' => $vn_start, 'end' => $vn_end);
									} else {
										$va_coord_list[] = array('type' => 'point', 'text' => $vs_stop, 'coordinates' => $va_parsed_points[0], 'start' => $vn_start, 'end' => $vn_end);
									}
								}
							}
 						}
 					}
 					
 					
 					$va_map_data['object_'.$vn_object_id] = array(
 						'id' => $vn_object_id,
 						'name' => $qr_res->get('ca_objects.preferred_labels.name'),
 						'color' => $va_used_colors[$vn_object_id],
 						'stops' => $va_coord_list
 					);
 				}
 			}
 			
 			
 			$this->view->setVar('entity_list', $va_entity_list);
 			$this->view->setVar('object_list', $va_object_list);
 			$this->view->setVar('map_data', $va_map_data);
 			
 			$this->render('Routes/get_map_data_json.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function GetMapData() {
 			//$ps_entity_ids = $this->request->getParameter('ids', pString);	// if set return data for a specific entity rather than the list
 			$pa_entity_ids = $ps_entity_ids ? explode(';', $ps_entity_ids) : array();
 			if (!is_array($va_entity_list = $this->request->session->getVar('itinera_entity_list'))) { $va_entity_list = array(); }
 			
 			//$ps_object_ids = $this->request->getParameter('object_ids', pString);	// if set return data for a specific object rather than the list
 			$pa_object_ids = $ps_object_ids ? explode(';', $ps_object_ids) : array();
 			if (!is_array($va_object_list = $this->request->session->getVar('itinera_object_list'))) { $va_object_list = array(); }
 			
 			$va_map_data = array();
 			
 			$va_used_colors = array_flip($va_entity_list);
 			if (sizeof($pa_entity_ids) > 0) { 
 				// assign colors
 				$va_tmp = array();
 				foreach($pa_entity_ids as $vn_entity_id) {
 					$vs_color = itineraGetUnusedColor($va_entity_list, $va_used_colors[$vn_entity_id]);
 					$va_tmp[$vs_color] = $vn_entity_id;
 				}
 				$va_entity_list = $va_tmp; 
 			}
 			
 			if (sizeof($va_entity_list) > 0) {
 				$qr_res = caMakeSearchResult('ca_entities', array_values($va_entity_list));
 			
 				while($qr_res->nextHit()) {
 					$vn_entity_id = $qr_res->get('ca_entities.entity_id');
 					
 					$va_coord_list = array();
 					$vn_entity_start_date = "";
 					if (is_array($va_stop_ids = $qr_res->get('ca_tour_stops.stop_id', array('returnAsArray' => true, 'sort' => 'ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate'))) && sizeof($va_stop_ids)) {
 						$qr_stops = caMakeSearchResult('ca_tour_stops', $va_stop_ids);
 						while($qr_stops->nextHit()) {
 							$va_georefs = $qr_stops->get('ca_places.georeference', array('returnWithStructure' => true,'returnAsArray' => true));
 							$va_dates = $qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate', array('returnWithStructure' => true, 'returnAsArray' => true, 'rawDate' => true));
 							
 							$vn_start = $vn_end = null;
 							foreach(array_shift($va_dates) as $va_date_by_id) {
 								foreach($va_date_by_id as $vn_id => $va_date) {
 									$vn_start = $va_date['start'];
 									$vn_end = $va_date['end'];
 									break(2);
 								}
 							}
 							if(!$vn_entity_start_date || ($vn_start < $vn_entity_start_date)){
 								$vn_entity_start_date = $vn_start;
 							}
 							if (is_array($va_georefs) && (is_array($va_georef_list = array_shift($va_georefs)))) {
								foreach($va_georef_list as $vn_i => $va_coord) {
									//$vs_coord_proc = preg_replace("![\[\]]+!", "", $va_coord['georeference']);
									if(preg_match('!\[([^\]]+)\]!', $va_coord['georeference'], $va_matches)) {
										$vs_coord_proc = $va_matches[1];
									} else {
										$vs_coord_proc = preg_replace("![\[\]]+!", "", $va_coord['georeference']);
									}
									$va_points = explode(';', $vs_coord_proc);
									$va_parsed_points = array();
									foreach($va_points as $vs_point) {
										$va_parsed_points[] = explode(',', $vs_point);
									}
								
									# --- use view for full stop info in map bubbles
									$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
									$o_view->setVar("color", $va_used_colors[$vn_entity_id]);
									$o_view->setVar("icon", $qr_res->getWithTemplate('^ca_entities.agentMedia%version=icon'));
									$o_view->setVar("name", $qr_res->getWithTemplate('^ca_entities.preferred_labels.displayname'));
									$o_view->setVar("date", $qr_stops->getWithTemplate('^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate'));
									$o_view->setVar("description", $qr_stops->getWithTemplate('^ca_tour_stops.tour_stop_description'));
									$o_view->setVar("source", $qr_stops->getWithTemplate('^ca_list_items.preferred_labels'));
									
									
									# -- full stop info
									$vs_stop = $o_view->render("Routes/stop_info_full_html.php");
									#$vs_stop = '<div class="mapItem-panel"><span class="glyphicon glyphicon-check" style="color:#'.$va_used_colors[$vn_entity_id].';"></span><div class="travelerMapItemSummaryImg">'.$qr_res->getWithTemplate('^ca_entities.agentMedia%version=icon').'</div><div class="travelerMapItemSummaryText">'.$qr_res->getWithTemplate('<strong>^ca_entities.preferred_labels.displayname</strong><br/>').$qr_stops->getWithTemplate('^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate<br/>^ca_tour_stops.tour_stop_description<br/><br/><ifdef code="ca_list_items.preferred_labels"><em>Source: ^ca_list_items.preferred_labels</em></ifdef>').'</div></div>';
									
									$vs_short_text = '<div class="travelerMapItemSummary"><div class="travelerMapItemSummaryImg">'.$qr_res->getWithTemplate('^ca_entities.agentMedia%version=icon').'</div><div class="travelerMapItemSummaryText"><strong>'.$qr_res->getWithTemplate('^ca_entities.preferred_labels.displayname').'</strong><br/>'.$qr_stops->getWithTemplate('^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate').'</div></div>';
									$va_stop_info = array();
									if (sizeof($va_points) > 1) {
										$va_stop_info = array('type' => 'polygon', 'short_text' => $vs_short_text,'text' => $vs_stop, 'coordinates' => $va_parsed_points, 'start' => $vn_start, 'end' => $vn_end);
									} else {
										$va_stop_info = array('type' => 'point', 'short_text' => $vs_short_text, 'text' => $vs_stop, 'coordinates' => $va_parsed_points[0], 'start' => $vn_start, 'end' => $vn_end);
									}
									$vs_location_key = join(";", $va_parsed_points[0]);
									if(!$va_map_data[$vs_location_key]){
										$va_map_data[$vs_location_key] = array(
											'color' => $va_used_colors[$vn_entity_id],
											'id' => join(";", $va_parsed_points),
											'name' => $qr_stops->get('ca_tour_stops.preferred_labels.name'),
											'type' => (sizeof($va_points) > 1) ? 'polygon' : 'point',
											'coordinates' => (sizeof($va_points) > 1) ? $va_parsed_points : $va_parsed_points[0],
											'travelers' => array()
										);
									}
									$va_map_data[$vs_location_key]['stops'][$vn_start][] = $va_stop_info;
									if(!in_array($vn_entity_id, $va_map_data[$vs_location_key]['travelers'])){
										$va_map_data[$vs_location_key]['travelers'][] = $vn_entity_id;
									}
									$va_map_data[$vs_location_key]['traveler_stop_info']["entity".$vn_entity_id]['dates'][] = $qr_stops->getWithTemplate('^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate');
									$va_map_data[$vs_location_key]['traveler_stop_info']["entity".$vn_entity_id]['icon'] = $qr_res->getWithTemplate('^ca_entities.agentMedia%version=icon');
									$va_map_data[$vs_location_key]['traveler_stop_info']["entity".$vn_entity_id]['name'] = $qr_res->getWithTemplate('^ca_entities.preferred_labels.displayname');
								}
							}
 						}
 					}

 				}
 			}
 			$va_used_colors = array_flip($va_object_list);
 			if (sizeof($pa_object_ids) > 0) { 
 				// assign colors
 				$va_tmp = array();
 				foreach($pa_object_ids as $vn_object_id) {
 					$vs_color = itineraGetUnusedColor($va_object_list, $va_used_colors[$vn_object_id]);
 					$va_tmp[$vs_color] = $vn_object_id;
 				}
 				$va_object_list = $va_tmp; 
 			}
 			
 			
 			if (sizeof($va_object_list) > 0) {
 				$qr_res = caMakeSearchResult('ca_objects', array_values($va_object_list));
 			
 				while($qr_res->nextHit()) {
 					$vn_object_id = $qr_res->get('ca_objects.object_id');
 					
 					$va_coord_list = array();
 					
 					if (is_array($va_stop_ids = $qr_res->get('ca_tour_stops.stop_id', array('returnAsArray' => true, 'sort' => 'ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate'))) && sizeof($va_stop_ids)) {
 						$qr_stops = caMakeSearchResult('ca_tour_stops', $va_stop_ids);
 						while($qr_stops->nextHit()) {
 							$va_georefs = $qr_stops->get('ca_places.georeference', array('returnWithStructure' => true,'returnAsArray' => true));
 							$va_dates = $qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate', array('returnWithStructure' => true, 'returnAsArray' => true, 'rawDate' => true));
 							
 							$vn_start = $vn_end = null;
 							foreach(array_shift($va_dates) as $va_date_by_id) {
 								foreach($va_date_by_id as $vn_id => $va_date) {
 									$vn_start = $va_date['start'];
 									$vn_end = $va_date['end'];
 									break(2);
 								}
 							}
 							
 							if (is_array($va_georefs) && (is_array($va_georef_list = array_shift($va_georefs)))) {
								foreach($va_georef_list as $vn_i => $va_coord) {
									//$vs_coord_proc = preg_replace("![\[\]]+!", "", $va_coord['georeference']);
									if(preg_match('!\[([^\]]+)\]!', $va_coord['georeference'], $va_matches)) {
										$vs_coord_proc = $va_matches[1];
									} else {
										$vs_coord_proc = preg_replace("![\[\]]+!", "", $va_coord['georeference']);
									}
									$va_points = explode(';', $vs_coord_proc);
									$va_parsed_points = array();
									foreach($va_points as $vs_point) {
										$va_parsed_points[] = explode(',', $vs_point);
									}
								
									# --- use view for full stop info in map bubbles
									$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
									$o_view->setVar("color", $va_used_colors[$vn_object_id]);
									$o_view->setVar("icon", $qr_res->getWithTemplate('^ca_object_representations.media.icon'));
									$o_view->setVar("name", $qr_res->getWithTemplate('^ca_objects.preferred_labels.name'));
									$o_view->setVar("date", $qr_stops->getWithTemplate('^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate'));
									$o_view->setVar("description", $qr_stops->getWithTemplate('^ca_tour_stops.tour_stop_description'));
									$o_view->setVar("source", $qr_stops->getWithTemplate('^ca_list_items.preferred_labels'));
									
									
									# -- full stop info
									$vs_stop = $o_view->render("Routes/stop_info_full_html.php");
									#$vs_stop = '<div class="mapItem-panel"><span class="glyphicon glyphicon-check" style="color:#'.$va_used_colors[$vn_object_id].';"></span><div class="travelerMapItemSummaryImg">'.$qr_res->getWithTemplate('^ca_object_representations.media.icon').'</div><div class="travelerMapItemSummaryText">'.$qr_res->getWithTemplate('<strong>^ca_objects.preferred_labels.name</strong><br/>').$qr_stops->getWithTemplate('^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate<br/>^ca_tour_stops.tour_stop_description<br/><br/><ifdef code="ca_list_items.preferred_labels"><em>Source: ^ca_list_items.preferred_labels</em></ifdef>').'</div></div>';
									
									$vs_short_text = '<div class="travelerMapItemSummary"><div class="travelerMapItemSummaryImg">'.$qr_res->getWithTemplate('^ca_object_representations.media.icon').'</div><div class="travelerMapItemSummaryText"><strong>'.$qr_res->getWithTemplate('^ca_objects.preferred_labels.name')."</strong><br/>".$qr_stops->getWithTemplate('^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate').'</div></div>';
									$va_stop_info = array();
									if (sizeof($va_points) > 1) {
										$va_stop_info = array('type' => 'polygon', 'short_text' => $vs_short_text,'text' => $vs_stop, 'coordinates' => $va_parsed_points, 'start' => $vn_start, 'end' => $vn_end);
									} else {
										$va_stop_info = array('type' => 'point', 'short_text' => $vs_short_text, 'text' => $vs_stop, 'coordinates' => $va_parsed_points[0], 'start' => $vn_start, 'end' => $vn_end);
									}
									$vs_location_key = join(";", $va_parsed_points[0]);
									if(!$va_map_data[$vs_location_key]){
										$va_map_data[$vs_location_key] = array(
											'color' => $va_used_colors[$vn_object_id],
											'id' => join(";", $va_parsed_points),
											'name' => $qr_stops->get('ca_tour_stops.preferred_labels.name'),
											'type' => (sizeof($va_points) > 1) ? 'polygon' : 'point',
											'coordinates' => (sizeof($va_points) > 1) ? $va_parsed_points : $va_parsed_points[0],
											'travelers' => array()
										);
									}
									$va_map_data[$vs_location_key]['stops'][$vn_start][] = $va_stop_info;
									if(!in_array($vn_object_id, $va_map_data[$vs_location_key]['travelers'])){
										$va_map_data[$vs_location_key]['travelers'][] = $vn_object_id;
									}
									$va_map_data[$vs_location_key]['traveler_stop_info'][$vn_object_id]['dates'][] = $qr_stops->getWithTemplate('^ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate');
									$va_map_data[$vs_location_key]['traveler_stop_info'][$vn_object_id]['icon'] = $qr_res->getWithTemplate('^ca_object_representations.media.icon');
									$va_map_data[$vs_location_key]['traveler_stop_info'][$vn_object_id]['name'] = $qr_res->getWithTemplate('^ca_objects.preferred_labels.name');
								}
							}
 						}
 					}

 				}
 			}
 			# -- simplifying stops array so dates are sorted correctly
 			if(is_array($va_map_data) && sizeof($va_map_data)){
 				foreach($va_map_data as $vs_loc_key => $va_loc_info){
 					ksort($va_loc_info["stops"]);
 					$va_tmp = array();
 					foreach($va_loc_info["stops"] as $va_stops_for_date){
 						foreach($va_stops_for_date as $va_stop){
 							$va_tmp[] = $va_stop;
 						}
 					}
 					$va_map_data[$vs_loc_key]['stops'] = $va_tmp;
 				}
 			}
 			
 			
 			
 			$this->view->setVar('entity_list', $va_entity_list);
 			$this->view->setVar('object_list', $va_object_list);
 			$this->view->setVar('map_data', $va_map_data);
 			
 			$this->render('Routes/get_map_data_json.php');
 		}
 		# -------------------------------------------------------
 	}