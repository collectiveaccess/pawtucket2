<?php
/* ----------------------------------------------------------------------
 * controllers/LoginRegController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2025 Whirl-i-Gig
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

class LoginRegController extends BasePawtucketController {
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$request, &$response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);

		if ($request->getAppConfig()->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) {
			throw new ApplicationException('Login/registration not allowed');
		}
		
		if (AuthenticationManager::supports(__CA_AUTH_ADAPTER_FEATURE_USE_ADAPTER_LOGIN_FORM__)) {
		    $auth_success = $request->doAuthentication(array('dont_redirect' => true, 'noPublicUsers' => false, 'allow_external_auth' => ($request->getController() == 'LoginReg')));
		}
		
		caSetPageCSSClasses(array("loginreg"));
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function loginForm() {
		if (AuthenticationManager::supports(__CA_AUTH_ADAPTER_FEATURE_USE_ADAPTER_LOGIN_FORM__)) {
			if($this->request->isLoggedIn()) {
				$this->notification->addNotification(_t("You have been logged in"), __NOTIFICATION_TYPE_INFO__);
			}
			$this->redirect(caNavUrl($this->request, '', 'Front', 'Index'));
			return;
		}
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Login"));
		$this->render("LoginReg/form_login_html.php");
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	function loginRegisterForm(?ca_users $t_user=null) {
		if ($this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) {
			$this->notification->addNotification(_t("Login is not enabled"), __NOTIFICATION_TYPE_ERROR__);
			$this->redirect(caNavUrl($this->request, '', 'Front', 'Index'));
			return;
		}
		if ($this->request->config->get('dontAllowRegistration')) {
			$this->view->setVar("show_register_form", false);
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Login"));		
		}else{
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Login or Register"));
			if(!is_object($t_user)){
				$t_user = new ca_users();
			}
			if(!is_object($t_user)){
				$t_user = new ca_users();
			}
			$this->view->setVar("t_user", $t_user);

			$profile_prefs = $t_user->getValidPreferences('profile');
			if (is_array($profile_prefs) && sizeof($profile_prefs)) {
				$elements = [];
				foreach($profile_prefs as $pref) {
					$pref_info = $t_user->getPreferenceInfo($pref);
					$elements[$pref] = array('element' => $t_user->preferenceHtmlFormElement($pref), 'formatted_element' => $t_user->preferenceHtmlFormElement($pref, "<label for='pref_".$pref."'>".$pref_info['label']."</label>^ELEMENT"), 'bs_formatted_element' => $t_user->preferenceHtmlFormElement($pref, "<label class='form-label' for='pref_".$pref."'>".$pref_info['label']."</label>^ELEMENT", array("classname" => "form-control")), 'info' => $pref_info, 'label' => $pref_info['label']);
				}

				$this->view->setVar("profile_settings", $elements);
			}
		}
		$this->render("LoginReg/form_login_register_html.php");
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	function registerForm(?ca_users $t_user=null) {
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

		$profile_prefs = $t_user->getValidPreferences('profile');
		if (is_array($profile_prefs) && sizeof($profile_prefs)) {
			$elements = [];
			foreach($profile_prefs as $pref) {
				$pref_info = $t_user->getPreferenceInfo($pref);
				$elements[$pref] = array('element' => $t_user->preferenceHtmlFormElement($pref), 'formatted_element' => $t_user->preferenceHtmlFormElement($pref, "<label for='pref_".$pref."'>".$pref_info['label']."</label>^ELEMENT"), 'bs_formatted_element' => $t_user->preferenceHtmlFormElement($pref, "<label class='form-label' for='pref_".$pref."'>".$pref_info['label']."</label>^ELEMENT", array("classname" => "form-control")), 'info' => $pref_info, 'label' => $pref_info['label']);
			}

			$this->view->setVar("profile_settings", $elements);
		}

		$this->render("LoginReg/form_register_html.php");
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	function profileForm(?ca_users $t_user=null) {
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
	
		$profile_prefs = $t_user->getValidPreferences('profile');
		if (is_array($profile_prefs) && sizeof($profile_prefs)) {
			$elements = [];
			foreach($profile_prefs as $pref) {
				$pref_info = $t_user->getPreferenceInfo($pref);
				$elements[$pref] = array('element' => $t_user->preferenceHtmlFormElement($pref), 'formatted_element' => $t_user->preferenceHtmlFormElement($pref, "<label for='pref_".$pref."'>".$pref_info['label']."</label>^ELEMENT"), 'bs_formatted_element' => $t_user->preferenceHtmlFormElement($pref, "<label class='form-label' for='pref_".$pref."'>".$pref_info['label']."</label>^ELEMENT", array("classname" => "form-control")), 'info' => $pref_info, 'label' => $pref_info['label']);
			}

			$this->view->setVar("profile_settings", $elements);
		}

		$this->render("LoginReg/form_profile_html.php");
	}
	# ------------------------------------------------------
	/**
	 *
	 */
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
	
			$email = html_entity_decode(strip_tags($this->request->getParameter("email", pString)));
			$fname = strip_tags($this->request->getParameter("fname", pString));
			$lname = strip_tags($this->request->getParameter("lname", pString));
			$password = html_entity_decode(strip_tags($this->request->getParameter("password", pString)));
			$password2 = html_entity_decode(strip_tags($this->request->getParameter("password2", pString)));
  
			$security = strip_tags($this->request->getParameter("security", pString));
			$group_code = strip_tags($this->request->getParameter("group_code", pString));

			$errors = [];

			if (!caCheckEmailAddress($email)) {
				$errors["email"] = _t("E-mail address is not valid.");
			}else{
				# --- if the username is changing, make sure there isn't an account with the same user name already
				if($email != $t_user->get("user_name")){
					# --- does deleted user login record for this user already exist?
					# --- (look for active records only; inactive records will effectively block reregistration)
					$t_user_check = new ca_users();
					$user_exists_but_is_deleted = false;
					if ($t_user_check->load(array('user_name' => $email))) {
						if ((int)$t_user_check->get('userclass') == 255) {
							if ($t_user_check->get('active') == 1) {
								// yeah... so allow registration
								$user_exists_but_is_deleted = true;
							} else {
								// existing inactive user record blocks registration
								$errors["email"] = _t("User cannot register");
							}
						} else {
							// already valid login with this user name
							$errors["email"] = _t("A user has already registered with this email address");
						}
					}
				}
				if(!$errors["email"]){
					if($t_user->get('userclass') == 1) { $t_user->set("user_name", $email); }	// only set for public users
					$t_user->set("email", $email);
				}
			}
			if (!$fname) {
				$errors["fname"] = _t("Please enter your first name");
			}else{
				$t_user->set("fname", $fname);
			}
			if (!$lname) {
				$errors["lname"] = _t("Please enter your last name");
			}else{
				$t_user->set("lname", $lname);
			}
			if ($password) {
				if($password != $password2){
					$errors["password"] = _t("Passwords do not match");
				}
				if(strlen($password) < 4){
					$errors["password"] = _t("Password must be at least 4 characters long");
				}
				if(!$errors["password"]){
					$t_user->set("password", $password);
				}
			}
			
			$t_group_to_join = null;
			if (strlen($group_code) && !($t_group_to_join = $this->_validateGroup($group_code))){
				$errors["group_code"] = _t("Group code %1 is not valid", $group_code);
			}
			
			// Check user profile responses
			$profile_prefs = $t_user->getValidPreferences('profile');
			if (is_array($profile_prefs) && sizeof($profile_prefs)) {
				foreach($profile_prefs as $pref) {
					$pref_value = $this->request->getParameter('pref_'.$pref, pString);
					if (!$t_user->isValidPreferenceValue($pref, $pref_value)) {
						$errors[$pref] = join("; ", $t_user->getErrors());

						$t_user->clearErrors();
					}else{
						$t_user->setPreference($pref, $this->request->getParameter('pref_'.$pref, pString));
					}
				}
			}		
	
			if(sizeof($errors) == 0){
				# --- there are no errors so update new user record
				$t_user->update();
				if($t_user->numErrors()) {
					$errors["general"] = join("; ", $t_user->getErrors());
				}else{
					#success
					
					# User has provided a group code
					if ($t_group_to_join && ($group_id = $t_group_to_join->getPrimaryKey())) {
						if(!$t_user->inGroup($group_id)){
							$t_user->addToGroups($group_id);
							$group_message = _t("You were added to group <em>%1</em>", $t_group_to_join->get('name'));
						}else{
							$group_message = _t("You are already a member of group <em>%1</em>", $t_group_to_join->get('name'));
						}
					}

					
					$this->notification->addNotification(_t("Updated profile").($group_message ? "<br/>{$group_message}" : ""), __NOTIFICATION_TYPE_INFO__);
					// If we are editing the user record of the currently logged in user
					// we have a problem: the request object flushes out changes to its own user object
					// for the logged-in user at the end of the request overwriting any changes we've made.
					//
					// To avoid this we check here to see if we're editing the currently logged-in
					// user and reload the request's copy if needed.
					$this->request->user->load($t_user->getPrimaryKey());
				}
			}
			if(sizeof($errors)){
				$this->notification->addNotification(_t("There were errors, your profile could not be updated"), __NOTIFICATION_TYPE_ERROR__);
				$this->view->setVar("errors", $errors);
			}
		}
		$this->profileForm();
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	function resetForm() {
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Reset Password"));
		$this->render("LoginReg/form_reset_html.php");
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	function login() {
		$group_id = Session::getVar("join_user_group_id");
		if (!$this->request->doAuthentication(array('dont_redirect' => true, 'user_name' => html_entity_decode($this->request->getParameter('username', pString)), 'password' => html_entity_decode($this->request->getParameter('password', pString))))) {
			$this->view->setVar("message", _t("Login failed"));
			$this->loginForm();
		} else {
			# --- user is joining a user group from a supplied link
			if($group_id && $this->_validateGroup($group_id)){
				if(!$this->request->user->inGroup($group_id)){
					$this->request->user->addToGroups($group_id);
					$group_message = _t(" and added to the group");
				}
				Session::setVar('join_user_group_id', '');
			}
			
			$controller = $module_path = '';
			
			if ($default_action = $this->request->config->get('default_login_action')) {
				$tmp = explode('/', $default_action);
				$action = array_pop($tmp);
				if (sizeof($tmp)) { $controller = array_pop($tmp); }
				if (sizeof($tmp)) { $module_path = join('/', $tmp); }
			} elseif ($default_action = $this->request->config->get('default_action')) {
				$tmp = explode('/', $default_action);
				$action = array_pop($tmp);
				if (sizeof($tmp)) { $controller = array_pop($tmp); }
				if (sizeof($tmp)) { $module_path = join('/', $tmp); }
			} else {
				$controller = 'Front';
				$action = 'Index';
			}
			$url = caNavUrl($this->request, $module_path, $controller, $action);
			$this->notification->addNotification(_t("You have been logged in").($group_message ? "<br/>{$group_message}" : ""), __NOTIFICATION_TYPE_INFO__);
			$this->response->setRedirect($url);
		}
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function logout() {
		if ($default_action = $this->request->config->get('default_action')) {
			$tmp = explode('/', $default_action);
			$action = array_pop($tmp);
			if (sizeof($tmp)) { $controller = array_pop($tmp); }
			if (sizeof($tmp)) { $module_path = join('/', $tmp); }
		} else {
			$controller = 'Front';
			$action = 'Index';
		}
		$url = caNavUrl($this->request, $module_path, $controller, $action);

		$this->request->deauthenticate();
		$this->notification->addNotification(_t("You have been logged out"), __NOTIFICATION_TYPE_INFO__);
		$this->response->setRedirect($url);

		$this->loginForm();
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function register() {
		if (!caValidateCSRFToken($this->request, null, ['notifications' => $this->notification])) {
			$this->registerForm();
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
		$email = html_entity_decode(strip_tags($this->request->getParameter("email", pString)));
		$fname = strip_tags($this->request->getParameter("fname", pString));
		$lname = strip_tags($this->request->getParameter("lname", pString));
		$password = html_entity_decode(strip_tags($this->request->getParameter("password", pString)));
		$password2 = html_entity_decode(strip_tags($this->request->getParameter("password2", pString)));
		$security = strip_tags($this->request->getParameter("security", pString));
		$captcha = strip_tags($this->request->getParameter("g-recaptcha-response", pString));
		$group_code = strip_tags($this->request->getParameter("group_code", pString));

		$errors = [];

		if (!caCheckEmailAddress($email)) {
			$errors["email"] = _t("E-mail address is not valid.");
		}else{
			$t_user->set("email", $email);
		}
		if (!$fname) {
			$errors["fname"] = _t("Please enter your first name");
		}else{
			$t_user->set("fname", $fname);
		}
		if (!$lname) {
			$errors["lname"] = _t("Please enter your last name");
		}else{
			$t_user->set("lname", $lname);
		}
		if ((!$password) || (!$password2)) {
			$errors["password"] = _t("Please enter and re-type your password.");
		}else{
			if($password != $password2){
				$errors["password"] = _t("Passwords do not match");
			}
			if(strlen($password) < 4){
				$errors["password"] = _t("Password must be at least 4 characters long");
			}
			if(!$errors["password"]){
				$t_user->set("password", $password);
			}
		}
		$co_security = $this->request->config->get('registration_security');
		if($co_security == 'captcha'){
			if(!(defined("__CA_GOOGLE_RECAPTCHA_SECRET_KEY__") && __CA_GOOGLE_RECAPTCHA_SECRET_KEY__) || !(defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__)){
			//Then the captcha will not work and should not be implemenented.
					$co_security = '';
			}
		}
		if($co_security == 'captcha'){
			if(!$captcha){
					$errors["recaptcha"] = _t("Please complete the captcha");
			} else {
				$request = curl_init();
				curl_setopt($request, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
				curl_setopt($request, CURLOPT_HEADER, 0);
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($request, CURLOPT_POST, 1);
				$request_params = ['secret'=>__CA_GOOGLE_RECAPTCHA_SECRET_KEY__, 'response'=>$captcha];
				curl_setopt($request, CURLOPT_POSTFIELDS, $request_params);
				$captcha_resp = curl_exec($request);
				$captcha_json = json_decode($captcha_resp, true);
				if(!$captcha_json['success']){
						$errors["recaptcha"] = _t("Your Captcha was rejected, please try again");
				}
			}
		}
		
		// check that group code exists if specified
		$t_group_to_join = null;
		if (strlen($group_code) && !($t_group_to_join = $this->_validateGroup($group_code))) {
			$errors["group_code"] = _t("Group code %1 is not valid", $group_code);
		}
		
		// Check user profile responses
		$profile_prefs = $t_user->getValidPreferences('profile');
		if (is_array($profile_prefs) && sizeof($profile_prefs)) {
			foreach($profile_prefs as $pref) {
				$pref_value = $this->request->getParameter('pref_'.$pref, pString);
				if (!$t_user->isValidPreferenceValue($pref, $pref_value)) {
					$errors[$pref] = join("; ", $t_user->getErrors());

					$t_user->clearErrors();
				}
			}
		}

		# --- does deleted user login record for this user already exist?
		# --- (look for active records only; inactive records will effectively block reregistration)
		$user_exists_but_is_deleted = false;
		if ($t_user->load(array('user_name' => $email))) {
			if ((int)$t_user->get('userclass') == 255) {
				if ($t_user->get('active') == 1) {
					// yeah... so allow registration
					$user_exists_but_is_deleted = true;
				} else {
					// existing inactive user record blocks registration
					$errors["email"] = _t("User cannot register");
				}
			} else {
				// already valid login with this user name
				$errors["email"] = _t("A user has already registered with this email address");
			}
		}

		# get names of form fields
		$fields = $t_user->getFormFields();

		# loop through fields
		foreach($fields as $f => $attr) {
			switch($f){
				case "user_name":
					if (!$user_exists_but_is_deleted && !sizeof($errors)) {
						# set field value
						$t_user->set("user_name",$email);
						if ($t_user->numErrors() > 0) {
							$errors[$f] = join("; ", $t_user->getErrors());
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
					if(!$errors[$f]){
						$t_user->set($f,$_REQUEST[$f]); # set field values
						if ($t_user->numErrors() > 0) {
							$errors[$f] = join("; ", $t_user->getErrors());
						}
					}
					break;
				# -------------
			}
		}
		$t_user->set("registered_on", _t("now"));

		// Save user profile responses
		if (is_array($profile_prefs) && sizeof($profile_prefs)) {
			foreach($profile_prefs as $pref) {
				$t_user->setPreference($pref, $this->request->getParameter('pref_'.$pref, pString));
			}
		}

		if(sizeof($errors) == 0){
			# --- there are no errors so make new user record

			if ($user_exists_but_is_deleted) {
				$t_user->update();
			} else {
				$t_user->insert();
			}
			$pn_user_id = $t_user->get("user_id");
			if($t_user->numErrors()) {
				$errors["register"] = join("; ", $t_user->getErrors());
			}else{
				# --- add default roles
				if (($default_roles = $this->request->config->getList('registration_default_roles')) && sizeof($default_roles)) {
					$t_user->addRoles($default_roles);
				}
				# --- user is joining a user group from a supplied link
				if(Session::getVar("join_user_group_id") && $this->_validateGroup(Session::getVar("join_user_group_id"))) {
					if(!$t_user->inGroup(Session::getVar("join_user_group_id"))){
						$t_user->addToGroups(Session::getVar("join_user_group_id"));
						Session::setVar('join_user_group_id', '');
						$group_message = _t(" You were added to the group");
					}else{
						Session::setVar('join_user_group_id', '');
						$group_message = _t(" You are already a member of the group");
					}
				}
				
				# User has provided a group code
				if ($t_group_to_join && ($group_id = $t_group_to_join->getPrimaryKey())) {
					if(!$t_user->inGroup($group_id)){
						$t_user->addToGroups($group_id);
						$group_message = _t("You were added to group <em>%1</em>", $t_group_to_join->get('name'));
					}else{
						$group_message = _t("You are already a member of group <em>%1</em>", $t_group_to_join->get('name'));
					}
				}

				# --- send email confirmation
				$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
				$o_view->setVar("t_user", $t_user);
				
				# -- generate email subject line from template
				$subject_line = $o_view->render("mailTemplates/reg_conf_subject.tpl");

				# -- generate mail text from template - get both the text and the html versions
				$mail_message_text = $o_view->render("mailTemplates/reg_conf.tpl");
				$mail_message_html = $o_view->render("mailTemplates/reg_conf_html.tpl");
				caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), $subject_line, $mail_message_text, $mail_message_html);

				if($this->request->config->get("email_notification_for_new_registrations")){
					# --- send email to admin
					$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));

					$o_view->setVar("t_user", $t_user);
					# -- generate email subject line from template
					$subject_line = $o_view->render("mailTemplates/reg_admin_notification_subject.tpl");

					# -- generate mail text from template - get both the text and the html versions
					$mail_message_text = $o_view->render("mailTemplates/reg_admin_notification.tpl");
					$mail_message_html = $o_view->render("mailTemplates/reg_admin_notification_html.tpl");
				
					caSendmail($this->request->config->get("ca_admin_email"), $this->request->config->get("ca_admin_email"), $subject_line, $mail_message_text, $mail_message_html);
				}

				$action = $controller = $module_path = '';
				if ($default_action = $this->request->config->get('default_action')) {
					$tmp = explode('/', $default_action);
					$action = array_pop($tmp);
					if (sizeof($tmp)) { $controller = array_pop($tmp); }
					if (sizeof($tmp)) { $module_path = join('/', $tmp); }
				} else {
					$controller = 'Front';
					$action = 'Index';
				}
				$url = caNavUrl($this->request, $module_path, $controller, $action);
				if($t_user->get("active")){
					# log in the new user
					$this->request->doAuthentication(array('dont_redirect' => true, 'user_name' => $email, 'password' => $password));

					if($this->request->isLoggedIn()){
						$this->notification->addNotification(_t('Thank you for registering!  You are now logged in.').$group_message, __NOTIFICATION_TYPE_INFO__);
						$this->response->setRedirect($url);
					}else{
						$errors["register"] = _t("Login failed.");
					}
				}else{
					# --- registration needs approval
					$this->notification->addNotification(_t('Thank you for registering!  Your account will be activated after review.').$group_message, __NOTIFICATION_TYPE_INFO__);
					$this->response->setRedirect($url);
				}
			}
		}

		if(sizeof($errors) > 0) {
			$this->view->setVar('errors', $errors);
			$this->registerForm($t_user);
		}
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function joinGroup() {
		$t_user_group = $this->_validateGroup($group_code = $this->request->getParameter("group_code", pString));
	
		if (!$t_user_group) {
			$this->view->setVar("message", _t("Group code %1 is not valid", $group_code));
			$this->notification->addNotification($this->view->getVar('message'), __NOTIFICATION_TYPE_ERROR__);
			$this->response->setRedirect(caNavUrl($this->request, '', 'Front', 'Index'));
			return;
		}
		if($t_user_group){
			$group_id = $t_user_group->getPrimaryKey();
			
			if($this->request->isLoggedIn()){
				if(!$this->request->user->inGroup($group_id)){
					$this->request->user->addToGroups($group_id);
					$group_message = _t("You were added to the group");
				}else{
					$group_message = _t("You are already a member of the group");
				}
				Session::setVar('join_user_group_id', '');
				$this->notification->addNotification($group_message, __NOTIFICATION_TYPE_INFO__);
				if(!$controller = $this->request->getParameter("section", pString)){
					$controller = "Lightbox";
				}
				$this->response->setRedirect(caNavUrl($this->request, "", $controller, "Index"));
				return;
			} else {
				Session::setVar('join_user_group_id', $group_id);
				$this->view->setVar("message", _t("Login/Register to join \"%1\"", $t_user_group->get("name")));
				$this->loginForm();
				return;
			}
		}else{
			$this->view->setVar("message", _t("Invalid user group"));
		}
		$this->notification->addNotification($this->view->getVar('message'), __NOTIFICATION_TYPE_ERROR__);
		$this->response->setRedirect(caNavUrl($this->request, '', 'Front', 'Index'));
		return;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function resetSend(){
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Reset Password"));
		$t_user = new ca_users();

		$message = "";
		$errors = [];
		$email = $this->request->getParameter('reset_email', pString);
		if (!caCheckEmailAddress($email)) {
			$this->view->setVar("message",_t("E-mail address is not valid"));
			$this->resetForm();
		}else{
			$t_user->setErrorOutput(0);
			if (!$t_user->load(array("user_name" => $email))) {
				$t_user->load(array("email" => $email));
			}
			# verify user exists with this e-mail address
			if ($t_user->getPrimaryKey()) {
				# user with e-mail does exists...

				if (sizeof($errors) == 0) {
					$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
					$reset_key = md5($t_user->get("user_id").'/'.$t_user->get("password"));
					# --- get the subject of the email from template
					$subject_line = $o_view->render('mailTemplates/instructions_subject.tpl');

					# -- generate mail text from template - get both the text and html versions
					$password_reset_url = $this->request->config->get("site_host").caNavUrl($this->request, '', 'LoginReg', 'resetSave', array('key' => $reset_key));
					$o_view->setVar("password_reset_url", $password_reset_url);
					$mail_message_text = $o_view->render('mailTemplates/instructions.tpl');
					$mail_message_html = $o_view->render('mailTemplates/instructions_html.tpl');

					caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), $subject_line, $mail_message_text, $mail_message_html);

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
	/**
	 *
	 */
	function resetSave(){
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Reset Password"));

		if(!($action = $this->request->getParameter('action', pString))) {
			$action = "reset";
		}
		$key = preg_replace("/[^A-Za-z0-9]+/", "", $this->request->getParameter('key', pString));
		$this->view->setVar("key", $key);
		$this->view->setVar("email", $this->request->config->get("ca_admin_email"));

		$o_check_key = new Db();
		$qr_check_key = $o_check_key->query("
				SELECT user_id 
				FROM ca_users 
				WHERE
					md5(concat(concat(user_id, '/'), password)) = ?
			", $key);

		#
		# Check reset key
		#
		if ((!$qr_check_key->nextRow()) || (!$user_id = $qr_check_key->get("user_id"))) {
			$this->view->setVar("action", "reset_failure");
			$this->view->setVar("message",_t("Your password could not be reset"));
			$this->render('LoginReg/form_reset_html.php');
		}else{

			$password = $this->request->getParameter('password', pString);
			$password_confirm = $this->request->getParameter('password_confirm', pString);

			switch($action) {
				case 'reset_save':
					if(!$password || !$password_confirm){
						$this->view->setVar("message", _t("Please enter and re-type your password."));
						$action = "reset";
						break;
					}
					if ($password != $password_confirm) {
						$this->view->setVar("message", _t("Passwords do not match. Please try again."));
						$action = "reset";
						break;
					}
					
					if(strlen($password) < 4){
						$this->view->setVar("message", _t("Password must be at least 4 characters long."));
						$action = "reset";
						break;
					}
					$t_user = new ca_users();
					$t_user->purify(true);
					$t_user->load($user_id);
					# verify user exists with this e-mail address
					if ($t_user->getPrimaryKey()) {
						# user with e-mail already exists...
						$t_user->set("password", $password);
						$t_user->update();

						if ($t_user->numErrors()) {
							$this->notification->addNotification(join("; ", $t_user->getErrors()), __NOTIFICATION_TYPE_INFO__);
							$action = "reset_failure";
						} else {
							$action = "reset_success";
							$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
							# -- generate email subject
							$subject_line = $o_view->render("mailTemplates/notification_subject.tpl");

							# -- generate mail text from template - get both the html and text versions
							$mail_message_text = $o_view->render("mailTemplates/notification.tpl");
							$mail_message_html = $o_view->render("mailTemplates/notification_html.tpl");

							caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), $subject_line, $mail_message_text, $mail_message_html);
						}
						break;
					} else {
						$this->notification->addNotification(_t("Invalid user"), __NOTIFICATION_TYPE_INFO__);
						$action = "reset_failure";
					}
			}
			$this->view->setVar("action", $action);
			$this->render('LoginReg/form_reset_html.php');
		}
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	private function _validateGroup(string $group) : ca_user_groups {
		$group = preg_replace('![^A-Za-z0-9_]+!u', '', $group);
		if(!strlen($group)) {
			$this->view->setVar("message", _t("Group code is empty"));
			return false;
		}
		$t_user_group = null;
		if(is_numeric($group)) {
			$t_user_group = ca_user_groups::find(['group_id' => (int)$group, 'for_public_use' => 1], ['returnAs' => 'firstModelInstance']);
		} else {
			$t_user_group = ca_user_groups::find(['code' => (string)$group, 'for_public_use' => 1], ['returnAs' => 'firstModelInstance']);
		}
		if (!$t_user_group) {
			$this->view->setVar("message", _t("Group %1 is not valid", $group));
			return false;
		}
		return $t_user_group;
	}
	# -------------------------------------------------------
}
