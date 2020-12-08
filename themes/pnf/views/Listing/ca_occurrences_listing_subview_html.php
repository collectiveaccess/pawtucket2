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
					<input type="text" name="filterByName" id="filterByName" placeholder="<?php print _t('author, title and keyword search');?>" value="" onfocus="this.value='';"/><a href="#" onclick="jQuery('.listEntry').css('display', 'block'); jQuery('#filterByName').val(''); return false;"> <i class="fa fa-close"></i> 
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
	$va_links_array = array();
	$va_letter_array = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			$vn_id = $qr_list->get('ca_occurrences.occurrence_id');
			$vs_sort = strToLower(strip_tags(str_replace(array(",", ".", "\"", "“", "”", "La ", "El ", "Los ", "Las ", "Del ", "À", "Á", "á", "à", "â", "ã", "Ç", "ç", "È", "É", "Ê", "è", "ê", "é", "Ì", "Í", "Î", "ì", "í", "î", "è", "Ò", "Ó", "ò", "ó", "ô", "õ", "Ü", "ù", "ú", "ü", "Ñ", "ñ", "Š", "š"), array("", "", "", "", "", "", "", "", "", "", "A", "A", "a", "a", "a", "a", "C", "c", "E", "E", "E", "e", "e", "e", "I", "I", "I", "i", "i", "i", "e", "O", "O", "o", "o", "o", "o", "U", "u", "u", "u", "N", "n", "S", "s"), trim(strip_tags($qr_list->get('ca_occurrences.author')." ".$qr_list->get('ca_occurrences.preferred_labels'))))));
			$vs_first_letter = ucfirst(substr($vs_sort, 0, 1));
			$va_letter_array[$vs_first_letter] = $vs_first_letter;
			$va_links_array[$vs_first_letter][$vs_sort] = "<div class='listLink listEntry listEntryIndentSecondLine'>".(($qr_list->get('ca_occurrences.author')) ? "<span class='listAuthor'>".$qr_list->get('ca_occurrences.author')."</span> " : "")."<span class='listTitle'>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels</l>')."</span><span class='listPub'>&nbsp;".$qr_list->get('ca_occurrences.publication_info')."</span>".(($qr_list->get('ca_occurrences.internal_notes')) ? " ".$qr_list->get('ca_occurrences.internal_notes') : "")."</div>\n";	
		}
		ksort($va_links_array);
		ksort($va_letter_array);
		foreach ($va_links_array as $va_first_letter => $va_links) {
			ksort($va_links);
			print "<p class='separator'><a name='".$vs_first_letter."'></a><br></p>";			
			print "<h2 id='".$va_first_letter."' class='mw-headline'>".$va_first_letter."</h2>";
			if($vs_action == "modern_editions"){
				switch(strToLower($va_first_letter)){
					# ----------------------
					case "b":
	?>
						<div class="listingLetterIntro">
							<p>
								<b>Bances Candamo items contributed by Blanca Oteiza Pérez.</b>
							</p>
							<p>
								En el teatro de Bances Candamo, que se representa entre 1685 y 1697, fecha de la primera y última representación documentadas de sus comedias, las comedias sueltas del XVIII tienen importancia capital, pues su teatro se publicó en dos volúmenes titulados <i>Poesías cómicas</i> (1722), la primera y hasta ahora única colección bastante completa de su teatro, que reúne treinta piezas dramáticas, contando el teatro breve, diecisiete en el tomo primero y trece en el segundo.
							</p>
							<p>
								Los datos del primer tomo son: <i>Poesías cómicas</i>. Obras póstumas de D. Francisco Bances Candamo, año 1722, con privilegio en Madrid por Blas de Villanueva, impresor de libros en la calle Hortaleza, a costa de Joseph Antonio Pimentel, mercader de libros en la Puerta del Sol, véndese en su casa. Y del segundo tomo: <i>Poesías cómicas</i>. Obras póstumas de D. Francisco Bances Candamo, año 1722, con privilegio en Madrid, por Lorenzo Francisco Mojados, impresor de libros en la calle del Olivo Alta, a costa de Joseph Antonio Pimentel, mercader de libros en la Puerta del Sol, véndese en su casa.
							</p>
							<p>
								La edición de <i>Poesías cómicas</i> se basa en textos contemporáneos sin precisar, que las ediciones críticas modernas van reconociendo, en especial los de prensas del XVIII, que lamentablemente en muchas ocasiones no presentan ningún dato de identificación: por ejemplo, en la transmisión del <i>Entremés El astrólogo tunante</i> se registra una suelta de Diego López de Haro (Impreso, en Sevilla, en la Imprenta Real de D. Diego López de Haro, en la calle de Génova); en la de la comedia <i>Quién es quien premia al amor</i>, se constata una suelta, sin año, impresa en Sevilla por Lucas Martín de Hermosilla 1685-1719], según consta en el colofón, y otra suelta, impresa sin año en Sevilla, por Francisco de Leefdael, en la casa del Correo Viejo, lugar en que aparecen sus impresiones a partir de 1717.
							</p>
						</div>
	<?php
					break;
					case "c":
	?>
						<div class="listingLetterIntro"><p><b>Calderón items contributed by Don W. Cruickshank.</b></p></div>
	<?php				
					break;
					# ----------------------
					case "t":
	?>
						<div class="listingLetterIntro">
							<p>
								<b>Tirso items contributed by Blanca Oteiza Pérez.</b>
							</p>
							<p>
								En el caso de Tirso, la transmisión textual de sus comedias a partir de los textos princeps y algunos manuscritos, tienen un eslabón fundamental en ediciones del XVIII, en concreto las de Teresa de Guzmán, que edita entre 1733-1736 (o 1737) 32 comedias de Tirso y el auto El colmenero divino en forma de sueltas que posteriormente se publican en 3 volúmenes. Coe  ha fechado 31 de estas comedias sueltas a partir de los anuncios de los periódicos madrileños, como La Gaceta, en los que se daba noticia de las ediciones de Guzmán no más tarde de diez a quince días de su publicación. Ver Ada M. Coe, <i>Catálogo bibliográfico y crítico de las comedias anunciadas en los periódicos de Madrid, desde 1661 hasta 1819</i>, Baltimore, The Johns Hopkins Press, 1935, y Alice H. Bushee, «The <i>Guzmán</i> edition of Tirso de Molina's Comedias», <i>Hispanic Review</i>, 5, 1937, pp. 25-39.
							</p>
						</div>
	<?php				
					break;
					# ----------------------
					case "v":
	?>
						<div class="listingLetterIntro">
							<b>Luis Vélez de Guevara items contributed by C. George Peale.</b>
						</div>
	<?php				
					break;
					# ----------------------
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
					if (!jQuery('#filterByName').val()) { jQuery(".listEntry").css("opacity", 1.0); }
					typingTimer = setTimeout(function() {
						var t = jQuery('#filterByName').val();
						if (t.length > 0) {
							jQuery(".listEntry").css("display", "none");
							if (jQuery(".listEntry:containsi(" + t + ")").length) {
								jQuery(".mw-headline").addClass("noLetter");
								jQuery(".separator").addClass("noSeparator");
								jQuery(".listEntry:containsi(" + t + ")").css("display", "block");
							}
						} else {
							jQuery(".listEntry").css("opacity", "1.0");
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