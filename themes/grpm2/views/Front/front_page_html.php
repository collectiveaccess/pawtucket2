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
<div class="row">
	<div class="col-sm-12 bgLightBlue">
		<div class="jcarousel-wrapper mainSlideShow">
			<!-- Carousel -->
			<div class="jcarousel mainSlide">
				<ul id="hpSlides">
					<li>
						<div class='frontSlide'>
							<div class="row">
								<div class="col-xs-12 col-sm-5 col-md-5">
									<?php print caGetThemeGraphic($this->request, 'welcome.jpg'); ?>
								</div>
								<div class="col-xs-12 col-sm-7 col-md-7">
									<div class="slideTextRight">
										<h2>
											Welcome to Grand Rapid Public Museum's<br/>Digital Collections
										</h2>
										<p>
											The Grand Rapids Public Museum preserves a Collection of over 250,000 artifacts and scientific specimens. The Museum is continuing to add new content for students, teachers and researchers around the world to explore the Digital Collection.
										</p>
										<p class="text-center">
											<?php print caNavLink($this->request, _t("Get Started"), "btn-default", "", "Browse", "objects"); ?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class='frontSlide'>
							<div class="row">
								<div class="col-xs-12 col-sm-7 col-md-7">
									<div class="slideTextLeft">
										<h2>
											Featured Galleries
										</h2>
										<p>
											The Galleries are curated collections of artifacts and specimens that tell stories. These educational resources were created and shared by teachers and curators.
										</p>
										<p class="text-center" style="line-height:2em;">
											<?php print caNavLink($this->request, _t("Curator Galleries"), "btn-default", "", "Gallery", "Index"); ?><br/><?php print caNavLink($this->request, _t("Teacher Created Galleries"), "btn-default", "", "TeacherGallery", "Index"); ?>
										</p>
									</div>
								</div>
								<div class="col-xs-12 col-sm-5 col-md-5">
									<?php print caGetThemeGraphic($this->request, 'explore.jpg'); ?>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class='frontSlide'>
							<div class="row">
								<div class="col-xs-12 col-sm-5 col-md-5">
									<?php print caGetThemeGraphic($this->request, 'gallery.jpg'); ?>
								</div>
								<div class="col-xs-12 col-sm-7 col-md-7">
									<div class="slideTextRight">
										<h2>
											Explore
										</h2>
										<p>
											There are many ways to browse the Grand Rapids Public Museum’s Digital Collection!
										</p>
										<p class="text-center" style="line-height:2em;">
<?php
											print caNavLink($this->request, _t("Collections"), "btn-default", "", "Browse", "collections")." ".
													caNavLink($this->request, _t("Exhibits & Programs"), "btn-default", "", "Browse", "occurrences")."<br/>".
													caNavLink($this->request, _t("Makers & Donors"), "btn-default", "", "Browse", "entities")." ".
													caNavLink($this->request, _t("Objects"), "btn-default", "", "Browse", "objects")." ";
?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class='frontSlide'>
							<div class="row">
								<div class="col-xs-12 col-sm-7 col-md-7">
									<div class="slideTextLeft">
										<h2>
											Get Involved!
										</h2>
										<p>
											Login and curate your own Collections. Save and share your favorites. Leave a comment to share your story about an artifact.
										</p>
										<p class="text-center">
<?php
											if($this->request->isLoggedIn()){
												$va_lightboxDisplayName = caGetLightboxDisplayName();
												$vs_lightbox_sectionHeading = ucFirst($va_lightboxDisplayName["section_heading"]);
												print caNavLink($this->request, $vs_lightbox_sectionHeading, 'btn-default', '', 'Lightbox', 'Index', array());
											}else{
												print "<a href='#' class='btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a>";
											}
?>

										</p>
									</div>
								</div>
								<div class="col-xs-12 col-sm-5 col-md-5">
									<?php print caGetThemeGraphic($this->request, 'involved.jpg'); ?>
								</div>
							</div>
						</div>
					</li>			
				</ul>
			</div><!-- end jcarousel -->
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev mainSlideNav"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="jcarousel-control-next mainSlideNav"><i class="fa fa-angle-right"></i></a>
		

		</div><!-- end jcarousel-wrapper -->
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<!-- Pagination -->
			<p class="jcarousel-pagination mainSlideNav">
			<!-- Pagination items will be generated in here -->
			</p>
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
						}).jcarouselAutoscroll({
							interval: 7000,
							target: '+=1',
							autostart: true
						});
        
						$('.mainSlide').hover(function() {
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
							// Options go here
							target: '-=1'
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
							// Options go here
							target: '+=1'
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
					/*
					setInterval("$('.jcarousel').jcarousel('scroll', '+=1')", 4000);
					*/
			</script>
		</div>
	</div>
<?php
	$vs_tagline = $this->getVar("frontpage_tagline");
	if($vs_tagline){
?>
	<div class="row">
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<H1><?php print $vs_tagline; ?></H1>
		</div><!--end col-sm-12-->
	</div><!-- end row -->
<?php
	}else{
		print "<div class='row collectionLinksSpacer'><div class='col-sm-12'></div></div>";
	}
?>
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="row collectionLinks">
				<div class="col-xs-12 col-sm-4">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'Collections_Culture_620X620.jpg'), "", "", "Browse", "collections", array("facet" => "type_facet", "id" => 208)); ?>
				</div>
				<div class="col-xs-12 col-sm-4">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'Collections_History_620X620.jpg'), "", "", "Browse", "collections", array("facet" => "type_facet", "id" => 88)); ?>
				</div>
				<div class="col-xs-12 col-sm-4">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'Collections_Science_620X620.jpg'), "", "", "Browse", "collections", array("facet" => "type_facet", "id" => 207)); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="container"><div class="row">
		<div class="col-sm-12">
<?php
			print $this->render("Front/gallery_slideshow_html.php");
?>
		</div>
	</div></div>
