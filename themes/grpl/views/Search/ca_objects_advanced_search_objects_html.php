
<div class="row">
	<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
		<h1>Advanced search</h1>

<?php
print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database">Keyword</span>
			{{{_fulltext%width=200px&height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to object titles only">Title</span>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search street address.">Street address</span>
			{{{ca_objects.address_info.address}}}
		</div>
	</div>

	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search file identifiers.">File ID</span>
			{{{ca_objects.idno%height=30px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to object types">Type</span>
			{{{ca_objects.type_id%height=30px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit search to a single date or date range">Date range (e.g. 1970-1979)</span>
			{{{ca_objects.date.date_value%height=30px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records within a particular collection">Collection</span>
			{{{ca_collections.preferred_labels%height=30px&restrictToTypes=collection}}}
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
		<h1>Other searches</h1>
			<p><a href="all_images">Search for images</a></p>
			<p><a href="publications">Search newspapers and magazines</a></p>
			<p><a href="regcard">Search WWI registration cards</a></p>
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover();
	});

</script>
