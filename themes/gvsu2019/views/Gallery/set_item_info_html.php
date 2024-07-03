<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4>

{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno</ifdef>}}}

{{{<ifdef code="ca_objects.work_description"><h6>Description:</h6>^ca_objects.work_description</ifdef>}}}

{{{<ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="creator,attributor"><h6>Artist: </h6></ifcount>}}}
{{{<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="creator,attributor"><h6>Artists: </h6></ifcount>}}}
{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="creator,attributor"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}

<br/><br/><?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?>
