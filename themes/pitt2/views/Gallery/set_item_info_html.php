<?php 

$vn_set_item_id = $this->getVar("item_id");
$t_set_item = new ca_set_items($vn_set_item_id);


#print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; 


if ($vs_item_title = $t_set_item->get('ca_set_items.preferred_labels')){
	print "<h2>".$vs_item_title."</h2>";
}
if ($vs_item_desc = $t_set_item->get('ca_set_items.set_item_description')){
	print "<div class='setItemDescription'>".$vs_item_desc."</div>";
}
?>

<?php #print caDetailLink($this->request, _t("VIEW RECORD"), '', 'ca_objects',  $this->getVar("object_id")); ?>