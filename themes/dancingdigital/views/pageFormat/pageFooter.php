<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2018 Whirl-i-Gig
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

<?php
	if(false) {
?>
		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<footer id="footer" class="text-center">
			<div class="row">
				<div class="col-sm-4 text-center">
					<?php
						print caNavLink($this->request, caGetThemeGraphic($this->request, 'no-boundaries.png', array("alt" => $this->request->config->get("app_display_name"), "role" => "banner")), "", "", "","");
					?>
				</div>
				<div class="col-sm-4 text-center">
					<ul class="list-inline social">
						<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
						<li><a href="#" target="_blank"><i class="fab fa-twitter"></i> </a></li>
						<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
						<li><a href="#" target="_blank"><i class="fab fa-vimeo-v"></i></a></li>
					</ul>
				</div>
				<div class="col-sm-4 text-center">
					<?php
						print caNavLink($this->request, caGetThemeGraphic($this->request, 'UTA_logo.png', array("alt" => $this->request->config->get("app_display_name"), "role" => "banner")), "", "", "","");
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<ul class="list-inline">
						<li><?php print caNavLink($this->request, _t("Contact Us"), "", "", "Contact", "Form"); ?></li>
						<li><?php print caNavLink($this->request, _t("Support Us"), "", "", "", ""); ?></li>
						<li><?php print caNavLink($this->request, _t("Resources"), "", "", "", ""); ?></li>
						<li><?php print caNavLink($this->request, _t("Related Articles"), "", "", "", ""); ?></li>
						<li><?php print caNavLink($this->request, _t("Accessibility"), "", "", "", ""); ?></li>
					</ul>
				</div>
			</div>
		</footer><!-- end footer -->
<?php
	}
?>
	
		<?php print TooltipManager::getLoadHTML(); ?>
		<div id="caMediaPanel" role="complementary"> 
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
						onCloseCallback: function(data) {
							if(data && data.url) {
								window.location = data.url;
							}
						},
						exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.5,							/* opacity of background color masking out page content; 1.0 is opaque */
						panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
						allowMobileSafariZooming: true,
						mobileSafariViewportTagID: '_msafari_viewport',
						closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
					});
				}
			});
		</script>
<?php
	print $this->render("Cookies/banner_html.php");	
?>

    	<!-- <script src="/themes/dancingdigital/assets/pawtucket/js/transitions.js"></script> -->
	</body>
</html>
