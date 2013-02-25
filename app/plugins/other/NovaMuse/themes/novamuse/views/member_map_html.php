<?php
/* ----------------------------------------------------------------------
 * app/plugins/NovaStory/themes/novastory/views/member_map_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
 
	$va_members		= $this->getVar('member_institutions');
?>
<div id='pageBody'>
<h1><?php print _t("Contributor Map"); ?></H1>
<p class='textContent'>
	<?php print _t("Museums, interpretive centres, and archives from across Nova Scotia contribute to NovaMuse. Click on a pin to learn more about each institution."); ?> 
</p>
<div style="clear:both; margin-top:10px;">
	<?php print $this->getVar("map"); ?>
</div>
</div>