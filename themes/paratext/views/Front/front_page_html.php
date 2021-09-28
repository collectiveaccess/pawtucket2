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
 
 	# --- navigation --- idno => Title
	$va_paratext_intro_sections = $this->request->config->get("paratext_intro_sections");
	$va_paratext_exhibition_sections = $this->request->config->get("paratext_exhibition_sections");
	
?>
<div class="home_width">

    <div class="home_left">
        <div class="map_package">
            <!-- map pins -->

                <!-- barcelona -->
                <div class="map_pin barcelona bottom-right-arrow visible"><div class="printer_name">Imprenta de Pedro Escudèr</div><div class="printer_subtitle">en la calle Condál</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Oficina de Pablo Nadal</div><div class="printer_subtitle">Torrente de Junqueras</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Imprenta de Francisco Suriá</div><div class="printer_subtitle">Vendese en su Casa!</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Imprenta de Carlos Sampera</div><div class="printer_subtitle">calle de la Librería</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Oficina de Pablo Campins</div><div class="printer_subtitle">¡Atrévase!</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Imprenta de Carlos Gibert y Tutó</div><div class="printer_subtitle">en la Libretería</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Juan Francisco Piferrer</div><div class="printer_subtitle">Plaza del Angel núm. 4</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Oficina de Francisco Genéras</div><div class="printer_subtitle">bajada de la Carcel</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Joseph Llopis</div><div class="printer_subtitle">à la plaça del Angel</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Hereus de la Viuda Pla</div><div class="printer_subtitle">carrer dels Cotoners</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Herederos de la Viuda Plan</div><div class="printer_subtitle">c/ de los Algodoneros</div></div>

                <!-- cadiz -->
                <div class="map_pin cadiz bottom-right-arrow"><div class="printer_name">Oficina de Francisco Periu</div></div>
                <div class="map_pin cadiz bottom-right-arrow"><div class="printer_name">Oficina de la viuda de Comes</div></div>

                <!-- madrid -->
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Antonio Sanz</div><div class="printer_subtitle">Plazuela de la calle de la Paz</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Libreria de los Herederos de Gabriel de Leon</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Teresa de Guzmán</div><div class="printer_subtitle">Puerta del Sol</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Librería de Quiroga</div><div class="printer_subtitle">junto à Barrio Nuevo</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Oficina del Diario</div><div class="printer_subtitle">frente al Coliseo</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Imprenta de Joseph Gonzalez</div><div class="printer_subtitle">en la calle del Arenal</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Libreria de Juan Pablo Gonzalez</div><div class="printer_subtitle">calle de Atocha</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Librería de Gonzalez</div><div class="printer_subtitle">frente los Cinco Gremios</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Librería de cerro</div><div class="printer_subtitle">calle de Cedaceros</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Librería de Castillo</div><div class="printer_subtitle">frente á las gradas de San Felipe el Real</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Librería de Don Isidro Lopez</div><div class="printer_subtitle">frente de la Nevería</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Imprenta, y Librerìa de Manuel Fernandez</div></div>

                <!-- malaga -->
                <div class="map_pin malaga"><div class="printer_name">Oficina de don Antonio Fernandez de Quincozes</div></div>
                <div class="map_pin malaga"><div class="printer_name">Imprenta de Casas y Vidondo</div></div>

                <!-- sevilla -->
                <div class="map_pin sevilla visible"><div class="printer_name">Viuda de Francisco de Leefdael</div><div class="printer_subtitle">Casa de el Correo Viejo</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Imprenta del Correo Viejo</div><div class="printer_subtitle">junto al Buen-Sucesso</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Thomê de Dios Miranda</div><div class="printer_subtitle">calle de Genova</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Francisco de leefdael</div><div class="printer_subtitle">junto à la Casa Professa</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Francisco de leefdael</div><div class="printer_subtitle">Casa de Correo Viejo</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Imprenta Real</div><div class="printer_subtitle">Casa de Correo Viejo</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Imprenta de Joseph Padrino</div><div class="printer_subtitle">calle de Genova</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Imprenta de los Herederos de Tomàs Lopez de Haro</div><</div>
                <div class="map_pin sevilla"><div class="printer_name">Imprenta de Joseph Antonio de Hermosilla</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Manuèl Nicolàs Vazquez</div><div class="printer_subtitle">calle de Genova</div></div>

                <!-- salamanca -->
                <div class="map_pin salamanca bottom-right-arrow"><div class="printer_name">Imprenta de Francisco Garcia Onorato y San Miguel</div></div>
                <div class="map_pin salamanca bottom-right-arrow"><div class="printer_name">Imprenta de D. Francisco de Tóxar</div><div class="printer_subtitle">calle de la Rua</div></div>
                <div class="map_pin salamanca bottom-right-arrow"><div class="printer_name">Imprenta de la Santa Cruz</div><div class="printer_subtitle">calle de la Rua</div></div>
                <div class="map_pin salamanca bottom-right-arrow"><div class="printer_name">Librería de la Viuda é Hijo de Quiroga</div></div>

                <!-- valencia -->
                <div class="map_pin valencia"><div class="printer_name">Oficina del Diario</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta y Librería de Miguel Domingo</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de Domingo y Mompié</div></div>
                <div class="map_pin valencia visible"><div class="printer_name">Imprenta de Estevan</div><div class="printer_subtitle">frente al horno de Salicofres</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de Joseph, y Thomàs de Orga</div></div>
                <div class="map_pin valencia"><div class="printer_name">Viuda de Joseph de Orga</div></div>
                <div class="map_pin valencia"><div class="printer_name">lldefonso Mompié</div><div class="printer_subtitle">¡Juto al mercado!</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de José Gimeno</div><div class="printer_subtitle">frente al Miguelete</div></div>
                <div class="map_pin valencia"><div class="printer_name">Librería de José Carlos Navarro</div><div class="printer_subtitle">Lonja de la Seda</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de D. Benito Monfort</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de Francisco Mestre</div><div class="printer_subtitle">¡Juto al molino!</div></div>

                <!-- valladolid -->
                <div class="map_pin valladolid"><div class="printer_name">Imprenta de Alonso del Riego</div><div class="printer_subtitle">frente de la Universidad</div></div>
                <div class="map_pin valladolid"><div class="printer_name">Imprenta de Santaren</div></div>
                
                <!-- zaragoza -->
                <div class="map_pin zaragoza bottom-right-arrow"><div class="printer_name">Herederos de D. Dormer</div><div class="printer_subtitle">¡No se la pierda!</div></div>
                <div class="map_pin zaragoza bottom-right-arrow"><div class="printer_name">Imprenta de Roque Gallifa</div><div class="printer_subtitle">¡No se la pierda!</div></div>
                <!-- <div class="map_pin zaragoza bottom-right-arrow"><div class="printer_name">Imprenta que està en la Plaza del Carbon sobre el Peso Real</div></div> --><!-- Name is too long -->

            <!-- map image -->
            <?php print caGetThemeGraphic($this->request, 'spain_map.png', array("class" => "spain_map", "alt" => "Map of Span")); ?>
        </div>
    </div> 

    <div class="home_right">
        <div class="positioner">
            <div class="exhibition_cover">
                <div class="paratext">paratext</div>
                <div class="comedias_sueltas">comedias sueltas</div>
                <div class="and_the">
                    <div class="and">and</div>
                    <div class="the">the</div>
                </div>
                <div class="commerce_of_printing">commerce of printing</div>
                <div class="an_online_exhitibion">an online exhibition</div>
                <div class="szilvia">by <?php print caNavLink($this->request, 'Szilvia Szmuk-Tanenbaum', '', '', 'About', 'Index'); ?></div>
                <div class="agradecimientos"><?php print caNavLink($this->request, 'Agradecimientos', '', '', 'About', 'Index#agradecimientos'); ?></div>
                <div class="cruickshank">Dedicated to D W Cruickshank</div>
            </div>
            <ul class="home_menu">
