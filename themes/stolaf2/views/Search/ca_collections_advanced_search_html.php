
<div class="row">
	<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
		<h1><?php _p('Collections Advanced Search') ?></h1>

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
		<div class="advancedSearchField col-sm-12">
			<label for='ca_collections_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to Collection Titles only.') ?>"><?php _p('Title') ?></label>
			{{{ca_collections.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_collections_idno' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search collection identifiers.') ?>"><?php _p('Identifier') ?></label>
			{{{ca_collections.idno%width=210px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_collections_type_id' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search by collection level.') ?>"><?php _p('Collection level') ?></label>
			{{{ca_collections.type_id%height=30px&id=ca_collections_type_id}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for='ca_collections.dacs_date_value[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search collection of a particular date or date range.') ?>"><?php _p('Date range <i>(e.g. 1970-1979)</i>') ?></label>
			{{{ca_collections.dacs_date_value%width=200px&height=40px&useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for='ca_entities_preferred_labels' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search people, organizations and families related to collections.') ?>"><?php _p('People, Organizations and Families') ?></label>
			{{{ca_entities.preferred_labels%width=200px&height=40px}}}
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
	<div class="col-sm-4" >
		<h1><?php _p('Search For:') ?></h1>
		<p>
			<?php print caNavLink($this->request, _t("Collections"), "", "Search", "advanced", "collections"); ?><br/>
			{{{advancedCollection}}}<br/><br/>
			<?php print caNavLink($this->request, _t("Archival Items"), "", "Search", "advanced", "objects"); ?><br/>
			{{{advancedArchivalItems}}}
		</p>
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>