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
	$va_item_ids = $this->getVar('featured_set_item_ids');
	if(is_array($va_item_ids) && sizeof($va_item_ids)){
		$t_object = new ca_objects();
		$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("mediumlarge"), array('checkAccess' => caGetUserAccessValues($this->request)));
		$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
	}
	if(is_array($va_item_media) && sizeof($va_item_media)){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					foreach($va_item_media as $vn_object_id => $va_media){
						print "<li>".caDetailLink($this->request, $va_media["tags"]["mediumlarge"], '', 'ca_objects', $vn_object_id)."</li>";
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if(sizeof($va_item_media) > 1){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
			<a href="#" class="jcarousel-control-next">&rsaquo;</a>
		
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
<div class="container">
	<div class="row">
	<div class="col-lg-12">
	<?php
	 	print $this->render("Front/featured_set_slideshow_2col_html.php");
?>
	</div>
	
		<div class="col-sm-4">
		<h2>Vision</h2><hr>
			<H1>To shape and enrich the quality of life for the residents and visitors of Grand Valley State University and to become a leader in the areas of art appreciation and interdisciplinary education for the local community.</H1>
		</div><!--end col-sm-8-->
	<div class="col-sm-4">
<?php
	 	print $this->render("Front/spotlight_set_grid_html.php");
?>
	</div> <!--end col-sm-4 -->	
	
		<div class="col-sm-4">
			<h2>Browse by Topic (<a href="../Gallery/Index">View all</a>)</h2>
			<?php
			print caGetGallerySetsAsList($this->request, "nav nav-pills nav-stacked", array("limit" => 5));
			?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->