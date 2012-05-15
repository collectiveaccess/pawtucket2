<?php
if (!$this->request->isAjax()) {
?>
		<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end pageArea -->
		<div id="footer"><div class="width">
			<a href="http://www.hsp.org">&copy 2012 Historial Society of Pennsylvania</a>|<a href="http://www.hsp.org/default.aspx?id=135">Licensing Information</a>|<?php print caNavLink($this->request, _t("Contact Us"), "", "", "About", "contact"); ?>
<?php
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print "|".caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
				}
			}
?>
		</div><!-- width --></div><!-- end footer -->
<?php
}
print TooltipManager::getLoadHTML();
?>
	<div id="caMediaPanel"> 
		<div id="close"><a href="#" onclick="caMediaPanel.hidePanel(); return false;">&nbsp;&nbsp;&nbsp;</a></div>
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
				exposeBackgroundOpacity: 0.5,							/* opacity of background color masking out page content; 1.0 is opaque */
				panelTransitionSpeed: 200, 									/* time it takes the panel to fade in/out in milliseconds */
				allowMobileSafariZooming: true,
				mobileSafariViewportTagID: '_msafari_viewport'
			});
		}
	});
	</script>	
   <script type="text/javascript"> 
 
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-8703180-1']);
    _gaq.push(['_setDomainName', '.hsp.org']);
    _gaq.push(['_trackPageview']);
 
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
 
   </script> 
</body>
</html>
