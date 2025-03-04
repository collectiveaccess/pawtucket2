<?php
/* ----------------------------------------------------------------------
 * app/controllers/system/PreferencesController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008 Whirl-i-Gig
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
 
 require_once(__CA_MODELS_DIR__."/ca_users.php");
 
 	class PreferencesController extends ActionController {
 		# -------------------------------------------------------
		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 		}
 		# -------------------------------------------------------
 		public function EditProfilePrefs() {
 			$this->view->setVar('t_user', $this->request->user);
 			
 			foreach(array('fname', 'lname', 'email') as $vs_pref) {
 				if (!$this->request->user->getPreference($vs_pref)) {
 					$this->request->user->setPreference($vs_pref, $this->request->user->get($vs_pref));
 				}
 			}
 			$this->render('preferences_html.php');
 		}
 		# -------------------------------------------------------
 		public function Save() {
 			$t_user = $this->request->user;
 			$vs_action = $this->request->getParameter('action', pString);
 		
 			switch($vs_action) {
 				default:
 				case 'EditProfilePrefs':
 					$vs_password = $this->request->getParameter('password', pString);
 					$vs_password_confirm = $this->request->getParameter('password_confirm', pString);
 					
 					if (($vs_password != $vs_password_confirm) && ($vs_password)) {
 						// passwords don't match
 						$this->notification->addNotification(_t("Could not save your changes because an error occurred: <em>passwords don't match</em>"), __NOTIFICATION_TYPE_ERROR__);	
 					} else {
 						$t_user->setMode(ACCESS_WRITE);
 						foreach(array('fname', 'lname', 'email') as $vs_field) {
 							$t_user->set($vs_field, $this->request->getParameter($vs_field, pString));
 						}
 						
 							$t_user->set('user_name', $this->request->getParameter('email', pString));
 						
 						if ($vs_password) {
 							$t_user->set('password', $this->request->getParameter('password', pString));
 						}
 						 						
 						if(!sizeof($va_errors)){
 							$t_user->update();
 						
							if ($t_user->numErrors()) {
								$this->notification->addNotification(_t("Could not save your changes because an error occurred: <em>%1</em>", join('; ', $t_user->getErrors())), __NOTIFICATION_TYPE_ERROR__);	
							} else {
								$this->notification->addNotification(_t("Saved new profile settings"), __NOTIFICATION_TYPE_INFO__);	
							}
						}else{
							$this->notification->addNotification(_t("Please complete all key fields before saving."), __NOTIFICATION_TYPE_ERROR__);	
							$this->view->setVar('reg_errors', $va_errors);
						}
 					} 
 					break;
 			}
 			
 			
 			$this->request->setAction($vs_action);
 			
 		
 			$this->EditProfilePrefs();
 		}
 		# -------------------------------------------------------
 	}
 ?>
