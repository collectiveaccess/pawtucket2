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
	<div id="comparison_list" class="compareDrawer compare_menu_item">
		<ul>
		
		</ul>  
	</div>
<?php
	if(strtolower($this->request->getController()) !== "compare"){
?>
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-5 col-md-7 col-lg-8">
					<p><a href='http://www.nga.gov'>© 2016 National Gallery of Art, Washington</a></p>
				</div>
				<div class="col-sm-7 col-md-5 col-lg-4" style="text-align:right;">

					<div class="footerlink">
<?php					
						print caNavLink($this->request, 'About the Project', '', '', 'About', 'project');
?>
					</div> | 
					<div class="footerlink">
<?php					
						print caNavLink($this->request, 'Guide to the Catalog', '', '', 'About', 'notes');
?>						
					</div> | 
					<div class="footerlink">
<?php					
						print caNavLink($this->request, 'Contact', '', '', 'About', 'contact');
?>
					</div>																																	
				</div>
			</div>
		</div>
	</div><!-- end footer -->	
<?php
	}
?>
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
								l += "<p class='listTitle'><?php print caNavLink($this->request, _t("<i class='fa fa-clone'></i> Compare images"), "", "", "Compare", "View", ['table' => 'ca_objects']); ?> (" + d.comparison_list.length + ")</p>\n";
								l += "<a href='#' class='openItems' onClick=\"$('.compareDrawer .items').toggle(100); return false;\"><i class='fa fa-chevron-down'></i></a>\n"; 
								
								l += "<div class='items'>";
								jQuery.each(d.comparison_list, function(i, id) {
									l += "<p><a href='#' class='comparison_list_remove' data-remove_id='" + id + "'><i class='fa fa-close'></i> " + display_list[i] + "</a></p>\n";
								});
								l += "</div>";
								
								jQuery("#comparison_list").fadeIn(100);

							} else {
								jQuery("#comparison_list").fadeOut(100);
							}
							jQuery("p.listTitle a").html("Compare (" + d.comparison_list.length + ")");
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
		<script>
			$(document).scroll(function() {
    			checkOffset();
			});
			function checkOffset() {
				if($('#comparison_list').offset().top + $('#comparison_list').height() 
													   >= $('#footer').offset().top - 100)
					$('#comparison_list').css({"position": "absolute", "bottom": "100px"});
				if($(document).scrollTop() + window.innerHeight < $('#footer').offset().top)
					$('#comparison_list').css({"position": "fixed", "bottom": "0px"}); // restore when you scroll up
			}
		</script>
	</body>
</html>
