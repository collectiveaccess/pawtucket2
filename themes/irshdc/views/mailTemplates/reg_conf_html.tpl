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
$t_user = $this->getVar("t_user");

print _t("<p>Thank you for creating an account with the Residential School History and Dialogue Centre records website.</p>
 
<p>Your account registration is confirmed and your username is %1. The URL for our home page is: %2. Access your account by clicking on the grey icon at the top right corner of the screen and selecting \"Login\" from the dropdown menu.</p> 
 
<p>If you would like support in your research, please contact us at <a href='mailto:irshdc.reference@ubc.ca'>irshdc.reference@ubc.ca</a>.</p>


", $t_user->get("ca_users.user_name"), $this->request->config->get("site_host"));


print "<br/><br/><p><img src='".$this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'rshdc-promo-black.png')."'></p>";
?>