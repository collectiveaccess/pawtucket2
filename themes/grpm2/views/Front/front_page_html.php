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
									<?php print caGetThemeGraphic($this->request, 'grand-rapids-public-museum.jpg'); ?>
								</div>
								<div class="col-xs-12 col-sm-7 col-md-7">
									<div class="slideTextRight">
										<h2>
											Welcome to Grand Rapid Public Museum's<br/>Digital Collections
										</h2>
										<p>
											Aliquam eget augue iaculis, volutpat est eget, malesuada orci. Nulla mi lectus, aliquet ac facilisis id, malesuada sit amet dolor. Nam varius ex at mauris porta, id elementum purus sollicitudin. 
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
											Browse Featured Galleries
										</h2>
										<p>
											Aliquam eget augue iaculis, volutpat est eget, malesuada orci. Nulla mi lectus, aliquet ac facilisis id, malesuada sit amet dolor. Nam varius ex at mauris porta, id elementum purus sollicitudin. 
										</p>
										<p class="text-center">
											<?php print caNavLink($this->request, _t("Get Started"), "btn-default", "", "Gallery", "Index"); ?>
										</p>
									</div>
								</div>
								<div class="col-xs-12 col-sm-5 col-md-5">
									<?php print caGetThemeGraphic($this->request, 'grand-rapids-public-museum.jpg'); ?>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class='frontSlide'>
							<div class="row">
								<div class="col-xs-12 col-sm-5 col-md-5">
									<?php print caGetThemeGraphic($this->request, 'grand-rapids-public-museum.jpg'); ?>
								</div>
								<div class="col-xs-12 col-sm-7 col-md-7">
									<div class="slideTextRight">
										<h2>
											Get Involved!
										</h2>
										<p>
											Aliquam eget augue iaculis, volutpat est eget, malesuada orci. Nulla mi lectus, aliquet ac facilisis id, malesuada sit amet dolor. Nam varius ex at mauris porta, id elementum purus sollicitudin. 
										</p>
										<p class="text-center">
											<?php print "<a href='#' class='btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a>"; ?>
										</p>
									</div>
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
			</script>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<H1>{{{frontpage_tagline}}}</H1>
		</div><!--end col-sm-12-->
	</div><!-- end row -->
	<div class="container"><div class="row">
		<div class="col-sm-12 bgGray">
<?php
			print $this->render("Front/gallery_slideshow_html.php");
?>
		</div>
	</div></div>
	<div class="row">
		<div class="col-sm-12">
			<H3>Featured Items</H3>
		</div>
<?php
			print $this->render("Front/featured_set_grid_html.php");
?>
		</div>
	</div>
