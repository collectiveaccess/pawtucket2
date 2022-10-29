<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_sets_search_images_subview_html.php : 
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
	$vs_default_placeholder_tag = "<div class='multisearchImgPlaceholder'><i class='fa fa-picture-o fa-2x'></i></div>";

	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<small class="pull-right sortValues">				
				<span class='multisearchFullResults'><?php print caNavLink($this->request, _t('All Stories'), 'btn btn-default btn-small', '', 'Gallery', 'Index'); ?></span> 
			</small>
			<H2><?php print $va_block_info['displayName']." (".$qr_results->numHits().")"; ?></H2>
			<div class='blockResults objects'><div id="{{{block}}}scrollButtonPrevious" class="scrollButtonPrevious" aria-label="previous" role="link" tabindex="0"><i class="fa fa-angle-left" role="button" aria-label="previous"></i></div><div id="{{{block}}}scrollButtonNext" class="scrollButtonNext" aria-label="next" role="link" tabindex="0"><i class="fa fa-angle-right" role="button" aria-label="next"></i></div>
				<div id='{{{block}}}Results' class='multiSearchResults'>
					<div class='blockResultsScroller'>
<?php
		}
		# --- preprocess results so can get ids and get set images all in one go
		$vn_count = 0;
		$va_results = array();
		while($qr_results->nextHit()) {
			$va_results[$qr_results->get("ca_sets.set_id")] = "<div class='bResultItemText'>".caNavLink($this->request, $qr_results->get('ca_sets.preferred_labels.name'), '', '', 'Gallery', $qr_results->get("ca_sets.set_id"))."</div>";
			$vn_count++;
			if ((!$vn_init_with_start && ($vn_count == $vn_hits_per_block)) || ($vn_init_with_start && ($vn_count >= $vn_init_with_start))) {break;} 
		}
		
		if(is_array($va_results) && sizeof($va_results)){		
			$t_set = new ca_sets();
			$set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_results), array("version" => "widepreview", "checkAccess" => $va_access_values));
			foreach($va_results as $vn_set_id => $vs_result){
				
				$first_item = $set_first_items[$vn_set_id];
				$first_item = array_shift($first_item);
				$vn_item_id = $first_item["item_id"];
				$vs_image = $set_first_items[$vn_set_id][$vn_item_id]["representation_tag"];
?>
				<div class='{{{block}}}Result multisearchResult'>
<?php 
				
				if($vs_image){
					print caNavLink($this->request, $vs_image, '', '', 'Gallery', $vn_set_id);
				}
				print $vs_result;
?>
				</div>
<?php
			}
		}
		
		
				

		if (!$this->request->isAjax()) {
?>
					</div><!-- end blockResultsScroller -->
				</div>
			</div><!-- end blockResults -->
		
			<div class='allLink'><?php print caNavLink($this->request, 'all '.$va_block_info['displayName'].' results', '', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search)));?></div>


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