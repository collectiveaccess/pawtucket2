<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 
	# Locale selection
	global $g_ui_locale;

 
	$config = caGetFrontConfig();
	$t_rel_types = new ca_relationship_types();
	$vn_creator_rel_type_id = $t_rel_types->getRelationshipTypeID("ca_objects_x_entities", "created_by");
	$vn_photographer_rel_type_id = $t_rel_types->getRelationshipTypeID("ca_objects_x_entities", "created_by_photographer");
	$t_set = $this->getVar("featured_set");
	$va_item_ids = $this->getVar('featured_set_item_ids');
	$t_object = new ca_objects();
	if(is_array($va_item_ids) && sizeof($va_item_ids)){
		$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("original"), array('checkAccess' => caGetUserAccessValues($this->request)));
		$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
	}
	if(is_array($va_item_media) && sizeof($va_item_media)){
?>   
		<div id="sliderHome" class="mascara">
			<div class="jcarousel-wrapper">
			<!-- Carousel -->
				<div class="slider jcarousel topSlideShow">
					<ul>
<?php
						foreach($va_item_media as $vn_object_id => $va_media){
							#print "<li>".caDetailLink($this->request, $va_media["tags"]["original"], '', 'ca_objects', $vn_object_id)."</li>";
							print "<li>".$va_media["tags"]["original"]."</li>";
						}
?>
					</ul>
				</div><!-- end jcarousel topSlideShow -->
			</div><!-- end jcarousel-wrapper -->
		</div>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
						var jcarousel = $('.topSlideShow');
				
						jcarousel
							.on('jcarousel:reload jcarousel:create', function () {
								var width = jcarousel.innerWidth();
								jcarousel.jcarousel('items').css('width', width + 'px');
							})
							.jcarousel({
								wrap: 'circular',
    							animation:'slow'
							});
				
						$('.jcarousel-pagination-frontPage')
							.on('jcarouselpagination:active', 'a', function() {
								$(this).addClass('active');
							})
							.on('jcarouselpagination:inactive', 'a', function() {
								$(this).removeClass('active');
							})
							.on('click', function(e) {
								e.preventDefault();
							})
							.jcarouselPagination({
								perPage: 1
							});
							
						setInterval("$('.topSlideShow').jcarousel('scroll', '+=1')", 5000);

			});
		</script>
<
<?php
	}
?>
		<section id="headerHome" class="col1">
                <nav>
                    <ul>
                        <li><a href="#"><?php print caGetThemeGraphic($this->request, 'logo.png'); ?></a></li>
                            <li>
								<ul class="dropMenu">
									<li>
										<a href="#" onClick="return false;"><?php print _t("Colecciones"); ?></a>
										<ul>

											<li><?php print caNavLink($this->request, _t("Patrimonio Artístico"), "", "", "arte", "arte"); ?></li>
											<li class="indent"><?php print caNavLink($this->request, "&middot; "._t("Presentación"), "", "", "arte", "arte"); ?></li>
											<li class="indent"><?php print caNavLink($this->request, "&middot; "._t("Obras de Arte"), "", "", "Browse", "objects", array("facet" => "collection_facet", "id" => "65")); ?></li>
											<li><?php print caNavLink($this->request, _t("Libros"), "subTitleHeading", "", "libros", "libros"); ?></li>
											<li class="indent"><?php print caNavLink($this->request, "&middot; "._t("Biblioteca Dr. Camino"), "", "", "libros", "libros"); ?></li>
											<li class="indent"><?php print caNavLink($this->request, "&middot; "._t("Boletines digitalizados"), "", "", "Browse", "objects", array("facet" => "collection_facet", "id" => "66")); ?></li>
											<li><?php print caNavLink($this->request, _t("Fototeka"), "subTitleHeading", "", "fototeka", "fototeka"); ?></li>
											<li class="indent"><?php print caNavLink($this->request, "&middot; "._t("Presentación"), "", "", "fototeka", "fototeka"); ?></li>
											<li class="indent"><?php print caNavLink($this->request, "&middot; "._t("Colecciones digitalizadas"), "", "", "Search", "objects", array("search" => "ca_objects.type_id:98 OR ca_objects.type_id:265")); ?></li>
										</ul>
									</li>
								</ul>
                            
                            </li>
                            <li>
								<ul class="dropMenu">
									<li>
										<a href="#" onClick="return false;"><?php print _t("Salas"); ?></a>
										<ul>
