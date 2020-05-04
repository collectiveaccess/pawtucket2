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
	<div id="stickyFooter" >
		<div id="socialFooter">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<ul>
<?php
						print "<li><a href='https://www.facebook.com/GirlScoutsUSA' target='_blank'>".caGetThemeGraphic($this->request, 'facebook.png')."</a></li>";
						print "<li><a href='https://twitter.com/girlscouts' target='_blank'>".caGetThemeGraphic($this->request, 'twitter.png')."</a></li>";
						print "<li><a href='https://www.youtube.com/user/girlscoutvideos' target='_blank'>".caGetThemeGraphic($this->request, 'youtube.png')."</a></li>";
						print "<li><a href='https://www.pinterest.com/gsusa/' target='_blank'>".caGetThemeGraphic($this->request, 'pinterest.png')."</a></li>";
						print "<li><a href='https://www.linkedin.com/company/girl-scouts-of-the-usa/' target='_blank'>".caGetThemeGraphic($this->request, 'in.png')."</a></li>";
						print "<li><a href='https://www.instagram.com/girlscouts/' target='_blank'>".caGetThemeGraphic($this->request, 'camera.png')."</a></li>";
?>		
						</ul>		
					</div>
					<div class="col-sm-6">
						<!--<span class='keep'>Keep in Touch</span><input type="email" placeholder="Email address"><span class='go'>GO</span>-->
					</div>				
				</div>
			</div>
		</div>
		<div id="footerGreen">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div><a href="http://www.girlscouts.org/en/contact-us/contact-us.html" target="_blank">Contact Us</a></div>
						<div><a href="http://www.girlscouts.org/en/visit-us/visit-us.html" target="_blank">Visit Us</a></div>
						<div><a href="http://www.girlscouts.org/en/careers/careers.html" target="_blank">Careers</a></div>
						<div><a href="http://blog.girlscouts.org/" target="_blank">Blog</a></div>
					</div>
					<div class="col-sm-3">
						<div><a href="http://www.girlscouts.org/en/press-room/press-room.html" target="_blank">Press Room</a></div>
						<div><a href="http://www.girlscouts.org/en/faq/faq.html" target="_blank">FAQ</a></div>
						<div><a href="http://www.girlscouts.org/en/about-girl-scouts/our-partners.html" target="_blank">Partners</a></div>
						<div><a href="http://www.girlscouts.org/en/help/help.html" target="_blank">Help</a></div>
					</div>
					<div class="col-sm-3">
						<div><a href="http://www.girlscouts.org/en/help/help/disclosure-statement.html" target="_blank">Disclosure Statement</a></div>
						<div><a href="http://www.girlscouts.org/en/help/help/privacy-policy.html" target="_blank">Privacy Policy</a></div>
						<div><a href="http://www.girlscouts.org/en/help/help/terms-and-conditions.html" target="_blank">Terms</a></div>
					</div>							
				</div><!-- end row -->
				<div class="row">
					<div class="col-sm-12 smallText">
						&copy; <?php print date("Y"); ?> Girl Scouts of the United States of America. A 501(c)(3) Organization. All Rights Reserved.	
					</div>
				</div>
			</div><!-- end container -->
		</div><!-- end footerGreen -->
	</div><!-- end sticky footer -->
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
		<script type="text/javascript">
			$(window).scroll(function(){ 
				var scrollLimit = 100;
				var pos = $(window).scrollTop();
				if(pos > scrollLimit) {
					$("body").removeClass("initial");
					$(".navbar-brand").removeClass("initialLogo");
					$(".headerText").hide();
				}else {
					if(!$("body").hasClass("initial")){
						$("body").addClass("initial");
					}
					if(!$(".navbar-brand").hasClass("initialLogo")){
						$(".navbar-brand").addClass("initialLogo");
						$(".headerText").show();
					}
				}
			});
		</script>		
	</body>
</html>
