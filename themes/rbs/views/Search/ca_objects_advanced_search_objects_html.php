<div class="container">
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
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Keyword</span>
				{{{_fulltext%width=200px&height=1}}}
			</div>			
		</div>		
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Book Titles only.">Title</span>
				{{{ca_objects.preferred_labels.name%width=220px}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records associated with an author.">Author </span>
				{{{ca_entities.preferred_labels%restrictToRelationshipTypes=author&width=200px&height=1}}}
			</div>
		</div>	
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records associated with a publisher.">Publisher </span>
				{{{ca_entities.preferred_labels%restrictToRelationshipTypes=publisher&width=200px&height=1}}}
			</div>
		</div>					
		<div class='row'>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Object Identifier</span>
				{{{ca_objects.idno%width=210px}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records with a controlled vocabulary term.">Controlled Vocabulary Term </span>
				{{{ca_list_items.preferred_labels%width=200px&height=1&autocomplete=1}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records according to date of publication.">Date Range </span>
				{{{ca_objects.date%width=200px&height=1}}}
			</div>
		</div>		
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records within a particular course.">Course </span>
				{{{ca_occurrences.preferred_labels%width=200px&height=1&autocomplete=1}}}
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
			<h1>Helpful Links</h1>
			<p style="margin-top:50px;"><a href="http://rbms.info/vocabularies/index.shtml?PHPSESSID=53f3ce679864adbe51d40f1df2ef14a2" target="_blank">RBMS Controlled Vocabularies</a></p>
			<p><a href="http://rarebookschool.org/" target="_blank">Rare Book School Main website</a></p>
			<p><a href="http://rarebookschool.org/courses/" target="_blank">RBS Course Descriptions</a></p>
			<p><a href="/themes/rbs/assets/pawtucket/files/Controlled_vocabularies_RBS_reference_list.pdf" target="_blank">Controlled Vocabularies Adopted by RBS: Reference List.</a></p>

		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>