<?php
if (!$this->request->isAjax()) {
?>
		</div><!-- end contentArea --><div style="clear:both;"><!-- empty --></div></div><!-- end pageAreaPadding -->
		<div id="footer">
<?php
			print caNavLink($this->request, "Info", "", "", "About", "index", array(), array("style" => "float:left; width:200px; text-align:left;"));
			print caNavLink($this->request, "Impressum", "", "", "About", "impressum", array(), array("style" => "float:right; width:200px; text-align:right;"));
			print caNavLink($this->request, "Hilfe", "", "", "About", "hilfe");
?>
		</div><!-- end footer -->
	</div><!-- end pageArea -->
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
	</body>
</html>
