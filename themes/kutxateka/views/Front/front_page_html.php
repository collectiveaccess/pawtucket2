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
	$va_item_ids = $this->getVar('featured_set_item_ids');
	if(is_array($va_item_ids) && sizeof($va_item_ids)){
		$t_object = new ca_objects();
		$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("mediumlarge"), array('checkAccess' => caGetUserAccessValues($this->request)));
		$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
	}
?>








        <div id="sliderHome" class="mascara">
            <div class="slider">
                <?php print caGetThemeGraphic($this->request, 'slider1.jpg'); ?>
            </div>
        </div>

            <section id="headerHome" class="col1">
                <nav>
                    <ul>
                        <li><a href="home.php#"><?php print caGetThemeGraphic($this->request, 'logo.png'); ?></a></li>
                        <li>
								<ul class="dropMenu">
									<li>
										<a href="#"><?php print _t("Colecciones"); ?></a>
										<ul>
											<li><?php print caNavLink($this->request, _t("Arte"), "", "", "arte", "arte_es"); ?></li>
											<li><?php print caNavLink($this->request, _t("Libros"), "", "", "libros", "libros_es"); ?></li>
										</ul>
									</li>
								</ul>
                            
                            </li>
                            <li>
								<ul class="dropMenu">
									<li>
										<a href="#"><?php print _t("Salas"); ?></a>
										<ul>
											<li><a href="#"><?php print _t("Kubo-Kutxa"); ?></a></li>
											<li><a href="#"><?php print _t("Sala Boulevard"); ?></a></li>
											<li><a href="#"><?php print _t("Biblioteca Dr. Camino"); ?></a></li>
										</ul>
									</li>
								</ul>
                            </li>
<script type="text/javascript">
	$(document).ready(function() {
		$('.dropMenu').dropit({
			action: 'hover'
		});
	});
