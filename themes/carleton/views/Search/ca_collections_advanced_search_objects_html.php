
<div class="row">
	<div class="col-sm-12 col-md-8">
		<h1><?php _p('Collections Advanced Search') ?></h1>

        <p><?php _p("Enter your search terms in the fields below."); ?></p>
		{{{form}}}

		<div class='advancedContainer'>
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<label for="_fulltext" class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search across all fields in the database including document text.') ?>"><?php _p('Keyword (Including Document Text)') ?></label>
					{{{_fulltext%width=200px&height=1}}}
				</div>			
			</div>		
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<label for='ca_collections_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to Collection titles only.') ?>"><?php _p('Title') ?></label>
					{{{ca_collections.preferred_labels.name%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<label for='ca_collections_col_classification' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records by classification.') ?>"><?php _p('Classification') ?></label>
					{{{ca_collections.col_classification%width=200px&height=40px&}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-6">
					<label for='ca_collections_material_type' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search material type.') ?>"><?php _p('Material Type') ?></label>
					{{{ca_collections.material_type%width=210px}}}
				</div>
				<div class="advancedSearchField col-sm-6">
					<label for='ca_collections_type_id' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to collection types.') ?>"><?php _p('Type') ?></label>
					{{{ca_collections.type_id%height=30px&id=ca_collections_type_id}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<label for='ca_objects.inclusive_dates[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records of a particular date or date range.') ?>"><?php _p('Date range <i>(e.g. 1970-1979)</i>') ?></label>
					{{{ca_collections.inclusive_dates%width=200px&height=40px&useDatePicker=0}}}
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