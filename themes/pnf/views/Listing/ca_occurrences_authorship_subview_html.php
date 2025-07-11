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
	<div class="listing-content single-lists printersBooksellersList" style="padding-left:0px;">
<?php
			if ($g_ui_locale == 'en_US'){
				print "<h2>{$va_listing_info['displayName']}</h2>\n";
			}else{
				print "<H2>Authorship: Attributions, Pseudonyms, Unidentified</H2>\n";	
			
			}		
			if ($g_ui_locale == 'en_US'){			
?>
				<div class="listingSubHeading">
					Introduction
				</div>
				<div class='trimText'>
					{{{authorshipIntroEnglish}}}
				</div>
				<br/><br/>
<?php
				if($this->getVar("translationsForeignLitBibEnglish")){
?>
					<div class="listingSubHeading">
						Bibliography
					</div>
					<div class='trimText'>
						{{{authorshipBibEnglish}}}
					</div>
<?php
				}
			}else{
?>
				<div class="listingSubHeading">
					Introducción
				</div>
				<div class='trimText'>
					{{{authorshipIntroSpanish}}}
				</div>
				<br/><br/>
<?php
				if($this->getVar("translationsForeignLitBibSpanish")){
?>
					<div class="listingSubHeading">
						Bibliografia
					</div>
					<div class='trimText'>
						{{{authorshipBibSpanish}}}
					</div>
<?php
				}			
			}
	$rows_by_type = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		
		
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			$display_type = "";
			$type = $qr_list->get("ca_occurrences.authorship_type", array("convertCodesToDisplayText" => true));
			switch($type){
				case "Ingenio":
					$display_type = "Ingenio(s)";
				break;
				# ---------------
				case "Initials / Acronym":
					$display_type = "Initials & Acronyms";
				break;
				# ---------------
				case "Pseudonym / Anagram":
					$display_type = "Pseudonyms & Anagrams";
				break;
				# ---------------
			}
			$rows_by_type[$display_type][] =  "<div class='row'>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.preferred_labels')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.person_identified')."</div>
										<div class='col-sm-3 col-md-3'>".$qr_list->get('ca_occurrences.example_title')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.510_citation_reference')."</div>
										<div class='col-sm-3 col-md-3'>".$qr_list->get('ca_occurrences.general_notes')."</div>
									</div>";
		}
	}
	ksort($rows_by_type);
	$types = array_keys($rows_by_type);
	print "<div class='listingSubHeading' style='padding-top:30px; color:#000;'>Show: ";
	$type_count = 0;
	foreach($types as $type){
		$type_no_spaces = str_replace(array(" ", "&", "(", ")"), "_", $type);
		if(!$cur_type){
			$cur_type = $type_no_spaces;
		}

?>
		<a class="sortLinks sortLink<?php print $type_no_spaces; ?>" style="<?php print ($cur_type == $type_no_spaces) ? "color: #7f4539; " : "color: #000000; "; ?>text-decoration:underline;" href="#" onclick="jQuery('.sortLinks').css('color', '#000000'); jQuery('.sortLink<?php print $type_no_spaces; ?>').css('color', '#7f4539'); jQuery('.typeListings').hide(); jQuery('#Type<?php print $type_no_spaces; ?>').show(); return false;"><?php print $type; ?></a> 
<?php	
		$type_count++;
		if($type_count < sizeof($types)){
			print " | ";
		}
	}
	print "</div>";
	$table_count = 0;
	foreach($rows_by_type as $autho_type => $rows){
		$table_count++;	
		$type_no_spaces = str_replace(array(" ", "&", "(", ")"), "_", $autho_type);
		if($autho_type == "Ingenio(s)"){
			$autho_type_display = "Printed Anonymously As";
		}else{
			$autho_type_display = $autho_type;
		}
?>
	<div class="typeListings" id="Type<?php print $type_no_spaces; ?>"<?php print ($cur_type != $type_no_spaces) ? " style='display:none;'" : "";  ?>><a name="Type<?php print $autho_type; ?>"></a>
		<div class='row'>
			<div class='col-sm-12'>
				<div style='padding:20px 10px 0px 10px;'>
					<div class='row'>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Label") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? $autho_type_display : $autho_type_display), "", "*", "*", "*", array("sort" => "Label", "type" => $type_no_spaces)); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Person") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Person Identified As" : "Person Identified As"), "", "*", "*", "*", array("sort" => "Person", "type" => $type_no_spaces)); ?></div>
						<div class='col-sm-3 col-md-3 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Example") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Example of a Title Where This Appears" : "Example of a Title Where This Appears"), "", "*", "*", "*", array("sort" => "Example", "type" => $type_no_spaces)); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Citation") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Citation" : "Citation"), "", "*", "*", "*", array("sort" => "Citation", "type" => $type_no_spaces)); ?></div>
						<div class='col-sm-3 col-md-3 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Notes") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Notes" : "Notas"), "", "*", "*", "*", array("sort" => "Notes", "type" => $type_no_spaces)); ?></div>
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