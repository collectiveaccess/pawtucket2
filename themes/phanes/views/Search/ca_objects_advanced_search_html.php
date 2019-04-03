
<div class="row">
	<div class="col-sm-8">
		<h1>Advanced Search</h1>

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
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Identifier</span>
			{{{ca_objects.idno%width=210px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-4">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to mint.">Mint</span>
			{{{ca_objects.mint%width=100%}}}
		</div>
		<div class="advancedSearchField col-sm-4">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to authority.">Authority</span>
			{{{ca_objects.authority%width=100%}}}
		</div>
		<div class="advancedSearchField col-sm-4">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to denomination.">Denomination</span>
			{{{ca_objects.denomination%width=100%}}}
		</div>
	</div>
	<div class='row'>	
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date range <i>(e.g. 1970-1979)</i></span>
			{{{ca_objects.date%width=100%&height=30px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to region.">Region</span>
			{{{ca_objects.region%width=100%}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to obverse.">Obverse</span>
			{{{ca_objects.obverse%width=100%}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to reverse.">Reverse</span>
			{{{ca_objects.reverse%width=100%}}}
		</div>
	</div>
	<br style="clear: both;"/>
	<div class='advancedFormSubmit'>
		<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
	</div>
</div>	
<input type="hidden" name="view" value="obverse">
{{{/form}}}

	</div>
	<div class="col-sm-4" >
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>