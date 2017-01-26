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
		<h4>Digital Collections Advanced Search<small> or <br/>
		<?php print caNavLink($this->request, 'Search Books', '', '', 'Search', 'advanced/objects');?> | 
		<?php print caNavLink($this->request, 'Search People & Organizations', '', '', 'Search', 'advanced/entities');?> | 
		<?php print caNavLink($this->request, 'Search Borrowing History', '', '', 'Search', 'advanced/borrowing');?>
		<!--<a href='#' class='advancedSearchSelected'>Search Documents</a>-->
		</small></h4>

		<p style='font-size:14px;'>Find digitized objects from our Special Collections in City Readers.</p>

		{{{form}}}

			<div class='advancedContainer'>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Keyword <i class="fa fa-info-circle" id='keyword'></i><br/>
						{{{_fulltext%width=680px&height=1&label=Keywords}}}
					</div>
<?php
						TooltipManager::add('#keyword', "Enter keywords or use <a href='http://www.lib.berkeley.edu/TeachingLib/Guides/Internet/Boolean.pdf' target='_blank'>Boolean operators</a> for more complex searches."); 
?>						
				</div>			
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Title:<br/>
						{{{ca_objects.preferred_labels.name%width=220px&label=Title}}}
					</div>
					<div class="advancedSearchField">
						Author/contributor/creator:<br/>
						{{{ca_entities.preferred_labels.displayname%width=220px&restrictToRelationshipTypes=author;creator;contributor&label=Author/contributor/creator}}}
					</div>
					<div class="advancedSearchField">
						Printer/Publisher:<br/>
						{{{ca_entities.preferred_labels.displayname%width=220px&restrictToRelationshipTypes=printer;publisher&label=Printer/Publisher}}}
					</div>					
				</div>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Genre<br/>
						{{{ca_objects.document_type%width=200px&height=25px&label=Genre}}}
					</div>												
					<div class="advancedSearchField">
						Local Subject<br/>
						{{{ca_objects.local_subject%width=200px&height=25px&label=Local+subject}}}
					</div>				
					<div class="advancedSearchField">
						Current Subjects <i class="fa fa-info-circle" id='subjects'></i><br/>
						{{{ca_objects.LCSH%width=200px&height=25px&label=Current+subjects}}}
					</div>
<?php
						TooltipManager::add('#subjects', "Keyword search for books classified according to today's subject headings from the <a href='http://authorities.loc.gov' target='_blank'>Library of Congress</a>."); 
?>						
				</div>
				<div class='advancedUnit'>
					<div class="advancedSearchField">
						Date: <i class="fa fa-info-circle" id='date'></i><br/>
<?php
						TooltipManager::add('#date', "Search for single dates or a range by day, month, or year. e.g., <i>7/1/1789</i>, or <i>7/1/1789-7/1/1790</i>, or <i>1790-1791</i>"); 
?>
						{{{ca_objects.dc_date.dates_value%width=220px&label=Date}}}
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