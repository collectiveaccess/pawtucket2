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
	
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1818796581723078";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<div id="footer">
			<div class="container mainContainer">
				<div class="row">
					<div class="col-sm-12">
						<div class="pull-right">
							<div class="socialButtons">
								<?php $current_url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]; ?>
								<div id="fb-root"></div>
								<script>(function(d, s, id) {
								  var js, fjs = d.getElementsByTagName(s)[0];
								  if (d.getElementById(id)) return;
								  js = d.createElement(s); js.id = id;
								  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10';
								  fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));</script>
								<div class="fb-like" data-href="<?php echo $current_url; ?>" data-width="60" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
								<div class="fb-share-button" data-href="<?php print $current_url; ?>" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php print urlencode($current_url); ?>%2F&amp;src=sdkpreparse">Share</a></div>
								<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
								<a href="https://www.pinterest.com/pin/create/button/">
    								<img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" />
								</a>
								<g:plusone size="medium" data-align="right"></g:plusone>
								<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
								<script type="IN/Share"></script>
							</div>
							<div class="inpageButtons"><a href="#" onclick="window.print();return false;"><i class="fa fa-print fa-2x" style="font-size: 1.25em"></i></a>				
							<a href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site: <?php print $current_url; ?>" title="Share by Email"><i class="fa fa-envelope fa-2x" style="font-size: 1.25em"></i></a>
							</div>
						</div>

						<ul class="list footerList">
							<li>Project of the Pine Needles Foundation of New York </li>
							<li>Copyright © <?php print date("Y"); ?> Manuscript Cookbooks Survey</li>
							<li>All Rights Reserved</li>
							<li>Library Website Design by Acorn Digital Marketing</li>
							<li>powered by <a href="http://www.collectiveaccess.org">CollectiveAccess 2017</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div><!-- end footer -->

	
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
