<?php
/** ---------------------------------------------------------------------
 * themes/default/Listings/listing_html : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
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
 
 	$va_lists = $this->getVar('lists');
 	$va_type_info = $this->getVar('typeInfo');
 	$va_listing_info = $this->getVar('listingInfo');
 	$va_access_values = $this->getVar("access_values");
?>
	<div class="row tanBg exploreRow exploreResourcesRow exploreDigitalExhibitionsRow">
		<div class="col-sm-12">
			<H1>Digital Exhibitions</H1>
			<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pretium risus ante, sed consectetur ipsum venenatis id. In convallis tortor turpis, sit amet mollis velit cursus quis. Proin elementum enim eu massa maximus accumsan. Proin venenatis elit et quam finibus eleifend. Sed eros diam, convallis id mauris eget, fringilla posuere ante. Pellentesque accumsan justo eu mauris facilisis, a maximus arcu maximus. Suspendisse potenti. Quisque a accumsan diam. Nunc ut sagittis arcu, vel tincidunt tortor. Pellentesque fermentum orci dui. Integer massa mi, placerat sit amet viverra a, lobortis sed risus. Quisque accumsan enim vel purus tempus, vel rhoncus massa rutrum.
			</p>
		</div>
	</div>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
<?php
	$vn_i = 0;
	$vn_cols = 3;
	$va_col_content = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			if($this->request->user->hasRole("admin") || (strToLower($qr_list->get('ca_occurrences.preview_only', array("convertCodesToDisplayText" => true))) != "yes")){
				if($i == 3){
					print "</div><div class='row'>";
					$i = 0;
				}
				$vs_image = $qr_list->getWithTemplate("<unit relativeTo='ca_objects' restrictToRelationshipTypes='featured'>^ca_object_representations.media.medium</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
				if(!$vs_image){
					$vs_image = $qr_list->getWithTemplate("<unit relativeTo='ca_objects'>^ca_object_representations.media.medium</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
				}
				$vs_desc = $qr_list->get("ca_occurrences.description");
				#if(mb_strlen($vs_desc) > 250){
				#	$vs_desc = substr($vs_desc, 0, 250)."...";
				#}

				$va_col_content[$vn_i] .= "
					<div class='listingContainer'>
						<div class='listingContainerImgContainer'>".caDetailLink($this->request, $vs_image, '', 'ca_occurrences', $qr_list->get("occurrence_id"))."</div>
						<div class='listingContainerDesc'>
							<H2>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>')."</H2>
							<p>
								".$vs_desc."
							</p>
							<p class='text-center'>
								".caDetailLink($this->request, "View Exhibition", 'btn-default btn-md', 'ca_occurrences', $qr_list->get("occurrence_id"))."
							</p>
						</div>
					</div>";

				$vn_i++;
				if($vn_i == $vn_cols){
					$vn_i = 0;
				}
			}
		}
	}
?>
			<div class='row'>
<?php
	foreach($va_col_content as $vs_col_content){
		print "<div class='col-sm-4'>".$vs_col_content."</div>";
	}
?>
			</div><!-- end row -->


		</div>
	</div>