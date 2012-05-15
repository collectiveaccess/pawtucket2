		<div style="clear:both; height:0px;"><!-- empty --></div></div><!-- end pageArea -->
		<div id="footer">
			<div id="footerLogo"><a href="http://www.colorado.edu/"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/footerLogo.gif' width='170' height='60' border='0'></a></div>
		<div id="footerText">
				UNIVERSITY OF COLORADO MUSEUM OF NATURAL HISTORY <br/>
				Henderson Building, 15th and Broadway, Boulder, CO 80309 <br/>
				tel: 303.492.6892 fax: 303.492.4195<br/>
				For questions or comments, please email:<a href="mailto:cumuseum@colorado.edu">cumuseum@colorado.edu</a>
			</div>
			<div id="footerText2">
				 <br>
				 Regents of the University of Colorado &copy; 2012  <br>
				 Built with:<a href="http://www.collectiveaccess.org">CollectiveAccess</a> &copy; 2012 
			</div>
			</div>
		
		<div class="clearfix"></div><!-- end footer -->
<?php
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