<?php
											switch($g_ui_locale){
												case "eu_EU":
?>
													<li><a href="http://www.sala-kubo-aretoa.eus/index.php/eu"><?php print _t("Kubo-Kutxa"); ?></a></li>
													<li><?php print caNavLink($this->request, _t("Biblioteca Dr. Camino"), "subTitleHeading", "", "libros", "libros"); ?></li>
<?php
												break;
												# --------------------------------
												case "es_ES":
?>
													<li><a href="http://www.sala-kubo-aretoa.eus/index.php/es"><?php print _t("Kubo-Kutxa"); ?></a></li>
													<li><?php print caNavLink($this->request, _t("Biblioteca Dr. Camino"), "subTitleHeading", "", "libros", "libros"); ?></li>
<?php												
												break;
												# --------------------------------
												case "en_US":
?>
													<li><a href="http://www.sala-kubo-aretoa.esu"><?php print _t("Kubo-Kutxa"); ?></a></li>
													<li><?php print caNavLink($this->request, _t("Biblioteca Dr. Camino"), "subTitleHeading", "", "libros", "libros"); ?></li>
<?php												
												break;
												# --------------------------------
											}
?>
										</ul>
									</li>
								</ul>
                            </li>
                             <li>
								<ul class="dropMenu">
									<li>
										<a href="#" onClick="return false;"><?php print _t("Exposiciones"); ?></a>
										<ul>
<?php
											switch($g_ui_locale){
												case "eu_EU":
?>
													<li><a href="http://www.sala-kubo-aretoa.eus/index.php/eu/erakusketak"><?php print _t("En Sala kubo-kutxa"); ?></a></li>
													<li><a href="http://www.kutxakulturartegunea.eus/index.php/eu/erakusketak"><?php print _t("En kutxa kultur artegunea"); ?></a></li>
<?php
												break;
												# --------------------------------
												case "es_ES":
?>
													<li><a href="http://www.sala-kubo-aretoa.eus/index.php/es/exposicio"><?php print _t("En Sala kubo-kutxa"); ?></a></li>
													<li><a href="http://www.kutxakulturartegunea.eus/es/exposicio"><?php print _t("En kutxa kultur artegunea"); ?></a></li>
<?php												
												break;
												# --------------------------------
												case "en_US":
?>
													<li><a href="http://www.sala-kubo-aretoa.eus/index.php/es/exposicio"><?php print _t("En Sala kubo-kutxa"); ?></a></li>
													<li><a href="http://www.kutxakulturartegunea.eus/es/exposicio"><?php print _t("En kutxa kultur artegunea"); ?></a></li>
<?php												
												break;
												# --------------------------------
											}
?>
										</ul>
									</li>
								</ul>
                            </li>
                            <li><?php print caNavLink($this->request, _t("Actualidad"), "", "", "Gallery", "Index"); ?></li>
                    </ul>
<script type="text/javascript">
	$(document).ready(function() {
		$('.dropMenu').dropit({
			action: 'hover'
		});
	});
</script>
                </nav>
                <ul class="icons">
                    <li class="carro"><a class="items tooltip" title="Carrito" href="#"><?php print _t("Carrito"); ?></a></li>
                    <li class="user"><a class="items tooltip" title="Mi cuenta" href="#"><?php print _t("Mi cuenta"); ?></a></li>
                    <li class="useradd"><a class="items tooltip" title="Alta nuevo usuario" href="#"><?php print _t("Alta nuevo usuario"); ?></a></li>
                    <li class="flag">
                        <a class="items tooltip" title="Idioma" href="#"><?php print _t("Idioma"); ?></a>
                        <span>
