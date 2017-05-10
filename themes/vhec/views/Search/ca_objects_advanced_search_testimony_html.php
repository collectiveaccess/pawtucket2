<div class="container">
	<div class="row">
		<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
			<h1>Holocaust Testimony Advanced Search</h1>

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
			<span>Resource Type:</span><br/>
			{{{ca_objects.resource_type%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span
				data-toggle="popover" data-trigger="hover" data-content="The unique alphanumeric identifier assigned to testimony holdings."
			>Unique ID:</span><br/>
			{{{ca_objects.alt_id%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The title of the record assigned by the creator or cataloguer."
			>Title:</span><br/>
			{{{ca_objects.preferred_labels.name%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Recording date of a testimony, which can be entered as a single date, approximate date, or a date range."
			>Recording Date </span><br/>
			{{{ca_objects.indexingDatesSet%width=300px&height=1&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search for the individual(s) who conducted the interview."
			>Interviewer: </span><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=interviewer&width=420px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search for the individual(s) who were interviewed."
			>Interviewee: </span><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=interviewee&width=420px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Other individuals or organizations involved in the creation or production of the testimony recording. "
			>Additional Creators & Contributors: </span><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=creator;author;illustrator;artist;composer;contributor;curator;director;editor;filmmaker;funder;narrator;organizer;performer;photographer;producer;researcher;speaker;subject;translator;videographer;other%width=420px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Language spoken during the testimony recording."
			>Language:</span><br/>
			{{{ca_objects.language%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search recordings by associated donor funding."
			>Funding Note:</span><br/>
			{{{ca_objects.funding_note%width=300px&height=1}}}
		</div>																	
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Local thesaurus terms used to describe subjects referred to in the testimony. "
			>Subject – Topical :</span><br/>
			{{{ca_objects.local_subject%width=300px&height=1}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search for places that are the subject of a testimony. Places can include both contemporary geographic regions as well as historical places (including camps and ghettos)."
			>Subject - Place: </span><br/>
			{{{ca_places.preferred_labels%restrictToRelationshipTypes=subject}}}
		</div>		
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search for individuals or organizations who are the subject of a testimony."
			>Subject - People & Organizations: </span><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=subject}}}
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