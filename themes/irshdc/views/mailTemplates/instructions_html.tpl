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

print _t("<p>We have received your request to reset your Residential School History and Dialogue Centre password.</p>
 
<p>To reset your password, click the following URL or copy and paste it into the address bar on your web browser:</p>
 
<p>%1</p>
 
<p>You will be asked to enter a new password. If you did not make a request for a new password, or if you require any assistance resetting it, please contact us at <a href='mailto:irshdc.reference@ubc.ca'>irshdc.reference@ubc.ca</a>.</p>
", $this->getVar("password_reset_url"));

print "<br/><br/><p><img src='".$this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'rshdc-promo-black.png')."'></p>";
?>