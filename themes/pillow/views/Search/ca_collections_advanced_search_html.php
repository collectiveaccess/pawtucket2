<div class="container">
	<div class="row">
		<div class="col-sm-1 "></div>
		<div class="col-sm-10 staticPageArea">
			<div class="container">
				<div class="row">
				
				
		<div class="col-sm-8 ">
			<h4>Collections Advanced Search</h4>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>
{{{form}}}	
	<div class='advancedContainer row'>	
		<div class='col-sm-12 col-md-12 col-lg-12'>		
			<div class="advancedSearchField">
				Keyword<br/>
				{{{_fulltext%width=380px&height=25px}}}
			</div>
		</div>
		<div class='col-sm-12 col-md-12 col-lg-12'>			
			<div class="advancedSearchField">
				Title:<br/>
				{{{ca_objects.preferred_labels.name%width=380px}}}
			</div>
		</div>	
		<div class='col-sm-12 col-md-12 col-lg-12'>		
			<div class="advancedSearchField">
				Date or Date range <i>(e.g. 1970-1979)</i><br/>
				{{{ca_objects.unitdate.date_value%width=380px&height=40px&useDatePicker=0}}}
			</div>
		</div>	
		<div class='col-sm-12 col-md-12 col-lg-12'>			
			<div class="advancedSearchField">
				Collection Identifier:<br/>
				{{{ca_collections.idno%width=53}}}
			</div>
		</div>
		<div class='col-sm-12 col-md-12 col-lg-12'>		
			<div class="advancedSearchField">
				Type:<br/>
				{{{ca_collections.type_id%width=380px}}}
			</div>
		</div>
		<div class='col-sm-12 col-md-12 col-lg-12'>		
			<div class="advancedSearchField">
				Storage Location <br/>
				{{{ca_storage_locations.preferred_labels%width=380px&height=40px}}}
			</div>
		</div>						
		<br style="clear: both;"/>
		<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
		<div style="float: right;">{{{submit%label=Search}}}</div>	
	</div>	
{{{/form}}}

		</div><!-- end col -->
		<div class="col-sm-4" style='border-left:1px solid #ddd; min-height:650px;'>
			<h2 style='margin-top:60px; margin-bottom:30px;'>Helpful Links</h2>
			<p><a href='http://danceinteractive.jacobspillow.org/' target='_blank'>Jacob’s Pillow Dance Interactive</a></p>
			<p><a href='http://jacobspillow.org/' target='_blank'>Jacob’s Pillow Home</a></p>
		</div><!-- end col -->
			</div></div>
			</div>
		<div class='col-sm-1'></div>
	</div><!-- end row -->
</div><!-- end container -->