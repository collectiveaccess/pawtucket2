<?php
	print "<p>"._t("%1 has shared a record from %2 with you.  To view the record online visit %3.", $ps_from_name, $this->request->config->get("site_host"), $this->request->config->get("site_host").caNavUrl($this->request, 'Detail', 'Object', 'Show', array('object_id' => $pn_object_id)))."</p>";
	print "<hr/>";
	if($ps_message){
		print "<p><b>"._t("%1 wrote", $ps_from_name).":</b>";
		print "<blockquote>".str_replace("\n", "<br/>", $ps_message)."</blockquote>";
		print "</p>";
		print "<hr/>";
	}
	print "<p><b>"._t("Record Summary").":</b><blockquote>";
	print "<b>"._t("Title").":</b> ".$t_object->getLabelForDisplay()."<br/>";
	print "<b>"._t("Identifier").":</b> ".$t_object->get("idno")."<br/>";
	print "<b>"._t("URL").":</b> ".$this->request->config->get("site_host").caNavUrl($this->request, 'Detail', 'Object', 'Show', array('object_id' => $pn_object_id))."<br/>";
	
	if($this->request->config->get('ca_objects_description_attribute')){
		if($vs_description_text = $t_object->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))){
			print "<b>"._t("Description").":</b> ".$vs_description_text;
		}
	}
	print "</blockquote></p>";
?>