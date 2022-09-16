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
		<footer id="footer" class="text-center">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 text-left">
						<div class="orgTitle">SITI Company</div>
						<div class="address">
							520 8th Avenue, Suite 310
							<br/>New York, NY 10018
							<br/>212-868-0860
						</div>
						<a href="mailto:inbox@siti.org">inbox@siti.org</a>
					</div>
					<div class="col-sm-2">
						<div class="footerNavLinks text-left">
							<a href="https://siti.org/productions/" target="_blank">Productions</a><br/>
							<a href="https://siti.org/training/" target="_blank">Training</a><br/>
							<a href="https://siti.org/about/" target="_blank">About</a>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="footerNavLinks col2 text-left">
							<a href="https://siti.org/get-involved/" target="_blank">Get Involved</a><br/>
							<a href="https://siti.org/blog/" target="_blank">Blog</a>
						</div>
					</div>
					<div class="col-sm-4 text-right">
						<div>
							<a href="https://www.siti.org"><?php print caGetThemeGraphic($this->request, 'SITI_logo_white.png', array("alt" => $this->request->config->get("app_display_name"))); ?></a>
						</div>
						<div>
							<a href="https://secure.givelively.org/donate/saratoga-international-theater-institute-inc" target="_blank" class="btn btn-default">Donate</a>
						</div>
						<ul class="list-inline social">
							<li><a href="https://www.instagram.com/siti_company/" target="_blank"><i class="fa fa-instagram"></i></a></li>
							<li><a href="http://www.facebook.com/siticompany" target="_blank"><i class="fa fa-facebook-square"></i></a><!--<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg>--></li>
							<li><a href="http://www.twitter.com/siticompany" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="http://www.youtube.com/channel/UCAVWC_6X8zWcw6VNKY0C5tQ" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 text-left">
						<div class="copyright">© <?php print date("Y"); ?> All Rights Reserved.</div>
					</div>
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
