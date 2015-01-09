<h1>Archives</h1>

<?php			
	print "<span class='faLink'><i class='fa fa-archive' style='padding-right:5px;'></i>".caNavLink($this->request, 'View finding aid', '', '', 'FindingAid', 'Collection/Index')."</span>";
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=200px&height=25px}}}
			{{{_fulltext:boolean}}}
		</div>
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=200px&height=25px}}}
			{{{_fulltext:boolean}}}
		</div>
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=200px&height=25px}}}
			{{{_fulltext:boolean}}}
		</div>
	</div>
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			Type:<br/>
			{{{ca_objects.type_id%restrictToTypes=audio;document;ephemera;image;moving_image}}}
		</div>
	
		<div class="advancedSearchField">
			Date range:<br/>
			{{{ca_objects.dc_date.dc_dates_value%width=200px&height=40px&useDatePicker=0}}}
		</div>
	</div>	
	
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}