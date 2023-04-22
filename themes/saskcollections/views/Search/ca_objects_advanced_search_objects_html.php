<div class="row">
	<div class="col-md-8">
		<h1><?php _p('Advanced Search') ?></h1>

        <p><?php _p("Enter your search terms in the fields below."); ?></p>

	</div>
</div>
<div class="row">
	<div class="col-md-8">
{{{form}}}
<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for="_fulltext" class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search across all fields in the database.') ?>"><?php _p('Keyword') ?></label>
			{{{_fulltext%width=200px&height=1}}}
		</div>			
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for='ca_objects_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to Object Titles only.') ?>"><?php _p('Object Name/Title') ?></label>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_type_id' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to object types.') ?>"><?php _p('Type') ?></label>
			{{{ca_objects.type_id%id=ca_objects_type_id}}}	
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_idno' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search object accession numbers.') ?>"><?php _p('Accession number') ?></label>
			{{{ca_objects.idno%width=210px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_entities_preferred_labels' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records by artist or maker.') ?>"><?php _p('Artist/Maker') ?></label>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=artist,manufacturer%width=200px&height=1}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects.date[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records of a particular date or date range.') ?>"><?php _p('Date range <i>(e.g. 1970-1979)</i>') ?></label>
			{{{ca_objects.date%width=200px&height=1&useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_materials' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to object materials.') ?>"><?php _p('Materials') ?></label>
			{{{ca_objects.materials%id=ca_objects_materials}}}	
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ns_category_as_text' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to object category.') ?>"><?php _p('Category') ?></label>
			{{{ca_objects.ns_category_as_text%id=ns_category_as_text}}}	
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_source_id' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records by Institution.') ?>"><?php _p('Institution') ?></label>
			{{{ca_objects.source_id%width=200px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<!--<label for='ca_object_representations_type_id' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records with media.') ?>"><?php _p('Has Media') ?></label>
			{{{ca_object_representations.media_class%width=200px&height=1}}}-->
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