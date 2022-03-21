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
 
 	$va_lists = $this->getVar('lists');
 	$va_type_info = $this->getVar('typeInfo');
 	$va_listing_info = $this->getVar('listingInfo');
 	$vs_action = $this->request->getAction();
?>
	<nav class="navbar navbar-fixed-top" id="bibHeading">

			<div id="filterByNameContainer">
				<div>
					<input type="text" name="filterByName" id="filterByName" placeholder="<?php print _t('author, title and keyword search');?>" value="" onfocus="this.value='';"/><a href="#" onclick="jQuery('.listEntry').css('display', 'block'); jQuery('#filterByName').val(''); jQuery('.listing-searchable-intro').css('display', 'block'); jQuery('.mw-headline').removeClass('noLetter'); jQuery('.separator').removeClass('noSeparator'); jQuery('#filterByName').val(''); return false;"> <i class="fa fa-close"></i> 
<?php		
			global $g_ui_locale;	
			if ($g_ui_locale == 'en_US'){			
				print "clear search";
			} else {
				print "Borrar búsqueda";
			}				
?>				
				</a>
			</div>
		</div>
<?php
			if ($g_ui_locale == 'en_US'){
				print "<h2>{$va_listing_info['displayName']}</h2>\n";
			}else{
				switch($vs_action){
					case "bibliography":
						print "<H2>Bibliografía</H2>\n";
					break;
					# --------------------------------------
					case "modern_editions":
						print "<H2>Ediciones Modernas</H2>\n";
					break;
					# --------------------------------------
				}	
			
			}		
?>
	</nav>
	<div class="listing-content single-lists">
		<div id="bibBody">
			 <div class="listing-searchable-intro">
<?php
		switch($vs_action){
			case "bibliography":
?>
			<div id="bibBodyIntro">
<?php
			if ($g_ui_locale == 'en_US'){			
?>
				<div>This bibliography includes the following categories of publications chosen in support of the database and deemed useful to scholars investigating in this field:</div>
				<ul class="listNoBullet">
					<li>&#10070; Studies that focus on specific <i>sueltas</i> or collections of them.</li>
					<li>&#10070; Comprehensive bibliographic sources for literature that incorporate material on <i>comedias sueltas</i>.</li>
					<li>&#10070; Books about printers or booksellers of <i>suelta</i> editions or about printing history in general that shed light on the printing practices applicable to <i>suelta</i> editions.</li>
				</ul>
<?php
			}else{
?>
				<div>Esta bibliografía incluye las siguientes categorías de publicaciones, útiles para el estudio de este campo y seleccionadas como apoyo a la base de datos:</div>
				<ul class="listNoBullet">
					<li>&#10070; Estudios enfocados en sueltas específicas o en colecciones de ellas.</li>
					<li>&#10070; Fuentes bibliográficas completas que incorporan material sobre comedias sueltas, incluyendo ediciones modernas de obras teatrales que contienen referencias a antiguas ediciones sueltas.</li>
					<li>&#10070; Obras sobre impresores o libreros de comedias sueltas o sobre la historia de la imprenta en general que arrojen una luz sobre las prácticas de la imprenta relevantes a las comedias sueltas.</li>
				</ul>
<?php		
			}
?>
			</div>
<?php
			if ($g_ui_locale == 'en_US'){			
?>
				<br/><div class="callout">If you have published or know of a publication that fits the criteria of this Bibliography, please send notice to <a href="mailto:contact@comediassueltasusa.org">contact@comediassueltasusa.org</a> and we will include it.  If there is an online version available, please add DOI or URL.</div>		
		
<?php
			}else{
?>
				<br/><div class="callout">Si Ud. ha publicado o sabe de alguna publicación que cumpla con los criterios de esta bibliografía, por favor, avísenos a <a href="mailto:contact@comediassueltasusa.org">contact@comediassueltasusa.org</a> y la incluiremos. Si existe una versión en línea, por favor, incluya el DOI o URL.</div>
<?php
			}
		break;
		# ---------------------------
		case "modern_editions":
			if ($g_ui_locale == 'en_US'){			
?>
				<div id="bibBodyIntro">
					<div>This list includes modern editions of plays for which <i>sueltas</i> provide the basis, or an important textual source.</div>
				</div>
<?php
			}else{
?>
				<div id="bibBodyIntro">
					<div>En estas ediciones recientes de comedias, las sueltas forman una <i>base esencial de la interpretación textual</i> de la edición moderna.</div>
				</div>
<?php
			
			}		
		break;
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
			$vs_sort_author = $qr_list->get('ca_occurrences.author');
			# --- don't sort by second author...and the word 'and' could be in multiple languages
			if(strpos($qr_list->get('ca_occurrences.author'), ' and ' ) !== false){
				$va_tmp_author = explode(" and ", strip_tags($qr_list->get('ca_occurrences.author')));
				$vs_sort_author = $va_tmp_author[0];
			}elseif(strpos($qr_list->get('ca_occurrences.author'), ' y ' ) !== false){
				$va_tmp_author = explode(" y ", strip_tags($qr_list->get('ca_occurrences.author')));
				$vs_sort_author = $va_tmp_author[0];
			}elseif(strpos($qr_list->get('ca_occurrences.author'), ' e ' ) !== false){
				$va_tmp_author = explode(" e ", strip_tags($qr_list->get('ca_occurrences.author')));
				$vs_sort_author = $va_tmp_author[0];
			}elseif(strpos($qr_list->get('ca_occurrences.author'), ' et ' ) !== false){
				$va_tmp_author = explode(" et ", strip_tags($qr_list->get('ca_occurrences.author')));
				$vs_sort_author = $va_tmp_author[0];
			}
			
			
			$vs_sort = strToLower(strip_tags(str_replace(array("The ", ",", ".", "\"", "“", "”", "&quot;", "&ldquo;", "La ", "El ", "Los ", "Las ", "Una ", "A ", "À", "Á", "á", "à", "â", "ã", "Ç", "ç", "È", "É", "Ê", "è", "ê", "é", "Ì", "Í", "Î", "ì", "í", "î", "è", "Ò", "Ó", "ò", "ó", "ô", "õ", "Ü", "ù", "ú", "ü", "Ñ", "ñ", "Š", "š"), array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "A", "A", "a", "a", "a", "a", "C", "c", "E", "E", "E", "e", "e", "e", "I", "I", "I", "i", "i", "i", "e", "O", "O", "o", "o", "o", "o", "U", "u", "u", "u", "N", "n", "S", "s"), trim(strip_tags($vs_sort_author." ".$qr_list->get('ca_occurrences.preferred_labels'))))));
			$vs_first_letter = ucfirst(substr($vs_sort, 0, 1));
			$va_letter_array[$vs_first_letter] = $vs_first_letter;
			# --- if title has quotes, do not italicize
			$vs_title_class = "listTitleItalic";
			if((strpos($qr_list->get('ca_occurrences.preferred_labels'), '"' ) !== false) || (strpos($qr_list->get('ca_occurrences.preferred_labels'), '“' ) !== false)  || (strpos($qr_list->get('ca_occurrences.preferred_labels'), '&quot;') !== false)  || (strpos($qr_list->get('ca_occurrences.preferred_labels'), '&ldquo;') !== false)){
				$vs_title_class = "listTitleNoItalic";
			}
			$vs_tmp_title = "<div class='listLink listEntry listEntryIndentSecondLine'>".(($qr_list->get('ca_occurrences.author')) ? "<span class='listAuthor'>".$qr_list->get('ca_occurrences.author')."</span> " : "")."<span class='".$vs_title_class."'>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels</l>')."</span><span class='listPub'>&nbsp;".$qr_list->get('ca_occurrences.publication_info')."</span>".(($qr_list->get('ca_occurrences.internal_notes')) ? " ".$qr_list->get('ca_occurrences.internal_notes') : "")."</div>\n";
			if(!$va_links_array[$vs_first_letter][$vs_sort]){
				$va_links_array[$vs_first_letter][$vs_sort] = $vs_tmp_title;
			}else{
				$va_links_array[$vs_first_letter][$vs_sort." ".$vn_id] = $vs_tmp_title;	
			}
		}
		ksort($va_links_array);
		ksort($va_letter_array);
		foreach ($va_links_array as $vs_first_letter => $va_links) {
			ksort($va_links);
			print "<p class='separator'><a name='".$vs_first_letter."'></a><br></p>";			
			print "<h2 id='".$vs_first_letter."' class='mw-headline'>".$vs_first_letter."</h2>";
			if($vs_action == "modern_editions"){
				if($vs_letter_intro = $this->getVar("modern_".strToLower($vs_first_letter))){
					print '<div class="listingLetterIntro">'.$vs_letter_intro.'</div>';
				}
			}
			foreach ($va_links as $vn_i => $va_link) {
				print $va_link;
			}
		}
	}
