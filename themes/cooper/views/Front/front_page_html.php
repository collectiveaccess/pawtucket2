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
	$va_access_values = $this->getVar('access_values');
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	
	$o_galleryConfig = caGetGalleryConfig();
	$t_list = new ca_lists();
	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_galleryConfig->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id);
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "icon", "checkAccess" => $va_access_values));
		
		$o_front_config = caGetFrontConfig();
		$vs_front_page_set = $o_front_config->get('front_page_set_code');
		$vb_omit_front_page_set = (bool)$o_galleryConfig->get('omit_front_page_set_from_gallery');
		foreach($va_sets as $vn_set_id => $va_set) {
			if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
				unset($va_sets[$vn_set_id]); 
			}
			$va_first_item = $va_set_first_items[$vn_set_id];
			$va_first_item = array_shift($va_first_item);
			$vn_item_id = $va_first_item["item_id"];
			
		}
	}
?>
	<div class="frontTopContainer">
		<div class="frontTop">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-7 col-sm-12 col-xs-12">
						<H1>The Student <br/>Work Collection</H1>
						<p>{{{home_page_intro}}}</p>
						<div class="jcarousel-paginationHero jcarousel-pagination"><!-- Pagination items will be generated in here --></div>

					</div><!-- end col -->
					<div class="col-lg-7 col-md-5 col-sm-7 col-xs-12">
						<?php print ($qr_res->numHits() < 1) ? caGetThemeGraphic($this->request, 'placeholder.jpg') : ""; ?>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end container -->
		</div>
		</div><!-- end container -->
	</div><!-- end frontTopContainer -->
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>

		<div id="gallerySlideShows">

			<!-- gallery sets loaded here -->
<?php
	#$va_sets = $this->getVar("sets");
	#$va_first_items_from_set = $this->getVar("first_items_from_sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		$va_all_ids = array();
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 frontGalleries">
<?php
			if(sizeof($va_sets) > 1){
				$i = 1;
				foreach($va_sets as $vn_set_id => $va_set){
					$t_set = new ca_sets($vn_set_id);
					$qr_set_items = caMakeSearchResult("ca_objects", array_keys($t_set->getItemRowIDs()));
					if($qr_set_items->numHits()){
?>
						<div class="frontGallerySlideLabel"><?php print caNavLink($this->request, _t("See All")." <i class='fa fa-caret-down'></i>", "btn-default", "", "Search", "projects", array("search" => "ca_sets.set_id:".$vn_set_id)); ?><?php print $va_set["name"]; ?> <span class='frontGallerySlideLabelSub'>/ <?php print $qr_set_items->numHits(); ?> projects</span></div>
						<div class="jcarousel-wrapper">
							<!-- Carousel -->
							<div class="jcarousel gallery<?php print $i; ?>">
								<ul>
<?php
									$c = 0;
									while($qr_set_items->nextHit()){
										$va_all_ids[] = $qr_set_items->get("ca_objects.object_id");
										$vs_image = $qr_set_items->getWithTemplate("<unit relativeTo='ca_objects.children' sort='ca_objects.idno'><if rule='^ca_objects.primary_item =~ /Yes/'>^ca_object_representations.media.widepreview</if></unit>", array("checkAccess" => $va_access_values));
										if(!$vs_image){
											$vs_image = $qr_set_items->getWithTemplate("<unit relativeTo='ca_objects.children' sort='ca_objects.idno' limit='1'>^ca_object_representations.media.widepreview</unit>", array("checkAccess" => $va_access_values));
										}
										if($vn_c = strpos($vs_image, ";")){
											$vs_image = substr($vs_image, 0, $vn_c);
										}
										if(!$vs_image){
											$vs_image = caGetThemeGraphic($this->request, 'placeholder.jpg', array("style" => "opacity:.5;"));
										}
										print "<li><div class='slide'>".caDetailLink($this->request, $vs_image, "", "ca_objects", $qr_set_items->get("ca_objects.object_id"))."<div class='slideCaption'>".caDetailLink($this->request, $qr_set_items->get("ca_objects.preferred_labels.name"), "", "ca_objects", $qr_set_items->get("ca_objects.object_id"))."</div></div></li>";
										$c++;
										if($c == 25){
											break;
										}
									}
?>
								</ul>
							</div><!-- end jcarousel -->
							<!-- Prev/next controls -->
							<a href="#" class="jcarousel-control-prev previous<?php print $i; ?>"><i class="fa fa-caret-left"></i></a>
							<a href="#" class="jcarousel-control-next next<?php print $i; ?>"><i class="fa fa-caret-right"></i></a>
						</div><!-- end jcarousel-wrapper -->
						<script type='text/javascript'>
							jQuery(document).ready(function() {
								/*
								Carousel initialization
								*/
								$('.gallery<?php print $i; ?>')
									.jcarousel({
										// Options go here
										auto: 1,
										wrap: "circular",
										animation:"slow"
									}).jcarouselAutoscroll({
										interval: 0,
										target: '+=1',
										autostart: false
									});
									
									$('.gallery<?php print $i; ?>').jcarousel({
										animation: {
											duration: 1500, /* lower = faster animation */
											easing:   'linear',
											complete: function() {
											}
										}
									});
								/*
								 Prev control initialization
								 */
								$('.previous<?php print $i; ?>')
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
								$('.next<?php print $i; ?>')
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
							
$(".previous<?php print $i; ?>").hover(function () {
    $('.gallery<?php print $i; ?>').jcarouselAutoscroll('reload', {
		interval: 0,
		target: '-=1',
		autostart: false
	});
    $(".gallery<?php print $i; ?>").jcarouselAutoscroll('start');
},function () {
    $(".gallery<?php print $i; ?>").jcarouselAutoscroll('stop');
});
$(".next<?php print $i; ?>").hover(function () {
    $('.gallery<?php print $i; ?>').jcarouselAutoscroll('reload', {
		interval: 0,
		target: '+=1',
		autostart: false
	});
    $(".gallery<?php print $i; ?>").jcarouselAutoscroll('start');
},function () {
    $(".gallery<?php print $i; ?>").jcarouselAutoscroll('stop');
});
					
							});
						</script>
		<?php
							$i++;
					}
				}
			}
?>		
					
		</div><!--end col-sm-12-->
	</div><!-- end row -->
</div> <!--end container-->
<?php
	
		$o_context = new ResultContext($this->request, 'ca_objects', 'front');
		$o_context->setAsLastFind();
		$o_context->setResultList($va_all_ids);
		$o_context->saveContext();
	}
?>
</div>