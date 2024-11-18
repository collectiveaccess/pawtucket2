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
			</div><!-- end main -->
			<!--begin footer-->
			<div class="row footer" role="contentinfo">
				<div class="col-sm-12 col-md-4">
					<b>NEW YORK CITY</b>
					<br/>46 WEST 90TH STREET
					<br/>NEW YORK, NY 10024
					<br/>BY APPOINTMENT ONLY
					<br/><br/>
				</div>
				<div class="col-sm-12 col-md-4 offset-md-1">
					<b>HUDSON</b>
					<br/>433 WARREN STREET<br/>HUDSON, NY 12534
					<br/>THURSDAY-MONDAY, 11AM-5PM AND BY APPOINTMENT
					<br/><br/><br/>
					<div class="text-center footerSocialNav">
						<a href="https://www.facebook.com/pages/Susan-Eley-Fine-Art/137980986325025" class="socialicon"><?php print caGetThemeGraphic($this->request, 'fbook.png', array("alt" => "FaceBook")); ?></a>
						<a href="https://twitter.com/EleyFineArt" class="socialicon"><?php print caGetThemeGraphic($this->request, 'twitter.png', array("alt" => "Twitter")); ?></a>
						<a href="https://instagram.com/sefa_gallery" class="socialicon darker"><?php print caGetThemeGraphic($this->request, 'instagram.png', array("alt" => "Instagram")); ?></a>
					</div>
				</div>
				<div class="col-sm-12 col-md-3 socialright footernav">
					<?php print caNavLink($this->request, _t("Newsletter Signup"), "footerButton", "", "About", "MailingList"); ?>
					<a href="https://artsy.net/susan-eley-fine-art?utm_source=follow_badge" class="socialicon"><?php print caGetThemeGraphic($this->request, 'artsy.png', array("alt" => "Artsy")); ?></a>
					<a href="https://www.1stdibs.com/dealers/susan-eley-fine-art/?utm_source=susaneleyfineart.com&utm_medium=referral&utm_campaign=dealer&utm_content=dealer_badge_1stdibs_gray" target="_blank" class="socialiconDibs"><?php print caGetThemeGraphic($this->request, '1stdibs_dark.jpg', array("title" => "Shop Susan Eley Fine Art's fine art on 1stdibs", "alt"=> "Shop Susan Eley Fine Art's fone art on 1stdibs")); ?></a>
					<a href="mailto:susie@susaneleyfineart.com" class="socialicon"><?php print caGetThemeGraphic($this->request, 'envelope.png', array("alt" => "Email")); ?></a>
				</div>
				<div class="col-sm-12 socialleft footernavphone">
					<?php print caNavLink($this->request, _t("Newsletter Signup"), "footerButton", "", "About", "MailingList"); ?><br/><br/>
					<a href="https://www.facebook.com/pages/Susan-Eley-Fine-Art/137980986325025" class="socialicon"><?php print caGetThemeGraphic($this->request, 'fbook.png', array('alt' => 'FaceBook')); ?></a>
					<a href="https://twitter.com/EleyFineArt" class="socialicon"><?php print caGetThemeGraphic($this->request, 'twitter.png', array('alt' => 'Twitter')); ?></a>
					<a href="https://instagram.com/sefa_gallery" class="socialicon darker"><?php print caGetThemeGraphic($this->request, 'instagram.png', array('alt' => 'Instagram')); ?></a>
					<a href="https://artsy.net/susan-eley-fine-art?utm_source=follow_badge" class="socialicon"><?php print caGetThemeGraphic($this->request, 'artsy.png', array('alt' => 'Artsy')); ?></a>
					<a href="https://www.1stdibs.com/dealers/susan-eley-fine-art/?utm_source=susaneleyfineart.com&utm_medium=referral&utm_campaign=dealer&utm_content=dealer_badge_1stdibs_gray" target="_blank" class="socialiconDibs"><?php print caGetThemeGraphic($this->request, '1stdibs_dark.jpg', array("title" => "Shop Susan Eley Fine Art's fine art on 1stdibs", "alt"=> "Shop Susan Eley Fine Art's fone art on 1stdibs")); ?></a>
					<a href="mailto:susie@susaneleyfineart.com" class="socialicon"><?php print caGetThemeGraphic($this->request, 'envelope.png', array('alt' => 'Email')); ?></a>
				</div>
			</div>
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
