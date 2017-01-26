<div class="container">
	<div class="row">
		<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
			<h1>Objects Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
<div class="advancedContainer">	
	<div class='row'>
		<div  class="col-sm-12">
			<div class="advancedSearchField">
				Keyword<br/>
				{{{_fulltext%width=200px&height=1}}}
			</div>
		</div>		
		<div class="col-sm-12">
			<div class="advancedSearchField">
				Title:<br/>
				{{{ca_objects.preferred_labels.name%width=220px&height=1}}}
			</div>	
		</div>
	</div>
	<div class="row">	
		<div class="col-sm-6">
			<div class="advancedSearchField">
				Type:<br/>
				{{{ca_objects.type_id}}}
			</div>
		</div>
		<div class="col-sm-6">
			<div class="advancedSearchField">
				Project:<br/>
				{{{ca_objects.project}}}
			</div>	
		</div>
	</div>
	<div class="row">			
		<div class="col-sm-12">
			<div class="advancedSearchField">
				Date range <i>(e.g. 1970-1979)</i><br/>
				{{{ca_objects.productionDate%height=1&useDatePicker=0}}}
			</div>
		</div>
		<div class="col-sm-12">
			<div class="advancedSearchField">
				Description:<br/>
				{{{ca_objects.description%width=200px&height=34px}}}
			</div>
		</div>
	</div>
	<div class="row">		
		<div class="col-sm-6">
			<div class="advancedSearchField">
				Keywords:<br/>
				{{{ca_objects.keywords}}}
			</div>
		</div>
		<div class="col-sm-6">
			<div class="advancedSearchField">
				Language:<br/>
				{{{ca_objects.pbcoreLanguage}}}
			</div>	
		</div>	
	</div>
	<div class="row">			
		<div class="col-sm-12">
			<div class="advancedSearchField">
				People & Organizations <br/>
				{{{ca_entities.preferred_labels%width=200px&height=1}}}
			</div>	
		</div>				
		<div class="col-sm-12">
			<div class="advancedSearchField">
				Collection <br/>
				{{{ca_collections.preferred_labels%width=200px&height=1}}}
			</div>	
		</div>
	</div>	
	
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
</div>	
{{{/form}}}

		</div><!-- end col -->
		<div class="col-sm-4" >
			<h1>Helpful Links</h1>
			<p>Include some helpful info for your users here.</p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->