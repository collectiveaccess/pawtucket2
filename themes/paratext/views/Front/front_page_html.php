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
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Imprenta de Carlos Sampera</div><div class="printer_subtitle">Calle de la Librería</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Oficina de Pablo Campins</div><div class="printer_subtitle">Calle de Amargós</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Imprenta de Carlos Gibert y Tutó</div><div class="printer_subtitle">en la Libretería</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Juan Francisco Piferrer</div><div class="printer_subtitle">Plaza del Angel núm. 4</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Oficina de Francisco Genéras</div><div class="printer_subtitle">bajada de la Carcel</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Joseph Llopis</div><div class="printer_subtitle">à la plaça del Angel</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Hereus de la Viuda Pla</div><div class="printer_subtitle">carrer dels Cotoners</div></div>
                <div class="map_pin barcelona bottom-right-arrow"><div class="printer_name">Herederos de la Viuda Plan</div><div class="printer_subtitle">c/ de los Algodoneros</div></div>

                <!-- cadiz -->
                <div class="map_pin cadiz bottom-right-arrow"><div class="printer_name">Oficina de Francisco Periu</div><div class="printer_subtitle">Isla de León</div></div>
                <div class="map_pin cadiz bottom-right-arrow"><div class="printer_name">Oficina de la viuda de Comes</div><div class="printer_subtitle">Cádiz</div></div>

                <!-- madrid -->
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Antonio Sanz</div><div class="printer_subtitle">Plazuela de la calle de la Paz</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Lib. de los Hros. de Gabriel de Leon</div><div class="printer_subtitle">Puerta del Sol</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Teresa de Guzmán</div><div class="printer_subtitle">Puerta del Sol</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Librería de Quiroga</div><div class="printer_subtitle">junto à Barrio Nuevo</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Oficina del Diario</div><div class="printer_subtitle">frente al Coliseo</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Imprenta de Joseph Gonzalez</div><div class="printer_subtitle">en la calle del Arenal</div></div>
                <div class="map_pin madrid bottom-right-arrow visible"><div class="printer_name">Libreria de Juan Pablo Gonzalez</div><div class="printer_subtitle">calle de Atocha</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Lib. de Gonzalez</div><div class="printer_subtitle">frente los Cinco Gremios</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Librería de cerro</div><div class="printer_subtitle">calle de Cedaceros</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Librería de Castillo</div><div class="printer_subtitle">frente á las gradas de San Felipe el Real</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Librería de Don Isidro Lopez</div><div class="printer_subtitle">frente de la Nevería</div></div>
                <div class="map_pin madrid bottom-right-arrow"><div class="printer_name">Imp., y Lib. de Manuel Fernandez</div><div class="printer_subtitle">Caba Baxa</div></div>

                <!-- malaga -->
                <div class="map_pin malaga"><div class="printer_name">Ofic. de don Antonio Fdez. de Quincozes</div><div class="printer_subtitle">Málaga</div></div>
                <div class="map_pin malaga"><div class="printer_name">Imprenta de Casas y Vidondo</div><div class="printer_subtitle">Málaga</div></div>

                <!-- sevilla -->
                <div class="map_pin sevilla visible"><div class="printer_name">Viuda de Francisco de Leefdael</div><div class="printer_subtitle">Casa de el Correo Viejo</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Imprenta del Correo Viejo</div><div class="printer_subtitle">junto al Buen-Sucesso</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Thomê de Dios Miranda</div><div class="printer_subtitle">calle de Genova</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Francisco de leefdael</div><div class="printer_subtitle">junto à la Casa Professa</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Francisco de leefdael</div><div class="printer_subtitle">Casa de Correo Viejo</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Imprenta Real</div><div class="printer_subtitle">Casa de Correo Viejo</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Impr. de Joseph Padrino</div><div class="printer_subtitle">calle de Genova</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Impr. de los Hros. de Tomàs Lopez de Haro</div><div class="printer_subtitle">calle de Genova</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Impr. de Joseph Antonio de Hermosilla</div><div class="printer_subtitle">calle de Genova</div></div>
                <div class="map_pin sevilla"><div class="printer_name">Manuèl Nicolàs Vazquez</div><div class="printer_subtitle">calle de Genova</div></div>

                <!-- salamanca -->
                <div class="map_pin salamanca bottom-right-arrow"><div class="printer_name">Impr. de Fco. Garcia Onorato y San Miguel</div><div class="printer_subtitle">calle de Libreros</div></div>
                <div class="map_pin salamanca bottom-right-arrow"><div class="printer_name">Imprenta de D. Francisco de Tóxar</div><div class="printer_subtitle">calle de la Rua</div></div>
                <div class="map_pin salamanca bottom-right-arrow"><div class="printer_name">Imprenta de la Santa Cruz</div><div class="printer_subtitle">calle de la Rua</div></div>
                <div class="map_pin salamanca bottom-right-arrow"><div class="printer_name">Librería de la Viuda é Hijo de Quiroga</div><div class="printer_subtitle">C/ Concepcion Gerónima</div></div>

                <!-- valencia -->
                <div class="map_pin valencia"><div class="printer_name">Oficina del Diario</div><div class="printer_subtitle">Calle del Príncipe</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta y Librería de Miguel Domingo</div><div class="printer_subtitle">Calle de Caballeros</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de Domingo y Mompié</div><div class="printer_subtitle">Calle de Caballeros</div></div>
                <div class="map_pin valencia visible"><div class="printer_name">Imprenta de Estevan</div><div class="printer_subtitle">frente al horno de Salicofres</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de Joseph, y Thomàs de Orga</div><div class="printer_subtitle">C/ de la Cruz Nueva</div></div>
                <div class="map_pin valencia"><div class="printer_name">Viuda de Joseph de Orga</div><div class="printer_subtitle">C/ de la Cruz Nueva</div></div>
                <div class="map_pin valencia"><div class="printer_name">lldefonso Mompié</div><div class="printer_subtitle">C/ San Fernando</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de José Gimeno</div><div class="printer_subtitle">frente al Miguelete</div></div>
                <div class="map_pin valencia"><div class="printer_name">Librería de José Carlos Navarro</div><div class="printer_subtitle">Lonja de la Seda</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de D. Benito Monfort</div><div class="printer_subtitle">Valencia</div></div>
                <div class="map_pin valencia"><div class="printer_name">Imprenta de Francisco Mestre</div><div class="printer_subtitle">Juto al molino</div></div>

                <!-- valladolid -->
                <div class="map_pin valladolid"><div class="printer_name">Imprenta de Alonso del Riego</div><div class="printer_subtitle">frente de la Universidad</div></div>
                <div class="map_pin valladolid"><div class="printer_name">Imprenta de Santaren</div><<div class="printer_subtitle">Valladolid</div></div>
                
                <!-- zaragoza -->
                <div class="map_pin zaragoza bottom-right-arrow"><div class="printer_name">Herederos de D. Dormer</div><div class="printer_subtitle">Zaragoça</div></div>
                <div class="map_pin zaragoza bottom-right-arrow"><div class="printer_name">Imprenta de Roque Gallifa</div><div class="printer_subtitle">Zaragoza</div></div>
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
                <div class="szilvia">by <?php print caNavLink($this->request, 'Szilvia Szmuk-Tanenbaum', '', '', 'Section', 'About'); ?></div>
                <?php print caGetThemeGraphic($this->request, 'horizontal_ornament_home-03.svg', array("class" => "horizontal_ornament", "alt" => "ornament")); ?>
                <div class="cruickshank"><?php print caNavLink($this->request, 'Dedicated to D W Cruickshank', '', '', 'Section', 'Acknowledgments'); ?></div>
                <div class="agradecimientos"><?php print caNavLink($this->request, 'Acknowledgments', '', '', 'Section', 'Acknowledgments'); ?></div>
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
?>
				<li class="menu_item">
					<div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
					<?php print caNavLink($this->request, "Exhibition", '', '', 'Section', 'Exhibition'); ?>
					<div class="ornament"></div><div class="ornament"></div><div class="ornament"></div>
				</li>

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
<?php
	$va_images = array(
		"img/71065583_M.jpg",
		"img/Libreria_Bardon_M.png",
		"img/Home Image 1 duotone_M.png",
		"img/Antonio de Sacha_M.jpg",
		"img/Home Image 5 duotone_M.jpg",
		"img/baixada de la canonja_M.jpg",
		"img/rehersal_M.jpg",
		"img/papirvm_M.png",
		"img/Lonja de la seda Valencia_M.jpg",
		"img/Miguelete Valencia_M.jpg",
		"img/don-quijote-visit-print-shop_M.jpg"
	);
	$i = 1;
	foreach($va_images as $vs_image){
		print "<div class='swiper-slide'>".caGetThemeGraphic($this->request, $vs_image, array("alt" => "Home Image ".$i))."</div>";
		$i++;
	}
?>
        </div>
        <div class="swiper-pagination"></div>
    </div>

</div>