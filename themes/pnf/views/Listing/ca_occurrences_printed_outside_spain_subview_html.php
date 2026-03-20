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
 	$vs_current_sort = $this->getVar('sort');
 	$cur_type = $this->request->getParameter("type", pString);
	
 	global $g_ui_locale;
?>
	<div class="listing-content single-lists outsideSpainList" style="padding-left:0px;">
<?php
			if ($g_ui_locale == 'en_US'){
				print "<h2>{$va_listing_info['displayName']}</h2>\n";
			}else{
				print "<H2>{$va_listing_info['displayName']}</H2>\n";	
			
			}		
			if ($g_ui_locale == 'en_US'){			
?>
				<div class="listingSubHeading">
					Introduction
				</div>
				<div class='trimText'>
					{{{outsideSpainIntroEnglish}}}
				</div>
				<br/><br/>
<?php
				if($this->getVar("outsideSpainBibEnglish")){
?>
					<div class="listingSubHeading">
						Bibliography
					</div>
					<div class='trimText'>
						{{{outsideSpainBibEnglish}}}
					</div>
<?php
				}
			}else{
?>
				<div class="listingSubHeading">
					Introducción
				</div>
				<div class='trimText'>
					{{{outsideSpainIntroSpanish}}}
				</div>
				<br/><br/>
<?php
				if($this->getVar("outsideSpainBibSpanish")){
?>
					<div class="listingSubHeading">
						Bibliografia
					</div>
					<div class='trimText'>
						{{{outsideSpainBibSpanish}}}
					</div>
<?php
				}			
			}
	$rows_by_language = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		
		
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			$rows_by_language[$qr_list->get("ca_occurrences.pos_original_language")][] =  "<div class='row'>
											<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.pos_place_publication')."</div>
											<div class='col-sm-3 col-md-3'>".$qr_list->get('ca_occurrences.publication_description')."</div>
											<div class='col-sm-3 col-md-3'>".$qr_list->get('ca_occurrences.preferred_labels')."</div>
											<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.general_notes')."</div>
											<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.pos_original_language')."</div>
									</div>";
		}
	}
	$lang_titles = array("printed_americas" => "Printed in the Americas", "printed_europe" => "Printed in Europe (Excluding Spain)");
	$langs = array_keys($rows_by_language);
	print "<div class='listingSubHeading' style='padding-top:30px; color:#000;'>Show: ";
	$lang_count = 0;
	foreach($langs as $lang){
?>
		<a class="sortLinks sortLink<?php print $lang; ?>" style="<?php print ($lang_count == 0) ? "color: #7f4539; " : "color: #000000; "; ?>text-decoration:underline;" href="#" onclick="jQuery('.sortLinks').css('color', '#000000'); jQuery('.sortLink<?php print $lang; ?>').css('color', '#7f4539'); jQuery('.langListings').hide(); jQuery('#Lang<?php print $lang; ?>').show(); return false;"><?php print $lang_titles[$lang]; ?></a> 
<?php	
		$lang_count++;
		if($lang_count < sizeof($langs)){
			print " | ";
		}
	}
	print "</div>";
	$table_count = 0;
	foreach($rows_by_language as $language => $rows){
		$table_count++;	
?>
	<div class="langListings" id="Lang<?php print $language; ?>"<?php print ($table_count > 1) ? " style='display:none;'" : "";  ?>><a name="Lang<?php print $language; ?>"></a>
		<div class='row'>
			<div class='col-sm-12'>
				<div style='padding:20px 10px 0px 10px;'>
					<div class='row'>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "PlacePublication") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Place of Publication" : "Place of Publication"), "", "*", "*", "*", array("sort" => "PlacePublication")); ?></div>
						<div class='col-sm-3 col-md-3 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "PrinterPublisherBookseller") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Printer, Publisher, Bookseller" : "Printer, Publisher, Bookseller"), "", "*", "*", "*", array("sort" => "PrinterPublisherBookseller")); ?></div>
						<div class='col-sm-3 col-md-3 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "ImprintSuelta") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Imprint/Colophon Printed on Suelta" : "Imprint/Colophon Printed on Suelta"), "", "*", "*", "*", array("sort" => "ImprintSuelta")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Notes") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Notes" : "Notes"), "", "*", "*", "*", array("sort" => "Notes")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "OriginalLanguage") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Original Language" : "Original Language"), "", "*", "*", "*", array("sort" => "OriginalLanguage")); ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class='row tableContent' style='overflow-y:scroll;'>
			<div class='col-sm-12'>
				<div style='background-color:#eeeded; padding:5px 5px 2px 5px;'>
<?php
			$i = 0;
			foreach($rows as $row) {
				
				
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
										".$row."
									</div>
								</div>
							</div>";
			}

?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>
	


</div>
	
		<script type="text/javascript">
			
			jQuery(document).ready(function() {
				$(".trimText").readmore({
				  speed: 75,
				  maxHeight: 120,
				  moreLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ MORE" : "LEER MÁS"; ?></a>",
				  lessLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ LESS" : "CERRAR"; ?></a>",
		  
				});
				$(".tableContent").height((jQuery(window).height() - 200));
				window.onresize = function() {
					$(".tableContent").height((jQuery(window).height() - 200));
				}
			});
		</script>