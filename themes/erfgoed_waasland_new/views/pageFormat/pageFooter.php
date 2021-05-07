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
		<footer id="footer" role="contentinfo">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-md-offset-2">
					<div class="footerHeading">&copy; Erfgoedbank Waasland</div>
					<div class="row">
						<div class="col-sm-4 footerContact">
							<b>Contacts</b><br/>
							Erfgoedcel Waasland<br/>
							Lamstraat 113<br/>
							9100 Sint-Niklaas<br/><br/>
							T - +32 (0)3 500 47 55<br/>
							E - <a href="mailto:erfgoedcel@interwaas.be">erfgoedcel@interwaas.be</a><br/>
							W - <a href="https://erfgoedcelwaasland.be" target="_blank">erfgoedcelwaasland.be</a>
						</div>
						<div class="col-sm-4">
							<ul class="list-inline social">
								<li><a href="https://www.facebook.com/erfgoedcelwaasland" target="_blank"><i class="fa fa-facebook-square" aria-label="Facebook"></i></a></li>
								<li><a href="https://www.instagram.com/erfgoedcel_waasland/" target="_blank"><i class="fa fa-instagram" aria-label="Instragram"></i></a></li>
							</ul>
							<div class="homeLogo"><a href="http://www.erfgoedcelwaasland.be" target="_blank"><?php print caGetThemeGraphic($this->request, 'erfgoedCelLogoTransparent.png'); ?></a></div>
						</div>
						<div class="col-sm-4">
							<div class="funder">
								<a href="http://www.vlaanderen.be"><?php print caGetThemeGraphic($this->request, 'Vlaanderen-verbeelding-werkt_vol.png'); ?></a>
							</div>
						</div>
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
						exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.5,							/* opacity of background color masking out page content; 1.0 is opaque */
						allowMobileSafariZooming: true,
						mobileSafariViewportTagID: '_msafari_viewport',
						closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
					});
				}
			});
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		
//			$(document).ready(function() {
//				$(document).bind("contextmenu",function(e){
//				   return false;
//				 });
//			}); 
			$(document).ready(function(){
				$(window).scroll(function(){
					$("#hpScrollBar").fadeOut();
				});
				
				$(function() {
					//caches a jQuery object containing the header element
					var html = $("html");
					
						$(window).scroll(function() {
							var scroll = $(window).scrollTop();

							if (scroll >= 125) {
								html.removeClass('initial');
							} else {
								html.addClass('initial');
							}
							
						});
					
				});
			});
		</script>
<?php
	if (Session::getVar('cookieAccepted') != 'accepted') {		
?>	
		<!--<div id="cookieNotice">
			{{{cookie_statement}}}
		</div>-->	<!--end homePanel-->
		
		
		<script type="text/javascript">
			$(document).ready(function() {
				$('.acceptCookie').click(function(e){
				  e.preventDefault();
				  $.ajax({
					   url: "<?php print caNavUrl($this->request, "", "Cookie", "accept"); ?>",
					   type: "GET",
					   success: function (data) {
						 if(data == 'success'){
						 	$('#cookieNotice').hide();
						 }
					   },
					   error: function(xhr, ajaxOptions, thrownError){
						  alert("There was an error, please try again later.");
					   }
				  });

				});
			});
		</script>

<?php
	}
?>
	</body>
</html>
