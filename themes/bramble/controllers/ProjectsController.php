<?php
/* ----------------------------------------------------------------------
 * themes/bramble/controllers/ProjectsController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
 	require_once(__CA_APP_DIR__."/helpers/themeHelpers.php");
 	require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
 	require_once(__CA_MODELS_DIR__."/ca_lists.php");
 	
 	class ProjectsController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private $ops_find_type = "occurrences";
 		private $opo_result_context = null;
 		private $opa_access_values = null;
 		private $opo_config = null;
 		private $opo_project_type_id = null;
 		private $ops_project_type = "project";
 		protected $purifier;
 		protected $opb_is_login_redirect = false;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			if (!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
                $this->opb_is_login_redirect = true;
                return;
            }
            
 			$this->opo_config = Configuration::load(__CA_THEME_DIR__.'/conf/projects.conf');
 			$this->view->setVar("projects_config", $this->opo_config);
 			$this->opa_access_values = caGetUserAccessValues($this->request);
 		 	$this->view->setVar("access_values", $this->opa_access_values);
 		 	
 			# --- get project occ type_id
 			$t_list = new ca_lists();
			$this->opo_project_type_id = $t_list->getItemIDFromList("occurrence_types", $this->ops_project_type, array("dontIncludeSubItems" => true));
			
			
			$this->purifier = caGetHTMLPurifier();
 			
 			caSetPageCSSClasses(array("projects"));
 		}
 		# -------------------------------------------------------
 		
 		/**
 		 *
 		 */ 
 		public function Index() {
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")." My Projects");
 			
 			$this->opo_result_context = new ResultContext($this->request, "ca_occurrences", "projects");
 			$this->opo_result_context->setAsLastFind();
 			$vs_sort = ($this->opo_config->get("listing_page_sort")) ? $this->opo_config->get("listing_page_sort") : "ca_occurrences.preferred_labels.name";
			$qr_projects = ca_occurrences::find(array('type_id' => $this->ops_project_type, "ca_user_id" => ["=", $this->request->user->get("user_id")]), array('boolean' => "AND", 'returnAs' => 'searchResult', 'sort' => $vs_sort, 'checkAccess' => $this->opa_access_values));
			$this->view->setVar("project_results", $qr_projects);
			caSetPageCSSClasses(array("projects"));
 			$this->render("Projects/index_html.php");
 		}
 		# ------------------------------------------------------
 		function projectForm($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }

			// project_id is passed, so we're editing a project
			if($this->request->getParameter('project_id', pInteger)){
				if($t_project = $this->_getProject()){
					// pass name and description to populate form
					$this->view->setVar("name", $t_project->getLabelForDisplay());
					$this->view->setVar("description", $t_project->get("description"));
				}else{
					throw new ApplicationException(_t("You do not have access to this project"));
				}
			}else{
				$t_project = new ca_occurrences();
			}
 			$this->view->setVar("project", $t_project);
 			$this->render(caGetOption("view", $pa_options, "Projects/form_project_info_html.php"));
 		}

 		# ------------------------------------------------------
 		function ajaxSaveProjectInfo($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }
            if (!$this->request->isAjax()) { $this->response->setRedirect(caNavUrl($this->request, '', 'Projects', 'Index')); return; }
 			
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			
 			$t_project = ($this->request->getParameter('project_id', pInteger)) ? $this->_getProject() : new ca_occurrences();
 			
 			// check for errors
 			// project name - required
 			
 			# --- preferred labal AKA name
 			if(!($ps_name = $this->purifier->purify($this->request->getParameter('name', pString)))){
 				$va_errors["name"] = _t("Please enter the name of your project");
 			}
 			$this->view->setVar("name", $ps_name);
 			
 			// description - optional
 			$ps_description =  $this->purifier->purify($this->request->getParameter("description", pString));
 			$this->view->setVar("description", $ps_description);
 			$vb_is_insert = false;
 			if(sizeof($va_errors) == 0){
				$t_project->setMode(ACCESS_WRITE);
				if($t_project->get("occurrence_id")){
					// edit/add description
					$t_project->replaceAttribute(array($this->ops_description_attribute => $ps_description, 'locale_id' => $g_ui_locale_id), $this->ops_description_attribute);
					$t_project->update();
				}else{
					$t_project->set('type_id', $this->opo_project_type_id);
					$t_project->set('access', 1);
					// attributes
					$t_project->addAttribute(array("description" => $ps_description, 'locale_id' => $g_ui_locale_id), "description");
					$t_project->addAttribute(array("ca_user_id" => $this->request->user->get("user_id"), 'locale_id' => $g_ui_locale_id), "ca_user_id");
					
					
					$t_project->insert();
					$vb_is_insert = true;
				}
				if($t_project->numErrors()) {
					$va_errors[] = join("; ", $t_project->getErrors());
					$this->view->setVar('errors', $va_errors);
					$this->projectForm();
				}else{
					// save name
					if (sizeof($va_labels = caExtractValuesByUserLocale($t_project->getLabels(array($g_ui_locale_id), __CA_LABEL_TYPE_PREFERRED__)))) {
						// edit label	
						foreach($va_labels as $vn_project_id => $va_label) {
							$t_project->editLabel($va_label[0]['label_id'], array('name' => $ps_name), $g_ui_locale_id);
						}
					} else {
						// add new label
						$t_project->addLabel(array('name' => $ps_name), $g_ui_locale_id, null, true);
					}
					
					// select the current project
					$this->request->user->setVar('current_project_id', $t_project->get("occurrence_id"));
					
					$this->view->setVar("message", _t('Saved project'));
					$this->render("Form/reload_html.php");
					#$vs_set_list_item_function = (string) caGetOption("set_list_item_function", $pa_options, "caLightboxSetListItem");
					#$this->view->setVar('block', $vs_set_list_item_function($this->request, $t_project, $this->opa_access_values, array('write_access' => $vb_is_insert ? true : $this->view->getVar('write_access'))));
				}
			}else{
				$this->view->setVar('errors', $va_errors);
				$this->projectForm();
			}
			
 		}
 		# -------------------------------------------------------
 		
 		/** 
 		 * Return project_id from request with fallback to user var, or if nothing there then get the users' first project
 		 */
 		private function _getProjectID() {
 			$vn_project_id = null;
 			if (!$vn_project_id = $this->request->getParameter('project_id', pInteger)) {			// try to get project_id from request
 				if(!$vn_project_id = $this->request->user->getVar('current_project_id')){		// get last used project_id
 					return null;
 				}
 			}
 			return $vn_project_id;
 		}
 		# -------------------------------------------------------
 		/**
 		 * Uses _getProjectID() to figure out the ID of the current project, then returns a ca_occurrences object for it
 		 * and also sets the 'current_project_id' user variable
 		 */
 		private function _getProject() {
 			$t_project = new ca_occurrences();
 			$vn_project_id = $this->_getProjectID();
 			if($vn_project_id){
				$t_project->load($vn_project_id);
				if ($t_project->getPrimaryKey() && ($t_project->get("ca_occurrences.ca_user_id") == $this->request->user->get("user_id")) && (!sizeof($this->opa_access_values) || in_array($t_project->get("access"), $this->opa_access_values))) {
					$this->request->user->setVar('current_project_id', $vn_project_id);
					return $t_project;
				}else{
					return null;
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
 				'controller' => 'Projects',
 				'action' => 'List',
 				'params' => array(
 					
 				)
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
	}
 ?>
