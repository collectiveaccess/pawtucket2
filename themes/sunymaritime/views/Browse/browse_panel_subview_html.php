<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_panel_subview_html.php : 
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