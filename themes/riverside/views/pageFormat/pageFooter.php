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
		</div><!-- end pageArea --></div></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<footer id="footer" role="contentinfo">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 logoCol">
						<a href="https://www.trcnyc.org" target="_blank"><?php print caGetThemeGraphic($this->request, 'trc-footer-logo.svg', array("class" => "logo", "alt" => "The Riverside Church Logo and Title")); ?></a>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-3 col-lg-5 text-left addressCol">
						<p>490 Riverside Drive
						<br/>New York, NY
						<br/>10027</p>

						<p><a href="mailto:welcome@trcnyc.org">welcome@trcnyc.org</a></p>
						<p>(212) 870-6700</p>

						
					</div>
					<div class="col-sm-12 col-md-9 col-lg-7">
						<div class="learnLinks">
							<h2>Learn</h2>
							<a href="https://www.trcnyc.org/worshipschedule/">Worship With Us</a><br/>
							<a href="https://www.trcnyc.org/online/#online-ministries">Our Ministries</a><br/>
							<a href="https://www.trcnyc.org/about/">Our Story</a><br/>
							<a href="https://www.trcnyc.org/news/">News</a><br/>
						</div>
						<div class="daySchool">
							<a class="affiliate-logo" href="https://www.wdsnyc.org/"><?php print caGetThemeGraphic($this->request, 'weekdaySchool.png', array("class" => "weekdaySchool", "alt" => "Weekday School")); ?></a>
							<a class="affiliate-logo" href="https://riversidehawks.org/"><?php print caGetThemeGraphic($this->request, 'riverside-hawks.png', array("class" => "riverside-hawks", "alt" => "Riverside Hawks")); ?></a>
							
							<div class="social-con">
								Follow riverside online:
							
									<a class="social-icon first" href="https://www.facebook.com/RiversideNY/" target="_blank"><i class="fa fa-facebook"></i></a>
									<a class="social-icon" href="https://twitter.com/RiversideNYC" target="_blank"><i class="fa fa-twitter"></i></a>
									<a class="social-icon" href="https://www.instagram.com/riversidenyc" target="_blank"><i class="fa fa-instagram"></i></a>
									<a class="social-icon" href="https://youtube.com/TheRiversideChurch" target="_blank"><i class="fa fa-youtube-play"></i></a>
							
							</div>
						
						</div>
				</div>
			</div>
		</footer><!-- end footer -->

	
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
			$(document).ready(function(){
				$(window).scroll(function(){
					$("#hpScrollBar").fadeOut();
				});
			});
		</script>
	</body>
</html>
