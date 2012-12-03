		<div style="clear:both;"></div></div><!--end main content-->
<?php
# --- tooltip for vaga images - changes to this should also be made in ajaxfooter
TooltipManager::add(
	".vagaDisclaimer", "<div style='width:250px;'>Reproduction of this image, including downloading, is prohibited without written authorization from VAGA, 350 Fifth Avenue, Suite 2820, New York, NY 10118. Tel: 212-736-6666; Fax: 212-736-6767; e-mail:info@vagarights.com; web: <a href='www.vagarights.com' target='_blank'>www.vagarights.com</a></div>"
);
print TooltipManager::getLoadHTML();
?>
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
				exposeBackgroundOpacity: 0.5,							/* opacity of background color masking out page content; 1.0 is opaque */
				panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
				allowMobileSafariZooming: true,
				mobileSafariViewportTagID: '_msafari_viewport',
				closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
			});
		}
	});
	$(function(){  // $(document).ready shorthand
	  $('.notificationMessage').effect('fade', 'easeInSine', 5000);
	});
	</script>
	</body>
</html>
