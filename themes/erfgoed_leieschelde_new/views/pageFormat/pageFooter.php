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
		</div><!-- end col --></div><!-- end main --></div><!-- end row --></div><!-- end container --></div><!-- end pageArea -->
		<footer id="footer" role="contentinfo">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12 text-center">
							<ul class="list-inline footerLinks">
								<li><i class="fa fa-home" aria-hidden="true"></i> <a href="https://www.cultuurregioleieschelde.be" target="_blank">www.cultuurregioleieschelde.be</a></li>
								<li><i class="fa fa-map-marker" aria-hidden="true"></i> Tolpoortstraat 79, 9800 Deinze</li>
								<li><i class="fa fa-users" aria-hidden="true"></i> <?php print caNavLink($this->request, "Contact", "", "", "Contact", "form"); ?></li>
								<li><i class="fa fa-phone" aria-hidden="true"></i> 09 386 78 86</li>
								<li><i class="fa fa-check" aria-hidden="true"></i> <?php print caNavLink($this->request, "Disclaimer", "", "", "About", "disclaimer"); ?></li>
								<li><div class="funder text-center"><a href="http://www.vlaanderen.be" target="_blank"><?php print caGetThemeGraphic($this->request, 'Vlaanderen_verbeelding_werkt.png'); ?></a></div></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<ul class="list-inline social">
								<li><a href="https://www.facebook.com/Cultuurregioleieschelde" target="_blank"><i class="fa fa-facebook-square" aria-label="Facebook"></i></a></li>
								<li><a href="https://www.instagram.com/cultuurregioleieschelde/" target="_blank"><i class="fa fa-instagram" aria-label="Instragram"></i></a></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							Erfgoedbank Leie Schelde is een initiatief van de Cultuurregio Leie Schelde i.s.m. Deinze, De Pinte, Gavere, Nazareth, Sint-Martens-Latem en Zulte.
							<?php print ((CookieOptionsManager::cookieManagerEnabled()) ? "<br/>".caNavLink($this->request, _t("Manage Cookies"), "small", "", "Cookies", "manage") : ""); ?>
						</div>
					</div>
				</div>
			</div>
		</footer>

	
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
						exposeBackgroundColor: '#FFFFFF',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.5,							/* opacity of background color masking out page content; 1.0 is opaque */
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
			
			$(document).ready(function(){
				$(window).scroll(function(){
					$("#hpScrollBar").fadeOut();
				});
				$(function() {
					//caches a jQuery object containing the header element
					var html = $("html");
					
						$(window).scroll(function() {
							var scroll = $(window).scrollTop();

							if (scroll >= 125) {
								html.removeClass('initial');
							} else {
								html.addClass('initial');
							}
							
						});
					
				});
			});
		</script>
<?php
	print $this->render("Cookies/banner_html.php");	
?>

	</body>
</html>
