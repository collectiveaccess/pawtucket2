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
		$vs_contactType = $this->request->getParameter("contactType", pString);
		if((in_array($this->request->getAction(), array("videooutartists", "videoout"))) || (in_array($this->request->getController(), array("About", "VideoOut", "VideoOutAbout", "VideoOutSubmit", "VideoOutNews"))) || (($this->request->getController() == "Contact") && (in_array($vs_contactType, array("ResearchRequest", "Reproduction", "RentalPurchase"))))){
?>
			</div></div>
<?php
		}
?>
		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<footer id="footer" class="text-center"><div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="footer-logo"><a href="https://www.vivomediaarts.com"><?php print caGetThemeGraphic($this->request, 'footerLogo.png', array("alt" => "VIVO Media Arts Centre")); ?></a></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-3">
					<div class="footerUnit">Tuesday to Friday<br/>12pm - 6pm</div>
					<div class="footerUnit">2625 Kaslo Street<br/>Vancouver, BC &nbsp;V5M 3G9</div>
					<div class="footerUnit"><a href="https://goo.gl/maps/9BhcTmLHpDjBKWNQ9" target="_blank" class="footer-link">Show on Map</a><div class="link-icon invert"></div></div>
					<div class="footerUnit landAck">
						VIVO is located on the stolen, sacred and ancestral territories of the xʷməθkʷəy̓əm (Musqueam), Sḵwx̱wú7mesh (Squamish), and səl̓ílwətaɬ (Tsleil-Waututh) Nations.
					</div>
				</div>
				<div class="col-sm-12 col-md-3">
					<div class="footerUnit"><div class="footer-title">Rentals + Services</div></div>
					
					<div class="footerUnit">
						<a href="https://www.vivomediaarts.com/programming/?tab=tab-link.current" class="footer-link">Current</a>
					</div>
					<div class="footerUnit">
						<a href="https://www.vivomediaarts.com/programming/?tab=tab-link.upcoming" class="footer-link">Upcoming</a>
					</div>
					<div class="footerUnit">
						<a href="https://www.vivomediaarts.com/programming/?tab=tab-link.past" class="footer-link">Past</a>
					</div>
					<div class="footerUnit">
						<a href="https://www.vivomediaarts.com/call-for-submissions" class="footer-link">Call for Submissions</a>
					</div>
					<div class="footerUnit">
						<br/><div class="footer-title">Rentals + Services</div>
					</div>
					<div class="footerUnit">
						<a href="https://www.vivomediaarts.com/rentals-services/digitization" class="footer-link">Digitization</a>
					</div>
					<div class="footerUnit">
						<a href="https://www.vivomediaarts.com/rentals-services/equipment" class="footer-link">Equipment</a>
					</div>
					<div class="footerUnit">
						<a href="https://www.vivomediaarts.com/rentals-services/space-rentals" class="footer-link">Venue Rental</a>
					</div>
				</div>
				<div class="col-sm-12 col-md-3">	
						<div class="footerUnit"><div class="footer-title">About VIVO</div></div>
						<div class="footerUnit"><a href="https://www.vivomediaarts.com/about" class="footer-link">Vision, Mission + Values</a></div>
						<div class="footerUnit"><a href="https://www.vivomediaarts.com/people" class="footer-link">People</a></div>
						<div class="footerUnit"><a href="https://www.vivomediaarts.com/venue-accessibility" class="footer-link">Venue Accessibility</a></div>
						<div class="footerUnit"><a href="https://www.vivomediaarts.com/work-with-vivo" class="footer-link">Work with VIVO</a></div>
						<div class="footerUnit"><a href="https://www.vivomediaarts.com/news" class="footer-link">News</a></div>
						<div class="footerUnit"><a href="https://www.vivomediaarts.com/memberships" aria-current="page" class="footer-link w--current">Memberships</a></div>
					
				</div>
				<div class="col-sm-12 col-md-3">
						<div class="footer-title">Follow Us</div>
						<div class="footerUnit"><a href="https://instagram.com/vivomediaarts" target="_blank" class="footer-link">Instagram</a></div>
						<div class="footerUnit"><a href="https://www.facebook.com/vivomediaarts" target="_blank" class="footer-link">Facebook</a></div>
						<div class="footerUnit"><a href="https://twitter.com/VIVOMediaArts" target="_blank" class="footer-link">Twitter</a></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="footnote-block">
					<div class="funding">We are financially supported by individual donations, the Province of BC through the BC Arts Council and BC Gaming Commission, the City of Vancouver, and the Canada Council for the Arts.</div>
				
					<div class="copyright">© 2022 VIVO Media Arts + Satellite Video Exchange Society</div>
					</div>
				</div>
			</div>
		</div></footer><!-- end footer -->

	
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
<?php
	print $this->render("Cookies/banner_html.php");	
?>
	</body>
</html>
