<?php
/* ----------------------------------------------------------------------
 * includes/ThemesController.php
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
 
 	require_once(__CA_MODELS_DIR__.'/ca_sets.php');
 	require_once(__CA_MODELS_DIR__.'/ca_objects.php');
 	require_once(__CA_MODELS_DIR__.'/ca_set_items.php');
 	require_once(__CA_MODELS_DIR__.'/ca_lists.php');
 	require_once(__CA_LIB_DIR__.'/core/GeographicMap.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_LIB_DIR__."/ca/Search/SetSearch.php");
 
 	class MemoriesController extends ActionController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			JavascriptLoadManager::register('panel');
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/wwsf/conf/wwsf.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('wwsf plugin is not enabled')); }
 			
 			$this->ops_theme = __CA_THEME__;																		// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/wwsf/views/'.$this->ops_theme)) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			$this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'memories');
			$this->opo_result_context->setAsLastFind();
			$this->opo_result_context->saveContext();
 		}
 		# -------------------------------------------------------
 		public function Index() {
 			$va_access_values = caGetUserAccessValues($this->request);
 			JavascriptLoadManager::register('tabUI');
 			JavascriptLoadManager::register('maps');
 			// get sets for public display
 			$t_list = new ca_lists();
 			$vn_set_type_memory = $t_list->getItemIDFromList('set_types', 'memory');
 			
 			$t_set = new ca_sets();
 			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array("table" => "ca_objects", "checkAccess" => $va_access_values, "setType" => $vn_set_type_memory)));
 			
 			$this->view->setVar('page', $pn_page = $this->opo_result_context->getCurrentResultsPageNumber());
 			
 			# page nav vars
 			$vn_items_per_page = 9;
 			$this->view->setVar('numPages', $vn_num_pages = ceil(sizeof($va_sets)/$vn_items_per_page));
			if (($pn_page > $vn_num_pages) || ($pn_page < 1)) { $pn_page = 1; }
			$this->view->setVar('itemsPerPage', $vn_items_per_page);
 			$this->view->setVar("numResults", sizeof($va_sets));
 			
 			$va_sets = array_slice($va_sets, ($vn_items_per_page * ($pn_page - 1)), $vn_items_per_page, TRUE);
 			$this->view->setVar('sets', $va_sets);
 			$va_set_first_items = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("version" => "preview160", "checkAccess" => $va_access_values));
			$this->view->setVar('first_items_from_sets', $va_set_first_items);
 			
 			$o_db = $t_set->getDb();
 			// Get terms attached to members of all sets
 			$qr_terms = $o_db->query("
 				SELECT clil.name_singular, clil.locale_id, clil.item_id, count(*) c
 				FROM ca_list_item_labels clil
 				INNER JOIN ca_objects_x_vocabulary_terms AS coxvt ON coxvt.item_id = clil.item_id
 				INNER JOIN ca_set_items AS csi ON csi.row_id = coxvt.object_id
 				INNER JOIN ca_sets AS cse ON cse.set_id = csi.set_id
 				WHERE 
 					cse.type_id = {$vn_set_type_memory} AND cse.access = 1 AND coxvt.type_id = 14 AND clil.is_preferred = 1
 				GROUP BY clil.item_id, clil.locale_id
 				ORDER BY clil.name_singular
 			"); 
 			
 			$va_terms = array();
 			while($qr_terms->nextRow()) {
 				$va_terms[$qr_terms->get('item_id')][$qr_terms->get('locale_id')] = array(
 					'label' => $qr_terms->get('name_singular'),
 					'count' => $qr_terms->get('c')
 				);
 			}
 			$va_terms = caExtractValuesByUserLocale($va_terms);
 			
 			$qr_terms = $o_db->query("
 				SELECT clil.item_id, cse.set_id
 				FROM ca_list_item_labels clil
 				INNER JOIN ca_objects_x_vocabulary_terms AS coxvt ON coxvt.item_id = clil.item_id
 				INNER JOIN ca_set_items AS csi ON csi.row_id = coxvt.object_id
 				INNER JOIN ca_sets AS cse ON cse.set_id = csi.set_id
 				WHERE 
 					cse.type_id = {$vn_set_type_memory} AND cse.access = 1
 			"); 
 			while($qr_terms->nextRow()) {
 				$va_terms[$qr_terms->get('item_id')]['set_ids'][] = $qr_terms->get('set_id');
 			}
 		
 			$this->view->setVar('set_terms', $va_terms);
 			
 			
 			// Get dates for all sets
 			$qr_dates = $o_db->query("
 				SELECT DISTINCT cav.value_decimal1, cav.value_decimal2
 				FROM ca_attribute_values cav
 				INNER JOIN ca_attributes AS ca ON ca.attribute_id = cav.attribute_id
 				INNER JOIN ca_metadata_elements AS cme ON cme.element_id = cav.element_id
 				INNER JOIN ca_sets AS cse ON cse.set_id = ca.row_id
 				WHERE 
 					cme.element_code = 'memory_date' AND ca.table_num = 103 AND cse.type_id = {$vn_set_type_memory} AND cse.access = 1
 				ORDER BY cav.value_decimal1, cav.value_decimal2
 			"); // table_num 103 = ca_sets
 			
 			$vs_dates = array();
 			$o_tep = new TimeExpressionParser();
 			while($qr_dates->nextRow()) {
 				$va_values = $o_tep->normalizeDateRange($qr_dates->get('value_decimal1'), $qr_dates->get('value_decimal2'), 'months');
 				foreach($va_values as $vs_value) {
 					if (preg_match('!([^\d]+) ([\d]+)!', $vs_value, $va_matches)) {
 						$va_dates[$va_matches[2]][$va_matches[1]] = $va_matches[1];
 					}
 				}
 			}
 			$this->view->setVar('set_dates', $va_dates);
 			
 			# --- get all memory sets to map
 			$o_search = new SetSearch();
			$qr_sets = $o_search->search("ca_sets.type_id:".$vn_set_type_memory, array('checkAccess' => $va_access_values));
 			if($qr_sets->numHits() > 0){
 				$o_map = new GeographicMap(267, 400, 'location');
 				$o_map->mapFrom($qr_sets, "set_georeference", array("contentView" => "memories_map_balloon_html.php", 'request' => $this->request, 'checkAccess' => $va_access_values, 'viewPath' => array_shift($this->getViewPaths()))); 
 				$this->view->setVar('map', $o_map->render('HTML', array('delimiter' => "<br/>")));
 			}
 			
 			$this->render('memories_landing_html.php');
 		}
 		# -------------------------------------------------------
 		public function slideshow() {
			$pn_object_id = $this->request->getParameter('object_id', pInteger);
			$pn_set_id = $this->request->getParameter('set_id', pInteger);
			$t_set = new ca_sets($pn_set_id);
			
			if (!$t_set->getPrimaryKey()) {
				$this->notification->addNotification(_t("The set does not exist"), __NOTIFICATION_TYPE_ERROR__);	
				$this->Edit();
				return;
			}
			
			if (!(($t_set->get('access') == 1) || ($this->request->getUserID() == $t_set->get('user_id')))) {
				$this->notification->addNotification(_t("You cannot view this set"), __NOTIFICATION_TYPE_INFO__);
				$this->response->setRedirect(caNavUrl($this->request, '', '', ''));
				return;
			}
			
			$this->view->setVar('set_id', $pn_set_id);
			$this->view->setVar('object_id', $pn_object_id);
			$this->view->setVar('t_set', $t_set);
			
 			$this->render('slideshow_html.php');
 		}
 		# -------------------------------------------------------
 		# XML data providers
 		# -------------------------------------------------------
 		public function getSetXML() {
			$va_access_values = caGetUserAccessValues($this->request);
			$pn_set_id = $this->request->getParameter('set_id', pInteger);
			$t_set = new ca_sets($pn_set_id);
			 
			if (!$t_set->getPrimaryKey()) {
				$this->notification->addNotification(_t("The set does not exist"), __NOTIFICATION_TYPE_ERROR__);	
				$this->Edit();
				return;
			}
			
			if (!(($t_set->get('access') == 1) || ($this->request->getUserID() == $t_set->get('user_id')))) {
				$this->notification->addNotification(_t("You cannot view this set"), __NOTIFICATION_TYPE_INFO__);
				$this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form'));
				return;
			}
			 
			 
			$this->view->setVar('set_id', $pn_set_id);
			$this->view->setVar('t_set', $t_set);
			$this->view->setVar('items', caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersion' => 'large', 'checkAccess' => $va_access_values))));
 			$this->render('xml_set_items.php');
 		}
 		# -------------------------------------------------------
 		# Ajax
 		# -------------------------------------------------------
 		public function searchSetsByTerm() {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$vn_item_id = $this->request->getParameter('item_id', pInteger);
 			
 			$t_list = new ca_lists();
 			$vn_set_type_memory = $t_list->getItemIDFromList('set_types', 'memory');
 			$t_item = new ca_list_items($vn_item_id);
 			
 			$o_db = new Db();
 			$qr_sets = $o_db->query("
 				SELECT coxvt.item_id, cse.*, csl.name, csl.locale_id
 				FROM ca_objects_x_vocabulary_terms coxvt
 				INNER JOIN ca_set_items AS csi ON csi.row_id = coxvt.object_id
 				INNER JOIN ca_sets AS cse ON cse.set_id = csi.set_id
 				INNER JOIN ca_set_labels AS csl ON csl.set_id = cse.set_id
 				WHERE 
 					cse.type_id = {$vn_set_type_memory} AND coxvt.item_id = ? AND cse.access = 1
 			", (int)$vn_item_id); 
 			
 			$va_sets = array();
 			while($qr_sets->nextRow()) {
 				$vn_set_id = $qr_sets->get('set_id');
 				$va_sets[$vn_set_id][$qr_sets->get('locale_id')] = $qr_sets->getRow();
 			}
 			$va_sets = caExtractValuesByUserLocale($va_sets);
 			
			$t_set = new ca_sets();
			$va_set_first_items = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("version" => "preview160", "checkAccess" => $va_access_values));
			$this->view->setVar('first_items_from_sets', $va_set_first_items);
 			
 			$va_set_list = array();
 			foreach($va_sets as $vn_set_id => $va_set_info){
 				$va_temp = array();
 				$va_temp["name"] = $va_set_info["name"];
 				$t_set->load($vn_set_id);
 				$va_temp["numObjects"] = $t_set->getItemCount();
 				if($va_temp["numObjects"] > 0){
 					$va_set_list[$va_set_info["set_id"]] = $va_temp;
 				}
 			}
 			
 			$this->view->setVar('sets', $va_set_list);
 			$this->view->setVar('t_item', $t_item);
 			
 			$this->view->setVar('search_type', 'tag');
 			$this->render('memories_search_results_html.php');
 		}
 		# -------------------------------------------------------
 		public function searchSetsByDate() {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$vs_date = $this->request->getParameter('date', pString);
 			
 			$t_list = new ca_lists();
 			$vn_set_type_memory = $t_list->getItemIDFromList('set_types', 'memory');
 			$t_item = new ca_list_items($vn_item_id);
 			
 			$o_db = new Db();
 			
 			$o_tep = new TimeExpressionParser();
 			$o_tep->parse($vs_date);
 			
 			$va_date = $o_tep->getHistoricTimestamps();
 			$qr_sets = $o_db->query("
 				SELECT cse.*, csl.name, csl.locale_id
 				FROM ca_attribute_values cav
 				INNER JOIN ca_attributes AS ca ON ca.attribute_id = cav.attribute_id
 				INNER JOIN ca_sets AS cse ON cse.set_id = ca.row_id
 				INNER JOIN ca_set_labels AS csl ON csl.set_id = cse.set_id
 				WHERE 
 					(cse.type_id = {$vn_set_type_memory}) AND 
 					(
 						(cav.value_decimal1 <= ? AND cav.value_decimal2 >= ?)
 						OR 
 						(cav.value_decimal1 >= ? AND cav.value_decimal1 <= ?)
 						OR 
 						(cav.value_decimal2 >= ? AND cav.value_decimal2 <= ?)
 						
 					) AND 
 					(cse.access = 1) AND
 					(ca.table_num = 103)
 					
 			", (float)$va_date['start'], (float)$va_date['end'], (float)$va_date['start'], (float)$va_date['end'], (float)$va_date['start'], (float)$va_date['end']); 

 			$va_sets = array();
 			while($qr_sets->nextRow()) {
 				$vn_set_id = $qr_sets->get('set_id');
 				$va_sets[$vn_set_id][$qr_sets->get('locale_id')] = $qr_sets->getRow();
 			}
 			$va_sets = caExtractValuesByUserLocale($va_sets);
 			
 			$t_set = new ca_sets();
			$va_set_first_items = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("version" => "preview160", "checkAccess" => $va_access_values));
			$this->view->setVar('first_items_from_sets', $va_set_first_items);
 			
 			$va_set_list = array();
 			foreach($va_sets as $vn_set_id => $va_set_info){
 				$va_temp = array();
 				$va_temp["name"] = $va_set_info["name"];
 				$t_set->load($vn_set_id);
 				$va_temp["numObjects"] = $t_set->getItemCount();
 				if($va_temp["numObjects"] > 0){
 					$va_set_list[$va_set_info["set_id"]] = $va_temp;
 				}
 			}
 			
 			$this->view->setVar('sets', $va_set_list);
 			$this->view->setVar('t_item', $t_item);
 			
 			$this->view->setVar('date', $vs_date);
 			$this->view->setVar('search_type', 'date');
 			$this->render('memories_search_results_html.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>