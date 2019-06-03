
<div class="row">
	<div class="col-sm-12 " style='border-right:1px solid #ddd;'>
		<h1 style='padding-left:0px;'>Digital Collections Advanced Search</h1>

<?php			
print "<p>Enter your search terms in the fields below to search objects in the New York State Archives Digital Collections.</p>";
?>

{{{form}}}

<div class='advancedContainer'>	
	<div class="row">
		<div class="col-sm-12 col-lg-8">
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Full Text</span>
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
					<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records from a particular creator.">Creator </span>
					{{{ca_entities.preferred_labels%width=200px&height=1}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to format.">Format</span>
					{{{ca_objects.type_id%height=30px&inUse=1}}}
				</div>	
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date range <i>(e.g. 1970-1979)</i></span>
					{{{ca_objects.date_original%width=200px&height=40px&useDatePicker=0}}}
				</div>
			</div>		
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records within a particular series.">Series </span>
					{{{ca_collections.preferred_labels%restrictToTypes=collection%width=200px&height=1}}}
				</div>
			</div>	
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records within a particular geographic location.">Geographic Location </span>
					{{{ca_places.preferred_labels%width=200px&height=1}}}
				</div>
			</div>
			<br style="clear: both;"/>
			<div class='advancedFormSubmit'>
				<span class='btn btn-default' style="margin-right: 20px;">{{{submit%label=Search}}}</span>
				<span class='btn btn-default'>{{{reset%label=Clear}}}</span>
			</div>
		</div>
	</div>
</div>	

{{{/form}}}

	</div>
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>