<?php
				foreach($va_paratext_intro_sections as $vs_idno => $vs_section_title){
?>
					<li class="menu_item">
                    	<div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
                       	<?php print caNavLink($this->request, $vs_section_title, '', '', 'Section', $vs_idno); ?>
                   		<div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
                	</li>
<?php
				}
				foreach($va_paratext_exhibition_sections as $vs_idno){
?>
					<li class="menu_item">
                    	<div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
                       	<?php print caNavLink($this->request, "Exhibition", '', '', 'Section', $vs_idno); ?>
                   		<div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
                	</li>
<?php
					break;
				}
?>
                <li class="menu_item">
                    <div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
                        <?php print caNavLink($this->request, _t("Printers' addresses"), "", "", "Printers", "Index"); ?>
                    <div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
                </li>
                <li class="menu_item">
                    <div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
                        <?php print caNavLink($this->request, _t("Gallery"), "", "", "ImageGallery", "Index"); ?>
                    <div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
                </li>
            </ul>
        </div> 
    </div>
</div>

<div class="home_slider">

    <div class="swiper-container home_galleries">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><?php print caGetThemeGraphic($this->request, 'img/Home Image 1 duotone.png', array("alt" => "Home Image 1 duotone")); ?></div>
            <div class="swiper-slide"><?php print caGetThemeGraphic($this->request, 'img/La librera de Goya_S.jpg', array("alt" => "La librera de Goya")); ?></div>
            <div class="swiper-slide"><?php print caGetThemeGraphic($this->request, 'img/Home Image 2 duotone.jpg', array("alt" => "Home Image 2 duotone")); ?></div>
            <!--<div class="swiper-slide"><?php print caGetThemeGraphic($this->request, 'img/Home Image 3 duotone.jpg', array("alt" => "Home Image 3 duotone")); ?></div>-->
            <div class="swiper-slide"><?php print caGetThemeGraphic($this->request, 'img/Home Image 5 duotone_S.jpg', array("alt" => "Home Image 5 duotone_S")); ?></div>
            <div class="swiper-slide"><?php print caGetThemeGraphic($this->request, 'img/Antonio de Sacha_S.jpg', array("alt" => "Antonio de Sacha")); ?></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

</div>