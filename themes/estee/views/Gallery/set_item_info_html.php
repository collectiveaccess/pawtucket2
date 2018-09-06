<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
{{{<ifdef code="ca_objects.type_id"><H6>^ca_objects.type_id <ifdef code="ca_objects.archival_types">- ^ca_objects.archival_types</ifdef></H6></ifdef>}}}

{{{<ifdef code="ca_objects.brand|ca_objects.sub_brand"><H6>^ca_objects.brand<ifdef code="ca_objects.brand,ca_objects.sub_brand">, </ifdef>^ca_objects.sub_brand</H6></ifdef>}}}

<H4><?php print $this->getVar("label"); ?></H4>

{{{<ifdef code="ca_objects.manufacture_display_date|ca_objects.manufacture_date">^ca_objects.manufacture_display_date<ifdef code="ca_objects.manufacture_display_date,ca_objects.manufacture_date"> </ifdef>^ca_objects.manufacture_date</ifdef>}}}


<br/><br/><br/><div class="text-center"><?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?></div>