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
 	global $g_ui_locale;
?>
	<div class="listing-content single-lists printersBooksellersList" style="padding-left:0px;">
<?php
			if ($g_ui_locale == 'en_US'){
				print "<h2>{$va_listing_info['displayName']}</h2>\n";
			}else{
				print "<H2>Traducciones de Literaturas Extranjeras</H2>\n";	
			
			}		
			if ($g_ui_locale == 'en_US'){			
?>
				<div class="listingSubHeading">
					Introduction
				</div>
				<div class='trimText'>
					{{{translationsForeignLitIntroEnglish}}}
				</div>
				<br/><br/>
<?php
				if($this->getVar("translationsForeignLitBibEnglish")){
?>
					<div class="listingSubHeading">
						Bibliography
					</div>
					<div class='trimText'>
						{{{translationsForeignLitBibEnglish}}}
					</div>
<?php
				}
			}else{
?>
				<div class="listingSubHeading">
					Introducción
				</div>
				<div class='trimText'>
					{{{translationsForeignLitIntroSpanish}}}
				</div>
				<br/><br/>
<?php
				if($this->getVar("translationsForeignLitBibSpanish")){
?>
					<div class="listingSubHeading">
						Bibliografia
					</div>
					<div class='trimText'>
						{{{translationsForeignLitBibSpanish}}}
					</div>
<?php
				}			
			}
	$rows_by_language = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		
		
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			$rows_by_language[$qr_list->get("ca_occurrences.translationOriginalLanguage", array("convertCodesToDisplayText" => true))][] =  "<div class='row'>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.author')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.translationOriginalTitle')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.translationtranslator')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.preferred_labels')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.translationCultural')."</div>
										<div class='col-sm-2 col-md-2'>".$qr_list->get('ca_occurrences.510_citation_reference')."</div>
									</div>";
		}
	}
	$langs = array_keys($rows_by_language);
	print "<div class='listingSubHeading' style='padding-top:30px; color:#000;'>Show: ";
	$lang_count = 0;
	foreach($langs as $lang){
		$flag = "";
		if(in_array($lang, array("Italian", "French"))){
			$flag = caGetThemeGraphic($this->request, $lang.'.png');
		}
?>
		<a class="sortLinks sortLink<?php print $lang; ?>" style="<?php print ($lang_count == 0) ? "color: #7f4539; " : "color: #000000; "; ?>text-decoration:underline;" href="#" onclick="jQuery('.sortLinks').css('color', '#000000'); jQuery('.sortLink<?php print $lang; ?>').css('color', '#7f4539'); jQuery('.langListings').hide(); jQuery('#Lang<?php print $lang; ?>').show(); return false;"><?php print $flag." ".$lang; ?></a> 
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
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Author") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Author(s) / Creator(s)" : "Autor(es) / Creador(es)"), "", "*", "*", "*", array("sort" => "Author")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "OrigTitle") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Original ".$language." Title" : "Título original"), "", "*", "*", "*", array("sort" => "OrigTitle")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Translator") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Translator(s) / Adaptor(s)" : "Traductor(es) / Refundidor(es)"), "", "*", "*", "*", array("sort" => "Translator")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "SpanishTitle") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Spanish Title Modernized" : "Título español modernizado"), "", "*", "*", "*", array("sort" => "SpanishTitle")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Culture") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Expression of Cultural Transition / Other Notes" : "Expresión de traslado cultural / Otras notas"), "", "*", "*", "*", array("sort" => "Culture")); ?></div>
						<div class='col-sm-2 col-md-2 listingSubHeading' style='font-size: 17px;<?php print (($vs_current_sort == "Citation") ? " text-decoration:underline;" : ""); ?>'><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-chevron-down' style='font-size:12px'></span> ".(($g_ui_locale == 'en_US') ? "Citation Reference" : "Cita de referencia"), "", "*", "*", "*", array("sort" => "Citation")); ?></div>
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