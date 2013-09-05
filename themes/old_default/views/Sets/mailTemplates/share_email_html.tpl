<?php
	print "<p>"._t("%1 has shared a slideshow from %2 with you.  To view the slideshow online visit %3.", $ps_from_name, $this->request->config->get("site_host"), $this->request->config->get("site_host").caNavUrl($this->request, '', 'Sets', 'Slideshow', array("set_id" => $pn_set_id)))."</p>";
	print "<hr/>";
	if($ps_message){
		print "<p><b>"._t("%1 wrote", $ps_from_name).":</b>";
		print "<blockquote>".str_replace("\n", "<br/>", $ps_message)."</blockquote>";
		print "</p>";
		print "<hr/>";
	}
	print "<p><b>"._t("Slideshow Summary").":</b><blockquote>";
	print "<b>"._t("Title").":</b> ".$t_set->getLabelForDisplay()."<br/>";
	print "<b>"._t("URL").":</b> ".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Sets', 'Slideshow', array("set_id" => $pn_set_id));
	print "</blockquote></p>";
?>