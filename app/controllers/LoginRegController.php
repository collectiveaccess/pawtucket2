<?php
/* ----------------------------------------------------------------------
 * controllers/LoginRegController.php
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
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_MODELS_DIR__."/ca_users.php");
 	require_once(__CA_MODELS_DIR__."/ca_user_groups.php");
 
 	class LoginRegController extends ActionController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 		}
 		# -------------------------------------------------------
 		function loginForm() {
			$this->render("LoginReg/form_login_html.php");
 		}
 		# ------------------------------------------------------
 		function registerForm($t_user = "") {
 			if(!is_object($t_user)){
 				$t_user = new ca_users();
 			}
 			$this->view->setVar("t_user", $t_user);
 			
 			$va_profile_prefs = $t_user->getValidPreferences('profile');
 			if (is_array($va_profile_prefs) && sizeof($va_profile_prefs)) {
 				$va_elements = array();
				foreach($va_profile_prefs as $vs_pref) {
					$va_pref_info = $t_user->getPreferenceInfo($vs_pref);
					$va_elements[$vs_pref] = array('element' => $t_user->preferenceHtmlFormElement($vs_pref), 'formatted_element' => $t_user->preferenceHtmlFormElement($vs_pref, "<div><b>".$va_pref_info['label']."</b><br/>^ELEMENT</div>"), 'bs_formatted_element' => $t_user->preferenceHtmlFormElement($vs_pref, "<label for='".$vs_pref."' class='col-sm-4 control-label'>".$va_pref_info['label']."</label><div class='col-sm-7'>^ELEMENT</div><!-- end col-sm-7 -->\n", array("classname" => "form-control")), 'info' => $va_pref_info, 'label' => $va_pref_info['label']);
				}
				
				$this->view->setVar("profile_settings", $va_elements);
			}
 			
 			$this->render("LoginReg/form_register_html.php");
 		}
 		# ------------------------------------------------------
 		function login() {
			$t_user = new ca_users();
			if (!$this->request->doAuthentication(array('dont_redirect' => true, 'user_name' => $this->request->getParameter('username', pString), 'password' => $this->request->getParameter('password', pString)))) {
				$this->view->setVar("message", _t("Login failed"));
 				$this->loginForm();
			} else {
 				# --- user is joining a user group from a supplied link
 				if($this->request->session->getVar("join_user_group_id")){
 					print $this->request->user->get("user_id");
 					if(!$this->request->user->inGroup($this->request->session->getVar("join_user_group_id"))){
 						$this->request->user->addToGroups($this->request->session->getVar("join_user_group_id"));
 						$this->request->session->setVar("join_user_group_id", "");
 						$vs_group_message = _t(" and added to the group");
 					}else{
 						$this->request->session->setVar("join_user_group_id", "");
 						$vs_group_message = _t(" you are already a member of the group");
 					}
 				}
 				if($this->request->isAjax()){
 					$this->view->setVar("message", _t("You are now logged in"));
 					$this->render("Form/reload_html.php");
 				}else{
 					$vs_action = $vs_controller = $vs_module_path = '';
					if ($vs_default_action = $this->request->config->get('default_action')) {
						$va_tmp = explode('/', $vs_default_action);
						$vs_action = array_pop($va_tmp);
						if (sizeof($va_tmp)) { $vs_controller = array_pop($va_tmp); }
						if (sizeof($va_tmp)) { $vs_module_path = join('/', $va_tmp); }
					} else {
						$vs_controller = 'Splash';
						$vs_action = 'Index';
					}
					$vs_url = caNavUrl($this->request, $vs_module_path, $vs_controller, $vs_action);
					$this->notification->addNotification(_t("You have been logged in").$vs_group_message, __NOTIFICATION_TYPE_INFO__);
 					$this->response->setRedirect($vs_url);
 				}
 			}
 		}
 		# -------------------------------------------------------
 		function logout() {
 			if ($vs_default_action = $this->request->config->get('default_action')) {
				$va_tmp = explode('/', $vs_default_action);
				$vs_action = array_pop($va_tmp);
				if (sizeof($va_tmp)) { $vs_controller = array_pop($va_tmp); }
				if (sizeof($va_tmp)) { $vs_module_path = join('/', $va_tmp); }
			} else {
				$vs_controller = 'Splash';
				$vs_action = 'Index';
			}
			$vs_url = caNavUrl($this->request, $vs_module_path, $vs_controller, $vs_action);
			
 			$this->request->deauthenticate();
 			$this->notification->addNotification(_t("You have been logged out"), __NOTIFICATION_TYPE_INFO__);
 			$this->response->setRedirect($vs_url);
 			
 			$t_user = new ca_users();
			
			$this->loginForm();
 		}
 		# -------------------------------------------------------
 		function register() {
 			# logout user in case is already logged in
			$this->request->deauthenticate();
			
			$t_user = new ca_users();
			
			# --- process incoming registration attempt
			$ps_email = strip_tags($this->request->getParameter("email", pString));
			$ps_fname = strip_tags($this->request->getParameter("fname", pString));
			$ps_lname = strip_tags($this->request->getParameter("lname", pString));
			$ps_password = $this->request->getParameter("password", pString);
			$ps_password2 = $this->request->getParameter("password2", pString);
			$ps_security = $this->request->getParameter("security", pString);
			
			$va_errors = array();
			
			if (!caCheckEmailAddress($ps_email)) {
				$va_errors["email"] = _t("E-mail address is not valid.");
			}else{
				$t_user->set("email", $ps_email);
			}
			if (!$ps_fname) {
				$va_errors["fname"] = _t("Please enter your first name");
			}else{
				$t_user->set("fname", $ps_fname);
			}
			if (!$ps_lname) {
				$va_errors["lname"] = _t("Please enter your last name");
			}else{
				$t_user->set("lname", $ps_lname);
			}
			if ((!$ps_password) || (!$ps_password2)) {
				$va_errors["password"] = _t("Please enter and re-type your password.");
			}else{
				if($ps_password != $ps_password2){
					$va_errors["password"] = _t("Passwords do not match");
				}else{
					$t_user->set("password", $ps_password);
				}
			}
			if ((!$ps_security)) {
				$va_errors["security"] = _t("Please answer the security question.");
			}else{
				if($ps_security != $_REQUEST["sum"]){
					$va_errors["security"] = _t("Your answer was incorrect, please try again");
				}
			}
			
			// Check user profile responses
			$va_profile_prefs = $t_user->getValidPreferences('profile');
			if (is_array($va_profile_prefs) && sizeof($va_profile_prefs)) {
				foreach($va_profile_prefs as $vs_pref) {
					$vs_pref_value = $this->request->getParameter('pref_'.$vs_pref, pString);
					if (!$t_user->isValidPreferenceValue($vs_pref, $vs_pref_value)) {
						$va_errors[$vs_pref] = join("; ", $t_user->getErrors());
						
						$t_user->clearErrors();
					}
				}
			}
			
			# --- does deleted user login record for this user already exist?
			# --- (look for active records only; inactive records will effectively block reregistration)
			$vb_user_exists_but_is_deleted = false;
			if ($t_user->load(array('user_name' => $ps_email))) {
				if ((int)$t_user->get('userclass') == 255) {
					if ($t_user->get('active') == 1) {
						// yeah... so allow registration
						$vb_user_exists_but_is_deleted = true;
					} else {
						// existing inactive user record blocks registration
						$va_errors["email"] = _t("User cannot register");
					}
				} else {
					// already valid login with this user name
					$va_errors["email"] = _t("A user has already registered with this email address");
				}
			}
			
			# get names of form fields
			$va_fields = $t_user->getFormFields();

			# loop through fields
			foreach($va_fields as $vs_f => $va_attr) {
				switch($vs_f){
					case "user_name":
						if (!$vb_user_exists_but_is_deleted && !sizeof($va_errors)) {
							# set field value
							$t_user->set("user_name",$ps_email);
							if ($t_user->numErrors() > 0) {
								$va_errors[$vs_f] = join("; ", $t_user->getErrors());
							}
						}
					break;
					# -------------
					case "active":
						$t_user->set("active",1);
					break;
					# -------------
					case "userclass":
						$t_user->set("userclass",1);		// 1=public-only
					break;
					# -------------
					default:
						if(!$va_errors[$vs_f]){
							$t_user->set($vs_f,$_REQUEST[$vs_f]); # set field values
							if ($t_user->numErrors() > 0) {
								$va_errors[$vs_f] = join("; ", $t_user->getErrors());
							}
						}
					break;
					# -------------
				}
			}
		
			// Save user profile responses
			if (is_array($va_profile_prefs) && sizeof($va_profile_prefs)) {
				foreach($va_profile_prefs as $vs_pref) {
					$t_user->setPreference($vs_pref, $this->request->getParameter('pref_'.$vs_pref, pString));
				}
			}
			
			if(sizeof($va_errors) == 0){
				# --- there are no errors so make new user record
				$t_user->setMode(ACCESS_WRITE);
				
				if ($vb_user_exists_but_is_deleted) {
					$t_user->update();
				} else {
					$t_user->insert();
				}
				$pn_user_id = $t_user->get("user_id");
				if($t_user->numErrors()) {
					$va_errors["register"] = join("; ", $t_user->getErrors());
				}else{
					# --- add default roles
					if (($va_default_roles = $this->request->config->getList('registration_default_roles')) && sizeof($va_default_roles)) {
						$t_user->addRoles($va_default_roles);
					}
					# --- user is joining a user group from a supplied link
					if($this->request->session->getVar("join_user_group_id")){
						if(!$t_user->inGroup($this->request->session->getVar("join_user_group_id"))){
							$t_user->addToGroups($this->request->session->getVar("join_user_group_id"));
							$this->request->session->setVar("join_user_group_id", "");
							$vs_group_message = _t(" You were added to the group");
						}else{
							$this->request->session->setVar("join_user_group_id", "");
							$vs_group_message = _t(" You are already a member of the group");
						}
					}
					
					# --- send email confirmation
					# -- generate email subject line from template
					ob_start();
					require($this->request->getViewsDirectoryPath()."/mailTemplates/reg_conf_subject.tpl");
						
					$vs_subject_line = ob_get_contents(); 
					ob_end_clean();
					# -- generate mail text from template - get both the text and the html versions
					ob_start();
					require($this->request->getViewsDirectoryPath()."/mailTemplates/reg_conf.tpl");
						
					$vs_mail_message_text = ob_get_contents(); 
					ob_end_clean();
					ob_start();
					require($this->request->getViewsDirectoryPath()."/mailTemplates/reg_conf_html.tpl");
						
					$vs_mail_message_html = ob_get_contents(); 
					ob_end_clean();
					caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);

					$t_user = new ca_users();
					# log in the new user
					$this->request->doAuthentication(array('dont_redirect' => true, 'user_name' => $ps_email, 'password' => $ps_password));
			
					if($this->request->isLoggedIn()){
						if($this->request->isAjax()){
							$this->view->setVar("message", _t('Thank you for registering!  You are now logged in.').$vs_group_message);
 							$this->render("Form/reload_html.php");
						}else{
							$vs_action = $vs_controller = $vs_module_path = '';
							if ($vs_default_action = $this->request->config->get('default_action')) {
								$va_tmp = explode('/', $vs_default_action);
								$vs_action = array_pop($va_tmp);
								if (sizeof($va_tmp)) { $vs_controller = array_pop($va_tmp); }
								if (sizeof($va_tmp)) { $vs_module_path = join('/', $va_tmp); }
							} else {
								$vs_controller = 'Splash';
								$vs_action = 'Index';
							}
							$vs_url = caNavUrl($this->request, $vs_module_path, $vs_controller, $vs_action);
							$this->notification->addNotification(_t('Thank you for registering!  You are now logged in.').$vs_group_message, __NOTIFICATION_TYPE_INFO__);
							$this->response->setRedirect($vs_url);
						}
					}else{
						$va_errors["register"] = _t("Login failed.");
					}
				}
			}else{
				$this->view->setVar('errors', $va_errors);
			}
			
			$this->registerForm($t_user);
 		}
 		# -------------------------------------------------------
 		function joinGroup() {
			$t_user_group = new ca_user_groups();
			$pn_group_id = $this->request->getParameter("group_id", pInteger);
			if($pn_group_id){
				if($this->request->isLoggedIn()){
					if(!$this->request->user->inGroup($pn_group_id)){
						$this->request->user->addToGroups($pn_group_id);
						$this->request->session->setVar("join_user_group_id", "");
						$vs_group_message = _t("You were added to the group");
					}else{
						$this->request->session->setVar("join_user_group_id", "");
						$vs_group_message = _t("You are already a member of the group");
					}
					$this->notification->addNotification($vs_group_message, __NOTIFICATION_TYPE_INFO__);
					$this->response->setRedirect(caNavUrl($this->request, "", "Sets", "Index"));
				}else{
					$t_user_group->load($pn_group_id);
					$this->request->session->setVar("join_user_group_id", $pn_group_id);
					$this->view->setVar("message", _t("Login/Register to join \"%1\"", $t_user_group->get("name")));
					$this->loginForm();
				}
			}else{	
				$this->view->setVar("message", _t("Invalid user group"));
			}
 		}
 		# ------------------------------------------------------

 	}
 ?>