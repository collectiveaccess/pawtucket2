<?php
if (!$this->request->isAjax()) {
?>
		<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end pageArea -->
<?php
	if($this->request->getController() == "Splash"){
?>
		<div id="footer">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="25%" align="center"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/NYSCA-logo.jpg" width="60" height="75" align="top" /></td>
			<td width="25%" align="center"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/NEA_logo_color.gif" alt="" width="100" height="57" border="0" /></td>
			<td width="25%" align="center"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/IMLS_Logo_2c.preview.jpg" alt="" width="132" height="60" /></td>
			<td width="25%" align="center"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/NYCulture_logo.jpg" width="100" height="46" /></td>
		  </tr>
		</table>
		</div><!-- end footer -->
<?php
	}
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
	</body>
</html>