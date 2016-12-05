<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
{{{<ifdef code="ca_objects.preferred_labels.name"><H4>^ca_objects.preferred_labels.name</H4></ifdef>}}}

{{{<ifdef code="ca_objects.altId"><b>Identifer: </b>^ca_objects.altId<br/><br/></ifdef>}}}

{{{<ifdef code="ca_objects.photographyType"><b>SubType:</b> ^ca_objects.photographyType<br/><br/></ifdef>}}}
{{{<ifdef code="ca_objects.artType"><b>SubType:</b> ^ca_objects.artType<br/><br/></ifdef>}}}
{{{<ifdef code="ca_objects.audioFilmType"><b>SubType:</b> ^ca_objects.audioFilmType<br/><br/></ifdef>}}}
{{{<ifdef code="ca_objects.textualType"><b>SubType:</b> ^ca_objects.textualType<br/><br/></ifdef>}}}
{{{<ifdef code="ca_objects.toolType"><b>SubType:</b> ^ca_objects.toolType<br/><br/></ifdef>}}}
{{{<ifdef code="ca_objects.propType"><b>SubType:</b> ^ca_objects.propType<br/><br/></ifdef>}}}



{{{<ifcount code="ca_objects.technique" min="1"><b>Technique: </b><unit delimiter=", ">^ca_objects.technique</unit><br/><br/></ifcount>}}}
{{{<ifcount code="ca_objects.technique" min="1"><b>Technique: </b><unit delimiter=", ">^ca_objects.techniquePhoto</unit><br/><br/></ifcount>}}}

{{{<ifcount code="ca_objects.date.dates_value" min="1"><ifdef code="ca_objects.date.dates_value"><b>Date: </b></ifdef><unit delimiter="<br/>"><ifdef code="ca_objects.date.dates_value">^ca_objects.date.dates_value (^ca_objects.date.dc_dates_types)</ifdef></unit><ifdef code="ca_objects.date.dates_value"><br/><br/></ifdef></ifcount>}}}

{{{<ifdef code="ca_objects.description">^ca_objects.description<br/><br/></ifdef>}}}

{{{<ifcount code="ca_collections.preferred_labels" min="1"><b>Related Projects:</b> <unit relativeTo="ca_collections" delimiter=", "><l>^ca_collections.preferred_labels</l></unit><br/><br/></ifcount>}}}

<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', 'ca_objects',  $this->getVar("object_id")); ?>