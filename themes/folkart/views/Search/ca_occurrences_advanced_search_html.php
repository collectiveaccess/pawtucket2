	<div class="row">
		<div class="col-sm-12">
			<H1><?php print _t("Exhibitions/Events Advanced Search"); ?></H1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-sm-12">
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
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to exhibition/event Titles only.">Title</span>
				{{{ca_occurrences.preferred_labels.name%width=220px}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search exhibition/event identifiers.">Accession number</span>
				{{{ca_occurrences.idno%width=210px}}}
			</div>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to exhibition/event types.">Type</span>
				{{{ca_occurrences.type_id%height=30px}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date range <i>(e.g. 1970-1979)</i></span>
				{{{ca_occurrences.event_date%width=400px&height=40px&useDatePicker=0}}}
			</div>
		</div>
		<br style="clear: both;"/>
		<div class='advancedFormSubmit'>
			<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
			<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
		</div>
	</div>	

{{{/form}}}

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>
		</div>
	</div>