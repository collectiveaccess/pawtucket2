<div class="row">
	<div class="col-sm-12 col-md-8">

<h1>Manuscript Collections Advanced Search</h1>

<?php			
print "<p>Enter your search terms in the fields below. Hover over a field to see search tips.</p>";
print "<p>Click here for the ".caNavLink($this->request, _t("Objects Advanced Search"), "", "Search", "Advanced", "objects").".</p>";
?>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the Manuscripts database.">Keyword</span>
			{{{_fulltext%width=200px&height=1}}}
		</div>			
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Collection Titles only.">Title</span>
			{{{ca_collections.preferred_labels.name%width=220px}}}
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
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search collection identifiers.">Collection Number</span>
			{{{ca_collections.idno%width=210px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date</span>
			{{{ca_collections.collection_date2.collection_date_inclusive%width=200px&useDatePicker=0}}}
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