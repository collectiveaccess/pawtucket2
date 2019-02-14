
<div class="row">
	<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
		<h1>Artifacts Advanced Search</h1>

<?php			
print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Keyword</span>
			{{{_fulltext%width=200px&height=1}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to type.">Type</span>
			{{{ca_objects.object_type%height=30px}}}
		</div>		
	</div>		
	<div class='row'>	
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to name only.">Artifact / Item name</span>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search item identifier.">Artifact / Item number</span>
			{{{ca_objects.idno%width=210px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records by date or date range.">Dates <i>(e.g. 1970-1979)</i></span>
			{{{ca_objects.date.dates_value%width=200px&height=40px&useDatePicker=0}}}
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
		<h1>Advanced Search Options</h1>
		<ul>
			<li><?php print caNavLink($this->request, _t("Archival Items Advanced Search"), "", "", "Search", "advanced/archival_items"); ?></li>
			<li><?php print caNavLink($this->request, _t("Archival Fonds and Collections Advanced Search"), "", "", "Search", "advanced/archives"); ?></li>
			<li><?php print caNavLink($this->request, _t("Artifact Advanced Search"), "", "", "Search", "advanced/artifacts"); ?></li>
		</ul>
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>