<?php
							# Locale selection
							global $g_ui_locale;
							print caNavLink($this->request, "EU", ($g_ui_locale == "eu_EU") ? "active" : "", "", $this->request->getController(), $this->request->getAction(), array("lang" => "eu_EU"));
                            print " ".caNavLink($this->request, "ES", ($g_ui_locale == "es_ES") ? "active" : "", "", $this->request->getController(), $this->request->getAction(), array("lang" => "es_ES"));
                            print " ".caNavLink($this->request, "EN", ($g_ui_locale == "en_US") ? "active" : "", "", $this->request->getController(), $this->request->getAction(), array("lang" => "en_US"));
?>
                        </span>
                    </li>
                </ul>
                <h1 id="tituloIndex">Kutxateka</h1>
                <h2 id="subtituloIndex"><?php print _t("750.000 fotografías libros y obras de arte"); ?></h2>
                <form class="buscador" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>"><input type="text" name="search" value="<?php print _t("Escribe aquí tu búsqueda"); ?>" /><input class="btnVerde" type="submit" value="<?php print _t("Buscar"); ?>" /></form>
<?php
				if($t_set && ($vs_name = $t_set->getLabelForDisplay())){
?>
                <article class="EXPO-BANNER-SLIDER">
                    <header>
                        <h3><?php print $vs_name ?></h3>
<?php
						if($t_set->get("title")){
							print "<p>".$t_set->get("title")."</p>";
						}
?>
                    </header>
<?php
						if($t_set->get("set_description")){
							print "<p>".$t_set->get("set_description")."</p>";
						}
						if($t_set->get("external_link")){
							print '<a class="btnGris" href="'.$t_set->get("external_link").'"><span class="flechaVerde alignLeft"></span> '._t("Visita la web").'</a>';
						}
?>                    
                </article>
<?php
				}

			if(sizeof($va_item_media) > 1){
?>
			<!-- Pagination -->
			<div class="jcarousel-pagination-frontPage">
			<!-- Pagination items will be generated in here -->
			</div>
<?php
			}
?>
            </section>
