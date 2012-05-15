<?php
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