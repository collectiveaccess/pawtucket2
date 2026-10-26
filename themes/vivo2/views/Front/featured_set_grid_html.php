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
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);

	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
	if($qr_res && $qr_res->numHits()){
?>   
<div class="frontGrid"><H2>Highlights</H2>
<?php
		$i = $vn_col = 0;
		while($qr_res->nextHit()){
			if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.widepreview</l>', array("checkAccess" => $va_access_values))){
				if($vn_col == 0){
					print "<div class='row lessGutter'>";
				}
					
				print "<div class='col-sm-4 col-md-4'><div class='resultTile'>".$vs_media;
				$vs_caption = $qr_res->getWithTemplate("<l><div class='caption'>".$vs_caption_template."</div></l>");
				if($vs_caption){
					print $vs_caption;
				}
				$vs_add_to_set_link = "<a href='#' class='setLink' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array("front" => "1", "object_id" => $qr_res->get("ca_objects.object_id")))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
				$vs_idno_link = "";
				if($vs_tmp = $qr_res->getWithTemplate("<ifdef code='ca_objects.idno'>^ca_objects.idno%truncate=15&ellipsis=1</ifdef>")){
					$vs_idno_link = caDetailLink($this->request, $vs_tmp, '', "ca_objects", $qr_res->get("ca_objects.object_id"), array(), array("aria-label" => "Record Identifier"));
				}
				print "<div class='tools'>".$vs_add_to_set_link."<div class='identifier'>".$vs_idno_link."</div></div>";
				print "</div></div>";
				$vb_item_output = true;
				$i++;
				$vn_col++;
				if($vn_col == 3){
					print "</div>";
					$vn_col = 0;
				}
			}
			if($i == 6){
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