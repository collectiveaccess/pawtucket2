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
	if(strtolower($this->request->getController()) != "front"){
?>
		</div><!-- end col --></div><!-- end row --></div><!-- end container -->
<?php	
	}
?>
		<div id="footer">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="kentlerLogo"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'KentlerLogo.jpg'), "", "", "",""); ?></div>
						<h3>
							353 Van Brunt Street<br/>RED HOOK<br/>Brooklyn &middot; NY &middot; 11231
						</h3>
					</div><!-- end col -->
					<div class="col-sm-6">
						<h5>
							<span class="openSansBold">HOURS</span>&nbsp;&nbsp; Thurs-Sun <span class="openSansBold">&middot;</span> 12-5PM<div style="margin:0px 0px 5px 52px; padding:0px;">(During Exhibitions)</div>
							<span class="openSansBold">PHONE</span>&nbsp;&nbsp; 718<span class="openSansBold">&middot;</span>875<span class="openSansBold">&middot;</span>2098
							<br/><ul class="list-inline pull-right social">
								<li><a href="https://twitter.com/KentlerDrawing" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li><a href="https://www.facebook.com/kentlerdrawing" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
								<li><a href="https://www.instagram.com/kentlerdrawing" target="_blank"><i class="fa fa-instagram"></i></a></li>
								<li><a href="mailto:drawing@kentlergallery.org"><i class="fa fa-envelope"></i></a></li>
							</ul>
							<div class='terms'><a href="/news/index.php/terms-of-use">Terms of Use</a></div>
						</h5>
					</div>
				</div><!-- end row -->
			</div><!-- end container -->
		</div><!-- end footer -->
<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}	
		#first visit sets the session
		Session::setVar('visited', 'has_visited');
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
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-101588167-1', 'auto');
  ga('send', 'pageview');

</script>
	</body>
</html>
