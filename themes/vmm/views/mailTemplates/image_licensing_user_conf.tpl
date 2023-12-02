<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/contact.tpl
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2014 Whirl-i-Gig
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

$vs_site_host = $this->request->config->get("site_host");
	
print _t("You have submitted an Image Licensing / Reproduction Request to %1.", $this->request->config->get("app_display_name"));
?>
	/n/nArchive staff will respond to your inquiry soon.  If you have any questions, please contact archives@vanmaritime.com
	/n/nFor your records, you will find a PDF copy of your request attached to this email.

<?php print "/n/n/n/n".$this->request->config->get("site_host"); ?>	
