<?php
/* ----------------------------------------------------------------------
 * app/controllers/GalleryController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_object_representations.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	
 	class FeaturedController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			caSetPageCSSClasses(array("featured"));
 			$this->view->setVar('access_values', $this->opa_access_values);
 			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
 		}
 		# -------------------------------------------------------
 		public function Tours() {
 			# --- what is the set code of the featured tours set?
 			$vs_set_code = $this->request->config->get("tours_page_set_code");
			$vs_images_set_code = $this->request->config->get("tours_page_images_set_code");
			
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => $vs_set_code));
			# Enforce access control on set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('tours_set', $t_set);
				$va_row_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values))) ? $va_tmp : array());
				$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("checkAccess" => $this->opa_access_values)));
				$va_row_to_item_ids = array();
				foreach($va_set_items as $vn_item_id => $va_item_info){
					$va_row_to_item_ids[$va_item_info["row_id"]] = $vn_item_id;
				}
				$this->view->setVar('set_id', $t_set->get("ca_sets.set_id"));
				$this->view->setVar('set_items', $va_set_items);
				$this->view->setVar('row_to_item_ids', $va_row_to_item_ids);
				$this->view->setVar('set_item_row_ids', $va_row_ids);
				$this->view->setVar('tours_results', caMakeSearchResult('ca_occurrences', $va_row_ids));
			}
			
			$t_set->load(array('set_code' => $vs_images_set_code));
			# Enforce access control on set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('songs_images_set', $t_set);
				$va_row_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values))) ? $va_tmp : array());
				if(is_array($va_row_ids) && sizeof($va_row_ids)){
					$this->view->setVar('image_row_ids', $va_row_ids);
					$this->view->setVar('image_object_id', $va_row_ids[array_rand($va_row_ids)]);
				}
			}
			
			$this->render("Featured/tours_html.php");
 		}
 		# -------------------------------------------------------
 		public function Songs() {
 			# --- what is the set code of the featured songs set?
 			$vs_set_code = $this->request->config->get("songs_page_set_code");
 			$vs_images_set_code = $this->request->config->get("songs_page_images_set_code");
			
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => $vs_set_code));
			# Enforce access control on set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('songs_set', $t_set);
				$va_row_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values))) ? $va_tmp : array());
				$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("checkAccess" => $this->opa_access_values)));
				$va_row_to_item_ids = array();
				foreach($va_set_items as $vn_item_id => $va_item_info){
					$va_row_to_item_ids[$va_item_info["row_id"]] = $vn_item_id;
				}
				$this->view->setVar('set_id', $t_set->get("ca_sets.set_id"));
				$this->view->setVar('set_items', $va_set_items);
				$this->view->setVar('row_to_item_ids', $va_row_to_item_ids);
				$this->view->setVar('set_item_row_ids', $va_row_ids);
				$this->view->setVar('songs_results', caMakeSearchResult('ca_occurrences', $va_row_ids));
			}
			
			$t_set->load(array('set_code' => $vs_images_set_code));
			# Enforce access control on set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('songs_images_set', $t_set);
				$va_row_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values))) ? $va_tmp : array());
				if(is_array($va_row_ids) && sizeof($va_row_ids)){
					$this->view->setVar('image_row_ids', $va_row_ids);
					$this->view->setVar('image_object_id', $va_row_ids[array_rand($va_row_ids)]);
				}
			}
			
			$this->render("Featured/songs_html.php");
 		}
 		# -------------------------------------------------------
		/**
 		 *
 		 */ 
		public function getTourInfoAsJSON() {
			$tour_id = $this->getRequest()->getParameter('tour_id', pInteger);
			$t_tour = new ca_occurrences($tour_id);
			if(!$t_tour->get("ca_occurrences.occurrence_id")){
				throw new ApplicationException("Invalid tour id");
			}
 			$qr_appearances = caMakeSearchResult(
				"ca_occurrences",
				$t_tour->get("ca_occurrences.related.occurrence_id", array("returnAsArray" => true, "restrictToTypes" => array("appearance"), "restrictToRelationshipTypes" => array("included"), "checkAccess" => $this->opa_access_values)),
				['checkAccess' => $this->opa_access_values]
			);

			$this->getView()->setVar('appearances', $qr_appearances);
			$this->getView()->setVar('tour', $t_tour);

			$this->render('Featured/tour_detail_storymap_json.php');
		}
 		# -------------------------------------------------------
		/**
 		 *
 		 */ 
		public function getSongInfoAsJSON() {
			$song_id = $this->getRequest()->getParameter('song_id', pInteger);
			$t_song = new ca_occurrences($song_id);
			if(!$t_song->get("ca_occurrences.occurrence_id")){
				throw new ApplicationException("Invalid song id");
			}
 			$qr_timeline_occs = caMakeSearchResult(
				"ca_occurrences",
				$t_song->get("ca_occurrences.related.occurrence_id", array("returnAsArray" => true, "restrictToTypes" => array("appearance", "album", "studio_session"), "checkAccess" => $this->opa_access_values)),
				['checkAccess' => $this->opa_access_values]
			);

			$this->getView()->setVar('timeline_occs', $qr_timeline_occs);
			$this->getView()->setVar('song', $t_song);

			$this->render('Featured/song_detail_timeline_json.php');
		}
 		# -------------------------------------------------------
	}
