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

		<?php print TooltipManager::getLoadHTML(); ?>

	</body>
</html>
