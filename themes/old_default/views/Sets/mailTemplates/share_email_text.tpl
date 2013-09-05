<?php
	print _t("%1 has shared a slideshow from %2 with you.  To view the slideshow online visit %3.", $ps_from_name, $this->request->config->get("site_host"), $this->request->config->get("site_host").caNavUrl($this->request, '', 'Sets', 'Slideshow', array("set_id" => $pn_set_id)))."\n\n";
	if($ps_message){
		print _t("%1 wrote", $ps_from_name).":\n\n".$ps_message."\n\n\n";
	}
	print _t("Slideshow Summary").":\n\n";
	print _t("Title").": ".$t_set->getLabelForDisplay()."\n";
	print _t("URL").": ".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Sets', 'Slideshow', array("set_id" => $pn_set_id))."\n";
?>