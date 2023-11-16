<div class="row">
	<div class="col-sm-12 col-md-8 col-md-offset-2">
		<div class="row">
			<div class="col-sm-12 col-md-5"><h1><?php _p("Programming, Events, & Projects") ?></h1></div>
			<div class="col-sm-12 col-md-7 advancedSearchNav"><b>Search other record types:</b> <?php print caNavLink($this->request, "Objects", "", "Search", "advanced", "objects"); ?> | <?php print caNavLink($this->request, "People & Organizations", "", "Search", "advanced", "entities"); ?></div>
		</div>
		

        <p><?php _p("Enter your search terms in the fields below."); ?></p>
{{{form}}}
<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for="_fulltext" class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search across all fields in the database.') ?>"><?php _p('Keyword') ?></label>
			<div class="sr-only"><?php _p('Search across all fields in the database.') ?></div>
			{{{_fulltext%width=200px&height=1}}}
		</div>			
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<label for='ca_occurrences_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to the names of programs, events, and projects.') ?>"><?php _p('Name') ?></label>
			<div class="sr-only"><?php _p('Limit your search to the names of programs, events, and projects.') ?></div>
			{{{ca_occurrences.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_occurrences_idno' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search by record identifiers.') ?>"><?php _p('Identifier') ?></label>
			<div class="sr-only"><?php _p('Search by record identifiers.') ?></div>
			{{{ca_occurrences.idno%width=210px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_occurrences_program_type[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to program types.') ?>"><?php _p('Program Type') ?></label>
			<div class="sr-only"><?php _p('Limit your search to program types.') ?></div>
			{{{ca_occurrences.program_type%height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_occurrences_occurrence_date[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records of a particular date or date range.') ?>"><?php _p('Date range <i>(e.g. 1990-1992)</i>') ?></label>
			<div class="sr-only"><?php _p('Search records of a particular date or date range.') ?></div>
			{{{ca_occurrences.occurrence_date%width=200px&height=1px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_occurrences_language[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to language.') ?>"><?php _p('Language') ?></label>
			<div class="sr-only"><?php _p('Limit your search to language.') ?></div>
			{{{ca_occurrences.language%height=1}}}
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