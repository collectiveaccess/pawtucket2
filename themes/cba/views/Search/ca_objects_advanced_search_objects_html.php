<div class="row">
	<div class="col-sm-12 col-lg-6">
		<h1><?php _p('Advanced Search') ?></h1>
{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for='ca_objects_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to Titles only.') ?>"><?php _p('Title') ?></label>
			{{{ca_objects.preferred_labels.name%width=100%}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for='ca_objects.date.dates_value[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records of a particular date or date range.') ?>"><?php _p('Date range <i>(e.g. 1970-1979)</i>') ?></label>
			{{{ca_objects.dates.dates_value%width=100%&useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for='ca_entities_preferred_labels' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records by their creator.') ?>"><?php _p('Creator') ?></label>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=rel_2,rel_37%width=100%}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for="_fulltext" class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search across all fields in the database.') ?>"><?php _p('Keyword') ?></label>
			{{{_fulltext%width=200px&height=1}}}
		</div>			
	</div>		
	<br style="clear: both;"/>
		<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
</div>	

{{{/form}}}

	</div>
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>