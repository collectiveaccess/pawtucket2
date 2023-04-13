<div class="row">
	<div class="col-md-4 col-md-offset-2">
		<h1><?php _p('Objects Advanced Search') ?></h1>

        <p><?php _p("Enter your search terms in the fields below."); ?></p>

	</div>
	<div class="col-md-4 formLinks">
		<?php print caNavLink($this->request, "Archives Advanced Search <span class='glyphicon glyphicon-new-window'></span>", "btn btn-default", "Search", "advanced", "collections"); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
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
			<label for='ca_objects_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to Object Titles only.') ?>"><?php _p('Title') ?></label>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_collections_preferred_labels' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records by Institution.') ?>"><?php _p('Institution') ?></label>
			{{{ca_objects.source_id%width=200px&height=1&inUse=1}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_collections_preferred_labels' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records within a particular collection.') ?>"><?php _p('Collection') ?></label>
			{{{ca_collections.preferred_labels%restrictToTypes=collection%width=200px&height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_idno' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search object identifiers.') ?>"><?php _p('Accession number') ?></label>
			{{{ca_objects.idno%width=210px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_type_id' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to object types.') ?>"><?php _p('Type') ?></label>
			{{{ca_objects.type_id%id=ca_objects_type_id&inUse=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_entities' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records by their creators and contributors.') ?>"><?php _p('Creators and Contributors') ?></label>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=creator,attributed,contributor&width=200px&height=1}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_entities' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records by related people and institutions.') ?>"><?php _p('Related People and Institutions') ?></label>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=associated,publisher,owner,previous_owner&width=200px&height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects.date.dates_value[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records of a particular date or date range.') ?>"><?php _p('Date range <i>(e.g. 1970-1979)</i>') ?></label>
			{{{ca_objects.date.date_value%width=200px&height=1&useDatePicker=0}}}
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
