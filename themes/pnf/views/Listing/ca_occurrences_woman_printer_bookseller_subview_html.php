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
	<div class="listing-content single-lists womenPrintersBooksellersList" style="padding-left:0px;">
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
					{{{womenPrintersBooksellersIntroEnglish}}}
				</div>
				<br/><br/>
<?php
				if($this->getVar("womenPrintersBooksellersBibEnglish")){
?>
					<div class="listingSubHeading">
						Bibliography
					</div>
					<div class='trimText'>
						{{{womenPrintersBooksellersBibEnglish}}}
					</div>
<?php
				}
			}else{
?>
				<div class="listingSubHeading">
					Introducción
				</div>
				<div class='trimText'>
					{{{womenPrintersBooksellersIntroSpanish}}}
				</div>
				<br/><br/>
<?php
				if($this->getVar("womenPrintersBooksellersBibSpanish")){
?>
					<div class="listingSubHeading">
						Bibliografia
					</div>
					<div class='trimText'>
						{{{womenPrintersBooksellersBibSpanish}}}
					</div>
<?php
				}			
			}
?>
		<div class='row'>
			<div class='col-sm-12'>
				<div style='padding:20px 10px 0px 10px;'>
					<div class='row'>
						<div class='col-sm-3 col-md-3 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "NamePrinted") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Name as Printed on the Title Page or Colophon" : "Name as Printed on the Title Page or Colophon"), "", "*", "*", "*", array("sort" => "NamePrinted")); ?></div>
						<div class='col-sm-3 col-md-3 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "NameAuthority") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Name from Authority File" : "Name from Authority File"), "", "*", "*", "*", array("sort" => "NameAuthority")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Place") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Place of Activity" : "Place of Activity"), "", "*", "*", "*", array("sort" => "Place")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Date") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Dates of Activity" : "Dates of Activity"), "", "*", "*", "*", array("sort" => "Date")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Associations") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Family or Business Associations" : "Family or Business Associations"), "", "*", "*", "*", array("sort" => "Associations")); ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class='row' style='overflow-y:scroll;' id='tableContent'>
			<div class='col-sm-12'>
				<div style='background-color:#eeeded; padding:5px 5px 2px 5px;'>
<?php
	foreach($va_lists as $vn_type_id => $qr_list) {
		
		if(!$qr_list) { continue; }
			while($qr_list->nextHit()) {
				$i = 0;
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
									<div class='row'>
										<div class='col-sm-3 col-md-3'>".$qr_list->get('ca_occurrences.preferred_labels.name')."</div>
										<div class='col-sm-3 col-md-3'>".$qr_list->get('ca_occurrences.name_authority_file')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.place_activity')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.printer_book_date')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.family_business_associations')."</div>
									</div>
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
				$("#tableContent").height((jQuery(window).height() - 200));
				window.onresize = function() {
					$("#tableContent").height((jQuery(window).height() - 200));
				}
			});
		</script>