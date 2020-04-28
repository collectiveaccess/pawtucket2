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
	$va_featured_ids = $this->getVar('featured_set_item_ids');
	$o_config = $this->getVar("config");
	$t_set = $this->getVar("featured_set");
	$va_set_item_captions = array();
	if($t_set && $t_set->get("set_id")){
		$va_items = $t_set->getItems();
		if(is_array($va_items) && sizeof($va_items)){
			$va_items = caExtractValuesByUserLocale($va_items);
			# --- get set item captions
			foreach($va_items as $va_item){
				if($va_item["caption"] && ($va_item["caption"] != "[BLANK]")){
					$va_set_item_captions[$va_item["row_id"]] = $va_item["caption"];
				}
			}
		}
	}
	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
	if($qr_res && $qr_res->numHits()){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel frontcarousel">
				<ul>
<?php
					$va_thumbnails = array();
					$i = 0;
					while($qr_res->nextHit()){
						if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.large</l>', array("checkAccess" => $va_access_values))){
							print "<li id='slide".$qr_res->get("ca_objects.object_id")."'><div class='frontSlide'>".$vs_media;
							$vs_set_item_caption = $va_set_item_captions[$qr_res->get("object_id")];
							$vs_caption = $qr_res->getWithTemplate($vs_caption_template).(($vs_set_item_caption) ? ", ".$vs_set_item_caption : "");
							if($vs_caption){
								print "<div class='frontSlideCaption'>".$vs_caption."</div>";
							}
							print "</div></li>";
							$vb_item_output = true;
							$va_thumbnails["slide".$qr_res->get("ca_objects.object_id")] = $qr_res->get('ca_object_representations.media.icon', array("checkAccess" => $va_access_values));
							$i++;
						}
						if($i == 9){
							break;
						}
					}
?>
				</ul>
			</div><!-- end jcarousel -->
			
<?php
			if($vb_item_output){
?>
				<!-- Prev/next controls -->
				<a href="#" class="jcarousel-control-prev" aria-label="previous"><i class="fa fa-angle-left"></i></a>
				<a href="#" class="jcarousel-control-next" aria-label="next"><i class="fa fa-angle-right"></i></a>
<?php
				print "<div class='rowSmallPadding'>";
				print "<H1 id='featuredLabel'>Featured Fossils</H1>";
				
				foreach($va_thumbnails as $vn_slide_id => $vs_thumbnail){
					print "<div class='col-xs-4 col-sm-1 col-md-1 col-lg-1 smallpadding frontCarouselThumbnail'><a href='#' onClick='$(\".jcarousel\").jcarousel(\"scroll\", $(\"#".$vn_slide_id."\"), false); return false;'>".$vs_thumbnail."</a></div>";
				}
				print "</div>";
			}
?>
		</div><!-- end jcarousel-wrapper -->
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.jcarousel')
					.jcarousel({
						// Options go here
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