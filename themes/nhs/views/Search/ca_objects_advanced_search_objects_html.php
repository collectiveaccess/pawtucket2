<div class="row">
	<div class="col-sm-12 col-md-8">

<h1>Objects Advanced Search</h1>

<?php			
print "<p>Enter your search terms in the fields below. Hover over a field to see search tips.</p>";
print "<p>Click here for the ".caNavLink($this->request, _t("Manuscript Collections Advanced Search"), "", "Search", "Advanced", "collections").".</p>";

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
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records by the people and organizations associated with them.">People & Organizations</span>
			{{{ca_entities.preferred_labels.displayname%width=200px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Object Number</span>
			{{{ca_objects.idno%width=210px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search additional object identifiers.">Other Object Number</span>
			{{{ca_objects.other_number%width=210px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date</span>
			{{{ca_objects.date.dates_value%width=200px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by object's materials.">Material</span>
			{{{ca_objects.materials%width=210px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<div style="display:none;">{{{ca_objects.aat%width=210px}}}</div>
			
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search objects by type (for example: photograph or shoe)">Object Type</span>
			<input name="ca_objects.aat[]" size="30" value="" id="ca_objects_aat[]" class="" style="" type="text">
			<input name="ca_objects.aat_label" value="Object Type (AAT)" type="hidden">
		</div>
	</div>
	<br style="clear: both;"/>
	<div class='advancedFormSubmit'>
		<input type="hidden" name="view" value="images">
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