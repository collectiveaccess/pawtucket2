<?php
	$t_object = $this->getVar("instance");
	
	$t_set_item = $this->getVar("set_item");
	$vs_set_item_description = $t_set_item->get("ca_set_items.preferred_labels");

?>
<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H2><?php print $this->getVar("label"); ?></H2>
<?php
	if($vs_set_item_description != "[BLANK]"){
		print "<div class='unit'>".$vs_set_item_description."</div>";
	}
	#Format, Date, Depicts, Photographer, Rights Holder
	if($vs_tmp = $t_object->getWithTemplate("
			<ifdef code='ca_objects.sourceDate'><div class='unit'><label>Date</label>^ca_objects.sourceDate</div></ifdef>
			<ifcount code='ca_entities' restrictToRelationshipTypes='depicts' min='1'><div class='unit'><label>Depicts</label><unit relativeTo='ca_entities' restrictToRelationshipTypes='depicts' delimiter=', '><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>
			<ifcount code='ca_entities' restrictToRelationshipTypes='photographer' min='1'><div class='unit trimText'><label>Photographer</label><unit relativeTo='ca_entities' restrictToRelationshipTypes='photographer' delimiter=', '><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>
			<ifcount code='ca_entities' restrictToRelationshipTypes='videographer' min='1'><div class='unit trimText'><label>Videographer</label><unit relativeTo='ca_entities' restrictToRelationshipTypes='videographer' delimiter=', '><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>
			<ifcount code='ca_entities' restrictToRelationshipTypes='rights_holder' min='1'><div class='unit trimText'><label>Rights Holder<ifcount code='ca_entities' restrictToRelationshipTypes='rights_holder' min='2'>s</ifcount></label><unit relativeTo='ca_entities' restrictToRelationshipTypes='rights_holder' delimiter=', '><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>")){
		print $vs_tmp;
	}		
?>


<?php print "<div class='unit text-center'>".caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id"))."</div>"; ?>