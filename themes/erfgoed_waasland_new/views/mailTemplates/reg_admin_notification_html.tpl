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
	print _t("<p>Een nieuwe gebruiker, %1, heeft zich geregistreerd op de %2 met %3. </p>", trim($t_user->get("fname")." ".$t_user->get("lname")), $this->request->config->get("app_display_name"), $t_user->get("email"));
	if($this->request->config->get("dont_approve_logins_on_registration")){
		print _t("<p>Please login and navigate to Manage > Access Control to approve the registration.</p>");
	}
	print _t("<p>Met vriendelijke groet,<br/>Het Ergoedcel-team</p>");

	print "<p>".$this->request->config->get("site_host")."</p>";
?>