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
	$vs_active_message = _t("Your account will be activated after review.");
}

print "Bedankt om u te registreren op de Erfgoedbank Waasland. ".$vs_active_message."

Als lid van de Erfgoedbank Waasland kan u reageren op foto's, audio- en filmfragmenten. U kan ook een eigen album samenstellen met zelf gekozen (audio)visueel materiaal.
";

	print "met vriendelijke groet, 
			Het Erfgoedcel-team
			waaserfgoed.be";
?>