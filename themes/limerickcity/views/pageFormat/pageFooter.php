		<div style="clear:both; height:1px;"><!-- empty --></div></div></div></div><!-- end pageArea -->
<div class="limfooter">
	<ul>
		<li class="first"><a href="http://limerick.ie/visiting/">Visiting</a></li>
		<li><a href="http://limerick.ie/business/">Business</a></li>
		<li><a href="http://limerick.ie/living/">Living</a></li>
		<li><a href="http://limerick.ie/learning/">Learning</a></li>
		<li><a href="http://limerick.ie/kids/">Kids</a></li>
		<li><a href="http://limerick.ie/homeitems/about/">About</a></li>
		<li><a href="http://limerick.ie/contact/">Contact</a></li>
		<li><a href="http://limerick.ie/homeitems/about/disclaimer/">Disclaimer</a></li>
		<li><a href="http://limerick.ie/homeitems/about/accessibility/">Accessibility</a></li>
		<li><a href="http://limerick.ie/homeitems/about/privacy/">Privacy</a></li>
	</ul>
	
	<address>Phone: 00353 (0)61 400010 &nbsp; <span>&#124;</span> &nbsp; Fax: 00353 (0)61 400355 &nbsp; <span>&#124;</span> &nbsp; Email: <a href="mailto:webservices@limerickcity.ie">webservices@limerickcity.ie</a></address>
	
	<p>&copy; 2009-2011 Limerick City Council</p>
	
</div>
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
				panelTransitionSpeed: 200, 									/* time it takes the panel to fade in/out in milliseconds */
				allowMobileSafariZooming: true,
				mobileSafariViewportTagID: '_msafari_viewport'
			});
		}
	});
	</script>
	</body>
</html>
