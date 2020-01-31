<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/instructions.tpl
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
 
print _t("We have received your request to reset your Residential School History and Dialogue Centre password.
 
To reset your password, click the following URL or copy and paste it into the address bar on your web browser:
 
%1
 
You will be asked to enter a new password. If you did not make a request for a new password, or if you require any assistance resetting it, please contact us at <a href='mailto:irshdc.reference@ubc.ca'>irshdc.reference@ubc.ca</a>.
", $this->getVar("password_reset_url"));
?>