{{{form}}}

	<div class="advancedSearchField">
		Field:<br/>
		{{{_fieldlist%width=200px&height=1&fieldListWidth=100&fieldListHeight=1&fields=ca_objects.preferred_labels.name:Title;ca_entities.preferred_labels.displayname/author:Author;ca_objects.ISBN:ISBN;ca_entities.preferred_labels.displayname/publisher:Publisher;ca_entities.preferred_labels.displayname/publication:Publication;ca_objects.dc_date;ca_objects.series}}}
	</div>

	<div class="advancedSearchField">
		Field:<br/>
		{{{_fieldlist%width=200px&height=1&fieldListWidth=100&fieldListHeight=1&fields=ca_objects.preferred_labels.name:Title;ca_entities.preferred_labels.displayname/author:Author;ca_objects.ISBN:ISBN;ca_entities.preferred_labels.displayname/publisher:Publisher;ca_entities.preferred_labels.displayname/publication:Publication;ca_objects.dc_date;ca_objects.series}}}
		{{{_fieldlist:boolean}}}
	</div>

	<div class="advancedSearchField">
		Field:<br/>
		{{{_fieldlist%width=200px&height=1&fieldListWidth=100&fieldListHeight=1&fields=ca_objects.preferred_labels.name:Title;ca_entities.preferred_labels.displayname/author:Author;ca_objects.ISBN:ISBN;ca_entities.preferred_labels.displayname/publisher:Publisher;ca_entities.preferred_labels.displayname/publication:Publication;ca_objects.dc_date;ca_objects.series}}}
		{{{_fieldlist:boolean}}}
	</div>

	<div class="advancedSearchField">
		Format:<br/>
		{{{ca_objects.type_id}}}
	</div>
	
	<div class="advancedSearchField">
		Date range:<br/>
		{{{ca_objects.dc_date%width=200px&height=40px}}}
	</div>
	
	<div class="advancedSearchField">
		Language:<br/>
		{{{ca_objects.language}}}
	</div>
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}