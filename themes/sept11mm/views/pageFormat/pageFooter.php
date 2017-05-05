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
<<<<<<< HEAD
					<h2>For 9/11 Families</h2>
=======
					<?php print caGetThemeGraphic($this->request, 'families.png', array('alt' => 'For 9/11 Families')); ?>
>>>>>>> 4f5b4a2238c4b5e929aed6692f176b41c49e81d1
					<p class="textBlock">
						A dedicated section for the loved ones of those killed in the 2001 and 1993 attacks. Stay informed and plan your visit.
					</p>
					<a href="https://www.911memorial.org/information-911-family-members">More Information »</a>
				</div><!-- end col -->
				<div class="col-sm-4">
<<<<<<< HEAD
					<h2>Give</h2>
=======
					<?php print caGetThemeGraphic($this->request, 'give.png', array('alt' => 'Give')); ?>
>>>>>>> 4f5b4a2238c4b5e929aed6692f176b41c49e81d1
					<p class="textBlock">
						The National September 11 Memorial & Museum is only possible because of your support.
					</p>
					<a href="https://www.911memorial.org/make-monetary-donation-now">All donations are tax deductible »</a>
				</div><!-- end col -->
				<div class="col-sm-4">
<<<<<<< HEAD
					<h2>Updates</h2>
=======
					<?php print caGetThemeGraphic($this->request, 'updates.png', array('alt' => 'Updates')); ?>
>>>>>>> 4f5b4a2238c4b5e929aed6692f176b41c49e81d1
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
					National September 11 Memorial Museum<br/>
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
					&copy; 2016 National September 11 Memorial & Museum<br/>9/11 MEMORIAL is a registered trademark of the National September 11 Memorial & Museum. 
				</div><!-- end col -->
			</div><!-- end row -->
		</div>
	</div><!-- end footer-bottom-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-5638262-14', 'auto');
  ga('send', 'pageview');
 
</script>
<script type="text/javascript">
var clicky_site_ids = clicky_site_ids || [];
clicky_site_ids.push(100990350);
(function() {
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.async = true;
  s.src = '//static.getclicky.com/js';
  ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( s );
})();
</script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/100990350ns.gif" /></p></noscript>
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
			jQuery(document).ready(function() {
				$('body').on('contextmenu', 'img', function(e){ return false; });
				$('#caMediaPanelContentArea').on('contextmenu', 'img', function(e){ return false; });
				$('img:not([alt])').attr('alt', '');
			});
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
