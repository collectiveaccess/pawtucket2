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

</div><!-- end content-inner -->
</div><!-- end content-wrapper -->
</div><!-- end wrapper -->
</div><!-- end page -->

<footer>   
	<div class="footer-top">
		<div class="site-main clearfix">
			<a rel="nofollow" class="eversonlogo" href="http://everson.org/"><?php print caGetThemeGraphic($this->request, 'footer-logo.png'); ?></a>
			<div class="foot-social">    
				<div id="ccm-block-social-links1616" class="ccm-block-social-links">
					<ul class="list-inline">
						<li><a target="_blank" href="https://www.facebook.com/eversonmuseumofart"><i class="fa fa-facebook"></i></a></li>
						<li><a target="_blank" href="https://twitter.com/EversonMuseum"><i class="fa fa-twitter"></i></a></li>
						<li><a target="_blank" href="https://www.instagram.com/eversonmuseum"><i class="fa fa-instagram"></i></a></li>
					</ul>
				</div>
            </div>
        	<div class="foot-hours">
    			<p>Everson Museum of Art Hours:</p>
				<table>
				<tbody>
				<tr>
					<td>Sunday 12-5<br><span>Monday Closed</span><br><span>Tuesday Closed</span><br>
					</td>
					<td>Wednesday 12-5<br>Thursday 12-8<br>Friday 12-5<br>Saturday 10-5<br>
					</td>
				</tr>
				</tbody>
				</table>
            </div>
            <div class="foot-search">
    			<form action="http://everson.org/search-results" method="get" class="ccm-search-block-form"><input name="search_paths[]" type="hidden" value=""><input name="query" type="text" value="" class="ccm-search-block-text"> <input name="submit" type="submit" value="Search" class="btn btn-default ccm-search-block-submit"></form>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="site-main clearfix">
            <a rel="nofollow" class="eversonlogo" href="http://everson.org/"><?php print caGetThemeGraphic($this->request, 'footer-logo.png'); ?></a>
            <div class="right-col">
                <div class="foot-social">   
					<div id="ccm-block-social-links1616" class="ccm-block-social-links">
						<ul class="list-inline">
							<li><a target="_blank" href="https://www.facebook.com/eversonmuseumofart"><i class="fa fa-facebook"></i></a></li>
							<li><a target="_blank" href="https://twitter.com/EversonMuseum"><i class="fa fa-twitter"></i></a></li>
							<li><a target="_blank" href="https://www.instagram.com/eversonmuseum"><i class="fa fa-instagram"></i></a></li>
						</ul>
					</div>
                </div>
                <span class="foot-tel">  315.474.6064 </span>
				<a rel="nofollow" class="foot-donate" href="#"> DONATE</a>
				<div class="foot-nav">
					<ul class="links clearfix">
						<li><a href="http://everson.org/search-results">SEARCH</a></li>
						<li><a href="https://21573a.blackbaudhosting.com/21573a/Total-Contributions-Gen-OpUNRES">Donate<br></a></li>
						<li> <a href="https://21573a.blackbaudhosting.com/21573a/page.aspx?pid=201" target="_blank">SUBSCRIBE</a></li>
						<li> <a href="http://everson.org/about/employment">Volunteer</a> </li>
						<li> <a href="http://everson.org/support">Supporters</a> </li>
					</ul>
				</div>                    
				<address>
					<ul class="copy-right clearfix">
						<li> <span>Everson Museum     </span> </li>
						<li> <span> <span></span></span> </li>
						<li><span>&nbsp;401 Harrison Street, Syracuse, NY 13202 | </span></li>
						<li> <span> ©2016 EVERSON MUSEUM OF ART, ALL RIGHTS RESERVED | (315) 474 6064</span></li>
					</ul>
				</address>
			</div>
		</div>
	</div>
</footer>
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
	</body>
</html>
