<?php
	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
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
		<h4>Books Advanced Search<small> or <br/>
		<!--<a href='#' class='advancedSearchSelected'>Search Books</a> | -->
		<?php print caNavLink($this->request, 'Search People & Organizations', '', '', 'Search', 'advanced/entities');?> | 
		<?php print caNavLink($this->request, 'Search Borrowing History', '', '', 'Search', 'advanced/borrowing');?> | 
		<?php print caNavLink($this->request, 'Search Digital Collections', '', '', 'Search', 'advanced/docs');?>
		</small></h4>



		{{{form}}}

			<div class='advancedContainer'>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Keyword: <i class="fa fa-info-circle" id='keyword'></i><br/>
<?php
						TooltipManager::add('#keyword', "Enter keywords or use <a href='http://www.lib.berkeley.edu/TeachingLib/Guides/Internet/Boolean.pdf' target='_blank'>Boolean operators</a> for more complex searches."); 
?>						
						{{{_fulltext%width=680px&height=1&label=Keywords}}}
					</div>
				</div>	
				<div class='advancedUnit'>
					<h3>Publication Information</h3>
					<div class="advancedSearchField">
						Title:<br/>
						{{{ca_objects.preferred_labels.name%width=220px&label=Title}}}
					</div>
					<div class="advancedSearchField">
						Author:<br/>
						{{{ca_entities.preferred_labels.displayname%width=220px&restrictToRelationshipTypes=author&label=Author}}}
					</div>
					<div class="advancedSearchField">
						Author Gender:<br/>
						{{{ca_entities.gender%width=220px&restrictToRelationshipTypes=author&label=Author+gender}}}
					</div>
				</div>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Printer/Publisher:<br/>
						{{{ca_objects.printing_pub_details%width=220px&label=Printer/Publisher}}}
					</div>				
					<div class="advancedSearchField">
						Publication Date<i> (e.g. 1650-1750)</i>: <br/>
						{{{ca_objects.publication_date%width=200px&height=40px&useDatePicker=0&label=Publication+date}}}
					</div>
					<div class="advancedSearchField">
						Publication Location: <br/>
						{{{ca_objects.publication_place.publication_place_text%width=200px&height=1&label=Publication+location}}}
					</div>																				
				</div>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						1813 Subjects: <i class="fa fa-info-circle" id='subjects1813'></i><br/>
<?php
						TooltipManager::add('#subjects1813', "Search for books by subject classification in the ".caNavLink($this->request, "Library's 1813 print catalog.", '', '', 'Detail', 'objects/7')); 
?>						
						{{{ca_objects.subjects_1813%width=220px&label=1813+subjects}}}
					</div>
					<div class="advancedSearchField">
						1838 Subjects: <i class="fa fa-info-circle" id='subjects1838'></i><br/>
<?php
						TooltipManager::add('#subjects1838', "Search for books by subject classification in the ".caNavLink($this->request, "Library's 1838 print catalog.", '', '', 'Detail', 'objects/11555')); 
?>							
						{{{ca_objects.subjects_1838%width=220px&label=1838+subjects}}}
					</div>	

					<div class="advancedSearchField">
						1850 Subjects: <i class="fa fa-info-circle" id='subjects1850'></i><br/>
<?php
						TooltipManager::add('#subjects1850', "Search for books by subject classification in the ".caNavLink($this->request, "Library's 1850 print catalog.", '', '', 'Detail', 'objects/9')); 
?>							
						{{{ca_objects.Analytical_Catalog_1850%width=220px&label=1850+subjects}}}
					</div>																													
				</div>	
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Current Subjects: <i class="fa fa-info-circle" id='subjects'></i><br/>
					
						{{{ca_objects.LCSH%width=200px&height=1&label=Current+subjects}}}
					</div>
					<div class="advancedSearchField">
						Collection Status: <i class="fa fa-info-circle" id='collection'></i><br/>
<?php
						TooltipManager::add('#collection', "Search for books based on their availability at the New York Society Library today."); 
?>						
						{{{ca_objects.collection_status%width=220px&label=Collection+status}}}
					</div>																								
				</div>							
				<div class='advancedUnit'>
					<h3>Personal or Organizational Details</h3> 
					<div class="advancedSearchField">
						Reader:<br/>
						{{{ca_entities.preferred_labels.displayname%width=220px&restrictToRelationshipTypes=reader&label=Reader}}}
					</div>
					<div class="advancedSearchField">
						Reader Occupation:<br/>
						{{{ca_entities.industry_occupations%width=220px&restrictToRelationshipTypes=reader&label=Reader+occupation}}}
					</div>	
					<div class="advancedSearchField">
						Reader Gender:<br/>
						{{{ca_entities.gender%width=220px&restrictToRelationshipTypes=reader&label=Reader+gender}}}
					</div>
				</div>	
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Reader Country of Origin:<br/>
						{{{ca_entities.country_origin%width=220px&restrictToRelationshipTypes=reader&label=Reader+country}}}
					</div>																				
				</div>
				<div class='advancedUnit'>
					<h3>Circulation Information</h3>
					<div class="advancedSearchField">
						Date Out: <i class="fa fa-info-circle" id='dateout'></i><br/>
<?php
						TooltipManager::add('#dateout', "Search for single dates or a range by day, month, or year. e.g., <i>7/1/1789</i>, or <i>7/1/1789-7/1/1790</i>, or <i>1790-1791</i>."); 
?>						
						{{{ca_objects_x_entities.date_out%width=220px&label=Date+out}}}
					</div>
					<div class="advancedSearchField">
						Date In:  <i class="fa fa-info-circle" id='datein'></i><br/>
<?php
						TooltipManager::add('#datein', "Search for single dates or a range by day, month, or year. e.g., <i>7/1/1789</i>, or <i>7/1/1789-7/1/1790</i>, or <i>1790-1791</i>."); 
?>						
						{{{ca_objects_x_entities.date_in%width=220px&label=Date+in}}}
					</div>	
					<div class="advancedSearchField">
						Transcribed Title: <i class="fa fa-info-circle" id='transcribed'></i><br/>
<?php
						TooltipManager::add('#transcribed', "The Library's circulation records often reference the same book in different ways. Search for books based on the way they were recorded at check out."); 
?>						
						{{{ca_objects_x_entities.book_title%width=220px&height=1&label=Transcribed+title}}}
					</div>
				</div>	
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Representative:<br/>
						{{{ca_objects_x_entities.representative%width=220px&height=25px&render=is_set&label=Representative}}}
					</div>
					<div class="advancedSearchField">
						Fine:<br/>
						{{{ca_objects_x_entities.fine%width=220px&height=25px&render=is_set&label=Fine}}}
					</div>									
					<div class="advancedSearchField">
						Uncertain Transcription:  <i class="fa fa-info-circle" id='uncertain'></i><br/>
<?php
						TooltipManager::add('#uncertain', "Search for illegible, unclear, or ambiguous transcriptions in the database."); 
?>						
						{{{ca_objects_x_entities.see_original%width=220px&render=is_set&label=Uncertain+transcription}}}
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