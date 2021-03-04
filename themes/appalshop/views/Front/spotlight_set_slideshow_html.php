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
	$o_config = $this->getVar("config");
	$va_access_values = $this->getVar("access_values");
	
	$va_spotlight_ids = array();
	if($vs_set_code = $o_config->get("cultural_history_set_code")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		$vn_shuffle = 0;
		if($o_config->get("cultural_history_set_random")){
			$vn_shuffle = 1;
		}
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$vn_spotlight_set_id = $t_set->get("set_id");
			$va_spotlight_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
			$qr_res = caMakeSearchResult('ca_objects', $va_cultural_history_ids);
	
			$vs_caption_template = $o_config->get("cultural_history_set_item_caption_template");
			if(!$vs_caption_template){
				$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
			}
			if($qr_res && $qr_res->numHits()){
		?>   <div class="row">
		       <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 spotlightRow">
	            <h2>Spotlight</h2>
	           </div>
	           <div class="jcarousel-wrapper galleryItems-wrapper">
					<!-- Carousel -->
					<div class="jcarousel frontSpotlight">
						<ul>
		<?php
							while($qr_res->nextHit()){
								if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.small</l>', array("checkAccess" => $va_access_values))){
									print "<li><div class='frontSlide spotlightSlide'>".$vs_media;
									$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
									if($vs_caption){
										print "<div class='slideTextRight'>".$vs_caption."</div>";
									}
									print "</div></li>";
									$vb_item_output = true;
								}
							}
		?>
						</ul>
					</div><!-- end jcarousel -->

		<?php
					if($vb_item_output){
		?>
					<!-- Prev/next controls -->
					<a href="#" class="jcarousel-control-prev frontSpotlight"><i class="fa fa-angle-left"></i></a>
					<a href="#" class="jcarousel-control-next frontSpotlight"><i class="fa fa-angle-right"></i></a>
		
					<!-- Pagination -->
					<p class="jcarousel-pagination frontSpotlight">
					<!-- Pagination items will be generated in here -->
					</p><br/>
		<?php
					}
		?>
		</div><!-- end jcarousel-wrapper -->
			</div>
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						/*
						Carousel initialization
						*/
						$('.jcarousel.frontSpotlight')
							.jcarousel({
								// Options go here
								wrap:'circular'
							});
		
						/*
						 Prev control initialization
						 */
						$('.jcarousel-control-prev.frontSpotlight')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '-=1'
							});
		
						/*
						 Next control initialization
						 */
						$('.jcarousel-control-next.frontSpotlight')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '+=1'
							});
		
						/*
						 Pagination initialization
						 */
						$('.jcarousel-pagination.frontSpotlight')
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
		<?php
			}
		}
	}

?>
