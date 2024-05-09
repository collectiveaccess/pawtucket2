<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/reg_admin_notification_html.tpl
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
 	$t_user = $this->getVar("t_user");
	print _t("<p>A new user, %1, has registered for \"%2\".</p>", trim($t_user->get("fname")." ".$t_user->get("lname")).", ".$t_user->get("email"), $this->request->config->get("app_display_name"));
	
	$va_profile_prefs = $t_user->getValidPreferences('profile');
	if(is_array($va_profile_prefs) && sizeof($va_profile_prefs)){
		foreach($va_profile_prefs as $profile_pref){
			if($t_user->getPreference($profile_pref)){
				switch($profile_pref){
					case "user_profile_type":
						print "<p>Are you a community member or researcher?: ".str_replace("_", " ", $t_user->getPreference($profile_pref))."</p>";
					break;
					# ------
					case "user_profile_community":
						print "<p>Community: ".$t_user->getPreference($profile_pref)."</p>";
					break;
				}
			}
		}
	}		
	
	if($this->request->config->get("dont_approve_logins_on_registration")){
		print _t("<p>Please login and navigate to Manage > Access Control to approve the registration.</p>");
	}
	
	print "<p>".$this->request->config->get("site_host")."</p>";
?>