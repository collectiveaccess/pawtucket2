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
			<div class="containerWrapper">
				<div class='row'><div class='col-sm-12'>
					<div><h2>Minnesota Alliance of Local History Museums: Peers Helping Peers Since 1991</h2></div>
				</div></div>
				<div class='row' style='margin-left:-25px;margin-right:-25px;'>
					<div class='col-xs-6 col-sm-4 logo'>
						<?php print caGetThemeGraphic($this->request, 'malhm.jpg'); ?>
					</div>
					<div class='col-xs-6 col-sm-4'>
						<div class="paragraph" style="text-align:left;">
							General contact:<br>
							Dustin Heckman, Alliance Coordinator<br>
							612-500-7460<br>
							<a href="mailto:mnhistoryalliance@gmail.com">Contact</a><br><br>
							Financial office:<br>
							Jill Wohnoutka, Treasurer<br>
							Kandiyohi County Historical Society<br>
							610 NE Hwy 71<br>
							Willmar, MN 56201<br>
							320-235-1881
						</div>					
					</div>
					<div class='col-xs-12 col-sm-4'> 
						<div class='pull-right social'>
							<span class='socialFooter'><a href='https://www.facebook.com/MNHistoryAlliance/' target='_blank'><i class='fa fa-facebook'></i></a></span>
							<span class='socialFooter'><a href='https://twitter.com/MNlocalhistory' target='_blank'><i class='fa fa-twitter'></i></a></span>
							<span class='socialFooter'><a href='https://www.linkedin.com/company/28123620/' target='_blank'><i class='fa fa-linkedin'></i></a></span>
							<span class='socialFooter'><a href='mailTo:mnhistoryalliance@gmail.com' target='_blank'><i class='fa fa-envelope-o'></i></a></span>
							<span class='socialFooter'><a href='https://www.instagram.com/mnhistoryalliance/' target='_blank'><i class='fa fa-instagram'></i></a></span>
							<div class='copy'>© COPYRIGHT 2018. ALL RIGHTS RESERVED.</div>
							<div class='clean'>
								<?php print caGetThemeGraphic($this->request, 'clean.jpg'); ?>
							</div>
							<div><small>powered by <a href="http://www.collectiveaccess.org">CollectiveAccess 2016</a></small></div>
						</div>
					</div>
				</div>
				
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
	</body>
</html>