<?php
	$va_slideshow_sets = array();
	$va_present_sets = array();
	$va_collection_sets = array();
	$t_display_set = new ca_sets();
	$va_display_set_ids = $t_display_set->getSets(array("setType" => $config->get("present_set_type"), "table" => "ca_objects", "checkAccess" => $this->getVar("access_values"), "setIDsOnly" => true));
	if(is_array($va_display_set_ids) && sizeof($va_display_set_ids)){
		foreach($va_display_set_ids as $vn_id){
			$va_featured_ids = array();
			$t_display_set->load($vn_id);
			$va_featured_ids = array_keys(is_array($va_tmp = $t_display_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
			if(sizeof($va_featured_ids)){
				$va_slideshow_sets[$vn_id] = array("set_id" => $t_display_set->get("set_id"), "set_name" => $t_display_set->getLabelForDisplay(), "set_code" => $t_display_set->get("set_code"), "object_ids" => $va_featured_ids, "set_description" => $t_display_set->get("set_description"), "title" => $t_display_set->get("title"), "external_link" => $t_display_set->get("external_link"), "set_image" => $t_display_set->get("set_description_image", array("version" => "medium")));
				$va_present_sets[] = $va_slideshow_sets[$vn_id];
			}
		}
	}
	# --- add the configured art, photo and books set to the array
	foreach(array($config->get("photo_set"), $config->get("art_set"), $config->get("book_set")) as $vs_set_code){
		$t_display_set->load(array("set_code" => $vs_set_code));
		$va_featured_ids = array();
		if($t_display_set->get("set_id")){
			$va_featured_ids = array_keys(is_array($va_tmp = $t_display_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
			if(sizeof($va_featured_ids)){
				$va_info = array("set_id" => $t_display_set->get("set_id"), "set_name" => $t_display_set->getLabelForDisplay(), "set_code" => $t_display_set->get("set_code"), "object_ids" => $va_featured_ids, "set_description" => $t_display_set->get("set_description"), "title" => $t_display_set->get("title"), "external_link" => $t_display_set->get("external_link"));	
				$va_slideshow_sets[$t_display_set->get("set_id")] = $va_info;	
				$va_collection_sets[$vs_set_code] = $va_info;
			}
		}
	}
?>
            <section id="mainHome" class="carrusel col1 jcarousel-wrapper">
                <div class="mascara jcarousel bottomSlideShow">
                        <ul>
							<li>
								<div class="articuloVisto">
									<article class="active bigFigure">
										<figure class="alignLeft">
											<a href="#" class="fotoinfo" onClick="hideExplorar(); return false();">
												<?php print caGetThemeGraphic($this->request, 'foto1.jpg'); ?>
												<p class="piefoto"><?php print _t("Fotografías"); ?><span>+500.000</span></p>
												<span></span>
											</a>
										</figure>
										<header class="alignLeft">
											<h3 class="verdeclaro"><?php print _t("Fotografías"); ?></h3>
											<p><?php print $va_collection_sets["frontPagePhoto"]["set_description"]; ?></p>
											<a class="btnExplorar mini alignLeft" href="#" onClick="showExplorar('explorar_<?php print $config->get("photo_set"); ?>'); return false;"><span>x</span><?php print _t("explorar"); ?></a>
											<a class="btnInfo mini alignRight" href="#"><?php print _t("más información"); ?></a>
										</header>
									</article>
									<article>
										<figure class="alignLeft cuadrada">
											<a href="#" class="fotoinfo miniarticulo" onClick="hideExplorar(); return false();">
												<?php print caGetThemeGraphic($this->request, 'foto2.jpg'); ?>
												<p class="piefoto"><?php print _t("Arte"); ?></p>
												<span></span>
											</a>
										</figure>
										<header>
											<h3 class="verdeclaro"><?php print _t("Arte"); ?></h3>
											<p><?php print $va_collection_sets["frontPageArt"]["set_description"]; ?></p>
											<a class="btnExplorar mini alignLeft" href="#" onClick="showExplorar('explorar_<?php print $config->get("art_set"); ?>'); return false;"><span>x</span><?php print _t("explorar"); ?></a>
											<?php print caNavLink($this->request, _t("más información"), "btnInfo mini alignRight", "", "Browse", "objects", array("facet" => "collection_facet", "id" => "65")); ?>
										</header>
									</article>
									<article>
										<figure class="alignLeft rectangular">
											<a href="#" class="fotoinfo miniarticulo" onClick="hideExplorar(); return false();">
												<?php print caGetThemeGraphic($this->request, 'foto3.jpg'); ?>
												<p class="piefoto"><?php print _t("Libros"); ?></p>
												<span></span>
											</a>
										</figure>
										<header>
											<h3 class="verdeclaro"><?php print _t("Libros"); ?></h3>
											<p><?php print $va_collection_sets["frontPageBook"]["set_description"]; ?></p>
											<a class="btnExplorar mini alignLeft" href="#" onClick="showExplorar('explorar_<?php print $config->get("book_set"); ?>'); return false;"><span>x</span><?php print _t("explorar"); ?></a>
											<?php print caNavLink($this->request, _t("más información"), "btnInfo mini alignRight", "", "Browse", "objects", array("facet" => "collection_facet", "id" => "66")); ?>
										</header>
									</article>
								</div>
							</li>
							<li>
								<div class="articuloVisto">
									<article class="active">
										<figure class="alignLeft">
											<a href="#" class="fotoinfo" onClick="hideExplorar(); return false();">
												<?php print caGetThemeGraphic($this->request, 'foto4.jpg'); ?>
												<p class="piefoto">Sala Kutxa</p>
												<span></span>
											</a>
										</figure>
										<header class="alignLeft">
											<h3 class="verdeclaro">Arte</h3>
											<p>La colección de Patrimonio Artístico ketxa reúne actualmente un conjunto de unas 5.500 obras procedentes de las anteriones colecciones de la CAM y de la CAP.</p>
											<a class="btnInfo mini alignLeft" href="#">más información</a>
										</header>
									</article>
									<article>
										<figure class="alignLeft">
											<a href="#" class="fotoinfo">
												<?php print caGetThemeGraphic($this->request, 'foto5.jpg'); ?>
												<p class="piefoto">Sala Kutxa</p>
												<span></span>
											</a>
										</figure>
										<header>
											<h3 class="verdeclaro">Arte</h3>
											<p>La colección de Patrimonio Artístico ketxa reúne actualmente un conjunto de unas 5.500 obras procedentes de las anteriones colecciones de la CAM y de la CAP.</p>
											<a class="btnInfo mini alignLeft" href="#">más información</a>
										</header>
									</article>
									<article>
										<figure class="alignLeft">
											<a href="#" class="fotoinfo">
												<?php print caGetThemeGraphic($this->request, 'foto6.jpg'); ?>
												<p class="piefoto">Sala Kutxa</p>
												<span></span>
											</a>
										</figure>
										<header>
											<h3 class="verdeclaro">Arte</h3>
											<p>La colección de Patrimonio Artístico ketxa reúne actualmente un conjunto de unas 5.500 obras procedentes de las anteriones colecciones de la CAM y de la CAP.</p>
											<a class="btnInfo mini alignLeft" href="#">más información</a>
										</header>
									</article>
								</div>
							</li>
<?php
						if(is_array($va_present_sets) && sizeof($va_present_sets)){
							$va_present_sets = array_reverse($va_present_sets, true);
							foreach($va_present_sets as $va_present_set){
?>
							<li>
								<div class="articuloVisto">
									<article class="actualidad">
<?php
										if($va_present_set["set_image"]){
											print '<figure class="alignLeft">'.$va_present_set["set_image"].'</figure>';
										}
?>
										<header>
											<h3><?php print $va_present_set["set_name"]; ?></h3>
											<?php print ($va_present_set["title"]) ? "<h4>".$va_present_set["title"]."</h4>" : ""; ?>
											<?php print ($va_present_set["set_description"] ? "<p class='mini'>".$va_present_set["set_description"]."</p>" : ""); ?>
											<a class="btnExplorar mini alignLeft" onClick="showExplorar('explorar_<?php print $va_present_set["set_code"]; ?>'); return false;">ampliar</a>
											<?php print caNavLink($this->request, _t("ver más noticias"), "btnInfo mini alignRight", "", "Gallery", "Index"); ?>
										</header>
									</article>
								</div>
							</li>
<?php
							}
						}
?>
						</ul>
                </div>
                <a href="#" class="btnmaxLeft items" id="frontPageBottomScrollButtonPrevious" onClick="hideExplorar(); return false();">left</a>
                <a href="#" class="btnmaxRight items" id="frontPageBottomScrollButtonNext" onClick="hideExplorar(); return false();">right</a> 
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('.bottomSlideShow')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#frontPageBottomScrollButtonPrevious')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '-=1'
						});
			
					/*
					 Next control initialization
					 */
					$('#frontPageBottomScrollButtonNext')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '+=1'
						});
				});
			</script>
                
            </section>
