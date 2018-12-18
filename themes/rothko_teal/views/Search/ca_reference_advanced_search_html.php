<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 " >
			<h1>Advanced Search–References <small>or search <?php print caNavLink($this->request, 'Works', '', 'Search', 'advanced', 'artworks');?>, <?php print caNavLink($this->request, 'Provenance', '', 'Search', 'advanced', 'provenance');?>, or <?php print caNavLink($this->request, 'Exhibitions', '', 'Search', 'advanced', 'exhibitions');?></small></h1>

<p>{{{advText}}}</p>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the catalog.">Keyword</span>
				{{{_fulltext%width=200px&height=1&label=Keyword}}}
			</div>			
		</div>		
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to reference titles only.">Title</span>
				{{{ca_occurrences.preferred_labels.name%width=220px&height=1&label=Title}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by reference authors.">Author</span>
				{{{ca_entities.preferred_labels%width=210px&height=1&restrictToRelationshipTypes=author&label=Author}}}
			</div>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by publication dates.">Date</span>
				{{{ca_occurrences.occurrence_dates%height=30px&height=1&useDatePicker=0&label=Date}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by reference types.">Type</span>
				{{{ca_occurrences.reference_type%width=210px&height=1&label=Type}}}
			</div>
		</div>			
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search references by location.">Location</span>
				{{{ca_places.preferred_labels.name%width=220px&height=1&label=Location}}}
			</div>
		</div>					
		<br style="clear: both;"/>
		<div class='advancedFormSubmit'>
			<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
			<span class='btn btn-default' style="margin-left: 10px;">{{{submit%label=Search}}}</span>
		</div>
	</div>	

{{{/form}}}

		</div>
	</div><!-- end row -->
</div><!-- end container -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>