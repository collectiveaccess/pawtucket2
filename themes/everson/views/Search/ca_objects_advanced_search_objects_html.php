<div class="container advsearch">
	<div class="row">
		<div class="col-sm-12 ">
			<h1>Objects Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='row'>
		<div class="col-sm-12">
			Keyword<br/>
			{{{_fulltext%width=200px&height=25px}}}
		</div>		
	</div>
	<div class='row'>
		<div class="col-sm-6">
			Title:<br/>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
		<div class="col-sm-6">
			Person or Organization:<br/>
			{{{ca_entities.preferred_labels.displayname%width=220px}}}
		</div>		
	</div>
	<div class='row'>	
		<div class="col-sm-6">
			Identifier:<br/>
			{{{ca_objects.idno%width=210px}}}
		</div>
		<div class="col-sm-6">
			Object Type:<br/>
			{{{ca_objects.object_type}}}
		</div>
	</div>
	<div class='row'>	
		<div class="col-sm-6">
			Object Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.date.dates_value%width=200px&height=40px&useDatePicker=0}}}
		</div>	
		<div class="col-sm-6">
			Archival Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.archive_dates.archive_daterange%width=200px&height=40px&useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>	
		<div class="col-sm-6">
			Materials:<br/>
			{{{ca_objects.materials}}}
		</div>
	</div>		
	
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label= > Reset}}}</div>
	<div style="float: right;">{{{submit%label= > Search}}}</div>
{{{/form}}}

		</div>
	</div><!-- end row -->
</div><!-- end container -->