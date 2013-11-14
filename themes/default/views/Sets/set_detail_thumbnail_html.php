<?php
	$va_set_items = $this->getVar("set_items");
	$t_set = $this->getVar("set");
	print "<div style='clear:left;'>".$t_set->get("ca_sets.preferred_labels.name")."</div>";
	if(sizeof($va_set_items)){
		foreach($va_set_items as $va_set_item){
			print "<div style='width:180px; height:275px; border:1px solid #666666; float:left; margin:5px;'>";
			print $va_set_item["representation_tag_preview"]."<br/>";
			print $va_set_item["set_item_label"];
			print "</div>";
		}
	}else{
		print "<div>No items in set</div>";
	}
?>