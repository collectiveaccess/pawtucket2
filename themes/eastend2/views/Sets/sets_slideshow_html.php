<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Sets/sets_slideshow_html.php : 
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
 
	$t_set = $this->getVar('t_set');
	$vn_set_id = $this->getVar('set_id');
?>
<div id="contentArea">
	<h1><?php print _t("Slideshow").": ".caNavLink($this->request, $t_set->getLabelForDisplay(), '', '', 'Sets', 'index', array()); ?></h1>
	<div id="slideshow_player">
		<h1><?php print _t('You must have the Flash Plug-in version 9.0.0 or better installed to play slideshows'); ?></h1>
		<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
	</div>
		
	<script type="text/javascript">
		jQuery(document).ready(function() { swfobject.embedSWF(
			"/viewers/apps/Slideshow.swf", "slideshow_player", "900", "600", "9.0.0", "swf/expressInstall.swf", 
			{'data' : '<?php print caNavUrl($this->request, '', 'Sets', 'getSetXML', array('set_id' => $vn_set_id)); ?>?_isFlex=1'}, {'allowscriptaccess': 'always', 'allowfullscreen' : 'true', 'allowNetworking' : 'all'}); }
		);
	</script>
</div>