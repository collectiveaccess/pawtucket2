<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")"; ?>
{{{<ifdef code="ca_objects.preferred_labels.name"><H2>^ca_objects.preferred_labels.name</H2></ifdef>}}}

{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifer</label>^ca_objects.idno</div></ifdef>}}}

{{{<ifdef code="ca_objects.description"><div class="unit">^ca_objects.description.description_text</div></ifdef>}}}

{{{<ifcount code="ca_entitines" min="1"><div class="unit">
	<ifcount code="ca_entities" min="1" max="1"><label>Related Person</label></ifcount>
	<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>
	<unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit>
</div></ifcount>}}}


<?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', 'ca_objects',  $this->getVar("object_id")); ?>
