<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
		$o_config = caGetGalleryConfig();
		$va_access_values = caGetUserAccessValues($this->request);
 		$t_list = new ca_lists();
 		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 	
 		$vn_on_view_set_id = $this->getVar("featured_set_id");	
 		$va_sets = array();
?>
	
		<div class="row">
			<div class="col-sm-3"><div class="hpBox bgDarkBlue">
				<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'spacer.png')."<div class='hpSetTitle' style='visibility: hidden;'>A</div><H2>"._t("Inside the Collection")."</H2>", "", "", "Gallery", "Index"); ?>
			</div></div>
<?php
			# --- loop through all the features
 		if($vn_gallery_set_type_id){
			$t_set = new ca_sets();
			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
			$va_set_ids = array_keys($va_sets); 
			shuffle($va_set_ids); 
			# --- add the on view set to the beginning if it's set
			if($vn_on_view_set_id){
				unset($va_set_ids[$vn_on_view_set_id]);
				array_unshift($va_set_ids, $vn_on_view_set_id);
			}
			$va_randomized = array(); 
			foreach ($va_set_ids as $vn_set_id) { 
				$va_randomized[$vn_set_id] = $va_sets[$vn_set_id]; 
			}
			$vn_limit = 10;
			$va_sets = array_slice($va_randomized,0,$vn_limit,true);
			
			if(sizeof($va_sets)){
				# --- get first items from set
				#$va_first_items = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("checkAccess" => $va_access_values, "version" => "iconlarge"));
				$vn_c = 1;
				$va_boxes = array();
				$i = 1;
				foreach($va_sets as $vn_set_id => $va_set){
					$t_set->load($vn_set_id);
					$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("checkAccess" => $va_access_values, "thumbnailVersion" => "iconlarge", "limit" => 3)));
					$vs_image = "";
					print '<div class="col-sm-3"><div class="hpBox">';
#					$va_first_item = array_shift($va_set_items);
#					if(is_array($va_first_item) && sizeof($va_first_item)){
#						$vs_image = $va_first_item["representation_tag"];
#					}
#					print caNavLink($this->request, $vs_image, "", "", "Gallery", $vn_set_id);
					print '<div class="jcarousel-wrapper"><div class="jcarousel box'.$vn_c.'"><ul>';
					foreach($va_set_items as $va_set_item_info){
						if($va_set_item_info["representation_tag"]){
							print "<li>".caNavLink($this->request, $va_set_item_info["representation_tag"], "", "", "Gallery", $vn_set_id)."</li>";
						}
					}
					print "</ul></div></div>";
					print "<div class='hpSetTitle ".(($i == 1) ? "onView" : "")."'>".caNavLink($this->request, $va_set["name"]."  &raquo;", "", "", "Gallery", $vn_set_id)."</div>\n";
					$va_boxes[] = "box".$vn_c;
					$vn_c++;
					print "</div></div>";
					$i++;
				}
				if($vn_limit > $vn_c){
					$vn_limit = $vn_c;
				}
			}
		}

?>			
			<div class="col-sm-3"><div class="hpBox bgDarkBlue">
				<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'spacer.png'), "", "", "Browse", "objects"); ?>
				<div class='hpSetTitle' style='visibility: hidden;'>A</div>
				<?php print caNavLink($this->request, _t("View All")." &raquo;", "hpMore", "", "Browse", "objects"); ?>
			</div></div>
		</div>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
					Set width of li to width of container and do it on page resize
				*/
				
				$('.front .jcarousel-wrapper li').width($('.hpBox').width());
				$( window ).resize(function() {
					$('.front .jcarousel-wrapper li').width($('.hpBox').width());
				});
				/*Carousel initialization*/
				/*$('.jcarousel').on('jcarousel:animate', function (event, carousel) {
					$(carousel._element.context).find('li').css({'opacity':0.3}).fadeTo(1500, 1);
					
				})*/
				$('.jcarousel').jcarousel({
					wrap: 'circular',
					animation: 500/*{
						duration: 0 
					}*/
				})
				.jcarouselAutoscroll({
					target: '+=1',
					autostart: false,
					interval: 1000
				});
				/*setInterval(function() { 
					var minNumber = 1;
					var maxNumber = <?php print $vn_limit; ?>;
					var randomNumber = Math.floor(Math.random()*(maxNumber-minNumber+1)+minNumber);
					
					$('.box'+randomNumber).jcarousel('scroll', '+=1');
				}, 2400);*/
				var count = 1;
				function animateBox() {

     				if (count > <?php print $vn_limit; ?>) {
                		count = 0;
            		}

            		$('.box'+count).jcarousel('scroll', '+=1');

   					count ++;

        		}
				setInterval(animateBox, 3000);
			});
		</script>