<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/contact_html.tpl
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
 
print "<p>"._t("You have been sent a contact email from \"%1\", %2.", $this->request->config->get("app_display_name"), $this->request->config->get("site_host"))."</p>";
$va_fields = $this->getVar("contact_form_elements");
foreach($va_fields as $vs_element => $va_options){
	if($this->request->getParameter($vs_element, pString)){
		print "<p><b>".$va_options["label"].":</b> ".$this->request->getParameter($vs_element, pString)."</p>";
	}
}

?>