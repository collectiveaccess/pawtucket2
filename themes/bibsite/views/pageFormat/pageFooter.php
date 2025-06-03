<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2021 Whirl-i-Gig
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
		<footer id="footer" role="contentinfo">
			<ul class="list">
				<li><?php print caNavLink($this->request, _t("Rights and Use"), "", "", "rights", ""); ?></li>
				<li><?php print caNavLink($this->request, _t("FAQ"), "", "", "faq", ""); ?></li>
				<li><?php print caNavLink($this->request, _t("Contact"), "", "", "contactus", ""); ?></li>
			</ul>
			<ul class="list">
				<li><a href="#">Join our newsletter</a></li>
				<form action="https://bibsocamer.us7.list-manage.com/subscribe/post?u=4fdfbb1192f268e1267caefff&amp;id=e12ef109cc" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="newsletter validate" target="_blank" novalidate role="newsletter">
					<input type="email" value="" name="EMAIL" placeholder="Email address" class="required email form-control" id="mce-EMAIL" autocomplete="off">
					<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_4fdfbb1192f268e1267caefff_e12ef109cc" tabindex="-1" value=""></div>
				    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn-search">
				    <div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div> 
				</form>
			</ul>
			<div class="small">
				<p>Copyright © 2022 The Bibliographical Society of America. All rights reserved. Powered by <a href="http://www.collectiveaccess.org">CollectiveAccess</a>.</p>
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
						onCloseCallback: function(data) {
							if(data && data.url) {
								window.location = data.url;
							}
						},
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
<?php
	print $this->render("Cookies/banner_html.php");	
?>
		
		<script>
			$(document).ready( function() {
				$('.jscroll-inner').imagesLoaded( function() {
				  	$('.jscroll-inner').masonry({
					  	itemSelector: '.bResultItemCol',
					});
				});
				var placeholderPreceder = "Try searching for ...";
				var placeholder = [" frisket sheets"," auction catalogs"," papermaking"," chapbooks"];
				var i = 0;
				var speed = 80;
				var wordCount = 0;
				var txt = placeholder[wordCount];
				var pause = '                         ';
				txt = txt + pause;

				typeWriter();

				function typeWriter() {
					
				  if (i <= txt.length * 2) {
				    if (i <= txt.length) {
				    	$('.home-search input').attr('placeholder', placeholderPreceder += txt.charAt(i));
				    }
				    if ( i > txt.length) {
				    	var slice = i - txt.length;
				    	$('.home-search input').attr('placeholder', placeholderPreceder.slice(0,-slice));
				    }
				    i++;
				    if (i == txt.length * 2 + 1) {
				    	wordCount++;
				    	if (wordCount == placeholder.length) { 
				    		wordCount = 0; 
				    	}
				    	txt = placeholder[wordCount] + pause;
				    	i = 0;
				    	placeholderPreceder = "Try searching for ...";
				    }
				    setTimeout(typeWriter, speed);
				  }

				}

				
				
			}); 
				
		</script>
	</body>
</html>
