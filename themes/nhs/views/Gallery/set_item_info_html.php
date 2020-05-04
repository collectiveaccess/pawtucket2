<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4>

{{{<ifdef code="ca_objects.date.dates_value"><H6>Date:</H6><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.date.dates_value</unit><br/><br/></ifdef>}}}
{{{<ifdef code="ca_objects.description">^ca_objects.description<br/><br/></ifdef>}}}

<div class="text-center"><?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?></div>