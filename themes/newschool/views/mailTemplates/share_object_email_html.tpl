<?php
	print "<p>"._t("%1 has shared a record from %2 with you.  To view the record online visit %3.", $ps_from_name, $this->request->config->get("site_host"), $this->request->config->get("site_host").caDetailUrl($this->request, $t_item->tableName(), $pn_item_id))."</p>";
	print "<hr/>";
	if($ps_message){
		print "<p><b>"._t("%1 wrote", $ps_from_name).":</b>";
		print "<blockquote>".str_replace("\n", "<br/>", $ps_message)."</blockquote>";
		print "</p>";
		print "<hr/>";
	}
	print "<p><b>"._t("Record Summary").":</b><blockquote>";
	print "<b>"._t("Title").":</b> ".$t_item->getLabelForDisplay()."<br/>";
	print "<b>"._t("Identifier").":</b> ".$t_item->get("idno")."<br/>";
	print "<b>"._t("URL").":</b> ".caDetailLink($this->request, $this->request->config->get("site_host").caDetailUrl($this->request, $t_item->tableName(), $pn_item_id), "", $t_item->tableName(), $pn_item_id)."<br/>";
	
	if($this->config->get('share_ca_objects_description_attribute')){
		if($vs_description_text = $t_item->get("ca_objects.".$this->config->get('share_ca_objects_description_attribute'))){
			print "<b>"._t("Description").":</b> ".$vs_description_text;
		}
	}
	print "</blockquote></p>";
?>