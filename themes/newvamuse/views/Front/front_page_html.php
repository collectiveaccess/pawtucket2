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
 	global $g_ui_locale;
 	$va_access_values = caGetUserAccessValues($this->request);
?>
	<div class="row">
		<div class=" leader">
<?php
		print caGetThemeGraphic($this->request, 'leader2.jpg');
?>
			<div class='collectConnect'><?= _t('Collect Connect Share'); ?></div>		
		</div>
	</div><!-- end row leader -->
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 homeText">
			<H1><?= $this->getVar('homepage_leader_'.$g_ui_locale); ?></H1>
		</div><!--end col-sm-8-->	
	</div><!-- end row text -->
	<div class="row members">
		<h2><?= _t('Featured Contributors'); ?></h2>
		<div class="jcarousel-wrapper">
			<div class="jcarousel">
				<ul>
<?php
 			$t_set = new ca_sets();
 			$t_set->load(array('set_code' => 'memberFeatured'));
			$va_member_ids = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1));
			foreach ($va_member_ids as $va_member_id => $thing) {
				$t_member = new ca_entities($va_member_id);
				print "<li><div class='memberTile'>";
				
				// ICONLARGE
				#print "<div class='memberImage'>".caNavLink($this->request, $t_member->get('ca_entities.mem_inst_image', array('version' => 'iconlarge')), '', '', 'Detail', 'entities/'.$va_member_id)."</div>";
				print "<div class='memberImageCrop'>".caNavLink($this->request, $t_member->get('ca_entities.mem_inst_image', array('version' => 'medium')), '', '', 'Detail', 'entities/'.$va_member_id)."</div>";
				print "<p>".caNavLink($this->request, $t_member->get('ca_entities.preferred_labels'), '', '', 'Detail', 'entities/'.$va_member_id)."</p>";
				print "</div></li>";
			}

?>	
				</ul>
			</div>	<!-- end jc  -->
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		
			<!-- Pagination -->
			<p class="jcarousel-pagination">
			<!-- Pagination items will be generated in here -->
			</p>			
		</div>	<!-- end jc wrapper -->
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.jcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular'
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
	</div><!-- end row members -->
	<div class="row curated">
<?php	
 		$t_curated = new ca_sets();
 		$t_curated->load(array('set_code' => 'curated'));
		$va_curated_ids = $t_curated->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1));
?>				
		<h2><?php print $t_curated->get('ca_sets.preferred_labels'); ?></h2>
		<div class="curated jcarousel-wrapper">
			<div class="curated jcarousel">
				<ul>
<?php

			if(is_array($va_curated_ids) && sizeof($va_curated_ids)){
				foreach ($va_curated_ids as $va_curated_id => $thing) {
					$t_curated = new ca_objects($va_curated_id);
					print "<li><div class='memberTile'>";
					// ICONLARGE
					#print "<div class='memberImage'>".caNavLink($this->request, $t_curated->get('ca_object_representations.media.iconlarge'), '', '', 'Detail', 'objects/'.$va_curated_id)."</div>";
					print "<div class='memberImageCrop'>".caNavLink($this->request, $t_curated->get('ca_object_representations.media.medium'), '', '', 'Detail', 'objects/'.$va_curated_id)."</div>";
					print "<p>".caNavLink($this->request, $t_curated->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_curated_id)."</p>";
					print "</div></li>";
				}
			}
