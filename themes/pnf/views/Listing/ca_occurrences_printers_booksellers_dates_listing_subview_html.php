<?php
/** ---------------------------------------------------------------------
 * themes/default/Listings/listing_html : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 	AssetLoadManager::register("readmore");
 	
 	$va_lists = $this->getVar('lists');
 	$va_type_info = $this->getVar('typeInfo');
 	$va_listing_info = $this->getVar('listingInfo');
 	$vs_action = $this->request->getAction();
 	$va_access_values = caGetUserAccessValues($this->request);
 	global $g_ui_locale;
?>
	<nav class="navbar navbar-fixed-top" id="bibHeading">

		<!--<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'miscellanies'); ?>">
			<div id="filterByNameContainer">
				<div>
					<input type="text" name="search" placeholder="<?php print _t('search');?>" value="" onfocus="this.value='';"/>  <button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</div>
		</form>-->
<?php
			if ($g_ui_locale == 'en_US'){
				print "<h2>{$va_listing_info['displayName']}</h2>\n";
			}else{
				print "<H2>Printers & Booksellers Dates</H2>\n";	
			
			}		
?>
	</nav><hr style="margin-top:-18px;"/>
	<div class="listing-content single-lists"><div class="listing-searchable">
		<div class='listing-searchable-intro'>
<?php		
			if ($g_ui_locale == 'en_US'){			
?>
				<!--<p class='trimText'>--><p>
					{{{printersBooksellersDatesIntroEnglish}}}
				</p>
<?php
			}else{
?>
				<!--<p class='trimText'>--><p>
					{{{printersBooksellersDatesIntroSpanish}}}
				</p>
<?php
			
			}		
?>
		</div>
<?php
	$va_links_array = array();
	$va_letter_array = array();
	print "<div class='row'><div class='col-sm-12' style='background-color:#dedede; padding:10px;'>";
	print "<div class='row'>";
	print "<div class='col-sm-4 col-md-3' style='padding:5px background-color:#FFF;'>NAME</div>";
	print "<div class='col-sm-4 col-md-2' style='padding:5px background-color:#FFF;'>PLACE & DATES KNOWN TO HAVE BEEN ACTIVE</div>";
	print "<div class='col-sm-4 col-md-2' style='padding:5px background-color:#FFF;'>DATES</div>";
	print "<div class='col-sm-4 col-md-5' style='padding:5px background-color:#FFF;'>NOTES</div>";
	print "</div>";

	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			print "<div class='row'>";
			print "<div class='col-sm-4 col-md-3' style='padding:5px background-color:#FFF;'>".$qr_list->get('ca_occurrences.preferred_labels.name')."</div>";
			print "<div class='col-sm-4 col-md-2' style='padding:5px background-color:#FFF;'>".$qr_list->get('ca_occurrences.printer_book_place_date')."</div>";
			print "<div class='col-sm-4 col-md-2' style='padding:5px background-color:#FFF;'>".$qr_list->get('ca_occurrences.printer_book_date')."</div>";
			print "<div class='col-sm-4 col-md-5' style='padding:5px background-color:#FFF;'>".$qr_list->get('ca_occurrences.printer_book_notes')."</div>";
			print "</div>";
		}
	}
	print "</div>";
?>
	


	</div></div>
	
		<script type="text/javascript">
			
			jQuery(document).ready(function() {
				$(".trimText").readmore({
				  speed: 75,
				  maxHeight: 220,
				  moreLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ MORE" : "LEER MÁS"; ?></a>",
				  lessLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ LESS" : "CERRAR"; ?></a>",
		  
				});
			});
		</script>