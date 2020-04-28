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
?>
		<div style="clear:both; height:1px;"><!-- empty --></div>

<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
	</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-5 col-md-7 col-lg-8">
					<p >© 2016 National Gallery of Art, Washington</p>
				</div>
				<div class="col-sm-7 col-md-5 col-lg-4">

					<div class="footerlink">
						Credits
					</div>
					<div class="footerlink">
						Note to User
					</div>	
					<div class="footerlink">
						Press
					</div>
					<div class="footerlink">
						Contact
					</div>
					<div style="clear:both; height:1px;"><!-- empty --></div>
					<div class="footerlink">
						Notices
					</div>
					<div class="footerlink">
						<a href='http://www.nga.gov'>http://www.nga.gov</a>
					</div>																																		
		
				</div>
			</div>
		</div>
	</div><!-- end footer -->	
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
				
				var loadComparisonListSummary;
				$('#comparison_list, #browseResultsContainer').on('click', '.compare_link, .comparison_list_remove', loadComparisonListSummary = function(e) {
					var id = this ? $(this).data('id') : null;
					var remove_id = this ? $(this).data('remove_id') : null;
		
					$.getJSON('<?php print caNavUrl($this->request, '', 'Compare', 'AddToList'); ?>', {table: 'ca_objects', id: id, remove_id: remove_id}, function(d) {
						if (parseInt(d.ok) == 1) {
							var l = '';
							
							var display_list = d.comparison_display_list;
							if (d.comparison_list && (d.comparison_list.length > 0)) {
								l += "<li><?php print caNavLink($this->request, "<strong>"._t("Compare images side-by-side")."</strong>", "", "", "Compare", "View", ['table' => 'ca_objects']); ?></li>\n";
								l += '<li role="separator" class="divider"></li>';
								
								jQuery.each(d.comparison_list, function(i, id) {
									l += "<li><a href='#' class='comparison_list_remove' data-remove_id='" + id + "'><em>Remove</em> " + display_list[i] + "</a></li>\n";
								});
								
								jQuery("#comparison_list").fadeIn(100);
								jQuery(".compare_menu_item").show();
							} else {
								jQuery("#comparison_list").fadeOut(100);
								jQuery(".compare_menu_item").hide();
							}
							jQuery("#comparison_list a").html("Compare (" + d.comparison_list.length + ")");
							jQuery("#comparison_list ul").html(l);
							
							// Reload page when removing from within "Compare" view
							if (remove_id && <?php print ($this->request->getController() == 'Compare') ? "true" : "false"; ?>) {
								window.location = '<?php print caNavUrl($this->request, '', 'Compare', 'View', ['table' => 'ca_objects']); ?>';
								return;
							}
						}
					});
					if (e) { e.preventDefault(); }
			
					return false;
				});
				loadComparisonListSummary();
			});
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		</script>
	</body>
</html>
