<h2>Archives</h2>

{{{form}}}
	
	<div class="advancedSearchField">
		Free text:<br/>
		{{{_fulltext%width=200px&height=40px}}}
		{{{_fulltext:boolean}}}
	</div>
	<div class="advancedSearchField">
		Free text:<br/>
		{{{_fulltext%width=200px&height=40px}}}
		{{{_fulltext:boolean}}}
	</div>
	<div class="advancedSearchField">
		Free text:<br/>
		{{{_fulltext%width=200px&height=40px}}}
		{{{_fulltext:boolean}}}
	</div>
	
	
	<div class="advancedSearchField">
		Format:<br/>
		{{{ca_objects.type_id%restrictToTypes=audio;document;ephemera;image;book;moving_image}}}
	</div>
	
	<div class="advancedSearchField">
		Date range:<br/>
		{{{ca_objects.dc_date%width=200px&height=40px}}}
	</div>
	
	<br style="clear: both;"/>
	
	<div>
		<ul>
			<li>Search Words Separated by Spaces Only</li>
			<li>Search for Exact Word or Phase (")</li>
			<li>Exclude a Word (-)</li>
			<li>Include Similar Words (~)</li>
			<li>Include "fill in the blank" (*)</li>
			<li>Search for Either Word (OR)</li>
		</ul>
</div>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}