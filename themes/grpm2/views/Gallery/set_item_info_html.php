<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
{{{<ifdef code="ca_objects.preferred_labels.name"><H4>^ca_objects.preferred_labels.name</H4></ifdef>}}}

{{{<ifdef code="ca_objects.idno"><H6>Identifier:</H6>^ca_objects.idno<br/></ifdef>}}}

{{{<ifdef code="ca_objects.date"><H6>Date:</H6>^ca_objects.date<br/><br/></ifdef>}}}

{{{<ifdef code="ca_objects.description"><div class="capHeightScroll">^ca_objects.description</div><br/><br/></ifdef>}}}

{{{<ifcount code="ca_entities" min="1" max="1"><b>Related person: </b></ifcount>}}}
{{{<ifcount code="ca_entities" min="2"><b>Related people: </b></ifcount>}}}
{{{<unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}


<div class="text-center">
<?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn-default', 'ca_objects',  $this->getVar("object_id")); ?>
</div>
