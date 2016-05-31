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
				<span class='multisearchFullResults'><?php print caNavLink($this->request, '<span class="glyphicon glyphicon-list"></span> '._t('Full results'), '', '', 'Search', '{{{block}}}', array('search' => $vs_search)); ?></span> | 
<?php
				}
?>
				
				<span class='multisearchSort'><?php print _t("sort by:"); ?> {{{sortByControl}}}</span>
				{{{sortDirectionControl}}}
			</small>
<?php
			if(in_array($vs_block, $va_browse_types)){
?>
				<?php print '<H3>'.caNavLink($this->request, $va_block_info['displayName'].' ('.$qr_results->numHits().')', '', '', 'Search', '{{{block}}}', array('search' => $vs_search)).'</H3>'; ?>
<?php
			}else{
?>
				<H3><?php print $va_block_info['displayName']." (".$qr_results->numHits().")"; ?></H3>
<?php
			}
?>
			<div class='blockResults'><div id="{{{block}}}scrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div><div id="{{{block}}}scrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id='{{{block}}}Results' class='multiSearchResults'>
					<div class='blockResultsScroller'>
<?php
		}
		$vn_count = 0;
		$vn_row = 0;
		$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
			if ($vn_row == 0) {
				print "<div class='objectSet'>";
			}
?>
			<div class='{{{block}}}Result multisearchResult'>
<?php 			$va_has_access = 0;
				if ($vs_image = $qr_results->get('ca_object_representations.media.preview', array("checkAccess" => $va_access_values))) {
					$va_has_access = 1;
				}
				$va_rep_info = $qr_results->getMediaInfo("ca_object_representations.media", "preview");
				#print 'width'.$va_rep_info["WIDTH"];
				if (($va_rep_info["HEIGHT"] > 112) && $va_has_access == 1) {
					$vs_image = "<img style='max-height:112px; width:auto;' src='".$qr_results->getMediaUrl("ca_object_representations.media", "preview")."'>";
				}
				if(!$vs_image){
					$t_list_item->load($qr_results->get("type_id"));
					$vs_typecode = $t_list_item->get("idno");
					if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
						$vs_image = "<div class='multisearchImgPlaceholder'>".$vs_type_placeholder."</div>";
					}else{
						$vs_image = $vs_default_placeholder_tag;
					}
				}
				print $qr_results->getWithTemplate('<l>'.$vs_image.'</l>', array("checkAccess" => $va_access_values));

				print "<p>".$qr_results->get('ca_objects.preferred_labels.name', array('returnAsLink' => true))."</p>";
				if ($qr_results->get('ca_objects.idno')) {
					print "<p>ID: ".$qr_results->get('ca_objects.idno')."</p>";
				}
				if ($qr_results->get('ca_objects.date')) {
					print "<p>".$qr_results->get('ca_objects.date')."</p>";
				}
				if ($va_camera = $qr_results->get('ca_objects.camera', array('convertCodesToDisplayText' => true))) {
					print "<p>Camera angle: ".$va_camera."</p>";
				} else {$va_camera = null;}
?>				
			</div><!-- end blockResult -->
<?php
			$vn_count++;
			$vn_row++;
			if ((!$vn_init_with_start && ($vn_count == $vn_hits_per_block)) || ($vn_init_with_start && ($vn_count >= $vn_init_with_start))) {break;} 
		
			if ($vn_row == 3) {
				print "</div><!-- end objectSet -->";
				$vn_row = 0;
			}
		}
		if ($vn_row != 0) {
			print "</div><!-- end objectSet -->";
		}	
		if (!$this->request->isAjax()) {
?>
					</div><!-- end blockResultsScroller -->
				</div>
			</div><!-- end blockResults -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#{{{block}}}Results').hscroll({
						name: '{{{block}}}',
						itemCount: <?php print $qr_results->numHits(); ?>,
						preloadCount: <?php print $vn_count; ?>,
						
						itemsPerColumn: 3,
						itemWidth: jQuery('.objectSet').outerWidth(true),
						itemsPerLoad: <?php print $vn_hits_per_block; ?>,
						itemLoadURL: '<?php print caNavUrl($this->request, '*', '*', '*', array('block' => $vs_block, 'search'=> $vs_search)); ?>',
						itemContainerSelector: '.blockResultsScroller',
						
						sortParameter: '{{{block}}}Sort',
						sortControlSelector: '#{{{block}}}_sort',
						
						sortDirection: '{{{sortDirection}}}',
						sortDirectionParameter: '{{{block}}}SortDirection',
						sortDirectionSelector: '#{{{block}}}_sort_direction',
						
						scrollPreviousControlSelector: '#{{{block}}}scrollButtonPrevious',
						scrollNextControlSelector: '#{{{block}}}scrollButtonNext',
						cacheKey: '{{{cacheKey}}}'
					});
				});
			</script>
<?php
		}else{
			# --- need to change sort direction to catch default setting for direction when sort order has changed
			if($this->getVar("sortDirection") == "desc"){
?>
				<script type="text/javascript">
					jQuery('#<?php print $vs_block; ?>_sort_direction').find('span').removeClass('glyphicon-sort-by-alphabet').addClass('glyphicon-sort-by-alphabet-alt');
				</script>
<?php
			}else{
?>
				<script type="text/javascript">
					jQuery('#<?php print $vs_block; ?>_sort_direction').find('span').removeClass('glyphicon-sort-by-alphabet-alt').addClass('glyphicon-sort-by-alphabet');
				</script>
<?php
			}
		}
	}
	
	TooltipManager::add('#caObjectsFullResults', 'Click here for full results');
?>