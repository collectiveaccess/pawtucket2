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
	$t_set = $this->getVar("featured_set");
	$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("checkAccess" => $this->opa_access_values)));
	$va_set_items_by_row_id = array();
	foreach($va_set_items as $vn_item_id => $va_set_item_info){
		$va_set_items_by_row_id[$va_set_item_info["row_id"]] = $vn_item_id;
	}
	if($qr_res && $qr_res->numHits()){
?>   
<div class="frontGrid mt-4">
	<H2 class="mb-3">Featured Student Work</H2>
				
<?php
		$i = $vn_col = 0;
		while($qr_res->nextHit()){
			if($vs_media = $qr_res->get('ca_object_representations.media.page', array("checkAccess" => $va_access_values, "class" => "object-fit-cover w-100"))){
				$vn_set_item_id = $va_set_items_by_row_id[$qr_res->get('ca_objects.object_id')];
				$t_set_item = new ca_set_items($vn_set_item_id);
				$vs_caption = "";
				if($t_set_item->get('ca_set_items.preferred_labels') && ($t_set_item->get('ca_set_items.preferred_labels') != "[BLANK]")){
					$vs_caption = "<div class='fs-5 fw-noraml pt-1'>".$t_set_item->get('ca_set_items.preferred_labels')."</div>";
				}
				if($vn_col == 0){
					print "<div class='row'>";
				}
				print "<div class='col-12 col-sm-6'>";
				print $qr_res->getWithTemplate("<div class='mb-4'><l class='text-decoration-none'>".$vs_media."<div class='fw-semibold pt-2'>".$qr_res->get("ca_objects.preferred_labels.name")."</div>".$vs_caption."</ifdef></l></div>");
				print "</div>";
				$vb_item_output = true;
				$i++;
				$vn_col++;
				if($vn_col == 2){
					print "</div>";
					$vn_col = 0;
				}
			}
			if($i == 2){
				break;
			}
		}
		if($vn_col > 0){
			print "</div><!-- end row -->";
		}
?>
</div>
<?php
	}
?>