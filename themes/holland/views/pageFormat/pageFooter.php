<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
		<div style="clear:both;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
	<footer class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-4 widget footer-widget widget_text">
					<h4 class="widgettitle">About our museum</h4>
					<div class="textwidget">
						<p><a href="https://www.hollandmuseum.org" class="footer-img" target="_blank"><?php print caGetThemeGraphic($this->request, 'HMcolorRGB.png'); ?></a></p>
						<p>(616) 796-3329</p>
						<p>The Holland Museum is located at the corner of 10th Street and River Avenue, across from Centennial Park. Please use the parking lot behind the museum on 9th Street or street parking available along 10th Street. Handicap accessibility is available from the east side of building.</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 widget footer-widget widget_text">
					<h4 class="widgettitle">Our Venues</h4>
					<div class="textwidget">
						<address>
							<a href="https://www.hollandmuseum.org/?venue=holland-museum" target="_blank"><strong>Holland Museum</strong></a><br>
							<span>31 W. 10th Street<br>
							Holland, MI 49423</span>
						</address>
						<hr>
						<address>
							<a href="https://www.hollandmuseum.org/?venue=cappon-house" target="_blank"><strong>Cappon House</strong></a><br>
							<span>228 W. 9th Street<br>Holland, MI 49423</span>
						</address>
						<hr>
						<address>
							<a href="https://www.hollandmuseum.org/?venue=settlers-house" target="_blank"><strong>Settlers House</strong></a><br>
							<span>190 W. 9th Street<br>
							Holland, MI 49423</span>
						</address>
						<hr>
						<address>
							<a href="https://www.hollandmuseum.org/?venue=the-armory" target="_blank"><strong>The Armory</strong></a><br>
							<span>16 W. 9th Street<br>Holland, MI 49423</span>
						</address>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 widget footer-widget widget_text">
					<h4 class="widgettitle">Supported By</h4>
					<div class="textwidget">
						<p><?php print caGetThemeGraphic($this->request, 'macc-logo-color.png'); ?><br />&nbsp;</p>
						<p><?php print caGetThemeGraphic($this->request, 'Holland-MuseumNEA-.png'); ?></p>
					</div>
				</div>
			</div>
		</div>
		<div style="clear:both;"><!-- empty --></div>
	</footer><!-- end footer -->
	<footer class="site-footer-bottom">
    	<div class="container">
        	<div class="row">
              	<div class="col-md-6 col-sm-6 copyrights-left">
					Holland Museum All Rights Reserved                
				</div>
                <div class="col-md-6 col-sm-6 copyrights-right">
                	<ul class="pull-right social-icons-colored">
                    	<li class="facebook"><a href="http://www.facebook.com/hollandmuseum" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    	<li class="twitter"><a href="http://www.twitter.com/hollandmuseum" target="_blank"><i class="fa fa-twitter"></i></a></li>                   	</ul>
                </div>
           	</div>
        </div>
    </footer>
<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
	
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
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		</script>
		<script type="text/javascript">
			$(window).scroll(function(){ 
				var scrollLimit = 190;
				var pos = $(window).scrollTop();
				if(pos > scrollLimit) {
					$("body").removeClass("initial");
				}else {
					if(!$("body").hasClass("initial")){
						$("body").addClass("initial");
					}
				}
			});
		</script>		

	</body>
</html>
