
<div class="row">
	<div class="col-sm-8 col-lg-7 col-lg-offset-1">
		<h1><?php _p('Objects Advanced Search') ?></h1>

        <p><?php _p("Enter your search terms in the fields below."); ?></p>
{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for="_fulltext" class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search across all fields. Separate keywords with commas.') ?>"><?php _p('Keyword') ?></label>
			{{{_fulltext%width=200px&height=1}}}
		</div>			
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for='ca_objects_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Title or name of the record or object assigned by the creator or cataloguer.') ?>"><?php _p('Title') ?></label>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_date[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records and items by date or date range.') ?>"><?php _p('Dates <i>(e.g. 1923-1950)</i>') ?></label>
			{{{ca_objects.date%width=200px&height=1px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_objects_language[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Language(s) associated with an item.') ?>"><?php _p('Language') ?></label>
			{{{ca_objects.language%width=210px&id=ca_objects_language&inUse=1}}}
		</div>
		
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for='ca_entities_preferred_labels' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Individuals and organizations related to an item, such as creator, contributor, speaker, subject, etc.') ?>"><?php _p('People & Organizations') ?></label>
			{{{ca_entities.preferred_labels%width=200px&height=1}}}
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
	<div class="col-sm-4 col-lg-3 helpText">
		<h2><?php _p('Helpful Hints') ?></h2>
		<p>{{{advanced_search}}}</p>
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>