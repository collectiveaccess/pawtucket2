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
		<h4>People & Organizations Advanced Search<small> or <br/>
		<?php print caNavLink($this->request, 'Search Books', '', '', 'Search', 'advanced/objects');?> | 
		<!--<a href='#' class='advancedSearchSelected'>Search People & Organizations</a> | -->
		<?php print caNavLink($this->request, 'Search Borrowing History', '', '', 'Search', 'advanced/borrowing');?> | 
		<?php print caNavLink($this->request, 'Search Digital Collections', '', '', 'Search', 'advanced/docs');?>
		</small></h4>


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
					<h3>Personal or Organizational Details</h3>
					<div class="advancedSearchField">
						Name:<br/>
						{{{ca_entities.preferred_labels.displayname%width=220px&label=Name}}}
					</div>
					<div class="advancedSearchField">
						Type:<br/>
						{{{ca_entities.type_id%width=220px&label=Type}}}
					</div>					
					<div class="advancedSearchField">
						Occupation:<br/>
						{{{ca_entities.industry_occupations%width=220px&label=Occupation}}}
					</div>
				</div>	
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Country of Origin:<br/>
						{{{ca_entities.country_origin%width=220px&label=Country}}}
					</div>					
					<div class="advancedSearchField">
						Gender:<br/>
						{{{ca_entities.gender%width=220px&label=Gender}}}
					</div>
					<div class="advancedSearchField">
						Relationship to the Library:<br/>
						<div style="margin-top: 5px;">{{{ca_entities.relationship_to_library%width=220px&render=checklist&maxColumns=2&label=Relationship+to+library}}}</div>
					</div>					
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
						Representative:<br/>
						{{{ca_objects_x_entities.representative%width=220px&height=1&render=is_set}}}
					</div>
					<div class="advancedSearchField">
						Uncertain Transcription: <i class="fa fa-info-circle" id='uncertain'></i><br/>
<?php
						TooltipManager::add('#uncertain', "Search for illegible, unclear, or ambiguous transcriptions in the database."); 
?>						
						{{{ca_objects_x_entities.see_original%width=220px&height=1&render=is_set&label=Uncertain+transcription}}}
					</div>
					<div class="advancedSearchField">
						Collection Status: <i class="fa fa-info-circle" id='collection'></i><br/>
<?php
						TooltipManager::add('#collection', "Search for books based on their availability at the New York Society Library today."); 
?>						
						{{{ca_objects.collection_status%width=220px&restrictToRelationshipTypes=reader&label=Collection+status}}}
					</div>					
				</div>	
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Transcribed Title: <i class="fa fa-info-circle" id='transcribed'></i><br/>
<?php
						TooltipManager::add('#transcribed', "The Library's circulation records often reference the same book in different ways. Search for books based on the way they were recorded at check out."); 
?>						
						{{{ca_objects.book_title%width=220px&height=1&restrictToRelationshipTypes=reader&label=Transcribed+title}}}
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