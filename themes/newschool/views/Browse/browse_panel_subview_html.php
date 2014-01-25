<div id="caBrowsePanel"> 
	<div id="caBrowsePanelContentArea">
	
	</div>
</div>
<script type="text/javascript">
/*
	Set up the "caBrowsePanel" panel that will be triggered by links in object detail
	Note that the actual <div>'s implementing the panel are located here in views/pageFormat/pageFooter.php
*/
var caBrowsePanel;
jQuery(document).ready(function() {
	if (caUI.initPanel) {
		caBrowsePanel = caUI.initPanel({ 
			panelID: 'caBrowsePanel',										/* DOM ID of the <div> enclosing the panel */
			panelContentID: 'caBrowsePanelContentArea',		/* DOM ID of the content area <div> in the panel */
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