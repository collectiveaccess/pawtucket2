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
		<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-4">
						<a href="https://www.grpm.org/"><i class="fa fa-university" aria-hidden="true"></i> Museum Home</a>
						<br/><br/>
					</div>
					<div class="col-sm-12 col-md-4">
						<a href="https://www.grpm.org/" target="_blank">Grand Rapids Public Museum</a>
						<br/>272 Pearl Street NW
						<br/>Grand Rapids, MI 49504
						<br/>
						<br/>
					</div>
					<div class="col-sm-12 col-md-4">
						<?php print caNavLink($this->request, _t("About the Collection"), "", "", "About", "Collection"); ?>
						<br/><a href="https://www.grpm.org/contact/">Contact Us</a>
						<br/><?php print caNavLink($this->request, _t("FAQ"), "", "", "About", "FAQ"); ?>
						<br/><?php print caNavLink($this->request, _t("Terms of Use"), "", "", "About", "Terms"); ?>
						<br/>
						<br/>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<!--<ul class="list-inline pull-center social">
							<li><a href="https://www.facebook.com/GRMuseum/?fref=ts" title="Grand Rapids Public Museum Facebook" target="_blank"><span class="fa fa-facebook"></span></a></li>
							<li><a href="https://twitter.com/GRMuseum?lang=en" title="Grand Rapids Public Museum Twitter" target="_blank"><span class="fa fa-twitter"></span></i></a></li>
							<li><a href="https://www.instagram.com/grmuseum/" title="Grand Rapids Public Museum Instagram" target="_blank"><span class="fa fa-instagram"></span></a></li>
							<li><a href="https://www.pinterest.com/grpublicmuseum/" title="Grand Rapids Public Museum Pinterest" target="_blank"><span class="fa fa-pinterest"></span></a></li>
						</ul>-->
						<br/>
						<br/>&copy; Grand Rapids Public Museum <?php print date("Y"); ?>
					</div>
				</div>
			</div>
		</footer><!-- end footer -->

	
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
		<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-59458617-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-59458617-1');
</script>
	</body>
</html>
