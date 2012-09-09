<?php
/* ----------------------------------------------------------------------
 * includes/ShowController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
 
 	require_once(__CA_MODELS_DIR__.'/ca_collections.php');
 	require_once(__CA_MODELS_DIR__.'/ca_occurrences.php');
 	require_once(__CA_MODELS_DIR__.'/ca_entities.php');
 	require_once(__CA_MODELS_DIR__.'/ca_lists.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_LIB_DIR__.'/ca/ResultContext.php');
 	require_once(__CA_LIB_DIR__.'/core/GeographicMap.php');
 	require_once(__CA_LIB_DIR__.'/ca/Search/OccurrenceSearch.php');
 
 	class ShowController extends ActionController {
 		# -------------------------------------------------------
 		private $opo_plugin_config;			// plugin config file
 		private $ops_theme;						// current theme
 		private $opo_result_context;			// current result context
 		
 		private $opn_silo_type_id = null;
 		private $opn_action_type_id = null;
 		private $opn_context_type_id = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			
 			$this->ops_theme = __CA_THEME__;																	// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/Chronology/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			parent::__construct($po_request, $po_response, array(__CA_APP_DIR__.'/plugins/Chronology/themes/'.$this->ops_theme.'/views'));
 			
			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/Chronology/conf/Chronology.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('Chronology plugin is not enabled')); }
 			
 			$this->_initView($pa_options);
 			$this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'Chronology');
 			
 			MetaTagManager::addLink('stylesheet', $po_request->getBaseUrlPath()."/app/plugins/Chronology/themes/".$this->ops_theme."/css/chronology.css",'text/css');
 			JavascriptLoadManager::register('jcarousel');
 			JavascriptLoadManager::register('maps');
 			
 			
 			$t_list = new ca_lists();
 		 	$this->opn_silo_type_id = $t_list->getItemIDFromList('collection_types', 'silo');
 		 	$this->opn_action_type_id = $t_list->getItemIDFromList('occurrence_types', 'action');
 		 	$this->opn_context_type_id = $t_list->getItemIDFromList('occurrence_types', 'context');
 		 	
 		 	
 		 	$this->opn_yes_list_id = $t_list->getItemIDFromList('yes_no', 'yes');
 		 	
 		 	$t_relationship_types = new ca_relationship_types();
 		 	$this->opn_rel_type_action_display_image = $t_relationship_types->getRelationshipTypeID("ca_objects_x_occurrences", "display");
 		 	$this->opn_rel_type_action_secondary_images = $t_relationship_types->getRelationshipTypeID("ca_objects_x_occurrences", "secondary");
 		 	
 		 	$va_access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $va_access_values;
			$this->view->setVar('access_values', $va_access_values);
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function Index() {
 			$o_cache = caGetCacheObject('chronology', 3600);
 		
 			if ((!is_array($va_silos = $o_cache->load('silo_list')) || $this->request->getParameter('nocache', pInteger)) || !$this->opo_plugin_config->get('doCaching')) {
				$va_access_values = caGetUserAccessValues($this->request);
				$this->view->setVar('access_values', $va_access_values);
				
				// Get silos
				$t_list = new ca_lists();
				
				$o_db = new Db();
				$qr_ids = $o_db->query("SELECT collection_id FROM ca_collections WHERE type_id = ? AND deleted = 0 AND access IN (?)", $this->opn_silo_type_id, implode(", ", $this->opa_access_values));
				$t_collection = new ca_collections();
				$qr_silos = $t_collection->makeSearchResult('ca_collections', $qr_ids->getAllFieldValues('collection_id'));
				
				$o_search = new OccurrenceSearch();
				
				$va_silos = array();
				while($qr_silos->nextHit()) {
					$vs_name = $qr_silos->get('ca_collections.preferred_labels.name');
					$vn_collection_id = $qr_silos->get('collection_id');
					
					if (strtolower($vs_name) == 'historical context') {
						$o_search->setTypeRestrictions(array($this->opn_context_type_id));
					} else {
						$o_search->setTypeRestrictions(array($this->opn_action_type_id));
					}
 		 			$o_search->addResultFilter("ca_occurrences.access", "IN", join(',', $this->opa_access_values));
					$qr_res = $o_search->search("ca_occurrences.includeChronology:".$this->opn_yes_list_id." AND ca_collections.collection_id:{$vn_collection_id} AND ca_occurrences.date.dates_value:\"after 1000\"");
 		
					$va_silos[$vn_collection_id] = array(
						'collection_id' => $vn_collection_id,
						'name' => $vs_name,
						'actions' => $this->_getActions($vn_collection_id, 0, 25, (strtolower($vs_name) == 'historical context')),
						'num_actions' => $qr_res->numHits(),
						'actionmap' => $this->_getActionMap($vn_collection_id, (strtolower($vs_name) == 'historical context')),
					);
				}
				$o_cache->save($va_silos);
			}
 			
 			$this->view->setVar('silos', $va_silos);
 			
 			$this->render('chronology_html.php');
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function GetActions() {
 			$pn_silo_id = $this->request->getParameter('silo_id', pInteger);
 			$pn_start = $this->request->getParameter('s', pInteger);
 			$pn_num_actions = $this->request->getParameter('n', pInteger);
 			$pb_is_context = (bool)$this->request->getParameter('context', pInteger);
 			if ($pn_num_actions < 1) { $pn_num_actions = 10; }
 			
 			$va_actions = $this->_getActions($pn_silo_id, $pn_start, $pn_num_actions, $pb_is_context);
 		 	
 		 	$this->view->setVar('actions', $va_actions);
 			
 			$this->render('ajax_actions_json.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _getActions($pn_silo_id, $pn_start=0, $pn_num_actions=10, $pb_is_context=false) {
 		 	$o_search = new OccurrenceSearch();
 		 	
 		 	if ($pb_is_context) {
				$o_search->setTypeRestrictions(array($this->opn_context_type_id));
 			} else {
 				$o_search->setTypeRestrictions(array($this->opn_action_type_id));
 			}
 		 	
 		 	$o_search->addResultFilter("ca_occurrences.access", "IN", join(',', $this->opa_access_values));
			$qr_res = $o_search->search("ca_occurrences.includeChronology:".$this->opn_yes_list_id." AND ca_collections.collection_id:{$pn_silo_id}", array('sort' => 'ca_occurrences.date.dates_value', 'sort_direction' => 'asc'));
 		
 			$t_occ = new ca_occurrences();
					
			$qr_res->seek($pn_start);
 		 	$va_actions = array();
 		 	$vn_c = 0;
 		 	while($qr_res->nextHit()) {
 		 		if (!($vs_date = trim($qr_res->get('ca_occurrences.date.dates_value', array('dateFormat' => 'delimited'))))) { continue; }
 		 		if ($vs_date == 'present') { continue; }
 		 		$va_entities = array();
 		 		$va_related_entities = array();
 		 		$va_entities = $qr_res->get('ca_entities', array("returnAsArray" => 1, 'checkAccess' => $this->opa_access_values));
 		 		$vs_entities = "";
 		 		$va_related_entities = array();
 		 		if(is_array($va_entities) && sizeof($va_entities)){
 		 			foreach($va_entities as $vn_i => $va_entity_info){
 		 				$va_related_entities[$va_entity_info['relation_id']] = $va_entity_info['displayname'];
 		 			}
 		 			$vs_entities = (implode(", ", $va_related_entities));
 		 		}
 		 		# --- get one object image to show in action - related with relationship type "is display image for"
 		 		$vs_image = "";
 		 		$o_db = new Db();
				$qr_action_object = $o_db->query("SELECT o.object_id, r.media
													FROM ca_objects_x_occurrences x
													RIGHT JOIN ca_objects AS o ON x.object_id = o.object_id
													RIGHT JOIN ca_objects_x_object_representations AS oxr ON o.object_id = oxr.object_id
													RIGHT JOIN ca_object_representations AS r ON r.representation_id = oxr.representation_id
													WHERE x.type_id = ? AND x.occurrence_id = ? AND oxr.is_primary > 0 AND o.access IN (?) AND r.access IN (?) LIMIT 1", $this->opn_rel_type_action_display_image, $qr_res->get('ca_occurrences.occurrence_id'), join(", ", $this->opa_access_values), join(", ", $this->opa_access_values));
				if($qr_action_object->numRows() > 0){
					$qr_action_object->nextRow();
					$vs_image = $qr_action_object->getMediaTag("media", "chronothumb").$qr_action_object->get("type_id");
				}else{
					$t_occ->load($qr_res->get("ca_occurrences.occurrence_id"));
					if($t_occ->get("ca_occurrences.georeference.geocode")){
						# attempt to display a small map instead of an image
						$o_map = new GeographicMap(142, 72, 'timelineMap'.$pn_silo_id.$t_occ->get("ca_occurrences.occurrence_id"));
						$o_map->mapFrom($t_occ, "ca_occurrences.georeference.geocode");
						$vs_map = $o_map->render('JPEG', array('zoomLevel' => 12, 'mapType' => 'TERRAIN'));
						$vs_image = $vs_map;
					}
				}
 		 		$va_timestamps = array_shift($qr_res->get('ca_occurrences.date.dates_value', array('rawDate' => true, 'returnAsArray' => true)));
 		 		$va_actions[$vn_id = $qr_res->get('ca_occurrences.occurrence_id')] = array(
 		 			'occurrence_id' => $vn_id,
 		 			'label' => $qr_res->get('ca_occurrences.preferred_labels.name'),
 		 			'idno' => $qr_res->get('ca_occurrences.idno'),
 		 			'date' => $vs_date,
 		 			'timestamp' => $va_timestamps['start'],
 		 			'entities_array' => $va_related_entities,
 		 			'entities' => $vs_entities,
 		 			'objectMedia' => $vs_image,
 		 			'location' => $qr_res->get('ca_occurrences.georeference.geocode'),
 		 			'silo_id' => $pn_silo_id
 		 		);
 		 		
 		 		$vn_c++;
 		 		if ($vn_c >= $pn_num_actions) { break; }
 		 	}
 		 	
 		 	return $va_actions;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function GetAction() {
 			$pn_action_id = $this->request->getParameter('action_id', pInteger);
 			$pn_silo_id = $this->request->getParameter('silo_id', pInteger);
 			$t_action = new ca_occurrences($pn_action_id);
 			$va_action = array();
 			$va_action["objects"] = $t_action->get('ca_objects', array("restrict_to_relationship_types" => array("display", "secondary"), "returnAsArray" => 1, 'checkAccess' => $this->opa_access_values));
 			$va_action["label"] = $t_action->getLabelforDisplay();
 			$va_action["georeference"] = $t_action->get('ca_occurrences.georeference.geocode');
 			# --- get a bigger map if there are no objects to show
 			if(is_array($va_action["objects"]) && sizeof($va_action["objects"]) > 0){
 				$o_map = new GeographicMap(250, 128, 'mapAction'.$pn_action_id.'Silo'.$pn_silo_id);
 			}else{
 				$o_map = new GeographicMap(500, 300, 'mapAction'.$pn_action_id.'Silo'.$pn_silo_id);
 			}
			$o_map->mapFrom($t_action, "ca_occurrences.georeference.geocode");
			$vs_map = $o_map->render('HTML');
 			$va_action["map"] = $vs_map;
 			$va_action["description"] = $t_action->get('description');
 			$va_action["occurrence_id"] = $t_action->get('occurrence_id');
 			$va_action["entities"] = $t_action->get('ca_entities', array("returnAsArray" => 1, 'checkAccess' => $this->opa_access_values, 'sort' => 'surname'));
 			$va_action["collections"] = $t_action->get('ca_collections', array("returnAsArray" => 1, 'checkAccess' => $this->opa_access_values));
 			$va_action["occurrences"] = $t_action->get('ca_occurrences', array("returnAsArray" => 1, 'checkAccess' => $this->opa_access_values));
 			$va_action["date"] = $t_action->get('date', array('template' => "^dates_value"));
 			
 			# --- get next and previous ids
 			$o_cache = caGetCacheObject('chronology', 3600);
 			$va_silos = $o_cache->load('silo_list');
 			$va_silo_actionmap = $va_silos[$pn_silo_id]['actionmap'];
 			
 			$pn_previous_id = "";
 			$pn_next_id = "";
 			foreach($va_silo_actionmap as $i => $va_action_info){
 				if($va_action_info["id"] == $pn_action_id){
 					$pn_previous_id = $va_silo_actionmap[$i - 1]["id"];
 					$pn_next_id = $va_silo_actionmap[$i + 1]["id"];
 					break;
 				}
 			}
 			$this->view->setVar('previous_id', $pn_previous_id);
 			$this->view->setVar('next_id', $pn_next_id);
 			$this->view->setVar('action', $va_action);
 			$this->view->setVar('silo_id', $pn_silo_id);
 			
 			$this->render('action_info_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function GetSyncPoints() {
 			$pn_silo_id = $this->request->getParameter('silo_id', pInteger);
 			$pn_time = $this->request->getParameter('t', pInteger);
 		 	
 		 	$this->view->setVar('sync_points', array()); 			
 			$this->render('ajax_sync_points_json.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _getActionMap($pn_silo_id, $pb_is_context=false) {
 		 	$o_search = new OccurrenceSearch();
 		 	
 		 	 if ($pb_is_context) {
 				$o_search->setTypeRestrictions(array($this->opn_context_type_id));
 			} else {
 				$o_search->setTypeRestrictions(array($this->opn_action_type_id));
 			}
 		 	$o_search->addResultFilter("ca_occurrences.access", "IN", join(',', $this->opa_access_values));
			$qr_res = $o_search->search("ca_occurrences.includeChronology:".$this->opn_yes_list_id." AND ca_collections.collection_id:{$pn_silo_id}", array('sort' => 'ca_occurrences.date.dates_value', 'sort_direction' => 'asc'));
 		
 		 	$va_actions = array();
 		 	$vn_c = 0;
 		 	while($qr_res->nextHit()) {
 		 		if (!($vs_date = trim($qr_res->get('ca_occurrences.date.dates_value', array('dateFormat' => 'delimited'))))) { continue; }
 		 		if ($vs_date == 'present') { continue; }
 		 		
 		 		$va_timestamps = array_shift($qr_res->get('ca_occurrences.date.dates_value', array('rawDate' => true, 'returnAsArray' => true)));
 		 
 		 		$va_actions[] = array(
 		 			'timestamp' => $va_timestamps['start'],
 		 			'date' => $vs_date,
 		 			'id' => $qr_res->get('ca_occurrences.occurrence_id')
 		 		);
 		 		
 		 		$vn_c++;
 		 	}
 		 	
 		 	return $va_actions;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		protected function _initView($pa_options=null) {
 			$this->view->setVar('graphicsPath', $this->request->getBaseUrlPath()."/app/plugins/Chronology/themes/".$this->ops_theme."/graphics");
 			$this->view->setVar('viewPath', array_shift($this->view->getViewPaths()));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function GetActionsEntity() {
 			$pn_entity_id = $this->request->getParameter('entity_id', pInteger);
 			$pn_start = $this->request->getParameter('s', pInteger);
 			$pn_num_actions = $this->request->getParameter('n', pInteger);
 			if ($pn_num_actions < 1) { $pn_num_actions = 10; }
 			
 			$va_actions = $this->_getActionsEntity($pn_entity_id, $pn_start, $pn_num_actions);
 		 	
 		 	$this->view->setVar('actions', $va_actions);
 			$this->render('ajax_actions_json.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _getActionsEntity($pn_entity_id, $pn_start=0, $pn_num_actions=10) {
 		 	$o_search = new OccurrenceSearch();
 		 	$o_search->setTypeRestrictions(array($this->opn_context_type_id, $this->opn_action_type_id));
 			$o_search->addResultFilter("ca_occurrences.access", "IN", join(',', $this->opa_access_values));
			$qr_res = $o_search->search("ca_entities.entity_id:{$pn_entity_id}", array('sort' => 'ca_occurrences.date.dates_value', 'sort_direction' => 'asc'));
 		
 			$t_occ = new ca_occurrences();
 			$qr_res->seek($pn_start);
 		 	$va_actions = array();
 		 	$vn_c = 0;
 		 	while($qr_res->nextHit()) {
 		 		if (!($vs_date = trim($qr_res->get('ca_occurrences.date.dates_value', array('dateFormat' => 'delimited'))))) { continue; }
 		 		if ($vs_date == 'present') { continue; }
 		 		$va_silos = array();
				$va_projects = array();
				$t_occ->load($qr_res->get('ca_occurrences.occurrence_id'));
				$va_silos = $t_occ->get("ca_collections", array("restrictToTypes" => array("silo"), "returnAsArray" => 1, 'checkAccess' => $this->opa_access_values));
				# --- format silo icons here
				$vs_silos = "";
				if(is_array($va_silos) && sizeof($va_silos) > 0){
					$vs_silos = "<div class='actionSiloIcons'>";
					foreach($va_silos as $vn_i => $va_silo_info){
						$vs_bgColor = "";
						switch($va_silo_info["collection_id"]){
							case $this->request->config->get('silo_strawberry_flag'):
								$vs_bgColor = $this->request->config->get('silo_strawberry_flag_bg');
							break;
							# --------------------------------------
							case $this->request->config->get('silo_silver_water'):
								$vs_bgColor = $this->request->config->get('silo_silver_water_bg');
							break;
							# --------------------------------------
							default:
								$vs_bgColor = "#000000";
							break;
						}
						$vs_silos .= caNavLink($this->request, "<div class='actionSiloIcon siloIcon".$va_silo_info["collection_id"]."' style='background-color:".$vs_bgColor."'><!-- empty --></div>", '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_silo_info["collection_id"]), array("title" => $va_silo_info["label"]));
					}
					$vs_silos .= "</div>";					
				}

				$va_projects = $t_occ->get("ca_collections", array("restrictToTypes" => array("project"), "returnAsArray" => 1, 'checkAccess' => $this->opa_access_values));
			
 		 		$va_timestamps = array_shift($qr_res->get('ca_occurrences.date.dates_value', array('rawDate' => true, 'returnAsArray' => true)));
 		 		$va_actions[$vn_id = $qr_res->get('ca_occurrences.occurrence_id')] = array(
 		 			'occurrence_id' => $vn_id,
 		 			'label' => $qr_res->get('ca_occurrences.preferred_labels.name'),
 		 			'idno' => $qr_res->get('ca_occurrences.idno'),
 		 			'date' => $vs_date,
 		 			'timestamp' => $va_timestamps['start'],
 		 			'location' => $qr_res->get('ca_occurrences.georeference.geocode'),
 		 			'silos' => $va_silos,
 		 			'silos_formatted' => $vs_silos,
					'projects' => $va_projects
 		 		);	 		
 		 		$vn_c++;
 		 		if ($vn_c >= $pn_num_actions) { break; }
 		 	}
 		 	
 		 	return $va_actions;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function GetActionsCollection() {
 			$pn_collection_id = $this->request->getParameter('collection_id', pInteger);
 			$pn_start = $this->request->getParameter('s', pInteger);
 			$pn_num_actions = $this->request->getParameter('n', pInteger);
 			if ($pn_num_actions < 1) { $pn_num_actions = 10; }
 			
 			$va_actions = $this->_getActionsCollection($pn_collection_id, $pn_start, $pn_num_actions);
 		 	
 		 	$this->view->setVar('actions', $va_actions);
 			
 			$this->render('ajax_actions_json.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _getActionsCollection($pn_collection_id, $pn_start=0, $pn_num_actions=10) {
 		 	$o_search = new OccurrenceSearch();
 		 	$o_search->setTypeRestrictions(array($this->opn_context_type_id, $this->opn_action_type_id));
 			$o_search->addResultFilter("ca_occurrences.access", "IN", join(',', $this->opa_access_values));
			$qr_res = $o_search->search("ca_collections.collection_id:{$pn_collection_id}", array('sort' => 'ca_occurrences.date.dates_value', 'sort_direction' => 'asc'));
			
 			$qr_res->seek($pn_start);
 		 	$va_actions = array();
 		 	$vn_c = 0;
 		 	$t_occ = new ca_occurrences();
 		 	while($qr_res->nextHit()) {
 		 		if (!($vs_date = trim($qr_res->get('ca_occurrences.date.dates_value', array('dateFormat' => 'delimited'))))) { continue; }
 		 		if ($vs_date == 'present') { continue; }
 		 		$va_silos = array();
				$va_projects = array();
				$t_occ->load($qr_res->get('ca_occurrences.occurrence_id'));
				$va_silos = $t_occ->get("ca_collections", array("restrictToTypes" => array("silo"), "returnAsArray" => 1, 'checkAccess' => $this->opa_access_values));
				# --- format silo icons here
				$vs_silos = "";
				if(is_array($va_silos) && sizeof($va_silos) > 0){
					$vs_silos = "<div class='actionSiloIcons'>";
					foreach($va_silos as $vn_i => $va_silo_info){
						$vs_bgColor = "";
						switch($va_silo_info["collection_id"]){
							case $this->request->config->get('silo_strawberry_flag'):
								$vs_bgColor = $this->request->config->get('silo_strawberry_flag_bg');
							break;
							# --------------------------------------
							case $this->request->config->get('silo_silver_water'):
								$vs_bgColor = $this->request->config->get('silo_silver_water_bg');
							break;
							# --------------------------------------
							default:
								$vs_bgColor = "#000000";
							break;
						}
						$vs_silos .= caNavLink($this->request, "<div class='actionSiloIcon siloIcon".$va_silo_info["collection_id"]."' style='background-color:".$vs_bgColor."'><!-- empty --></div>", '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_silo_info["collection_id"]), array("title" => $va_silo_info["label"]));
					}
					$vs_silos .= "</div>";					
				}

				$va_projects = $t_occ->get("ca_collections", array("restrictToTypes" => array("project"), "returnAsArray" => 1, 'checkAccess' => $this->opa_access_values));
			
 		 		$va_timestamps = array_shift($qr_res->get('ca_occurrences.date.dates_value', array('rawDate' => true, 'returnAsArray' => true)));
 		 		$va_actions[$vn_id = $qr_res->get('ca_occurrences.occurrence_id')] = array(
 		 			'occurrence_id' => $vn_id,
 		 			'label' => $qr_res->get('ca_occurrences.preferred_labels.name'),
 		 			'idno' => $qr_res->get('ca_occurrences.idno'),
 		 			'date' => $vs_date,
 		 			'timestamp' => $va_timestamps['start'],
 		 			'location' => $qr_res->get('ca_occurrences.georeference.geocode'),
 		 			'silos' => $va_silos,
 		 			'silos_formatted' => $vs_silos,
					'projects' => $va_projects
 		 		);	 		
 		 		$vn_c++;
 		 		if ($vn_c >= $pn_num_actions) { break; }
 		 	}
 		 	
 		 	return $va_actions;
 		}
 		# -------------------------------------------------------
 	}
 ?>
