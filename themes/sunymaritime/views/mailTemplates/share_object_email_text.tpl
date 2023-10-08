<?php
	$t_item = $this->getVar("item");
	$pn_item_id = $this->getVar("item_id");
	$ps_from_name = $this->getVar("from_name");
	$ps_message = $this->getVar("message");
	$o_detailConfig = $this->getVar("detailConfig");
	
	print _t("%1 has shared a record from %2 with you.  To view the record online visit %3.", $ps_from_name, $this->request->config->get("site_host"), $this->request->config->get("site_host").caDetailUrl($this->request, $t_item->tableName(), $pn_item_id))."\n\n";
	if($ps_message){
		print _t("%1 wrote", $ps_from_name).":\n\n".$ps_message."\n\n\n";
	}
	print _t("Record Summary").":\n\n";
	print _t("Title").": ".$t_item->getLabelForDisplay()."\n";
	print _t("Identifier").": ".$t_item->get("idno")."\n";
	print _t("URL").": ".caDetailLink($this->request, $this->request->config->get("site_host").caDetailUrl($this->request, $t_item->tableName(), $pn_item_id), "", $t_item->tableName(), $pn_item_id)."\n";
	
	if($o_detailConfig->get('share_ca_objects_description_attribute')){
		if($vs_description_text = $t_item->get("ca_objects.".$o_detailConfig->get('share_ca_objects_description_attribute'))){
			print _t("Description").":\n".strip_tags($vs_description_text);
		}
	}
?>