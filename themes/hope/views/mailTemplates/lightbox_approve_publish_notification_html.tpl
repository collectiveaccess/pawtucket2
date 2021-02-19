<?php
	$vs_set_name = $this->getVar("set");
	$ps_from_name = $this->getVar("from_name");
	$ps_from_email = $this->getVar("from_email");
	$vs_lightbox_displayname = $this->getVar("display_name");
	$vs_lightbox_displayname_plural = $this->getVar("display_name_plural");
	#$vs_share_message = $this->getVar("share_message");
	
	print "<p>Your Gallery: ".$vs_set_name.", has been published and is now available in the public Gallery section of ".$this->request->config->get("site_host").".</p>";

?>