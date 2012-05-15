<?php
/* ----------------------------------------------------------------------
 * system/AuthController.php : user authentication
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
 	class AuthController extends ActionController {
 		# -------------------------------------------------------
		
 		# -------------------------------------------------------
 		function Login() {
 			$this->render('login_html.php');
 		}
 		# -------------------------------------------------------
 		function DoLogin() {
			if (!$this->request->doAuthentication(array('dont_redirect' => true, 'user_name' => $this->request->getParameter('username', pString), 'password' => $this->request->getParameter('password', pString)))) {
				$this->notification->addNotification(_t("Login was invalid"), __NOTIFICATION_TYPE_ERROR__);
 				$this->render('login_html.php');
			} else {
 				$this->notification->addNotification(_t("You are now logged in"), __NOTIFICATION_TYPE_INFO__);
				$this->render('welcome_html.php');
 			}
 		}
 		# -------------------------------------------------------
 		function Welcome() {
 			$this->render('welcome_html.php');
 		}
 		# -------------------------------------------------------
 		function Logout() {
 			$this->request->deauthenticate();
 			
 			$this->render('logged_out_html.php');
 			
 			$this->notification->addNotification(_t("You are now logged out"), __NOTIFICATION_TYPE_INFO__);
 		}
 		# -------------------------------------------------------
 	}
 ?>