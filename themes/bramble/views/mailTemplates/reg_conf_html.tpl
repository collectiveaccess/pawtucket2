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

print _t("<p>Welcome to \"%1\". ".$vs_active_message."</p>

<p>Bramble offers plant professionals logical search mechanisms in an uncluttered interface to assist in finding the right plant for a particular place. We want your individual creativity to flourish: our aim is to provide you with a clean interface, letting you navigate the design process without unnecessary suggestions or interruption in workflow. With Bramble, you can easily select plants to combine into palettes, which in turn can be used as design tools and to create custom presentation pages allowing effective communication with your clients.</p>

", $this->request->config->get("app_display_name"));

	print "<p>".$this->request->config->get("site_host")."</p>";
?>