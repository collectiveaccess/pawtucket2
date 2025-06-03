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
<footer class="footer">
      <div class="footer--container grid">
        <div>
          <address class="address">28 West 27th St, 3rd Fl
New York, NY 10001
<a href="tel:212-481-0295">212-481-0295</a>          </address>
          <span class="hours">Mon-Sat 11am-4pm
CLOSED Sun          </span>
        </div>
        <div class="blurb">
          <p>Supporting Artists Making Books for Over 45 years!</p>
        </div>
        <nav id="footer-nav" class="footer-nav nav" role="navigation">
			<ul class="footer-menu">
				<li id="menu-item-67748" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-67748"><a href="https://centerforbookarts.org/about">About</a></li>
				<li id="menu-item-41" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-41"><a href="https://centerforbookarts.org/resources">Resources</a></li>
				<li id="menu-item-40" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-40"><a href="https://centerforbookarts.org/support">Support</a></li>
				<li id="menu-item-42" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-42"><a href="https://centerforbookarts.org/book-shop">Book Shop</a></li>
				<li id="menu-item-67749" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-67749"><a href="https://centerforbookarts.org/opportunities">Opportunities</a></li>
			</ul>
		</nav><!-- #footer-nav -->
        <div class="footer-social">
			<div class="social-links">
				<a href="https://www.instagram.com/centerforbookarts/"><span>Instagram</span></a>
				<a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/center4bookarts/"><span>Facebook</span></a>
				<a target="_blank" rel="noopener noreferrer" href="https://twitter.com/center4bookarts"><span>Twitter</span></a>
				<a target="_blank" rel="noopener noreferrer" href="https://www.flickr.com/photos/centerforbookarts/"><span>Flickr</span></a>
				<a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/channel/UCMAt94lZJDyeDQCJ_YQ6kxg/?guided_help_flow=5&amp;disable_polymer=true"><span>YouTube</span></a>
			 </div>
        </div>
      </div>
        <div class="footer--container">
          <span class="copyright">© 2021 <a href="https://centerforbookarts.org/" rel="home">Center for Book Arts</a>, Incorporated 1974 • A 501(c)(3) not-for-profit organization</span>
        </div>
      </footer>

	
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
