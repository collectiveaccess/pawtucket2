<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4>
{{{<ifcount min="1" code="ca_objects.date"><h6 style='padding:0px 0px 30px 0px; margin-top:5px;'><unit delimiter="<br/>">^ca_objects.date</unit></h6></ifcount>}}}

{{{<ifdef code="ca_set_items.set_item_description">^ca_set_items.set_item_description<br/><br/></ifdef>}}}
<!--{{{<ifdef code="ca_objects.description">^ca_objects.description<br/><br/></ifdef>}}}-->

{{{<ifcount code="ca_entities" min="1" max="1"><b>Related person: </b></ifcount>}}}
{{{<ifcount code="ca_entities" min="2"><b>Related people: </b></ifcount>}}}
{{{<unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}


<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', $this->getVar("table"),  $this->getVar("row_id")); ?>