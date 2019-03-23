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
<?php
	if(strtolower($this->request->getController()) != "detail"){
?>
		</div><!-- end container -->
<?php
	}
?>				
		</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<footer id="footer">
			<div class="row">
				<div class="col-md-3 col-sm-12">
					<h5>Museum of International Folk Art</h5>
					<p>
						706 Camino Lejo, on Museum Hill<br/>
						Santa Fe, New Mexico 87505<br/>
						Phone: (505) 476-1200 
					</p>
					<p class="directions">
						<a href="http://www.internationalfolkart.org/visit/directions.html"><i class="fa fa-location-arrow "></i> View Maps and Directions</a>
					</p>
				</div>
				<div class="col-md-3 col-sm-12">
					<ul>
						<li><a href="http://www.internationalfolkart.org">Museum Home</a></li>
						<li><a href="http://internationalfolkart.org/learn/library-and-archives.html">About the Archive</a></li>
						<li><a href="mailto:bartlett.library@state.nm.us">Questions? Ask the archivist</a></li>
					</ul>
				</div>
				<div class="col-md-4 col-sm-12">
					<div id="footerOptin">
						<h5>Get Updates &amp; Event Announcements</h5>
						<form action="http://internationalfolkart.us6.list-manage.com/subscribe/post?u=5220fed7ea92195f749f3c020&amp;id=097905fc46" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate newsletterForm" target="_blank"> 
						  <input value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter your email address" required="" type="email">
						  <input value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button" type="submit"></form>
					</div>
					<div id="footerConnect">
						<h5>CONNECT WITH US</h5>
						<a href="https://www.facebook.com/InternationalFolkArt" target="_blank"><i class="fa fa-facebook-official"></i></a>
						<a href="https://twitter.com/nmm_intfolkart" target="_blank"><i class="fa fa-twitter"></i></a>
						<a href="https://www.flickr.com/photos/moifa/" target="_blank"><span class="fa-flickr-hack"><i class="fa fa-circle blue"></i><i class="fa fa-circle"></i></span></a>
					</div>
				</div>
				<div class="col-md-2 col-sm-12 dcaFooter">
					<a href="http://www.newmexicoculture.org/" target="_blank"><img alt="New Mexico Department of Cultural Affairs Logo" class="dcaLogo" src="<?php print caGetThemeGraphicUrl($this->request, 'dca-logo.png'); ?>"></a>
					<p>
						<a href="http://www.newmexicoculture.org/" target="_blank">
							A Division of the New
							<br>
							Mexico Department of
							<br>
							Cultural Affairs
						</a>
					</p>
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
		<script type="text/javascript" language="javascript">
			jQuery(document).ready(function() {
				$('html').on('contextmenu', 'body', function(e){ return false; });
			});
		</script>
	</body>
</html>
