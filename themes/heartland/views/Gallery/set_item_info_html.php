<?php 
	$t_set_item = $this->getVar("set_item");
?>
<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H2><?php print $this->getVar("label"); ?></H2>

<?php
	if(($vs_set_caption = $t_set_item->get("ca_set_items.preferred_labels")) && $vs_set_caption != "[BLANK]"){
		print "<p>".$vs_set_caption."</p>";
	}
?>

{{{<ifdef code="ca_objects.idno"><label>Identifer</label>^ca_objects.idno<br/><br/></ifdef>}}}
{{{<ifdef code="ca_objects.date_created"><label>Date</label>^ca_objects.date_created<br/><br/></ifdef>}}}

{{{<ifdef code="ca_objects.description"><label>Description</label>^ca_objects.description<br/><br/></ifdef>}}}


<?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?>