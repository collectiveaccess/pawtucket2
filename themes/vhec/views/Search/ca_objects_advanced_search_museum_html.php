	<div class="row">
		<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
			<h1>Museum Advanced Search</h1>

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
				data-toggle="popover" data-trigger="hover" data-content="The particular kind of object described in a record. This is a curated list that reflects the contents of the VHEC’s collection."
			>Genre:</span><br/>
			{{{ca_objects.genre%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The unique identifier assigned to a work. Traditionally an accession number, Museum Works are assigned a barcode identifier."
			>Object ID:</span><br/>
			{{{ca_objects.alt_id%width=300px&height=1}}}
		</div>						
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The title of the work assigned by the creator or cataloguer."
			>Title:</span><br/>
			{{{ca_objects.preferred_labels.name%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Creation date of a work, which can be entered as a single date, approximate date, or a date range. "
			>Date of Creation <i>(e.g. 1970-1979)</i></span><br/>
			{{{ca_objects.indexingDatesSet%width=300px&height=25px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The individual credited as the creator of the work. Please note that while many works have unknown creators, a search of “unknown” will not return any of these records."
			>Creator </span><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=creator;author;illustrator;artist;composer;contributor;curator;director;editor;filmmaker;funder;interviewee;interviewer;narrator;organizer;performer;photographer;producer;researcher;speaker;subject;translator;videographer;other%width=420px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Places associated with a work can include both contemporary geographic locations as well as historical places (including camps and ghettos)."
			>Places: </span><br/>
			{{{ca_places.preferred_labels%width=300px}}}
		</div>				
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Classification terms are applied from the Getty’s Art & Architecture Thesaurus®"
			>Classification:</span><br/>
			{{{ca_objects.classification%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Materials used in the creation of the work as well as a description of any particular methods or techniques applied by the creator."
			>Materials/Techniques:</span><br/>
			{{{ca_objects.cdwa_displayMaterialsTech%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Language of the work, where applicable."
			>Language:</span><br/>
			{{{ca_objects.language%width=300px&height=1}}}
		</div>	
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search objects by associated donor funding."
			>Funding Note:</span><br/>
			{{{ca_objects.funding_note%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Local thesaurus terms used to describe Local thesaurus terms used to describe the subject and content of the work."
			>Access Points:</span><br/>
			{{{ca_objects.local_subject%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search for individuals who are the subject of a work. "
			>Subject - People & Organizations:</span><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=artist,author,compiler,contributor,creator,curator,director,editor,filmmaker,funder,illustrator,interviewee,interviewer,narrator,organizer,other,performer,photographer,producer,related_ob,repository,researcher,speaker,subject,translator,venue,videographer&width=300px&height=1}}}
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