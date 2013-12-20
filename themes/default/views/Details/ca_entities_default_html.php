<div style="float: right;">
	{{{ca_object_representations.media.small}}}
</div>

<h1>{{{ca_entities.preferred_labels.displayname}}}</h1>
<h2>{{{<unit>^ca_entities.type_id</unit>}}}</h2>
{{{<ifdef code="ca_entities.idno"><h3>Identifer: ^ca_entities.idno</h3></ifdef>}}}

{{{ca_entities.notes}}}

<p>
	{{{<ifdef code="ca_objects"><h3>Related objects ^</h3></ifdef>}}}
	{{{<unit relativeTo="ca_objects" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l> (^ca_objects.idno)</unit>}}}
</p>
