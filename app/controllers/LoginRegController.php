<?php
/* ----------------------------------------------------------------------
 * controllers/LoginRegController.php
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
	require_once(__CA_MODELS_DIR__."/ca_users.php");
	require_once(__CA_MODELS_DIR__."/ca_user_groups.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');

	class LoginRegController extends BasePawtucketController {
		# -------------------------------------------------------
		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
			parent::__construct($po_request, $po_response, $pa_view_paths);

			if ($po_request->getAppConfig()->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) {
				throw new ApplicationException('Login/registration not allowed');
			}
			caSetPageCSSClasses(array("loginreg"));
		}
		# -------------------------------------------------------
		function loginForm() {
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Login"));
			$this->render("LoginReg/form_login_html.php");
		}
		# ------------------------------------------------------
		function registerForm($t_user = "") {
			if (
			    $this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])
			    ||
			    $this->request->config->get('dontAllowRegistration')
			) {
				$this->notification->addNotification(_t("Registration is not enabled"), __NOTIFICATION_TYPE_ERROR__);
				$this->redirect(caNavUrl($this->request, '', 'Front', 'Index'));
				return;
			}
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Register"));
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
		function profileForm($t_user = "") {
			if(!$this->request->isLoggedIn()){
				$this->notification->addNotification(_t("User is not logged in"), __NOTIFICATION_TYPE_ERROR__);
				$this->redirect(caNavUrl($this->request, '', 'Front', 'Index'));
				return;
			}
			if (
			    $this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])
			) {
				$this->notification->addNotification(_t("Login/registration not allowed"), __NOTIFICATION_TYPE_ERROR__);
				$this->redirect(caNavUrl($this->request, '', 'Front', 'Index'));
				return;
			}
			MetaTagManager::setWindowTitle(_t("User Profile"));
			if(!is_object($t_user)){
				$t_user = $this->request->user;
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

			$this->render("LoginReg/form_profile_html.php");
		}
		# ------------------------------------------------------
		function profileSave() {
		    if (caValidateCSRFToken($this->request, null, ['notifications' => $this->notification])) {
                if(!$this->request->isLoggedIn()){
                    $this->notification->addNotification(_t("User is not logged in"), __NOTIFICATION_TYPE_ERROR__);
                    $this->redirect(caNavUrl($this->request, '', 'Front', 'Index'));
                    return;
                }
                if (
                    $this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])
                ) {
                    $this->notification->addNotification(_t("Login/registration not allowed"), __NOTIFICATION_TYPE_ERROR__);
                    $this->redirect(caNavUrl($this->request, '', 'Front', 'Index'));
                    return;
                }
                MetaTagManager::setWindowTitle(_t("User Profile"));
                $t_user = $this->request->user;
                $t_user->purify(true);
        
                $ps_email = $this->request->getParameter("email", pString);
                $ps_fname = $this->request->getParameter("fname", pString);
                $ps_lname = $this->request->getParameter("lname", pString);
                $ps_password = $this->request->getParameter("password", pString);
                $ps_password2 = $this->request->getParameter("password2", pString);
                $ps_security = $this->request->getParameter("security", pString);
                $va_errors = array();

                if (!caCheckEmailAddress($ps_email)) {
                    $va_errors["email"] = _t("E-mail address is not valid.");
                }else{
                    # --- if the username is changing, make sure there isn't an account uwith the same user name already
                    if($ps_email != $t_user->get("user_name")){
                        # --- does deleted user login record for this user already exist?
                        # --- (look for active records only; inactive records will effectively block reregistration)
                        $t_user_check = new ca_users();
                        $vb_user_exists_but_is_deleted = false;
                        if ($t_user_check->load(array('user_name' => $ps_email))) {
                            if ((int)$t_user_check->get('userclass') == 255) {
                                if ($t_user_check->get('active') == 1) {
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
                    }
                    if(!$va_errors["email"]){
                        $t_user->set("user_name",$ps_email);
                        $t_user->set("email", $ps_email);
                    }
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
                if ($ps_password) {
                    if($ps_password != $ps_password2){
                        $va_errors["password"] = _t("Passwords do not match");
                    }
                    if(strlen($ps_password) < 4){
                        $va_errors["password"] = _t("Password must be at least 4 characters long");
                    }
                    if(!$va_errors["password"]){
                        $t_user->set("password", $ps_password);
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
                        }else{
                            $t_user->setPreference($vs_pref, $this->request->getParameter('pref_'.$vs_pref, pString));
                        }
                    }
                }		
        
                if(sizeof($va_errors) == 0){
                    # --- there are no errors so update new user record
                    $t_user->setMode(ACCESS_WRITE);
                    $t_user->update();
                    if($t_user->numErrors()) {
                        $va_errors["general"] = join("; ", $t_user->getErrors());
                    }else{
                        #success
                        $this->notification->addNotification(_t("Updated profile"), __NOTIFICATION_TYPE_INFO__);
                        // If we are editing the user record of the currently logged in user
                        // we have a problem: the request object flushes out changes to its own user object
                        // for the logged-in user at the end of the request overwriting any changes we've made.
                        //
                        // To avoid this we check here to see if we're editing the currently logged-in
                        // user and reload the request's copy if needed.
                        $this->request->user->load($t_user->getPrimaryKey());
                    }
                }
                if(sizeof($va_errors)){
                    $this->notification->addNotification(_t("There were errors, your profile could not be updated"), __NOTIFICATION_TYPE_ERROR__);
                    $this->view->setVar("errors", $va_errors);
                }
            }
			$this->profileForm();
		}
		# ------------------------------------------------------
		function resetForm() {
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Reset Password"));
			$this->render("LoginReg/form_reset_html.php");
		}
		# ------------------------------------------------------
		function login() {
			if (!$this->request->doAuthentication(array('dont_redirect' => true, 'user_name' => $this->request->getParameter('username', pString), 'password' => $this->request->getParameter('password', pString)))) {
				$this->view->setVar("message", _t("Login failed"));
				$this->loginForm();
			} else {
				# --- user is joining a user group from a supplied link
				if(Session::getVar("join_user_group_id")){
					if(!$this->request->user->inGroup(Session::getVar("join_user_group_id"))){
						$this->request->user->addToGroups(Session::getVar("join_user_group_id"));
						Session::setVar("join_user_group_id", "");
						$vs_group_message = _t(" and added to the group");
					}else{
						Session::setVar("join_user_group_id", "");
						$vs_group_message = _t(" you are already a member of the group");
					}
				}
				if($this->request->isAjax()){
					$this->view->setVar("message", _t("You are now logged in"));
					$this->render("Form/reload_html.php");
				}else{
					$vs_controller = $vs_module_path = '';
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

			$this->loginForm();
		}
		# -------------------------------------------------------
		function register() {
			if (!caValidateCSRFToken($this->request, null, ['notifications' => $this->notification])) {
				$this->register();
				return;
		    }
			if (
			    $this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])
			    ||
			    $this->request->config->get('dontAllowRegistration')
			) {
				$this->notification->addNotification(_t("Registration is not enabled"), __NOTIFICATION_TYPE_ERROR__);
				$this->redirect(caNavUrl($this->request, '', 'Front', 'Index'));
				return;
			}
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Register"));
			# logout user in case is already logged in
			$this->request->deauthenticate();

			$t_user = new ca_users();
			$t_user->purify(true);

			# --- process incoming registration attempt
			$ps_email = $this->request->getParameter("email", pString);
			$ps_fname = $this->request->getParameter("fname", pString);
			$ps_lname = $this->request->getParameter("lname", pString);
			$ps_password = $this->request->getParameter("password", pString);
			$ps_password2 = $this->request->getParameter("password2", pString);
			$ps_security = $this->request->getParameter("security", pString);
			$ps_captcha = $this->request->getParameter("g-recaptcha-response", pString);

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
				}
				if(strlen($ps_password) < 4){
					$va_errors["password"] = _t("Password must be at least 4 characters long");
				}
				if(!$va_errors["password"]){
					$t_user->set("password", $ps_password);
				}
			}
			$co_security = $this->request->config->get('registration_security');
			if($co_security == 'captcha'){
         			if(strlen($this->request->config->get('google_recaptcha_sitekey')) != 40 || strlen($this->request->config->get('google_recaptcha_secretkey')) != 40){
					//Then the captcha will not work and should not be implemenented.
                    			$co_security = 'equation_sum';
                		}
        		}
			if($co_security == 'captcha'){
				if(!$ps_captcha){
						$va_errors["recaptcha"] = _t("Please complete the captcha");
				} else {
						$va_request = curl_init();
						curl_setopt($va_request, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
						curl_setopt($va_request, CURLOPT_HEADER, 0);
						curl_setopt($va_request, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($va_request, CURLOPT_POST, 1);
						$va_request_params = ['secret'=>$this->request->config->get('google_recaptcha_secretkey'), 'response'=>$ps_captcha];
						curl_setopt($va_request, CURLOPT_POSTFIELDS, $va_request_params);
						$va_captcha_resp = curl_exec($va_request);
						$captcha_json = json_decode($va_captcha_resp, true);
						if(!$captcha_json['success']){
								$va_errors["recaptcha"] = _t("Your Captcha was rejected, please try again");
						}
				}
			} else {
				if ((!$ps_security)) {
					$va_errors["security"] = _t("Please answer the security question.");
				}else{
					if($ps_security != $_REQUEST["sum"]){
						$va_errors["security"] = _t("Your answer was incorrect, please try again");
					}
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
						if($this->request->config->get('dont_approve_logins_on_registration')){
							$t_user->set("active",0);
						}else{
							$t_user->set("active",1);
						}
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
			$t_user->set("registered_on","now");

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
					if(Session::getVar("join_user_group_id")){
						if(!$t_user->inGroup(Session::getVar("join_user_group_id"))){
							$t_user->addToGroups(Session::getVar("join_user_group_id"));
							Session::setVar("join_user_group_id", "");
							$vs_group_message = _t(" You were added to the group");
						}else{
							Session::setVar("join_user_group_id", "");
							$vs_group_message = _t(" You are already a member of the group");
						}
					}

					# --- send email confirmation
					$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));

					# -- generate email subject line from template
					$vs_subject_line = $o_view->render("mailTemplates/reg_conf_subject.tpl");

					# -- generate mail text from template - get both the text and the html versions
					$vs_mail_message_text = $o_view->render("mailTemplates/reg_conf.tpl");
					$vs_mail_message_html = $o_view->render("mailTemplates/reg_conf_html.tpl");
					caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);

					if($this->request->config->get("email_notification_for_new_registrations")){
						# --- send email to admin
						$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));

						$o_view->setVar("t_user", $t_user);
						# -- generate email subject line from template
						$vs_subject_line = $o_view->render("mailTemplates/reg_admin_notification_subject.tpl");
	
						# -- generate mail text from template - get both the text and the html versions
						$vs_mail_message_text = $o_view->render("mailTemplates/reg_admin_notification.tpl");
						$vs_mail_message_html = $o_view->render("mailTemplates/reg_admin_notification_html.tpl");
					
						caSendmail($this->request->config->get("ca_admin_email"), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
					}

					#$t_user = new ca_users();
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
					if($t_user->get("active")){
						# log in the new user
						$this->request->doAuthentication(array('dont_redirect' => true, 'user_name' => $ps_email, 'password' => $ps_password));
	
						if($this->request->isLoggedIn()){
							if($this->request->isAjax()){
								$this->view->setVar("message", _t('Thank you for registering!  You are now logged in.').$vs_group_message);
								$this->render("Form/reload_html.php");
								return;
							}else{
								$this->notification->addNotification(_t('Thank you for registering!  You are now logged in.').$vs_group_message, __NOTIFICATION_TYPE_INFO__);
								$this->response->setRedirect($vs_url);
							}
						}else{
							$va_errors["register"] = _t("Login failed.");
						}
					}else{
						# --- registration needs approval
						if($this->request->isAjax()){
							$this->view->setVar("message", _t('Thank you for registering!  Your account will be activated after review.').$vs_group_message);
							$this->render("Form/reload_html.php");
							return;
						}else{
							$this->notification->addNotification(_t('Thank you for registering!  Your account will be activated after review.').$vs_group_message, __NOTIFICATION_TYPE_INFO__);
							$this->response->setRedirect($vs_url);
						}
					}
				}
			}

			if(sizeof($va_errors) > 0) {
				$this->view->setVar('errors', $va_errors);
				$this->registerForm($t_user);
			}
		}
		# -------------------------------------------------------
		function joinGroup() {
			$t_user_group = new ca_user_groups();
			$pn_group_id = $this->request->getParameter("group_id", pInteger);
			if($pn_group_id){
				if($this->request->isLoggedIn()){
					if(!$this->request->user->inGroup($pn_group_id)){
						$this->request->user->addToGroups($pn_group_id);
						Session::setVar("join_user_group_id", "");
						$vs_group_message = _t("You were added to the group");
					}else{
						Session::setVar("join_user_group_id", "");
						$vs_group_message = _t("You are already a member of the group");
					}
					$this->notification->addNotification($vs_group_message, __NOTIFICATION_TYPE_INFO__);
					if(!$vs_controller = $this->request->getParameter("section", pString)){
						$vs_controller = "Lightbox";
					}
					$this->response->setRedirect(caNavUrl($this->request, "", $vs_controller, "Index"));
				}else{
					$t_user_group->load($pn_group_id);
					Session::setVar("join_user_group_id", $pn_group_id);
					$this->view->setVar("message", _t("Login/Register to join \"%1\"", $t_user_group->get("name")));
					$this->loginForm();
				}
			}else{
				$this->view->setVar("message", _t("Invalid user group"));
			}
		}
		# -------------------------------------------------------
		function resetSend(){
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Reset Password"));
			$t_user = new ca_users();

			$vs_message = "";
			$va_errors = array();
			$ps_email = $this->request->getParameter('reset_email', pString);
			if (!caCheckEmailAddress($ps_email)) {
				$this->view->setVar("message",_t("E-mail address is not valid"));
				$this->resetForm();
			}else{
				$t_user->setErrorOutput(0);
				if (!$t_user->load(array("user_name" => $ps_email))) {
					$t_user->load(array("email" => $ps_email));
				}
				# verify user exists with this e-mail address
				if ($t_user->getPrimaryKey()) {
					# user with e-mail does exists...

					if (sizeof($va_errors) == 0) {
						$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
						$vs_reset_key = md5($t_user->get("user_id").'/'.$t_user->get("password"));
						# --- get the subject of the email from template
						$vs_subject_line = $o_view->render('mailTemplates/instructions_subject.tpl');

						# -- generate mail text from template - get both the text and html versions
						$vs_password_reset_url = $this->request->config->get("site_host").caNavUrl($this->request, '', 'LoginReg', 'resetSave', array('key' => $vs_reset_key));
						$o_view->setVar("password_reset_url", $vs_password_reset_url);
						$vs_mail_message_text = $o_view->render('mailTemplates/instructions.tpl');
						$vs_mail_message_html = $o_view->render('mailTemplates/instructions_html.tpl');

						caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);

						$this->view->setVar("email", $this->request->config->get("ca_admin_email"));
						$this->view->setVar("action", "send");

						$this->render('LoginReg/form_reset_html.php');
					}
				} else {
					$this->view->setVar("message",_t("There is no registered user with the email address you provided"));
					$this->resetForm();
				}
			}
		}
		# ------------------------------------------------------
		function resetSave(){
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Reset Password"));
			$ps_action = $this->request->getParameter('action', pString);
			if(!$ps_action){
				$ps_action = "reset";
			}
			$ps_key = $this->request->getParameter('key', pString);
			$ps_key = preg_replace("/[^A-Za-z0-9]+/", "", $ps_key);
			$this->view->setVar("key", $ps_key);

			$this->view->setVar("email", $this->request->config->get("ca_admin_email"));

			$o_check_key = new Db();
			$qr_check_key = $o_check_key->query("
					SELECT user_id 
					FROM ca_users 
					WHERE
						md5(concat(concat(user_id, '/'), password)) = ?
				", $ps_key);

			#
			# Check reset key
			#
			if ((!$qr_check_key->nextRow()) || (!$vs_user_id = $qr_check_key->get("user_id"))) {
				$this->view->setVar("action", "reset_failure");
				$this->view->setVar("message",_t("Your password could not be reset"));
				$this->render('LoginReg/form_reset_html.php');
			}else{

				$ps_password = $this->request->getParameter('password', pString);
				$ps_password_confirm = $this->request->getParameter('password_confirm', pString);

				switch($ps_action) {
					case 'reset_save':
						if(!$ps_password || !$ps_password_confirm){
							$this->view->setVar("message", _t("Please enter and re-type your password."));
							$ps_action = "reset";
							break;
						}
						if ($ps_password != $ps_password_confirm) {
							$this->view->setVar("message", _t("Passwords do not match. Please try again."));
							$ps_action = "reset";
							break;
						}
						
						if(strlen($ps_password) < 4){
							$this->view->setVar("message", _t("Password must be at least 4 characters long."));
							$ps_action = "reset";
							break;
						}
						$t_user = new ca_users();
						$t_user->purify(true);
						$t_user->load($vs_user_id);
						# verify user exists with this e-mail address
						if ($t_user->getPrimaryKey()) {
							# user with e-mail already exists...
							$t_user->setMode(ACCESS_WRITE);
							$t_user->set("password", $ps_password);
							$t_user->update();

							if ($t_user->numErrors()) {
								$this->notification->addNotification(join("; ", $t_user->getErrors()), __NOTIFICATION_TYPE_INFO__);
								$ps_action = "reset_failure";
							} else {
								$ps_action = "reset_success";
								$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
								# -- generate email subject
								$vs_subject_line = $o_view->render("mailTemplates/notification_subject.tpl");

								# -- generate mail text from template - get both the html and text versions
								$vs_mail_message_text = $o_view->render("mailTemplates/notification.tpl");
								$vs_mail_message_html = $o_view->render("mailTemplates/notification_html.tpl");

								caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
							}
							break;
						} else {
							$this->notification->addNotification(_t("Invalid user"), __NOTIFICATION_TYPE_INFO__);
							$ps_action = "reset_failure";
						}
				}
				$this->view->setVar("action", $ps_action);
				$this->render('LoginReg/form_reset_html.php');
			}
		}
		# -------------------------------------------------------
	}
