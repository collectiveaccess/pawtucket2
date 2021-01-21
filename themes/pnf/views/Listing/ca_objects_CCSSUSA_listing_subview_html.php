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
?>
	<div class="listing-content single-lists">
<?php 

	$va_links_array = array();
	$va_letter_array = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		print "<h2>{$va_listing_info['displayName']}</h2>\n";		
		#print '<p>'._t('Intro here...').'</p>';	
		$va_ccssusa_titles_output = array();
		while($qr_list->nextHit()) {
			$vs_title = $qr_list->get('ca_objects.CCSSUSA_Uniform');
			if(!in_array($vs_title, $va_ccssusa_titles_output)){
				
				
				$va_ccssusa_titles_output[] = $vs_title;
				$vs_sort = strToLower(strip_tags(str_replace(array("¡", "¿", ", La", ", El", ", Los", ", Las", ",", ".", "\"", "“", "”", "La ", "El ", "Los ", "Las ", "À", "Á", "á", "à", "â", "ã", "Ç", "ç", "È", "É", "Ê", "è", "ê", "é", "Ì", "Í", "Î", "ì", "í", "î", "è", "Ò", "Ó", "ò", "ó", "ô", "õ", "Ú", "Ü", "ù", "ú", "ü", "Ñ", "ñ", "Š", "š"), 
															 array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "A", "A", "a", "a", "a", "a", "C", "c", "E", "E", "E", "e", "e", "e", "I", "I", "I", "i", "i", "i", "e", "O", "O", "o", "o", "o", "o", "U", "U", "u", "u", "u", "N", "n", "S", "s"), trim($vs_title))));
				$vs_first_letter = ucfirst(substr($vs_sort, 0, 1));
				$va_letter_array[$vs_first_letter] = $vs_first_letter;
				$vn_id = $qr_list->get('ca_objects.object_id');
				$va_links_array[$vs_first_letter][$vs_sort] = "<div class='listLink'><span class='listTitle'>".caNavLink($this->request, $vs_title, "", "", "Browse", "objects", array("facet" => "label_facet", "id" => $vs_title))."</span></div>\n";	
			}
		}
		ksort($va_links_array);
		ksort($va_letter_array);
		foreach ($va_links_array as $va_first_letter => $va_links) {
			ksort($va_links);
			print "<p class='separator'><a name='".$vs_first_letter."'></a><br></p>";			
			print "<h2 id='".$va_first_letter."' class='mw-headline'>".$va_first_letter."</h2>";
			if($vs_letter_intro = $this->getVar("modern_titles_".strToLower($va_first_letter))){
				print '<div class="listingLetterIntro trimText">'.$vs_letter_intro.'</div>';
			}
			foreach ($va_links as $vs_sort => $va_link) {
				print $va_link;
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


	</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 65
		});
	});
</script>