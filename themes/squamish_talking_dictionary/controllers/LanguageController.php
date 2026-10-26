<?php
/* ----------------------------------------------------------------------
 * controllers/BrowseAllController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2016 Whirl-i-Gig
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
 
	require_once(__CA_LIB_DIR__."/ApplicationError.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
 	class LanguageController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			$this->config = caGetFrontConfig();
 			caSetPageCSSClasses(array("language"));
 			$this->view->setVar('access_values', $this->opa_access_values);
 			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function Index() {
 			$this->render("Language/index_html.php");
 		}
 		# -------------------------------------------------------
 		public function Alphabet() {
 			# --- what is the set code of the alphabet set?
 			$vs_set_code = $this->request->config->get("alphabet_page_set_code");
			
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => $vs_set_code));
			# Enforce access control on set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('alphabet_set', $t_set);
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
				$this->view->setVar('set_items_as_search_result', caMakeSearchResult('ca_objects', $va_row_ids));
			}
			
			# --- what is the set code of the vowel set?
 			$vs_vowel_set_code = $this->request->config->get("alphabet_page_vowel_set_code");
			
			$t_vowel_set = new ca_sets();
			$t_vowel_set->load(array('set_code' => $vs_vowel_set_code));
			# Enforce access control on set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_vowel_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('vowel_set', $t_vowel_set);
				$va_row_ids = array_keys(is_array($va_tmp = $t_vowel_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values))) ? $va_tmp : array());
				$va_vowel_set_items = caExtractValuesByUserLocale($t_vowel_set->getItems(array("checkAccess" => $this->opa_access_values)));
				$va_vowel_row_to_item_ids = array();
				foreach($va_vowel_set_items as $vn_item_id => $va_item_info){
					$va_vowel_row_to_item_ids[$va_item_info["row_id"]] = $vn_item_id;
				}
				$this->view->setVar('vowel_set_id', $t_vowel_set->get("ca_sets.set_id"));
				$this->view->setVar('vowel_set_items', $va_vowel_set_items);
				$this->view->setVar('vowel_row_to_item_ids', $va_vowel_row_to_item_ids);
				$this->view->setVar('vowel_set_item_row_ids', $va_row_ids);
				$this->view->setVar('vowel_set_items_as_search_result', caMakeSearchResult('ca_objects', $va_row_ids));
			}
			
			
			$this->render("Language/alphabet_html.php");
 		}
 		# -------------------------------------------------------
 		public function AlphabetItem() {
 			$item_id = $this->request->getParameter('item_id', pInteger);
 			$set_id = $this->request->getParameter('set_id', pInteger);
 			
 			$t_set = $this->_getSet($set_id);
 			$t_set_item = $this->_getSetItem($set_id, $item_id);
 			
			if (!($t_instance = Datamodel::getInstanceByTableNum($t_set->get("table_num")))) { throw new ApplicationException(_t('Invalid set type')); }
			if (!($table = Datamodel::getTableName($t_set_item->get('table_num')))) { throw new ApplicationException(_t('Invalid set type')); }
			if (!$t_instance->load($t_set_item->get("row_id"))) { throw new ApplicationException(_t('Invalid item')); }
			
 			$set_item_ids = array_keys($t_set->getItemIDs(array("checkAccess" => $this->opa_access_values)));
 			$this->view->setVar("item_id", $item_id);
 			$this->view->setVar("set_num_items", sizeof($set_item_ids));
 			$this->view->setVar("set_item_num", (array_search($item_id, $set_item_ids) + 1));
 			
 			$this->view->setVar("set_item", $t_set_item);
 			$this->view->setVar("object", $t_instance);
 			$this->view->setVar("instance", $t_instance);
 			$this->view->setVar("object_id", $t_set_item->get("row_id"));
 			$this->view->setVar("row_id", $t_set_item->get("row_id"));
 			$this->view->setVar("label", $t_instance->getLabelForDisplay());

			
			$this->render("Language/alphabet_item_html.php");
 		}
 		# -------------------------------------------------------
 		public function Sentences(){
 		 	$t_set = new ca_sets();
 		 	
			$set_opts = array('checkAccess' => $this->opa_access_values, 'setType' => 'sentences_phrases');
			$set_opts["table"] = "ca_objects";
			$sets = caExtractValuesByUserLocale($t_set->getSets($set_opts));
			$set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($sets), array("version" => "icon", "checkAccess" => $this->opa_access_values));
		
			// Sort by name by default; otherwise sort on rank
			#if($this->config->get('gallery_sort_by') !== 'name') {
			#	$sets = caSortArrayByKeyInValue($sets, ['rank', 'set_id']);
			#}
			
			foreach($sets as $set_id => $va_set) {
				$first_item = $set_first_items[$set_id];
				$first_item = array_shift($first_item);
				$vn_item_id = $first_item["item_id"];
			}
			$this->view->setVar('sets', $sets);
			$this->view->setVar('first_items_from_sets', $set_first_items);
			$this->view->setVar('sets_as_search_result', caMakeSearchResult('ca_sets', array_keys($sets)));
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Sentences and Phrases"));
			$this->render("Language/sentences_html.php");
 				
 		}
 		# -------------------------------------------------------
 		public function SentenceSet(){
 		 	$set_id = $this->request->getParameter('set_id', pInteger);
			$t_set = $this->_getSet($set_id);
			# Enforce access control on set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('alphabet_set', $t_set);
				$va_row_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values))) ? $va_tmp : array());
				$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("checkAccess" => $this->opa_access_values)));
				$va_row_to_item_ids = array();
				foreach($va_set_items as $vn_item_id => $va_item_info){
					$va_row_to_item_ids[$va_item_info["row_id"]] = $vn_item_id;
				}
				$this->view->setVar('set', $t_set);
				$this->view->setVar('set_id', $t_set->get("ca_sets.set_id"));
				$this->view->setVar('set_items', $va_set_items);
				$this->view->setVar('row_to_item_ids', $va_row_to_item_ids);
				$this->view->setVar('set_item_row_ids', $va_row_ids);
				$this->view->setVar('set_items_as_search_result', caMakeSearchResult('ca_objects', $va_row_ids));
			}
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Sentences and Phrases"));
			$this->render("Language/sentence_detail_html.php");
 				
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _getSet($set_id) {
 			$t_set = new ca_sets();
 			if (!$t_set->load($set_id) || (sizeof($this->opa_access_values) && !in_array((int)$t_set->get('access'), $this->opa_access_values, true))) { throw new ApplicationException(_t('Invalid set')); }
 			return $t_set;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _getSetItem($set_id, $item_id) {
 			$t_set = $this->_getSet($set_id);
 			
 			$t_item = new ca_set_items($item_id);
 			if (!$t_item->isLoaded() || ((int)$t_item->get('ca_set_items.set_id') !== (int)$set_id)) { throw new ApplicationException(_t('Invalid item')); }
 			return $t_item;
 		}
 		# -------------------------------------------------------
 	}