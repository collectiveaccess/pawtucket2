<?php
	$vs_set = $this->getVar("set");
	$ps_from_name = $this->getVar("from_name");
	$vs_lightbox_displayname = $this->getVar("display_name");
	$vs_lightbox_displayname_plural = $this->getVar("display_name_plural");
	
	print "<p>"._t("%1 has shared a %2 with you.  To view \"%3\" from %4, login to %5, and view your %6.", $ps_from_name, $vs_lightbox_displayname, $vs_set, $this->request->config->get("app_display_name"), $this->request->config->get("site_host"), ucfirst($vs_lightbox_displayname_plural))."</p>";
	
?>