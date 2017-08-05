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
?>
	<div class="frontTopContainer">
		<div class="frontTop">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-1 col-lg-4 col-sm-5 col-xs-12">
						<H1>The Student<br/>Work Collection</H1>
						<p>An archive of student design projects dating from the 1930’s through the present. This material documents over 4,000 student projects spanning more than eight decades of architectural pedagogy at The Cooper Union. As a whole, these records provide a comprehensive narrative of the School’s evolving, radical and influential approach to architectural education.</p>
					</div><!-- end col -->
					<div class="col-lg-6 col-sm-7 col-xs-12">
						<?php print caGetThemeGraphic($this->request, 'frontImage.jpg'); ?>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end container -->
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 frontTopSlideCaption">
					Project title: Nine Square Grid | Author: McNeur, Lorna | Course: ARCH 111 Architectonics | Academic Year: 1976-77
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
		
		
		
		
	<div><!-- end frontTopContainer -->
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>

		<div id="gallerySlideShows"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#gallerySlideShows").load("<?php print caNavUrl($this->request, '', 'Gallery', 'Index'); ?>");
			});
		</script>

<div class="container">
	<div class="row">
		<div class="col-sm-12 frontGalleries">
<!--
			<div class="frontGallerySlideLabel">Feature Label</div>
			<div class="jcarousel-wrapper">
			<div class="jcarousel gallery1">
				<ul>
					<li><div class='frontGallerySlide'><?php print caGetThemeGraphic($this->request, 'frontImage.jpg'); ?><div class='frontGallerySlideCaption'>caption</div></div></li>
					<li><div class='frontGallerySlide'><?php print caGetThemeGraphic($this->request, 'frontImage.jpg'); ?><div class='frontGallerySlideCaption'>caption</div></div></li>
					<li><div class='frontGallerySlide'><?php print caGetThemeGraphic($this->request, 'frontImage.jpg'); ?><div class='frontGallerySlideCaption'>caption</div></div></li>
					<li><div class='frontGallerySlide'><?php print caGetThemeGraphic($this->request, 'frontImage.jpg'); ?><div class='frontGallerySlideCaption'>caption</div></div></li>
					<li><div class='frontGallerySlide'><?php print caGetThemeGraphic($this->request, 'frontImage.jpg'); ?><div class='frontGallerySlideCaption'>caption</div></div></li>
					<li><div class='frontGallerySlide'><?php print caGetThemeGraphic($this->request, 'frontImage.jpg'); ?><div class='frontGallerySlideCaption'>caption</div></div></li>
					<li><div class='frontGallerySlide'><?php print caGetThemeGraphic($this->request, 'frontImage.jpg'); ?><div class='frontGallerySlideCaption'>caption</div></div></li>
					<li><div class='frontGallerySlide'><?php print caGetThemeGraphic($this->request, 'frontImage.jpg'); ?><div class='frontGallerySlideCaption'>caption</div></div></li>
				</ul>
			</div>
			<a href="#" class="jcarousel-control-prev previous1"><i class="fa fa-caret-left"></i></a>
			<a href="#" class="jcarousel-control-next next1"><i class="fa fa-caret-right"></i></a>
		</div>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.gallery1')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
		
				/*
				 Prev control initialization
				 */
				$('.previous1')
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
				$('.next1')
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
			});
		</script>
-->		

		</div><!--end col-sm-12-->
	</div><!-- end row -->
</div> <!--end container-->