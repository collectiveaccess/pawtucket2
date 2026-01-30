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
		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<footer id="footer">
			
			<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<div class="orgLink">
							Crista Dahl
							<br/>Media Library & Archive
							<hr/>
							VIVO Media Arts Centre
					</div>
				</div>
				<div class="col-sm-2">
					<ul class="">
						<li class="title">About</li>
						<li><?php print caNavLink($this->request, _t("The Archive"), "", "", "About", "Index"); ?></li>
						<li><?php print caNavLink($this->request, _t("How to Use this Site"), "", "", "About", "Guide"); ?></li>
						<li><?php print caNavLink($this->request, _t("Research & Reproduction"), "", "", "About", "ResearchReproduction"); ?></li>
						<li><?php print caNavLink($this->request, _t("Policies"), "", "", "About", "Policies"); ?></li>
					</ul>
				</div>
				<div class="col-sm-2">
					<ul class="">
						<li class="title">Browse</li>
						<li><?php print caNavLink($this->request, _t("All Objects"), "", "", "Browse", "objects"); ?></li>
						<li><?php print caNavLink($this->request, _t("People & Organizations"), "", "", "Browse", "entities"); ?></li>
						<li><?php print caNavLink($this->request, _t("Videos"), "", "", "Browse", "video"); ?></li>
						<li><?php print caNavLink($this->request, _t("Events"), "", "", "Browse", "events"); ?></li>
						<li><?php print caNavLink($this->request, _t("Research Guides"), "", "", "Browse", "research_guides"); ?></li>
					</ul>
				</div>
				<div class="col-sm-2">
					<ul class="">
						<li class="title">Collections</li>
<?php
	$col_config = caGetCollectionsConfig();
	$vs_sves_id = $col_config->get("sves_idno");
	if($vs_sves_id){
		$t_sves_collection = new ca_collections(array("idno" => $vs_sves_id));
		if($vn_sves_id = $t_sves_collection->get("ca_collections.collection_id")){
?>
						<li><?php print caDetailLink($this->request, _t("Satellite Video Exchange Society"), "", "ca_collections",  $vn_sves_id); ?></li>
<?php
		}
	}
?>
						<li><?php print caNavLink($this->request, _t("Explore All Collections"), "", "", "Collections", "index"); ?></li>
						<li><?php print caNavLink($this->request, _t("Projects"), "", "", "Gallery", "Index"); ?></li>
						<li><?php print caNavLink($this->request, _t("Donate"), "", "", "About", "Donate"); ?></li>
					</ul>
				</div>
				<div class="col-sm-2">
					<ul class="">
						<li class="title"><?php print caNavLink($this->request, _t("Video Out")." <span class='material-symbols-outlined'>open_in_new</span>", "", "", "VideoOut", "Index"); ?></li>
						<li><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "videoout"); ?></li>
						<li><?php print caNavLink($this->request, _t("Artists"), "", "", "Browse", "videooutartists"); ?></li>
						<li><?php print caNavLink($this->request, _t("Rental & Sales"), "", "", "Contact", "form", array("contactType" => "RentalPurchase")); ?></li>
						<li><?php print caNavLink($this->request, _t("Submit for Distribution"), "", "", "VideoOutSubmit", ""); ?></li>
						<li><a href="https://www.vivomediaarts.com/"><?php print _t("VIVO Media Arts")." <span class='material-symbols-outlined'>open_in_new</span>"; ?></a></li>
					</ul>
				</div>
			</div>
			</div>
		</footer><!-- end footer -->
<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
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
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		
//			$(document).ready(function() {
//				$(document).bind("contextmenu",function(e){
//				   return false;
//				 });
//			}); 
		</script>
<?php
	print $this->render("Cookies/banner_html.php");	
?>
	</body>
</html>
