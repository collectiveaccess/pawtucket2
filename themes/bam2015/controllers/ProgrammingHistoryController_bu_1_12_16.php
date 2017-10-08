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
 			if($ps_function == "index"){
 				# --- start with years -> no eras in system
 				$t_list = new ca_lists();
 				$vn_year_type_id = $t_list->getItemIDFromList('occurrence_types', 'year'); 			
 				# --- get the top of the hierarchy
 				$o_search = caGetSearchInstance("ca_occurrences");
 				$o_search->addResultFilter('ca_occurrences.type_id', '=', $vn_year_type_id);
 				# --- not checking access cause they aren't set right
 				$qr_res = $o_search->search("*", array("sort" => "ca_occurrence_labels.name", "sort_direction" => "desc", "checkAccess" => $this->opa_access_values));
				$this->view->setVar('years', $qr_res);
				
				$this->render("ProgramHistory/index_html.php");
 			}else{
 				$pn_id = $this->request->getParameter("id", pInteger);
 				$t_occurrence = new ca_occurrences($pn_id);
 				$this->view->setVar("parent_name", $t_occurrence->get("ca_occurrences.preferred_labels"));
 				$t_list = new ca_lists();
 				$vn_series_type_id = $t_list->getItemIDFromList('occurrence_types', 'event_series'); 			
 				# --- get the child records
 				$o_db = new Db();
 				$q_children_series = $o_db->query("SELECT occurrence_id, type_id from ca_occurrences where parent_id = ? AND deleted != 1 AND access IN (".join(", ", $this->opa_access_values).")", $pn_id);
 				if($q_children_series->numRows()){
 					$va_series_child_ids = array();
 					$va_production_child_ids = array();
 					while($q_children_series->nextRow()){
 						if($q_children_series->get("type_id") == $vn_series_type_id){
 							$va_series_child_ids[] = $q_children_series->get("occurrence_id");
 						}else{
 							$va_production_child_ids[] = $q_children_series->get("occurrence_id");
 						}
 					}
 					if(sizeof($va_series_child_ids)){
 						$qr_series_children = caMakeSearchResult("ca_occurrences", $va_series_child_ids);
 						$this->view->setVar('series_children', $qr_series_children);
 					}
 					if(sizeof($va_production_child_ids)){
 						$qr_production_children = caMakeSearchResult("ca_occurrences", $va_production_child_ids);
 						$this->view->setVar('production_children', $qr_production_children);
 					}
 				}
 				
				$this->render("ProgramHistory/children_html.php");
 			}
 		}
 	}