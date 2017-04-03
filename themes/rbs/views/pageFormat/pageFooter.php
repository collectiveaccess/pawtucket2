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

<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
	</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
	
			</div><!-- end content-inner -->
		</div><!-- end content-wrapper -->
	</div><!-- end wrapper -->	
</div><!-- end page -->
<div id="footer">
	<div class="row" style="padding-left:20px;">
		<div class="footer-col mcol two flush-left" style="height: 168px;">
        	<p><strong>Rare Book School</strong>
            114 Alderman Library<br>
			University of Virginia<br>
			P.O. Box 400103 <br>
			Charlottesville, VA 22904</p>
        </div>
		<div class="footer-col mcol three" style="height: 168px;">
			<p><strong>CONTACT</strong>
			Phone: 434-924-8851<br>
			Fax: 434-924-8824<br>
			Email: <a href="mailto:oldbooks@virginia.edu">oldbooks@virginia.edu</a><br>
			<a href="http://rarebookschool.org/about-rbs/staff/">Staff Directory</a>
			</p>
		</div> 
		<div class="footer-col mcol two" style="height: 168px;">
			<strong>CONNECT WITH RBS</strong>
			<ul class="social-links">
				<li><a target="_blank" href="https://www.facebook.com/rarebookschool"><div class="fa fa-facebook"></div></a></li>
				<li><a target="_blank" href="https://twitter.com/rarebookschool"><div class="fa fa-twitter"></div></a></li>
				<li><a target="_blank" href="https://www.youtube.com/user/rarebookschool"><div class="fa fa-youtube"></div></a></li>
				<li class="join"><a target="_blank" href="http://rarebookschool.us2.list-manage.com/subscribe?u=c3921162713adaa3f481a4987&amp;id=3b19c4e1ef">Join Our Email List</a></li>
			</ul>
			<a target="_blank" href="http://rbsconnect.org/"><img src="http://rarebookschool.org/wp-content/themes/RBS/images/rbs-connect.png" alt="" width="113"></a><br>
			<a target="_blank" href="https://rbs.sites.virginia.edu"><img src="http://rarebookschool.org/wp-content/themes/RBS/images/myRBS.png" alt="" width="80"></a>
		</div>
		<div class="footer-col mcol five flush-right" style="height: 168px;"> </div>
		<p id="copyright">Copyright ©2017</p>				       
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
