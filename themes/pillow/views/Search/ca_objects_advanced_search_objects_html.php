<div class="container">
	<div class="row">
		<div class="col-sm-8 ">
			<h1>Objects Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer row'>
	<div class='col-sm-12 col-md-12 col-lg-12' style='height:60px;'>	
		<div class="advancedSearchField">
			Title:<br/>
			{{{ca_objects.preferred_labels.name%width=380px}}}
		</div>
	</div>	
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			Entity <br/>
			{{{ca_entities.preferred_labels.displayname%width=380px&height=25px}}}
			<!-- {{{ca_entities.preferred_labels.displayname:relationshipTypes%width=180px&height=90px&multiple=1}}} -->
			<br style='clear: both;'/>
		</div>
	</div>		
	<div class='col-sm-12 col-md-12 col-lg-12'>			
		<div class="advancedSearchField">
			Object Identifier:<br/>
			{{{ca_objects.idno%width=53}}}
		</div>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			Type:<br/>
			{{{ca_objects.type_id%width=380px}}}
		</div>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			Collection <br/>
			{{{ca_collections.collection_id%restrictToTypes=collection%width=380px&height=40px&select=1&sort=ca_collections.preferred_labels.name&inUse=1}}}
		</div>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=380px&height=25px}}}
		</div>
	</div>	
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			Date or Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.date%width=380px&height=40px&useDatePicker=0}}}
		</div>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			Venue<br/>
			{{{ca_objects.venue%width=380px&height=40px0}}}
		</div>
	</div>						
	

	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>	

	</div>	
	

{{{/form}}}

		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;'>
			<h1>Helpful Links</h1>
			<p>Include some helpful info for your users here.</p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->