?>	
				</ul>
			</div>	<!-- end jc  -->
			<!-- Prev/next controls -->
			<a href="#" class="curated jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="curated jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		
			<!-- Pagination -->
			<p class="curated jcarousel-pagination">
			<!-- Pagination items will be generated in here -->
			</p>			
		</div>	<!-- end jc wrapper -->
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.curated.jcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
		
				/*
				 Prev control initialization
				 */
				$('.curated.jcarousel-control-prev')
					.on('.curated.jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('.curated.jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '-=1'
					});
		
				/*
				 Next control initialization
				 */
				$('.curated.jcarousel-control-next')
					.on('.curated.jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('.curated.jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '+=1'
					});
		
				/*
				 Pagination initialization
				 */
				$('.curated.jcarousel-pagination')
					.on('.curated.jcarouselpagination:active', 'a', function() {
						$(this).addClass('active');
					})
					.on('.curated.jcarouselpagination:inactive', 'a', function() {
						$(this).removeClass('active');
					})
					.jcarouselPagination({
						// Options go here
					});
			});
		</script>	
	</div><!-- end row curated -->

	<div class="row cats" >
		<h2><?= _t('Browse Themes'); ?></h2>
		<div class="col-sm-1"></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'architecturedark.png')."<p>"._t('Architecture')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/470'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'artdark.png')."<p>"._t('Art')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/474'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'communicationsdark.png')."<p>"._t('Communications')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/473'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'farmingdark.png')."<p>"._t('Farming')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/469'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'fishingdark.png')."<p>"._t('Fishing')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/468'); ?></div>
		<div class="col-sm-1"></div>
	</div><!-- end row cats -->
	<div class="row cats" style="margin-bottom:70px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'household_lifedark.png')."<p>"._t('Household Life')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/466'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'industrydark.png')."<p>"._t('Industry')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/472'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'militarydark.png')."<p>"._t('Military')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/471'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'recreationdark.png')."<p>"._t('Recreation')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/475'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'transportationdark.png')."<p>"._t('Transportation')."</p>", '', 'Browse/objects', 'facet', 'novastory_category_facet/id/467'); ?></div>
		
		<div class="col-sm-1"></div>
	</div>	<!-- end row cats -->
	<div class="row recent">
		<h2><?= _t('What\'s New'); ?></h2>
		<div class="recent jcarousel-wrapper">
			<div class="recent jcarousel">
				<ul>
<?php
		$t_object = new ca_objects();
		$va_recently_added_items = $t_object->getRecentlyAddedItems(20, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));	
		$va_labels = $t_object->getPreferredDisplayLabelsForIDs(array_keys($va_recently_added_items));
 		$va_media = $t_object->getPrimaryMediaForIDs(array_keys($va_recently_added_items), array('iconlarge', 'medium'), array("checkAccess" => $va_access_values));
		foreach($va_recently_added_items as $vn_object_id => $va_object_info){
			print "<li><div class='memberTile'>";
			//ICON LARGE
			#print "<div class='memberImage'>".caNavLink($this->request, $va_media[$vn_object_id]['tags']['iconlarge'], '', '', 'Detail', 'objects/'.$vn_object_id)."</div>";
			print "<div class='memberImageCrop'>".caNavLink($this->request, $va_media[$vn_object_id]['tags']['medium'], '', '', 'Detail', 'objects/'.$vn_object_id)."</div>";
			print "<p>".caNavLink($this->request, $va_labels[$vn_object_id], '', '', 'Detail', 'objects/'.$vn_object_id)."</p>";

			print "</div></li>";
		}			
?>
				</ul>
			</div>	<!-- end jc  -->
			<!-- Prev/next controls -->
			<a href="#" class="recent jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="recent jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		
			<!-- Pagination -->
			<p class="recent jcarousel-pagination">
			<!-- Pagination items will be generated in here -->
			</p>			
		</div>	<!-- end jc wrapper -->	
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.recent.jcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
		
				/*
				 Prev control initialization
				 */
				$('.recent.jcarousel-control-prev')
					.on('recent.jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('recent.jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '-=1'
					});
		
				/*
				 Next control initialization
				 */
				$('.recent.jcarousel-control-next')
					.on('recent.jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('recent.jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '+=1'
					});
		
				/*
				 Pagination initialization
				 */
				$('.recent.jcarousel-pagination')
					.on('recent.jcarouselpagination:active', 'a', function() {
						$(this).addClass('active');
					})
					.on('recent.jcarouselpagination:inactive', 'a', function() {
						$(this).removeClass('active');
					})
					.jcarouselPagination({
						// Options go here
					});
			});
		</script>
	</div><!-- end row recent -->
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8 offset-sm-1 supportText">
			<h2><?= _t('Support the Museums'); ?></h2>
			<?= _t('Help preserve Nova Scotia\'s rich history. Museums across the province depend on generous contributions from dedicated volunteers and community members. Contact your local museum to see what opportunities there are for you.'); ?>
			<br/><br/><br/>
		</div>
	</div><!-- end row fund -->