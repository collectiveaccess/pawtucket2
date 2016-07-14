<div class="container">
	<div class="row">
		<div class="col-sm-8 ">
			<h1>Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			All Fields<br/>
			{{{_fulltext%width=300px&height=25px}}}
		</div>
		<div class="advancedSearchField">
			Genre:<br/>
			{{{ca_objects.cdwa_work_type%width=300px}}}
		</div>
		<div class="advancedSearchField">
			Object ID:<br/>
			{{{ca_objects.altID%width=300px&height=23px}}}
		</div>						
		<div class="advancedSearchField">
			Title:<br/>
			{{{ca_objects.preferred_labels.name%width=300px}}}
		</div>
		<div class="advancedSearchField">
			Date of Creation <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.indexingDatesSet%width=300px&height=25px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField">
			Creator <br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=creator;artist;photographer%width=420px}}}
		</div>
		<div class="advancedSearchField">
			Places <br/>
			{{{ca_places.preferred_labels%width=300px}}}
		</div>				
		<div class="advancedSearchField">
			Provenance:<br/>
			{{{ca_objects.dc_provenance%width=300px&height=23px}}}
		</div>
		<div class="advancedSearchField">
			Classification:<br/>
			{{{ca_objects.classification%width=300px&height=23px&render=checklist}}}
		</div>
		<div class="advancedSearchField">
			Materials/Techniques:<br/>
			{{{ca_objects.cdwa_displayMaterialsTech%width=300px&height=23px}}}
		</div>
		<div class="advancedSearchField">
			Language:<br/>
			{{{ca_objects.language%width=300px&height=23px}}}
		</div>	
		<div class="advancedSearchField">
			Funding Note:<br/>
			{{{ca_objects.funding_note%width=300px&height=23px}}}
		</div>
		<div class="advancedSearchField">
			Access Points:<br/>
			{{{ca_objects.local_subject%width=300px&height=23px}}}
		</div>
		<div class="advancedSearchField">
			Subject - People & Organizations:<br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=subject&width=300px&height=23px}}}
		</div>	
		<div class="advancedSearchField">
			Only Digital Collections:<br/>
			{{{ca_object_representations.media%width=300px&height=23px&render=is_set}}}
		</div>											
		<br style="clear: both;"/>
	
		<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
		<div style="float: right;">{{{submit%label=Search}}}</div>
	
	</div>	
	

{{{/form}}}

		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;'>
			<h1>Helpful Hints</h1>
			<p>Include some helpful info for your users here.</p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->