<div style="float: right;">
	{{{ca_object_representations.media.small}}}
</div>

<h1>{{{<l>^ca_collections.preferred_labels.name</l>}}}</h1>
<h2>{{{<unit>^ca_collections.type_id</unit>}}}</h2>



{{{<ifdef code="ca_collections.idno">Identifer: ^ca_collections.idno<br/></ifdef>}}}
{{{<ifdef code="ca_objects.containerID">Box/series: ^ca_objects.containerID<br/></ifdef>}}}
<p>
	{{{<ifcount code="ca_entities" min="1" max="1"><h3>Related person</h3></ifcount>}}}
	{{{<ifcount code="ca_entities" min="2"><h3>Related people</h3></ifcount>}}}
	{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
</p>

<p>
	{{{<ifcount code="ca_objects" min="1" max="1"><h3>Related object</h3></ifcount>}}}
	{{{<ifcount code="ca_objects" min="2"><h3>Related objects</h3></ifcount>}}}
	{{{<unit relativeTo="ca_objects" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l> (^ca_objects.idno)</unit>}}}
</p>
