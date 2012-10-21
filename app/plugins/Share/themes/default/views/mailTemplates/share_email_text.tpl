<?php
	print _t("%1 has shared a record from %2 with you.  To view the record online visit %3.", $ps_from_name, $this->request->config->get("site_host"), $this->request->config->get("site_host").caNavUrl($this->request, 'Detail', $vs_controller, 'Show', array($t_item->PrimaryKey() => $pn_item_id)))."\n\n";
	if($ps_message){
		print _t("%1 wrote", $ps_from_name).":\n\n".$ps_message."\n\n\n";
	}
	print _t("Record Summary").":\n\n";
	print _t("Title").": ".$t_item->getLabelForDisplay()."\n";
	print _t("Identifier").": ".$t_item->get("idno")."\n";
	print _t("URL").": ".$this->request->config->get("site_host").caNavUrl($this->request, 'Detail', $vs_controller, 'Show', array($t_item->PrimaryKey() => $pn_item_id))."\n";
?>