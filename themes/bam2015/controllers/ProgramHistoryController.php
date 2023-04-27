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
 			MetaTagManager::setWindowTitle(_t("Programming History"));
 				
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
 				$pn_season_id = $this->request->getParameter("season_id", pInteger);
 				$this->view->setVar("season_id", $pn_season_id);
 				# --- start with seasons
 				# --- get the top of the hierarchy
 				$o_search = caGetSearchInstance("ca_occurrences");
 				$qr_res = $o_search->search("ca_occurrences.type_id:".$vn_season_type_id, array("sort" => "ca_occurrence_labels.name", "sort_direction" => "desc", "checkAccess" => $this->opa_access_values));
				$va_series = array();
				if($qr_res->numHits()){
					$va_seasons = array();
					while($qr_res->nextHit()){
						if(!in_array($qr_res->get("ca_occurrences.access"), $this->opa_access_values)){
							continue;
						}
						$vs_season_sort = "";
						$o_search_series = caGetSearchInstance("ca_occurrences");
 						#$o_search_series->addResultFilter('ca_occurrences.type_id', '=', $vn_event_series_type_id);
 						$o_search_series->addResultFilter('ca_occurrences.parent_id', '=', $qr_res->get("ca_occurrences.occurrence_id"));
 						$qr_res_series = $o_search_series->search("ca_occurrences.type_id:".$vn_event_series_type_id, array("sort" => "ca_occurrence_labels.name", "sort_direction" => "desc", "checkAccess" => $this->opa_access_values));
						$va_children = array();
						if($qr_res_series->numHits()){
							while($qr_res_series->nextHit()){
								if(in_array($qr_res_series->get("ca_occurrences.access"), $this->opa_access_values)){
									$va_children[$qr_res_series->get("ca_occurrences.occurrence_id")] = array(
										"id" => $qr_res_series->get("ca_occurrences.occurrence_id"),
										"name" => $qr_res_series->get("ca_occurrences.preferred_labels"
									));
								}
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
 						$vs_description = "<p>Every January, artists, activists, national and local civic leaders, and community members come together in the BAM Howard Gilman Opera House to honor the legacy of Dr. Martin Luther King, Jr.. The largest event of its kind in New York City, this celebration is presented in partnership with the Brooklyn Borough President and Medgar Evers College, and has been a BAM tradition since 1990.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'africa') !== false){
 						# --- danceafrica
 						$vs_description = "<p>DanceAfrica, part of the Winter/Spring Season, is BAM's longest running program and America's largest celebration of African and African-American dance, music, and culture. Founded in 1977 by artistic director Chuck Davis with the aim of heightening awareness of African culture, the festival has evolved into a beloved annual Memorial Day weekend event that brings together the community. Over the years, the festival has expanded to several major cities, and in 2015, the leadership baton was passed to Abdel R. Salaam.</p>
											<p>Each year DanceAfrica welcomes artists from the African diaspora at the BAM Howard Gilman Opera House. The performances include other traditional and contemporary dance companies, including students of BAM/Restoration DanceAfrica Ensemble, plus live music. The weekend-long festival also includes master classes, community events, film screenings, an art exhibition, and the one-and-only DanceAfrica outdoor bazaar, a global marketplace of African, African-American, and Caribbean arts, crafts, and food featuring over 200 vendors and attracting up to 30,000 visitors per year.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'humanities') !== false){
 						# --- Education & Humanities Spring  & Fall
 						$vs_description = "<p>Since 1861 BAM has presented educational, community, social, and humanities programming offering a comprehensive schedule of events for audiences of all ages. Programs for adults include artist talks scheduled in conjunction with productions, and literary events with authors. BAM also works with schools to integrate performing arts into the curriculum. Students attend matinees of live performances and films, attend post-show Q&A sessions, and prepare for these visits with in-school pre-show workshops conducted by BAM teaching artists. Other school programs include in-school residencies, after-school programs for high school teens, and professional development workshops for teachers. BAM also has events for families, including performances, concerts, films, block parties, and children's book author appearances.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'wave festival') !== false){
 						# --- Next Wave festival
 						$vs_description = "<p>BAM's fall Next Wave Festival is a showcase for contemporary performance. Founded in 1983 by pioneering BAM President and Executive Producer Harvey Lichtenstein, the Next Wave Festival began presenting exciting new works by known and emerging artists. The festival grew quickly in prestige, artistic scope, and geographical reach into today's vibrant festival.</p>
											<p>Next Wave performances are often collaborations by artists of varied disciplines—choreographers, composers, musicians, theater directors, playwrights, visual artists, and videographers. Current Executive Producer Joseph V. Melillo, who was the producing director of the first Next Wave, continues to program the festival with adventurous artists–both emerging and established, local and international.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'wave series') !== false){
 						# --- Next wave series
 						$vs_description = "<p>The Next Wave Series, the predecessor of the Next Wave Festival, ran in the falls of 1981 and 1982, and spring 1983. Upon his appointment as president in 1967, Harvey Lichtenstein introduced more adventurous fare to BAM, and in 1981 he codified that as a series. When audiences responded favorably, the series expanded into the Next Wave Festival.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'dancemotion') !== false){
 						# --- DanceMotion USA℠
 						$vs_description = "<p>DanceMotion USA℠, a program of the Bureau of Education and Cultural Affairs of the US Department of State and produced by BAM, is a cross-cultural exchange program connecting America's finest dance companies with international artists and communities. It launched in 2010 and has included engagement with 55 countries and 20 American companies.</p>
 											<p>BAM works with US embassies to establish partnerships with leading cultural, social service, community, and educational organizations abroad to establish residencies for US dance companies, fostering cultural sharing and engagement. The companies lead workshops, master classes, collaborative creative sessions with local artists, and give public performances and discussions.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'chelsea') !== false){
 						# --- Chelsea Theater spring and fall
 						$vs_description = "<p>The Chelsea Theater Center was established in NYC in 1965, and in 1968 became a resident company at BAM. Company repertoire was an eclectic mix of plays—new, neglected, groundbreaking British and European, lesser known classics, and authored by writers known in other genres. One production, Hal Prince's environmental staging of Leonard Bernstein's <i>Candide</i>, moved to Broadway where it ran for two years. The Chelsea Theater attracted many talented actors, often at the dawn of their careers, including Glenn Close, Meryl Streep, Frank Langella, and Des McAnuff. In 1978, after a decade at BAM, the Chelsea Theater struggled and was ended its residency.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'bam spring') !== false){
 						# --- BAM Spring
 						$vs_description = "<p>The Winter/Spring Season showcases theater, dance, and opera, and more. Major international companies alongside New York artists reflect BAM's global and local reach. Performance runs are often longer in length than in the fall, and can include partnership projects of, for example, repertory theater or live renditions of public radio programs.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'presents') !== false){
 						# --- BAM Presents
 						$vs_description = "<p>BAM Presents is a series programmed separately from Next Wave or BAM Spring. It typically includes widely popular talks, music, or comedy that sell out the Opera House as one-night-only events.</p>";
  					}elseif(strpos($vs_parent_name_lower, 'bam fall') !== false){
 						# --- BAM Fall
 						$vs_description = "<p>Events listed under the BAM Fall umbrella are ones scheduled for fall season but not programmed under the rubric of the Next Wave Festival. These events, dependent on opportunity and booked individually, have included fall engagements by American Ballet Theatre and Les Arts Florissants, and the 2009 Sydney Theatre Company production of <i>A Streetcar Named Desire</i> that starred Cate Blanchett.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'sundance') !== false){
 						# --- Sundance Institute at BAM
 						$vs_description = "<p>The Sundance Institute at BAM was presented during the spring seasons of 2006, 2007, and 2008. It presented independent feature films and shorts straight from the Sundance Film Festival, and showcased their dynamic emerging filmmakers. Other programs included panel discussions with artists, musical performances by Sundance composers, and theater events developed through Sundance Institute's Theatre Program.</p>";
 					}elseif(strpos($vs_parent_name_lower, 'philharmonic') !== false){
 						# --- Brooklyn Philharmonic Fall & Spring
 						$vs_description = "<p>The Brooklyn Philharmonic Orchestra gave its first concert in November of 1857 and helped launch the original Brooklyn Academy of Music. The name was changed to Brooklyn Philharmonia in 1954, continuing to call BAM home. Though the two institutions parted in 1971, BPO continued to perform at BAM and other venues. BPO built its strong reputation by presenting innovative programming and championing new music. Conductors and artistic directors have included founding conductor Siegfried Landau, American composer Lukas Foss who presented a well-known “Meet the Moderns” series, and Robert Spano. BPO dissolved in 2013 after struggling financially.</p>";
 					}elseif(strpos($vs_parent_name_lower, '651 arts') !== false){
 						# --- 651 Arts
 						$vs_description = "<p>Founded in 1988, 651 ARTS took its name from Fulton Street address of the BAM Majestic Theater (now the BAM Harvey Theater), where it was originally headquartered. Committed to developing, producing, and presenting contemporary African-American arts programming in theater, dance, humanities, and music, it was established to provide programs and services that connect meaningfully with Brooklyn's cultural communities.</p>";
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