<?php
	$t_object = $this->getVar('item');
?>
<div style="float: right;">
<?php
	if ($this->request->isLoggedIn()) {
?>
	<a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'addItemForm', array("object_id" => $t_object->getPrimaryKey())); ?>"); return false;' ><?php print _t("Add to Lightbox"); ?></a>
	<br/>
<?php
	}
?>
</div>

<h1>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</h1>
<h2>{{{<unit>^ca_objects.type_id</unit>}}}</h2>


{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
<br/>


{{{<ifdef code="ca_objects.idno">Identifer: ^ca_objects.idno<br/></ifdef>}}}
{{{<ifdef code="ca_objects.containerID">Box/series: ^ca_objects.containerID<br/></ifdef>}}}

{{{<ifdef code="ca_objects.description">^ca_objects.description<br/></ifdef>}}}


{{{<ifdef code="ca_objects.dateSet.setDisplayValue">Date: ^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}

<p>
	{{{<ifcount code="ca_entities" min="1" max="1"><h3>Related person</h3></ifcount>}}}
	{{{<ifcount code="ca_entities" min="2"><h3>Related people</h3></ifcount>}}}
	{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
</p>


{{{<ifcount code="ca_objects.LcshNames" min="1"><h3>LC Terms</h3></ifcount>}}}
{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}