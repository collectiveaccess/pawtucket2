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
				print "<H2>Traducciones de Literatura Extranjera</H2>\n";	
			
			}		
			if ($g_ui_locale == 'en_US'){			
?>
				<div class="listingSubHeading">
					Introduction
				</div>
				<div class='trimText'>
					{{{translationsForeignLitIntroEnglish}}}
				</div>
<?php
			}else{
?>
				<div class="listingSubHeading">
					Introducción
				</div>
				<div class='trimText'>
					{{{translationsForeignLitIntroSpanish}}}
				</div>
			
			}		
?>
		<div class='row'>
			<div class='col-sm-12'>
				<div style='padding:20px 10px 0px 10px;'>
					<div class='row'>
						<div class='col-sm-2 col-md-3 listingSubHeading'><?php print ($g_ui_locale == 'en_US') ? "Author(s) / Creator(s)" : "Author(s) / Creator(s)"; ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading'><?php print ($g_ui_locale == 'en_US') ? "Original French Title" : "Original French Title"; ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading'><?php print ($g_ui_locale == 'en_US') ? "Translator(s) / Adaptor(s)" : "Translator(s) / Adaptor(s)"; ?></div>
						<div class='col-sm-3 col-md-3 listingSubHeading'><?php print ($g_ui_locale == 'en_US') ? "Spanish Title Modernized" : "Spanish Title Modernized"; ?></div>
						<div class='col-sm-3 col-md-4 listingSubHeading'><?php print ($g_ui_locale == 'en_US') ? "Expression of Cultural Transition as Stated on the Sueltas" : "Expression of Cultural Transition as Stated on the Sueltas"; ?></div>
						<div class='col-sm-2 col-md-4 listingSubHeading'><?php print ($g_ui_locale == 'en_US') ? "Citation" : "Citation"; ?></div>
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
		#$va_output = array();
		#while($qr_list->nextHit()) {
			#$vs_title_sort = strToLower(strip_tags(str_replace(array("¡", "¿", ", La", ", El", ", Los", ", Las", ",", ".", "\"", "“", "”", "À", "Á", "á", "à", "â", "ã", "Ç", "ç", "È", "É", "Ê", "è", "ê", "é", "Ì", "Í", "Î", "ì", "í", "î", "è", "Ò", "Ó", "ò", "ó", "ô", "õ", "Ú", "Ü", "ù", "ú", "ü", "Ñ", "ñ", "Š", "š"), 
			#												 array("", "", "", "", "", "", "", "", "", "", "", "A", "A", "a", "a", "a", "a", "C", "c", "E", "E", "E", "e", "e", "e", "I", "I", "I", "i", "i", "i", "e", "O", "O", "o", "o", "o", "o", "U", "U", "u", "u", "u", "N", "n", "S", "s"), trim($qr_list->get('ca_occurrences.preferred_labels.name')))));
			#$va_output[$vs_title_sort] = "<div class='col-sm-4 col-md-3'>".$qr_list->get('ca_occurrences.preferred_labels.name')."</div>
			#				<div class='col-sm-4 col-md-2'>".$qr_list->get('ca_occurrences.printer_book_place_date')."</div>
			#				<div class='col-sm-4 col-md-3'>".$qr_list->get('ca_occurrences.printer_book_date')."</div>
			#				<div class='col-sm-4 col-md-4'>".$qr_list->get('ca_occurrences.printer_book_notes')."</div>";
				
		#}
		#ksort($va_output);
		$i = 0;
		while($qr_list->nextHit()) {
		#foreach ($va_output as $vs_tmp) {
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
									<div class='col-sm-4 col-md-3'>".$qr_list->get('ca_occurrences.author')."</div>
									<div class='col-sm-4 col-md-2'>".$qr_list->get('ca_occurrences.translationOriginalTitle')."</div>
									<div class='col-sm-4 col-md-3'>".$qr_list->get('ca_occurrences.translationtranslator')."</div>
									<div class='col-sm-4 col-md-4'>".$qr_list->get('ca_occurrences.preferred_labels')."</div>
									<div class='col-sm-4 col-md-4'>".$qr_list->get('ca_occurrences.translationCultural')."</div>
									<div class='col-sm-4 col-md-4'>".$qr_list->get('ca_occurrences.510_citation_reference')."</div>
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