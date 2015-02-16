<?php
/* ----------------------------------------------------------------------
 * controllers/SetsController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 
	require_once(__CA_LIB_DIR__."/core/Error.php");
	require_once(__CA_LIB_DIR__."/core/Datamodel.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_users.php");
 	require_once(__CA_APP_DIR__."/controllers/FindController.php");
 
 	class SetsController extends FindController {
 		# -------------------------------------------------------
 		 protected $opa_access_values;
 		 protected $opa_user_groups;
 		 protected $opo_config;
 		 protected $ops_lightbox_display_name;
 		 protected $ops_lightbox_display_name_plural;
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
 			$this->opa_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar("access_values", $this->opa_access_values);
 			$t_user_groups = new ca_user_groups();
 			$this->opa_user_groups = $t_user_groups->getGroupList("name", "desc", $this->request->getUserID());
 			$this->view->setVar("user_groups", $this->opa_user_groups);
 			$this->opo_config = caGetSetsConfig();
 			caSetPageCSSClasses(array("sets"));
 			
 			$va_lightbox_display_name = caGetSetDisplayName($this->opo_config);
 			$this->view->setVar('set_config', $this->opo_config);
 			
			$this->ops_lightbox_display_name = $va_lightbox_display_name["singular"];
			$this->ops_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
 		}
 		# -------------------------------------------------------
 		function Index() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$t_sets = new ca_sets();
 			$va_read_sets = $t_sets->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "checkAccess" => $this->opa_access_values, "access" => 1));
 			$va_write_sets = $t_sets->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "access" => 2));
 			# --- remove write sets from the read array
 			$va_read_sets = array_diff_key($va_read_sets, $va_write_sets);
 			$this->view->setVar("read_sets", $va_read_sets);
 			$this->view->setVar("write_sets", $va_write_sets);
 			$va_set_ids = array_merge(array_keys($va_read_sets), array_keys($va_write_sets));
 			$this->view->setVar("set_ids", $va_set_ids);
 			$va_set_change_log = $t_sets->getSetChangeLog($va_set_ids);
 			if(is_array($va_set_change_log) && sizeof($va_set_change_log)){
 				$va_set_change_log = array_slice($va_set_change_log, 0, 50);
 			}
 			$this->view->setVar("activity", $va_set_change_log);
            MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": ".ucfirst($this->ops_lightbox_display_name));
 			$this->render("Sets/set_list_html.php");
 		}
 		# ------------------------------------------------------
 		function setDetail() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			AssetLoadManager::register("mediaViewer");
 		
			$o_context = new ResultContext($this->request, 'ca_objects', 'sets', 'lightbox');
 			$o_context->setAsLastFind();
			$this->view->setVar('browse', $o_browse = caGetBrowseInstance("ca_objects"));
			$this->view->setVar("browse_type", "caLightbox");	# --- this is only used when loading hierarchy facets and is a way to get around needing a browse type to pull the table in FindController		
 			$ps_view = $this->request->getParameter('view', pString);
 			if(!in_array($ps_view, array('thumbnail', 'timeline', 'timelineData', 'pdf', 'list'))) {
 				$ps_view = 'thumbnail';
 			}
 			$this->view->setVar('view', $ps_view);
			$this->view->setVar('views', $this->opo_config->getAssoc("views"));

 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			
 			$vn_set_id = $t_set->get("set_id");
 			
 			$this->view->setVar("set", $t_set);
 			$va_comments = $t_set->getComments();
 			$this->view->setVar("comments", $va_comments);

			//
			// Load existing browse if key is specified
			//
			if ($ps_cache_key = $this->request->getParameter('key', pString)) {
				$o_browse->reload($ps_cache_key);
			}
			//
			// Clear criteria if required
			//
			
			if ($vs_remove_criterion = $this->request->getParameter('removeCriterion', pString)) {
				$o_browse->removeCriteria($vs_remove_criterion, array($this->request->getParameter('removeID', pString)));
			}
			
			if ((bool)$this->request->getParameter('clear', pInteger)) {
				// Clear all refine critera but *not* underlying _search criterion
				$va_criteria = $o_browse->getCriteria();
				foreach($va_criteria as $vs_criterion => $va_criterion_info) {
					if ($vs_criterion == '_search') { continue; }
					$o_browse->removeCriteria($vs_criterion, array_keys($va_criterion_info));
				}
			}
			if ($this->request->getParameter('getFacet', pInteger)) {
				$vs_facet = $this->request->getParameter('facet', pString);
				$this->view->setVar('facet_name', $vs_facet);
				$this->view->setVar('key', $o_browse->getBrowseID());
				$va_facet_info = $o_browse->getInfoForFacet($vs_facet);
				$this->view->setVar('facet_info', $va_facet_info);
				
				# --- pull in different views based on format for facet - alphabetical, list, hierarchy
				 switch($va_facet_info["group_mode"]){
					case "alphabetical":
					case "list":
					default:
						$this->view->setVar('facet_content', $o_browse->getFacetContent($vs_facet, array("checkAccess" => $this->opa_access_values)));
						$this->render("Browse/list_facet_html.php");
					break;
					case "hierarchical":
						$this->render("Browse/hierarchy_facet_html.php");
					break;
				}
				return;
			}
			//
			// Add criteria and execute
			//
			$vs_search_expression = "ca_sets.set_id:{$vn_set_id}";
			if (($o_browse->numCriteria() == 0) && $vs_search_expression) {
				$o_browse->addCriteria("_search", array($vs_search_expression));
			}
			if ($vs_facet = $this->request->getParameter('facet', pString)) {
				$o_browse->addCriteria($vs_facet, array($this->request->getParameter('id', pString)));
			}
			
			//
			// Sorting
			//
			$vb_sort_changed = false;
			if(!$ps_secondary_sort = $this->request->getParameter("secondary_sort", pString)){
 				$ps_secondary_sort = $o_context->getCurrentSecondarySort();
 			}
 			$va_config_sort = $this->opo_config->getAssoc("sortBy");
			if(!is_array($va_config_sort)){
				$va_config_sort = array();
			}
			$va_sort_by = array_merge(array(_t('Set order') => "ca_set_items.rank/{$vn_set_id}"), $va_config_sort);
		
 			if (!($ps_sort = urldecode($this->request->getParameter("sort", pString)))) {
 				if (!$ps_sort && !($ps_sort = $o_context->getCurrentSort())) {
 					if(is_array($va_sort_by)) {
 						$ps_sort = array_shift(array_keys($va_sort_by));
 						$vb_sort_changed = true;
 					}
 				}
 			}else{
 				$vb_sort_changed = true;
 			}
 			if($vb_sort_changed){
				# --- set the default sortDirection if available
				$va_sort_direction = $this->opo_config->getAssoc("sortDirection");
				if($ps_sort_direction = $va_sort_direction[$ps_sort]){
					$o_context->setCurrentSortDirection($ps_sort_direction);
				}
 				$ps_secondary_sort = "";			
 			}
 			if (!($ps_sort_direction = $this->request->getParameter("direction", pString))) {
 				if (!($ps_sort_direction = $o_context->getCurrentSortDirection())) {
 					$ps_sort_direction = 'asc';
 				}
 			}
 			
 			$o_context->setCurrentSort($ps_sort);
 			$o_context->setCurrentSecondarySort($ps_secondary_sort);
 			$o_context->setCurrentSortDirection($ps_sort_direction);
 			
			$this->view->setVar('sortBy', is_array($va_sort_by) ? $va_sort_by : null);
			$this->view->setVar('sortBySelect', $vs_sort_by_select = (is_array($va_sort_by) ? caHTMLSelect("sort", $va_sort_by, array('id' => "sort"), array("value" => $ps_sort)) : ''));
			$this->view->setVar('sort', $ps_sort);
			$va_secondary_sort_by = $this->opo_config->getAssoc("secondarySortBy");
			$this->view->setVar('secondarySortBy', is_array($va_secondary_sort_by) ? $va_secondary_sort_by : null);
			$this->view->setVar('secondarySortBySelect', $vs_secondary_sort_by_select = (is_array($va_secondary_sort_by) ? caHTMLSelect("secondary_sort", $va_secondary_sort_by, array('id' => "secondary_sort"), array("value" => $ps_secondary_sort)) : ''));
			$this->view->setVar('secondarySort', $ps_secondary_sort);
			$this->view->setVar('sortDirection', $ps_sort_direction);
			
			$va_options = array('checkAccess' => $this->opa_access_values, 'no_cache' => true);
			$o_browse->execute(array_merge($va_options, array('strictPhraseSearching' => true)));

			//
			// Facets
			//
			if ($vs_facet_group = $this->opo_config->get("set_facet_group")) {
				$o_browse->setFacetGroup($vs_facet_group);
			}
			$va_available_facet_list = $this->opo_config->get("availableFacets");
			$va_facets = $o_browse->getInfoForAvailableFacets();
			if(is_array($va_available_facet_list) && sizeof($va_available_facet_list)) {
				foreach($va_facets as $vs_facet_name => $va_facet_info) {
					if (!in_array($vs_facet_name, $va_available_facet_list)) {
						unset($va_facets[$vs_facet_name]);
					}
				}
			} 
		
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				$va_facets[$vs_facet_name]['content'] = $o_browse->getFacetContent($vs_facet_name, array("checkAccess" => $this->opa_access_values));
			}
		
			$this->view->setVar('facets', $va_facets);
		
			$this->view->setVar('key', $vs_key = $o_browse->getBrowseID());
			$this->request->session->setVar('lightbox_last_browse_id', $vs_key);
			
			//
			// Current criteria
			//
			$va_criteria = $o_browse->getCriteriaWithLabels();
			if (isset($va_criteria['_search']) && (isset($va_criteria['_search']['*']))) {
				unset($va_criteria['_search']);
			}
			$va_criteria_for_display = array();
			foreach($va_criteria as $vs_facet_name => $va_criterion) {
				$va_facet_info = $o_browse->getInfoForFacet($vs_facet_name);
				foreach($va_criterion as $vn_criterion_id => $vs_criterion) {
					$va_criteria_for_display[] = array('facet' => $va_facet_info['label_singular'], 'facet_name' => $vs_facet_name, 'value' => $vs_criterion, 'id' => $vn_criterion_id);
				}
			}
			
			$this->view->setVar('criteria', $va_criteria_for_display);
			
			// 
			// Results
			//
			$vs_combined_sort = $va_sort_by[$ps_sort];
			
			if($ps_secondary_sort){
				$vs_combined_sort .= ";".$va_secondary_sort_by[$ps_secondary_sort];
			}
			
			$qr_res = $o_browse->getResults(array('sort' => $vs_combined_sort, 'sort_direction' => $ps_sort_direction));
			$this->view->setVar('result', $qr_res);
			
			if (!($pn_hits_per_block = $this->request->getParameter("n", pString))) {
 				if (!($pn_hits_per_block = $o_context->getItemsPerPage())) {
 					$pn_hits_per_block = ($this->opo_config->get("defaultHitsPerBlock")) ? $this->opo_config->get("defaultHitsPerBlock") : 36;
 				}
 			}
 			$o_context->getItemsPerPage($pn_hits_per_block);
			
			$this->view->setVar('hits_per_block', $pn_hits_per_block);
			
			$this->view->setVar('start', $vn_start = $this->request->getParameter('s', pInteger));
			
			$o_context->setParameter('key', $vs_key);
			
			if (($vn_key_start = $vn_start - 500) < 0) { $vn_key_start = 0; }
			$qr_res->seek($vn_key_start);
			$o_context->setResultList($qr_res->getPrimaryKeyValues(1000));
			if ($o_block_result_context) { $o_block_result_context->setResultList($qr_res->getPrimaryKeyValues(1000)); $o_block_result_context->saveContext();}
			$qr_res->seek($vn_start);
			
			$o_context->saveContext();
 			
            MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": ".ucfirst($this->ops_lightbox_display_name).": ".$t_set->getLabelForDisplay());
 			switch($ps_view) {
 				case 'pdf':
 					$this->_genExport($qr_res, $this->request->getParameter("export_format", pString), $vs_label = $t_set->get('ca_sets.preferred_labels'), $vs_label);
 				case 'timelineData':
 					$this->view->setVar('view', 'timeline');
 					$this->render("Sets/set_detail_timelineData_json.php");
 					break;
 				default:
 					$this->render("Sets/set_detail_html.php");
 					break;
 			}
 		}
 		# ------------------------------------------------------
 		function setForm() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			# --- if set exists, we're being redirected here after attempting a save
 			if (!$t_set){
 				# --- set_id is passed, so we're editing a set
 				if($this->request->getParameter('set_id', pInteger)){
					$t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__);
					# --- pass name and description to populate form
					$this->view->setVar("name", $t_set->getLabelForDisplay());
					$this->view->setVar("description", $t_set->get("description"));
				}else{
					$t_set = new ca_sets();
				}
 			}
 			$this->view->setVar("set", $t_set);
 			$this->render("Sets/form_set_info_html.php");
 		}
 		# ------------------------------------------------------
 		function saveSetInfo() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			$o_purifier = new HTMLPurifier();
 			
 			# --- set_id is passed through form, otherwise we're saving a new set
 			if($this->request->getParameter('set_id', pInteger)){
 				$t_set = $this->_getSet(__CA_EDIT_READ_ACCESS__);
 			}else{
 				$t_set = new ca_sets();
 			}
 			# --- check for errors
 			# --- set name - required
 			$ps_name = $o_purifier->purify($this->request->getParameter('name', pString));
 			if(!$ps_name){
 				$va_errors["name"] = _t("Please enter the name of your %1", $this->ops_lightbox_display_name);
 			}else{
 				$this->view->setVar("name", $ps_name);
 			}
 			# --- set description - optional
 			$ps_description =  $o_purifier->purify($this->request->getParameter('description', pString));
 			$this->view->setVar("description", $ps_description);

 			$t_list = new ca_lists();
 			$vn_set_type_user = $t_list->getItemIDFromList('set_types', $this->request->config->get('user_set_type'));
 			$t_object = new ca_objects();
 			$vn_object_table_num = $t_object->tableNum();
 			if(sizeof($va_errors) == 0){
				$t_set->setMode(ACCESS_WRITE);
				$t_set->set('access', 1);
				#$t_set->set('access', $this->request->getParameter('access', pInteger));
				if($t_set->get("set_id")){
					# --- edit/add description
					$t_set->replaceAttribute(array('description' => $ps_description, 'locale_id' => $g_ui_locale_id), 'description');
					$t_set->update();
				}else{
					$t_set->set('table_num', $vn_object_table_num);
					$t_set->set('type_id', $vn_set_type_user);
					$t_set->set('user_id', $this->request->getUserID());
					$t_set->set('set_code', $this->request->getUserID().'_'.time());
					# --- create new attribute
					$t_set->addAttribute(array('description' => $ps_description, 'locale_id' => $g_ui_locale_id), 'description');
					$t_set->insert();
				}
				if($t_set->numErrors()) {
					$va_errors["general"] = join("; ", $t_set->getErrors());
					$this->view->setVar('errors', $va_errors);
					$this->setForm();
				}else{
					# --- save name
					if (sizeof($va_labels = caExtractValuesByUserLocale($t_set->getLabels(array($g_ui_locale_id), __CA_LABEL_TYPE_PREFERRED__)))) {
						# --- edit label	
						foreach($va_labels as $vn_set_id => $va_label) {
							$t_set->editLabel($va_label[0]['label_id'], array('name' => $ps_name), $g_ui_locale_id);
						}
					} else {
						# --- add new label
						$t_set->addLabel(array('name' => $ps_name), $g_ui_locale_id, null, true);
					}
					
					# --- select the current set
					$this->request->user->setVar('current_set_id', $t_set->get("set_id"));
					
					$this->view->setVar("message", _t('Saved %1.', $this->ops_lightbox_display_name));
 					$this->render("Form/reload_html.php");
				}
			}else{
				$this->view->setVar('errors', $va_errors);
				$this->setForm();
			} 			
 		}
 		# ------------------------------------------------------
 		function setAccess() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			# --- list of groups/users with access to set
 			$this->view->setVar("users", $t_set->getSetUsers());
 			$this->view->setVar("user_groups", $t_set->getSetGroups());
 			
 			$this->render("Sets/set_access_html.php");
 		}
 		# ------------------------------------------------------
 		function saveGroupAccess() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			# --- list of groups/users with access to set
 			$this->view->setVar("users", $t_set->getSetUsers());
 			$this->view->setVar("user_groups", $t_set->getSetGroups());
 			
 			$this->render("Sets/set_access_html.php");
 		}
 		# ------------------------------------------------------
 		function removeGroupAccess() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$pn_group_id = $this->request->getParameter('group_id', pInteger);
 			$t_item = new ca_sets_x_user_groups();
			$t_item->load(array('set_id' => $t_set->get('set_id'), 'group_id' => $pn_group_id));
			if($t_item->get("relation_id")){
				$t_item->setMode(ACCESS_WRITE);
				$t_item->delete(true);
				if ($t_item->numErrors()) {
					$this->view->setVar('errors', join("; ", $t_item->getErrors()));
				}else{
					$this->view->setVar('message', _t("Removed group access to %1", $this->ops_lightbox_display_name));
				}
			}else{
				$this->view->setVar('errors', _("invalid group/set id"));
			}
			$this->setAccess();
 		}
 		# ------------------------------------------------------
 		function removeUserAccess() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$pn_user_id = $this->request->getParameter('user_id', pInteger);
 			$t_item = new ca_sets_x_users();
			$t_item->load(array('set_id' => $t_set->get('set_id'), 'user_id' => $pn_user_id));
			if($t_item->get("relation_id")){
				$t_item->setMode(ACCESS_WRITE);
				$t_item->delete(true);
				if ($t_item->numErrors()) {
					$this->view->setVar('errors', join("; ", $t_item->getErrors()));
				}else{
					$this->view->setVar('message', _t("Removed user access to %1", $this->ops_lightbox_display_name));
				}
			}else{
				$this->view->setVar('errors', _("invalid user/set id"));
			}
 			$this->setAccess();
 		}
 		# ------------------------------------------------------
 		function editGroupAccess() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$pn_group_id = $this->request->getParameter('group_id', pInteger);
 			$pn_access = $this->request->getParameter('access', pInteger);
 			$t_item = new ca_sets_x_user_groups();
			$t_item->load(array('set_id' => $t_set->get('set_id'), 'group_id' => $pn_group_id));
			if($t_item->get("relation_id") && $pn_access){
				$t_item->setMode(ACCESS_WRITE);
				$t_item->set('access', $pn_access);
				$t_item->update();
				if ($t_item->numErrors()) {
					$this->view->setVar('errors', join("; ", $t_item->getErrors()));
				}else{
					$this->view->setVar('message', _t("Changed group access to %1", $this->ops_lightbox_display_name));
				}
			}else{
				$this->view->setVar('errors', _("invalid group/set id or access"));
			}
			$this->setAccess();
 		}
 		# ------------------------------------------------------
 		function editUserAccess() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$pn_user_id = $this->request->getParameter('user_id', pInteger);
 			$pn_access = $this->request->getParameter('access', pInteger);
 			$t_item = new ca_sets_x_users();
			$t_item->load(array('set_id' => $t_set->get('set_id'), 'user_id' => $pn_user_id));
			if($t_item->get("relation_id") && $pn_access){
				$t_item->setMode(ACCESS_WRITE);
				$t_item->set('access', $pn_access);
				$t_item->update();
				if ($t_item->numErrors()) {
					$this->view->setVar('errors', join("; ", $t_item->getErrors()));
				}else{
					$this->view->setVar('message', _t("Changed user access to %1", $this->ops_lightbox_display_name));
				}
			}else{
				$this->view->setVar('errors', _("invalid user/set id or access"));
			}
			$this->setAccess();
 		}
 		# ------------------------------------------------------
 		function shareSetForm() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$this->render("Sets/form_share_set_html.php");
 		}
 		# ------------------------------------------------------
 		function saveShareSet() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__);
 			$o_purifier = new HTMLPurifier();
 			$ps_user = $o_purifier->purify($this->request->getParameter('user', pString));
 			# --- ps_user can be list of emails separated by comma
 			$va_users = explode(", ", $ps_user);
 			$pn_group_id = $this->request->getParameter('group_id', pInteger);
 			if(!$pn_group_id && !$ps_user){
 				$va_errors["general"] = _t("Please select a user or group");
 			}
 			$pn_access = $this->request->getParameter('access', pInteger);
 			if(!$pn_access){
 				$va_errors["access"] = _t("Please select an access level");
 			}
 			if(sizeof($va_errors) == 0){
				if($pn_group_id){
					$t_sets_x_user_groups = new ca_sets_x_user_groups();
					if($t_sets_x_user_groups->load(array("set_id" => $t_set->get("set_id"), "group_id" => $pn_group_id))){
						$this->view->setVar("message", _t('Group already has access to the %1', $this->ops_lightbox_display_name));
						$this->render("Form/reload_html.php");
					}else{
						$t_sets_x_user_groups->setMode(ACCESS_WRITE);
						$t_sets_x_user_groups->set('access',  $pn_access);
						$t_sets_x_user_groups->set('group_id',  $pn_group_id);
						$t_sets_x_user_groups->set('set_id',  $t_set->get("set_id"));
						$t_sets_x_user_groups->insert();
						if($t_sets_x_user_groups->numErrors()) {
							$va_errors["general"] = join("; ", $t_sets_x_user_groups->getErrors());
							$this->view->setVar('errors', $va_errors);
							$this->shareSetForm();
						}else{
							$t_group = new ca_user_groups($pn_group_id);
							$va_group_users = $t_group->getGroupUsers();
							if(sizeof($va_group_users)){
								# --- send email to each group user
								# --- send email confirmation
								$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
								$o_view->setVar("set", $t_set->getLabelForDisplay());
								$o_view->setVar("from_name", trim($this->request->user->get("fname")." ".$this->request->user->get("lname")));
							
							
								# -- generate email subject line from template
								$vs_subject_line = $o_view->render("mailTemplates/share_set_notification_subject.tpl");
								
								# -- generate mail text from template - get both the text and the html versions
								$vs_mail_message_text = $o_view->render("mailTemplates/share_set_notification.tpl");
								$vs_mail_message_html = $o_view->render("mailTemplates/share_set_notification_html.tpl");
							
								foreach($va_group_users as $va_user_info){
									# --- don't send notification to self
									if($this->request->user->get("user_id") != $va_user_info["user_id"]){
										caSendmail($va_user_info["email"], array($this->request->user->get("email") => trim($this->request->user->get("fname")." ".$this->request->user->get("lname"))), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
									}
								}
							}							
							
							
							$this->view->setVar("message", _t('Shared %1 with group', $this->ops_lightbox_display_name));
							$this->render("Form/reload_html.php");
						}
					}
				}else{
					$va_error_emails = array();
					$va_success_emails = array();
					$va_error_emails_has_access = array();
					$t_user = new ca_users();
					foreach($va_users as $vs_user){
						# --- lookup the user/users
						$t_user->load(array("email" => $vs_user));
						if($vn_user_id = $t_user->get("user_id")){
							$t_sets_x_users = new ca_sets_x_users();
							if(($vn_user_id == $t_set->get("user_id")) || ($t_sets_x_users->load(array("set_id" => $t_set->get("set_id"), "user_id" => $vn_user_id)))){
								$va_error_emails_has_access[] = $vs_user;
							}else{
								$t_sets_x_users->setMode(ACCESS_WRITE);
								$t_sets_x_users->set('access',  $pn_access);
								$t_sets_x_users->set('user_id',  $vn_user_id);
								$t_sets_x_users->set('set_id',  $t_set->get("set_id"));
								$t_sets_x_users->insert();
								if($t_sets_x_users->numErrors()) {
									$va_errors["general"] = _t("There were errors while sharing this %1 with %2", $this->ops_lightbox_display_name, $vs_user).join("; ", $t_sets_x_users->getErrors());
									$this->view->setVar('errors', $va_errors);
									$this->shareSetForm();
								}else{
									$va_success_emails[] = $vs_user;
									$va_success_emails_info[] = array("email" => $vs_user, "name" => trim($t_user->get("fname")." ".$t_user->get("lname")));
								}
							}
						}else{
							$va_error_emails[] = $vs_user;
						}
					}
					if((sizeof($va_error_emails)) || (sizeof($va_error_emails_has_access))){
						$va_user_errors = array();
						if(sizeof($va_error_emails)){
							$va_user_errors[] = _t("The following email(s) you entered do not belong to a registered user: ").implode(", ", $va_error_emails);
						}
						if(sizeof($va_error_emails_has_access)){
							$va_user_errors[] = _t("The following email(s) you entered already have access to this %1: ", $this->ops_lightbox_display_name).implode(", ", $va_error_emails_has_access);
						}
						if(sizeof($va_success_emails)){
							$this->view->setVar('message', _t('Shared %1 with: ', $this->ops_lightbox_display_name).implode(", ", $va_success_emails));
						}
						$va_errors["user"] = implode("<br/>", $va_user_errors);
						$this->view->setVar('errors', $va_errors);
						$this->shareSetForm();
					}else{
						$this->view->setVar("message", _t('Shared %1 with: ', $this->ops_lightbox_display_name).implode(", ", $va_success_emails));
						$this->render("Form/reload_html.php");
					}
					if(is_array($va_success_emails_info) && sizeof($va_success_emails_info)){
						# --- send email to user
						# --- send email confirmation
						$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
						$o_view->setVar("set", $t_set->getLabelForDisplay());
						$o_view->setVar("from_name", trim($this->request->user->get("fname")." ".$this->request->user->get("lname")));
					
					
						# -- generate email subject line from template
						$vs_subject_line = $o_view->render("mailTemplates/share_set_notification_subject.tpl");
						
						# -- generate mail text from template - get both the text and the html versions
						$vs_mail_message_text = $o_view->render("mailTemplates/share_set_notification.tpl");
						$vs_mail_message_html = $o_view->render("mailTemplates/share_set_notification_html.tpl");
					
						foreach($va_success_emails as $vs_email){
							caSendmail($vs_email, array($this->request->user->get("email") => trim($this->request->user->get("fname")." ".$this->request->user->get("lname"))), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
						}
					}
				}
			}else{
				$this->view->setVar('errors', $va_errors);
				$this->shareSetForm();
			} 		
 		}
 		# ------------------------------------------------------
 		function userGroupList() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$this->render("Sets/user_group_list_html.php");
 		}
 		# ------------------------------------------------------
 		function userGroupForm() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			if(!$t_user_group){
 				$t_user_group = new ca_user_groups();
 			}
 			$this->view->setVar("user_group",$t_user_group);
 			$this->render("Sets/form_user_group_html.php");
 		}
 		# ------------------------------------------------------
 		function saveUserGroup() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			$o_purifier = new HTMLPurifier();
 			
 			$t_user_group = new ca_user_groups();
 			if($pn_group_id = $this->request->getParameter('group_id', pInteger)){
 				$t_user_group->load($pn_group_id);
 			}
 			
 			# --- check for errors
 			# --- group name - required
 			$ps_name = $o_purifier->purify($this->request->getParameter('name', pString));
 			if(!$ps_name){
 				$va_errors["name"] = _t("Please enter the name of your user group");
 			}else{
 				$this->view->setVar("name", $ps_name);
 			}
 			# --- user group description - optional
 			$ps_description =  $o_purifier->purify($this->request->getParameter('description', pString));
 			$this->view->setVar("description", $ps_description);

 			if(sizeof($va_errors) == 0){
				$t_user_group->setMode(ACCESS_WRITE);
				$t_user_group->set('name',  $ps_name);
				$t_user_group->set('description',  $ps_description);
				if($t_user_group->get("group_id")){
					$t_user_group->update();
				}else{
					$t_user_group->set('user_id', $this->request->getUserID());
					$t_user_group->set('code', 'lb_'.$this->request->getUserID().'_'.time());
					$t_user_group->insert();
					if($t_user_group->get("group_id")){
						$t_user_group->addUsers($this->request->getUserID());
					}
				}
				if($t_user_group->numErrors()) {
					$va_errors["general"] = join("; ", $t_user_group->getErrors());
					$this->view->setVar('errors', $va_errors);
					$this->userGroupForm();
				}else{
					# --- add current user to group
					$this->view->setVar("message", _t('Saved user group.'));
 					$this->render("Form/reload_html.php");
				}
			}else{
				$this->view->setVar('errors', $va_errors);
				$this->userGroupForm();
			} 			
 		}
 		# ------------------------------------------------------
 		function AjaxListComments() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$o_datamodel = new Datamodel();
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			# --- check this is a valid table to have comments in the lightbox
 			if(!in_array($ps_tablename, array("ca_sets", "ca_set_items"))){ $this->Index();}
 			# --- load table
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$t_item = $o_datamodel->getTableInstance($ps_tablename);
 			$t_item->load($pn_item_id);
 			$va_comments = $t_item->getComments();
 			
 			$this->view->setVar("set", $t_set);
 			$this->view->setVar("tablename", $ps_tablename);
 			$this->view->setVar("item_id", $pn_item_id);
 			$this->view->setVar("comments", $va_comments);
			$this->render("Sets/ajax_comments.php");
 		}
 		# ------------------------------------------------------
 		function AjaxSaveComment() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			# --- when close is set to true, will make the form view disappear after saving form
 			$vb_close = false;
 			$o_datamodel = new Datamodel();
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			# --- check this is a valid table to have comments in the lightbox
 			if(!in_array($ps_tablename, array("ca_sets", "ca_set_items"))){ $this->Index(); }
 			# --- load table
 			$t_item = $o_datamodel->getTableInstance($ps_tablename);
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$t_item->load($pn_item_id);
 			$ps_comment = $this->request->getParameter('comment', pString);
 			if(!$ps_comment){
 				$vs_error = _t("Please enter a comment");
 				$this->AjaxListComments();
 				return;
 			}else{
 				# --- pass user's id as moderator - all set comments should be made public, it's a private space and comments should not need to be moderated
 				if($t_item->addComment($ps_comment, null, $this->request->getUserID(), null, null, null, 1, $this->request->getUserID(), array("purify" => true))){
 					$vs_message = _t("Saved comment");
 					$vb_close = true;
 				}else{
 					$vs_error = _t("There were errors adding your comment: ".join("; ", $t_item->getErrors()));
 					$this->AjaxListComments();
 					return;
 				}
 			}
 			$this->view->setVar("tablename", $ps_tablename);
 			$this->view->setVar("item_id", $pn_item_id);
 			$this->view->setVar("message", $vs_message);
			$this->view->setVar("error", $vs_error);
			$this->view->setVar("close", $vb_close);
			$this->render("Sets/ajax_comments.php");
 		}
 		# ------------------------------------------------------
 		function saveComment() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$o_datamodel = new Datamodel();
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); return;}
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			if (!$ps_tablename) { $this->Index(); return;}
 			# --- check this is a valid table to have comments in the lightbox
 			if(!in_array($ps_tablename, array("ca_sets", "ca_set_items"))){ $this->Index(); }
 			# --- load table
 			$t_item = $o_datamodel->getTableInstance($ps_tablename);
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$t_item->load($pn_item_id);
 			$ps_comment = $this->request->getParameter('comment', pString);
 			if(!$ps_comment){
 					$this->notification->addNotification(_t("Please enter a comment"), __NOTIFICATION_TYPE_ERROR__);
 			}else{
 				# --- pass user's id as moderator - all set comments should be made public, it's a private space and comments should not need to be moderated
 				if($t_item->addComment($ps_comment, null, $this->request->getUserID(), null, null, null, 1, $this->request->getUserID(), array("purify" => true))){
 					$this->notification->addNotification(_t("Saved comment"), __NOTIFICATION_TYPE_INFO__);
 				}else{
 					$this->notification->addNotification(_t("There were errors saving your comment"), __NOTIFICATION_TYPE_ERROR__);
 				}
 			}
 			if($ps_tablename == "ca_sets"){
 				$this->response->setRedirect(caNavUrl($this->request, '', 'Sets', 'setDetail', array("key" => $this->request->getParameter('key', pString))));
 				#$this->setDetail();
 			}
 		}
 		# ------------------------------------------------------
 		function deleteComment() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$o_datamodel = new Datamodel();
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); return;}
 			$pn_comment_id = $this->request->getParameter("comment_id", pInteger);
 			$t_comment = new ca_item_comments($pn_comment_id);
 			
 			if($t_comment->get("comment_id")){
				# --- check if user is owner of comment or has edit access to set comment was made on
				if(($this->request->getUserID() != $t_comment->get("user_id")) && !$t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)){
					$this->Index(); return;
				}
				
				$t_comment->setMode(ACCESS_WRITE);
				$t_comment->delete(true);
				if ($t_comment->numErrors()) {
					$this->notification->addNotification(_t("There were errors:".join("; ", $t_comment->getErrors())), __NOTIFICATION_TYPE_ERROR__);
				}else{
					$this->notification->addNotification(_t("Removed comment"), __NOTIFICATION_TYPE_INFO__);
				}
			}else{
				$this->notification->addNotification(_t("Invalid comment_id"), __NOTIFICATION_TYPE_ERROR__);
			}
			$ps_reload = $this->request->getParameter("reload", pString);
 			switch($ps_reload){
 				case "detail":
 					$this->response->setRedirect(caNavUrl($this->request, '', 'Sets', 'setDetail'));
 					return;
 				break;
 				# -----------------------------
 				default:
 					$this->response->setRedirect(caNavUrl($this->request, '', 'Sets', 'Index'));
 					return;
 				break;
 				# -----------------------------
 			}
 		}
 		# -------------------------------------------------------
 		public function DeleteSet() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			if ($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)) { 
 				$vs_set_name = $t_set->getLabelForDisplay();
 				$t_set->setMode(ACCESS_WRITE);
 				$t_set->delete();
 				
 				if($t_set->numErrors()) {
 					$this->notification->addNotification(_t("<em>%1</em> could not be deleted: %2", $vs_set_name, join("; ", $t_set->getErrors())), __NOTIFICATION_TYPE_ERROR__);
 				} else {
 					$this->notification->addNotification(_t("<em>%1</em> was deleted", $vs_set_name), __NOTIFICATION_TYPE_INFO__);
 				}
 			}
 			$this->Index();
 		}
 		# ------------------------------------------------------
 		public function AjaxReorderItems() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
			if($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)){
				
				$this->view->setVar("set_id", $t_set->get("set_id"));
				
				$va_row_ids = array();
				$va_row_ids_raw = explode('&', $this->request->getParameter('row_ids', pString));
				foreach($va_row_ids_raw as $vn_row_id_raw){
					$va_row_ids[] = str_replace('row[]=', '', $vn_row_id_raw);
				}
				$va_errors = $t_set->reorderItems($va_row_ids);
			}else{
				$va_errors[] = _t("%1 is not defined or you don't have access to the lightbox", $this->ops_lightbox_display_name);
			}
			$this->view->setVar('errors', $va_errors);
			$this->render('Sets/ajax_reorder_items_json.php');
 		}
 		# -------------------------------------------------------
 		public function AjaxDeleteItem() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
			if($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)){
				
				$pn_item_id = $this->request->getParameter('item_id', pInteger);
				if ($t_set->removeItemByItemID($pn_item_id, $this->request->getUserID())) {
					$va_errors = array();
				} else {
					$va_errors[] = _t('Could not remove item from %1', $this->ops_lightbox_display_name);
				}
				$this->view->setVar('set_id', $pn_set_id);
				$this->view->setVar('item_id', $pn_item_id);
			} else {
				$va_errors['general'] = _t('You do not have access to the %1', $this->ops_lightbox_display_name);	
			}
 			
 			$this->view->setVar('errors', $va_errors);
 			$this->render('Sets/ajax_delete_item_json.php');
 		}
 		# -------------------------------------------------------
 		public function AjaxAddItem() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			$o_purifier = new HTMLPurifier();
 			
 			# --- set_id is passed through form, otherwise we're saving a new set, and adding the item to it
 			if($this->request->getParameter('set_id', pInteger)){
 				$t_set = $this->_getSet(__CA_EDIT_READ_ACCESS__);
 				if(!$t_set && $t_set = $this->_getSet(__CA_SET_READ_ACCESS__)){
 					$va_errors["general"] = _t("You can not add items to this %1.  You have read only access.", $this->ops_lightbox_display_name);
 					$this->view->setVar('errors', $va_errors);
 					$this->addItemForm();
 					return;
 				}
 			}else{
 				$t_set = new ca_sets();
				# --- set name - if not sent, make a decent default
				$ps_name = $o_purifier->purify($this->request->getParameter('name', pString));
				if(!$ps_name){
					$ps_name = _t("Your %1", $this->ops_lightbox_display_name);
				}
				# --- set description - optional
				$ps_description =  $o_purifier->purify($this->request->getParameter('description', pString));
	
				$t_list = new ca_lists();
				$vn_set_type_user = $t_list->getItemIDFromList('set_types', $this->request->config->get('user_set_type'));
				$t_object = new ca_objects();
				$vn_object_table_num = $t_object->tableNum();
				$t_set->setMode(ACCESS_WRITE);
				$t_set->set('access', 1);
				#$t_set->set('access', $this->request->getParameter('access', pInteger));
				$t_set->set('table_num', $vn_object_table_num);
				$t_set->set('type_id', $vn_set_type_user);
				$t_set->set('user_id', $this->request->getUserID());
				$t_set->set('set_code', $this->request->getUserID().'_'.time());
				# --- create new attribute
				if($ps_description){
					$t_set->addAttribute(array('description' => $ps_description, 'locale_id' => $g_ui_locale_id), 'description');
				}
				$t_set->insert();
				if($t_set->numErrors()) {
					$va_errors["general"] = join("; ", $t_set->getErrors());
					$this->view->setVar('errors', $va_errors);
					$this->addItemForm();
					return;
				}else{
					# --- save name - add new label
					$t_set->addLabel(array('name' => $ps_name), $g_ui_locale_id, null, true);
					# --- select the current set
					$this->request->user->setVar('current_set_id', $t_set->get("set_id"));

				}			
			}
			if($t_set){
				$pn_item_id = null;
				$pn_object_id = $this->request->getParameter('object_id', pInteger);
				if($pn_object_id){
					if(!$t_set->isInSet("ca_objects", $pn_object_id, $t_set->get("set_id"))){
						if ($pn_item_id = $t_set->addItem($pn_object_id, array(), $this->request->getUserID())) {
							//
							// Select primary representation
							//
							$t_object = new ca_objects($pn_object_id);
							$vn_rep_id = $t_object->getPrimaryRepresentationID();	// get representation_id for primary
							
							$t_item = new ca_set_items($pn_item_id);
							$t_item->addSelectedRepresentation($vn_rep_id);			// flag as selected in item vars
							$t_item->update();
							
							$va_errors = array();
							$this->view->setVar('message', _t("Successfully added item."));
							$this->render("Form/reload_html.php");
						} else {
							$va_errors["message"] = _t('Could not add item to %1', $this->ops_lightbox_display_name);
							$this->render("Form/reload_html.php");
						}
					}else{
						$this->view->setVar('message', _t("Item already in %1.", $this->ops_lightbox_display_name));
						$this->render("Form/reload_html.php");
					}				
				}else{
					if(($pb_saveLastResults = $this->request->getParameter('saveLastResults', pString)) || ($ps_object_ids = $this->request->getParameter('object_ids', pString))){
						if($pb_saveLastResults){
							# --- get object ids from last result
							$o_context = ResultContext::getResultContextForLastFind($this->request, "ca_objects");
							$va_object_ids = $o_context->getResultList();
						}else{
							$va_object_ids = explode(";", $ps_object_ids);
						}
						if(is_array($va_object_ids) && sizeof($va_object_ids)){
							# --- check for those already in set
							$va_object_ids_in_set = $t_set->areInSet("ca_objects", $va_object_ids, $t_set->get("set_id"));
							$va_object_ids = array_diff($va_object_ids, $va_object_ids_in_set);
							# --- insert items
							$t_set->addItems($va_object_ids);
							$this->view->setVar('message', _t("Successfully added results to %1.", $this->ops_lightbox_display_name));
							$this->render("Form/reload_html.php");
							
						}else{
							$this->view->setVar('message', _t("No objects in search result to add to %1", $this->ops_lightbox_display_name));
							$this->render("Form/reload_html.php");
						}
					}else{
						$this->view->setVar('message', _t("Object ID is not defined"));
						$this->render("Form/reload_html.php");
					}
				}
			}
 		}
 		# -------------------------------------------------------
 		public function addItemForm(){
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			$this->view->setvar("set", new ca_Sets());
 			$this->view->setvar("object_id", $this->request->getParameter('object_id', pInteger));
 			$this->view->setvar("object_ids", $this->request->getParameter('object_ids', pString));
 			$this->view->setvar("saveLastResults", $this->request->getParameter('saveLastResults', pInteger));
 			if($this->request->getParameter('object_id', pInteger) || $this->request->getParameter('saveLastResults', pInteger) || sizeof(explode(";", $this->request->getParameter('object_ids', pString)))){
 				$this->render("Sets/form_add_set_item_html.php");
 			}else{
 				$this->view->setVar('message', _t("Object ID is not defined"));
				$this->render("Form/reload_html.php");
 			}
 		}
		# ------------------------------------------------------
		/**
		 *
		 */
		public function Present() {
			AssetLoadManager::register("reveal.js");
			$o_app = AppController::getInstance();
			$o_app->removeAllPlugins();
			$t_set = $this->_getSet();
			$this->view->setVar("set", $t_set);

			$this->render("Sets/present_html.php");
		}
 		# -------------------------------------------------------
 		
 		/** 
 		 * Return set_id from request with fallback to user var, or if nothing there then get the users' first set
 		 */
 		private function _getSetID() {
 			$vn_set_id = null;
 			if (!$vn_set_id = $this->request->getParameter('set_id', pInteger)) {			// try to get set_id from request
 				if(!$vn_set_id = $this->request->user->getVar('current_set_id')){		// get last used set_id
 					return null;
 				}
 			}
 			return $vn_set_id;
 		}
 		# -------------------------------------------------------
 		/**
 		 * Uses _getSetID() to figure out the ID of the current set, then returns a ca_sets object for it
 		 * and also sets the 'current_set_id' user variable
 		 */
 		private function _getSet($vs_access_level = __CA_SET_EDIT_ACCESS__) {
 			$t_set = new ca_sets();
 			$vn_set_id = $this->_getSetID();
 			if($vn_set_id){
				$t_set->load($vn_set_id);
				
				if ($t_set->getPrimaryKey() && ($t_set->haveAccessToSet($this->request->getUserID(), $vs_access_level))) {
					$this->request->user->setVar('current_set_id', $vn_set_id);
					# --- pass the access level the user has to the set - needed to display the proper controls in views
					$vb_write_access = false;
					if($t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)){
						$vb_write_access = true;
					}
					$this->view->setVar("write_access", $vb_write_access);
					return $t_set;
				}
			}
 			return null;
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'Sets',
 				'action' => 'setDetail',
 				'params' => array(
 				
 				)
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
 	}
 ?>