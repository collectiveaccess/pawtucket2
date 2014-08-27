<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
?>




		</div><!-- end pageContentArea --></div><!-- end pageContentAreaPadding -->
		<div style="clear:both; height:0px;"><!-- empty --></div></div><!-- end pageArea -->
		<div id="footer" style="position: relative;">			
			<div style="position: absolute; top: 5px; right: 5px;">
				<a href="http://www.nsf.gov/"><?php print caGetThemeGraphic($this->request, 'nsf.png'); ?></a>
			</div>
			<div id="footerLogo"><a href="http://www.colorado.edu/"><?php print caGetThemeGraphic($this->request, 'footerLogo.gif'); ?></a></div>
			<div id="footerText">
				For inquiries regarding visits to the collection or specimen loans,<br/>please contact the Vertebrate and Trace Paleontology Collections Manager,<br/>Toni Culver  at Toni.Culver@Colorado.edu.
			</div>
			<div id="footerText2">
				 Regents of the University of Colorado &copy; 2013<br/>
				 Built with: <a href="http://www.collectiveaccess.org">CollectiveAccess</a> &copy; 2013 
			</div>
		</div><!-- end footer -->
<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
<?php
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
				exposeBackgroundColor: '#FFFFFF',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
				exposeBackgroundOpacity: 0.7,							/* opacity of background color masking out page content; 1.0 is opaque */
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
