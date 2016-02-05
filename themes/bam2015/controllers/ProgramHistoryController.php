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
 			# –℠
 				$vs_description = "";
 				$pn_id = $this->request->getParameter("id", pInteger);
 				$t_occurrence = new ca_occurrences($pn_id);
 				$this->view->setVar("parent_name", $vs_parent_name = $t_occurrence->get("ca_occurrences.preferred_labels"));
 				if($t_occurrence->get("type_id") == $vn_season_type_id){
 					$this->view->setVar("parent_type", "season");
 				}else{
 					$this->view->setVar("parent_type", "series");
 					$vs_parent_name_lower = strtolower($vs_parent_name);
 					if(strpos($vs_parent_name_lower, 'mlk') !== false){
 						# --- MLK Day
 						$vs_description = "<p>Every January, artists, activists, civic leaders, and community members come together in the BAM Howard Gilman Opera House to honor the legacy and share the dream of Dr. King. The largest event of its kind in New York City, this celebration is presented in partnership with the Brooklyn Borough President and Medgar Evers College, and has been a BAM tradition since 1990.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'africa') !== false){
 						# --- danceafrica
 						$vs_description = "<p>DanceAfrica, part of the Winter/Spring Season, is BAM's longest running program and America's largest celebration of African and African-American dance, music, and culture. Created in 1977, under the artistic direction of Founding Elder Chuck Davis and with the aim of heightening awareness of African culture, the festival has evolved into a beloved annual Memorial Day weekend event that brings the entire community together. In 2015, the leadership baton was passed to Abdel R. Salaam.</p>
											<p>Each year DanceAfrica welcomes a new visiting company from Africa or its diaspora at the BAM Howard Gilman Opera House. The performances include other traditional and contemporary dance companies, including the students of BAM/Restoration DanceAfrica Ensemble, and live music. The weekend-long festival also includes master classes, community events, film screenings, an art exhibition, and the one-and-only DanceAfrica outdoor bazaar, a global marketplace of African, African-American, and Caribbean arts, crafts, and food featuring over 200 vendors and attracting up to 30,000 visitors per year.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'humanities') !== false){
 						# --- Education & Humanities Spring  & Fall
 						$vs_description = "<p>BAM's Education & Humanities Department offers a comprehensive schedule of events for audiences of all ages. Programs for adult patrons include artist talks scheduled in conjunction with productions and literary events with authors. BAM also works with schools to integrate the arts into the curriculum. Students attend matinees of live performances and films, attend post-show Q&A sessions, and prepare for these visits with in-school pre-show workshops conducted by BAM teaching artists. Other school programs include in-school residencies, after-school programs for high school teens, and professional development workshops for teachers. BAM also programs events for families, including performances, concerts, films, and children's book author appearances.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'wave festival') !== false){
 						# --- Next Wave festival
 						$vs_description = "<p>BAM's Next Wave Festival is a celebrated showcase for contemporary experimental performance. Founded in 1983 by pioneering BAM president and executive producer Harvey Lichtenstein, the Next Wave Festival presented exciting new works by promising young artists, taking works that had previously been shown in downtown lofts and small \"black box\" theaters and granting them a larger stage and audience. The Next Wave grew quickly in prestige and scope into what is today's busy, vibrant festival, scheduled every year during BAM's fall season. 
											<p>Next Wave performances are often non-linear and imagistic, frequently the result of collaborations from artists in a bold grab bag of disciplines – visual artists, choreographers, composers, musicians, theater directors, playwrights, and videographers. Current executive producer Joseph V. Melillo, who came to BAM as the producing director of the first Next Wave, continues to program the festival with adventurous artists – emerging and established, local and international. The artists who've performed in the Next Wave are a veritable Who's Who of contemporary performance, and include such icons as Steve Reich, Mark Morris, Meredith Monk, Laurie Anderson, Trisha Brown, Pina Bausch, Anne Teresa De Keersmaeker, and Bill T. Jones/Arnie Zane. Many have become inextricably associated with BAM, as have some of the pieces they've presented, for instance <i>Einstein on the Beach</i> by Philip Glass and Robert Wilson.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'wave series') !== false){
 						# --- Next wave series
 						$vs_description = "<p>The Next Wave Series, the predecessor of The Next Wave Festival, ran three seasons – Fall 1981, Fall 1982, and Spring 1983. Upon his appointment as president in 1967, Harvey Lichtenstein began introducing more adventurous programming to BAM, and in 1981 he codified that programming as a series. The first season, heavy on modern dance which Lichtenstein had studied and loved, debuted with four productions: Trisha Brown, Laura Dean, and Lucinda Childs dance companies, and Philip Glass's opera <i>Satyagraha</i>. When audiences responded favorably, the Series grew into the more extensive Next Wave Festival, launched in Fall 1983.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'dancemotion') !== false){
 						# --- DanceMotion USA℠
 						$vs_description = "<p>DanceMotion USA℠, a program of the Bureau of Education and Cultural Affairs of the US Department of State, and produced by BAM, is a cross-cultural exchange program that connects America's finest dance companies with international artists and communities. It launched in 2010.</p>
 											<p>BAM works with US embassies to establish partnerships with leading cultural, social service, community, and educational organizations abroad to establish residencies for US dance companies, in order to foster cultural sharing and engagement. While in residence, participating US dance companies provide workshops and outreach events, lead master classes for local dancers, participate in collaborative creative sessions with local artists, and offer public performances and artist discussions. To complete the cross-cultural exchange, the program brings foreign artists to the US to collaborate with American artists.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'chelsea') !== false){
 						# --- Chelsea Theater spring and fall
 						$vs_description = "<p>The Chelsea Theater Center was established in NYC in 1965, and in 1968 became the resident company at BAM. Company repertoire was an eclectic mix of new plays, lesser known classics, neglected plays, groundbreaking British and European plays, and plays by writers better known in other genres. One production, Hal Prince's environmental staging of Leonard Bernstein's <i>Candide</i>, moved to Broadway where it ran for two years. The Chelsea Theater attracted many talented actors, often at the dawn of their careers, including Glenn Close, Meryl Street, Frank Langella, and Des McAnuff. In 1978, after a decade at BAM, the Chelsea Theater was struggling for survival and was forced to end its residency.</p>";
 					}
 				}
 				$this->view->setVar("parent_description", $vs_description);
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