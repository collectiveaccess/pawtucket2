
<div class="row">
	<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
		<h1>Advanced Search</h1>

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
		
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Identifier</span>
			{{{ca_objects.idno%width=210px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Object Titles only.">Title</span>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to mint.">Mint</span>
			{{{ca_objects.mint_link%width=100%&height=30px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to material types.">Material</span>
			{{{ca_objects.material_link%width=100%&height=30px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date range <i>(e.g. 1970-1979)</i></span>
			{{{ca_objects.date%width=100%&height=30px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to region.">Region</span>
			{{{ca_objects.region_link%width=100%&height=30px}}}
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
		<h1>Help</h1>
		<p>Include search tips here.</p>
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>