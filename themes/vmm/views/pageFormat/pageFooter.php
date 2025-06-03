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
		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea -->
<?php
	if(strToLower($this->request->getController()) != "front"){
		print "</div><!-- end col --></div><!-- end row --></div><!-- end container -->";
	}
?>
		<footer id="footer" class="text-center">
			<div class="row">
				<div class="col-sm-12 text-center">
					<p>
						<a href="https://vancouvermaritimemuseum.com/" class="museumLink">Vancouver Maritime Museum</a>
						<div class="address">1905 Ogden Avenue in Vanier Park, Vancouver, BC V6J 1A3</div>
					</p>
					<ul class="list-inline social">
						<li><a href="https://www.facebook.com/vanmaritime" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
						<li><a href="https://www.instagram.com/vanmaritime/" target="_blank"><i class="fa fa-instagram"></i></a></li>
						<li><a href="https://twitter.com/vanmaritime" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
					</ul>
					<ul class="list-inline">
						<li><a href="https://vancouvermaritimemuseum.com/" target="_blank">Museum Home</a></li>
						<li><?php print caNavLink($this->request, _t("Contact"), "", "", "About", "Contact"); ?></li>
						<li><?php print caNavLink($this->request, _t("Terms of Use"), "", "", "About", "TermsOfUse"); ?></li>
						<li><?php print caNavLink($this->request, _t("Privacy Policy"), "", "", "About", "PrivacyPolicy"); ?></li>
					</ul>
					<p class="funder">
						<a href="https://www.canada.ca/en/canadian-heritage.html" target="_blank"><?php print caGetThemeGraphic($this->request, '3li_EnFr_Wordmark_C.png'); ?></a>
					</p>
				</div>
			</div>
		</footer><!-- end footer -->

	
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
			
				$(function() {
					//caches a jQuery object containing the header element
					var body = $("body");
					
						$(window).scroll(function() {
							if ($(window).width() > 992) {
								var scroll = $(window).scrollTop();

								if (scroll >= 125) {
									body.removeClass('initial', 1400, 'linear');
								} else {
									body.addClass('initial', 1400, 'linear');
								}
							}else{
								if(!body.hasClass('initial')){
									body.addClass('initial');
								}
							}
						});
					
				});
				
			
			});
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		</script>
		<script type="text/javascript" language="javascript">
			jQuery(document).ready(function() {
				$('html').on('contextmenu', 'body', function(e){ return false; });
				$('html').on('dragstart', false);
			});
		</script>
	</body>
</html>
