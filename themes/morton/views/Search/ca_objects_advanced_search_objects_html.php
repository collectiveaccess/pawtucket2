<div class="container">
	<div class="row">
		<div class="col-sm-8 ">
			<h1>Objects Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer row'>
		<div class='col-sm-6 col-md-6 col-lg-6'>
			<div class="advancedSearchField">
				Title:<br/>
				{{{ca_objects.preferred_labels.name%width=240px}}}
			</div>
		</div>
		<div class='col-sm-6 col-md-6 col-lg-6'>
			<div class="advancedSearchField">
				Type:<br/>
				{{{ca_objects.type_id}}}
			</div>
		</div>	
		<div class='col-sm-6 col-md-6 col-lg-6'>			
			<div class="advancedSearchField">
				Keyword<br/>
				{{{_fulltext%width=240px&height=25px}}}
			</div>
		</div>	
		<div class='col-sm-6 col-md-6 col-lg-6'>	
			<div class="advancedSearchField">
				Date range <i>(e.g. 1970-1979)</i><br/>
				{{{ca_objects.date.date_value%width=240px&height=40px&useDatePicker=0}}}
			</div>
		</div>	
		<div class='col-sm-6 col-md-6 col-lg-6'>
			<div class="advancedSearchField">
				Collection <br/>
				{{{ca_collections.preferred_labels%width=240px&height=40px}}}
			</div>
		</div>	
	</div>	
	
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}

		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;'>
			<h1>Other Resources</h1>
			<p><a href='http://www.mortonarb.org/visit-explore/sterling-morton-library' target='_blank'>Sterling Morton Library Home</a></p>
			<p><a href='https://catalog.swanlibraries.net/client/en_US/mas' target='_blank'>Search the Library Catalog</a></p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->