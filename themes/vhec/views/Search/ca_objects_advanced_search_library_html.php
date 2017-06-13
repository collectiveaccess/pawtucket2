<div class="container">
	<div class="row">
		<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
			<h1>Library Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="All front end record fields."
			>Keyword (All Fields):</span><br/>
			{{{_fulltext%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span>Resource Type:</span><br/>
			{{{ca_objects.resource_type%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The physical storage medium of the item."
			>Carrier:</span><br/>
			{{{ca_objects.carrier_type_library%width=300px&height=1}}}
		</div>		
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The code assigned to a library item to indicate where in the library it can be found."
			>Call Number:</span><br/>
			{{{ca_objects.MARC_localNo%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span >ISBN/ISSN:</span><br/>
			{{{ca_objects.MARC_isbn%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The title of the work assigned by the creator or cataloguer."
			>Title:</span><br/>
			{{{ca_objects.preferred_labels.name%width=300px}}}
		</div>		
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Individuals and organizations responsible for the creation of a work, and individuals and organizations contributing to an expression of a work."
			>Creators & Contributors: </span><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=creator;author;illustrator;artist;composer;contributor;curator;director;editor;filmmaker;funder;interviewee;interviewer;narrator;organizer;performer;photographer;producer;researcher;speaker;subject;translator;videographer;other%width=420px}}}
		</div>	
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="All individuals or organizations associated with a work, including those that are the subject of a work."
			>People & Organizations: </span><br/>
			{{{ca_entities.preferred_labels%width=420px}}}
		</div>	
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Local thesaurus terms used to describe what the library work is about."
			>Local Subject Headings:</span><br/>
			{{{ca_objects.LOC_text%width=300px&height=1}}}
		</div>	
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Library of Congress Subject Headings used to describe what the library work is about."
			>Library of Congress Subject Headings Keyword Search:</span><br/>
			{{{ca_objects.LOC_text%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Places associated with a work, which can include both contemporary geographic regions as well as historical places (including camps and ghettos)."
			>Places: </span><br/>
			{{{ca_places.preferred_labels%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Language of the work."
			>Language:</span><br/>
			{{{ca_objects.language%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Indexing date of a work, which can be entered as a single date, approximate date, or a date range."
			>Date <i>(e.g. 1970-1979):</i></span><br/>
			{{{ca_objects.indexingDatesSet%width=300px&height=25px&useDatePicker=0}}}
		</div>																											
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search for items in the library’s special and designated collections."
			>Sub-Collection:</span><br/>
			{{{ca_objects.sub_collection%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search items by publicly available donor names and dedications."
			>Public Recognition:</span><br/>
			{{{ca_objects.MARC_sourceAcq%width=300px&height=1}}}
		</div>														
		<br style="clear: both;"/>
	
		<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
		<div style="float: right;">{{{submit%label=Search}}}</div>
	
	</div>	
	

{{{/form}}}

		</div>
		<div class="col-sm-4" >
			<h1>Helpful Hints</h1>
			<p>Include some helpful info for your users here.</p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField span').popover(); 
	});
	
</script>