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
	<div id="footer-top">
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<?php print caGetThemeGraphic($this->request, 'families.png'); ?>
					<p class="textBlock">
						A dedicated section for the loved ones of those killed in the 2001 and 1993 attacks. Stay informed and plan your visit.
					</p>
					<a href="https://www.911memorial.org/information-911-family-members">More Information »</a>
				</div><!-- end col -->
				<div class="col-sm-4">
					<?php print caGetThemeGraphic($this->request, 'give.png'); ?>
					<p class="textBlock">
						The National September 11 Memorial & Museum is only possible because of your support.
					</p>
					<a href="https://www.911memorial.org/make-monetary-donation-now">All donations are tax deductible »</a>
				</div><!-- end col -->
				<div class="col-sm-4">
					<?php print caGetThemeGraphic($this->request, 'updates.png'); ?>
					<p class="textBlock">
						Stay informed about news and events by subscribing to our newsletter.
					</p>
					<br/>
					<a href="https://www.911memorial.org/sign-911-memorial-news">Sign up here »</a>
				</div><!-- end col -->
			</div><!-- end row -->
		</div>
	</div><!-- end footer-top-->
	<div id="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<h4>National September 11 Memorial & Museum</h4>
					Administrative Office
					<br/>200 Liberty Street, 16th Floor
					<br/>New York, NY 10281
					<br/>(212) 312-8800
				</div><!-- end col -->
				<div class="col-sm-3 centerCol">
					<a href="https://www.911memorial.org/contact-us">Contact Us</a>
					<br/><a href="https://www.911memorial.org/privacy-policy">Terms of Use / Privacy Policy</a>
					<br/><a href="https://www.911memorial.org/financial-and-legal-information">Financial & Legal Information</a>
					<br/><a href="https://secure.ethicspoint.com/domain/en/report_custom.asp?clientid=19476">Ethics Point Hotline</a>
					<br/><a href="https://www.911memorial.org/node/1019876">Feedback</a>
				</div><!-- end col -->
				<div class="col-sm-3">
					<a href="https://www.facebook.com/911memorial">Facebook</a>
					<br/><a href="https://twitter.com/sept11memorial">Twitter</a>
					<br/><a href="https://instagram.com/911memorial/">Instagram</a>
					<br/><a href="https://plus.google.com/+911Memorial/posts">Google +</a>
					<br/><a href="https://pinterest.com/911memorial/">Pinterest</a>
					<br/><a href="https://www.youtube.com/user/911memorial">YouTube</a>
					<br/><a href="http://911memorialmuseum.tumblr.com/">Tumblr</a>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-4 copyright">
					&copy; 2016 National September 11 Memorial & Museum 9/11 MEMORIAL is a registered trademark of the National September 11 Memorial & Museum. 
				</div><!-- end col -->
			</div><!-- end row -->
		</div>
	</div><!-- end footer-bottom-->
<!--	
	<div id="footer">
		<div class="container">
			<ul class="list-inline">
				<li><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
				<li><?php print caNavLink($this->request, _t("FAQ"), "", "", "About", "faq"); ?></li>
				<li><a href="#">Contact Us</a></li>
				<li><?php print caNavLink($this->request, _t("Terms of Use / Privacy Policy"), "", "", "About", "terms"); ?></li>
			</ul>
			<div>
				&copy; 2015 National September 11 Memorial & Museum.<br/>
				9/11 MEMORIAL is a registered trademark of the National<br/>
				September 11 Memorial & Museum
			</div>
		</div>
	</div>
-->
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
		
			$(function () {
			  $('[data-toggle="popover"]').popover()
			});
		</script>
	</body>
</html>
