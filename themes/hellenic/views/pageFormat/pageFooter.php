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
		</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<div class="container bottom">
			
		</div>
		<footer id="footer">
			<div class="container" style="padding:0px;">
				<div style="width:47%;float:left;">
					<div class="footer_left_top">
						© 2015 National Hellenic Museum
					<!---->
					</div>
					<div class="footer_left_bottom">
						© 2017 National Hellenic Museum, Chicago  
						333 South Halsted Street, Chicago IL, 60661, Phone: (312) 655-1234, Fax: (312) 655-1221
						All text and images on this site are protected by the U.S. and International copyright laws. 
						Unauthorized use is prohibited.                
					</div>
				</div>
				<div style="width:47%;float:right;">
					<div class="social-icons icon_28">
						<a class="ttip" href="https://www.facebook.com/NationalHellenicMuseum" target="_blank" original-title="Facebook"><img src="https://www.nationalhellenicmuseum.org/wp-content/themes/zwordpress_theme/images/socialicons/facebook.png" alt="Facebook"></a><a class="ttip" href="https://twitter.com/Hellenicmuseum" target="_blank" original-title="Twitter"><img src="https://www.nationalhellenicmuseum.org/wp-content/themes/zwordpress_theme/images/socialicons/twitter.png" alt="Twitter"></a><a class="ttip" href="https://www.linkedin.com/company/national-hellenic-museum" target="_blank" original-title="LinkedIn"><img src="https://www.nationalhellenicmuseum.org/wp-content/themes/zwordpress_theme/images/socialicons/linkedin.png" alt="LinkedIn"></a><a class="ttip" href="https://www.flickr.com/photos/124882725@N04" target="_blank" original-title="Flickr"><img src="https://www.nationalhellenicmuseum.org/wp-content/themes/zwordpress_theme/images/socialicons/flickr.png" alt="Flickr"></a><a class="ttip" href="https://www.youtube.com/user/NatlHellenicMuseum" target="_blank" original-title="Youtube"><img src="https://www.nationalhellenicmuseum.org/wp-content/themes/zwordpress_theme/images/socialicons/youtube.png" alt="YouTube"></a><a class="ttip" href="https://www.instagram.com/hellenicmuseum" target="_blank" original-title="instagram"><img src="https://www.nationalhellenicmuseum.org/wp-content/themes/zwordpress_theme/images/socialicons/instagram.png" alt="instagram"></a>	
					</div>
					<div class="footer-menu">
						<ul id="menu-footer-menu" class="menu"><li id="menu-item-124" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-124"><a href="https://www.nationalhellenicmuseum.org/terms-conditions/">Terms &amp; Conditions</a></li>
							<li id="menu-item-125" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-125"><a href="https://www.nationalhellenicmuseum.org/privacy-policy/">Privacy Policy</a></li>
							<li id="menu-item-986" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-986"><a>#0 (no title)</a></li>
						</ul>
					</div>									
					<div style="text-align:right;margin-top:15px;"><small>powered by <a href="http://www.collectiveaccess.org">CollectiveAccess 2017</a></small></div>
				
				</div>					
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
	</body>
</html>
