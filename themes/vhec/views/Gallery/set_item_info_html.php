<?php 
$vn_set_item_id = $this->getVar("item_id");
$t_set_item = new ca_set_items($vn_set_item_id);

	print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; 

	if ($va_set_title = $t_set_item->get('ca_set_items.preferred_labels')) {
		print "<h4>".$va_set_title."</h4>";
	}
	if ($va_set_caption = $t_set_item->get('ca_set_items.caption')) {
		print "<div style='margin-bottom:20px;'>".$va_set_caption."</div>";
	}

?>



<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', 'ca_objects',  $this->getVar("object_id")); ?>