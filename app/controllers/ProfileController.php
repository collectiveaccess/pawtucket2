<?php
/* ----------------------------------------------------------------------
 * includes/ProfileController.php
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
 
 	require_once(__CA_LIB_DIR__."/core/Error.php");
	require_once(__CA_MODELS_DIR__."/ca_users.php");
 
 	class ProfileController extends ActionController {
 		# -------------------------------------------------------
 		function Edit() {
 			$t_user = $this->request->user;
 			
 			$this->view->setVar("fname", $t_user->htmlFormElement("fname","<div><b>"._t("First name")."</b><br/>^ELEMENT</div>"));
 			$this->view->setVar("lname", $t_user->htmlFormElement("lname","<div><b>"._t("Last name")."</b><br/>^ELEMENT</div>"));
 			$this->view->setVar("email", $t_user->htmlFormElement("email","<div><b>"._t("Email address")."</b><br/>^ELEMENT</div>"));
 			$this->view->setVar("password", $t_user->htmlFormElement("password","<div><b>"._t("Password (Leave blank to keep existing password)")."</b><br/>^ELEMENT</div>", array('value' => '')));
 			$this->view->setVar("password_confirm", '<div><b>Password confirm (Leave blank to keep existing password)</b><br><input name="password_confirm" value="" size="60" maxlength="100" autocomplete="off" type="password"></div>');
 			
 			$va_profile_prefs = $t_user->getValidPreferences('profile');
 			if (is_array($va_profile_prefs) && sizeof($va_profile_prefs)) {
 				$va_elements = array();
				foreach($va_profile_prefs as $vs_pref) {
					$va_pref_info = $t_user->getPreferenceInfo($vs_pref);
					$va_elements[$vs_pref] = array('element' => $t_user->preferenceHtmlFormElement($vs_pref), 'formatted_element' => $t_user->preferenceHtmlFormElement($vs_pref, "<div><b>".$va_pref_info['label']."</b><br/>^ELEMENT</div>"), 'info' => $va_pref_info, 'label' => $va_pref_info['label']);
				}
				
				$this->view->setVar("profile_settings", $va_elements);
			}
 			
 			$this->render('Profile/profile_html.php');
 		}
 		# -------------------------------------------------------
 		function Save() {
 			$t_user = $this->request->user;
			
			# --- process incoming registration attempt
			$ps_email = strip_tags($this->request->getParameter("email", pString));
			$ps_fname = strip_tags($this->request->getParameter("fname", pString));
			$ps_lname = strip_tags($this->request->getParameter("lname", pString));
			$ps_password = strip_tags($this->request->getParameter("password", pString));
			$ps_password_confirm = strip_tags($this->request->getParameter("password_confirm", pString));
			
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
			if($ps_password && ($ps_password != $ps_password_confirm)){
				$va_errors["password_confirm"] = _t("Please confirm your password");
				$va_errors["password"] = _t("Please re-enter your password");
			}
			
			// Check user profile responses
			$va_profile_prefs = $t_user->getValidPreferences('profile');
			if (is_array($va_profile_prefs) && sizeof($va_profile_prefs)) {
				foreach($va_profile_prefs as $vs_pref) {
					$vs_pref_value = $this->request->getParameter('pref_'.$vs_pref, pString);
					if (!$t_user->isValidPreferenceValue($vs_pref, $vs_pref_value, true)) {
						$va_errors[$vs_pref] = join("; ", $t_user->getErrors());
						
						$t_user->clearErrors();
					}
				}
			}
			
			# get names of form fields
			$va_fields = $t_user->getFormFields();

			# loop through fields
			foreach($va_fields as $vs_f => $va_attr) {
				switch($vs_f){
					case "user_name":
					case "active":
					case "userclass":
						# noop
						break;
					# -------------
					case "password":
						if(!$va_errors[$vs_f] && $_REQUEST[$vs_f]){
							$t_user->set($vs_f,$_REQUEST[$vs_f]); # set field values
							if ($t_user->numErrors() > 0) {
								$va_errors[$vs_f] = join("; ", $t_user->getErrors());
							}
						}
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
				$t_user->setMode(ACCESS_WRITE);
				$t_user->update();
				if($t_user->numErrors()) {
					$va_errors["register"] = join("; ", $t_user->getErrors());
					print $va_errors["register"];
				}else{
					$this->notification->addNotification(_t('Your profile has been updated.'), __NOTIFICATION_TYPE_INFO__);
				}
			}
			$this->view->setVar('errors', $va_errors);
			
			$this->Edit();
 		}
 		# -------------------------------------------------------
 	}
 ?>