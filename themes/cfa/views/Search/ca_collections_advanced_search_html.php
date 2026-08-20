<div class="row my-3 mx-3">
	<div class="col-sm-8 " style=''>
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
					<label for='ca_collections_idno' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search object identifiers.') ?>"><?php _p('Identifier #') ?></label>
					{{{ca_collections.idno%width=210px}}}
				</div>
				<div class="advancedSearchField col-sm-6">
					<label for='ca_collections_type_id' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to object types.') ?>"><?php _p('Type') ?></label>
					{{{ca_collections.type_id%height=30px&id=ca_collections_type_id}}}
				</div>
				<div class="advancedSearchField col-sm-6">
					<label for='ca_occurrences.cfaDateProduced' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records of a particular date or date range.') ?>"><?php _p('Date of Production') ?></label>
					{{{ca_occurrences.cfaDateProduced%width=200px&height=40px&useDatePicker=0}}}
				</div>
			</div>
			<br style="clear: both;"/>
			<div class='advancedFormSubmit'>
				<span class='btn' style="color: #fff; background-color: #007ABF;">{{{reset%label=Reset}}}</span>
				<span class='btn' style="color: #fff; background-color: #007ABF; margin-left: 20px;">{{{submit%label=Search}}}</span>
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