?>
	</div>
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
	
		<script type="text/javascript">
			
			// This will break in jQuery 1.8
			jQuery.extend($.expr[':'], {
			  'containsi': function(elem, i, match, array)
			  {
				return (elem.textContent || elem.innerText || '').toLowerCase()
				.indexOf((match[3] || "").toLowerCase()) >= 0;
			  }
			});
			jQuery(document).ready(function() {
				//prevent form submit with enter key
				jQuery('#filterByName').bind("keypress", function(e) {
					if (e.keyCode == 13) {
						return false;
					}
				});
				
				var typingTimer;
				
				//jQuery('#filterByName').css('color', '#eeeeee');
				jQuery('#filterByName').bind('keyup', function(e) {
					if (!jQuery('#filterByName').val()) {
								jQuery(".mw-headline").removeClass("noLetter");
								jQuery(".separator").removeClass("noSeparator");
								jQuery('.listing-searchable-intro').css('display', 'block');
								jQuery(".listEntry").css("display", "block");
					}
					typingTimer = setTimeout(function() {
						var t = jQuery('#filterByName').val();
						if (t.length > 0) {
							jQuery(".listEntry").css("display", "none");
							if (jQuery(".listEntry:containsi(" + t + ")").length) {
								jQuery(".mw-headline").addClass("noLetter");
								jQuery(".separator").addClass("noSeparator");
								jQuery('.listing-searchable-intro').css('display', 'none');
								jQuery(".listEntry:containsi(" + t + ")").css("display", "block");
							}else{
								jQuery(".mw-headline").removeClass("noLetter");
								jQuery(".separator").removeClass("noSeparator");
								jQuery('.listing-searchable-intro').css('display', 'block');
								jQuery(".listEntry").css("display", "block");
							}
						} else {
							jQuery(".mw-headline").removeClass("noLetter");
							jQuery(".separator").removeClass("noSeparator");
							jQuery('.listing-searchable-intro').css('display', 'block');
							jQuery(".listEntry").css("display", "block");
						}
					}, 1500);
				});
				jQuery('#filterByName').bind('keydown', function(){
					clearTimeout(typingTimer);
					//jQuery('#filterByName').css('color', '#999999');
				});
				
				jQuery('#filterByName').bind('focus', function(){
					//jQuery('#filterByName').css('color', '#000000');
					if (jQuery('#filterByName').val() == 'Name') {
						jQuery('#filterByName').val('');
					}
				});
			});
		</script>	