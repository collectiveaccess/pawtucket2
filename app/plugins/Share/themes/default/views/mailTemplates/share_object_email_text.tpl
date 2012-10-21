<?php
	print _t("%1 has shared a record from %2 with you.  To view the record online visit %3.", $ps_from_name, $this->request->config->get("site_host"), $this->request->config->get("site_host").caNavUrl($this->request, 'Detail', 'Object', 'Show', array('object_id' => $pn_object_id)))."\n\n";
	if($ps_message){
		print _t("%1 wrote", $ps_from_name).":\n\n".$ps_message."\n\n\n";
	}
	print _t("Record Summary").":\n\n";
	print _t("Title").": ".$t_object->getLabelForDisplay()."\n";
	print _t("Identifier").": ".$t_object->get("idno")."\n";
	print _t("URL").": ".$this->request->config->get("site_host").caNavUrl($this->request, 'Detail', 'Object', 'Show', array('object_id' => $pn_object_id))."\n";
	
	if($this->request->config->get('ca_objects_description_attribute')){
		if($vs_description_text = $t_object->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))){
			print _t("Description").":\n".strip_tags($vs_description_text);
		}
	}
?>