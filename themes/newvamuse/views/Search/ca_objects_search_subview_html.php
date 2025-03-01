<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_objects_search_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2014 Whirl-i-Gig
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
				
				<span class='multisearchSort'><?php print _t("sort by:"); ?> {{{sortByControl}}}</span>
				{{{sortDirectionControl}}}
			</small>
<?php
			if(in_array($vs_block, $va_browse_types)){

				print '<H3>'.caNavLink($this->request, $va_block_info['displayName'].' ('.$qr_results->numHits().')', '', '', 'Search', '{{{block}}}', array('search' => $vs_search));
?>
				 <span class='pipe'>|</span> <span class='multisearchFullResults'><?php print caNavLink($this->request, _t('Filter results'), '', '', 'Search', '{{{block}}}', array('search' => $vs_search, 'sort' => 'Relevance')); ?><i class="fa fa-external-link"></i></span> 
<?php				
				print '</H3>'; 
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
		$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
?>
			<div class='{{{block}}}Result multisearchResult'>
<?php 
				$vs_image = $qr_results->get('ca_object_representations.media.widepreview', array("checkAccess" => $va_access_values));
				if(!$vs_image){
					# --- get the placeholder graphic from the novamuse theme
					$va_themes = $qr_results->get("ca_objects.novastory_category", array("returnAsArray" => true));  
					$vs_placeholder = "";
					if(sizeof($va_themes)){
						$t_list_item = new ca_list_items();
						foreach($va_themes as $k => $vs_list_item_id){
							$t_list_item->load($vs_list_item_id);
							if(caGetThemeGraphic($this->request, $t_list_item->get("idno").'.png')){
								$vs_image = "<span class='imgPlaceholder'>".caGetThemeGraphic($this->request, $t_list_item->get("idno").'.png', array('class' => 'placeholder'))."</span>";
								$vn_padding_top_bottom = 5;
							}
						}
					}
					if(!$vs_image){
						$vs_image = caGetThemeGraphic($this->request, 'placeholders/placeholder.png');
						$vn_padding_top_bottom = 5;
					}
				}
				print $qr_results->getWithTemplate('<l>'.$vs_image.'</l>', array("checkAccess" => $va_access_values));
?>
				<br/>
<?php 
				print "<p>".$qr_results->get('ca_objects.preferred_labels.name', array('returnAsLink' => true))."</p>"; 
				print "<p>".$qr_results->get('ca_objects.idno')."</p>";
				print "<p>".$qr_results->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'restrictToRelationshipTypes' => array('repository')))."</p>";
?>
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
					jQuery('#{{{block}}}Results').hscroll({
						name: '{{{block}}}',
						itemCount: <?php print $qr_results->numHits(); ?>,
						preloadCount: <?php print $vn_count; ?>,
						
						itemWidth: jQuery('.{{{block}}}Result').outerWidth(true),
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