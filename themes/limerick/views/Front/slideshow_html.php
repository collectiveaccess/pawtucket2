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
	$qr_res = $this->getVar('set_items_as_search_result');
	$o_config = $this->getVar("config");
	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
	$set_code = $this->getVar('set_code');
	$t_set = $this->getVar('t_set');
	if($qr_res && $qr_res->numHits()){
?>   
		<div id="<= $set_code;? >" class="jcarousel-wrapper" style="margin: 10px;">
			<h1><?= $t_set->get('ca_sets.preferred_labels'); ?></h1>
			<div class="jcarousel">
				<ul>
<?php
					while($qr_res->nextHit()){
						if($qr_res->get("ca_object_representations.media.large")){
							if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.large</l>', array("checkAccess" => $va_access_values))){
								print "<li><div class='frontSlide'>".$vs_media;
								$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
								if($vs_caption){
									#print "<div class='frontSlideCaption'>".$vs_caption."</div>";
								}
								print "</div></li>";
								$vb_item_output = true;
							}
						}
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if($vb_item_output){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left" aria-label="<?php print _t("Previous"); ?>"></i></a>
			<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right" aria-label="<?php print _t("Next"); ?>"></i></a>
		
			<!-- Pagination -->
			<p class="jcarousel-pagination">
			<!-- Pagination items will be generated in here -->
			</p>
<?php
			}
?>
		</div><!-- end jcarousel-wrapper -->
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('#<?= $set_code; ?> .jcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
		
				/*
				 Prev control initialization
				 */
				$('#<?= $set_code; ?> .jcarousel-control-prev')
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
				$('#<?= $set_code; ?> .jcarousel-control-next')
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
				$('#<?= $set_code; ?> .jcarousel-pagination')
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
