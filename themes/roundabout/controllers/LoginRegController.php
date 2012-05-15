<?php
/* ----------------------------------------------------------------------
 * includes/LoginRegController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
	require_once(__CA_MODELS_DIR__."/ca_users.php");
 
 	class LoginRegController extends ActionController {
 		# -------------------------------------------------------
 		function form($t_user = "") {
 			if ($vs_last_page = $this->request->getParameter("site_last_page", pString)) { # --- last_page is passed as "Sets" if was trying to add an image to set
				$this->request->session->setVar('site_last_page', $vs_last_page);
				$this->request->session->setVar('site_last_page_object_id', $this->request->getParameter("object_id", pInteger));
			}
 			
 			if(!is_object($t_user)){
 				$t_user = new ca_users();
 			}
 			$this->view->setVar("fname", $t_user->htmlFormElement("fname","<div><b>"._t("First name")."</b><br/>^ELEMENT</div>"));
 			$this->view->setVar("lname", $t_user->htmlFormElement("lname","<div><b>"._t("Last name")."</b><br/>^ELEMENT</div>"));
 			$this->view->setVar("email", $t_user->htmlFormElement("email","<div><b>"._t("Email address")."</b><br/>^ELEMENT</div>"));
 			$this->view->setVar("password", $t_user->htmlFormElement("password","<div><b>"._t("Password")."</b><br/>^ELEMENT</div>", array('value' => '')));
 			
 			$this->render('LoginReg/loginreg_html.php');
 		}
 		# -------------------------------------------------------
 		function login() {
			$t_user = new ca_users();
			# --- pass form elements for reg form
			$this->view->setVar("fname", $t_user->htmlFormElement("fname","<div><b>"._t("First name")."</b><br/>^ELEMENT</div>"));
 			$this->view->setVar("lname", $t_user->htmlFormElement("lname","<div><b>"._t("Last name")."</b><br/>^ELEMENT</div>"));
 			$this->view->setVar("email", $t_user->htmlFormElement("email","<div><b>"._t("Email address")."</b><br/>^ELEMENT</div>"));
 			$this->view->setVar("password", $t_user->htmlFormElement("password","<div><b>"._t("Password")."</b><br/>^ELEMENT</div>"));
 			
			if (!$this->request->doAuthentication(array('dont_redirect' => true, 'user_name' => $this->request->getParameter('username', pString), 'password' => $this->request->getParameter('password', pString)))) {
				$this->view->setVar('loginMessage', _t("Login failed. Please try again."));
 				$this->form($t_user);
			} else {
 				if($this->request->isLoggedIn()){
					# --- login successful so redirect to search page
 					$this->notification->addNotification(_t("You are now logged in"), __NOTIFICATION_TYPE_INFO__);
				
					$vo_session = $this->request->getSession();
					$vs_last_page = $vo_session->getVar('site_last_page');
					$vo_session->setVar('site_last_page', "");
					
					switch($vs_last_page){
						case "Sets":
							$this->response->setRedirect(caNavUrl($this->request, "", "Sets", "addItem", array("object_id" => $vo_session->getVar('site_last_page_object_id'))));
						break;
						# --------------------
						case "ObjectDetail":
							$this->response->setRedirect(caNavUrl($this->request, "Detail", "Object", "Show", array("object_id" => $vo_session->getVar('site_last_page_object_id'))));
						break;
						# --------------------
						default:
							if (!($vs_url = $this->request->session->getVar('pawtucket2_last_page'))) {
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
							} 
							$this->response->setRedirect($vs_url);
						break;
						# --------------------
					}
				} else {
					$va_errors["register"] = _t("Login failed.");
				}
				return;
			}
 		}
 		# -------------------------------------------------------
 		function Logout() {
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
			
			$this->form($t_user);
 		}
 		# -------------------------------------------------------
 		function register() {
 			# logout user in case is already logged in
			$this->request->deauthenticate();
			
			$t_user = new ca_users();
			
			# --- process incoming registration attempt
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
			
			
			//if (!sizeof($va_errors)) {
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
			//}

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
					# --- send email confirmation
					# -- generate mail text from template
					ob_start();
					require($this->request->getViewsDirectoryPath()."/mailTemplates/reg_conf.tpl");
						
					$vs_mail_message = ob_get_contents(); 
					ob_end_clean();
					caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), "[".$this->request->config->get("app_display_name")."] "._t("Thank you for registering!"), $vs_mail_message);

					$t_user = new ca_users();
					# log in the new user
					$this->request->doAuthentication(array('dont_redirect' => true, 'user_name' => $ps_email, 'password' => $ps_password));
			
					if($this->request->isLoggedIn()){
						# --- login successful so redirect to search page
						$this->notification->addNotification(_t('Thank you for registering!  You are now logged in.'), __NOTIFICATION_TYPE_INFO__);
						$vo_session = $this->request->getSession();
						$vs_last_page = $vo_session->getVar('site_last_page');
						$vo_session->setVar('site_last_page', "");
						
						switch($vs_last_page){
							case "Sets":
								$this->response->setRedirect(caNavUrl($this->request, "", "Sets", "addItem", array("object_id" => $vo_session->getVar('site_last_page_object_id'))));
							break;
							# --------------------
							case "ObjectDetail":
								$this->response->setRedirect(caNavUrl($this->request, "Detail", "Object", "Show", array("object_id" => $vo_session->getVar('site_last_page_object_id'))));
							break;
							# --------------------
							default:
								$this->response->setRedirect(caNavUrl($this->request, "", "", ""));
							break;
							# --------------------
						}
					}else{
						$va_errors["register"] = _t("Login failed.");
					}
				}
			}else{
				$this->view->setVar('reg_errors', $va_errors);
			}
			
			$this->form($t_user);
 		}
 		# -------------------------------------------------------
 		function resetSend(){
 			$t_user = new ca_users();
 			
			$vs_message = "";
			$va_errors = array();
			$ps_email = $this->request->getParameter('reset_email', pString);
			if (!caCheckEmailAddress($ps_email)) {
				$this->view->setVar("reset_email_error",_t("E-mail address is not valid"));
				$this->view->setVar("resetFormOpen", 1);
				$this->form($t_user);
			}else{
			
				$t_user->setErrorOutput(0);
				$t_user->load(array("user_name" => $ps_email));
				# verify user exists with this e-mail address
				if ($t_user->getPrimaryKey()) {
					# user with e-mail does exists...
					
					if (sizeof($va_errors) == 0) {	
						$vs_reset_key = md5($t_user->get("user_id").'/'.$t_user->get("password"));
						
						# -- generate mail text from template
						ob_start();
						#$vs_password_reset_url = $this->request->config->get("site_host")."/exhibit/index.php/LoginReg/resetSave/action/reset/key/".$vs_reset_key."/";
						$vs_action = "reset";
						$vs_password_reset_url = $this->request->config->get("site_host").caNavUrl($this->request, '', 'LoginReg', 'resetSave', array('key' => $vs_reset_key));
						require($this->request->getViewsDirectoryPath()."/mailTemplates/instructions.tpl");
							
						$vs_mail_message = ob_get_contents(); 
						ob_end_clean();
						
						caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), "[".$this->request->config->get("app_display_name")."] "._t("Resetting your site password"), $vs_mail_message);
						
						$this->view->setVar("email", $this->request->config->get("ca_admin_email"));
						$this->view->setVar("action", "send");
						$this->render('LoginReg/resetpw_html.php');
					}
				} else {
					$this->view->setVar("reset_email_error",_t("E-mail address is not valid"));
					$this->view->setVar("resetFormOpen", 1);
					$this->form($t_user);
				}
 			}
 		}
 		# -------------------------------------------------------
 		function resetSave(){
			$ps_action = $this->request->getParameter('action', pString);
			
			$ps_key = $this->request->getParameter('key', pString);
			$ps_key = preg_replace("/[^A-Za-z0-9]+/", "", $ps_key);
			$this->view->setVar("key", $ps_key);
			
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
				$this->render('LoginReg/resetpw_html.php');
			}else{
			
				$ps_password = $this->request->getParameter('password', pString);
				$ps_password_confirm = $this->request->getParameter('password_confirm', pString);
				
				switch($ps_action) {
					case 'reset_save':
						if(!$ps_password || !$ps_password_confirm){
							$this->view->setVar("password_error", _t("Please enter and re-type your password."));
							$ps_action = "reset";
							break;
						}
						if ($ps_password != $ps_password_confirm) {
							$this->view->setVar("password_error", _t("Passwords do not match. Please try again."));
							$ps_action = "reset";
							break;
						}
						$t_user = new ca_users();
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
								
								# -- generate mail text from template
								ob_start();
								require($this->request->getViewsDirectoryPath()."/mailTemplates/notification.tpl");
									
								$vs_mail_message = ob_get_contents(); 
								ob_end_clean();
								caSendmail($t_user->get('email'), $this->request->config->get("ca_admin_email"), "[".$this->request->config->get("app_display_name")."] "._t("Your password has been reset"), $vs_mail_message);
							}
							break;
						} else {
							$this->notification->addNotification(_t("Invalid user"), __NOTIFICATION_TYPE_INFO__);
							$ps_action = "reset_failure";
						}
				}
				$this->view->setVar("action", $ps_action);
				$this->render('LoginReg/resetpw_html.php');
			} 		
 		}
 		# -------------------------------------------------------
 	}
 ?>