<?php
/* ----------------------------------------------------------------------
 * themes/uga/controllers/FindingAidController.php : 
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
 	require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
 	require_once(__CA_MODELS_DIR__."/ca_lists.php");
 	
 	class ProgramHistoryController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 *
 		 */
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			$va_access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $va_access_values;
 			$this->view->setVar("access_values", $va_access_values);
 			caSetPageCSSClasses(array("program"));
 			MetaTagManager::setWindowTitle(_t("Programing History"));
 				
 		}
 		# -------------------------------------------------------
 		
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$ps_function = strtolower($ps_function);
 			$t_occ = new ca_occurrences();
 			$t_list = new ca_lists();
 			$vn_season_type_id = $t_list->getItemIDFromList('occurrence_types', 'season');
 			$vn_event_series_type_id = $t_list->getItemIDFromList('occurrence_types', 'event_series'); 			
 			if($ps_function == "index"){
 				# --- start with seasons
 				# --- get the top of the hierarchy
 				$o_search = caGetSearchInstance("ca_occurrences");
 				$o_search->addResultFilter('ca_occurrences.type_id', '=', $vn_season_type_id);
 				# --- not checking access cause they aren't set right
 				$qr_res = $o_search->search("*", array("sort" => "ca_occurrence_labels.name", "sort_direction" => "desc"));
				$va_series = array();
				if($qr_res->numHits()){
					$va_seasons = array();
					while($qr_res->nextHit()){
						$vs_season_sort = "";
						$o_search_series = caGetSearchInstance("ca_occurrences");
 						$o_search_series->addResultFilter('ca_occurrences.type_id', '=', $vn_event_series_type_id);
 						$o_search_series->addResultFilter('ca_occurrences.parent_id', '=', $qr_res->get("ca_occurrences.occurrence_id"));
 						$qr_res_series = $o_search_series->search("*", array("sort" => "ca_occurrence_labels.name", "sort_direction" => "desc"));
						$va_children = array();
						if($qr_res_series->numHits()){
							while($qr_res_series->nextHit()){
								$va_children[$qr_res_series->get("ca_occurrences.occurrence_id")] = array("id" => $qr_res_series->get("ca_occurrences.occurrence_id"),
													"name" => $qr_res_series->get("ca_occurrences.preferred_labels")
													);
							}
						}
						if(strpos(strtolower($qr_res->get("ca_occurrences.preferred_labels")), "fall") !== false){
							$vs_season_sort = str_replace("fall ", "", $qr_res->get("ca_occurrences.preferred_labels"));
							$vs_season_sort = str_replace("Fall ", "", $qr_res->get("ca_occurrences.preferred_labels"));
							$vs_season_sort .= ".1";
						}else{
							$vs_season_sort = str_replace("spring ", "", $qr_res->get("ca_occurrences.preferred_labels"));
							$vs_season_sort = str_replace("Spring ", "", $qr_res->get("ca_occurrences.preferred_labels"));
							$vs_season_sort .= ".2";
						}
						$va_seasons[$vs_season_sort] = array("id" => $qr_res->get("ca_occurrences.occurrence_id"),
															"name" => $qr_res->get("ca_occurrences.preferred_labels"),
															"children" => $va_children
															);
					}
				}
				ksort($va_seasons);
				$va_seasons = array_reverse($va_seasons);
				$this->view->setVar('seasons', $va_seasons);
				
				$this->render("ProgramHistory/index_html.php");
 			}else{
 				$pn_id = $this->request->getParameter("id", pInteger);
 				$t_occurrence = new ca_occurrences($pn_id);
 				$this->view->setVar("parent_name", $t_occurrence->get("ca_occurrences.preferred_labels"));
 				$this->view->setVar("parent_description", $t_occurrence->get("ca_occurrences.description"));
 				if($t_occurrence->get("type_id") == $vn_season_type_id){
 					$this->view->setVar("parent_type", "season");
 				}else{
 					$this->view->setVar("parent_type", "series");
 				}
 				# --- get the child records -> these are always productions and events
 				$o_db = new Db();
 				$q_children_series = $o_db->query("SELECT occurrence_id, type_id from ca_occurrences where parent_id = ? AND deleted != 1 AND access IN (".join(", ", $this->opa_access_values).")", $pn_id);
 				
 				if($q_children_series->numRows()){
 					$va_production_child_ids = array();
 					while($q_children_series->nextRow()){
 						$va_production_child_ids[] = $q_children_series->get("occurrence_id");
 					}
 					if(sizeof($va_production_child_ids)){
 						$qr_production_children = caMakeSearchResult("ca_occurrences", $va_production_child_ids);
 						$this->view->setVar('children', $qr_production_children);
 					}
 				}
 				
				$this->render("ProgramHistory/children_html.php");
 			}
 		}
 	}