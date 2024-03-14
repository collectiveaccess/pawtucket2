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
	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
	if($qr_res && $qr_res->numHits()){
?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10 py-5 text-center">
			<H2 class="mb-3"><?php print _t("Highlights"); ?></H2>  

			<div id="carouselFeaturedSet" class="carousel slide carousel-dark">
				<div class="carousel-inner">
<?php
						$active = true;
						while($qr_res->nextHit()){
							if($vs_media = $qr_res->getWithTemplate('<l aria-label="go to detail page"><img src="^ca_object_representations.media.medium.url" class="d-block w-100 h-auto" alt="^ca_objects.preferred_labels.name"></l>', array("checkAccess" => $va_access_values))){
								print "<div class='carousel-item".(($active) ? " active" : "")."'>".$vs_media;
								$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
								if($vs_caption){
									print "<div class='carousel-caption d-none d-md-block bg-light'>".$vs_caption."</div>";
								}
								print "</div>";
								$vb_item_output = true;
								$active = false;
							}
						}
?>
				</div><!-- end jcarousel-inner -->
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
		</div>
	</div>
</div>

<?php
	}
?>