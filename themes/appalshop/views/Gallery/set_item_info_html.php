<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4>

{{{<ifdef code="ca_objects.idno"><H6>Identifer</H6>^ca_objects.idno<br/><br/></ifdef>}}}

{{{<ifdef code="ca_objects.description_w_type.description"><p>^ca_objects.description_w_type.description</p><br/><br/></ifdef>}}}
<?php print caDetailLink($this->request, _t("<span class='btn-default'>VIEW RECORD</span>"), '', $this->getVar("table"),  $this->getVar("row_id")); ?>
<br/><br/>
{{{<ifcount code="ca_entities" min="1" max="1"><h6>Related person </h6></ifcount>}}}
{{{<ifcount code="ca_entities" min="2"><h6>Related people </h6></ifcount>}}}
{{{<p><unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></p>}}}


