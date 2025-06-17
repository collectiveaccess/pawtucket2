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
		<div id="comparison_list" class="compareDrawer compare_menu_item">
			<div class="comparisonList">
		
			</div>  
		</div>
		</div><!-- end pageArea --></div></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		

<?php
if(strtolower($this->request->getController()) !== "compare"){
?>		
		<footer id="footer" class="text-center">
			<div class="row">
				<div class="col-sm-12 text-center">
					<p>
						<a href="http://www.nga.gov" class="museumLink" target="_blank">National Gallery of Art</a>
					</p>
					<ul class="list-inline social">
						<li><a href="https://www.facebook.com/nationalgalleryofart" target="_blank"><i class="fa fa-facebook-square" aria-label="Facebook"></i></a></li>
						<li><a href="https://www.instagram.com/ngadc/" target="_blank"><i class="fa fa-instagram" aria-label="Instragram"></i></a></li>
						<li><a href="https://twitter.com/ngadc" target="_blank"><i class="fa fa-twitter-square" aria-label="Twitter"></i></a></li>
					</ul>
					<ul class="list-inline">
						<li><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "form"); ?></li>
						<li><?php print caNavLink($this->request, _t("Notices"), "", "", "About", "Notices"); ?></li>
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
						exposeBackgroundColor: '#FFFFFF',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.7,							/* opacity of background color masking out page content; 1.0 is opaque */
						panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
						allowMobileSafariZooming: true,
						mobileSafariViewportTagID: '_msafari_viewport',
						closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
					});
				}
				
								
				var loadComparisonListSummary;
				$('#comparison_list, #pageArea').on('click', '.compare_link, .comparison_list_remove', loadComparisonListSummary = function(e) {
					var id = this ? $(this).data('id') : null;
					var id_selector = this ? $(this).data('id_selector') : null;
					var remove_id = this ? $(this).data('remove_id') : null;
					var remove_all = this ? $(this).data('remove_all') : null;
					
					if (id_selector) {
					    if (id = jQuery(id_selector).data('current_id')) { id = "representation:" + id; }
					}
		
					$.getJSON('<?php print caNavUrl($this->request, '', 'Compare', 'AddToList'); ?>', {id: id, remove_id: remove_id, remove_all: remove_all}, function(d) {
						if (parseInt(d.ok) == 1) {
							var l = '', im = '';
							
							if (d.comparison_list && (d.comparison_list.length > 0)) {
								l += "<p class='listTitle'><?php print caNavLink($this->request, _t("<span class='compareImg'></span> <span id='compare_count_display'>Compare images</span> <i class='fa fa-expand' aria-label='open'></i>"), "", "", "Compare", "View", ['url' => str_replace('/', '|', $this->request->getFullUrlPath())]); ?></p>\n";
								l += "<a href='#' class='openItems' onClick=\"$('.compareDrawer .items').toggle(100); $('.compareDrawer').data('open', !$('.compareDrawer').data('open')); return false;\"><i class='fa fa-chevron-down' aria-label='open close compare list'></i></a>\n"; 
								
								l += "<div class='items'>";
								jQuery.each(d.comparison_list, function(i, item) {
									l += "<p><a href='#' class='comparison_list_remove' data-remove_id='" + item['id'] + "'><i class='fa fa-times' aria-label='remove item'></i> " + item['display'] + "</a></p>\n";
								});
								l += "<p><a href='#' class='comparison_list_remove' data-remove_all='1'><i class='fa fa-times' aria-label='remove item'></i> CLEAR SELECTION</a></p>\n";
								
								l += "</div>";
								
								im = "Compare " + d.comparison_list.length + ((d.comparison_list.length > 1) ? " images" : " image"); 
								jQuery("#comparison_list").fadeIn(100);

							} else {
								jQuery("#comparison_list").fadeOut(100);
								jQuery(".compareDrawer").data('open', false);
							}
							jQuery("#comparison_list div.comparisonList").html(l);
							jQuery('#compare_count_display').html(im);
							
							// Reload page when removing from within "Compare" view
							if ((remove_all || remove_id) && <?php print ($this->request->getController() == 'Compare') ? "true" : "false"; ?>) {
								window.location = '<?php print caNavUrl($this->request, '', 'Compare', 'View', ['url' => str_replace('/', '|', $this->request->getFullUrlPath())]); ?>';
								return;
							} else if($(".compareDrawer").data('open')){
							    jQuery(".compareDrawer .items").toggle(0);
						    }
						}
					});
					
					if (e) { e.preventDefault(); }
			
					return false;
				});
				loadComparisonListSummary();

			});
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
			$(document).ready(function(){
				$(window).scroll(function(){
					$("#hpScrollBar").fadeOut();
				});
			});
		</script>
	</body>
</html>
