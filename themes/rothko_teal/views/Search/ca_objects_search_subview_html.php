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


	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<small class="pull-right">
<?php
				if(in_array($vs_block, $va_browse_types)){
?>
				<span class='multisearchFullResults'><?php print caNavLink($this->request, ''._t('Filter results'), '', '', 'Search', '{{{block}}}', array('search' => $vs_search)); ?></span> 
<?php
				}
?>
				
				<!--<span class='multisearchSort'><?php print _t("sort by:"); ?> {{{sortByControl}}}</span>
				{{{sortDirectionControl}}}-->
			</small>
			<H3><?php print caNavLink($this->request, $va_block_info['displayName']."&nbsp;&nbsp;<span class='resultCount'>(".$qr_results->numHits().")</span>", '', '', 'Search', '{{{block}}}', array('search' => $vs_search)); ?></H3>
			<div id='browseResultsContainer'>
<?php
		}
		$vn_count = 0;
		$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
				$vn_id 					= $qr_results->get("ca_objects.object_id");
				$vn_parent_id = $qr_results->get("ca_objects.parent_id");
				$t_parent = new ca_objects($vn_parent_id);
				if ($vs_catno = $qr_results->get('ca_objects.institutional_id')) {
					$vs_catno = "<div class='catno'>".$vs_catno."</div>";
				}
				$vs_label_detail_link 	= "<span class='resultLabel'>".caDetailLink($this->request, $qr_results->get("ca_objects.preferred_labels.name"), '', 'ca_objects', $vn_id)."</span>";
				
				$vs_link_text = "";
				if ($va_date = $qr_results->get('ca_objects.display_date')) {
					$vs_link_text.= "<p>".$va_date."</p>";
				}
				if ($va_collection = $t_parent->getWithTemplate('<unit relativeTo="ca_objects_x_collections"><if rule="^ca_objects_x_collections.current_collection =~ /yes/"><unit relativeTo="ca_collections">^ca_collections.preferred_labels</unit></if></unit>')) {
					$vs_link_text.= "<p>".$va_collection."</p>";
				}				

				$vs_thumbnail = "";
				$vs_type_placeholder = "";
				$vs_typecode = "";
				$t_list_item->load($qr_results->get("type_id"));
				$vs_typecode = $t_list_item->get("idno");
				$vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon");
				$vb_has_image = true;
				if(!($vs_thumbnail = $qr_results->getMediaTag('ca_object_representations.media', 'small', array("checkAccess" => $va_access_values)))){
					$vb_has_image = false;
					if($vs_type_placeholder){
						$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
					}else{
						$vs_thumbnail = $vs_default_placeholder_tag;
					}
				}
				if(!$this->request->getParameter("openResultsInOverlay", pInteger)){
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $vn_id);
				}else{
					$vs_rep_detail_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'objects', $vn_id, array('overlay' => 1))."\"); return false;'>".$vs_thumbnail."</a>";
				}
				$vs_add_to_set_link = "<div class='addTo'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array('object_id' => $vn_id))."\"); return false;' title='Add to lightbox'><i class='fa fa-suitcase'></i></a></div>";
				
				$vs_rep_id = $qr_results->get("ca_object_representations.representation_id");
				$vs_obj_id = $qr_results->get("ca_objects.object_id");
				$vs_download_link = "";
				if ($vs_rep_id) {
					$vs_download_link = caNavLink($this->request, '<i style="padding-left:10px;" class="fa fa-download"></i>', 'multiDl', '', 'Detail', 'DownloadRepresentation', array('representation_id' => $vs_rep_id, 'object_id' => $vs_obj_id, 'download' => 1, 'version' => 'original'));
				}	
				
				$vs_compare_link = ($vb_has_image ? "<a href='#' class='compare_link' data-id='object:{$vn_id}'><div class='compareIcon' aria-hidden='true'></div></a>" : '');			
				print "
	<div class='bResultItemCol col-xs-6 col-sm-4 col-md-3'>
		<div class='bResultItem' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
			<div class='bResultItemContent'><div class='imgContainer'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div></div>
				<div class='bResultItemText'>
					{$vs_label_detail_link}
					{$vs_link_text}
					{$vs_catno}
					{$vs_compare_link}
				</div><!-- end bResultItemText -->
			</div><!-- end bResultItemContent -->
		</div><!-- end bResultItem -->
	</div><!-- end col -->";
				

			$vn_count++;
			if ($vn_count == $vn_hits_per_block) {break;} 
		}
		print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $this->getVar("cacheKey"), 'block' => $vs_block, 'search'=> $vs_search));
		
		if (!$this->request->isAjax()) {
?>
					</div><!-- end browseResultsContainer -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 60,
			nextSelector: 'a.jscroll-next'
		});
	});

</script><?php
		}
	}
	
?>