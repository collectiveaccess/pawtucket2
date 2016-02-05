<div class="container">
	<div class="row">
		<div class="col-sm-8 ">
			<h1>Objects Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=400px&height=25px}}}
		</div>		
		<div class="advancedSearchField">
			Title:<br/>
			{{{ca_objects.preferred_labels.name%width=400px}}}
		</div>
		<div class="advancedSearchField">
			Culture:<br/>
			{{{ca_objects.culture%width=400px&height=25px}}}
		</div>
		<div class="advancedSearchField">
			Creator<br/>
			{{{ca_entities.preferred_labels.displayname/creator%width=400px&height=25px}}}
		</div>		
		<div class="advancedSearchField">
			Date<br/>
			{{{ca_objects.dates.date_value%width=400px&height=25px&useDatePicker=0}}}
		</div>	
		<div class="advancedSearchField">
			Exhibition Date<br/>
			{{{ca_objects.exh_dates%width=400px&height=25px&useDatePicker=0}}}
		</div>	
		<div class="advancedSearchField">
			Exhibition Location<br/>
			{{{ca_objects.exh_location%width=400px&height=25px}}}
		</div>	
		<div class="advancedSearchField">
			Material<br/>
			{{{ca_objects.material%width=400px&height=25px}}}
		</div>
		<div class="advancedSearchField">
			Medium<br/>
			{{{ca_objects.medium%width=400px&height=25px}}}
		</div>	
		<div class="advancedSearchField">
			Nationality<br/>
			{{{ca_entities.nationalityCreator%width=400px&height=25px}}}
		</div>
		<div class="advancedSearchField">
			Technique<br/>
			{{{ca_objects.technique%width=400px&height=25px}}}
		</div>											
		<div class="advancedSearchField">
			Type:<br/>
			{{{ca_objects.type}}}
		</div>
		<div style='width:400px;height:80px;'>		
			<br style="clear: both;"/>
	
			<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
			<div style="float: right;">{{{submit%label=Search}}}</div>
		</div>		
	</div>	
	

{{{/form}}}

		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;'>
			<h1>Helpful Links</h1>
			<p>Include some helpful info for your users here.</p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->