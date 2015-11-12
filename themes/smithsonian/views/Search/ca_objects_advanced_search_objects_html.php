<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<h1>Objects Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=200px&height=25px}}}
		</div>	
		<div class="advancedSearchField">
			Title:<br/>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
		<div class="advancedSearchField">
			Work Type:<br/>
			{{{ca_occurrences.workType%width=210px}}}
		</div>
		<div class="advancedSearchField">
			Object Type:<br/>
			{{{ca_objects.type_id}}}
		</div>
		<div class="advancedSearchField">
			Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.date%width=200px&height=40px&useDatePicker=0}}}
		</div>
		
	</div>	
	
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}

		</div>
	</div><!-- end row -->
</div><!-- end container -->