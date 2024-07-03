<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/notification_html.tpl
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

print _t("<p>Your Residential School History and Dialogue Centre account password was reset on %1/%2. You will now be able to login with your new password at https://collections.irshdc.ubc.ca.</p>
 
<p>If you did not reset your password, or if you require further assistance, please contact us at <a href='mailto:irshdc.reference@ubc.ca'>irshdc.reference@ubc.ca</a>.</p>

", date("F j, Y"), date("G:i"));

print "<br/><br/><p><img src='".$this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'rshdc-promo-black.png')."'></p>";
?>