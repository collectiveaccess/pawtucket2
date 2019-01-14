<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4>

{{{<ifdef code="ca_objects.idno"><H6>Accession Number:</H6>^ca_objects.idno<br/><br/></ifdef>}}}

{{{<ifdef code="ca_objects.description">^ca_objects.description<br/><br/></ifdef>}}}



<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', $this->getVar("table"),  $this->getVar("row_id")); ?>