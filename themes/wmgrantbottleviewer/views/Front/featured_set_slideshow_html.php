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
	$access_values = $this->getVar("access_values");
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$o_config = $this->getVar("config");
	$caption_template = $o_config->get("front_page_set_item_caption_template");
	$multiple_slides = $o_config->get("set_show_multiple_slides");
	if(!$caption_template){
		$caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
	if($qr_res && $qr_res->numHits()){
		$qr_res->seek(0);
?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10 my-5 py-5">
			<H2 class="mb-3"><?php print _t("Highlights"); ?></H2>  

			
			
<?php			
	if(!$multiple_slides){		
?>		
			<div id="carouselFeaturedSet" class="carousel slide">
				<div class="carousel-inner">
<?php
						$active = true;
						while($qr_res->nextHit()){
							if($vs_media = $qr_res->getWithTemplate('<l><img src="^ca_object_representations.media.large.url" class="d-block w-100" alt="^ca_objects.preferred_labels.name"></l>', array("checkAccess" => $access_values))){
								print "<div class='carousel-item".(($active) ? " active" : "")."'>".$vs_media;
								$vs_caption = $qr_res->getWithTemplate($caption_template);
								if($vs_caption){
									print "<div class='carousel-caption d-none d-md-block'>".$vs_caption."</div>";
								}
								print "</div>";
								$vb_item_output = true;
								$active = false;
							}
						}
?>
				</div><!-- end carousel-inner -->
<?php
			if($vb_item_output){
?>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselFeaturedSet" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden"><?php print _t("Previous"); ?></span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselFeaturedSet" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden"><?php print _t("Next"); ?></span>
				</button>
<?php
			}
?>
			</div><!-- end carousel -->
<?php
	}else{
?>		
		<div class="row mx-auto my-auto justify-content-center">
			<div id="carouselFeaturedSet" class="carousel slide multiSlideCarousel">
				<div class="carousel-inner" role="listbox">
<?php
						$active = true;
						while($qr_res->nextHit()){
							if($vs_media = $qr_res->getWithTemplate('<l><img src="^ca_object_representations.media.large.url" alt="^ca_objects.preferred_labels.name"></l>', array("checkAccess" => $access_values))){
								print "<div class='carousel-item".(($active) ? " active" : "")."'>".$vs_media;
								$vs_caption = $qr_res->getWithTemplate($caption_template);
								if($vs_caption){
									#print "<div class='carousel-caption'>".$vs_caption."</div>";
								}
								print "</div>";
								$vb_item_output = true;
								$active = false;
							}
						}
?>
				</div><!-- end carousel-inner -->
<?php
			if($vb_item_output){
?>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselFeaturedSet" data-bs-slide="prev" aria-label="Previous">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselFeaturedSet" data-bs-slide="next" aria-label="Next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
				</button>
<?php
			}
?>
			</div><!-- end carousel -->
		</div>
<script>
let items = document.querySelectorAll('.carousel.multiSlideCarousel .carousel-item')

items.forEach((el) => {
    const minPerSlide = 4
    let next = el.nextElementSibling
    for (var i=1; i<minPerSlide; i++) {
        if (!next) {
            // wrap carousel by using first child
        	next = items[0]
      	}
        let cloneChild = next.cloneNode(true)
        el.appendChild(cloneChild.children[0])
        next = next.nextElementSibling
    }
});
var myCarousel = document.getElementById('carouselFeaturedSet');


</script>
<style>
	@media (max-width: 767px) {
		.multiSlideCarousel .carousel-inner .carousel-item > div {
			display: none;
		}
		.multiSlideCarousel .carousel-inner .carousel-item > div:first-child {
			display: block;
		}
	}
	
	.multiSlideCarousel .carousel-inner .carousel-item.active,
	.multiSlideCarousel .carousel-inner .carousel-item-next,
	.multiSlideCarousel .carousel-inner .carousel-item-prev {
		display: flex;
	}
	.multiSlideCarousel .carousel-item img{
		height:400px;
		width:auto;
	}
	/* medium and up screens */
	@media (min-width: 768px) {
		
		.multiSlideCarousel .carousel-inner .carousel-item-end.active,
		.multiSlideCarousel .carousel-inner .carousel-item-next {
			transform: translateX(0%);
		}
		
		.multiSlideCarousel .carousel-inner .carousel-item-start.active, 
		.multiSlideCarousel .carousel-inner .carousel-item-prev {
			transform: translateX(-0%);
		}
	}
	
	.multiSlideCarousel .carousel-inner .carousel-item-end,
	.multiSlideCarousel .carousel-inner .carousel-item-start { 
		transform: translateX(0);
	}
</style>

<?php	
	}
?>
		</div>
	</div>
</div>

<?php
	}
?>