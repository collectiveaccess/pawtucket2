<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/reg_conf_html.tpl
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
require(__CA_THEME_DIR__."/views/mailTemplates/settings.php"); 

$active_message = $this->request->config->get("dont_approve_logins_on_registration") ? _t("Your account will be activated after review.") : _t("Thank you for registering!");
?>
<p style="font-family: <?= $font; ?>; color: <?= $font_color; ?>; font-size: 24px; font-weight: bold; padding-top: 30px;"><?= $active_message; ?></p>

<p style="font-family: <?= $font; ?>; color: <?= $font_color; ?>; font-size: 15px;">As a registered user you can comment on items, assemble your own lightboxes and view lightboxes shared with you.</p>