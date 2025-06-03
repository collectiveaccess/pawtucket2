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


	</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
<?php
	if ((strtolower($this->request->getController()) !== "front")) {	
		print '<div id="backToTop"><a href="#">'.caGetThemeGraphic($this->request, 'rothko-back-to-top.svg').'Top</a></div>';
	}
?>	
	<div id="comparison_list" class="compareDrawer compare_menu_item">
		<ul>
		
		</ul>  
	</div>
<?php
	if((strtolower($this->request->getController()) !== "compare") && (strtolower($this->request->getController()) !== "front")){
?>
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-4">
					<p class="footerTitle"><a href='http://www.nga.gov'>National Gallery of Art</a></p>
					<p>© <?php print date('Y');?> National Gallery of Art, Washington</p>
				</div>
				<div class="col-sm-6">
					<div style="margin-bottom:15px;">{{{footerText}}}</div>
					<div class="footerLinks">
						<div class="footerLink"><?php print caNavLink($this->request, 'About', '', '', 'About', 'project');?></div> | 
						<div class="footerLink space"><?php print caNavLink($this->request, ' Credits', '', '', 'About', 'credits'); ?></div> | 
						<div class="footerLink space"><?php print caNavLink($this->request, ' Notices', '', '', 'About', 'notices'); ?></div> | 
						<div class="footerLink space"><?php print caNavLink($this->request, ' Contact', '', '', 'About', 'contact'); ?></div>
						<!--<div class="socialLink"><a href="http://www.facebook.com"><i class="fab fa-facebook-f"></i></a></div>
						<div class="socialLink"><a href="http://www.twitter.com"><i class="fab fa-twitter"></i></a></div>-->
					</div>																																	
				</div>
				<div class="col-sm-1"></div>
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
				$('#comparison_list, #pageArea').on('click', '.compare_link, .comparison_list_remove', loadComparisonListSummary = function(e) {
					var id = this ? $(this).data('id') : null;
					var id_selector = this ? $(this).data('id_selector') : null;
					var remove_id = this ? $(this).data('remove_id') : null;
					
					if (id_selector) {
					    if (id = jQuery(id_selector).data('current_id')) { id = "representation:" + id; }
					}
		
					$.getJSON('<?php print caNavUrl($this->request, '', 'Compare', 'AddToList'); ?>', {id: id, remove_id: remove_id}, function(d) {
						if (parseInt(d.ok) == 1) {
							var l = '', im = '';
							
							if (d.comparison_list && (d.comparison_list.length > 0)) {
								l += "<p class='listTitle'><?php print caNavLink($this->request, _t("<span class='compareImg'></span> <span id='compare_count_display'>Compare images</span>"), "", "", "Compare", "View", ['url' => str_replace('/', '|', $this->request->getFullUrlPath())]); ?></p>\n";
								l += "<a href='#' class='openItems' onClick=\"$('.compareDrawer .items').toggle(100); $('.compareDrawer').data('open', !$('.compareDrawer').data('open')); return false;\"><i class='fa fa-chevron-down'></i></a>\n"; 
								
								l += "<div class='items'>";
								jQuery.each(d.comparison_list, function(i, item) {
									l += "<p><a href='#' class='comparison_list_remove' data-remove_id='" + item['id'] + "'><i class='fa fa-times'></i> " + item['display'] + "</a></p>\n";
								});
								l += "</div>";
								
								im = "Compare " + d.comparison_list.length + ((d.comparison_list.length > 1) ? " images" : " image"); 
								jQuery("#comparison_list").fadeIn(100);

							} else {
								jQuery("#comparison_list").fadeOut(100);
								jQuery(".compareDrawer").data('open', false);
							}
							jQuery("#comparison_list ul").html(l);
							jQuery('#compare_count_display').html(im);
							
							// Reload page when removing from within "Compare" view
							if (remove_id && <?php print ($this->request->getController() == 'Compare') ? "true" : "false"; ?>) {
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

		</script>
		<script>
			$(document).scroll(function() {
    			checkOffset();
			});
			function checkOffset() {
				if($('#comparison_list').offset().top + $('#comparison_list').height() 
													   >= $('#footer').offset().top - 160)
					$('#comparison_list').css({"position": "absolute", "bottom": "160px"});
				if($(document).scrollTop() + window.innerHeight < $('#footer').offset().top)
					$('#comparison_list').css({"position": "fixed", "bottom": "0px"}); // restore when you scroll up
				
				
				if($('#backToTop').offset().top + $('#backToTop').height() 
													   >= $('#footer').offset().top - 170)
					$('#backToTop').css({"position": "absolute", "bottom": "170px"});
				if($(document).scrollTop() + window.innerHeight < $('#footer').offset().top)
					$('#backToTop').css({"position": "fixed", "bottom": "10px"}); // restore when you scroll up			
			}
		</script>
	</body>
</html>
