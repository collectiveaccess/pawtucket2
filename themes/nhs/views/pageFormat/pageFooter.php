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
		<div style="clear:both;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
	<footer id="footer">
		<div>
			<a href="http://newporthistory.org"><?php print caGetThemeGraphic($this->request, 'Stacked_NHS_Tag_White.png'); ?></a>
			<ul class="list-inline pull-right social">
				<li><a href="https://www.facebook.com/NewportHistory" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
				<li><a href="https://twitter.com/newporthistory" target="_blank"><i class="fab fa-twitter"></i></a></li>
				<li><a href="http://instagram.com/newporthistory/" target="_blank"><i class="fab fa-instagram"></i></a></li>
				<li><a href="https://www.youtube.com/user/NewportHistory" target="_blank"><i class="fab fa-youtube"></i></a></li>
			</ul>
			<div class="address">
				Newport Historical Society
				<br/>82 Touro Street
				<br/>Newport RI 02840
				<br/>401.846.0813
			</div>
			<div style="clear:both;"><!-- empty --></div>
		</div>
	</footer><!-- end footer -->
	
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
				var scrollLimit = 200;
				var pos = $(window).scrollTop();
				if(($(window).width() > 970) && (pos > scrollLimit)) {
					$("body").removeClass("initial");
				}else {
					if(!$("body").hasClass("initial")){
						$("body").addClass("initial");
					}
				}
			});
		</script>
		<script type="text/javascript" language="javascript">
			$(document).ready(function() {
				$('#caMediaPanel').on('contextmenu', 'canvas', function(e){ return false; });
			});
		</script>
	</body>
</html>
