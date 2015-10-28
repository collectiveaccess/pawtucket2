<div class="container">
	<div class="row">
		<div class="col-sm-8 col-md-6 col-lg-6">
			<h2>Objects Advanced Search</h2>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="form-group advancedSearchField">
			Title:<br/>
			{{{ca_objects.preferred_labels.name%height=25px&width=400px&class=form-control}}}
		</div>
		<div class="form-group advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=400px&height=35px&class=form-control}}}
		</div>		
		<div class="form-group advancedSearchField identifier">
			Object Identifier:<br/>
			{{{ca_objects.idno%width=100px&height=35px&class=form-control}}}
		</div>
		<div class="form-group advancedSearchField">
			Type:<br/>
			{{{ca_objects.type_id%height=25px&width=400px&class=form-control}}}
		</div>
		<div class="form-group advancedSearchField">
			Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.sourceDate%width=400px&height=25px&useDatePicker=0&class=form-control}}}
		</div>
	</div>	
	
	<br style="clear: both;"/>
	<div style="width:400px;">
		<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
		<div style="float: right;">{{{submit%label=Search}}}</div>
	</div>
{{{/form}}}

		</div>
		<div class="col-sm-4 col-md-6 col-lg-6" style='border-left:1px solid #ddd;'>
			<h2>For Researchers</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus accumsan, quam in accumsan blandit, lacus neque pretium orci, et ornare quam elit vitae metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce ac dictum nunc, eget lacinia nulla. Integer eget aliquam lectus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin pellentesque, metus vel cursus dignissim, ligula dolor imperdiet nisl, et rhoncus mauris velit non risus. Nunc ultrices scelerisque aliquet. Pellentesque vulputate massa a lacus pretium, vel sodales ligula cursus. Sed id velit vitae felis feugiat mattis. Etiam nec magna egestas, tempus felis sed, semper nunc. Cras ac condimentum lorem, non malesuada dolor. Nullam viverra eros a dui viverra, et suscipit turpis eleifend. Maecenas vitae mauris erat. Ut ut feugiat magna.</p>
			<p>Curabitur imperdiet maximus mauris, eget aliquam elit auctor non. In hac habitasse platea dictumst. Cras eget malesuada elit. Donec a viverra libero. Aenean condimentum erat et metus posuere facilisis eu eu risus. Pellentesque feugiat sem eu tellus blandit, sed molestie arcu rhoncus. Etiam non varius libero.</p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->