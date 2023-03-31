<!--<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>-->

<H4><!--<?php print $this->getVar("label"); ?>-->
<?php 

$pn_item_id = $this->getVar("item_id");
$t_set_item = new ca_set_items($pn_item_id);
print $t_set_item->get("preferred_labels");

?>
</H4>
<?php 

$pn_item_id = $this->getVar("item_id");
$t_set_item = new ca_set_items($pn_item_id);
print "<span id='set_item_description'>".$t_set_item->get("set_item_description")."</span><br/><br/>";
print "<script>$('a').attr('target', '_blank');</script>";
?>

<!--
{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/><br/></ifdef>}}}

{{{<ifdef code="ca_objects.description">^ca_objects.description<br/><br/></ifdef>}}}

{{{<ifcount code="ca_entities" min="1" max="1"><b>Related person: </b></ifcount>}}}
{{{<ifcount code="ca_entities" min="2"><b>Related people: </b></ifcount>}}}
{{{<unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}

-->

<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', $this->getVar("table"),  $this->getVar("row_id")); ?>
