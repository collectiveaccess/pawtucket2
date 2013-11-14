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
				<div class='socialIcon'><a href='http://www.facebook.com/MattressFactory'><img src='<?php print $this->request->getThemeUrlPath();?>/assets/pawtucket/graphics/facebook.png' border='0'></a></div>
				<div class='socialIcon'><a href='http://twitter.com/MattressFactory'><img src='<?php print $this->request->getThemeUrlPath();?>/assets/pawtucket/graphics/twitter.png' border='0'></a></div>
				<div class='socialIcon'><a href='http://www.flickr.com/photos/mattressfactory/'><img src='<?php print $this->request->getThemeUrlPath();?>/assets/pawtucket/graphics/flickr.png' border='0'></a></div>
				<div class='socialIcon'><a href='http://www.youtube.com/user/MattressFactory'><img src='<?php print $this->request->getThemeUrlPath();?>/assets/pawtucket/graphics/youtube.png' border='0'></a></div>
				<div class='socialIcon'><a href='http://instagram.com/mattressfactory'><img src='<?php print $this->request->getThemeUrlPath();?>/assets/pawtucket/graphics/instagram.png' border='0'></a></div>
			</div>
		
		</div><!-- end footer -->
<?php
	if($this->request->isLoggedIn()){
		print $this->request->user->get("lname");
		print " - ".caNavLink($this->request, _t('Lightbox'), '', '', 'Sets', 'Index', array());
		print " - ".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array());
		print "<br/><br/>";
	}else{	
		print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a>";
		print " - <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a>";
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
					exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
					exposeBackgroundOpacity: 0.8,							/* opacity of background color masking out page content; 1.0 is opaque */
					panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
					allowMobileSafariZooming: true,
					mobileSafariViewportTagID: '_msafari_viewport',
					closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
				});
			}
		});
		</script>
	</body>
</html>
