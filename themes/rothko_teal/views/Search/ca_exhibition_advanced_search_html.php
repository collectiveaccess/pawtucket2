<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 " >
			<h1>Advanced Search–Exhibitions <small>or search <?php print caNavLink($this->request, 'Works', '', 'Search', 'advanced', 'artworks');?>, <?php print caNavLink($this->request, 'Provenance', '', 'Search', 'advanced', 'provenance');?>, or <?php print caNavLink($this->request, 'References', '', 'Search', 'advanced', 'references');?></small></h1>

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
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to exhibition titles only.">Exhibition Title</span>
				{{{ca_occurrences.preferred_labels.name%width=220px&height=1&label=Exhibition_Title}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to related object titles only.">Object Title</span>
				{{{ca_objects.preferred_labels%width=220px&height=1&label=Object_Title}}}
			</div>
		</div>		
		<div class='row'>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by exhibition venues.">Venue</span>
				{{{ca_entities.preferred_labels%width=210px&height=1&restrictToRelationshipTypes=venue&label=Venue}}}
			</div>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by exhibition dates.">Date</span>
				{{{ca_occurrences.occurrence_dates%height=30px&height=1&useDatePicker=0&label=Date}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search exhibitions by location.">Location</span>
				{{{ca_places.preferred_labels.name%width=220px&height=1&label=Location}}} <input type="hidden" name="ca_places_preferred_labels_name_label" value="Location"/>
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