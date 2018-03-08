	<div class="row">
		<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
			<h1>Archives Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Keyword search of all record fields."
			>Keyword (All Fields):</span><br/>
			{{{_fulltext%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The documentary form of an archival item."
			>Resource Type:</span><br/>
			{{{ca_objects.resource_type%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The unique identifier assigned to an archival item."
			>Object ID:</span><br/>
			{{{ca_objects.objectIdno%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search all archival records within a collection."
			>Fonds or Collection: </span><br/>
			{{{ca_collections.preferred_labels%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The title of the item assigned by the creator or cataloguer."
			>Title of item:</span><br/>
			{{{ca_objects.preferred_labels.name%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Creation date of an item, which can be entered as a single date, approximate date, or a date range."
			>Date(s) of Creation <i>(e.g. 1970-1979):</i></span><br/>
			{{{ca_objects.indexingDatesSet%width=300px&height=1&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The individual credited as the creator of the work. Please note that while many works have unknown creators, a search of "unknown" will not return any of these records."
			>Creator: </span><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=creator;author;illustrator;artist;composer;contributor;curator;director;editor;filmmaker;funder;interviewee;interviewer;narrator;organizer;performer;photographer;producer;researcher;speaker;subject;translator;videographer;other%width=420px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Local thesaurus terms used to describe our collection."
			>Subject Access Points:</span><br/>
			{{{ca_objects.local_subject%width=300px&height=1}}}
		</div>															
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The particular kind of archival item described in a record. This is a curated list that reflects the contents of the VHEC’s collection."
			>Genre:</span><br/>
			{{{ca_objects.genre%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Places associated with an archival item can include both contemporary geographic regions as well as historical places."
			>Places: </span><br/>
			{{{ca_places.preferred_labels%width=300px}}}
		</div>				
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Language of the item, where applicable."
			>Language:</span><br/>
			{{{ca_objects.RAD_langMaterial%width=300px&height=1}}}
		</div>	
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search items by associated donor funding."
			>Funding Note:</span><br/>
			{{{ca_objects.funding_note%width=300px&height=1}}}
		</div>	
		
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Limit searching to born-digital archival records."
			>Born Digital:</span><br/>
			{{{ca_objects.born_digital%width=300px&height=1}}}
		</div>													
		<br style="clear: both;"/>
	
		<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
		<div style="float: right;">{{{submit%label=Search}}}</div>
	
	</div>	
	

{{{/form}}}

		</div>
		<div class="col-sm-4 searchHints" >
			<H1>Helpful Hints</H1>
			{{{search_help}}}
		</div><!-- end col -->
	</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField span').popover(); 
	});
	
</script>