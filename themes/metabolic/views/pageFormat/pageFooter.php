		<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end pageArea -->
<?php
		# --- depending on the current page, we might need an extra /div to close the border table around the pageArea div
		if(in_array($this->request->getController(), array("Object", "Entity", "Occurrence", "Collection", "Place", "Form", "Share"))){
			print "</div><!-- end detailPageAreaBorder -->";
		}
?>
		<div id="footer">
			Metabolic Studio <br/>
1745 N. Spring Street Unit 4 Los Angeles, CA 90012 <br/>
<a href="mailto:info@metabolicstudio.org">info@metabolicstudio.org</a> phone 323.226.1158  
		</div><!-- end footer -->
<?php
print TooltipManager::getLoadHTML();
?>
	<div id="caMediaPanel"> 
		<!--<div id="close"><a href="#" onclick="caMediaPanel.hidePanel(); return false;">&nbsp;&nbsp;&nbsp;</a></div>-->
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
	</div>
	</body>
</html>
