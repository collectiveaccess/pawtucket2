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
		<footer id="footer" role="contentinfo">
			<div class="footerBg row">
				<div class="col-md-12 col-lg-8 col-lg-offset-2">
					<div class="footerHeading"><a href="https://www.dezuidrand.be/erfgoedcel-zuidrand"><span class="footerCopyright">&copy;</span> Erfgoedcel Zuidrand</a>
						<p>{{{footer_text}}}</p>
					</div>
					<div class="row">
						<div class="col-sm-4 footerContact">
							<a href="https://www.dezuidrand.be/erfgoedcel-zuidrand">Erfgoedcel Zuidrand</a><br/>
							Gemeenteplein 1<br/>
							2550 Kontich<br/><br/>
							T - 0483 56 01 68<br/>
							E - <a href="mailto:info@dezuidrand.be">info@dezuidrand.be</a>
							
						</div>
						<div class="col-sm-4">
							<ul class="list-inline social">
								<li><a href="https://www.facebook.com/StreekverenigingZuidrand" target="_blank"><i class="fa fa-facebook-square" aria-label="Facebook"></i></a></li>
								<li><a href="https://www.instagram.com/dezuidrand/" target="_blank"><i class="fa fa-instagram" aria-label="Instragram"></i></a></li>
								<li><a href="https://www.dezuidrand.be/" target="_blank"><i class="fa fa-home" aria-label="Home"></i></a></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<div class="funder">
								<a href="http://www.vlaanderen.be"><?php print caGetThemeGraphic($this->request, 'Vlaanderen-verbeelding-werkt_vol.png'); ?></a>
							</div>
							<?php print caNavLink($this->request, "Disclaimer", "", "", "About", "Disclaimer")." | ".((CookieOptionsManager::cookieManagerEnabled()) ? caNavLink($this->request, _t("Manage Cookies"), "", "", "Cookies", "manage") : ""); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 footerPartnerLogos">
					<a href="https://www.aartselaar.be/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logos/Aartselaar.png'); ?></a> 
					<a href="https://www.borsbeek.be/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logos/Borsbeek.png'); ?></a>
					<a href="https://www.edegem.be/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logos/Edegembaseline.png'); ?></a>
					<a href="https://www.hove.be/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logos/hove_logo-cymk.jpg'); ?></a> 
					<a href="https://www.kontich.be/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logos/Kontich.png'); ?></a>
					<a href="https://www.lint.be/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logos/GLI-7509_logo_pos_lokaalbestuur_rgb.png'); ?></a>
					<a href="https://www.mortsel.be/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logos/M-erktekenMortsel.png'); ?></a>
				</div>
			</div>
			<div class="footerLogos">
			
			</div>
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
		</script>
		<script type="text/javascript">
			$( ".front .notificationMessage" ).delay(1500).fadeOut("slow");
			$(document).ready(function(){
				$(document).bind("contextmenu",function(e){
					return false;
				});
				$(document).bind("dragstart", function(e) {
					return false;
				});
			});
		</script>
		<!-- Google tag (gtag.js) --> <script async src=https://www.googletagmanager.com/gtag/js?id=G-V2RZFKSWHQ></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-V2RZFKSWHQ'); </script>
<?php
	print $this->render("Cookies/banner_html.php");	
?>
	</body>
</html>
