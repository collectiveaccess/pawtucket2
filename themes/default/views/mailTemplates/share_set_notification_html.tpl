<?php
	$vs_set = $this->getVar("set");
	$ps_from_name = $this->getVar("from_name");
	$va_lightbox_display_name = caGetSetDisplayName();
	$vs_lightbox_display_name = $va_lightbox_display_name["singular"];
	$vs_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
	
	print "<p>"._t("%1 has shared a %2 with you.  To view \"%3\" from %4, login to %5, and view your %6.", $ps_from_name, $vs_lightbox_display_name, $vs_set, $this->request->config->get("app_display_name"), $this->request->config->get("site_host"), ucfirst($vs_lightbox_display_name_plural))."</p>";
	
?>