<?php
/* ----------------------------------------------------------------------
 * controllers/LightboxController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2017 Whirl-i-Gig
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
	require_once(__CA_LIB_DIR__."/Datamodel.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_users.php");
 	require_once(__CA_APP_DIR__."/controllers/FindController.php");
 	require_once(__CA_LIB_DIR__."/GeographicMap.php");
	require_once(__CA_LIB_DIR__.'/Parsers/ZipStream.php');
	require_once(__CA_LIB_DIR__.'/Logging/Downloadlog.php');
 
 	class LightboxController extends FindController {
 		# -------------------------------------------------------
        /**
         * @var array
         */
 		 protected $opa_access_values;

        /**
         * @var array
         */
 		 protected $opa_user_groups;

        /**
         * @var
         */
 		 protected $ops_lightbox_display_name;

        /**
         * @var
         */
 		 protected $ops_lightbox_display_name_plural;

        /**
         * @var
         */
        protected $opb_is_login_redirect = false;
        
        /**
         * @var HTMLPurifier
         */
        protected $purifier;
        
        /**
         * @var string
         */
        protected $ops_tablename = 'ca_objects';
        
 		/**
 		 *
 		 */
 		protected $ops_view_prefix = 'Lightbox';
 		protected $ops_description_attribute;
        
 		# -------------------------------------------------------
        /**
         * @param RequestHTTP $po_request
         * @param ResponseHTTP $po_response
         * @param null $pa_view_paths
         * @throws ApplicationException
         */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);

            // Catch disabled lightbox
            if ($this->request->config->get('disable_lightbox') && $this->request->config->get('disable_classroom')) {
 				throw new ApplicationException('Lightbox/classroom is not enabled');
 			}
 			if (!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
                $this->opb_is_login_redirect = true;
                return;
            }
            
 			$t_user_groups = new ca_user_groups();
 			$this->opa_user_groups = $t_user_groups->getGroupList("name", "desc", $this->request->getUserID());
 			$this->view->setVar("user_groups", $this->opa_user_groups);

 			$this->opo_config = caGetLightboxConfig();
 			caSetPageCSSClasses(array("sets", "lightbox"));
 			
 			$va_lightboxDisplayName = caGetLightboxDisplayName($this->opo_config);
 			$this->view->setVar('set_config', $this->opo_config);
 			
			$this->ops_lightbox_display_name = $va_lightboxDisplayName["singular"];
			$this->ops_lightbox_display_name_plural = $va_lightboxDisplayName["plural"];
			$this->ops_description_attribute = ($this->opo_config->get("lightbox_set_description_element_code") ? $this->opo_config->get("lightbox_set_description_element_code") : "description");
			$this->view->setVar('description_attribute', $this->ops_description_attribute);
			
			$this->purifier = new HTMLPurifier();
			
 			parent::setTableSpecificViewVars();
 		}
 		# -------------------------------------------------------
        /**
         *
         */
 		function index($pa_options = null) {
 			if($this->opb_is_login_redirect) { return; }

			
			$va_lightbox_displayname = caGetLightboxDisplayName();
			$this->view->setVar('lightbox_displayname', $va_lightbox_displayname["singular"]);
			$this->view->setVar('lightbox_displayname_plural', $va_lightbox_displayname["plural"]);

            # Get sets for display
            $t_sets = new ca_sets();
 			$va_read_sets = $t_sets->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "checkAccess" => $this->opa_access_values, "access" => (!is_null($vn_access = $this->request->config->get('lightbox_default_access'))) ? $vn_access : 1, "parents_only" => true));
 			$va_write_sets = $t_sets->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "checkAccess" => $this->opa_access_values, "parents_only" => true));

 			# Remove write sets from the read array
 			$va_read_sets = array_diff_key($va_read_sets, $va_write_sets);

            $this->view->setVar("read_sets", $va_read_sets);
 			$this->view->setVar("write_sets", $va_write_sets);

            $va_set_ids = array_merge(array_keys($va_read_sets), array_keys($va_write_sets));
 			$this->view->setVar("set_ids", $va_set_ids);

            # Get set change log
            $va_set_change_log = $t_sets->getSetChangeLog($va_set_ids);
 			if(is_array($va_set_change_log) && sizeof($va_set_change_log)){
 				$va_set_change_log = array_slice($va_set_change_log, 0, 50);
 			}
 			$this->view->setVar("activity", $va_set_change_log);

            MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").ucfirst($this->ops_lightbox_display_name));
 			
 			$this->render(caGetOption("view", $pa_options, "Lightbox/set_list_html.php"));
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function setDetail($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }
            $this->request->setParameter('callback', null);
            unset($_REQUEST['callback']);

 			AssetLoadManager::register("mediaViewer");
 		
			$o_context = new ResultContext($this->request, 'ca_objects', 'sets', 'lightbox');
 			$o_context->setAsLastFind();

            $this->view->setVar('browse', $o_browse = caGetBrowseInstance("ca_objects"));
			$this->view->setVar("browse_type", "caLightbox");	// this is only used when loading hierarchy facets and is a way to get around needing a browse type to pull the table in FindController		

 			$this->view->setVar('view', $ps_view = caCheckLightboxView(array('request' => $this->request)));
			$this->view->setVar('views', $va_views = $this->opo_config->getAssoc("views"));
			$va_view_info = $va_views[$ps_view];

            //
            // User must at least have read access to the set
 			//
            if (!($t_set = $this->_getSet(__CA_SET_READ_ACCESS__))) { $this->Index(); return; }
 			
 			$vn_set_id = $t_set->get("set_id");
 			$this->view->setVar("set", $t_set);

 			$qr_comments = $t_set->getComments(null, null, array('returnAs' => 'searchResult'));

 			$this->view->setVar("comments", $qr_comments);
            $this->view->setVar("commentCountDisplay", $qr_comments ? (($vn_comment_count = $qr_comments->numHits())." ".(($vn_comment_count == 1) ? _t("comment") : _t("comments"))) : 0);

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
			
			//
			// Return filtering facets
			//
			if ($this->request->getParameter('getFacet', pInteger) && $vs_facet = $this->request->getParameter('facet', pString)) {
				$this->view->setVar('facet_name', $vs_facet);
				$this->view->setVar('key', $o_browse->getBrowseID());
				$va_facet_info = $o_browse->getInfoForFacet($vs_facet);
				$this->view->setVar('facet_info', $va_facet_info);
				
				// pull in different views based on format for facet - alphabetical, list, hierarchy
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
				// set the default sortDirection if available
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
			
			$va_browse_options = array('checkAccess' => $this->opa_access_values, 'no_cache' => true);

            $o_browse->execute(array_merge($va_browse_options, array('strictPhraseSearching' => true, 'checkAccess' => $this->opa_access_values, 'request' => $this->request)));

		if ($ps_view !== 'timelineData') {
			//
			// Facets
			//
			if ($vs_facet_group = $this->opo_config->get("setFacetGroup")) {
				$o_browse->setFacetGroup($vs_facet_group);
			}
			$va_available_facet_list = $this->opo_config->get("availableFacets");
			$va_facets = $o_browse->getInfoForAvailableFacets(['checkAccess' => $this->opa_access_values, 'request' => $this->request,]);
			if(is_array($va_available_facet_list) && sizeof($va_available_facet_list)) {
				foreach($va_facets as $vs_facet_name => $va_facet_info) {
					if (!in_array($vs_facet_name, $va_available_facet_list)) {
						unset($va_facets[$vs_facet_name]);
					}
				}
			} 
		
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				$va_facets[$vs_facet_name]['content'] = $o_browse->getFacetContent($vs_facet_name, ['checkAccess' => $this->opa_access_values, 'request' => $this->request]);
			}
		
			$this->view->setVar('facets', $va_facets);
		
			$this->view->setVar('key', $vs_key = $o_browse->getBrowseID());
			Session::setVar('lightbox_last_browse_id', $vs_key);
			
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
		}	
			// 
			// Results
			//
			$vs_combined_sort = $va_sort_by[$ps_sort];
			
			if($ps_secondary_sort){
				$vs_combined_sort .= ";".$va_secondary_sort_by[$ps_secondary_sort];
			}
			
			$qr_res = $o_browse->getResults(array('sort' => $vs_combined_sort, 'sort_direction' => $ps_sort_direction));
			$this->view->setVar('result', $qr_res);

            if (($va_ids = $qr_res->getAllFieldValues('ca_objects.object_id')) && sizeof($va_ids)) {
                // convert object result to set item result set
            	$this->view->setVar('setItemInfo', $t_set->rowIDsToItemIDs($va_ids, array('returnAsInfoArray' => true)));
            }
			
			if (!($pn_hits_per_block = $this->request->getParameter("n", pString))) {
 				if (!($pn_hits_per_block = $o_context->getItemsPerPage())) {
 					$pn_hits_per_block = ($this->opo_config->get("defaultHitsPerBlock")) ? $this->opo_config->get("defaultHitsPerBlock") : 36;
 				}
 			}
 			$o_context->getItemsPerPage($pn_hits_per_block);
			$this->view->setVar('hits_per_block', $pn_hits_per_block);
			$this->view->setVar('start', $vn_start = $this->request->getParameter('s', pInteger));
			
			$o_context->setParameter('key', $vs_key);
			
			if (($vn_key_start = (int)$vn_start - 1000) < 0) { $vn_key_start = 0; }
			$qr_res->seek($vn_key_start);
			$o_context->setResultList($qr_res->getPrimaryKeyValues(1000));
			//if ($o_block_result_context) { $o_block_result_context->setResultList($qr_res->getPrimaryKeyValues(1000)); $o_block_result_context->saveContext();}
			$qr_res->seek($vn_start);
			
			$o_context->saveContext();
			
			// map
			if ($ps_view === 'map') {
				$va_opts = array('renderLabelAsLink' => false, 'request' => $this->request, 'color' => '#cc0000');
		
				$va_opts['ajaxContentUrl'] = caNavUrl($this->request, '*', '*', 'AjaxGetMapItem', array('view' => $ps_view));
			
				$o_map = new GeographicMap(caGetOption("width", $va_view_info, "100%"), caGetOption("height", $va_view_info, "600px"));
				$o_map->mapFrom($qr_res, $va_view_info['data'], $va_opts);
				$this->view->setVar('map', $o_map->render('HTML', array()));
			}
 			
            MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").ucfirst($this->ops_lightbox_display_name).$this->request->config->get("page_title_delimiter").$t_set->getLabelForDisplay());
 			switch($ps_view) {
 				case 'xlsx':
 				case 'pptx':
 				case 'pdf':
 					$this->_genExport($qr_res, $this->request->getParameter("export_format", pString), caGenerateDownloadFileName(caGetOption('pdfExportTitle', $va_browse_info, $vs_label = $t_set->get('ca_sets.preferred_labels.name')), ['t_subject' => $t_set]), $vs_label);
 					break;
 				case 'timelineData':
 					$this->view->setVar('view', 'timeline');
 					$this->render("Lightbox/set_detail_timelineData_json.php");
 					break;
 				default:
 					$this->render(caGetOption("view", $pa_options, "Lightbox/set_detail_html.php"));
 					break;
 			}
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function setForm($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }

			// set_id is passed, so we're editing a set
			if($this->request->getParameter('set_id', pInteger)){
				if($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)){
					// pass name and description to populate form
					$this->view->setVar("name", $t_set->getLabelForDisplay());
					$this->view->setVar("description", $t_set->get($this->ops_description_attribute));
				}else{
					throw new ApplicationException(_t("You do not have access to this lightbox"));
				}
			}else{
				$t_set = new ca_sets();
			}
 			$this->view->setVar("set", $t_set);
 			$this->render(caGetOption("view", $pa_options, "Lightbox/form_set_info_html.php"));
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function ajaxSaveSetInfo($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }
            if (!$this->request->isAjax()) { $this->response->setRedirect(caNavUrl($this->request, '', 'Lightbox', 'Index')); return; }
 			
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			
 			$vs_display_name = caGetOption("display_name", $pa_options, $this->ops_lightbox_display_name);
 			// set_id is passed through form, otherwise we're saving a new set
 			$t_set = ($this->request->getParameter('set_id', pInteger)) ? $this->_getSet(__CA_SET_EDIT_ACCESS__) : new ca_sets();
 			
 			if(!$t_set->get("set_id") && ($pn_parent_id = $this->request->getParameter('parent_id', pInteger))){
 				# --- if making a new reponse set, check there isn't already one for the user
 				$va_user_response_ids = $t_set->getSetResponseIds($this->request->getUserID(), $pn_parent_id);
 				if(is_array($va_user_response_ids) && sizeof($va_user_response_ids)){
 					$va_errors[] = _t('Only one reponse allowed');
 				}
 			}
 			// check for errors
 			// set name - required
 			
 			if(!($ps_name = $this->purifier->purify($this->request->getParameter('name', pString)))){
 				$va_errors[] = _t("Please enter the name of your %1", $vs_display_name);
 			}
 			$this->view->setVar("name", $ps_name);
 			
 			// set description - optional
 			$ps_description =  $this->purifier->purify($this->request->getParameter($this->ops_description_attribute, pString));
 			$this->view->setVar("description", $ps_description);

 			$t_list = new ca_lists();
 			$vn_set_type_user = $t_list->getItemIDFromList('set_types', $this->request->config->get('user_set_type'));
 			
 			$t_object = new ca_objects();
 			$vn_object_table_num = $t_object->tableNum();
 			
 			$vb_is_insert = false;
 			if(sizeof($va_errors) == 0){
				$t_set->setMode(ACCESS_WRITE);
				if(strlen($vn_access = $this->request->getParameter('access', pInteger))) {
					$t_set->set('access', $vn_access);
				} else {
					$t_set->set('access', (!is_null($vn_access = $this->request->config->get('lightbox_default_access'))) ? $vn_access : 1);
				}
				if($t_set->get("set_id")){
					// edit/add description
					$t_set->replaceAttribute(array($this->ops_description_attribute => $ps_description, 'locale_id' => $g_ui_locale_id), $this->ops_description_attribute);
					$t_set->update();
				}else{
					$t_set->set('table_num', $vn_object_table_num);
					$t_set->set('type_id', $vn_set_type_user);
					$t_set->set('user_id', $this->request->getUserID());
					$t_set->set('set_code', $this->request->getUserID().'_'.time());
					$t_set->set('parent_id', $this->request->getParameter('parent_id', pInteger));
					// create new attribute
					$t_set->addAttribute(array($this->ops_description_attribute => $ps_description, 'locale_id' => $g_ui_locale_id), $this->ops_description_attribute);
					$t_set->insert();
					$vb_is_insert = true;
				}
				if($t_set->numErrors()) {
					$va_errors[] = join("; ", $t_set->getErrors());
					$this->view->setVar('errors', $va_errors);
					$this->setForm();
				}else{
					// save name
					if (sizeof($va_labels = caExtractValuesByUserLocale($t_set->getLabels(array($g_ui_locale_id), __CA_LABEL_TYPE_PREFERRED__)))) {
						// edit label	
						foreach($va_labels as $vn_set_id => $va_label) {
							$t_set->editLabel($va_label[0]['label_id'], array('name' => $ps_name), $g_ui_locale_id);
						}
					} else {
						// add new label
						$t_set->addLabel(array('name' => $ps_name), $g_ui_locale_id, null, true);
					}
					
					// select the current set
					$this->request->user->setVar('current_set_id', $t_set->get("set_id"));
					
					$this->view->setVar("message", _t('Saved %1', $vs_display_name));
					$vs_set_list_item_function = (string) caGetOption("set_list_item_function", $pa_options, "caLightboxSetListItem");
					$this->view->setVar('block', $vs_set_list_item_function($this->request, $t_set, $this->opa_access_values, array('write_access' => $vb_is_insert ? true : $this->view->getVar('write_access'))));
				}
			}else{
				$this->view->setVar('errors', $va_errors);
			} 	
			$this->view->setVar('set_id', $t_set->get("set_id"));	
			$this->view->setVar('is_insert', $vb_is_insert);
					
			$this->render("Lightbox/ajax_save_set_info_json.php");
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function setAccess($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }
            if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) {
            	throw new ApplicationException(_t("You do not have access to this lightbox"));
            }
 			// list of groups/users with access to set
 			$this->view->setVar("users", $t_set->getSetUsers());
 			$this->view->setVar("user_groups", $t_set->getSetGroups());
 			
 			$this->render(caGetOption("view", $pa_options, "Lightbox/set_access_html.php"));
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function saveGroupAccess() {
            if($this->opb_is_login_redirect) { return; }
            if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) {
            	throw new ApplicationException(_t("You do not have access to this lightbox"));
            }
 			// list of groups/users with access to set
 			$this->view->setVar("users", $t_set->getSetUsers());
 			$this->view->setVar("user_groups", $t_set->getSetGroups());
 			
 			$this->render("Lightbox/set_access_html.php");
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function removeGroupAccess() {
            if($this->opb_is_login_redirect) { return; }
            if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) {
            	throw new ApplicationException(_t("You do not have access to this lightbox"));
            }
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
				$this->view->setVar('errors', _t("invalid group/set id"));
			}
			$this->setAccess();
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function removeUserAccess() {
            if($this->opb_is_login_redirect) { return; }
            if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) {
            	throw new ApplicationException(_t("You do not have access to this lightbox"));
            }
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
				$this->view->setVar('errors', _t("invalid user/set id"));
			}
 			$this->setAccess();
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function editGroupAccess() {
            if($this->opb_is_login_redirect) { return; }
            if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) {
            	throw new ApplicationException(_t("You do not have access to this lightbox"));
            }
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
				$this->view->setVar('errors', _t("invalid group/set id or access"));
			}
			$this->setAccess();
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function editUserAccess() {
            if($this->opb_is_login_redirect) { return; }
            if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) {
            	throw new ApplicationException(_t("You do not have access to this lightbox"));
            }
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
				$this->view->setVar('errors', _t("invalid user/set id or access"));
			}
			$this->setAccess();
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function shareSetForm($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }
			if(!$t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)){
 				throw new ApplicationException(_t("You do not have access to this lightbox"));
 			}
			$vs_display_name = caGetOption("display_name", $pa_options, $this->ops_lightbox_display_name);
			$this->view->setVar("display_name", $vs_display_name);
 			$this->render("Lightbox/form_share_set_html.php");
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function saveShareSet($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }

 			if(!$t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)){
 				throw new ApplicationException(_t("You do not have access to this lightbox"));
 			}
 			$vs_display_name = caGetOption("display_name", $pa_options, $this->ops_lightbox_display_name);
 			$vs_display_name_plural = caGetOption("display_name_plural", $pa_options, $this->ops_lightbox_display_name_plural);
 			$this->view->setVar("display_name", $vs_display_name);
 			$this->view->setVar("display_name_plural", $vs_display_name_plural);
 			$ps_user = $this->purifier->purify($this->request->getParameter('user', pString));
 			// ps_user can be list of emails separated by comma
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
						$this->view->setVar("message", _t('Group already has access to the %1', $vs_display_name));
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
								// send email to each group user
								// send email confirmation
								$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
								$o_view->setVar("set", $t_set->getLabelForDisplay());
								$o_view->setVar("from_name", trim($this->request->user->get("fname")." ".$this->request->user->get("lname")));
								$o_view->setVar("display_name", $vs_display_name);
 								$o_view->setVar("display_name_plural", $vs_display_name_plural);
							
								# -- generate email subject line from template
								$vs_subject_line = $o_view->render("mailTemplates/share_set_notification_subject.tpl");
								
								# -- generate mail text from template - get both the text and the html versions
								$vs_mail_message_text = $o_view->render("mailTemplates/share_set_notification.tpl");
								$vs_mail_message_html = $o_view->render("mailTemplates/share_set_notification_html.tpl");
							
								foreach($va_group_users as $va_user_info){
									// don't send notification to self
									if($this->request->user->get("user_id") != $va_user_info["user_id"]){
										caSendmail($va_user_info["email"], array($this->request->user->get("email") => trim($this->request->user->get("fname")." ".$this->request->user->get("lname"))), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
									}
								}
							}							
							
							
							$this->view->setVar("message", _t('Shared %1 with group', $vs_display_name));
							$this->render("Form/reload_html.php");
						}
					}
				}else{
					$va_error_emails = array();
					$va_success_emails = array();
					$va_error_emails_has_access = array();
					$t_user = new ca_users();
					foreach($va_users as $vs_user){
						// lookup the user/users
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
									$va_errors["general"] = _t("There were errors while sharing this %1 with %2", $vs_display_name, $vs_user).join("; ", $t_sets_x_users->getErrors());
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
							$va_user_errors[] = _t("The following email(s) you entered already have access to this %1: ", $vs_display_name).implode(", ", $va_error_emails_has_access);
						}
						if(sizeof($va_success_emails)){
							$this->view->setVar('message', _t('Shared %1 with: ', $vs_display_name).implode(", ", $va_success_emails));
						}
						$va_errors["user"] = implode("<br/>", $va_user_errors);
						$this->view->setVar('errors', $va_errors);
						$this->shareSetForm();
					}else{
						$this->view->setVar("message", _t('Shared %1 with: ', $vs_display_name).implode(", ", $va_success_emails));
						$this->render("Form/reload_html.php");
					}
					if(is_array($va_success_emails_info) && sizeof($va_success_emails_info)){
						// send email to user
						// send email confirmation
						$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
						$o_view->setVar("set", $t_set->getLabelForDisplay());
						$o_view->setVar("from_name", trim($this->request->user->get("fname")." ".$this->request->user->get("lname")));
						$o_view->setVar("display_name", $vs_display_name);
 						$o_view->setVar("display_name_plural", $vs_display_name_plural);
							
					
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
        /**
         *
         */
 		function userGroupList() {
            if($this->opb_is_login_redirect) { return; }

 			$this->render("Lightbox/user_group_list_html.php");
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function userGroupForm($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }

 			$t_user_group = new ca_user_groups();
 			$this->view->setVar("user_group",$t_user_group);
			$this->view->setVar("user_group_heading", caGetOption("user_group_heading", $pa_options, _t("User Group")));
 			$this->render("Lightbox/form_user_group_html.php");
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function saveUserGroup($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }

 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			
 			$vs_user_group_terminology = caGetOption("user_group_terminology", $pa_options, _t("user group"));
 			
 			$t_user_group = new ca_user_groups();
 			if($pn_group_id = $this->request->getParameter('group_id', pInteger)){
 				$t_user_group->load($pn_group_id);
 				if($t_user_group->get("user_id") != $this->request->getUserId()){
 					throw new ApplicationException(_t("You do not have access to this user group"));
 				}
 			}
 			
 			// check for errors
 			// group name - required
 			$ps_name = $this->purifier->purify($this->request->getParameter('name', pString));
 			if(!$ps_name){
 				$va_errors["name"] = _t("Please enter the name of your %1", $vs_user_group_terminology);
 			}else{
 				$this->view->setVar("name", $ps_name);
 			}
 			// user group description - optional
 			$ps_description =  $this->purifier->purify($this->request->getParameter('description', pString));
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
					// add current user to group
					$this->view->setVar("message", _t('Saved %1.', $vs_user_group_terminology));
 					$this->render("Form/reload_html.php");
				}
			}else{
				$this->view->setVar('errors', $va_errors);
				$this->userGroupForm();
			} 			
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function ajaxListComments() {
            if($this->opb_is_login_redirect) { return; }

 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) {
                throw new ApplicationException(_t("You do not have access to this lightbox"));
            }

 			$ps_tablename = $this->request->getParameter('type', pString);

 			// check this is a valid table to have comments in the lightbox
 			if(!in_array($ps_tablename, array("ca_sets", "ca_set_items"))){
                throw new ApplicationException(_t("Invalid type"));
            }

 			// load table
 			if (!($t_item = Datamodel::getInstance($ps_tablename))) {
                throw new ApplicationException(_t("Invalid type"));
            }
 			$pn_item_id = $this->request->getParameter($t_item->primaryKey(), pInteger);
 			if (!$t_item->load($pn_item_id)) {
                throw new ApplicationException(_t("Item does not exist"));
            }
 			
 			$this->view->setVar("set", $t_set);
 			$this->view->setVar("tablename", $ps_tablename);
 			$this->view->setVar("item_id", $pn_item_id);
 			$this->view->setVar("comments", $qr_comments = $t_item->getComments(null, null, array('returnAs' => 'searchResult')));
			
			$this->render("Lightbox/ajax_comments.php");
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function ajaxAddComment() {
            if($this->opb_is_login_redirect) { return; }

 			// when close is set to true, will make the form view disappear after saving form

            $va_errors = array();
            $vn_count = null;
            $vs_message = null;

 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) {
                throw new ApplicationException(_t("You do not have access to this lightbox"));
            } else {
 			    $ps_comment_type = $this->request->getParameter('type', pString);

 			    // check this is a valid table to have comments in the lightbox
 			    if(!in_array($ps_comment_type, array("ca_sets", "ca_set_items"))){
                    $va_errors[] = _t("Invalid type: %1", $ps_comment_type);
                } else {
                    // load table
                    $t_item = Datamodel::getInstance($ps_comment_type, true);
                    $pn_id = $this->request->getParameter('id', pInteger);
                    if (!$t_item->load($pn_id)) {
                        $va_errors[] = _t("Invalid id: %1", $pn_id);
                    } elseif(!($ps_comment = $this->purifier->purify($this->request->getParameter('comment', pString)))) {
                        $va_errors[] = _t("Please enter a comment");
                    } elseif($t_comment = $t_item->addComment($ps_comment, null, $this->request->getUserID(), null, null, null, 1, $this->request->getUserID(), array("purify" => true))){
                        // pass user's id as moderator - all set comments should be made public, it's a private space and comments should not need to be moderated
                        $vs_message = _t("Saved comment");

                        $this->view->setVar('comment', $ps_comment);
                        $this->view->setVar('comment_id', $t_comment->getPrimaryKey());
                        $this->view->setVar('author', $t_comment->get('ca_users.fname').' '.$t_comment->get('ca_users.lname').' '.$t_comment->get('ca_item_comments.created_on'));

                        $this->view->setVar('is_writeable', $this->view->getVar('write_access'));
                        $this->view->setVar('is_author', true);
                        $vs_rendered_comment = $this->render("Lightbox/set_comment_html.php", true);
                        $vn_count = (int)$t_comment->getItem()->getNumComments();

                    } else {
                        $va_errors[] = _t("There were errors adding your comment: ".join("; ", $t_item->getErrors()));
                    }
                }
            }

 			$this->view->setVar("type", $ps_comment_type);
 			$this->view->setVar("set_id", $pn_id);
 			$this->view->setVar("message", $vs_message);
            $this->view->setVar("comment", $vs_rendered_comment);
            $this->view->setVar("comment_count", $vn_count);
            $this->view->setVar("comment_count_display",  $vn_count." ".(($vn_count == 1) ? _t("comment") : _t("comments")));
			$this->view->setVar("errors", $va_errors);
			$this->render("Lightbox/ajax_add_comment_json.php");
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function ajaxDeleteComment() {
            if($this->opb_is_login_redirect) { return; }

            $va_errors = array();
            $vs_message = null;
            $vn_count = null;
            $pn_comment_id = null;

 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) {
                $va_errors[] = _t('You do not have access to this lightbox');
            } else {
                $t_comment = new ca_item_comments($pn_comment_id = $this->request->getParameter("comment_id", pInteger));

                if ($t_comment->get("comment_id")) {
                    $vn_count = $t_comment->getItem()->getNumComments();

                    // check if user is owner of comment or has edit access to set comment was made on
                    if (($this->request->getUserID() != $t_comment->get("user_id")) && !$t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
                        $va_errors[] = _t('You do not have access to this comment');
                    } else {
                        $t_comment->setMode(ACCESS_WRITE);
                        $t_comment->delete(true);
                        if ($t_comment->numErrors()) {
                            $va_errors = $t_comment->getErrors();
				    } else {
                            $vn_count--;
                            $vs_message = _t("Removed comment");
                        }
                    }
                } else {
                    $va_errors[] = _t("Invalid comment_id");
                }

            }
            $this->view->setVar("comment_id", $pn_comment_id);
            $this->view->setVar("comment_count", $vn_count);
            $this->view->setVar("comment_count_display",  $vn_count." ".(($vn_count == 1) ? _t("comment") : _t("comments")));
            $this->view->setVar("message", $vs_message);
            $this->view->setVar("errors", $va_errors);
            $this->render("Lightbox/ajax_delete_comment_json.php");
 		}
 		# -------------------------------------------------------
        /**
         *
         */
 		public function deleteLightbox() {
            if($this->opb_is_login_redirect) { return; }

			$va_errors = array();
			$vs_message = $vn_set_id = $vs_set_name = null;
			
 			if ($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)) { 
 				$vs_set_name = $t_set->getLabelForDisplay();
 				$t_set->setMode(ACCESS_WRITE);
 				$t_set->delete();
 				
 				if($t_set->numErrors()) {
 					$va_errors[] = _t("<em>%1</em> could not be deleted: %2", $vs_set_name, join("; ", $t_set->getErrors()));
 				} else {
 					$vs_message = _t("<em>%1</em> was deleted", $vs_set_name);
 				}
 				$vn_set_id = $t_set->get('set_id');
 			} else {
 				throw new ApplicationException(_t("You do not have access to this lightbox"));
 			}
 			
 			$this->view->setVar('message', $vs_message);
 			$this->view->setVar('set_id', $vn_set_id);
 			$this->view->setVar('errors', $va_errors);
 			$this->view->setVar('name', $vs_set_name);
 			
 			$this->render("Lightbox/ajax_delete_set_json.php");
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		public function ajaxReorderItems() {
            if($this->opb_is_login_redirect) { return; }

            if($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)){
				
				$this->view->setVar("set_id", $t_set->get("set_id"));
				
				$va_row_ids = array();
				$va_row_ids_raw = explode('&', $this->request->getParameter('row_ids', pString));
				foreach($va_row_ids_raw as $vn_row_id_raw){
					$va_row_ids[] = str_replace('row[]=', '', $vn_row_id_raw);
				}
				$va_errors = $t_set->reorderItems($va_row_ids, ['user_id' => $this->request->getUserID()]);
			}else{
				throw new ApplicationException(_t("You do not have access to this lightbox"));
			}
			$this->view->setVar('errors', $va_errors);
			$this->render('Lightbox/ajax_reorder_items_json.php');
 		}
 		# -------------------------------------------------------
        /**
         *
         */
 		public function ajaxDeleteItem() {
            if($this->opb_is_login_redirect) { return; }

            if($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)){
				
				$pn_item_id = $this->request->getParameter('item_id', pInteger);
				if ($t_set->removeItemByItemID($pn_item_id, $this->request->getUserID())) {
					$va_errors = array();
				} else {
					$va_errors[] = _t('Could not remove item from %1', $this->ops_lightbox_display_name);
				}
				$this->view->setVar('set_id', $t_set->getPrimaryKey());
				$this->view->setVar('item_id', $pn_item_id);
                $this->view->setVar('count', $t_set->getItemCount(array('user_id' => $this->request->getUserID(), 'checkAccess' => $this->opa_access_values)));
			} else {
				throw new ApplicationException(_t("You do not have access to this lightbox"));	
			}
 			
 			$this->view->setVar('errors', $va_errors);
 			$this->render('Lightbox/ajax_delete_item_json.php');
 		}
 		# -------------------------------------------------------
        /**
         *
         */
 		public function ajaxAddItem($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }

 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			
 			$vs_display_name = caGetOption("display_name", $pa_options, $this->ops_lightbox_display_name);
 			$this->view->setVar("display_name", $vs_display_name);
 			$vs_display_name_plural = caGetOption("display_name_plural", $pa_options, $this->ops_lightbox_display_name_plural);
            $this->view->setVar("display_name_plural", $vs_display_name_plural);
            
 			// set_id is passed through form, otherwise we're saving a new set, and adding the item to it
 			if($this->request->getParameter('set_id', pInteger)){
 				$t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__);
 				if(!$t_set && $t_set = $this->_getSet(__CA_SET_READ_ACCESS__)){
 					$va_errors["general"] = _t("You can not add items to this %1.  You have read only access.", $vs_display_name);
 					$this->view->setVar('errors', $va_errors);
 					$this->addItemForm();
 					return;
 				}
 			}else{
 				$t_set = new ca_sets();
 				$t_set->purify(true);
 				
				// set name - if not sent, make a decent default
				$ps_name = $this->purifier->purify($this->request->getParameter('name', pString));
				if(!$ps_name){
					$ps_name = _t("Your %1", $vs_display_name);
				}
				// set description - optional
				$ps_description =  $this->purifier->purify($this->request->getParameter($this->ops_description_attribute, pString));
	
				$t_list = new ca_lists();
				$vn_set_type_user = $t_list->getItemIDFromList('set_types', $this->request->config->get('user_set_type'));
				
				$t_object = new ca_objects();
				$t_object->purify(true);
				
				$vn_object_table_num = $t_object->tableNum();
				$t_set->setMode(ACCESS_WRITE);
				$t_set->set('access', (!is_null($vn_access = $this->request->config->get('lightbox_default_access'))) ? $vn_access : 1);
				$t_set->set('table_num', $vn_object_table_num);
				$t_set->set('type_id', $vn_set_type_user);
				$t_set->set('user_id', $this->request->getUserID());
				$t_set->set('set_code', $this->request->getUserID().'_'.time());
				// create new attribute
				if($ps_description){
					$t_set->addAttribute(array($this->ops_description_attribute => $ps_description, 'locale_id' => $g_ui_locale_id), $this->ops_description_attribute);
				}
				$t_set->insert();
				if($t_set->numErrors()) {
					$va_errors["general"] = join("; ", $t_set->getErrors());
					$this->view->setVar('errors', $va_errors);
					$this->addItemForm();
					return;
				}else{
					// save name - add new label
					$t_set->addLabel(array('name' => $ps_name), $g_ui_locale_id, null, true);
					// select the current set
					$this->request->user->setVar('current_set_id', $t_set->get("set_id"));

				}			
			}
			if($t_set){
				$pn_item_id = null;
				$pn_object_id = $this->request->getParameter('id', pInteger);
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
							$va_errors["message"] = _t('Could not add item to %1', $vs_display_name);
							$this->render("Form/reload_html.php");
						}
					}else{
						$this->view->setVar('message', _t("Item already in %1.", $vs_display_name));
						$this->render("Form/reload_html.php");
					}				
				}else{
					if(($pb_saveLastResults = $this->request->getParameter('saveLastResults', pString)) || ($ps_object_ids = $this->request->getParameter('object_ids', pString)) || ($pn_object_id = $this->request->getParameter('object_id', pInteger))){
						if($pb_saveLastResults){
							// get object ids from last result
							$o_context = ResultContext::getResultContextForLastFind($this->request, "ca_objects");
							$va_object_ids = $o_context->getResultList();
						} elseif($pn_object_id) {
							$va_object_ids = [$pn_object_id];
							$this->view->setVar("row_id", $pn_object_id);
						}else{
							$va_object_ids = explode(";", $ps_object_ids);
						}
						if(is_array($va_object_ids) && sizeof($va_object_ids)){
							// check for those already in set
							$va_object_ids_in_set = $t_set->areInSet("ca_objects", $va_object_ids, $t_set->get("set_id"));
							$va_object_ids = array_diff($va_object_ids, $va_object_ids_in_set);
							// insert items
							$t_set->addItems($va_object_ids);
							$this->view->setVar('message', _t("Successfully added results to %1.", $vs_display_name));
							$this->render("Form/reload_html.php");
							
						}else{
							$this->view->setVar('message', _t("No objects in search result to add to %1", $vs_display_name));
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
        /**
         *
         */
 		public function addItemForm($pa_options = array()){
            if($this->opb_is_login_redirect) { return; }

            $this->view->setVar("display_name", caGetOption("display_name", $pa_options, $this->ops_lightbox_display_name));
            $this->view->setVar("display_name_plural", caGetOption("display_name_plural", $pa_options, $this->ops_lightbox_display_name_plural));
            $this->view->setvar("set", new ca_Sets());
 			$this->view->setvar("object_id", $this->request->getParameter('object_id', pInteger));
 			$this->view->setvar("object_ids", $this->request->getParameter('object_ids', pString));
 			$this->view->setvar("saveLastResults", $this->request->getParameter('saveLastResults', pInteger));
 			if(($pn_object_id = $this->request->getParameter('object_id', pInteger)) || ($pn_save_last_results = $this->request->getParameter('saveLastResults', pInteger)) || ($pa_object_ids = sizeof(explode(";", $this->request->getParameter('object_ids', pString))))){
 				$this->render("Lightbox/form_add_set_item_html.php");
 			}else{
 				$this->view->setVar('message', _t("Object ID is not defined"));
				$this->render("Form/reload_html.php");
 			}
 		}
 		# -------------------------------------------------------
        /**
         * Return text for map item info bubble
         */
 		public function ajaxGetMapItem() {
            if($this->opb_is_login_redirect) { return; }
            
            $pa_ids = explode(";", $this->request->getParameter('id', pString)); 
            $ps_view = $this->request->getParameter('view', pString);
 			
 			$this->view->setVar('view', $ps_view = caCheckLightboxView(array('request' => $this->request, 'default' => 'map')));
			$this->view->setVar('views', $va_views = $this->opo_config->getAssoc("views"));
			$va_view_info = $va_views[$ps_view];
            
			$vs_content_template = $va_view_info['display']['description_template'];
			
 			$this->view->setVar('contentTemplate', caProcessTemplateForIDs($vs_content_template, 'ca_objects', $pa_ids, array('checkAccess' => $this->opa_access_values)));
			
         	$this->render("Lightbox/ajax_map_item_html.php");   
        }
		# ------------------------------------------------------
		/**
		 *
		 */
		public function present($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }
			if(!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)){
				$this->Index();
				return;
			}
			$this->view->setVar("controller", caGetOption("controller", $pa_options, "Lightbox"));
            $this->view->setVar("display_name", caGetOption("display_name", $pa_options, $this->ops_lightbox_display_name));
            $this->view->setVar("display_name_plural", caGetOption("display_name_plural", $pa_options, $this->ops_lightbox_display_name_plural));
			
			AssetLoadManager::register("reveal.js");
			$o_app = AppController::getInstance();
			$o_app->removeAllPlugins();
			$this->view->setVar("set", $t_set);

			$this->render("Lightbox/present_html.php");
		}
		# -------------------------------------------------------
		/**
		 * Download (accessible) media for all records in this set
		 */
		public function getLightboxMedia() {
			set_time_limit(600); // allow a lot of time for this because the sets can be potentially large
			$t_set = new ca_sets($this->request->getParameter('set_id', pInteger));
			if (!$t_set->getPrimaryKey()) {
				$this->notification->addNotification(_t('No set defined'), __NOTIFICATION_TYPE_ERROR__);
				$this->opo_response->setRedirect(caNavUrl($this->request, '', 'Lightbox', 'Index'));
				return false;
			}

			$va_record_ids = array_keys($t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values, 'limit' => 100000)));
			if(!is_array($va_record_ids) || !sizeof($va_record_ids)) {
				$this->notification->addNotification(_t('No media is available for download'), __NOTIFICATION_TYPE_ERROR__);
				$this->opo_response->setRedirect(caNavUrl($this->request, '', 'Lightbox', 'Index'));
				return false;
			}

			$vs_subject_table = Datamodel::getTableName($t_set->get('table_num'));
			$t_instance = Datamodel::getInstance($vs_subject_table);

			$qr_res = $vs_subject_table::createResultSet($va_record_ids);
			$qr_res->filterNonPrimaryRepresentations(false);

			$va_paths = array();
			$t_download_log = new Downloadlog();
			while($qr_res->nextHit()) {
				$t_instance->load($qr_res->get("ca_objects.object_id"));
				if (!$t_instance->getPrimaryKey()) { continue; }
				
				$va_reps = $t_instance->getRepresentations(null, null, array("checkAccess" => $this->opa_access_values));
				$vs_idno = $t_instance->get('idno');
				
				$vn_c = 1;
				foreach($va_reps as $vn_representation_id => $va_rep) {
					
					$t_download_log->log(array(
						"user_id" => $this->request->getUserID() ? $this->request->getUserID() : null, 
						"ip_addr" => $_SERVER['REMOTE_ADDR'] ?  $_SERVER['REMOTE_ADDR'] : null, 
						"table_num" => $t_instance->TableNum(), 
						"row_id" => $t_instance->get("ca_objects.object_id"), 
						"representation_id" => $vn_representation_id, 
						"download_source" => "pawtucket"
					));
				
					
					# -- get version to download configured in media_display.conf
					$va_download_display_info = caGetMediaDisplayInfo('download', $va_rep["mimetype"]);
					$vs_download_version = caGetOption(['download_version', 'display_version'], $va_download_display_info);
	
					$t_rep = new ca_object_representations($va_rep['representation_id']);
					$va_rep_info = $t_rep->getMediaInfo("media", $vs_download_version);
					//$va_rep_info = $va_rep['info'][$vs_download_version];
					$vs_idno_proc = preg_replace('![^A-Za-z0-9_\-]+!', '_', $vs_idno);

					switch($this->request->user->getPreference('downloaded_file_naming')) {
						case 'idno':
							$vs_file_name = $vs_idno_proc.'_'.$vn_c.'.'.$va_rep_info['EXTENSION'];
							break;
						case 'idno_and_version':
							$vs_file_name = $vs_idno_proc.'_'.$vs_download_version.'_'.$vn_c.'.'.$va_rep_info['EXTENSION'];
							break;
						case 'idno_and_rep_id_and_version':
							$vs_file_name = $vs_idno_proc.'_representation_'.$vn_representation_id.'_'.$vs_download_version.'.'.$va_rep_info['EXTENSION'];
							break;
						case 'original_name':
						default:
							if ($va_rep['info']['original_filename']) {
								$va_tmp = explode('.', $va_rep['info']['original_filename']);
								if (sizeof($va_tmp) > 1) { 
									if (strlen($vs_ext = array_pop($va_tmp)) < 3) {
										$va_tmp[] = $vs_ext;
									}
								}
								$vs_file_name = join('_', $va_tmp); 					
							} else {
								$vs_file_name = $vs_idno_proc.'_representation_'.$vn_representation_id.'_'.$vs_download_version;
							}
							
							if (isset($va_file_names[$vs_file_name.'.'.$va_rep_info['EXTENSION']])) {
								$vs_file_name.= "_{$vn_c}";
							}
							$vs_file_name .= '.'.$va_rep_info['EXTENSION'];
							break;
					} 
					
					$va_file_names[$vs_file_name] = true;
				
					//
					// Perform metadata embedding
					if (!($vs_path = $this->ops_tmp_download_file_path = caEmbedMediaMetadataIntoFile($t_rep->getMediaPath('media', $vs_download_version), 'ca_objects', $t_instance->getPrimaryKey(), $t_instance->getTypeCode(), $t_rep->getPrimaryKey(), $t_rep->getTypeCode()))) {
						$vs_path = $t_rep->getMediaPath('media', $vs_download_version);
					}
					$va_file_paths[$vs_path] = $vs_file_name;
					
					$vn_c++;
				}
				$va_paths[$qr_res->get($t_instance->primaryKey())] = $va_file_paths;
			}	

			if (sizeof($va_paths) > 0){
				$o_zip = new ZipStream();

				foreach($va_paths as $vn_pk => $va_reps) {
					$vn_c = 1;
					foreach($va_reps as $vs_path => $vs_file_name) {
						if (!file_exists($vs_path)) { continue; }
						$o_zip->addFile($vs_path, $vs_file_name);

						$vn_c++;
					}
				}

				$o_view = new View($this->request, $this->request->getViewsDirectoryPath().'/bundles/');

				// send files
				$o_view->setVar('zip_stream', $o_zip);
				$o_view->setVar('archive_name', 'media_for_'.mb_substr(preg_replace('![^A-Za-z0-9]+!u', '_', ($vs_set_code = $t_set->get('set_code')) ? $vs_set_code : $t_set->getPrimaryKey()), 0, 20).'.zip');
				$this->response->addContent($o_view->render('download_file_binary.php'));
				return;
			} else {
				$this->notification->addNotification(_t('No files to download'), __NOTIFICATION_TYPE_ERROR__);
				$this->opo_response->setRedirect(caNavUrl($this->request, '', 'Lightbox', 'Index'));
				return;
			}

			return $this->Index();
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
 		private function _getSet($pn_access_level=__CA_SET_EDIT_ACCESS__) {
 			$t_set = new ca_sets();
 			$vn_set_id = $this->_getSetID();
 			if($vn_set_id){
				$t_set->load($vn_set_id);
				
				if ($t_set->getPrimaryKey() && ($t_set->haveAccessToSet($this->request->getUserID(), $pn_access_level))) {
					$this->request->user->setVar('current_set_id', $vn_set_id);
					// pass the access level the user has to the set - needed to display the proper controls in views
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
 				'controller' => 'Lightbox',
 				'action' => 'setDetail',
 				'params' => array(
 				
 				)
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
 	}