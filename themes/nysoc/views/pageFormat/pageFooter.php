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
		if ($this->request->getController() != "Front") {		
			print '<a href="#top" style="float:right;padding-top:50px;">Back to Top</a>';
		}
?>		
	</div><!-- end pageArea -->
	</div><!-- end col --></div><!-- end container -->		

			<div id="footerArea" class="footerArea">
				<div id="libAd" class="col1">
					<h3>The New York <br> Society Library</h3>
					<p>53 East 79th Street <br> New York, NY 10075 <br> 212.288.6900 <br> <a href="mailto:reference@nysoclib.org"> reference@nysoclib.org</a></p>
				</div>
				<div id="footerImage" class="col2">
					<img src="https://www.nysoclib.org/sites/all/themes/nysoclib/images/clock.png" alt="">
				</div>
				<div id="libHours" class="col3">
					<h3>Hours of Operation</h3>
					<div>Monday / Friday<br> 9:00 AM - 5:00 PM</div>
					<div>Tuesday / Wednesday / Thursday <br> 9:00 AM - 8:00 PM</div>
					<div>Saturday / Sunday&nbsp;</div>
					<div>11:00 AM - 5:00 PM</div>
				</div>
				<div id="libInfo" class="col4">
					<div>
						<h3>The Library Will Be Closed</h3><div>Sunday, March 27</div><div>For Easter</div>
						<div><p><span style="line-height: 1.538em;">All areas except Circulation close 15 minutes prior to building closing time.</span></p></div>
					</div>
				</div>
				<div id="libLinks" class="col5">
					<div class="footerItems"><a href="http://nysoclib.org/about/map"> MAP</a> <br> <a href="http://nysoclib.org/about/directions"> DIRECTIONS</a> <br> <a href="https://www.facebook.com/nysoclib" target="_blank" class="sbIcon facebook"> Facebook </a> <a href="https://twitter.com/nysoclib" target="_blank" class="sbIcon twitter"> Twitter</a></div>
				</div>
				<div class="clear">&nbsp;</div>
				<div id="footerCopyright">
					<span class="copyright">©</span> Copyright The New York Society Library | <a href="/about/privacy-policy">Privacy Policy</a>
				</div>
				<div id="footerDesigner">Site Design: <a href="http://www.bfdg.com" target="_blank">Bernhardt Fudyma Design Group</a></div>
			</div><!-- end footerArea -->

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
		<script> (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-39467259-1', 'auto'); ga('send', 'pageview'); </script>
	</body>
</html>
