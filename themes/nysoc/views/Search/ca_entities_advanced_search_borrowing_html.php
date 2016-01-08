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
		<h4>Borrowing History Advanced Search<small> or <br/>
		<?php print caNavLink($this->request, 'Search Books', '', '', 'Search', 'advanced/objects');?> | 
		<?php print caNavLink($this->request, 'Search People & Organizations', '', '', 'Search', 'advanced/entities');?> | 
		<!--<a href='#' class='advancedSearchSelected'>Search Borrowing History</a> | -->
		<?php print caNavLink($this->request, 'Search Digital Collections', '', '', 'Search', 'advanced/docs');?>
		</small></h4>

		<p style='font-size:14px;'>Find records of borrowing activity. Results appear a list of transactions, including the borrower's name, book author and title, and check out and check in dates.</p>
		
		{{{form}}}

			<div class='advancedContainer'>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Keyword: <i class="fa fa-info-circle" id='keyword'></i><br/>
						{{{_fulltext%width=680px&height=1&label=Keywords}}}
					</div>
<?php
						TooltipManager::add('#keyword', "Enter keywords or use <a href='http://www.lib.berkeley.edu/TeachingLib/Guides/Internet/Boolean.pdf' target='_blank'>Boolean operators</a> for more complex searches."); 
?>						
				</div>
				<div class='advancedUnit'>
					<h3>Circulation Information</h3>
					<div class="advancedSearchField">
						Date Out: <i class="fa fa-info-circle" id='dateout'></i><br/>
<?php
						TooltipManager::add('#dateout', "Search for single dates or a range by day, month, or year. e.g., <i>7/1/1789</i>, or <i>7/1/1789-7/1/1790</i>, or <i>1790-1791</i>"); 
?>						
						{{{ca_objects_x_entities.date_out%width=220px&label=Date+out}}}
					</div>
					<div class="advancedSearchField">
						Date In: <i class="fa fa-info-circle" id='datein'></i><br/>
<?php
						TooltipManager::add('#datein', "Search for single dates or a range by day, month, or year. e.g., <i>7/1/1789</i>, or <i>7/1/1789-7/1/1790</i>, or <i>1790-1791</i>"); 
?>
						{{{ca_objects_x_entities.date_in%width=220px&label=Date+in}}}
					</div>	
					<div class="advancedSearchField">
						Fine:<br/>
						{{{ca_objects_x_entities.fine%width=220px&height=25px&render=is_set&label=Fine}}}
					</div>
				</div>	
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Uncertain Transcription: <i class="fa fa-info-circle" id='uncertain'></i><br/>
<?php
						TooltipManager::add('#uncertain', "Search for illegible, unclear, or ambiguous transcriptions in the database."); 
?>						
						{{{ca_objects_x_entities.see_original%width=220px&render=is_set&label=Uncertain+transcription}}}
					</div>			
					<div class="advancedSearchField">
						Reader occupation:<br/>
						{{{ca_entities.industry_occupations%width=220px&label=Reader+occupation}}}
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
<?php
						TooltipManager::add('#subjects', "Keyword search for books classified according to today's subject headings from the <a href='http://authorities.loc.gov' target='_blank'>Library of Congress</a>."); 
?>						
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
					<!--<div class="advancedSearchField">
						Author:<br/>
						{{{ca_entities.preferred_labels.displayname%width=220px&restrictToRelationshipTypes=author}}}
					</div>-->
					<div class="advancedSearchField">
						Reader gender:<br/>
						{{{ca_entities.gender%width=220px&label=Reader_gender}}}
					</div>
					<!--<div class="advancedSearchField">
						Author gender:<br/>
						{{{ca_entities.gender%width=220px&restrictToRelationshipTypes=author&label=Author+gender}}}
					</div>-->
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