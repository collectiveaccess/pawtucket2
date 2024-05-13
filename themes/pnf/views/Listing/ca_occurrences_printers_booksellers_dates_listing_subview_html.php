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
	<div class="listing-content single-lists">
<?php
			if ($g_ui_locale == 'en_US'){
				print "<h2>{$va_listing_info['displayName']}</h2>\n";
			}else{
				print "<H2>Printers & Booksellers Dates</H2>\n";	
			
			}		
			#if ($g_ui_locale == 'en_US'){			
?>
				<div class="listingSubHeading">
					Introduction
				</div>
				<p class='trimText'>
					{{{printersBooksellersDatesIntroEnglish}}}
				</p>
				<br/><br/>
				<div class="listingSubHeading">
					Bibliography
				</div>
				<p class='trimText'>
					{{{printersBooksellersDatesBibEnglish}}}
				</p>
<?php
			#}else{
			#}		
?>

	<div class='container'>
		<div class='row'>
			<div class='col-sm-12'>
				<div style='padding:10px;'>
					<div class='row'>
						<div class='col-sm-4 col-md-3 listingSubHeading'><div style='padding:5px;'>Name</div></div>
						<div class='col-sm-4 col-md-2 listingSubHeading'><div style='padding:5px;'>Places Active</div></div>
						<div class='col-sm-4 col-md-2 listingSubHeading'><div style='padding:5px;'>Dates</div></div>
						<div class='col-sm-4 col-md-5 listingSubHeading'><div style='padding:5px;'>Notes</div></div>
					</div>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-12'>
				<div style='background-color:#dedede; padding:10px;'>
<?php
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			print "<div class='row'>";
			print "<div class='col-sm-4 col-md-3'><div style='padding:5px; background-color:#FFF;'>".$qr_list->get('ca_occurrences.preferred_labels.name')."</div></div>";
			print "<div class='col-sm-4 col-md-2'><div style='padding:5px; background-color:#FFF;'>".$qr_list->get('ca_occurrences.printer_book_place_date')."</div></div>";
			print "<div class='col-sm-4 col-md-2'><div style='padding:5px; background-color:#FFF;'>".$qr_list->get('ca_occurrences.printer_book_date')."</div></div>";
			print "<div class='col-sm-4 col-md-5'><div style='padding:5px; background-color:#FFF;'>".$qr_list->get('ca_occurrences.printer_book_notes')."</div></div>";
			print "</div>";
		}
	}
?>
				</div>
			</div>
		</div>
	</div>

	


</div>
	
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