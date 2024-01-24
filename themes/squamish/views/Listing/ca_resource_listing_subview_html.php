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
	<div class="row bg_dark_eye pageHeaderRow">
		<div class="col-sm-12">
			<H1>External Resources</H1>
			<p>
			{{{resources_intro}}}
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
			if($i == 3){
				print "</div><div class='row'>";
				$i = 0;
			}
			$vs_image = $qr_list->getWithTemplate("<unit relativeTo='ca_objects'>^ca_object_representations.media.large</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
			$vs_desc = strip_tags($qr_list->get("ca_objects.description"));
			if(mb_strlen($vs_desc) > 250){
				$vs_desc = substr($vs_desc, 0, 250)."...";
			}

			$va_col_content[$vn_i] .= "
				<div class='listingContainer listingContainerResources'>
					<div class='listingContainerImgContainer'>".caDetailLink($this->request, $vs_image, '', 'ca_objects', $qr_list->get("object_id"))."</div>
					<div class='listingContainerDesc'>
						<div class='listingTitle'>".$qr_list->getWithTemplate('<l>^ca_objects.preferred_labels.name</l>')."</div>
						<small>".$qr_list->getWithTemplate('<ifdef code="ca_objects.website"><a href="^ca_objects.website" target="_blank">View Website <span class="glyphicon glyphicon-new-window"></span></a></ifdef>')."</small>
						<p>
							".$vs_desc."
						</p>
						<p class='text-center'>
							".caDetailLink($this->request, "Learn More", 'btn-default btn-md', 'ca_objects', $qr_list->get("object_id"))."
						</p>
					</div>
				</div>";

			$vn_i++;
			if($vn_i == $vn_cols){
				$vn_i = 0;
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