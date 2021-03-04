<?php
	$t_set_item = $this->getVar("set_item");
	print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>";
?>
<H2><?php print $this->getVar("label"); ?></H2>


<?php
	if(($vs_set_item_text = $t_set_item->get("ca_set_items.preferred_labels")) && ($vs_set_item_text != "[BLANK]")){
		print "<p>".$vs_set_item_text."</p>";
	}
?>

<br/><div><?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?></div>