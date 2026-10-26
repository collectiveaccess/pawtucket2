<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>Collection Items Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class='row'><div class="advancedSearchField col-sm-12">
			<label for="ca_entities_preferred_labels" class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search creators.') ?>"><?php _p('Creator') ?></label>
			{{{ca_entities.preferred_labels.displayname/creator%width=400px&height=1}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			<label for='ca_objects_type' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to object types.') ?>"><?php _p('Type') ?></label>
			{{{ca_objects.type%width=400px&render=list}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			<label for='ca_objects_medium' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to object medium.') ?>"><?php _p('Type') ?></label>
			{{{ca_objects.medium%width=400px&height=1}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			<label for='ca_objects_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to Object Titles only.') ?>"><?php _p('Title') ?></label>
			{{{ca_objects.preferred_labels.name%width=400px&height=1}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			<label for='ca_objects_date_date_value[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records of a particular date or date range.') ?>"><?php _p('Date range <i>(e.g. 1970-1979)</i>') ?></label>
			{{{ca_objects.date.date_value%width=400px&height=25px&useDatePicker=0&height=1}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			<label for='ca_objects_idno' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search object identifiers.') ?>"><?php _p('Accession number') ?></label>
			{{{ca_objects.idno%width=210px}}}
		</div></div>
		<div class='row'><div class="advancedSearchField col-sm-12">
			<label for="_fulltext" class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search across all fields in the database.') ?>"><?php _p('Keyword') ?></label>
			{{{_fulltext%width=400px&height=1}}}
		</div></div>
		<div class='row'><div class='advancedFormSubmit'>
			<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
			<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
		</div></div>		
	</div>	

{{{/form}}}

		</div>
	</div><!-- end row -->
</div><!-- end container -->