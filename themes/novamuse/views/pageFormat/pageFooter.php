	<div class="clear"></div>
</div><!--end container-->
<div class="clear"></div>
<div id='footer'>
	<div>
<?php
		if ($this->request->isLoggedIn()) {
			print "<div style='float:left;'>".caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout")."</div>";
		}
?>
		&copy; 2012 ANSM
	</div>
<?php
	if ($this->request->getController() == 'Splash') {
?>
		<div id="footerlogos"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/novamuse/sponsor_logos/ansmLogo.png"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/novamuse/sponsor_logos/pch.jpg"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/novamuse/sponsor_logos/CommCulHerit_Fulcol.jpg"></div>
<?php
	}
?>
</div><!-- end footer --><div class="clear"></div></div><!-- end pageArea -->
</body>
</html>
<?php
print TooltipManager::getLoadHTML();
?>
	<div id="caMediaPanel"> 
		<!--<div id="close"><a href="#" onclick="caMediaPanel.hidePanel(); return false;">&nbsp;&nbsp;&nbsp;</a></div>-->
		<div id="caMediaPanelContentArea">
		
		</div>
	</div>
	<script type="text/javascript">
	/* prevent dragging of image to desktop */
	jQuery(document).ready(function() {
		$("img").mousedown(function(){
			return false;
		});

		$('img').bind('contextmenu', function(e){
			return false;
		});
	});

	$(function(){  // $(document).ready shorthand
	  $('.notificationMessage').effect('fade', 'easeInSine', 5000);
	});

	
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
