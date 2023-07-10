<?php
/** ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
 	$va_access_values = caGetUserAccessValues();
	$va_lists = $this->getVar('lists');
 	$va_type_info = $this->getVar('typeInfo');
 	$va_listing_info = $this->getVar('listingInfo');
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
?>
<div class="row projectsList"><div class="col-sm-12 offset-xl-1 col-xl-10">

<?php 
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		
		print "<h1>{$va_listing_info['displayName']}</h1>\n";
?>
		<div class="row rowWidePadding">
<?php		
		while($qr_list->nextHit()) {
			print "<div class='col-md-4 colWidePadding '><div class='project'>";
			$va_images = explode(";",$qr_list->getWithTemplate("<ifcount code='ca_objects' min='1' restrictToRelationshipTypes='featured'><unit relativeTo='ca_objects' length='5' restrictToRelationshipTypes='featured'><ifdef code='ca_object_representations.media.widepreview'>^ca_object_representations.media.widepreview</ifdef></unit></ifcount>"));
			$i = 1;
			$vs_slides = "";
			foreach($va_images as $vs_image){
				if($vs_image){
					$vs_image = str_replace("<img", "<img class='d-block w-100'", $vs_image);
					$vs_image = caDetailLink($vs_image, '', 'ca_collections', $qr_list->get("ca_collections.collection_id"));
					$vs_slides .= "<div class='carousel-item".(($i == 1) ? " active" : "")."'>".$vs_image."</div>";
					$i++;
				}
			}
			if($vs_slides){
?>
				<div class='carousel slide' id='projectSlideshow<?php print $qr_list->get("collection_id"); ?>' data-interval='false'>
					<div class='carousel-inner'><?php print $vs_slides; ?>
						<a class="carousel-control-prev" href="#projectSlideshow<?php print $qr_list->get("collection_id"); ?>" role="button" data-slide="prev">
							<ion-icon name="ios-arrow-back"></ion-icon>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#projectSlideshow<?php print $qr_list->get("collection_id"); ?>" role="button" data-slide="next">
							<ion-icon name="ios-arrow-forward"></ion-icon>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
<?php
			}else{
				print "<div class='projectSlideshow'></div>";
			}
			print $qr_list->getWithTemplate("<l>^ca_collections.preferred_labels.name</l>");
			print "</div></div>";
		}
	}
?>
</div></div>