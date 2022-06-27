
<div class="row">
	<div class="col-sm-12 col-md-8 col-md-offset-2">
		<h1><?php _p('Collection Items Advanced Search') ?></h1>

        <p><?php _p("Enter your search terms in the fields below."); ?></p>
{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for="_fulltext" class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search across all fields in the database.') ?>"><?php _p('Keyword') ?></label>
			{{{_fulltext%width=200px&height=1}}}
		</div>			
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to Collection Item name.') ?>"><?php _p('Name') ?></label>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_idno' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to catalog number.') ?>"><?php _p('Catalog number') ?></label>
			{{{ca_objects.idno%width=100%}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_collection_area' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to collection area.') ?>"><?php _p('Collection area') ?></label>
			{{{ca_objects.collection_area%width=100%}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_subtype' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to collection type.') ?>"><?php _p('Collection type') ?></label>
			{{{ca_objects.subtype%width=100%&inUse=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_country' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to country.') ?>"><?php _p('Country') ?></label>
			{{{ca_objects.country_display%id=ca_objects_country}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_culture' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to culture.') ?>"><?php _p('Culture') ?></label>
			{{{ca_objects.culture_display%id=ca_objects_culture}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_locale' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to locale.') ?>"><?php _p('Locale') ?></label>
			{{{ca_objects.locale_display%width=100%&id=ca_objects_locale}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_period' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to period.') ?>"><?php _p('Period') ?></label>
			{{{ca_objects.period_display%id=ca_objects_period}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_materials' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to material.') ?>"><?php _p('Material') ?></label>
			{{{ca_objects.materials%width=100%&id=ca_objects_materials}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_technique' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to technique.') ?>"><?php _p('Technique') ?></label>
			{{{ca_objects.technique%id=ca_objects_technique}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_entities_collector' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to collector.') ?>"><?php _p('Collector') ?></label>
			{{{ca_entities.preferred_labels%id=ca_entities_collector&restrictToRelationshipTypes=collector}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_entities_donor' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to donot.') ?>"><?php _p('Donor') ?></label>
			{{{ca_entities.preferred_labels%id=ca_entities_donor&relativeTo=ca_object_lot}}}
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