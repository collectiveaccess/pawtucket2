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
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
	if($qr_res && $qr_res->numHits()){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					while($qr_res->nextHit()){
						if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.mediumlarge</l>', array("checkAccess" => $va_access_values))){
							print "<li><div class='frontSlide'>".$vs_media;
							print "<div class='frontSlideInfo'>";
							if($qr_res->get("ca_objects.preferred_labels.name")){
								print "<H2>".$qr_res->get("ca_objects.preferred_labels.name")."</H2>";
							}
							if($qr_res->get("ca_objects.idno")){
								print "<p><b>Accession Number:</b> ".$qr_res->get("ca_objects.idno")."</p>";
							}
							if($qr_res->get("ca_objects.public_title")){
								print "<p><b>Title:</b> ".$qr_res->get("ca_objects.public_title")."</p>";
							}
							if($qr_res->get("ca_object_lots.credit_line")){
								print "<p><b>Credit Line: </b><i>".$qr_res->get("ca_object_lots.credit_line")."</i></p>";
							}
							if($qr_res->get("ca_object_representations.photo_credit")){
								print "<p><b>Photo Credit:</b> ".$qr_res->get("ca_object_representations.photo_credit");
							}
							print "<br/><br/>".caDetailLink($this->request, _t("VIEW FULL RECORD"), 'btn btn-default', 'ca_objects',  $qr_res->get("object_id"));
							print "</div>";
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
			<div class="jcarousel-controls">
				<a href="#" class="jcarousel-control-prev-text">&laquo; Previous</a> / <a href="#" class="jcarousel-control-next-text">Next &raquo;</a>
			</div>
<?php
			}
?>
		</div><!-- end jcarousel-wrapper -->
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
					Set width of li to width of container and do it on page resize
				*/
				
				$('.front .jcarousel-wrapper li').width($('.jcarousel-wrapper').width());
				$( window ).resize(function() {
					$('.front .jcarousel-wrapper li').width($('.jcarousel-wrapper').width());
				});
				/*
				Carousel initialization
				*/
				$('.jcarousel')
					.jcarousel({
						wrap: 'circular',
						animation: 'slow'
					})
					.jcarouselAutoscroll({
						interval: 5000,
						target: '+=1',
						autostart: true
					})
				;
				/*
				 Prev control initialization
				 */
				$('.jcarousel-control-prev-text')
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
				$('.jcarousel-control-next-text')
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
					
					
				
				$('.jcarousel-control-prev-text').bind('click', function() {
					$('.jcarousel').jcarouselAutoscroll('stop');
				});
				$('.jcarousel-control-next-text').bind('click', function() {
					$('.jcarousel').jcarouselAutoscroll('stop');
				});
			});
		</script>
<?php
	}
?>