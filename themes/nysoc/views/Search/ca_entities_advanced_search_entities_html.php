<?php
	$va_home = caNavLink($this->request, "Project Home", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > Advanced Search");

?>
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
		<h4>Entities Advanced Search<small> or <br/>
		<?php print caNavLink($this->request, 'Search Publications', '', '', 'Search', 'advanced/objects');?> | 
		<?php print caNavLink($this->request, 'Search Borrowing History', '', '', 'Search', 'advanced/entities');?> | 
		<?php print caNavLink($this->request, 'Search Collections', '', '', 'Search', 'advanced/docs');?>
		</small></h4>
		<?php			
			print "<p>Enter your search terms in the fields below.</p>";
		?>

		{{{form}}}

			<div class='advancedContainer'>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Keyword<br/>
						{{{_fulltext%width=680px&height=25px}}}
					</div>
				</div>			
				<div class='advancedUnit'>
					<h3>Entity Information</h3>
					<div class="advancedSearchField">
						Name:<br/>
						{{{ca_entities.preferred_labels.name%width=220px}}}
					</div>
					<div class="advancedSearchField">
						Type:<br/>
						{{{ca_entities.type_id%width=220px}}}
					</div>					
					<div class="advancedSearchField">
						Occupation:<br/>
						{{{ca_entities.industry_occupations%width=220px}}}
					</div>
				</div>	
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Country of Origin:<br/>
						{{{ca_entities.country_origin%width=220px}}}
					</div>					
					<div class="advancedSearchField">
						Gender:<br/>
						{{{ca_entities.gender%width=220px}}}
					</div>
					<div class="advancedSearchField">
						Relationship to the Library:<br/>
						{{{ca_entities.relationship_to_library%width=220px}}}
					</div>					
				</div>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Lifedates<br/>
						{{{ca_entities.life_dates%width=200px&height=25px}}}
					</div>																				
				</div>	
				<div class='advancedUnit'>
					<h3>Circulation Information</h3>
					<div class="advancedSearchField">
						Date Out:<br/>
						{{{ca_objects_x_entities.date_out%width=220px}}}
					</div>
					<div class="advancedSearchField">
						Date In:<br/>
						{{{ca_objects_x_entities.date_in%width=220px}}}
					</div>	
					<div class="advancedSearchField">
						Fine:<br/>
						{{{ca_objects_x_entities.fine%width=220px&height=25px}}}
					</div>
				</div>	
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Representative:<br/>
						{{{ca_objects_x_entities.representative%width=220px&height=25px}}}
					</div>
					<div class="advancedSearchField">
						Uncertain Transcription:<br/>
						{{{ca_objects_x_entities.see_original%width=220px}}}
					</div>
				</div>											
				<br style="clear: both;"/>

				<div class='advButton' style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
				<div class='advButton' style="float: right;">{{{submit%label=Search}}}</div>
				<br style="clear: both;"/>
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