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

		<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'miscellanies'); ?>">
			<div id="filterByNameContainer">
				<div>
					<input type="text" name="search" placeholder="<?php print _t('search');?>" value="" onfocus="this.value='';"/>  <button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</div>
		</form>
<?php
			if ($g_ui_locale == 'en_US'){
				print "<h2>{$va_listing_info['displayName']}</h2>\n";
			}else{
				print "<H2>Miscelanea</H2>\n";	
			
			}		
?>
	</nav><hr style="margin-top:-18px;"/>
	<div class="listing-content single-lists"><div class="listing-searchable">
		<div class='listing-searchable-intro'>
<?php		
			if ($g_ui_locale == 'en_US'){			
?>
				<!--<p class='trimText'>--><p>
					{{{miscellaniesIntroEnglish}}}
				</p>
<?php
			}else{
?>
				<!--<p class='trimText'>--><p>
					{{{miscellaniesIntroSpanish}}}
				</p>
<?php
			
			}		
?>
		</div>
<?php
	$va_links_array = array();
	$va_letter_array = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			$vn_id = $qr_list->get('ca_occurrences.occurrence_id');
			$vs_sort = strToLower(strip_tags(str_replace(array("The ", ",", ".", "\"", "“", "”", "La ", "El ", "Los ", "Las ", "Una ", "À", "Á", "á", "à", "â", "ã", "Ç", "ç", "È", "É", "Ê", "è", "ê", "é", "Ì", "Í", "Î", "ì", "í", "î", "è", "Ò", "Ó", "ò", "ó", "ô", "õ", "Ü", "ù", "ú", "ü", "Ñ", "ñ", "Š", "š"), array("", "", "", "", "", "", "", "", "", "", "", "A", "A", "a", "a", "a", "a", "C", "c", "E", "E", "E", "e", "e", "e", "I", "I", "I", "i", "i", "i", "e", "O", "O", "o", "o", "o", "o", "U", "u", "u", "u", "N", "n", "S", "s"), trim(strip_tags($qr_list->get('ca_occurrences.preferred_labels'))))));
			$vs_first_letter = ucfirst(substr($vs_sort, 0, 1));
			$va_letter_array[$vs_first_letter] = $vs_first_letter;
			if(!$va_links_array[$vs_first_letter][$vs_sort]){
				$va_cross_refs = $qr_list->get("ca_occurrences.related", array("restrictToRelationshipTypes" => array("related"), "returnWithStructure" => true, "checkAccess" => $va_access_values));
				$vb_cross_ref = false;
				if(is_array($va_cross_refs) && sizeof($va_cross_refs)){
					foreach($va_cross_refs as $va_cross_ref){
						if($va_cross_ref["direction"] == "ltor"){
							$va_links_array[$vs_first_letter][$vs_sort] = "<div class='listLink listEntry listCol'>".$qr_list->getWithTemplate('^ca_occurrences.preferred_labels <i>see</i> <unit relativeTo="ca_occurrences.related" restrictToRelationshipTypes="related"><l>^ca_occurrences.preferred_labels</l></unit>')."</div>\n";	
							$vb_cross_ref = true;
							break;
						}
					}
				}
				if(!$vb_cross_ref){
					$va_links_array[$vs_first_letter][$vs_sort] = "<div class='listLink listEntry listCol'>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels</l>')."</div>\n";	
				}
			}
		}
		ksort($va_links_array);
		ksort($va_letter_array);
		foreach ($va_links_array as $vs_first_letter => $va_links) {
			ksort($va_links);
			print "<p class='separator'><a name='".$vs_first_letter."'></a><br></p>";			
			print "<h2 id='".$vs_first_letter."' class='mw-headline'>".$vs_first_letter."</h2>";
			$i = 0;
			foreach ($va_links as $vn_i => $va_link) {
				print $va_link;
				$i++;
				if($i == 3){
					print "<div style='clear:both'></div>";
					$i = 0;
				}
			}
			if($i > 0){
				print "<div style='clear:both'></div>";
			}
		}
	}
?>
	<div id='toc_container'>
		<div id='toc_content' class='arrow-scroll'>
			<ul id='tocList'>
<?php
	foreach ($va_letter_array as $va_key => $va_letter) {
		print "<li class='tocLevel2'><a class='tocLink' href='#".$va_letter."'>".$va_letter."</a></li>";
	}
?>
			</ul><!-- end tocList -->
			<div class="tocListArrow topArrow"></div>
			<div class="tocListArrow bottomArrow"></div>
		</div><!-- end toc_content -->
	</div><!-- end toc_container -->


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