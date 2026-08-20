<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_objects_search_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
	$qr_results 		= $this->getVar('result');
	$va_block_info 		= $this->getVar('blockInfo');
	$vs_block 			= $this->getVar('block');
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_hits_per_block 	= (int)$this->getVar('itemsPerPage');
	$vb_has_more 		= (bool)$this->getVar('hasMore');
	$vs_search 			= (string)$this->getVar('search');
	$vn_init_with_start	= (int)$this->getVar('initializeWithStart');
	$va_access_values = caGetUserAccessValues($this->request);
	$o_config = caGetSearchConfig();
	$o_browse_config = caGetBrowseConfig();
	$va_browse_types = array_keys($o_browse_config->get("browseTypes"));
	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='multisearchImgPlaceholder'>".$vs_default_placeholder."</div>";
	$vs_caption_template = $va_block_info["caption_template"];
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
	$num_results_display = $vn_hits_per_block;
	if($vn_hits_per_block > $qr_results->numHits()){
		$num_results_display = $qr_results->numHits();
	}	
	if ($qr_results->numHits() > 0) {
?>
		<H2><div class='multisearchViewAll'><?php print caNavLink($this->request, 'See All <i class="fa fa-caret-down"></i>', 'btn-default', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search)));?></div>
<?php

		print caNavLink($this->request, $va_block_info['displayName'].' <span class="resultCount"> / '.$num_results_display.' of '.$qr_results->numHits().' exhibition'.(($num_results_display > 1) ? "s" : "").'</span>', '', '', 'Search', '{{{block}}}', array('search' => $vs_search));
?>
		</H2>
			<div class='multisearchResults objects'>
					<div class='row'>
<?php
		$vn_count = 0;
		$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
?>
			<div class='col-sm-6 col-md-3'>
<?php 
						$vs_thumbnail = $qr_results->getWithTemplate("<unit relativeTo='ca_occurrences.children' sort='ca_occurrences.idno'><unit relativeTo='ca_objects' sort='ca_objects.idno' delimiter='|'><if rule='^ca_objects.primary_item =~ /Yes/'>^ca_object_representations.media.widepreview</if></unit></unit>", array("checkAccess" => $va_access_values));
						if(!$vs_thumbnail){
							$vs_thumbnail = $qr_results->getWithTemplate("<unit relativeTo='ca_occurrences.children' sort='ca_occurrences.idno' limit='1'><unit relativeTo='ca_objects' sort='ca_objects.idno' limit='1' delimiter='|'>^ca_object_representations.media.widepreview</unit></unit>", array("checkAccess" => $va_access_values));
						}
						if($vn_p = strpos($vs_thumbnail, "|")){
							$vs_thumbnail = substr($vs_thumbnail, 0, $vn_p);
						}
						if(!$vs_thumbnail){
							$t_list_item->load($qr_results->get("type_id"));
							$vs_typecode = $t_list_item->get("idno");
							if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
								$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png').$vs_type_placeholder."</div>";
							}else{
								$vs_thumbnail = $vs_default_placeholder_tag;
							}
						}
						$vs_info = null;
						$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);

						print "<div class='slide'>".caDetailLink($this->request, $vs_thumbnail, "", "ca_occurrences", $qr_results->get("ca_occurrences.occurrence_id"))."<div class='slideCaption'>".caDetailLink($this->request, $qr_results->get("ca_occurrences.preferred_labels.name"), "", "ca_occurrences", $qr_results->get("ca_occurrences.occurrence_id"))."</div></div>";






?>
			</div><!-- end col -->
<?php
			$vn_count++;
			if ($vn_count == $vn_hits_per_block) {break;} 
		}
?>
					</div><!-- end row -->
			</div>
		
			<div class='allLink'><?php print caNavLink($this->request, 'all '.$va_block_info['displayName'].' results', '', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search)));?></div>

<?php
	}	
?>