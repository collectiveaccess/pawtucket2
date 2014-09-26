<?php
	$vs_set = $this->getVar("set");
	$ps_from_name = $this->getVar("from_name");
	
	print _t("%1 has shared a lightbox with you.  To view \"%2\" from %3, login to %4, and view your Lightboxes.", $ps_from_name, $vs_set, $this->request->config->get("app_display_name"), $this->request->config->get("site_host"));
	
?>