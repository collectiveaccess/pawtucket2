
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
						
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						<div class="container">
							<div class="row">
								<div class="col-sm-12 " style="margin-top:20px;">
		<h4>Publications Advanced Search<small> or <?php print caNavLink($this->request, 'Search Entities', '', '', 'Search', 'advanced/entities');?></small></h4>

		<?php			
			print "<p>Enter your search terms in the fields below.</p>";
		?>

		{{{form}}}

			<div class='advancedContainer'>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Title:<br/>
						{{{ca_objects.preferred_labels.name%width=220px}}}
					</div>
					<div class="advancedSearchField">
						Author:<br/>
						{{{ca_entities.preferred_labels.name%width=220px&restrictToRelationshipTypes=author}}}
					</div>
					<div class="advancedSearchField">
						Publication Date<i> (e.g. 1650-1750)</i><br/>
						{{{ca_objects.publication_date%width=200px&height=40px&useDatePicker=0}}}
					</div>
				</div>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Publication Location<br/>
						{{{ca_objects.publication_place.publication_place_text%width=200px&height=25px}}}
					</div>												
					<div class="advancedSearchField">
						Keyword<br/>
						{{{_fulltext%width=200px&height=25px}}}
					</div>				
					<div class="advancedSearchField">
						Reader:<br/>
						{{{ca_entities.preferred_labels.name%width=220px&restrictToRelationshipTypes=reader}}}
					</div>
				</div>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Reader Occupation:<br/>
						{{{ca_entities.industry_occupations%width=220px&restrictToRelationshipTypes=reader}}}
					</div>	
					<div class="advancedSearchField">
						Reader Gender:<br/>
						{{{ca_entities.gender%width=220px&restrictToRelationshipTypes=reader}}}
					</div>
				</div>								
				<br style="clear: both;"/>

				<div class='advButton' style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
				<div class='advButton' style="float: right;">{{{submit%label=Search}}}</div>
			</div>	


		{{{/form}}}

								</div><!-- end col -->
							</div><!-- end row -->
						</div><!-- end container -->
					</div><!-- end col -->
				</div><!-- end row --></div><!-- end container -->
			</div><!-- end content-inner -->
		</div><!-- end content-wrapper -->
	</div><!-- end wrapper -->
</div><!-- end page -->