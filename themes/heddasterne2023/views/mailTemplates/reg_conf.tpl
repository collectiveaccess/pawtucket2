<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/reg_conf.tpl
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
	$vs_active_message = _t("Your account will be activated after review.");
}
print _t("Thank you for registering for \"%1\". ".$vs_active_message."

As a member you can rank, comment and tag items on the site.  You can also create your own sets from the collection and share your slide-shows with friends and colleagues.

Regards,
the Staff

", $this->request->config->get("app_display_name"));

	print $this->request->config->get("site_host");
?>