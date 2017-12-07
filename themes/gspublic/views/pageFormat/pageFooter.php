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
						print "<li>".caGetThemeGraphic($this->request, 'facebook.png')."</li>";
						print "<li>".caGetThemeGraphic($this->request, 'twitter.png')."</li>";
						print "<li>".caGetThemeGraphic($this->request, 'youtube.png')."</li>";
						print "<li>".caGetThemeGraphic($this->request, 'pinterest.png')."</li>";
						print "<li>".caGetThemeGraphic($this->request, 'in.png')."</li>";
						print "<li>".caGetThemeGraphic($this->request, 'camera.png')."</li>";
?>		
						</ul>		
					</div>
					<div class="col-sm-6">
						<span class='keep'>Keep in Touch</span><input type="email" placeholder="Email address"><span class='go'>GO</span>
					</div>				
				</div>
			</div>
		</div>
		<div id="footerGreen">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
<?php
	/*					if($this->request->isLoggedIn()){
							print "<div class='footerRight'><div>".trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email")."</div>";
							print "<ul class='list-inline'>";
							print "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
							print "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";	
							print "</ul></div>";
						} */
?>			
					</div><!-- end col -->
				</div><!-- end row -->
				<div class="row">
					<div class="col-sm-3">
						<div>Contact Us</div>
						<div>Visit Us</div>
						<div>Careers</div>
						<div>Blog</div>
					</div>
					<div class="col-sm-3">
						<div>Press Room</div>
						<div>FAQ</div>
						<div>Partners</div>
						<div>Help</div>
					</div>
					<div class="col-sm-3">
						<div>Disclosure Statement</div>
						<div>Privacy Policy</div>
						<div>Terms</div>
					</div>							
				</div><!-- end row -->
				<div class="row">
					<div class="col-sm-12 smallText">
						&copy; 2016 Girl Scouts of the United States of America. A 501(c)(3) Organization. All Rights Reserved.	
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
