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
	<div class="listing-content single-lists printersBooksellersList">
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
				<div class='trimText'>
					{{{printersBooksellersDatesIntroEnglish}}}
				</div>
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

		<div class='row'>
			<div class='col-sm-12'>
				<div style='padding:20px 10px 0px 10px;'>
					<div class='row'>
						<div class='col-sm-4 col-md-3 listingSubHeading'>Name</div>
						<div class='col-sm-4 col-md-2 listingSubHeading'>Places Active</div>
						<div class='col-sm-4 col-md-3 listingSubHeading'>Dates</div>
						<div class='col-sm-4 col-md-4 listingSubHeading'>Notes</div>
					</div>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-12'>
				<div style='background-color:#eeeded; padding:5px;'>
<?php
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		$i = 0;
		while($qr_list->nextHit()) {
			if($i == 1){
				$bg = "#eeeded";
			}else{
				$bg = "#ffffff";
			}
			$i++;
			if($i == 2){
				$i = 0;
			}
			print "<div class='row'>
						<div class='col-sm-12'>
							<div style='margin-bottom:3px; padding:10px; background-color:".$bg."; line-height: 1.3em'>
								<div class='row'>";
									print "<div class='col-sm-4 col-md-3'>".$qr_list->get('ca_occurrences.preferred_labels.name')."</div>";
									print "<div class='col-sm-4 col-md-2'>".$qr_list->get('ca_occurrences.printer_book_place_date')."</div>";
									print "<div class='col-sm-4 col-md-3'>".$qr_list->get('ca_occurrences.printer_book_date')."</div>";
									print "<div class='col-sm-4 col-md-4'>".$qr_list->get('ca_occurrences.printer_book_notes')."</div>";
			print 				"</div>
							</div>
						</div>
					</div>";
		}
	}
?>
				</div>
			</div>
		</div>

	


</div>
	
		<script type="text/javascript">
			
			jQuery(document).ready(function() {
				$(".trimText").readmore({
				  speed: 75,
				  maxHeight: 120,
				  moreLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ MORE" : "LEER MÁS"; ?></a>",
				  lessLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ LESS" : "CERRAR"; ?></a>",
		  
				});
			});
		</script>