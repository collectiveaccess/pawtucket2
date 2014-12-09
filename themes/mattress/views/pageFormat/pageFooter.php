<script type="text/javascript">
(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);
</script>
		<div style="clear:both; height:1px;"><!-- empty --></div>
		<div id="footer">
		<?php # print $this->request->session->elapsedTime(4).'s'.caGetMemoryUsage(); ?>
			<div class='footerMenu'>
				<div class='footerLink'><a href='#' style='padding-left:0px;'>JOIN</a></div>
				<div class='footerLink'><a href='#'>CALENDAR</a></div>
				<div class='footerLink'><a href='#'>PRESS</a></div>
				<div class='footerLink'><a href='#'>RENTALS</a></div>
				<div class='footerLink'><a href='#'>CONTACT</a></div>
				<div class='footerLink'><a href='#'>SHOP</a></div>
				<div class='footerLink'><a href='#'>SIGN UP</a></div>
			</div>
			<div class='footerSocial'>
				<div class='socialIcon'><a href='http://www.facebook.com/MattressFactory'><?php print caGetThemeGraphic($this->request, 'facebook.png'); ?></a></div>
				<div class='socialIcon'><a href='http://twitter.com/MattressFactory'><?php print caGetThemeGraphic($this->request, 'twitter.png'); ?></a></div>
				<div class='socialIcon'><a href='http://www.flickr.com/photos/mattressfactory/'><?php print caGetThemeGraphic($this->request, 'flickr.png'); ?></a></div>
				<div class='socialIcon'><a href='http://www.youtube.com/user/MattressFactory'><?php print caGetThemeGraphic($this->request, 'youtube.png'); ?></a></div>
				<div class='socialIcon'><a href='http://instagram.com/mattressfactory'><?php print caGetThemeGraphic($this->request, 'instagram.png'); ?></a></div>
			</div>
		
		</div><!-- end footer -->

		<?php print TooltipManager::getLoadHTML(); ?>
		<div id="caMediaPanel"> 
			<div id="caMediaPanelContentArea">
			
			</div>
		</div>
		<div id="welcomeMessage">
			Welcome to P[art]icipate: An Active Archive! Don't know where to start? Visit the <?php print caNavLink($this->request, "About", "", "", "", "");?> section to learn how to browse.
			<div class='ok'> <a href='#' onclick='$("#welcomeMessage").fadeOut(200); return false;'>OK</a></div>
		</div>
		<script>
			jQuery(document).ready(function(){
				$(".scrollingDiv").each(function( index ) {
					$(this).width($(this).find(".scrollingDivContent").width());
				});
				
				jQuery('.scrollBlock').jScrollPane({autoReinitialise: false});
			});
		</script>
<?php
	if ($this->request->session->getVar('visited') != 'has_visited') {		
?>				
		<script>
			$(document).ready(function(){
				$('#welcomeMessage').fadeIn(1000);
			});
		</script>
<?php
	}
?>		
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
	
			(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);
		</script>
<?php
	
		#first visit sets the session
		$this->request->session->setVar('visited', 'has_visited');
?>
	</body>
</html>
