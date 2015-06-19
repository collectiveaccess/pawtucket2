	
	

		
			<div style="clear:both;"></div>

		</div><!-- end pageArea -->
	</div> <!--end shadow container-->
			<!--<ul class="list-inline pull-right social">
				<li><i class="fa fa-twitter"></i></li>
				<li><i class="fa fa-facebook-square"></i></li>
				<li><i class="fa fa-youtube-play"></i></li>
			</ul>-->
			<!--<div class="row">-->
	<div class="container footercontainer">
		<div class="row">
			<div class="col-sm-4">
				<a href="#" style="float:left;"><?php print caGetThemeGraphic($this->request, 'chhefooter.png') ?></a>
				<a href="#" style="float:left;"><?php print caGetThemeGraphic($this->request, 'cjffooter.png') ?></a>
			</div>
		
			<div class="col-sm-8 text-right">
				Cincinnati Judaica Fund| 8401 Montgomery Road | Cincinnati, OH 45236 | 513-241-5748<br />
				Center for Holocaust and Humanity Education | 8401 Montgomery Road | Cincinnati, OH 45236 | 513-487-3055
			</div>
		</div>
		<div><small>powered by <a href="http://www.collectiveaccess.org">CollectiveAccess 2014</a></small></div>
	</div><!--end footer container-->	
	

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
	
			(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);
		</script>
	</body>
</html>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52271760-1', 'cincinnatijudaicafund.com');
  ga('send', 'pageview');

</script>