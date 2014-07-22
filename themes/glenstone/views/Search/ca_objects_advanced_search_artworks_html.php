<h2>Artworks</h2>

{{{form}}}

	<div class="advancedSearchField">
		Title:<br/>
		{{{ca_objects.preferred_labels.name}}}
	</div>
	<div class="advancedSearchField">
		Accession number:<br/>
		{{{ca_objects.idno%width=200px}}}
	</div>
	<div class="advancedSearchField">
		{{{ca_objects.description:label}}}<br/>
		{{{ca_objects.description%width=220px&height=40px}}} {{{ca_objects.description:boolean}}}
	</div>
	<div class="advancedSearchField">
		Artist:<br/>
		{{{ca_entities.preferred_labels.displayname/artist%width=200px&height=40px}}}
	</div>
	<div class="advancedSearchField">
		Date:<br/>
		{{{ca_objects.creation_date}}} {{{ca_objects.creation_date:not}}} Not
	</div>
	
	<div class="advancedSearchField">
		Text:<br/>
		{{{_fulltext%width=200px&height=100px}}}
	</div>
	
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}