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
<?php
	$vs_controller = strToLower($this->request->getController());
	if(!in_array($vs_controller, array("browse", "search"))){
?>
		<footer id="footer">
			<div class="darkRedBg text-center">
				<div>
					Need support? The Indian Residential School Survivor Support Society<br/>has established a 24-hour Crisis Line for former students and their families. Call: 1-866-925-4419<br/>
					Find additional <a href="https://irshdc.ubc.ca/for-survivors/healing-and-wellness-resources/" target="_blank">wellness resources and supports</a>.
				</div>
			</div>
			<div class="footerBottom">
				<div class="row">
					<div class="col-sm-6">
						<?php print caGetThemeGraphic($this->request, 'ubc.jpg'); ?>
						<div class='footerAddress'>
							Vancouver Campus
							<br/>1985 Learner's Walk
							<br/>Vancouver, BC, Canada
							<br/>V6T 1Z1
							<br/><br/><a href="https://ubc.us20.list-manage.com/subscribe?u=864c7c8b0267ee128e9375a0b&id=eab5d0fbd2" target="_blank">Subscribe to the Centre's newsletter</a>
						</div>
					</div>
					<div class="col-sm-6">
						<ul class="list-inline footerLinks" style="clear:right;">
							<li><a href="//cdn.ubc.ca/clf/ref/terms" title="Terms of Use">Terms of Use</a></li>
							<li>|</li>
							<li><a href="//cdn.ubc.ca/clf/ref/copyright" title="UBC Copyright">Copyright</a></li>
						</ul>
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
<?php
	}
	
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
