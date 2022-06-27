<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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

  </div></div></div> <!-- /.block-content -->
</div> <!-- /.contentblock.pagination-block -->

</div> <!-- /#components-bottom -->
</div>  <!-- /.primary-content -->

</div> <!-- /.row --></div></main>
		
<footer class="footer bg-branding bg-branding">
        <div class="container text-xs-center">
            <nav class="navbar-dark">
            <ul class="nav navbar-nav nav-centered">
             <li class="nav-item"><a class="nav-link" href="http://passagemuseums.blogspot.ca" title="Museums Nova Scotia Blog">Museums Nova Scotia Blog</a></li>
             <li class="nav-item"><a class="nav-link" href="https://www.facebook.com/AssociationNSMuseums" title="Facebook">Facebook</a></li>
             <li class="nav-item"><a class="nav-link" href="https://www.youtube.com/user/museumcommunity/" title="YouTube">YouTube</a></li>
             <li class="nav-item"><a class="nav-link" href="http://www.novamuse.ca" title="NovaMuse">NovaMuse</a></li>
             <li class="nav-item"><a class="nav-link" href="https://www.facebook.com/NovaMuse" title="NovaMuse Facebook">NovaMuse Facebook</a></li>
             <li class="nav-item"><a class="nav-link" href="https://twitter.com/novamuse_ca" title="NovaMuse Twitter">NovaMuse Twitter</a></li>
             <li class="nav-item"><a class="nav-link" href="https://www.pinterest.com/novamuse/" title="NovaMuse Pinterest">NovaMuse Pinterest</a></li>
             <li class="nav-item"><a class="nav-link" href="sitemap.html" title="Sitemap">Sitemap</a></li>
            </ul>
            <p class="copyright"><small>©&nbsp;2019&nbsp;Association of Nova Scotia Museums (ANSM)</small><br><small>ANSM is located on the traditional and unceded territory of the Mi'kmaq people.<br />
            We extend our appreciation for the opportunity to live and learn on this territory in mutual respect and gratitude.</small></p>
            </nav>
            </div>
        </footer>
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
