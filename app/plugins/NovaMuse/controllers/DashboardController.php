<?php
/* ----------------------------------------------------------------------
 * includes/DashboardController.php
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
 
 	require_once(__CA_MODELS_DIR__.'/ca_entities.php');
 	require_once(__CA_MODELS_DIR__.'/ca_objects.php');
 	require_once(__CA_MODELS_DIR__.'/ca_lists.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_LIB_DIR__.'/ca/ResultContext.php');
 	require_once(__CA_LIB_DIR__.'/ca/Search/EntitySearch.php');
 	require_once(__CA_LIB_DIR__.'/ca/Search/ObjectSearch.php');
 	require_once(__CA_LIB_DIR__.'/core/Parsers/TimeExpressionParser.php');
 	
 
 	class DashboardController extends ActionController {
 		# -------------------------------------------------------
 		private $opo_plugin_config;			// plugin config file
 		private $ops_theme;						// current theme
 		private $opo_result_context;			// current result context
 		
 		private $opn_member_institution_id = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			
 			$this->ops_theme = __CA_THEME__;																	// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/NovaMuse/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			parent::__construct($po_request, $po_response, array(__CA_APP_DIR__.'/plugins/NovaMuse/themes/'.$this->ops_theme.'/views'));
 			
			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/NovaMuse/conf/NovaMuse.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('NovaMuse plugin is not enabled')); }
 			
 			MetaTagManager::addLink('stylesheet', $po_request->getBaseUrlPath()."/app/plugins/NovaMuse/themes/".$this->ops_theme."/css/dashboard.css",'text/css');
 			
 			$this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'dashboard');

 			$t_list = new ca_lists();
 		 	$this->opn_member_institution_id = $t_list->getItemIDFromList('entity_types', 'member_institution');
 		 	$this->opn_individual_id = $t_list->getItemIDFromList('entity_types', 'ind');
 		 	$this->opn_family_id = $t_list->getItemIDFromList('entity_types', 'fam');
 		 	$this->opn_organization_id = $t_list->getItemIDFromList('entity_types', 'org');
 		 	
 		 	$t_object = new ca_objects();
 			$this->opn_objectTableNum = $t_object->tableNum();
 			 			
 			$va_access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $va_access_values;
			$this->view->setVar('access_values', $va_access_values);
			
 		}
 		# -------------------------------------------------------
 		/**
 		 * Displays site stats
 		 */
 		public function Index() {
 			$o_cache = caGetCacheObject('dashboard');
 			if ($o_cache && ((time() - (int)$o_cache->load('dashboard_time')) < 3600) && ($vs_content = $o_cache->load('dashboard'))) {
 				$this->response->addContent($vs_content);
 				return;
 			}
			$this->view->setVar("num_objects", $this->numObjects());
			$this->view->setVar("num_members", $this->numEntities(array($this->opn_member_institution_id)));
 			$this->view->setVar("num_entities", $this->numEntities(array($this->opn_individual_id, $this->opn_family_id, $this->opn_organization_id)));
 			$this->view->setVar("num_reps", $this->numReps());
 			$this->view->setVar("oldest_date", $this->oldestDate());
 			$this->view->setVar("median_date", $this->medianDate());
 			
 			$vs_version = "medium";
 			
 			$t_object = new ca_objects();
// 			$va_user_favorites_items = array_reverse($t_object->getHighestRated(null, 3, $this->opa_access_values));
// 			$va_user_favorites = array();
// 			if(is_array($va_user_favorites_items) && (sizeof($va_user_favorites_items) > 0)){
// 				foreach($va_user_favorites_items as $vn_user_favorite_id){
// 					$t_object->load($vn_user_favorite_id);
// 					$va_rep = $t_object->getPrimaryRepresentation(array($vs_version), null, array('return_with_access' => $this->opa_access_values));
// 					$va_user_favorites[$vn_user_favorite_id] = array("image" => $va_rep['tags'][$vs_version], "label" => $t_object->getLabelForDisplay());
// 				}
// 			}
//  			$this->view->setVar("most_popular", $va_user_favorites);
 			$o_db = new Db();
 			$q_most_liked = $o_db->query("SELECT ic.row_id, count(*) c
 												FROM ca_item_comments ic
 												INNER JOIN ca_objects o ON ic.row_id = o.object_id
 												INNER JOIN ca_objects_x_object_representations oxr ON oxr.object_id = o.object_id
 												INNER JOIN ca_object_representations r ON oxr.representation_id = r.representation_id
 												WHERE o.access = 1 AND o.deleted = 0 AND r.access = 1 AND r.deleted = 0
 												GROUP BY ic.row_id order by c DESC limit 4;");
 			$va_user_favorites = array();
 			if($q_most_liked->numRows()){
 				while($q_most_liked->nextRow()){
 					#print $q_most_liked->get("row_id")." - ";
 					$t_object->load($q_most_liked->get("row_id"));
					$va_rep = $t_object->getPrimaryRepresentation(array($vs_version), null, array('return_with_access' => $this->opa_access_values));
					$va_user_favorites[$q_most_liked->get("row_id")] = array("image" => $va_rep['tags'][$vs_version], "label" => $t_object->getLabelForDisplay());

 				}
 			}
 			$this->view->setVar("most_popular", $va_user_favorites);
 			
 			
 			
 			
 			$va_recently_added_items = $t_object->getRecentlyAddedItems(4, array('checkAccess' => $this->opa_access_values, 'hasRepresentations' => 1));
			#print_r($va_recently_added_items);
			$va_recently_added = array();
			if(is_array($va_recently_added_items) && (sizeof($va_recently_added_items) > 0)){
				$i = 0;
				foreach($va_recently_added_items as $vn_recently_added_info){
					if($i==4){
						break;
					}
					$t_object->load($vn_recently_added_info["object_id"]);
					$va_rep = $t_object->getPrimaryRepresentation(array($vs_version), null, array('return_with_access' => $this->opa_access_values));
					if($va_rep['tags'][$vs_version]){
						$va_recently_added[$vn_recently_added_info["object_id"]] = array("image" => $va_rep['tags'][$vs_version], "label" => $t_object->getLabelForDisplay());
						$i++;
					}
				}
			}
 			$this->view->setVar("recently_added", $va_recently_added);
 			
 			# --- timestamp for 60 days ago
 			$vn_timestamp = time() - (24*60*60*60);
 			$this->view->setVar("createdLast60Days", $this->recentlyAdded($vn_timestamp));
 			$this->view->setVar("topThemes", $this->topThemes());
 			
 			$vs_output = $this->render('dashboard_html.php');
 			if ($o_cache) {
 				$o_cache->save($vs_output, 'dashboard');
 				$o_cache->save(time(), 'dashboard_time');
 			}
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 * num entities - returns count of all public entities by default
 		 * pass an array of type_ids to restrict by type
 		 */
 		private function numEntities($va_type_ids = null) {
 			$o_db = new db();
 			$va_wheres = array();
 			if(is_array($va_type_ids) && sizeof($va_type_ids)){
 				$va_wheres[] = "ca_entities.type_id IN (".join(',', $va_type_ids).")";
 			}
 		//	$va_wheres[] = "ca_entities.access IN (".join(',', $this->opa_access_values).")";
 			$va_wheres[] = "ca_entities.deleted = 0";
 			$vs_wheres = join(" AND ", $va_wheres);
 			$qr_res = $o_db->query("SELECT count(*) c from ca_entities WHERE ".$vs_wheres);
 			
 			$qr_res->nextRow();
 			return $qr_res->get("c");
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 * objects - accept timestamp to find num objects since a time
 		 */
 		private function numObjects($vn_since_timestamp = "") {
 			
			$o_search = new ObjectSearch();
 		 	$o_search->addResultFilter("ca_objects.access", "IN", join(',', $this->opa_access_values));
 		 	if($vn_since_timestamp){
 		 		#$o_search->addResultFilter("ca_objects.dates", ">", $vn_since_timestamp);
 		 	}
			$qr_res = $o_search->search("*");
 			return $qr_res->numHits();
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 * object representations
 		 */
 		private function numReps() {
 			$o_db = new db();
 			$va_wheres = array();
 			$va_wheres[] = "r.access IN (".join(',', $this->opa_access_values).")";
 			$va_wheres[] = "r.deleted = 0";
 			$va_wheres[] = "o.access IN (".join(',', $this->opa_access_values).")";
 			$va_wheres[] = "o.deleted = 0";
 			$vs_wheres = join(" AND ", $va_wheres);
 			$qr_res = $o_db->query("SELECT count(*) c from ca_object_representations r
 									INNER JOIN ca_objects_x_object_representations x ON r.representation_id = x.representation_id
 									INNER JOIN ca_objects o ON x.object_id = o.object_id
 									WHERE ".$vs_wheres);
 			$qr_res->nextRow();
 			return $qr_res->get("c");			
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 * oldest date
 		 */
 		private function oldestDate() {
 			$t_object = new ca_objects();
 			$vn_object_tablenum = $this->opn_objectTableNum;
 			$o_db = new db();
 			
 			# --- get the element_id for date attribute
 			$q_date_element_id = $o_db->query("select element_id from ca_metadata_elements where element_code = 'date'");
 			$q_date_element_id->nextRow();
 			$vn_date_element_id = $q_date_element_id->get("element_id");
 			
 			if($vn_date_element_id && $vn_object_tablenum){
 				// Bracket search to dates between 1000 and 2012 since ANSM date data is very fucked up
 				$q_oldest_date = $o_db->query("select v.value_decimal1, v.value_decimal2, a.row_id from ca_attribute_values v
 												INNER JOIN ca_attributes a ON v.attribute_id = a.attribute_id
 												INNER JOIN ca_objects o ON a.row_id = o.object_id
 												where v.element_id = ".$vn_date_element_id." AND a.table_num = ".$vn_object_tablenum." AND o.access = 1 AND (value_decimal1 BETWEEN 1100 AND 2012)
 												ORDER BY value_decimal1 LIMIT 1");
 				if($q_oldest_date->numRows() > 0){
 					$q_oldest_date->nextRow();
 					$t_object->load($q_oldest_date->get("row_id"));
 					#print $q_oldest_date->get("value_decimal1")." - ".$q_oldest_date->get("value_decimal2")." - ".$q_oldest_date->get("row_id");
 					return $t_object->get("date").", ".caNavLink($this->request, $t_object->getLabelForDisplay(), "", "Detail", "Object", "Show", array("object_id" => $q_oldest_date->get("row_id")));
 				}else{
 					return false;
 				}
 			}else{
 				return false;
 			}			
 		}
 		# -------------------------------------------------------
 		/**
 		 * median date
 		 */
 		private function medianDate() {
 			$vn_object_tablenum = $this->opn_objectTableNum;
 			$o_db = new db();
 			
 			# --- get the element_id for date attribute
 			$q_date_element_id = $o_db->query("select element_id from ca_metadata_elements where element_code = 'date'");
 			$q_date_element_id->nextRow();
 			$vn_date_element_id = $q_date_element_id->get("element_id");
 			
 			if($vn_date_element_id && $vn_object_tablenum){
 				$q_median_date = $o_db->query($x="select a.row_id, v.value_decimal1, v.value_decimal2 from ca_attribute_values v
 												INNER JOIN ca_attributes a ON v.attribute_id = a.attribute_id
 												INNER JOIN ca_objects o ON a.row_id = o.object_id
 												where v.element_id = ".$vn_date_element_id." AND a.table_num = ".$vn_object_tablenum." AND o.access = 1 AND o.deleted = 0 AND v.value_decimal1 > -2000000000
 												ORDER BY v.value_decimal1 ");
 				if($q_median_date->numRows() > 0){
 					
 					$q_median_date->seek(ceil($q_median_date->numRows()/2));
					$q_median_date->nextRow();
					return intval($q_median_date->get("value_decimal1"));
 				}else{
 					return false;
 				}
 			}else{
 				return false;
 			}			
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 * objects created since a provided time
 		 */
 		private function recentlyAdded($pn_timestamp) {
 			if($pn_timestamp){
 				$vn_object_tablenum = $this->opn_objectTableNum;
 				$o_db = new db();
 				#print $pn_timestamp.": ".date("F d Y", $pn_timestamp);
 				$q_recently_added = $o_db->query("SELECT count(*) c from ca_change_log cl
 													RIGHT JOIN ca_objects o ON cl.logged_row_id = o.object_id
 													WHERE cl.log_datetime > ".$pn_timestamp." AND cl.changetype = 'I' AND cl.logged_table_num = ".$vn_object_tablenum." AND o.deleted = 0 AND o.access = 1");
 				if($q_recently_added->numRows() > 0){
 					$q_recently_added->nextRow();
 					return $q_recently_added->get("c");
 				}else{
 					return false;
 				}
 			}else{
 				return false;
 			}			
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 * themes with most items
 		 */
 		private function topThemes() {
 			$va_theme_links = array();
 			$vn_object_tablenum = $this->opn_objectTableNum;
 			$o_db = new db();
 			# --- get the element_id for date attribute
 			$q_theme_element_id = $o_db->query("select element_id from ca_metadata_elements where element_code = 'NovaStory_category'");
 			$q_theme_element_id->nextRow();
 			$vn_theme_element_id = $q_theme_element_id->get("element_id");
 			$t_list = new ca_lists();
 			$q_top_categories = $o_db->query("SELECT v.item_id, count(*) c
 												FROM ca_attribute_values v
 												INNER JOIN ca_attributes a ON v.attribute_id = a.attribute_id
 												INNER JOIN ca_objects o ON a.row_id = o.object_id
 												WHERE v.element_id = ".$vn_theme_element_id." AND a.table_num = ".$vn_object_tablenum." AND o.access = 1 AND o.deleted = 0
 												GROUP BY v.item_id order by c DESC limit 5;");
			if($q_top_categories->numRows() > 0){
				while($q_top_categories->nextRow()){
					$va_theme_links[] = caNavLink($this->request, $t_list->getItemForDisplayByItemID($q_top_categories->get("item_id")), "", "", "Browse", "clearAndAddCriteria", array("facet" => "NovaMuse_category_facet", "id" => $q_top_categories->get("item_id")));
				}
			}
			return $va_theme_links;		
 		}
 		
 		# -------------------------------------------------------
 		
 		
 	}
 ?>
