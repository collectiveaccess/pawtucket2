<?php 
	$vn_set_id = $this->getVar("item_id");
	$t_set_item = new ca_set_items($vn_set_id);
	
	
	print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; 

?>
{{{<ifdef code="ca_objects.preferred_labels.name"><H4>^ca_objects.preferred_labels.name</H4></ifdef>}}}

<?php
	if ($va_set_caption = $t_set_item->get('ca_set_items.preferred_labels')) {
		if ($va_set_caption != "[BLANK]") {
			print "<div style='margin-bottom:10px;'>".$va_set_caption."</div>";
		}
	}
	if ($va_set_desc = $t_set_item->get('ca_set_items.set_item_description')) {
		print "<div><h6>Description</h6>".$va_set_desc."</div>";
	}	
?>
{{{<ifdef code="ca_objects.description">^ca_objects.description<br/><br/></ifdef>}}}
<hr>
{{{<ifcount code="ca_entities" min="1" max="1"><b>Related person: </b></ifcount>}}}
{{{<ifcount code="ca_entities" min="2"><b>Related people: </b></ifcount>}}}
{{{<unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}


<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', 'ca_objects',  $this->getVar("object_id")); ?>