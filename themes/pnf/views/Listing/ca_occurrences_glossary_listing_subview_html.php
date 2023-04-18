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
 	$vs_mode = $this->request->getParameter("mode", pString);
?>
	<nav class="navbar navbar-fixed-top" id="bibHeading">

		<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'glossary'); ?>">
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
				print "<H2>Glosario</H2>\n";				
			}		
?>
	</nav><hr style="margin-top:-18px;"/>

	<div class="listing-content single-lists">
		<div class="listing-searchable">
<?php
			if($vs_mode != "enlarge_image"){
?>
			<div id='glossaryBodyIntro' class='listing-searchable-intro'>
			<div class="row"><div class="col-md-6">
<?php
			if ($g_ui_locale == 'en_US'){			
?>
				<div class='trimText'>
					{{{glossaryIntroEnglish}}}
				</div>
<?php
			}else{
?>
				<div class='trimText'>
					{{{glossaryIntroSpanish}}}
				</div>
<?php
			
			}		
?>
			</div><div class="col-md-6 fullWidthImg">
<?php
			}else{
?>
				<div class="col-md-10 col-md-offset-1 fullWidthImg">
<?php
			}
?>
				<div class='glossary_illustration'>
<?php
			if ($g_ui_locale == 'en_US'){
				print caGetThemeGraphic($this->request, 'Anatomy_Numbered_v2.jpg');
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 590, null, array('style' => 'z-index:100; position:absolute; top:3%; left:32%; width:18%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; position:absolute; top:7%; left:32%; width:18%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 477, null, array('style' => 'z-index:100; position:absolute; top:11%; left:32%; width:18%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 642, null, array('style' => 'z-index:100; position:absolute; top:15%; left:32%; width:18%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; position:absolute; top:19%; left:32%; width:18%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 523, null, array('style' => 'z-index:100; position:absolute; top:23%; left:32%; width:18%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 479, null, array('style' => 'z-index:100; position:absolute; top:27%; left:32%; width:18%; height:3%;'));
				
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 492, null, array('style' => 'z-index:100; position:absolute; top:3%; left:51%; width:15%; height:6%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 490, null, array('style' => 'z-index:100; position:absolute; top:10%; left:51%; width:15%; height:6%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 580, null, array('style' => 'z-index:100; position:absolute; top:16%; left:51%; width:15%; height:6%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 585, null, array('style' => 'z-index:100; position:absolute; top:23%; left:51%; width:15%; height:4%;'));
				
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 524, null, array('style' => 'z-index:100; position:absolute; top:44%; left:4%; width:22%; height:8%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; position:absolute; top:44%; left:75%; width:22%; height:13%;'));
				
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; position:absolute; top:69%; left:35%; width:28%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; position:absolute; top:73%; left:35%; width:28%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 485, null, array('style' => 'z-index:100; position:absolute; top:77%; left:35%; width:28%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 569, null, array('style' => 'z-index:100; position:absolute; top:81%; left:35%; width:28%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; position:absolute; top:85%; left:35%; width:28%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 479, null, array('style' => 'z-index:100; position:absolute; top:89%; left:35%; width:28%; height:3%;'));

			}else{
				print caGetThemeGraphic($this->request, 'Anatomy_Numbered_spanish.jpg');
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 590, null, array('style' => 'z-index:100; position:absolute; top:3%; left:32%; width:18%; height:5%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; position:absolute; top:9%; left:32%; width:18%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 477, null, array('style' => 'z-index:100; position:absolute; top:12%; left:32%; width:18%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 642, null, array('style' => 'position:absolute; top:16%; left:32%; width:20%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'position:absolute; top:19%; left:32%; width:20%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 523, null, array('style' => 'z-index:100; position:absolute; top:23%; left:32%; width:18%; height:5%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 479, null, array('style' => 'z-index:100; position:absolute; top:28%; left:32%; width:18%; height:3%;'));
				
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 492, null, array('style' => 'position:absolute; top:3%; left:53%; width:14%; height:12%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 490, null, array('style' => 'position:absolute; top:16%; left:53%; width:14%; height:5%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 580, null, array('style' => 'position:absolute; top:22%; left:53%; width:14%; height:5%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 585, null, array('style' => 'position:absolute; top:28%; left:53%; width:14%; height:5%;'));
				
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 524, null, array('style' => 'z-index:100; z-index:100; position:absolute; top:44%; left:4%; width:22%; height:11%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; z-index:100; position:absolute; top:40%; left:75%; width:22%; height:20%;'));
				
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; z-index:100; position:absolute; top:69%; left:35%; width:28%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; z-index:100; position:absolute; top:73%; left:35%; width:28%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 485, null, array('style' => 'z-index:100; z-index:100; position:absolute; top:76%; left:35%; width:28%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 569, null, array('style' => 'z-index:100; z-index:100; position:absolute; top:80%; left:35%; width:28%; height:3%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 518, null, array('style' => 'z-index:100; z-index:100; position:absolute; top:84%; left:35%; width:28%; height:5%;'));
				print caDetailLink($this->request, _t('&nbsp;'), '', 'ca_occurrences', 479, null, array('style' => 'z-index:100; z-index:100; position:absolute; top:89%; left:35%; width:28%; height:3%;'));

			}
				
?>
				
			</div>
<?php
				if ($g_ui_locale == 'en_US'){
					$vs_enlarge = "ENLARGE";
				}else{
					$vs_enlarge = "AGRANDAR";				
				}
				if($vs_mode != "enlarge_image"){
					print "<div style='text-align:center'>".caNavLink($this->request, "<span class='glyphicon glyphicon-search'></span> ".$vs_enlarge, '', '', 'Listing', 'glossary', array("mode" => "enlarge_image"))."</div>";
				}else{
					print "<div style='text-align:center'>".caNavLink($this->request, "BACK", '', '', 'Listing', 'glossary')."</div>";
				}
?>
			</div></div>
			</div>

<?php
	$va_links_array = array();
	$va_letter_array = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			$vn_id = $qr_list->get('ca_occurrences.occurrence_id');
			if ($g_ui_locale == 'en_US'){
				$vs_sort = strToLower(strip_tags(str_replace(array("The ", ",", ".", "\"", "“", "”", "La ", "El ", "Los ", "Las ", "Una ", "À", "Á", "á", "à", "â", "ã", "Ç", "ç", "È", "É", "Ê", "è", "ê", "é", "Ì", "Í", "Î", "ì", "í", "î", "è", "Ò", "Ó", "ò", "ó", "ô", "õ", "Ü", "ù", "ú", "ü", "Ñ", "ñ", "Š", "š"), array("", "", "", "", "", "", "", "", "", "", "", "A", "A", "a", "a", "a", "a", "C", "c", "E", "E", "E", "e", "e", "e", "I", "I", "I", "i", "i", "i", "e", "O", "O", "o", "o", "o", "o", "U", "u", "u", "u", "N", "n", "S", "s"), trim(strip_tags($qr_list->get('ca_occurrences.preferred_labels'))))));
			}else{
				$vs_sort = strToLower(strip_tags(str_replace(array("The ", ",", ".", "\"", "“", "”", "La ", "El ", "Los ", "Las ", "Una ", "À", "Á", "á", "à", "â", "ã", "Ç", "ç", "È", "É", "Ê", "è", "ê", "é", "Ì", "Í", "Î", "ì", "í", "î", "è", "Ò", "Ó", "ò", "ó", "ô", "õ", "Ü", "ù", "ú", "ü", "Ñ", "ñ", "Š", "š"), array("", "", "", "", "", "", "", "", "", "", "", "A", "A", "a", "a", "a", "a", "C", "c", "E", "E", "E", "e", "e", "e", "I", "I", "I", "i", "i", "i", "e", "O", "O", "o", "o", "o", "o", "U", "u", "u", "u", "N", "n", "S", "s"), trim(strip_tags($qr_list->get('ca_occurrences.nonpreferred_labels'))))));
			}
			$vs_first_letter = ucfirst(substr($vs_sort, 0, 1));
			$va_letter_array[$vs_first_letter] = $vs_first_letter;
			if(!$va_links_array[$vs_first_letter][$vs_sort]){
				$va_cross_refs = $qr_list->get("ca_occurrences.related", array("restrictToRelationshipTypes" => array("related"), "returnWithStructure" => true, "checkAccess" => $va_access_values));
				$vb_cross_ref = false;
				if(is_array($va_cross_refs) && sizeof($va_cross_refs)){
					foreach($va_cross_refs as $va_cross_ref){
						if($va_cross_ref["direction"] == "ltor"){
							if ($g_ui_locale == 'en_US'){
								$va_links_array[$vs_first_letter][$vs_sort] = "<div class='listLink listEntry listCol'>".$qr_list->getWithTemplate('^ca_occurrences.preferred_labels <i>see</i> <unit relativeTo="ca_occurrences.related" restrictToRelationshipTypes="related"><l>^ca_occurrences.preferred_labels</l></unit>')."</div>\n";	
							}else{
								$va_links_array[$vs_first_letter][$vs_sort] = "<div class='listLink listEntry listCol'>".$qr_list->getWithTemplate('^ca_occurrences.nonpreferred_labels <i>see</i> <unit relativeTo="ca_occurrences.related" restrictToRelationshipTypes="related"><l>^ca_occurrences.nonpreferred_labels</l></unit>')."</div>\n";	
							}
							$vb_cross_ref = true;
							break;
						}
					}
				}
				if(!$vb_cross_ref){
					if ($g_ui_locale == 'en_US'){
						$va_links_array[$vs_first_letter][$vs_sort] = "<div class='listLink listEntry listCol'>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels</l>')."</div>\n";	
					}else{
						$va_links_array[$vs_first_letter][$vs_sort] = "<div class='listLink listEntry listCol'>".$qr_list->getWithTemplate('<l>^ca_occurrences.nonpreferred_labels</l>')."</div>\n";	
					}
				}
			}
		}
		ksort($va_links_array);
		ksort($va_letter_array);
		foreach ($va_links_array as $vs_first_letter => $va_links) {
			ksort($va_links);
			print "<p class='separator' style='clear:both;'><a name='".$vs_first_letter."'></a><br></p>";			
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
				  maxHeight: 605,
				  moreLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ MORE" : "LEER MÁS"; ?></a>",
				  lessLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ LESS" : "CERRAR"; ?></a>",
		  
				});
			});
		</script>