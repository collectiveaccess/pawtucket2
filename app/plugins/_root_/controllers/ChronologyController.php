<?php
/* ----------------------------------------------------------------------
 * controllers/ChronologyController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
 	require_once(__CA_LIB_DIR__."/ca/BaseSearchController.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/OccurrenceSearch.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/ObjectSearch.php");
	require_once(__CA_LIB_DIR__."/ca/Browse/OccurrenceBrowse.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 
 	class ChronologyController extends BaseSearchController {
 		# ------------------------------------------------------- 	
 		private $opb_cache_searches = false;
 		# -------------------------------------------------------
 		protected $ops_periods = array(
			1 => array("start" =>1904, "end" => 1904, "label" => "1904", "displayAllYears" => "0"),
			2 => array("start" =>1905, "end" => 1909, "label" => "1905 - 1909", "displayAllYears" => "1"),
			3 => array("start" =>1910, "end" => 1912, "label" => "1910 - 1912", "displayAllYears" => "1"),
			4 => array("start" =>1913, "end" => 1917, "label" => "1913 - 1917", "displayAllYears" => "1"),
			5 => array("start" =>1918, "end" => 1918, "label" => "1918", "displayAllYears" => "0"),
			6 => array("start" =>1919, "end" => 1921, "label" => "1919 - 1921", "displayAllYears" => "1"),
			7 => array("start" =>1922, "end" => 1923, "label" => "1922 - 1923", "displayAllYears" => "1"),
			8 => array("start" =>1924, "end" => 1988, "label" => "1924 - 1988", "displayAllYears" => "0")
		);
		protected $ops_jumpToList = array(
			'Birth (1904)' => 1904,
			'Childhood (1907)' => 1907,
			'Adolescence (1918)' => 1918,
			'Academic Education (1924)' => 1924,
			'Guggenheim Fellowship (1927)' => 1927,
			'Early career (1932)' => 1932,
			'Wartime Activism (1942)' => 1942,
			'MacDougal Alley studio (1943)' => 1943,
			'Bollingen travels (1949)' => 1949,
			'Return to Japan (1950)' => 1950,
			'Mid Career (1955)' => 1955,
			'Long Island City studio (1961)' => 1961,
			'Mure-cho studio (1969)' => 1969,
			'Late Career (1981)' => 1981,
			'Long Island City Museum (1981)' => 1981,
			'Death (1988)' => 1988
		);
 			
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			// redirect user if not logged in
			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            }
            
            $t_list = new ca_lists();
			$pn_type_restriction_id = $t_list->getItemIDFromList('occurrence_types', 'chronology');
			
			// set type restrictions for searches 
 			$o_search_result_context = new ResultContext($this->request, "ca_occurrences", 'basic_search');
 			$o_search_result_context->setTypeRestriction($pn_type_restriction_id);
 			$o_search_result_context->saveContext();
		}
 		# -------------------------------------------------------
 		function Index() {
 			JavascriptLoadManager::register('panel');
 			$va_periods = $this->ops_periods;
 			$this->view->setVar('periods', $va_periods);
 			
 			$va_jumpToList = $this->ops_jumpToList;
 			$this->view->setVar('jumpToList', $va_jumpToList);
 			
 			$this->render('Chronology/landing_html.php');
 		}
 		# -------------------------------------------------------
 		function Detail() {
 			JavascriptLoadManager::register('panel');
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			
 			$va_jumpToList = $this->ops_jumpToList;
 			$this->view->setVar('jumpToList', $va_jumpToList);
 			
 			$va_periods = $this->ops_periods;
 			$this->view->setVar('periods', $va_periods);
 			$vn_year = $this->request->getParameter('year', pInteger);
 			$vn_period = $this->request->getParameter('period', pInteger);
			if(!$vn_period){
				if($vn_year){
					# --- determine the period from the year
					foreach($va_periods as $i => $va_per_info){
						if(($vn_year >= $va_per_info["start"]) && ($vn_year <= $va_per_info["end"])){
							$vn_period = $i;
							break;
						}
					}
				}
			}
			$this->view->setVar('period', $vn_period);
			if(!$vn_year){
				$vn_year = $va_periods[$vn_period]["start"];
			}
			$this->view->setVar('year', $vn_year);
 			
 			$vn_y = "";
 			if($va_periods[$vn_period]["displayAllYears"] == 1){
 				$vn_y = $va_periods[$vn_period]["start"]." to ".$va_periods[$vn_period]["end"];
 			}else{
 				$vn_y = $vn_year;
 			}
 			$o_search = new OccurrenceSearch();
			
			$t_list = new ca_lists();
			$vn_chronology_type_id = $t_list->getItemIDFromList('occurrence_types', 'chronology');
			$vn_exhibition_type_id = $t_list->getItemIDFromList('occurrence_types', 'exhibition');
			$vn_bibliography_type_id = $t_list->getItemIDFromList('occurrence_types', 'bibliography');
			$vn_artwork_type_id = $t_list->getItemIDFromList('object_types', 'artwork');
			$vn_chron_images_type_id = $t_list->getItemIDFromList('object_types', 'chronology_image');
			
			$va_years_info = array();

			$qr_events = $o_search->search("ca_occurrences.access:1 AND ca_occurrences.type_id:{$vn_chronology_type_id} AND ca_occurrences.date.parsed_date:\"".$vn_y."\"", array("sort" => "ca_occurrences.date.parsed_date", "no_cache" => !$this->opb_cache_searches));
			
			$va_event_ids = array();
			if($qr_events->numHits() > 0){
				while($qr_events->nextHit()){
					$va_event_ids[] = $qr_events->get("occurrence_id");
				}
			}
			$opo_result_context = new ResultContext($this->request, "ca_occurrences", "basic_search");
 		
			foreach($va_event_ids as $vn_event_id){
				if($opo_result_context->getIndexInResultList($vn_event_id) != '?'){
					$this->view->setVar("show_back_button", 1);
					break;
				}
			}
			$qr_events->seek(0);
			$va_years_info["events"] = $qr_events;
			
			$qr_exhibitions = $o_search->search("ca_occurrences.access:1 AND ca_occurrences.type_id:{$vn_exhibition_type_id} AND ca_occurrences.date.parsed_date:\"".$vn_y."\"", array("sort" => "ca_occurrences.date.parsed_date", "no_cache" => !$this->opb_cache_searches));
			$va_years_info["exhibitions"] = $qr_exhibitions;
			
			$qr_bibliographies = $o_search->search("ca_occurrences.access:1 AND ca_occurrences.type_id:{$vn_bibliography_type_id} AND ca_occurrences.bib_year_published:\"".$vn_y."\"", array("sort" => "ca_occurrences.bib_year_published", "no_cache" => !$this->opb_cache_searches));
			$va_years_info["bibliographies"] = $qr_bibliographies;
			
			$o_obj_search = new ObjectSearch();
			$qr_artworks = $o_obj_search->search("ca_objects.access:1 AND ca_objects.date.parsed_date:\"".$vn_y."\" AND ca_objects.type_id:{$vn_artwork_type_id}", array("sort" => "ca_objects.idno_sort", "no_cache" => !$this->opb_cache_searches));
			$va_years_info["artworks"] = $qr_artworks;
			
			$qr_chron_images = $o_obj_search->search("ca_objects.access:1 AND ca_objects.date.parsed_date:\"".$vn_y."\" AND ca_objects.type_id:{$vn_chron_images_type_id}", array("sort" => "ca_objects.date.parsed_date", "no_cache" => !$this->opb_cache_searches));
			$va_years_info["chron_images"] = $qr_chron_images;
			
			$this->view->setVar('years_info', $va_years_info);
			$this->view->setVar('num_images', $qr_chron_images->numHits());
			$va_reps = array();
			if($qr_chron_images->numHits() > 0){
				while($qr_chron_images->nextHit()){
					$t_image_object = new ca_objects($qr_chron_images->get("object_id"));
					# Media representations to display (objects only)
					if ($t_primary_rep = $t_image_object->getPrimaryRepresentationInstance()) {
						if (!sizeof($va_access_values) || in_array($t_primary_rep->get('access'), $va_access_values)) { 		// check rep access
							# --- build array of thumbnails on related images for display under main image
							$va_temp = array();
							$va_temp["representation_id"] = $t_primary_rep->get("representation_id");
							$va_temp["rep_tinyicon"] = $t_primary_rep->getMediaTag('media', 'tinyicon');
							$va_temp["object_id"] = $qr_chron_images->get("object_id");
							$va_reps[$qr_chron_images->get("object_id")] = $va_temp;
							if(!$vn_display_image_set){
								$vn_display_image_set = 1;
								$this->view->setVar("image_object_id", $qr_chron_images->get("object_id"));
								$this->view->setVar("image_description", $t_image_object->get("ca_objects.description"));
								$this->view->setVar("image_photographer", $t_image_object->get("ca_objects.provenance"));
								$this->view->setVar('t_primary_rep', $t_primary_rep);
								
								$va_rep_display_info = caGetMediaDisplayInfo('detail', $t_primary_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
								
								$this->view->setVar('primary_rep_display_version', $va_rep_display_info['display_version']);
								unset($va_display_info['display_version']);
								$va_rep_display_info['poster_frame_url'] = $t_primary_rep->getMediaUrl('media', $va_rep_display_info['poster_frame_version']);
								unset($va_display_info['poster_frame_version']);
								$this->view->setVar('primary_rep_display_options', $va_rep_display_info);
							}
						}
					}
				}
			}
			$this->view->setVar("reps", $va_reps);
 			$this->render('Chronology/year_detail_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 * Returns content for overlay containing details for object representation
 		 */ 
 		public function GetChronologyMediaOverlay() {
 			$this->_renderMediaView("ajax_chronology_media_overlay_html", "media_overlay");
 		}
 		# ------------------------------------------------------- 		
 		/**
 		 * Returns content for overlay containing details for object representation
 		 */ 
 		private function _renderMediaView($ps_view_name, $ps_media_context) {
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			$pn_year = $this->request->getParameter('year', pInteger);
 			$this->view->setVar("year", $pn_year);
 			$va_periods = $this->ops_periods;
 			
 			$this->view->setVar('object_id', $pn_object_id);
 			$t_object = new ca_objects($pn_object_id);
 			
 			# --- get caption and photocredit
			$this->view->setVar("caption", $t_object->get("description"));
			$this->view->setVar("photographer", $t_object->get("provenance"));

 			$t_rep = new ca_object_representations($pn_representation_id);
 			$this->view->setVar('representation_id', $pn_representation_id);
 			$this->view->setVar('t_object_representation', $t_rep);
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			if (!$t_object->getPrimaryKey()) { die("Invalid object_id"); }
 			if (!$t_rep->getPrimaryKey()) { die("Invalid representation_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_object->get('access'), $va_access_values))) { die("Invalid object_id"); }
 			if (sizeof($va_access_values) && (!in_array($t_rep->get('access'), $va_access_values))) { die("Invalid rep_id"); }
 			
			$this->view->setVar('t_display_rep', $t_rep);
			
			// Get media for display using configured rules
			$va_rep_display_info = caGetMediaDisplayInfo($ps_media_context, $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			
			// set version
			$this->view->setVar('display_version', $va_rep_display_info['display_version']);
			
			// set other options
			$this->view->setVar('display_options', $va_rep_display_info);
	
			// Get all representation as icons for navigation
			# --- do a search for all chronology image objects
			# --- determine the period from the year
			foreach($va_periods as $i => $va_per_info){
				if(($pn_year >= $va_per_info["start"]) && ($pn_year <= $va_per_info["end"])){
					$vn_period = $i;
					break;
				}
			}
			# --- what is year to search by?
			$vn_y = "";
 			if($va_periods[$vn_period]["displayAllYears"] == 1){
 				$vn_y = $va_periods[$vn_period]["start"]."-".$va_periods[$vn_period]["end"];
 			}else{
 				$vn_y = $pn_year;
 			}
 			# --- get type is for chron images
 			$t_list = new ca_lists();
			$vn_chron_images_type_id = $t_list->getItemIDFromList('object_types', 'chronology_image');
			$o_obj_search = new ObjectSearch();
			$qr_chron_images = $o_obj_search->search("ca_objects.access:1 AND ca_objects.date.parsed_date:\"".$vn_y."\" AND ca_objects.type_id:{$vn_chron_images_type_id}", array("sort" => "ca_objects.date.parsed_date", "no_cache" => !$this->opb_cache_searches));
			$va_thumbnails = array();
			if($qr_chron_images->numHits() > 0){
				$t_image_objects = new ca_objects();
				$i = 1;
				while($qr_chron_images->nextHit()){
					$t_image_objects->load($qr_chron_images->get("ca_objects.object_id"));
					if ($t_primary_rep = $t_image_objects->getPrimaryRepresentationInstance()){
						$va_temp =  array();
						if (!sizeof($va_access_values) || in_array($t_primary_rep->get('access'), $va_access_values)) {
							$va_temp["representation_id"] = $t_primary_rep->get("representation_id");
							$va_temp["rep_icon"] = $t_primary_rep->getMediaTag('media', 'icon');
							$va_temp["rep_tiny"] = $t_primary_rep->getMediaTag('media', 'tinyicon');
							$va_temp["object_id"] = $qr_chron_images->get("ca_objects.object_id");

							$va_thumbnails[$qr_chron_images->get("ca_objects.object_id")] = $va_temp;
							if($vn_getNext == 1){
								$this->view->setVar("next_object_id", $qr_chron_images->get("object_id"));
								$this->view->setVar("next_representation_id", $t_primary_rep->get("representation_id"));
								$vn_getNext = 0;
							}
							if($qr_chron_images->get("object_id") == $pn_object_id){
								$this->view->setVar("representation_index", $i);
								$this->view->setVar("previous_object_id", $vn_prev_obj_id);
								$this->view->setVar("previous_representation_id", $vn_prev_rep_id);
								$vn_getNext = 1;
							}
							$vn_prev_obj_id = $qr_chron_images->get("object_id");
							$vn_prev_rep_id = $t_primary_rep->get("representation_id");
							
							$i++;
						}
					}
				}
			}
			$this->view->setVar('reps', $va_thumbnails);			
 			
 			return $this->render("Chronology/{$ps_view_name}.php");
 		}
 		# -------------------------------------------------------
 		/**
 		 * Returns content for overlay containing list of years
 		 */ 
 		public function YearsList() {
 			return $this->render("Chronology/years_list_html.php");
 		}
 		# ------------------------------------------------------- 
 		/**
 		 * Returns content for overlay containing list of years
 		 */ 
 		public function PeriodsList() {
 		 	$va_jumpToList = $this->ops_jumpToList;
 			$this->view->setVar('jumpToList', $va_jumpToList);
 			
 			return $this->render("Chronology/periods_list_html.php");
 		}
 		# ------------------------------------------------------- 
 	}
 ?>
