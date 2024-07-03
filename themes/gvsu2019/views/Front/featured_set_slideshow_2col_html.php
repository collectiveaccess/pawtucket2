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
	$va_access_values = $this->getVar("access_values");
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$o_config = $this->getVar("config");
	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "Artist: ^ca_entities.preferred_labels.displayname";
	}
	if($qr_res && $qr_res->numHits()){
?>   
		<div class="row">
			<div class="col-sm-12 bgLightBlue colNoPadding">
				<div class="jcarousel-wrapper mainSlideShow">
					<!-- Carousel -->
					<div class="jcarousel mainSlide">
						<ul id="hpSlides">
<?php
							$va_thumbnails = array();
							while($qr_res->nextHit()){
								if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.mediumlarge</l>', array("checkAccess" => $va_access_values))){
									$va_thumbnails[$qr_res->get("ca_objects.object_id")] = $qr_res->get('ca_object_representations.media.iconlarge', array("checkAccess" => $va_access_values));
?>							
									
									<li id="slide<?php print $qr_res->get("ca_objects.object_id"); ?>" class="<?php print $qr_res->get("ca_objects.object_id"); ?>">
										<div class='frontSlide'>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-offset-1 col-md-6">
													<?php print $vs_media; ?>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<div class="slideTextRight">
														<h2 class="text-center">
															<?php print $qr_res->getWithTemplate("^ca_objects.preferred_labels.name"); ?>
														</h2>
														<p class="text-center">
															<?php print $qr_res->getWithTemplate($vs_caption_template); ?> 
														</p>
														<p class="text-center">
															<?php print caDetailLink($this->request, _t("View Item"), 'btn-default', 'ca_objects', $qr_res->get("ca_objects.object_id")); ?>
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
   				         interval: 6000,
       				     target: '+=1',
     				       autostart: true
       					 })
 						   ;
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