<?php
		if(is_array($va_slideshow_sets) && sizeof($va_slideshow_sets)){
			foreach($va_slideshow_sets as $va_slideshow_set){
?>
            <section id="explorar_<?php print $va_slideshow_set["set_code"]; ?>" class="explorarHome">
                <div class="carrusel col1">
                    <div class="mascara jcarousel-wrapper">
                        <div class="jcarousel <?php print $va_slideshow_set["set_code"]; ?>">
                            <ul>
<?php
								if(is_array($va_slideshow_set["object_ids"]) && sizeof($va_slideshow_set["object_ids"])){
									$va_item_media = $t_object->getPrimaryMediaForIDs($va_slideshow_set["object_ids"], array("small"), array('checkAccess' => caGetUserAccessValues($this->request)));
									$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_slideshow_set["object_ids"]);
									$va_date = caExtractValuesByUserLocale($t_object->getAttributeForIDs("date", $va_slideshow_set["object_ids"]));
									$db = new Db();
									global $g_ui_locale_id;
									$q_autor = $db->query("
										SELECT oe.entity_id, oe.object_id, el.displayname
										FROM ca_objects_x_entities oe
										INNER JOIN ca_entity_labels AS el ON oe.entity_id = el.entity_id
										WHERE oe.object_id IN (".join(", ", $va_slideshow_set["object_ids"]).")
											AND (oe.type_id = ? OR oe.type_id = ?) AND el.locale_id = ?
										LIMIT 1
									", $vn_creator_rel_type_id, $vn_photographer_rel_type_id, $g_ui_locale_id);
									$va_autors = array();
									if($q_autor->numRows()){
										while($q_autor->nextRow()){
											$va_autors[$q_autor->get("object_id")] = array("displayname" => $q_autor->get("displayname"), "entity_id" => $q_autor->get("entity_id"));
										}
									}
									foreach($va_item_media as $vn_object_id => $va_media){
										$vs_date = $va_date[$vn_object_id];
										$vs_autor = $va_autors[$vn_object_id]["displayname"];
?>
										<li>
											<article>
												<figure>
													<?php print caDetailLink($this->request, "<span></span>".$va_media["tags"]["small"], 'fotoExplore', 'ca_objects', $vn_object_id); ?>
												</figure>
												<h4><?php print (mb_strlen($va_item_labels[$vn_object_id]) > 50) ? mb_substr($va_item_labels[$vn_object_id], 0, 47)."..." : $va_item_labels[$vn_object_id]; ?></h4>
												<p>
<?php
												if($vs_autor){
													print _t("Autor").": ".caNavLink($this->request, $vs_autor, "verde", "", "Search", "objects", array("search" => "entity_id:".$va_autors[$vn_object_id]["entity_id"]));
												}
												if($vs_autor && $vs_date){
													print " | ";
												}
												if($vs_date){
													print caNavLink($this->request, $va_date[$vn_object_id], "verde", "", "Search", "objects", array("search" => $va_date[$vn_object_id]));
												}
?>												
												</p>
											</article>
										</li>
<?php
									}
								}
?>
                            	<!--<li>
									<article>
										<figure>
											<a class="fotoExplore" href="#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin1.jpg'); ?></a>
										</figure>
										<h4>Lorem ipsum dolor sit amet, consectetur</h4>
										<p>Autor: <a href="#" class="verde">Paco Marí</a> | <a href="#" class="verde">1960</a></p>
									</article>
								</li>-->
                        </div>
                    </div>
                    <a href="#" class="btnwhiteLeft items" id="scrollButtonPrevious_<?php print $va_slideshow_set["set_code"]; ?>">left</a>
                    <a href="#" class="btnwhiteRight items" id="scrollButtonNext_<?php print $va_slideshow_set["set_code"]; ?>">right</a>
                </div>
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						/*
						Carousel initialization
						*/
						$('.<?php print $va_slideshow_set["set_code"]; ?>')
							.jcarousel({
								// Options go here
							});
				
						/*
						 Prev control initialization
						 */
						$('#scrollButtonPrevious_<?php print $va_slideshow_set["set_code"]; ?>')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '-=1'
							});
				
						/*
						 Next control initialization
						 */
						$('#scrollButtonNext_<?php print $va_slideshow_set["set_code"]; ?>')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '+=1'
							});
					});
				</script>
            </section>
<?php
			}
		}
?>








