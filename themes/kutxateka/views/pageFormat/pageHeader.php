<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
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
 * ----------------------------------------------------------------------
 */
?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print $this->request->config->get('html_page_title'); ?></title>
    <meta name="description" content="<?php print $this->request->config->get('html_page_title'); ?>" />
</head>
<body>
	    <div id="politica_cookies">
            <a href="#" class="cerrarCookies">x</a>
            <p>Para mejorar tu experiencia de usuario nuestra web utiliza cookies propias y de terceros, si continúas navegnado entendemos que aceptas nuestra <a class="txtPolCookies" href="#">Política de Cookies</a>.</p>
        </div>
        <div id="pageWrap">
            <header id="cabecera">
                <nav class="hideMenu">
                    <div class="col1">
                        <ul>
                            <li><a href="#" class="home items active">Home</a></li>
                            <li><a class="" href="#">Colecciones</a></li>
                            <li><a href="#">Salas</a></li>
                            <li><a href="#">Exposiciones</a></li>
                            <li><a href="#">Actualidad</a></li>
                            <li class="sinborde aireLeft2 mini"><span class="compra items alignLeft">compras</span> 2 elementos</li>
                            <li class="mini"><a class="active" href="#">comprar</a></li>
                            <li class="sinborde aireLeft mini"><span class="login items alignLeft"></span> <a class="active" href="#">Javier González</a></li>
                            <li class="mini"><a href="#" class="rojo">salir</a></li>
                            <li class="sinborde aireLeft mini"><a href="#">EU</a></li>
                            <li class="mini"><a class="active" href="#">ES</a></li>
                            <li class="mini"><a href="#">EN</a></li>
                        </ul>
                        <p class="pestana"><span class="flechaBlanca"></span> Menú</p>
                    </div>
                </nav>
                <div class="col1">
                    <a class="alignLeft" href="#"><?php print caGetThemeGraphic($this->request, 'logo2.png'); ?></a>
                    <form class="buscador alignRight"  action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>"><input type="text" value="Nueva búsqueda" name="search"/><input type="submit" class="items lupa" value="Buscar" /></form>
                </div>
             </header>
	
	





	<div class="container">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
