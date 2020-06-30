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
	$va_featured_set_item_ids = $this->getVar("featured_set_item_ids");
	$qr_res = caMakeSearchResult('ca_collections', $va_featured_set_item_ids);
	$o_config = $this->getVar("config");
	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
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
								if($vs_media = $qr_res->getWithTemplate('<ifcount code="ca_objects" restrictToRelationshipTypes="featured" min="1"><l><unit relativeTo="ca_objects" restrictToRelationshipTypes="featured" length="1">^ca_object_representations.media.large</unit></l></ifcount>', array("checkAccess" => $va_access_values))){
									$va_thumbnails[$qr_res->get("ca_collections.collection_id")] = $qr_res->getWithTemplate('<unit relativeTo="ca_objects" restrictToRelationshipTypes="featured" length="1">^ca_object_representations.media.iconlarge</unit>', array("checkAccess" => $va_access_values));
?>							
									
									<li id="slide<?php print $qr_res->get("ca_collections.collection_id"); ?>" class="<?php print $qr_res->get("ca_collections.collection_id"); ?>">
										<div class='frontSlide'>
											<div class="row">
												<div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-6">
													<?php print $vs_media; ?>
												</div>
												<div class="col-xs-12 col-sm-4 col-md-4">
													<div class="slideTextRight">
														<h2>
															<?php print $qr_res->getWithTemplate("<l>^ca_collections.preferred_labels.name</l>"); ?>
														</h2>
														<p>
															<?php print $qr_res->getWithTemplate($vs_caption_template); ?> 
														</p>
														<p class="text-center">
															<?php print caDetailLink($this->request, _t("View Collection"), 'btn-default', 'ca_collections', $qr_res->get("ca_collections.collection_id")); ?>
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
