<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 " >
			<h1>Advanced Search–Provenance <small>or search <?php print caNavLink($this->request, 'Works', '', 'Search', 'advanced', 'artworks');?>, <?php print caNavLink($this->request, 'Exhibitions', '', 'Search', 'advanced', 'exhibitions');?>, or <?php print caNavLink($this->request, 'References', '', 'Search', 'advanced', 'references');?></small></h1>

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
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to provenance names only.">Name</span>
				{{{ca_collections.preferred_labels.name%width=220px&label=Name}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Whether a work currently or previously resides in a location.">Provenance Status</span>
				{{{ca_objects_x_collections.current_collection%width=210px&height=1&label=Provenance_Status}}}
			</div>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Where a provenance resides.">Location</span>
				{{{ca_places.preferred_labels%height=30px&height=1&label=Location}}}
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