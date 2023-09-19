<?php
/* ----------------------------------------------------------------------
 * controllers/PeopleController.php
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
 	require_once(__CA_APP_DIR__."/controllers/FindController.php");
 	require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
 
 	class PeopleController extends BasePawtucketController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			$this->config = caGetFrontConfig();
 			
 			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function Index() {
 			caSetPageCSSClasses(array("peopleLanding"));
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);
 			
 			# --- what is the set code of the featured people set?
 			$vs_set_code = $this->request->config->get("people_page_set_code");
			
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => $vs_set_code));
			# Enforce access control on set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('people_set', $t_set);
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
				$this->view->setVar('set_items_as_search_result', caMakeSearchResult('ca_entities', $va_row_ids));
			}

 			# --- get all browse facets to list out:
 			$va_browse_info = caGetInfoForBrowseType("entities");
 			$va_types = caGetOption('restrictToTypes', $va_browse_info, array(), array('castTo' => 'array'));
 			$o_browse = caGetBrowseInstance("ca_entities");
 			if (is_array($va_types) && sizeof($va_types)) { $o_browse->setTypeRestrictions($va_types, array('dontExpandHierarchically' => caGetOption('dontExpandTypesHierarchically', $va_browse_info, false))); }
			$o_browse->addCriteria("_search", array("*"));
			$o_browse->execute(array('checkAccess' => $this->opa_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => true));
			
 			$va_facets = $o_browse->getInfoForAvailableFacets(['checkAccess' => $this->opa_access_values, 'request' => $this->request]);
 			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				if($va_facet_info["include_on_people_landing"]){
					$va_facets[$vs_facet_name]['content'] = $o_browse->getFacet($vs_facet_name, array('checkAccess' => $this->opa_access_values, 'request' => $this->request));
				}else{
					unset($va_facets[$vs_facet_name]);
				}
			}
			$this->view->setVar('facets', $va_facets);
			$this->render("People/index_html.php");
 		}
 		# -------------------------------------------------------
 		public function Story() {
 			caSetPageCSSClasses(array("story", "detail"));
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);
 			
 			$pn_entity_id = $this->request->getParameter("story", pInteger);
 			
 			$this->view->setVar('entity_id', $pn_entity_id);
 			# --- what is the set code of the featured people set?
 			$vs_set_code = $this->request->config->get("people_page_set_code");
			
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => $vs_set_code));
			# Enforce access control on set, make sure the entity id is in the set
			if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_set->get("access"), $this->opa_access_values))){
				$this->view->setVar('people_set', $t_set);
				$va_row_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values))) ? $va_tmp : array());
				$this->view->setVar('row_ids', $va_row_ids);
				if(in_array($pn_entity_id, $va_row_ids)){
					$t_entity = new ca_entities($pn_entity_id);
					$vn_key = array_search($pn_entity_id, $va_row_ids);
					$previous_id = $next_id = "";
					if($vn_key > 0){
						$previous_id = $va_row_ids[$vn_key - 1];
					}
					if($vn_next < (sizeof($va_row_ids) - 1)){
						$next_id = $va_row_ids[$vn_key + 1];
					}
					
					if((sizeof($this->opa_access_values) == 0) || (sizeof($this->opa_access_values) && in_array($t_entity->get("ca_entities.access"), $this->opa_access_values))){
						$this->view->setVar("entity", $t_entity);
						$this->view->setVar("previous_id", $previous_id);
						$this->view->setVar("next_id", $next_id);
					}
				}
			}

 			
			$this->render("People/story_detail_html.php");
 		}
 		# -------------------------------------------------------
 	}