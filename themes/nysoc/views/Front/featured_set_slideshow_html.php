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
	include_once(__CA_LIB_DIR__."/ca/Search/SetSearch.php");
	$o_set_search = new SetSearch();
	$qr_res = $o_set_search->search("ca_sets.display_homepage:yes", array('sort' => 'ca_sets.rank', 'sort_direction' => 'asc', 'checkAccess' => $va_access_values));
	
	
	if($qr_res && $qr_res->numHits()){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					$vn_i = 0;
					$va_slide_image = caGetThemeGraphic($this->request, 'discover.jpg'); 
					print "<li><div class='frontSlide'>".caNavLink($this->request, $va_slide_image, '', '', 'Gallery', 'Index');
					print caNavLink($this->request, "<div class='frontSlideCaption'><div class='setTitle'>Discover More</div><div class='setDescription'>Find curated content from the Society Library's Special Collections in our Featured Gallery.</div></div>", '', '', 'Gallery', 'Index');
					print "</div></li>";					
					while($qr_res->nextHit()){
						if($vs_media = $qr_res->get('ca_sets.set_media', array('version' => 'slideshow'))){
							print "<li><div class='frontSlide'>".caNavLink($this->request, $vs_media, '', '', 'Gallery', $qr_res->get('ca_sets.set_id'));
							print caNavLink($this->request, "<div class='frontSlideCaption'><div class='setTitle'>".$qr_res->get('ca_sets.preferred_labels')."</div><div class='setDescription'>".$qr_res->get('ca_sets.set_description')."</div></div>", '', '', 'Gallery', $qr_res->get('ca_sets.set_id'));
							print "</div></li>";
							if ($vn_i == 0) {
								print "<li><div class='frontSlide'>".caNavLink($this->request, caGetThemeGraphic($this->request, 'visualizations.png'), '', '', 'About', 'visualizations')."<div class='frontSlideCaption'><div class='setTitle'>".caNavLink($this->request, 'Visualization Tools', '', '', 'About', 'visualizations')."</div><div class='setDescription'>View complex data at a glance with customizable graphing and mapping applications.</div></div></div></li>";
							}
							$vb_item_output = true;
							$vn_i++;
						}
					}

?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if($vb_item_output){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev disabled"><i class="fa fa-angle-left"></i></a>
			<a href="#" onclick="$('.jcarousel-control-prev').removeClass('disabled');return false;" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		

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
				
					.on('jcarousel:targetin', 'li', function() {
						$(this).addClass('activeSlide');
					})
					.on('jcarousel:targetout', 'li', function() {
						$(this).removeClass('activeSlide');
					})
					.on('jcarousel:createend', function() {
						// Arguments:
						// 1. The method to call
						// 2. The index of the item (note that indexes are 0-based)
						// 3. A flag telling jCarousel jumping to the index without animation
						$(this).jcarousel('scroll', 1, true);
					})					
					.jcarousel({
						wrap: 'circular',
						center: true
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