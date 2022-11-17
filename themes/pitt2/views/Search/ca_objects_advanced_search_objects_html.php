<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>Collection Items Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class='row'><div class="advancedSearchField col-sm-12">
			Creator<br/>
			{{{ca_entities.preferred_labels.displayname/creator%width=400px&height=25px}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			Medium<br/>
			{{{ca_objects.medium%width=400px&height=25px&render=list}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			Title<br/>
			{{{ca_objects.preferred_labels.name%width=400px&height=25px}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			Date<br/>
			{{{ca_objects.dates.date_value%width=400px&height=25px&useDatePicker=0&height=25px}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			Accession No.<br/>
			{{{ca_object_lots.idno_stub%width=400px&height=25px}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			Keyword<br/>
			{{{_fulltext%width=400px&height=25px}}}
		</div></div>
		<div class='row'><div class='advancedFormSubmit'>
			<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
			<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
		</div></div>		
	</div>	
	

{{{/form}}}

		</div>
	</div><!-- end row -->
</div><!-- end container -->