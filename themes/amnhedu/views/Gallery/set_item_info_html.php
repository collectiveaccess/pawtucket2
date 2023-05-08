<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4><br/>

{{{<ifdef code="ca_objects.idno"><p><b>Identifer: </b>^ca_objects.idno<br/></ifdef>}}}

{{{<ifdef code="ca_objects.description">^ca_objects.description<br/><br/></ifdef>}}}
{{{<ifdef code="ca_objects.restrictions"><p><b>Restrictions: </b>^ca_objects.restrictions<br/></p></ifdef>}}}				
{{{<ifdef code="ca_objects.rights_restrictions"><p><b>Rights & Restrictions: </b>^ca_objects.rights_restrictions<br/></p></ifdef>}}}				
<br/>


<?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?>