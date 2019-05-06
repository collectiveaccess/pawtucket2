<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
{{{<ifdef code="ca_objects.preferred_labels.name"><H4><l>^ca_objects.preferred_labels.name</l></H4></ifdef>}}}

{{{<ifdef code="ca_objects.dateSet.displayDate"><h6>Date</h6>^ca_objects.dateSet.displayDate</ifdef>}}}

{{{<ifdef code="ca_objects.descriptionSet.descriptionText"><h6>Description</h6>^ca_objects.descriptionSet.descriptionText%truncate=500&ellipsis</ifdef>}}}

<br/><br/>
<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', 'ca_objects',  $this->getVar("object_id")); ?>