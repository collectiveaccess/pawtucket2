
<div class="row">
	<div class="col-md-4 col-md-offset-2">
		<h1><?php _p('Archives Advanced Search') ?></h1>

        <p><?php _p("Enter your search terms in the fields below."); ?></p>

	</div>
	<div class="col-md-4 formLinks">
		<?php print caNavLink($this->request, "Objects Advanced Search <span class='glyphicon glyphicon-new-window'></span>", "btn btn-default", "Search", "advanced", "objects"); ?>
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
			<label for='ca_collections_preferred_labels' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records within a particular collection.') ?>"><?php _p('Collection') ?></label>
			{{{ca_collections.preferred_labels%restrictToTypes=collection%width=200px&height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_collections_source' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search collections by institution.') ?>"><?php _p('Institution') ?></label>
			{{{ca_collections.source_id%width=200px&height=1}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_collections_idno' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search collection identifier.') ?>"><?php _p('Collection Identifier') ?></label>
			{{{ca_collections.idno%width=200px&height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_entities' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search collections by their creator.') ?>"><?php _p('Creator') ?></label>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=creator&width=200px&height=1}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<label for='ca_entities' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search collections by related people or institutions.') ?>"><?php _p('Related People and Institutions') ?></label>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=related&width=200px&height=1}}}
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