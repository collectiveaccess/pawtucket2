<?php
/** ---------------------------------------------------------------------
 * themes/itinera/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 	require_once(__CA_LIB_DIR__."/ca/Search/EntitySearch.php");
 
	$va_access_values = $this->getVar("access_values");
	//$qr_res = $this->getVar('featured_set_items_as_search_result');
	$o_config = $this->getVar("config");
	//$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	//if(!$vs_caption_template){
	//	$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	//}
	
	$o_entity_search = new EntitySearch();
	$qr_res = $o_entity_search->search("ca_entities.tour_yn:957", array('sort' => 'ca_entities.preferred_labels.surname', 'sort_direction' => 'asc', 'checkAccess' => array(1)));

	if($qr_res && $qr_res->numHits()){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php

					while ($qr_res->nextHit()) {
						$vs_image_tag = $qr_res->get('ca_entities.agentMedia', array('version' => 'mediumlarge'));
						$vn_entity_id = $qr_res->get('ca_entities.entity_id');
						
						print "<li class='frontSlide'><div class='frontSlide'>";
						print "<div style='margin:10px;' class='clearfix'><div class='frontSlideImage'>";
						print caNavLink($this->request, $vs_image_tag, '', 'Itinera', 'Tours', 'Index', array('id' => $vn_entity_id));
							
						if (!empty($vs_image_source = $qr_res->get('ca_entities.sourceUrlSet.sourceURL_URL'))) {
							print "<a href='{$vs_image_source}' class='frontSlideImageSource'>Source</a>";
						} else {
							print "<span>&nbsp;</span>";
						}
						print "</div>";
							
							print "<div class='frontSlideCaption'>";
							print "<p class='frontSlideArtistName'>".$qr_res->get('ca_entities.preferred_labels')."</p>";
							$va_entity_roles = $qr_res->get('ca_entities.agentLifeRoleSet.agentLifeRoleType', array('useSingular' => true, 'convertCodesToDisplayText' => true, 'returnAsArray' => 'true'));
				
							print "<p class='frontSlideArtistRoles'>".join(", " , $va_entity_roles)."</p>";
 
							$va_dates_array = $qr_res->get('ca_entities.agentLifeDateSet', array('returnAsArray' => true));
							foreach ($va_dates_array as $va_dates) {
								$va_date_set[] = $va_dates['agentLifeDisplayDate'];
							}
							print "<p>".join($va_date_set, ' - ')."</p>";
							print "<p>".$qr_res->get('ca_entities.generalNotes')."</p>";
							
							
							print "<p class='frontSlideButtons'>";
							print caGetThemeGraphic($this->request, 'seeicon.png', array('class' => 'frontButton'));
							print caNavLink($this->request, 'See Route', 'frontButton', '', 'Routes', 'Index', array('id' => $vn_entity_id));
							
							
							print caGetThemeGraphic($this->request, 'seeicon.png', array('class' => 'frontButton'));
							print caNavLink($this->request, 'See Network', 'frontButton', '', 'Travelers', 'Index', array('id' => $vn_entity_id));
							
							print "</p>";
							
							$va_date_set = null;
						print "</div></div>";
						print "</div></li>";
						
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
				$('.jcarousel')
					.jcarousel({
						// Options go here
					}).jcarouselAutoscroll({
						interval: 5000,
						target: '+=1',
						autostart: true
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