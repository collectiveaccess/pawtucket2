<div class="container">
	<div class="row">
		<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
			<h1>Objects Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Keyword</span>
				{{{_fulltext%width=200px&height=1}}}
			</div>			
		</div>		
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to object names only.">Object Name</span>
				{{{ca_objects.preferred_labels.name%width=220px}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to artists, manufacturers and photographers.">Artists, Manufacturers, and Photographers</span>
				{{{ca_entities.preferred_labels.name%restrictToRelationshipTypes=artist;manufacturer;photographer&width=220px}}}
			</div>
		</div>		
		<div class='row'>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by materials.">Material</span>
				{{{ca_objects.material%width=200px&height=1}}}
			</div>	
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by technique.">Technique</span>
				{{{ca_objects.technique%width=200px&height=1}}}
			</div>				
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object descriptions.">Description</span>
				{{{ca_objects.description%width=200px&height=1}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date range <i>(e.g. 1970-1979)</i></span>
				{{{ca_objects.date%width=200px&height=40px&useDatePicker=0}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records from a particular association.">Related Association </span>
				{{{ca_occurrences.preferred_labels%restrictToTypes=association%width=200px&height=1}}}
			</div>
		</div>
		<br style="clear: both;"/>
		<div class='advancedFormSubmit'>
			<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
			<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
		</div>
	</div>	

{{{/form}}}

		</div>
		<div class="col-sm-4" >
			<h1>Helpful Links</h1>
			<p>Include some helpful info for your users here.</p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>