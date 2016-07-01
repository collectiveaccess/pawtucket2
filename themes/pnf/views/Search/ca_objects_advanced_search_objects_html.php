<div class="container advancedSearch">
	<div class="row">
		<div class="col-sm-8 ">
			<h1>Objects Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	<div class='row'>
		<div class="col-sm-12 field">
			Keyword: 
			{{{_fulltext%width=200px&height=1}}}
		</div>	
	</div>	
	<hr>
	<div class='row'>
		<div class="col-sm-6 field">
			Title:<br/>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
		<div class="col-sm-6 field">
			Accession number:<br/>
			{{{ca_objects.idno%width=210px}}}
		</div>
	</div>	
	<div class='row'>
		<div class="col-sm-6 field">
			Author:<br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=author}}}
		</div>
		<div class="col-sm-6 field">
			Printer:<br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=printer}}}
		</div>		
	</div>
	<div class='row'>
		<div class="col-sm-6 field">
			Translator:<br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=translator}}}
		</div>
		<div class="col-sm-6 field">
			Publisher:<br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=publisher}}}
		</div>			
	</div>
	<div class='row'>
		<div class="col-sm-6 field">
			Bookseller:<br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=bookseller}}}
		</div>		
	</div>	
	<hr>		
	<div class='row'>		
		<div class="col-sm-6 field">
			Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.260_date%width=200px&height=40px&useDatePicker=0}}}
		</div>
	</div>	
	<hr>
	<div class='row'>
		<div class="col-sm-6 field">
			Place of Publication:<br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=bookseller}}}
		</div>	
		<div class="col-sm-6 field">
			Institution <br/>
			{{{ca_objects.institution%width=200px&height=1}}}
		</div>			
	</div>
	<hr>
	<div class='row'>
		<div class="col-sm-6 field">
			Caption Title:<br/>
			{{{ca_objects.caption_title%width=200px&height=1}}}
		</div>	
		<div class="col-sm-6 field">
			Theme <br/>
			{{{ca_objects.650_themes%width=200px&height=1}}}
		</div>			
	</div>	
	<div class='row'>
		<div class="col-sm-6 field">
			Ornament:<br/>
			{{{ca_objects.ornaments%width=200px&height=1}}}
		</div>	
		<div class="col-sm-6 field">
			Physical Description <br/>
			{{{ca_objects.physical_description%width=200px&height=1}}}
		</div>			
	</div>		
	<div class='row'>
		<div class="col-sm-6 field">
			Local Notes:<br/>
			{{{ca_objects.590_local%width=200px&height=1}}} 
		</div>	
		<div class="col-sm-6 field">
			Ownership <br/>
			{{{ca_objects.561_ownership%width=200px&height=1}}}
		</div>			
	</div>
			
	<div class="row" style='margin-bottom:40px;'>	
		<div style="float: right; margin-left: 20px; margin-right:15px;">{{{reset%label=Reset}}}</div>
		<div style="float: right;">{{{submit%label=Search}}}</div>
	</div>
{{{/form}}}

		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;min-height:500px;'>
			<h1>Guide to Use</h1>
			<p>How to use advanced search.</p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->