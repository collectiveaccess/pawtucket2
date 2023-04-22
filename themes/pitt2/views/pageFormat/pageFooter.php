<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2018 Whirl-i-Gig
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
		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<footer id="footer" class="text-center">
			<div class="container"><div class="row footerExtraPadding">
				<div class="col-sm-3 text-left">
					<a href="https://www.uag.pitt.edu/about-the-uag">About the UAG</a><br/>
					<a href="https://www.uag.pitt.edu/exhibitions"<?php print (strToLower($this->request->getController()) == "gallery") ? " class='footerHighlight'" : ""; ?>>Exhibitions</a><br/>
					<a href="https://www.uag.pitt.edu/events">Events</a><br/>
					<?php print caNavLink($this->request, "Collections", (strToLower($this->request->getController()) != "gallery") ? "footerHighlight" : "", "", "", ""); ?><br/>
					<a href="https://www.uag.pitt.edu/academic-programs">Academic Programs</a><br/>
					<a href="https://www.uag.pitt.edu/look-listen-read">Look, Listen & Read</a>
				</div>
				<div class="col-sm-5 text-left">
					<div class='footerCol2Links'>
						<a href="https://www.haa.pitt.edu/" target="_blank">History of Art and Architecture Home <span class="ticon ticon-external-link"></span></a><br/>
						<a href="https://www.pitt.edu/" target="_blank">University of Pittsburgh Home <span class="ticon ticon-external-link"></span></a><br/>
						<a href="https://www.pitt.edu/privacy-policy" target="_blank">Privacy Policy <span class="ticon ticon-external-link"></span></a><br/>
						<a href="https://www.uag.pitt.edu/subscribe">Subscribe</a>
					</div>
					<div class="footerSocial">
						<a href="https://www.facebook.com/PittUAG/" class="wpex-social-btn wpex-social-btn-no-style wpex-has-custom-color wpex-facebook wpex-dhover-12" target="_blank" title="Facebook" style="color:#ffffff;" rel="noopener noreferrer"><span class="ticon ticon-facebook" aria-hidden="true"></span><span class="screen-reader-text">Facebook</span></a>
						<a href="https://www.instagram.com/pitt_uag/" class="wpex-social-btn wpex-social-btn-no-style wpex-has-custom-color wpex-instagram wpex-dhover-13" target="_blank" title="Instagram" style="color:#ffffff;" rel="noopener noreferrer"><span class="ticon ticon-instagram" aria-hidden="true"></span><span class="screen-reader-text">Instagram</span></a>
					</div>
				</div>
				<div class="col-sm-3 col-sm-offset-1 text-right">
					<div class="pittAddress">
						<?php print caGetThemeGraphic($this->request, 'university_pittsburgh_university_art_gallery_white.png', array("alt" => "University Art Gallery")); ?>
						<hr/>
						Frick Fine Arts Building
						<br/><a href="https://www.google.com/maps/place/University+of+Pittsburgh+-+Frick+Fine+Arts+Library/@40.4416615,-79.9534302,17z/data=!3m2!4b1!5s0x8834f227bc624611:0x3ae08d298a709d88!4m5!3m4!1s0x8834f227d19505a5:0xaec78aa38b70425b!8m2!3d40.4416574!4d-79.9512415" target="_blank" rel="noopener">650 Schenley Drive<br>Pittsburgh, PA 15260</a>
						<br/><a href="mailto:uag@pitt.edu">uag@pitt.edu</a> | <a href="tel:1-412-648-2400">1-412-648-2400</a>	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-left">
					<div class="footerCopyright">&copy; University Art Gallery</div>
				</div>
			</div></div>
		</footer><!-- end footer -->
<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
	
		<?php print TooltipManager::getLoadHTML(); ?>
		<div id="caMediaPanel" role="complementary"> 
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
						onCloseCallback: function(data) {
							if(data && data.url) {
								window.location = data.url;
							}
						},
						exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.5,							/* opacity of background color masking out page content; 1.0 is opaque */
						panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
						allowMobileSafariZooming: true,
						mobileSafariViewportTagID: '_msafari_viewport',
						closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
					});
				}
			});
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		
//			$(document).ready(function() {
//				$(document).bind("contextmenu",function(e){
//				   return false;
//				 });
//			}); 

			
				jQuery(document).ready(function() {
					//caches a jQuery object containing the header element
					var body = $("body");
					
						$(window).scroll(function() {
							var scroll = $(window).scrollTop();

							if (scroll >= 125) {
								body.removeClass('initial', 1400, 'linear');
							} else {
								body.addClass('initial', 1400, 'linear');
							}							
						});
					
				});
		</script>
<?php
	print $this->render("Cookies/banner_html.php");	
?>
	</body>
</html>
