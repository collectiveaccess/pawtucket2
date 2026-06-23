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
	$vs_cache_key 			= $this->getVar('cacheKey');
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
	$vs_default_placeholder_tag = "<div class='multisearchImgPlaceholder'><div class='bResultItemImgPlaceholder'>".caGetThemeGraphic($this->request, 'KentlerLogoWhiteBG.jpg')."</div></div>";

	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<small class="pull-right">
<?php
				if(in_array($vs_block, $va_browse_types)){
?>
				<span class='multisearchFullResults'><?php print caNavLink($this->request, '<span class="glyphicon glyphicon-list"></span> '._t('Full results'), '', '', 'Search', $vs_block, array('search' => $vs_search)); ?></span> | 
<?php
				}
?>
				
				<span class='multisearchSort'><?php print _t("sort by:"); ?> <?php print $this->getVar("sortByControl"); ?></span>
				<?php print $this->getVar("sortDirectionControl"); ?>
			</small>
<?php
			if(in_array($vs_block, $va_browse_types)){
?>
				<?php print '<H3>'.caNavLink($this->request, $va_block_info['displayName'].' ('.$qr_results->numHits().')', '', '', 'Search', $vs_block, array('search' => $vs_search)).'</H3>'; ?>
<?php
			}else{
?>
				<H3><?php print $va_block_info['displayName']." (".$qr_results->numHits().")"; ?></H3>
<?php
			}
?>
			<div class='blockResults'><div id="<?php print $vs_block; ?>scrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div><div id="<?php print $vs_block; ?>scrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id='<?php print $vs_block; ?>Results' class='multiSearchResults'>
					<div class='blockResultsScroller'>
<?php
		}
		$vn_count = 0;
		#$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
?>
			<div class='<?php print $vs_block; ?>Result multisearchResult'>
<?php 
				$vs_image = $qr_results->get('ca_object_representations.media.widepreview', array("checkAccess" => $va_access_values));
				if(!$vs_image){
					#$t_list_item->load($qr_results->get("type_id"));
					#$vs_typecode = $t_list_item->get("idno");
					#if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
					#	$vs_image = "<div class='multisearchImgPlaceholder'>".$vs_type_placeholder."</div>";
					#}else{
						$vs_image = $vs_default_placeholder_tag;
					#}
				}
				print $qr_results->getWithTemplate('<l>'.$vs_image.'</l>', array("checkAccess" => $va_access_values));
				
				$vs_caption = "";
				if($vs_artist = $qr_results->get('ca_entities.preferred_labels.displayname', array("restrictToRelationshipTypes" => array("artist"), 'checkAccess' => $va_access_values))){
					$vs_caption = $vs_artist.", ";
				}
				$vs_caption .= "<i>".$qr_results->get("ca_objects.preferred_labels.name")."</i>, ";
				if($qr_results->get("ca_objects.date")){
					$vs_caption .= $qr_results->get("ca_objects.date").", ";
				}
				$vs_medium = "";
				if($qr_results->get("medium_text")){
					$vs_medium = $qr_results->get("medium_text");
				}else{
					if($qr_results->get("medium")){
						$vs_medium .= $qr_results->get("medium", array("delimiter" => ", ", "convertCodesToDisplayText" => true));
					}
				}
				if($vs_medium){
					$vs_caption .= $vs_medium.", ";
				}					
				if($qr_results->get("ca_objects.dimensions")){
					$vs_caption .= $qr_results->get("ca_objects.dimensions.dimensions_height")." X ".$qr_results->get("ca_objects.dimensions.dimensions_width").(($qr_results->get("ca_objects.dimensions.dimensions_length") ? " X ".$qr_results->get("ca_objects.dimensions.dimensions_length") : "")).".";
					
				}
				$vb_removed = false;
				if(strtolower($qr_results->get("ca_objects.removed.removal_text", array("convertCodesToDisplayText" => true))) == "yes"){
					$vb_removed = true;
				}
				if($qr_results->get("ca_objects.is_deaccessioned")){
					$vb_removed = true;
				}
				if($qr_results->get("ca_entities.entity_id", array("restrictToRelationshipTypes" => array("sold")))){
					$vb_removed = true;
				}
				if($vb_removed){
					$vs_caption .= "<br/>No longer available";
				}
?>
				<br/><?php print caDetailLink($this->request, $vs_caption, '', 'ca_objects', $qr_results->get("ca_objects.object_id")); ?>
			</div><!-- end blockResult -->
<?php
			$vn_count++;
			if ((!$vn_init_with_start && ($vn_count == $vn_hits_per_block)) || ($vn_init_with_start && ($vn_count >= $vn_init_with_start))) {break;} 
		}
?>
<?php	
		if (!$this->request->isAjax()) {
?>
					</div><!-- end blockResultsScroller -->
				</div>
			</div><!-- end blockResults -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#<?php print $vs_block; ?>Results').hscroll({
						name: '<?php print $vs_block; ?>',
						itemCount: <?php print $qr_results->numHits(); ?>,
						preloadCount: <?php print $vn_count; ?>,
						
						itemWidth: jQuery('.<?php print $vs_block; ?>Result').outerWidth(true),
						itemsPerLoad: <?php print $vn_hits_per_block; ?>,
						itemLoadURL: '<?php print caNavUrl($this->request, '*', '*', '*', array('block' => $vs_block, 'search'=> $vs_search)); ?>',
						itemContainerSelector: '.blockResultsScroller',
						
						sortParameter: '<?php print $vs_block; ?>Sort',
						sortControlSelector: '#<?php print $vs_block; ?>_sort',
						
						sortDirection: '<?php print $this->getVar("sortDirection"); ?>',
						sortDirectionParameter: '<?php print $vs_block; ?>SortDirection',
						sortDirectionSelector: '#<?php print $vs_block; ?>_sort_direction',
						
						scrollPreviousControlSelector: '#<?php print $vs_block; ?>scrollButtonPrevious',
						scrollNextControlSelector: '#<?php print $vs_block; ?>scrollButtonNext',
						cacheKey: '<?php print $vs_cache_key; ?>'
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