<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/reg_conf_html.tpl
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
if($this->request->config->get("dont_approve_logins_on_registration")){
	$vs_active_message = _t("<p>Your account will be activated after review.</p>");
}

print _t("<p>Thank you for registering with the historical digital collections site of the Grand Rapids Public Library.</p>
<p>As a member, you can comment and tag items on the site. You can also create your own personal collections and share them with friends, family, and colleagues.</p>
<p>If you clip articles or content in newspapers or magazines, your clippings will be saved in your account on the My Clippings page. You can download your clippings to print them or save them to your own device.</p>
<p>Any comments or tags that you add will display your full name. If you would like to display initials or update your name, you can make those changes on your User Profile <a href='https://digital.grpl.org/LoginReg/profileForm'>page</a>.
<p>If you have any questions, send us an email at localhistory@grpl.org</p>
<p>Regards,</p>
<p>Grand Rapids History Center</p>
<p>Grand Rapids Public Library</p>
", $this->request->config->get("app_display_name"));

	print "<p>".$this->request->config->get("site_host")."</p>";
?>
