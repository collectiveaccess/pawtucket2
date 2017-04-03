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
		<div style="clear:both; height:1px;"><!-- empty --></div>
		<div id="footer">
        
            <div class="pull-left" style="color:#000">
				<strong>INTERFACE GUIDANCE</strong>
			</div>
            
			<div class="pull-right">
				<?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?>
				<!--<a href="#">Help</a>-->
			</div>
            
<br />
            
			<div style="line-height:1.25; color:#666">
				<table border="0" cellpadding="3">
                
                  <tr class="front-text">
                    <td valign="top"><strong>Travelers</strong>: This page displays the Traveler's biographical information and their collective network of associations. Selecting a Traveler from the "Index" will bring up the corresponding life role and notable achievements of the Traveler in the green box to the right of your screen. In the main window, the Traveler's social relationships are visualized as a nodal network. The name of the selected Traveler is highlighted in red, while his or her associations are in black. The more associations a Traveler has, the more connections appear. The nodes of these people can be selected, and doing so will bring up the corresponding information and social network of the new Traveler.
                </td>
                
                    <td valign="top"><strong>Routes</strong>: The "Routes" map interface visualizes the Travelers' movements. You may select one or multiple Travelers from the "Index." The traveler's individual journey is displayed in a series of geographically specific "stops." Clicking on an individual stop will display further information about the Traveler's stop in a floating window. Clicking the 'x' will close the information box. Beneath the map, a sliding bar allows you to select a date range for the displayed stops. If you click on the name of the Traveler (in light blue, indicating a hyperlink), you will be directed to the Social Network page of that Traveler. </td>
                    
                    <td valign="top"><strong>Chronology</strong>: The Chronology page displays a Traveler's Route in a timeline format. If a Traveler has already been selected in the "Routes" page, they will appear automatically on the Chronology page. If no traveler is selected, then you may select a Traveler from the "Index." Just like on the "Routes" page, you may select multiple Travelers. In chronological order, small windows represent each of the Traveler's Stops. If you place you mouse over the box, the information for that Stop appears in a fly away window. Below each Traveler's Route, a sliding bar will allow you to move along the chronological timeline. 
                </td>
                  </tr>
                </table>

			</div>            
			
			<div><small>&copy; 2015 <a href="http://www.haa.pitt.edu/collections/visual-media-workshop">Visual Media Workshop</a>, University of Pittsburgh</small></div>
		</div><!-- end footer -->
<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
	</div><!-- end pageArea --></div><!-- end container -->
		<?php print TooltipManager::getLoadHTML(); ?>
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
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		</script>
	</body>
</html>
