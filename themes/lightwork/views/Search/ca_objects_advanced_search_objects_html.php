
<div class="row">
	<div class="col-sm-12 " >
		<h1>Artwork Search</h1>

<div>{{{search_text}}}</div>

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
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records made by a particular artist.">Artist </span>
			{{{ca_entities.entity_id%restrictToRelationshipTypes=artist&width=200px&height=40px&select=1&sort=ca_entities.preferred_labels.surname}}}

		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Artist biographies.">Artist Biography</span>
			{{{ca_entities.biography%width=220px&height=1}}}
		</div>
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Artist essays.">Artist Essay</span>
			{{{ca_entities.essays%width=220px&height=1}}}
		</div>
	</div>						
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Object Titles only.">Artwork Title</span>
			{{{ca_objects.preferred_labels.name%width=220px&height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Artwork Date</span>
			{{{ca_objects.date%width=200px&height=1&useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search artworks created with a particular technique.">Medium</span>
			{{{ca_objects.medium%width=200px&height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records related to a specific publication.">Light Work Publication </span>
			{{{ca_objects.related.idno%restrictToTypes=publication&width=200px&height=1&select=1}}}
		</div>
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Light Works programs and initiatives.">Light Work Relationship</span>
			{{{ca_entities.lw_relationship%height=1}}}
		</div>
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to artist gender.">Artist Gender</span>
			{{{ca_entities.gender%height=1}}}
		</div>
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to artist gender.">Cultural Heritage</span>
			{{{ca_entities.cultural%height=1}}}
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