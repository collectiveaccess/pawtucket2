<div class="container">
	<div class="row">
		<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
			<h1>Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Keyword search of all fields."
			>All Fields:</span><br/>
			{{{_fulltext%width=300px&height=25px}}}
		</div>
		
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Search one of the VHEC’s four collections."
			>Collection Type:</span><br/>
			{{{ca_objects.type_id%width=300px}}}
		</div>
		<div class="advancedSearchField">
			Resource Type:<br/>
			{{{ca_objects.resource_type%width=300px}}}
		</div>	
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The unique identifier assigned to a record. For the Archives this is the Identifier, Museum and Testimony collections this is the Object Identifier. For the library is the Barcode or Call Number."
			>Object ID:</span><br/>
			{{{ca_objects.altID%width=300px&height=23px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The title of the record assigned by the creator or cataloguer."
			>Title:</span><br/>
			{{{ca_objects.preferred_labels.name%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Local thesaurus terms used to describe the subject and content of the item."
			>Subject:</span><br/>
			{{{ca_objects.local_subject%width=300px&height=23px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="The particular kind of object described in a record. This is a curated list that reflects the contents of the VHEC’s collection."
			>Genre:</span><br/>
			{{{ca_objects.cdwa_work_type%width=300px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Individuals and organizations related to an item."
			>People & Organizations:</span><br/>
			{{{ca_entities.preferred_labels%width=420px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Language(s) associated with an item."
			>Language:</span><br/>
			{{{ca_objects.language%width=300px&height=23px}}}
		</div>
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Places associated with an item; including both contemporary geographic locations and historical places, such as camps and ghettos."
			>Place:</span> <br/>
			{{{ca_places.preferred_labels%width=300px}}}
		</div>																				
		<div class="advancedSearchField">
			<span 
				data-toggle="popover" data-trigger="hover" data-content="Limit searching to records with media."
			>Only Digital Collections:</span><br/>
			{{{ca_object_representations.media%width=300px&height=23px&render=is_set}}}
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