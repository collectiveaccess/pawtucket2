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
	# --- check if there is a current exhibition
	$o_occ_search = caGetSearchInstance("ca_occurrences");
	$qr_current_exhibitions = $o_occ_search->search("ca_occurrences.on_view:yes", array("checkAccess" => $va_access_values, "sort" => "ca_occurrences.exhibition_dates", "sortDirection" => "desc"));
	$va_current_exhibition_info = array();
	if($qr_current_exhibitions->numHits()){
		$t_exhibit = new ca_occurrences();
		while($qr_current_exhibitions->nextHit()){
			$t_exhibit->load($qr_current_exhibitions->get("occurrence_id"));
			# --- we need to get the exhibit or exhibits info and images to show
			$va_current_exhibition_info["name"][] = $qr_current_exhibitions->getWithTemplate("<l>^ca_occurrences.preferred_labels.name</l>");
			$va_reps = $t_exhibit->getRepresentations(array("large"), null, array("restrictToTypes" => array("installation", "artwork"), "checkAccess" => $va_access_values));
			foreach($va_reps as $va_rep){
				$va_current_exhibition_info["images"][]	= $va_rep["tags"]["large"];
			}
		}
	}
	if(is_array($va_current_exhibition_info) && sizeof($va_current_exhibition_info["images"])){
?>   
			<div class="jcarousel-wrapper" style="overflow:hidden;">
<?php
					if($va_current_exhibition_info["name"]){
						$vs_exhibition_titles = join("<br/>", $va_current_exhibition_info["name"]);
						print "<div class='frontSlideShowOverlay'>On View<br/>".$vs_exhibition_titles."</div>";
					}
?>
				<!-- Carousel -->
				<div class="jcarousel">
					<ul>
<?php
						foreach($va_current_exhibition_info["images"] as $vs_media){
							print "<li><div class='frontSlide'>".$vs_media."</div></li>";
							$vb_item_output = true;
						}
?>
					</ul>
				</div><!-- end jcarousel -->
<?php
				if($vb_item_output){
?>
				<!-- Prev/next controls -->
				<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
				<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		
			
<?php
				}
?>
			</div><!-- end jcarousel-wrapper -->
<?php	
	}else{


		$qr_res = $this->getVar('featured_set_items_as_search_result');
		$o_config = $this->getVar("config");
		$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
		if(!$vs_caption_template){
			$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
		}
		if($qr_res && $qr_res->numHits()){
?>   
			<div class="jcarousel-wrapper" style="overflow:hidden;">
				<!-- Carousel -->
				<div class="jcarousel">
					<ul>
<?php
						while($qr_res->nextHit()){
							if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.large</l>', array("checkAccess" => $va_access_values))){
								print "<li><div class='frontSlide'>".$vs_media;
								$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
								if($vs_caption){
									print "<div class='frontSlideCaption'>".$vs_caption."</div>";
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
				<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
				<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		
			
<?php
				}
?>
			</div><!-- end jcarousel-wrapper -->
<?php
		}
	}
	if($vb_item_output){
?>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.jcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
		
				/*
				 Prev control initialization
				 */
				$('.jcarousel-control-prev')
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
				$('.jcarousel-control-next')
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
				$('.jcarousel-pagination')
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
?>