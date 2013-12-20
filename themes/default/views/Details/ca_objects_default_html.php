<div style="float: right;">
	{{{thumbnail}}}

	{{{ca_object_representations.media.small}}}
</div>

<h1>{{{ca_objects.preferred_labels.name}}}</h1>
<h2>{{{<unit>^ca_objects.type_id</unit>}}}</h2>
{{{<ifdef code="ca_objects.idno"><h3>Identifer: ^ca_objects.idno</h3></ifdef>}}}

{{{ca_objects.description}}}

<p>
	{{{<ifcount code="ca_entities" min="1"><h3>Related people ^</h3></ifcount>}}}
	{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
</p>
