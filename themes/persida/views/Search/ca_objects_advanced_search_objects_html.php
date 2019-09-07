
<div class="row">
<?php
	$vs_guide_text = $this->getVar("guide_to_use_text");
	if($vs_guide_text){
		print '<div class="col-sm-8 " style="border-right:1px solid #ddd;">';
	}else{
		print '<div class="col-sm-8 col-sm-offset-2">';
	}
?>
		<h1>Artwork Advanced Search</h1>

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
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to artist names only.">Artist Name</span>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=artist%width=220px}}}
		</div>
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Work code</span>
			{{{ca_objects.idno%width=210px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to artwork types.">Type</span>
			{{{ca_objects.art_types%height=30px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Creation date <i>(e.g. 1970-1979)</i></span>
			{{{ca_objects.creation_date%width=200px&height=40px&useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular acquisition date or date range.">Acquisition date <i>(e.g. 1970-1979)</i></span>
			{{{ca_objects.acquisition_date%width=200px&height=40px&useDatePicker=0}}}
		</div>
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search artworks of a particular medium.">Medium</span>
			{{{ca_objects.medium%width=200px&height=1}}}
		</div>
	</div>
<?php
	if($this->request->user->hasRole("admin") || $this->request->user->hasRole("dj") || $this->request->user->hasRole("purchasing")){
?>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a range of insurance values.">Insurance Value</span>
			{{{ca_objects.value_insurance%width=200px&height=1}}}
		</div>
	</div>
<?php
	}
	if($this->request->user->hasRole("admin") || $this->request->user->hasRole("purchasing")){
?>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a range of purchase values.">Value of Purchase</span>
			{{{ca_objects.value_purchase_USD%width=200px&height=1}}}
		</div>
	</div>
<?php
	}
?>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search artworks within an exhibition.">Related Exhibition </span>
			{{{ca_occurrences.preferred_labels%restrictToTypes=exhibition%width=200px&height=1&label=Exhibition}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search artworks related to bibliographies.">Related Bibliography </span>
			{{{ca_occurrences.preferred_labels%restrictToTypes=bibliography%width=200px&height=1&label=Bibliography}}}
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
	
<?php 
		if($vs_guide_text){
			print "<div class='col-sm-4'>";
			print "<h1>Guide to Use</h1>";
			print "<p>{{{guide_to_use_text}}}</p>";
			print "</div><!-- end col -->";
		}
?>
		
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>