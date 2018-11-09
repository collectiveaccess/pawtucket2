
<div class="row">
	<div class="col-sm-8">
		<h1>Library Advanced Search</h1>

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
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Object Titles only.">Title</span>
			{{{ca_objects.preferred_labels%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-8">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by Author.">Author</span>
				{{{ca_objects.author_name%width=220}}}
		</div>
		<div class="advancedSearchField col-sm-4">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by Author.">Author Role</span>
				{{{ca_objects.author_role%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by Tags.">Tags</span>
			{{{ca_objects.artwork_status%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by Publication.">Publication</span>
			{{{ca_objects.publisher%width=220px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by Publication Date.">Publication Date (Year)</span>
			{{{ca_objects.common_date%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by LC Subject Headings.">LC Subject Headings (Imported)</span>
			{{{ca_objects.lc_import%width=220px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by LC Subject Headings.">LC Subject Headings (Lookup)</span>
			{{{ca_objects.lcsh%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by Library.">Library</span>
			{{{ca_objects.library%width=220px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by Category.">Category</span>
			{{{ca_objects.book_category%width=220px&nullOption=-}}}
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
		
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>