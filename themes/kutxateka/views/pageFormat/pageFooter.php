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
?>
			</div><!-- end pageArea --></div><!-- end container -->
			
			
             <footer>
                <div class="col1">
                    <div class="colLeft alignLeft">
                        <a href="#"><?php print caGetThemeGraphic($this->request, 'logo2.png'); ?></a>
                        <ul class="social">
                            <li><a class="facebook items" href="#">facebook</a></li>
                            <li><a class="twitter items" href="#">twitter</a></li>
                            <li><a class="googlePlus items" href="#">google plus</a></li>
                        </ul>
                    </div>
                    <div class="colCenter alignLeft">
                        <h4>Nosotros</h4>
                        <ul>
                            <li><a href="#">Sobre Nosotros</a></li>
                            <li><a href="#">Contacto</a></li>
                            <li><a href="#">Condiciones</a></li>
                            <li><a href="#">Legal</a></li>
                        </ul>
                    </div>
                    <div class="colCenter alignLeft">
                        <h4>Colecciones</h4>
                        <ul>
                            <li><a href="#">Fotografías</a></li>
                            <li><a href="#">Obras de arte</a></li>
                            <li><a href="#">Libros</a></li>
                        </ul>
                    </div>
                    <div class="colCenter alignLeft">
                        <h4>Salas y<br />Servicios públicos</h4>
                        <ul>
                            <li><a href="#">Kubo-Kutxa</a></li>
                            <li><a href="#">Sala Boulevard</a></li>
                            <li><a href="#">Biblioteca Dr. Camino</a></li>
                        </ul>
                    </div>
                    <div class="colCenter alignLeft">
                        <h4>Otros</h4>
                        <ul>
                            <li><a href="#">Tienda</a></li>
                            <li><a href="#">Actualidad</a></li>
                        </ul>
                    </div>
                    <div class="colRight alignRight">
                        <h4 class="verde">Enlaces de interés</h4>
                        <ul>
                            <li><span class="cuadraditoVerde items"></span> <a href="#">Kutxa Social</a></li>
                            <li><span class="cuadraditoVerde items"></span> <a href="#">Kutxabank</a></li>
                            <li><span class="cuadraditoVerde items"></span> <a href="#">Blog Kutxateka</a></li>
                        </ul>
                    </div>
                </div>
            </footer>

        </div>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        
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
						exposeBackgroundOpacity: 0.7,							/* opacity of background color masking out page content; 1.0 is opaque */
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
