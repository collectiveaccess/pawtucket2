<div style="float: right;">
	{{{ca_object_representations.media.small}}}
</div>

<h1>{{{ca_entities.preferred_labels.displayname}}}</h1>
<h2>{{{<unit>^ca_entities.type_id</unit>}}}</h2>
{{{<ifdef code="ca_entities.idno"><h3>Identifer: ^ca_entities.idno</h3></ifdef>}}}

{{{ca_entities.notes}}}

<p>
	{{{<ifcount code="ca_objects" min="1" max="1"><h3>Related object</h3></ifcount>}}}
	{{{<ifcount code="ca_objects" min="2"><h3>Related objects</h3></ifcount>}}}
	{{{<unit relativeTo="ca_objects" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l> (^ca_objects.idno)</unit>}}}
</p>
