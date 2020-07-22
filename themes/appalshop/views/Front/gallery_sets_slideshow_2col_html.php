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

# --- this makes a slideshow of gallery sets by the set type configured in gallery.conf
	
	$va_access_values = $this->getVar("access_values");
	$o_front_config = caGetFrontConfig();
	$o_gallery_config = caGetGalleryConfig();
	
	# --- which type of set is configured for display in gallery section
 	$t_list = new ca_lists();
 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_gallery_config->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	$va_sets = array();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_objects");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$va_set_first_items_large = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "large", "checkAccess" => $va_access_values));
		$va_set_first_items_iconlarge = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
	}

	if(is_array($va_sets) && sizeof($va_sets)){
?>   
		<div class="row">
			<div class="col-sm-12 bgLightBlue colNoPadding">
				<div class="jcarousel-wrapper mainSlideShow">
					<!-- Carousel -->
					<div class="jcarousel mainSlide">
						<ul id="hpSlides">
<?php
							$va_thumbnails = array();
							foreach($va_sets as $vn_set_id => $va_set){
								#$t_set = new ca_sets($vn_set_id);
								#$vs_desc = $t_set->get($o_gallery_config->get('gallery_set_description_element_code'));
								$va_first_item_large = array_shift($va_set_first_items_large[$vn_set_id]);
								$va_first_item_iconlarge = array_shift($va_set_first_items_iconlarge[$vn_set_id]);
								if($vs_media = $va_first_item_large["representation_tag"]){
									$va_thumbnails[$vn_set_id] = $va_first_item_iconlarge["representation_tag"];
?>							
									
									<li id="slide<?php print $vn_set_id; ?>" class="<?php print $vn_set_id; ?>">
										<div class='frontSlide'>
											<div class="row">
												<div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-6">
													<?php print $vs_media; ?>
												</div>
												<div class="col-xs-12 col-sm-4 col-md-4">
													<div class="slideTextRight">
														<h2>
															<?php print caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id); ?>
														</h2>
														<p>
															<?php #print $vs_desc; ?> 
														</p>
														<p class="text-center">
															<?php print caNavLink($this->request, _t("View Project"), 'btn-default', '', 'Gallery', $vn_set_id); ?>
														</p>
													</div>
													<div class="col-md-1 col-lg-1"></div>
												</div>
											</div>
										</div>
									</li>									
									
<?php									
									$vb_item_output = true;
								}
							}
?>
						</ul>
					</div>  <!-- end jcarousel -->
<?php
			if($vb_item_output){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev mainSlideNav"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="jcarousel-control-next mainSlideNav"><i class="fa fa-angle-right"></i></a>
				<div class="container text-center">
					<div class="row mainSlideThumbs">
					<div class="col-sm-offset-0 col-md-offset-4">		
<?php
					$i = 0;
					foreach($va_thumbnails as $vn_id => $vs_thumbnail){
						print "<div class='col-sm-2 col-md-1 thumb".$vn_id." ".(($i == 0) ? " mainSlideActive" : "")."'><a href='#' onclick='$(\".mainSlideActive\").removeClass(\"mainSlideActive\"); $(this).parent().addClass(\"mainSlideActive\"); $(\".jcarousel\").jcarousel(\"scroll\", $(\"#slide".$vn_id."\"), false); return false;'>".$vs_thumbnail."</a></div>\n";
						$i++;
					}
?>
					</div>
					</div>	
				</div>
<?php
			}
?>

				</div><!-- end jcarousel-wrapper -->
			</div><!-- end col-sm-12 -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-sm-12">
			<!-- Pagination -->
						
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					$('.mainSlide li').width($('.mainSlideShow').width());
					$( window ).resize(function() {
					  $('.mainSlide li').width($('.mainSlideShow').width());
					});
					/*
					Carousel initialization
					*/
					$('.mainSlide')
						.jcarousel({
							// Options go here
							wrap:'circular'
						});
		
		             $(function() {
   					 $('.jcarousel')
      				  .jcarousel({
     			       // Core configuration goes here
   					     })
   					     .jcarouselAutoscroll({
   				         	interval: 5000,
       				     	target: '+=1',
     				       	autostart: true
       					 });
					 });
					 
					 $('.jcarousel').hover(function() {
						$(this).jcarouselAutoscroll('stop');
					}, function() {
						$(this).jcarouselAutoscroll('start');
					});
					/*
					 Prev control initialization
					 */
					$('.jcarousel-control-prev.mainSlideNav')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							target: '-=1',
							method: function() {
								$('.jcarousel').jcarousel('scroll', '-=1', true, function() {
									var id = $('.jcarousel').jcarousel('target').attr('class');
									$('.mainSlideThumbs div').removeClass('mainSlideActive');
									$('.thumb' + id).addClass('mainSlideActive');
								});
							}
						});
		
					/*
					 Next control initialization
					 */
					$('.jcarousel-control-next.mainSlideNav')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							target: '+=1',
							method: function() {
								$('.jcarousel').jcarousel('scroll', '+=1', true, function() {
									var id = $('.jcarousel').jcarousel('target').attr('class');
									$('.mainSlideThumbs div').removeClass('mainSlideActive');
									$('.thumb' + id).addClass('mainSlideActive');
								});
							}
						});
		
					/*
					 Pagination initialization
					 */
					$('.jcarousel-pagination.mainSlideNav')
						.on('jcarouselpagination:active', 'a', function() {
							$(this).addClass('active');
						})
						.on('jcarouselpagination:inactive', 'a', function() {
							$(this).removeClass('active');
						})
						.jcarouselPagination({
							// Options go here
						});
			
			
				});
				
			</script>
		</div><!-- end col -->
	</div><!-- end row -->
<?php
	}
?>
