
<div class="row">
	<div class="col-sm-8 col-sm-offset-2" style='border-right:1px solid #ddd; border-left:1px solid #ddd;'>
		<h1>Advanced Search</h1>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Object Titles only.">Object Title</span>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Individuals and Organizations.">Individuals and Organizations</span>
			{{{ca_entities.preferred_labels%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Archival Material and Object Type</span>
			{{{ca_objects.archival_object_subtype%width=220px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to object types.">Published Materials Type</span>
			{{{ca_objects.published_subtype%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Related List Items</span>
			{{{ca_list_items.preferred_labels.name_singular%width=200px&height=40px&useDatePicker=0}}}
			</div>
		<div class="advancedSearchField col-sm-3">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date</i></span>
			{{{ca_objects.dates.dates_value%width=200px&height=40px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField col-sm-3">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date Type</i></span>
			{{{ca_objects.date.dates_types}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search descriptions.">Description</span>
			{{{ca_objects.description%height=60px&width=220px}}}
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
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>