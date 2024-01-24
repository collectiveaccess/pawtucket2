<?php
	$t_set_item = $this->getVar("set_item");
	$t_item = $this->getVar("item");
	print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>";
	
	if($this->getVar("table") == "ca_entities"){
?>
		<H2>{{{^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname}}}</H2>
<?php		
	}else{	
?>
<H2><?php print $this->getVar("label"); ?></H2>


<?php
	}
	if(($vs_set_item_text = $t_set_item->get("ca_set_items.preferred_labels")) && ($vs_set_item_text != "[BLANK]")){
		print "<p>".$vs_set_item_text."</p>";
	}
?>

<br/><div><?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?></div>