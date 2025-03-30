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
		</div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<div id="footer">
			<div class="left-box">
			<a href="http://www.nysed.gov"><?php print caGetThemeGraphic($this->request, 'footer-logo.png', array( 'width' => '100px', 'height' => '79px', 'alt' => 'New York State Education Department'));?></a>
			<p>
				The New York State Archives is part of the Office of Cultural Education, an office 
				of the New York State Education Department.
			</p>
		</div>
		<ul>
			<li class="list-item-one">
				<ul>
					<li><a href="http://www.archives.nysed.gov/about/about-nysa">About Us</a></li>
					<li><a href="http://www.archives.nysed.gov/directories/index.shtml">Contact Us</a></li>
					<li><a href="http://iarchives.nysed.gov/xtf/search?">Finding Aids</a></li>
					<li><a href="http://www.archives.nysed.gov/news">News</a></li>
					<li><a href="http://www.archives.nysed.gov/about/site-map">Site Map</a></li>
					
				</ul>
			</li>
			<li class="list-item-two">
				<ul>
					<li><a href="https://www.nysarchivestrust.org/new-york-archives-magazine">New York Archives Magazine</a></li>
					<li><a href="https://www.nysarchivestrust.org/">Archives Partnership Trust</a></li>
					<li><a href="http://www.archives.nysed.gov/shrab">New York State Historical Records</a></li>
					<li class="advisory-board"><a href="http://www.archives.nysed.gov/shrab">Advisory Board</a></li>
					<li><a href="http://www.oce.nysed.gov/">Office of Cultural Education</a></li>
				</ul>
			</li>
			<li>
				<ul>
					<li><a href="http://www.nysed.gov/">New York State Education Department</a></li>
					<li><a href="http://www.ny.gov/">New York State</a></li>
					<li><a href="http://www.nysed.gov/privacy-policy">Privacy Policy</a></li>
					<li><a href="http://www.nysed.gov/terms-of-use">Terms of Use</a></li>
					<li><a href="http://www.nysed.gov/terms-of-use#Accessibility">Accessibility</a></li>
				</ul>
			</li>
		</ul>
		
			<p class="bottom-paragraph">To report technical problems with this web site, please contact the New York State Archives at <a href="mailto:archinfo@nysed.gov">archinfo@nysed.gov</a> </p>
		</div>
	</div><!-- end pageArea -->
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
		<script>
  			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-507388-26', 'auto');ga('send', 'pageview');

</script>
	</body>
</html>
