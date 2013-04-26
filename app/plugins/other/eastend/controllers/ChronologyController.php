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
 	require_once(__CA_LIB_DIR__."/ca/Search/EntitySearch.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/ObjectSearch.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/PlaceSearch.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/ListItemSearch.php");
 	
 	require_once(__CA_LIB_DIR__."/ca/Browse/ObjectBrowse.php");
 	
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
	require_once(__CA_MODELS_DIR__."/ca_places.php");
	require_once(__CA_MODELS_DIR__."/ca_entities.php");
 	require_once(__CA_LIB_DIR__.'/core/GeographicMap.php');
 
 	class ChronologyController extends BaseSearchController {
 		# ------------------------------------------------------- 	
 		private $opb_cache_searches = false;
 		
 		protected $opa_periods = array(
			1 => array("start" =>1870, "end" => 1899, "label" => "1870 - 1900", "displayAllYears" => 1),
			2 => array("start" =>1900, "end" => 1919, "label" => "1900 - 1920", "displayAllYears" => 1),
			3 => array("start" =>1920, "end" => 1939, "label" => "1920 - 1940", "displayAllYears" => 1),
			4 => array("start" =>1940, "end" => 1959, "label" => "1940 - 1960", "displayAllYears" => 1),
			5 => array("start" =>1960, "end" => 1979, "label" => "1960 - 1980", "displayAllYears" => 1),
			6 => array("start" =>1980, "end" => 1999, "label" => "1980 - 2000", "displayAllYears" => 1),
			8 => array("start" =>2000, "end" => 2010, "label" => "2000 - 2010", "displayAllYears" => 1),
			7 => array("start" =>2010, "end" => 2060, "label" => "2010 - present", "displayAllYears" => 1)
		);
		
		private $opa_access_values;
		private $opn_default_period = 1;
		private $opo_plugin_config;			// plugin config file
 		private $ops_theme;						// current theme
 		private $ops_date_range;
 		
 			
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			$this->ops_theme = __CA_THEME__;																	// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/eastend/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}

 			parent::__construct($po_request, $po_response, array(__CA_APP_DIR__.'/plugins/eastend/themes/'.$this->ops_theme.'/views'));
 			
 			JavascriptLoadManager::register('smoothDivScrollVertical');
 			MetaTagManager::addLink('stylesheet', $po_request->getBaseUrlPath()."/app/plugins/eastend/themes/".$this->ops_theme."/css/eastend.css",'text/css');
 		 	
 			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/eastend/conf/eastend.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('eastend plugin is not enabled')); }

			// redirect user if not logged in
			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            }
            if($this->request->config->get("dont_enforce_access_settings")){
 				$this->opa_access_values = array();
 			}else{
 				$this->opa_access_values = caGetUserAccessValues($this->request);
 			}
 			$this->view->setVar('access_values', $this->opa_access_values);
 			 
            $this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'chronology');
            
            $t_list = new ca_lists();
			$pn_type_restriction_id_entity = $t_list->getItemIDFromList('entity_types', 'individual');
			
			// set type restrictions for searches 
 			$this->opo_search_result_context_entity = new ResultContext($this->request, "ca_entities", 'chronology');
 			$this->opo_search_result_context_entity->setTypeRestriction($pn_type_restriction_id_entity);
 			$this->opo_search_result_context_entity->saveContext();
 			
 			$va_periods = $this->opa_periods;
 			$this->view->setVar('periods', $this->opa_periods);
 			$vn_year = $this->request->getParameter('year', pInteger);
 			$vn_period = $this->request->getParameter('period', pInteger);
			if(!$vn_period || (!$va_periods[$vn_period])){
				if($vn_year){
					# --- determine the period from the year
					foreach($va_periods as $i => $va_per_info){
						if(($vn_year >= $va_per_info["start"]) && ($vn_year <= $va_per_info["end"])){
							$vn_period = $i;
							break;
						}
					}
				}else{
					$vn_period = $this->opn_default_period;
				}
			}
			$this->view->setVar('period', $vn_period);
			$this->opn_period = $vn_period;
			if(!$vn_year){
				$vn_year = $va_periods[$vn_period]["start"];
			}
			$this->view->setVar('year', $vn_year);
 			
 			if($va_periods[$vn_period]["displayAllYears"] == 1){
 				$this->ops_date_range = $va_periods[$vn_period]["start"]." to ".$va_periods[$vn_period]["end"];
 			}else{
 				$this->ops_date_range = $vn_year;
 			}
 			JavascriptLoadManager::register('maps'); 			
 			
		}
 		# -------------------------------------------------------
 		function Index() {
			$vn_y = $this->ops_date_range;
			$va_period_data = array();
			
			//
			// Do browse for objects from period; we'll use the facets for related entities, occurrences and list items
			// from this browse to generate lists of which have related objects to show from it.
			//
			$vo_object_browse = new ObjectBrowse();														// we'll do a browse
			$vo_object_browse->addCriteria('_search', array('ca_objects.creation_date:"'.$vn_y.'"'));	// criteria is a search for creation date
			$vo_object_browse->execute();																// execute the browse
			
			//
			// Get events & exhibitions (occurrences)
			//
			$o_occ_search = new OccurrenceSearch();
			$qr_occs = $o_occ_search->search("ca_occurrences.event_date:\"".$vn_y."\"", array("sort" => "ca_occurrences.event_date", "no_cache" => !$this->opb_cache_searches, "checkAccess" => $this->opa_access_values));
			
			$va_occ_ids = array();
			while($qr_occs->nextHit()){
				$va_occ_ids[] = $qr_occs->get("ca_occurrences.occurrence_id");
			}
			$qr_occs->seek(0);
			// result context for occ
 			$o_search_result_context_occ = new ResultContext($this->request, "ca_occurrences", 'chronology');
 			$o_search_result_context_occ->setAsLastFind();
			$o_search_result_context_occ->setResultList($va_occ_ids);
			$o_search_result_context_occ->setParameter("period", $this->opn_period);
			$o_search_result_context_occ->saveContext();
			
			$va_period_data["occurrences"] = $qr_occs;
			
				// Get list of occurrences that have associated objects *from this period*
				$va_related_occs = $vo_object_browse->getFacet('occurrence_facet');				
				$va_period_data["occurrences_with_objects"] = is_array($va_related_occs) ? array_keys($vo_object_browse->getFacet('occurrence_facet')) : array();		// grab the related occurrences facet to get a list of occurrences with objects; the keys of the returned array are occurrence_ids
			
			//
			// Get entity list
			//
			$o_ent_search = new EntitySearch();
			$qr_entities = $o_ent_search->search("ca_entities.arrival_date:\"".$vn_y."\"", array("sort" => "ca_entity_labels.surname", "no_cache" => !$this->opb_cache_searches, "checkAccess" => $this->opa_access_values));
			
			$va_entity_ids = array();
			while($qr_entities->nextHit()){
				$va_entity_ids[] = $qr_entities->get("ca_entities.entity_id");
			}
			$qr_entities->seek(0);
			$this->opo_search_result_context_entity->setAsLastFind();
			$this->opo_search_result_context_entity->setResultList($va_entity_ids);
			$this->opo_search_result_context_entity->setParameter("period", $this->opn_period);
			$this->opo_search_result_context_entity->saveContext();
			
			$va_period_data["entities"] = $qr_entities;
																						
				$va_related_entities = $vo_object_browse->getFacet('entity_facet');												
				$va_period_data["entities_with_objects"] = is_array($va_related_entities) ? array_keys($va_related_entities) : array();		// grab the related entities facet to get a list of entities with objects; the keys of the returned array are entity_ids				
			
			//
			// Get styles/schools (list items) list
			//			
			$o_styles_schools_search = new ListItemSearch();
			$qr_styles_schools_search = $o_styles_schools_search->search("ca_list_items.term_date:\"".$vn_y."\"", array("sort" => "ca_list_item_labels.name_singular", "no_cache" => !$this->opb_cache_searches, "checkAccess" => $this->opa_access_values));
			$va_period_data["styles_schools"] = $qr_styles_schools_search;
			
				$va_related_list_items = $vo_object_browse->getFacet('style');				
				$va_period_data["list_items_with_objects"] = is_array($va_related_list_items) ? array_keys($va_related_list_items) : array();		// grab the related list items facet to get a list of list items with objects; the keys of the returned array are item_ids				
			
			# -- make array of entity_ids so can find places associated with these entities to map
			// $va_entities = array();
// 			if($qr_entities->numHits()){
// 				while($qr_entities->nextHit()){
// 					$va_entities[] = $qr_entities->get("entity_id");
// 				}
// 			}	
// 			$qr_entities->seek(0);
// 			$o_place_search = new PlaceSearch();
// 			$o_place_search->addResultFilter("ca_entities.entity_id", "IN", join(',', $va_entities));
// 			$qr_places = $o_place_search->search("*", array("no_cache" => !$this->opb_cache_searches, "checkAccess" => $this->opa_access_values));
//  			$o_map = new GeographicMap(450, 250, 'map');
// 			$va_map_stats = $o_map->mapFrom($qr_places, "georeference", array("ajaxContentUrl" => caNavUrl($this->request, "eastend", "Chronology", "getMapItemInfo"), "request" => $this->request, "checkAccess" => $this->opa_access_values));
// 			$va_period_data["map"] = $o_map->render('HTML', array('delimiter' => "<br/>"));
// 			$va_period_data["places"] = $qr_places;
			
			$o_obj_search = new ObjectSearch();
			$qr_objects = $o_obj_search->search("ca_objects.creation_date:\"".$vn_y."\" AND (ca_object.object_status:349 OR ca_object.object_status:347 OR ca_object.object_status:193)", array("sort" => "ca_objects.creation_date", "no_cache" => !$this->opb_cache_searches, "checkAccess" => $this->opa_access_values));
			$va_period_data["objects"] = $qr_objects;
			
			$va_object_ids = array();
			while($qr_objects->nextHit()){
				$va_object_ids[] = $qr_objects->get("ca_objects.object_id");
			}
			$qr_objects->seek(0);
			$this->opo_result_context->setAsLastFind();
			$this->opo_result_context->setResultList($va_object_ids);
			$this->opo_result_context->setParameter("period", $this->opn_period);
			$this->opo_result_context->saveContext();
			
			$this->view->setVar('period_data', $va_period_data);
			
 			$this->render('chronology_period_html.php');
 		}
 		# -------------------------------------------------------
 		function RefineSearch() {
 			$vs_refine = "";
 			
 			$pn_entity_id = $this->request->getParameter('entity_id', pInteger);
 			$this->view->setVar('entity_id', $pn_entity_id);
 			$t_entity = new ca_entities($pn_entity_id);
 			$this->view->setVar('entity_name', $t_entity->getLabelForDisplay());
 			if($pn_entity_id){
 				$vs_refine = " AND ca_entities.entity_id:".$pn_entity_id;
 			}
 			
 			$pn_occurrence_id = $this->request->getParameter('occurrence_id', pInteger);
 			$this->view->setVar('occurrence_id', $pn_occurrence_id);
 			$t_occurrence = new ca_occurrences($pn_occurrence_id);
 			$this->view->setVar('occurrence_name', $t_occurrence->getLabelForDisplay());
 			if($pn_occurrence_id){
 				$vs_refine = " AND ca_occurrences.occurrence_id:".$pn_occurrence_id;
 			}
 			
 			# --- style school
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$this->view->setVar('item_id', $pn_item_id);
 			$t_list_item = new ca_list_items($pn_item_id);
 			$this->view->setVar('style_school_name', $t_list_item->getLabelForDisplay());
 			if($pn_item_id){
 				$vs_refine = " AND ca_objects.style_school:".$pn_item_id;
 			}
 			
 			$vn_y = $this->ops_date_range;
			$va_period_data = array();
			$o_obj_search_refine = new ObjectSearch();
			$qr_objects_refine = $o_obj_search_refine->search("ca_objects.creation_date:\"".$vn_y."\" AND (ca_object.object_status:349 OR ca_object.object_status:347 OR ca_object.object_status:193)".$vs_refine, array("sort" => "ca_objects.creation_date", "no_cache" => !$this->opb_cache_searches, "checkAccess" => $this->opa_access_values));
			$va_object_ids = array();
			while($qr_objects_refine->nextHit()){
				$va_object_ids[] = $qr_objects_refine->get("ca_objects.object_id");
			}
			$qr_objects_refine->seek(0);
			$this->opo_result_context->setAsLastFind();
			$this->opo_result_context->setResultList($va_object_ids);
			$this->opo_result_context->setParameter("period", $this->opn_period);
			$this->opo_result_context->saveContext();
			$va_period_data["objects"] = $qr_objects_refine;
			$this->view->setVar('period_data', $va_period_data);			
			$this->render('chronology_object_results_html.php');
 		}
 		# ------------------------------------------------------- 
 		/**
 		 *
 		 */
 		public function getMapItemInfo() {
 			$pa_place_ids = explode(';', $this->request->getParameter('id', pString));
 			
 			$this->view->setVar('place_ids', $pa_place_ids);
 			$this->view->setVar('access_values', $this->opa_access_values);
 			
 		 	$this->render("chronology_map_balloon_html.php");		
 		}
 		
 		# -------------------------------------------------------
 	}
 ?>
