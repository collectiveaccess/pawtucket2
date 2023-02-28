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
	$va_access_values = caGetUserAccessValues($this->request);
?>
	<div class="row">
		<div class="col-sm-12 frontSearchCollage">
			<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
				<div class="frontSearchCollageOutline">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search All Collections" name="search">
					</div>
					<button type="submit"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</form>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 homeText">
			<h1>Explore the collections of history and cultural organizations across Minnesota</h1>
		</div>
	</div>
<?php
	$qr_members = ca_entities::find(["type_id" => "member"], ["returnAs" => "searchResult", 'sort' => 'ca_entities.preferred_labels.displayname']);
	if ($qr_members) {
		print "<div class='row members'>";
		print '<div class="containerWrapper">';
		print "<div class='col-sm-12'><h2>Contributing Institutions</h2></div>";
		//print '<div class="col-sm-12">';
		
		
		while ($qr_members->nextHit()) {
			
			// print "<div class='col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 text-center' style='height: 300px;'>";
// 			print "<div class='memberImage'>".caDetailLink($this->request, $qr_members->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values)), '', 'ca_entities', $qr_members->get('ca_entities.entity_id'))."</div>";
// 			print "<div class='memberCaption'>".caDetailLink($this->request, $qr_members->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values)), '', 'ca_entities', $qr_members->get('ca_entities.entity_id'))."</div>";
// 			print "</div>";
?>
			<div class="col-md-3 archivalCollectionWrapper">
				<div class="archivalCollection">
					<?= caDetailLink($this->request, $qr_members->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values)), '', 'ca_entities', $qr_members->get('ca_entities.entity_id')); ?>
				</div>
			</div>		
<?php
		}
				
		
		print "</div><!-- end containerWrapper -->";
		print "</div><!-- end row -->";
	}
?>	
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.membersjcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
		
				/*
				 Prev control initialization
				 */
				$('.membersjcarousel-control-prev')
					.on('.membersjcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('.membersjcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '-=1'
					});
		
				/*
				 Next control initialization
				 */
				$('.membersjcarousel-control-next')
					.on('.membersjcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('.membersjcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '+=1'
					});
		
				/*
				 Pagination initialization
				 */
				$('.membersjcarousel-pagination')
					.on('.membersjcarouselpagination:active', 'a', function() {
						$(this).addClass('active');
					})
					.on('.membersjcarouselpagination:inactive', 'a', function() {
						$(this).removeClass('active');
					})
					.jcarouselPagination({
						// Options go here
					});
			});
		</script>	
	
	<div class="row purple">
		<div class="containerWrapper">
			<div class="col-sm-10 col-sm-offset-1">
				<H1 style="color: #fff;">{{{homepage_text}}}</H1>
			</div><!--end col-sm-8-->	
		</div>
	</div><!-- end row -->

	<div class="row hpAboutText">
		<div class="containerWrapper">
			<div class="col-sm-12 col-md-6 col-lg-6 col-left">
				<br/><br/><br/><H2>SUPPORT OUR MUSEUMS</H2><p>{{{homepage_support_text}}}</p><br/>
			</div><!--end col-sm-6-->
			<div class="col-sm-12 col-md-6 col-lg-6 col-right">
				<br/><br/><br/><H2>WHO WE ARE</H2><p>{{{homepage_who_text}}}</p><br/>
			</div><!--end col-sm-6-->	
		</div>
	</div><!-- end row -->