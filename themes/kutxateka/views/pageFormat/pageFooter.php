<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
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
# Locale selection
global $g_ui_locale;

?>
			</div><!-- end pageArea --></div><!-- end container -->
			
			
             <footer>
                <div class="col1">
                    <div class="colLeft alignLeft">
                        <a href="#"><?php print caGetThemeGraphic($this->request, 'logo2.png'); ?></a>
                        <ul class="social">
                            <li><a class="facebook items" href="#"><?php print _t("facebook"); ?></a></li>
                            <li><a class="twitter items" href="#"><?php print _t("twitter"); ?></a></li>
                            <li><a class="googlePlus items" href="#"><?php print _t("google plus"); ?></a></li>
                        </ul>
                    </div>
                    <div class="colCenter alignLeft">
                        <h4><?php print _t("Nosotros"); ?></h4>
                        <ul>
                            <li><?php print caDetailLink($this->request, _t("Sobre Nosotros"), '', 'ca_occurrences', 1); ?></li>
                            <li><?php print caNavLink($this->request, _t("Contacto"), "", "", "Contact", "form"); ?></li>
                            <li><a href="#"><?php print _t("Condiciones"); ?></a></li>
                            <li><a href="#"><?php print _t("Legal"); ?></a></li>
                        </ul>
                    </div>
                    <div class="colCenter alignLeft">
                        <h4><?php print _t("Colecciones"); ?></h4>
                        <ul>
                            <li><a href="#"><?php print caNavLink($this->request, _t("Fotografías"), "subTitleHeading", "", "fototeka", "fototeka"); ?></a></li>
                            <li><a href="#"><?php print caNavLink($this->request, _t("Obras de arte"), "", "", "arte", "arte"); ?></a></li>
                            <li><a href="#"><?php print caNavLink($this->request, _t("Libros"), "", "", "libros", "libros"); ?></a></li>
                        </ul>
                    </div>
                    <div class="colCenter alignLeft">
                        <h4><?php print _t("Salas y<br />Servicios públicos"); ?></h4>
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
								<li><a href="http://www.sala-kubo-aretoa.eus"><?php print _t("Kubo-Kutxa"); ?></a></li>
								<li><?php print caNavLink($this->request, _t("Biblioteca Dr. Camino"), "subTitleHeading", "", "libros", "libros"); ?></li>
<?php												
							break;
							# --------------------------------
						}
?>
                        </ul>
                    </div>
                    <div class="colCenter alignLeft">
                        <h4><?php print _t("Otros"); ?></h4>
                        <ul>
                            <li><a href="#"><?php print _t("Tienda"); ?></a></li>
                            <li><?php print caNavLink($this->request, _t("Actualidad"), "", "", "Gallery", "Index"); ?></a></li>
                        </ul>
                    </div>
                    <div class="colRight alignRight">
                        <h4 class="verde"><?php print _t("Enlaces de interés"); ?></h4>
                        <ul>
                            <li><span class="cuadraditoVerde items"></span> <a href="http://kutxasocial.net" target="_blank"><?php print _t("Kutxa Social"); ?></a></li>
                            <li><span class="cuadraditoVerde items"></span> <a href="http://kutxa.net" target="_blank"><?php print _t("Kutxa"); ?></a></li>
                            <li><span class="cuadraditoVerde items"></span> <a href="http://kutxabank.es" target="_blank"><?php print _t("Kutxabank"); ?></a></li>
                        </ul>
                    </div>
                </div>
            </footer>

        </div>

       <!-- 
 <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
 -->
        
		<?php print TooltipManager::getLoadHTML(); ?>
		<div id="caMediaPanel"> 
			<div id="caMediaPanelContentArea">
			
			</div>
		</div>
		<script type="text/javascript">
			/*
				Set up the "caMediaPanel" panel that will be triggered by links in object detail
				Note that the actual <div>'s implementing the panel are located here in views/pageFormat/pageFooter.php
			*/
			var caMediaPanel;
			jQuery(document).ready(function() {
				if (caUI.initPanel) {
					caMediaPanel = caUI.initPanel({ 
						panelID: 'caMediaPanel',										/* DOM ID of the <div> enclosing the panel */
						panelContentID: 'caMediaPanelContentArea',		/* DOM ID of the content area <div> in the panel */
						exposeBackgroundColor: '#FFFFFF',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.9,							/* opacity of background color masking out page content; 1.0 is opaque */
						panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
						allowMobileSafariZooming: true,
						mobileSafariViewportTagID: '_msafari_viewport',
						closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
					});
				}
			});
	
			(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);
		</script>
	</body>
</html>
