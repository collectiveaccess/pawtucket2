<div class="container">
	<div class="row">
		<div class="col-sm-12" >
			<div id="page-name" style="padding-bottom:20px;">
				<h1 id="archives" class="title">Advanced Search</h1>
			</div>

<div class="col-sm-8" >
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
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Object Titles only.">Title</span>
				{{{ca_objects.preferred_labels.name%width=220px}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Identifier</span>
				{{{ca_objects.idno%width=210px}}}
			</div>
		</div>
		<div class='row'>	
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to object types.">Type</span>
				{{{ca_objects.type_id%height=30px}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date range <i>(e.g. 1970-1979)</i></span>
				{{{ca_objects.dates.parsed_date%width=200px&height=40px&useDatePicker=0}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records within a particular collection.">Collection </span>
				{{{ca_collections.preferred_labels%restrictToTypes=collection%width=200px&height=1}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records within a particular exhibition.">Exhibition </span>
				{{{ca_occurrences.preferred_labels%restrictToTypes=exhibition%width=200px&height=1}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search for objected cited in a bibliographic record.">Bibliography </span>
				{{{ca_occurrences.preferred_labels%restrictToTypes=bibliography%width=200px&height=1}}}
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
</div>
		</div>
	</div><!-- end row -->
</div><!-- end container -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>