
<div class="row">
	<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
		<h1>Objects Advanced Search</h1>

<?php			
print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Object Titles only.">Title</span>
			{{{ca_objects.preferred_labels.name}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Accession number</span>
			{{{ca_objects.idno}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to object types.">Type</span>
			{{{ca_objects.type_id}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date range <i>(e.g. 1970-1979)</i></span>
			{{{ca_objects.Date%useDatePicker=0}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records within a particular collection.">Collection </span>
			{{{ca_collections.preferred_labels%restrictToTypes=collection}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<div class='row'>
				<div class="advancedSearchField col-sm-2">
					<span class='formLabel'>&nbsp;</span>
					{{{_fulltext:boolean}}}
				</div>
				<div class="advancedSearchField col-sm-10">
					<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Keyword</span>
					{{{_fulltext%width=200px&height=1}}} 
				</div>
			</div>
		</div>			
	</div>		
	
	<br style="clear: both;"/>
	<div class='advancedFormSubmit'>
		<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
	</div>
	<br/><br/>
</div>	

{{{/form}}}

	</div>
	<div class="col-sm-4" >
		<h1>General Search</h1>
		<p>Search for Collections, Exhibits/Programs, Objects and Makers/Donors in a single search.</p>
		<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
			<div class='row'>
				<div class="advancedSearchField col-xs-10">				
					<input type="text" name="search">
				</div>	
				<div class="advancedSearchField col-xs-2 text-left">
					<button type="submit" class="btn-default">GO</button>
				</div>		
			</div>
		</form>
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>