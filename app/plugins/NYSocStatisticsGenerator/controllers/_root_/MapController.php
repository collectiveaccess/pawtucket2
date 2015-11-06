<?php
/* ----------------------------------------------------------------------
 * controllers/MapController.php
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
 
 	class MapController extends BaseNYSocFeaturesController {
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
 			if (!is_array($va_catalogue_list = $this->request->session->getVar('catalog_list'))) { $va_catalogue_list = array(); }
 			
			$pn_catalogue_id = $this->request->getParameter('id', pInteger);
			
			if ($pn_catalogue_id && !in_array($pn_entity_id, $va_entity_list)) {
				if ($t_cat = ca_objects::find(['object_id' => $pn_catalogue_id, 'type_id' => 'catalogue'], ['returnAs' => 'firstModelInstance'])) {
					$va_catalogue_list[$pn_catalogue_id] = $pn_catalogue_id; 
				}
 				$this->request->session->setVar('catalog_list', $va_catalogue_list);
			}
			
 			
 			$this->render('Map/index_html.php');
 		}		
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		function GetMapData() {
 			if (!is_array($va_catalogue_list = $this->request->session->getVar('catalog_list'))) { $va_catalogue_list = array(); }
 			
 			$va_map_data = array();
 			$va_object_ids = ca_objects::find(['type_id' => 'bib'], ['returnAs' => 'ids']);
 			
 			if (sizeof($va_object_ids) > 0) {
 				$qr_res = caMakeSearchResult('ca_objects', $va_object_ids);
 				
 				while($qr_res->nextHit()) {
 					$vn_object_id = $qr_res->get('ca_objects.object_id');
 					
 					$va_coord_list = array();
 					
 					$va_dates = $qr_res->get('ca_objects.publication_date', ['returnAsArray' => true, 'rawDate' => true]);
					$vn_start = $vn_end = null;
					foreach($va_dates as $va_date) {
						$vn_start = $va_date['start'];
						$vn_end = $va_date['end'];
						break;
					}
					
					//if (!$vn_start && !$vn_end) { continue; }
					
					if ($vn_end > 2100) { $vn_end = $vn_start; }
					if ($vn_start < 0) { $vn_start = $vn_end; }
 					
					//publication_place_text
					$va_coord_proc = $qr_res->get('ca_objects.publication_place.publication_geo', ['returnAsArray' => true, 'coordinates' => true]);
		
					foreach($va_coord_proc as $va_coord_info) {
						$va_coord_info['latitude'] = sprintf("%3.4f", $va_coord_info['latitude']); 
						$va_coord_info['longitude'] = sprintf("%3.4f", $va_coord_info['longitude']); 
						
						$vs_key = $va_coord_info['latitude'].'/'.$va_coord_info['longitude'];
						
						$va_catalogue_ids = $qr_res->get('ca_objects.related.object_id', ['restrictToTypes' => ['catalog'], 'returnAsArray' => true]);
						if (!is_array($va_catalogue_ids) || !sizeof($va_catalogue_ids)) { continue; }
						
						$va_catalogue_ids_proc = [];
						foreach($va_catalogue_ids as $vn_catalogue_id) {
							if ($vn_catalogue_id == 8) { continue; }
							$va_catalogue_ids_proc[] = $vn_catalogue_id;
						}
							
						if (!is_array($va_map_data[$vs_key] )) {
							if (!($vs_name = $qr_res->get('ca_objects.publication_place.publication_place_text'))) { $vs_name = $va_coord_info['label']; }
							$va_map_data[$vs_key] = array(
								'id' => $vn_object_id,
								'name' => $vs_name,
								'latitude' => $va_coord_info['latitude'],
								'longitude' => $va_coord_info['longitude'],
								'count' => 1,
								'catalog_ids' => $va_catalogue_ids_proc,
								'by_date' => []
							);
						} else {
							$va_map_data[$vs_key]['count']++;
							$va_map_data[$vs_key]['catalog_ids'] = array_unique(array_merge($va_map_data[$vs_key]['catalog_ids'], $va_catalogue_ids_proc));
						}
						
						
								
					//	if (!is_array($va_catalogue_ids) || !sizeof($va_catalogue_ids)) { 	
					//		$va_catalogue_ids = [0];
					//	}			
						foreach($va_catalogue_ids as $vn_catalogue_id) {
							if ($vn_catalogue_id == 8) { continue; }
							if(is_array($va_map_data[$vs_key]['by_date'][$vn_start.'/'.$vn_end][$vn_catalogue_id][$vn_object_id])) {
								//$va_map_data[$vs_key]['by_date'][$vn_start.'/'.$vn_end][$vn_catalogue_id][$vn_object_id]['count']++;
							} else {
								$va_map_data[$vs_key]['by_date'][$vn_start.'/'.$vn_end][$vn_catalogue_id][$vn_object_id] = [
									'start' => $vn_start, 
									'end' => $vn_end,
									'count' => 1
								];
							}
						}
					}			
 				}
 			}
 			
 			$this->view->setVar('map_data', $va_map_data);
 			
 			$this->render('Map/get_map_data_json.php');
 		}
 		# -------------------------------------------------------
 	}