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
	
	
	$t_featured_share = new ca_sets();
	$t_featured_share->load(array('set_code' => $this->request->config->get('featured_share_set_name')));
	# Enforce access control on set
 	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured_share->get("access"), $va_access_values))){
  		$vn_featured_share_set_id = $t_featured_share->get("set_id");
 		$va_featured_share_ids = array_keys(is_array($va_tmp = $t_featured_share->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());	// These are the object ids in the set
 	}
	if(!is_array($va_featured_share_ids) || (sizeof($va_featured_share_ids) == 0)){
		# put a random object in the features variable
		$va_featured_share_ids = array_keys($t_object->getRandomItems(10, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1)));
	}
	$qr_res_share = caMakeSearchResult("ca_objects", $va_featured_share_ids);
	
	# --- set for featured member - set name assigned in app.conf - featured_member_set_name - this is an ENTITY set
	$t_featured_member = new ca_sets();
	$t_featured_member->load(array('set_code' => $this->request->config->get('featured_member_set_name')));
	# Enforce access control on set
 	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured_member->get("access"), $va_access_values))){
  		$vn_featured_member_set_id = $t_featured_member->get("set_id");
 		$va_featured_member_ids = array_keys(is_array($va_tmp = $t_featured_member->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());	// These are the entity ids in the set
 	}
	$t_entity = new ca_entities($va_featured_member_ids[0]);
	$vn_featured_member_id = $va_featured_member_ids[0];
	$vs_featured_member_image = $t_entity->get("mem_inst_image", array("version" => "frontpage", "return" => "tag"));
	$vs_featured_member_name = $t_entity->getLabelForDisplay();

	
	if($qr_res && $qr_res->numHits()){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				
<?php
					while($qr_res->nextHit()){
						if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.frontpage</l>', array("checkAccess" => $va_access_values))){
							print "<div><div class='frontSlide'>".$vs_media;
							$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
							if($vs_caption){
								print "<div class='frontSlideCaption'>".$vs_caption."</div>";
							}
							print "</div></div>";
							$vb_item_output = true;
						}
					}
					# --- featured member inst
					if($vs_featured_member_image){
						print "<div><div class='frontSlide'>".caDetailLink($this->request, $vs_featured_member_image, '', 'ca_entities', $vn_featured_member_id);
						print "<div class='frontSlideCaption'><b>"._t("Featured Member")."</b><br/>".caDetailLink($this->request, $vs_featured_member_name, '', 'ca_entities', $vn_featured_member_id)."</div>";
						print "</div></div>";
					}
					if($qr_res_share->numHits()){
						while($qr_res_share->nextHit()){
							if($vs_media = $qr_res_share->getWithTemplate('<l>^ca_object_representations.media.frontpage</l>', array("checkAccess" => $va_access_values))){
								print "<div><div class='frontSlide'>".$vs_media;
								print "<div class='frontSlideCaption'>".caDetailLink($this->request, "<b>"._t("Share Your Knowledge")."</b><br/>"._t("Help us improve this record. Do you know more about this item?"), '', 'ca_objects', $qr_res_share->get("ca_objects.object_id"))."</div>";
								print "</div></div>";
								$vb_item_output = true;
								break;
							}
						}
					}
?>
				
			</div><!-- end jcarousel -->
		</div><!-- end jcarousel-wrapper -->

<script type="text/javascript">
$(document).ready(function() {
   $('.jcarousel').cycle({
               fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
               speed:  1000,
               timeout: 4000
       });
});
</script>
<?php
	}
?>