</script>                        
                        
                        <li><a href="home.php#"><?php print _t("Exposiciones"); ?></a></li>
                        <li><a href="home.php#"><?php print _t("Actualidad"); ?></a></li>
                    </ul>
                </nav>
                <ul class="icons">
                    <li class="carro"><a class="items tooltip" title="Carrito" href="home.php#"><?php print _t("Carrito"); ?></a></li>
                    <li class="user"><a class="items tooltip" title="Mi cuenta" href="home.php#"><?php print _t("Mi cuenta"); ?></a></li>
                    <li class="useradd"><a class="items tooltip" title="Alta nuevo usuario" href="home.php#"><?php print _t("Alta nuevo usuario"); ?></a></li>
                    <li class="flag">
                        <a class="items tooltip" title="Idioma" href="home.php#"><?php print _t("Idioma"); ?></a>
                        <span>
                            <a href="home.php#">EU</a>
                            <a class="active" href="home.php#">ES</a>
                            <a href="home.php#">EN</a>
                        </span>
                    </li>
                </ul>
                <h1 id="tituloIndex">Kutxateka</h1>
                <h2 id="subtituloIndex"><?php print _t("750.000 fotografías libros y obras de arte"); ?></h2>
                <form class="buscador" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>"><input type="text" name="search" value="<?php print _t("Escribe aquí tu búsqueda"); ?>" /><input class="btnVerde" type="submit" value="<?php print _t("Buscar"); ?>" /></form>
                <article class="EXPO-BANNER-SLIDER">
                    <header>
                        <h3><?php print _t("Exposición en la Sala Kutxa Boulevard"); ?></h3>
                        <p><?php print _t("LA ILUSIÓN NOS HACE ÚNICOS"); ?></p>
                    </header>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam euismod neque nec mauris rutrum posuere. Quisque dictum urna sollicitudin leo venenatis dapibus. Suspendisse sed accumsan massa.</p>
                    <a class="btnGris" href="home.php#"><span class="flechaVerde alignLeft"></span> <?php print _t("Visita la web"); ?></a>
                </article>
                <div id="marcador">
                    <a class="active" href="home.php#">foto1</a>
                    <a href="home.php#">foto2</a>
                    <a href="home.php#">foto3</a>
                    <a href="home.php#">foto4</a>
                    <a href="home.php#">foto5</a>
                    <a href="home.php#">foto6</a>
                </div>
            </section>

            <section id="mainHome" class="carrusel col1">
                <div class="mascara">
                    <div class="articulos">
                        <div class="alignLeft articuloVisto">
                            <article class="active bigFigure">
                                <figure class="alignLeft">
                                    <a href="home.php#" class="fotoinfo">
                                        <?php print caGetThemeGraphic($this->request, 'foto1.jpg'); ?>
                                        <p class="piefoto"><?php print _t("Fotografías"); ?><span>+500.000</span></p>
                                        <span></span>
                                    </a>
                                </figure>
                                <header class="alignLeft">
                                    <h3 class="verdeclaro"><?php print _t("Arte"); ?></h3>
                                    <p><?php print _t("La colección de Patrimonio Artístico ketxa reúne actualmente un conjunto de unas 5.500 obras procedentes de las anteriones colecciones de la CAM y de la CAP."); ?></p>
                                    <a class="btnExplorar mini alignLeft" href="home.php#"><span>x</span><?php print _t("explorar"); ?></a>
                                    <a class="btnInfo mini alignRight" href="home.php#"><?php print _t("más información"); ?></a>
                                </header>
                            </article>
                            <article>
                                <figure class="alignLeft cuadrada">
                                    <a href="home.php#" class="fotoinfo miniarticulo">
                                        <?php print caGetThemeGraphic($this->request, 'foto2.jpg'); ?>
                                        <p class="piefoto"><?php print _t("Arte"); ?></p>
                                        <span></span>
                                    </a>
                                </figure>
                                <header>
                                    <h3 class="verdeclaro"><?php print _t("Arte"); ?></h3>
                                    <p><?php print _t("La colección de Patrimonio Artístico ketxa reúne actualmente un conjunto de unas 5.500 obras procedentes de las anteriones colecciones de la CAM y de la CAP."); ?></p>
                                    <a class="btnExplorar mini alignLeft" href="home.php#"><span>x</span><?php print _t("explorar"); ?></a>
                                    <a class="btnInfo mini alignRight" href="home.php#"><?php print _t("más información"); ?></a>
                                </header>
                            </article>
                            <article>
                                <figure class="alignLeft rectangular">
                                    <a href="home.php#" class="fotoinfo miniarticulo">
                                        <?php print caGetThemeGraphic($this->request, 'foto3.jpg'); ?>
                                        <p class="piefoto"><?php print _t("Libros"); ?></p>
                                        <span></span>
                                    </a>
                                </figure>
                                <header>
                                    <h3 class="verdeclaro"><?php print _t("Arte"); ?></h3>
                                    <p><?php print _t("La colección de Patrimonio Artístico ketxa reúne actualmente un conjunto de unas 5.500 obras procedentes de las anteriones colecciones de la CAM y de la CAP."); ?></p>
                                    <a class="btnExplorar mini alignLeft" href="home.php#"><span>x</span><?php print _t("explorar"); ?></a>
                                    <a class="btnInfo mini alignRight" href="home.php#"><?php print _t("más información"); ?></a>
                                </header>
                            </article>
                        </div>
                        <div class="alignLeft articuloVisto">
                            <article class="active">
                                <figure class="alignLeft">
                                    <a href="home.php#" class="fotoinfo">
                                        <?php print caGetThemeGraphic($this->request, 'foto4.jpg'); ?>
                                        <p class="piefoto">Sala Kutxa</p>
                                        <span></span>
                                    </a>
                                </figure>
                                <header class="alignLeft">
                                    <h3 class="verdeclaro">Arte</h3>
                                    <p>La colección de Patrimonio Artístico ketxa reúne actualmente un conjunto de unas 5.500 obras procedentes de las anteriones colecciones de la CAM y de la CAP.</p>
                                    <a class="btnInfo mini alignLeft" href="home.php#">más información</a>
                                </header>
                            </article>
                            <article>
                                <figure class="alignLeft">
                                    <a href="home.php#" class="fotoinfo">
                                        <?php print caGetThemeGraphic($this->request, 'foto5.jpg'); ?>
                                        <p class="piefoto">Sala Kutxa</p>
                                        <span></span>
                                    </a>
                                </figure>
                                <header>
                                    <h3 class="verdeclaro">Arte</h3>
                                    <p>La colección de Patrimonio Artístico ketxa reúne actualmente un conjunto de unas 5.500 obras procedentes de las anteriones colecciones de la CAM y de la CAP.</p>
                                    <a class="btnInfo mini alignLeft" href="home.php#">más información</a>
                                </header>
                            </article>
                            <article>
                                <figure class="alignLeft">
                                    <a href="home.php#" class="fotoinfo">
                                        <?php print caGetThemeGraphic($this->request, 'foto6.jpg'); ?>
                                        <p class="piefoto">Sala Kutxa</p>
                                        <span></span>
                                    </a>
                                </figure>
                                <header>
                                    <h3 class="verdeclaro">Arte</h3>
                                    <p>La colección de Patrimonio Artístico ketxa reúne actualmente un conjunto de unas 5.500 obras procedentes de las anteriones colecciones de la CAM y de la CAP.</p>
                                    <a class="btnInfo mini alignLeft" href="home.php#">más información</a>
                                </header>
                            </article>
                        </div>
                        <div class="alignLeft articuloVisto">
                            <article class="actualidad bigFigure">
                                <figure class="alignLeft">
                                    <?php print caGetThemeGraphic($this->request, 'foto1.jpg'); ?>
                                </figure>
                                <header class="alignLeft">
                                    <h3>ACTUALIDAD</h3>
                                    <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce commodo malesuada ante, nec tincidunt mauris eleifend sed.</h4>
                                    <p class="mini">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce commodo malesuada ante, nec tincidunt mauris eleifend sed. Fusce porttitor lectus sed nisl ornare condimentum. Sed nisl magna, tempor sed ultricies id, adipiscing id diam. Quisque adipiscing fermentum dui. Donec tristique leo eu magna ultrices posuere. Donec feugiat urna ullamcorper velit feugiat sed congue metus pulvinar. Maecenas non consectetur velit. Nam mi lectus, luctus id posuere sed, pharetra vel leo. Mauris sit amet mollis ipsum. Donec a accumsan felis. Aenean vehicula placerat ipsum, id ullamcorper ipsum tincidunt sit amet. Morbi varius, neque ut mollis gravida, nunc erat placerat tortor, elementum sollicitudin nulla metus ac velit.</p>
                                    <p class="mini">Maecenas mauris magna, pretium nec luctus eu, porta ac mauris. Fusce condimentum condimentum tempus. Curabitur vel leo et massa aliquet cursus. Nullam vestibulum feugiat mi nec gravida. Aenean cursus quam ac arcu faucibus consectetur. Proin eu lorem enim, eget varius elit. Integer facilisis porta tellus non facilisis. (...)</p>
                                    <a class="btnExplorar mini alignLeft" href="home.php#">ampliar</a>
                                    <a class="btnInfo mini alignRight" href="home.php#">ver más noticias</a>
                                </header>
                            </article>
                        </div>
                    </div>
                </div>
                <a href="home.php#" class="botonIzq btnmaxLeft items">left</a>
                <a href="home.php#" class="botonDer btnmaxRight items">right</a>
            </section>
            <section id="explorarHome">
                <div class="carrusel col1">
                    <div class="mascara">
                        <div class="articulos">
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin1.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin2.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin3.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin4.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin5.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin1.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin2.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin3.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin4.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                            <article>
                                <figure>
                                    <a class="fotoExplore" href="home.php#"><span></span><?php print caGetThemeGraphic($this->request, 'fotomin5.jpg'); ?></a>
                                </figure>
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>
                                <p>Autor: <a href="home.php#" class="verde">Paco Marí</a> | <a href="home.php#" class="verde">1960</a></p>
                            </article>
                        </div>
                    </div>
                    <a href="home.php#" class="btnwhiteLeft items botonIzq">left</a>
                    <a href="home.php#" class="btnwhiteRight items botonDer">right</a>
                </div>
            </section>









