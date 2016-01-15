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
		
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-4">
					<a href="#"><h3 class="rokkit-reg">ABOUT CENTRO</h3></a>
					<ul id='footerAbout'>
						<li><a href="#">Directors Corner</a></li>
						<li><a href="#">Staff</a></li>
						<li><a href="#">History</a></li>
						<li><a href="#">Jobs</a></li>
					</ul>
				</div>
				<div class="col-xs-12 col-md-2">
					<h3 class="rokkit-reg">EVENTS &amp; CULTURE</h3>
					<ul>
						<li><a href="#">Calendar</a></li>
						<li><a href="#">Exhibits</a></li>
						<li><a href="#">Conferences</a></li>
						<li><a href="#">Conferences</a></li>
					</ul>
				</div>
				<div class="col-xs-12 col-md-2">
					<h3 class="rokkit-reg">COLLECTIONS</h3>
					<ul>
						<li><a href="#">Oral Histories</a></li>
						<li><a href="#">Galleries</a></li>
						<li><a href="#">Virtual Exhibits</a></li>
					</ul>
				</div>
				<div class="col-xs-12 col-md-2">
					<h3 class="rokkit-reg">LIBRARY &amp; PUBLICATIONS</h3>
					<ul>
						<li><a href="#">Centro Publications</a></li>
						<li><a href="#">Briefs</a></li>
						<li><a href="#">Centro Journals</a></li>
					</ul>
				</div>
				<div class="col-xs-12 col-md-2">
					<h3 class="rokkit-reg">RESEARCH &amp; EDUCATION</h3>
					<ul>
						<li><a href="#">Educational Products</a></li>
						<li><a href="#">Teaching Guides</a></li>
						<li><a href="#">Documentaries</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div><!-- end footer -->
	<div id="footer2">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<small><strong>Center for Puerto Rican Studies</strong> | Hunter College | 695 Park Avenue | Room E1429 | New York, NY 10065 | C 2015 Centro Center for Puerto Rican Studies Privacy Policy | Disclaimer</small>
				</div>
				<div class="col-sm-6 text-right">
					<?php print caGetThemeGraphic($this->request, 'Hunter_logo_xsmall.png'); ?>
				</div>
			</div>
		</div>
	</div><!-- end footer -->	
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
