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
<h1><?php print _t("Member Map"); ?></H1>
<p>
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sodales elit dictum massa aliquam in tincidunt metus pellentesque. Maecenas posuere, lectus eu varius venenatis, eros augue mollis est, quis placerat nisi massa et est. Ut quis leo risus. Phasellus ac justo dolor, ut mattis felis. In commodo neque non urna cursus consequat. Curabitur viverra, lacus id rutrum laoreet, elit turpis condimentum nibh, ut fermentum erat tellus scelerisque turpis. Vestibulum faucibus, mauris ut facilisis ultricies, dui risus dapibus arcu, sit amet suscipit velit enim vitae justo. 
</p>
<div style="clear:both; margin-top:10px;">
	<?php print $this->getVar("map"); ?>
</div>