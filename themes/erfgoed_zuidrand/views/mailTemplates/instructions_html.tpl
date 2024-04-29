<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/instructions_html.tpl
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

print _t("<p>Om jouw paswoord te wijzigen, kopieer en plak de volgende URL in de webbrowser</p>");

print "<p>".$this->getVar("password_reset_url")."</p>";

print _t("<p>Je wordt gevraagd een nieuw wachtwoord aan te maken. Als je nog steeds problemen ondervindt, of wanneer je geen mail hebt ontvangen, gelieve %1 te contacteren.</p>

<p>Met vriendelijke groet,<br/>

Erfgoedcel Zuidrand</p>
", $this->request->config->get("ca_admin_email"));


	print $this->request->config->get("site_host");
?>