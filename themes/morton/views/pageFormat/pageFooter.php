<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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

	TooltipManager::add('.detailMediaToolbar .zoomButton', 'Zoom');
	TooltipManager::add('.compareButton', 'Add to comparison group');
	TooltipManager::add('.setsButton', 'Add to lightbox');
	TooltipManager::add('.dlButton', 'Download');
	
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
	</div><!-- end pageArea --></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->

	
	<div class='container' style='max-width:none;'>
		<div class='row'>
			<div id="footer">
				<div class='upperBlock'>
					<div class='col-sm-12 col-md-4 col-md-offset-4'>
						<div class='footerLogo'>
							<?= caGetThemeGraphic($this->request, 'ACORN-logo-white-trans.png');?>
						</div>
					</div>
				</div>
				<div class='lowerBlock'>
					© <?= date('Y'); ?> THE MORTON ARBORETUM&nbsp;&nbsp;|
					&nbsp;&nbsp;4100 ILLINOIS ROUTE 53, LISLE, IL 60532&nbsp;&nbsp;|
					&nbsp;&nbsp;<a href='http://www.mortonarb.org/visit-explore/plan-visit/maps-and-directions'>Map</a>&nbsp;&nbsp;|
					&nbsp;&nbsp;Phone: 630-968-0074&nbsp;&nbsp;|
					&nbsp;&nbsp;Email: <a href='mailto:trees@mortonarb.org'>trees@mortonarb.org</a>&nbsp;&nbsp;|
					&nbsp;&nbsp;<a href='http://www.mortonarb.org/privacy-policy' target='_blank'>Privacy Policy&nbsp;&nbsp;</a>  
				</div>
			</div><!-- end footer -->	
		</div><!-- end row-->	
	</div><!-- end container -->
    <?= TooltipManager::getLoadHTML(); ?>
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
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-59BF57K');</script>
<!-- End Google Tag Manager -->
</body>
</html>
