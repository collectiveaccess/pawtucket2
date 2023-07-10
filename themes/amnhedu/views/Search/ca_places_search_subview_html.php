<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_places_search_subview_html.php : 
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
	$vn_items_per_column = (int)$this->getVar('itemsPerColumn');
	$vb_has_more 		= (bool)$this->getVar('hasMore');
	$vs_search 			= (string)$this->getVar('search');
	$vn_init_with_start	= (int)$this->getVar('initializeWithStart');
	$o_config = $this->getVar("config");
	$o_browse_config = caGetBrowseConfig();
	$va_browse_types = array_keys($o_browse_config->get("browseTypes"));
	
	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<small class="pull-right sortValues">
<?php
				if(in_array($vs_block, $va_browse_types)){
?>
				<span class='multisearchFullResults'><?php print caNavLink($this->request, '<span class="glyphicon glyphicon-list"></span> '._t('Full results'), '', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search))); ?></span> | 
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
			<div class='blockResults authorityBlock'>
				<div id="{{{block}}}scrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div><div id="{{{block}}}scrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id='{{{block}}}Results' class='multiSearchResults'>
					<div class='blockResultsScroller'>
<?php
		}		
		$vn_count = 0;
		$vn_i = 0;
		$vb_div_open = false;
		while($qr_results->nextHit()) {
			if ($vn_i == 0) { print "<div class='{{{block}}}Set authoritySet'>\n"; $vb_div_open = true;}
				print "<div class='{{{block}}}Result authorityResult'>".$qr_results->get('ca_places.preferred_labels.name', array('returnAsLink' => true))."</div><!-- end Result -->";
			$vn_count++;
			$vn_i++;
			if ($vn_i == $vn_items_per_column) {
				print "</div><!-- end set -->";
				$vb_div_open = false;
				$vn_i = 0;
			}
			if ((!$vn_init_with_start && ($vn_count == $vn_hits_per_block)) || ($vn_init_with_start && ($vn_count >= $vn_init_with_start))) {break;} 
		}
		
		if ($vb_div_open) {print "</div><!-- end set -->";}
		
		if (!$this->request->isAjax()) {
?>
					</div><!-- end blockResultsScroller -->
				</div>
			</div><!-- end blockResults -->
<?php
			if ($qr_results->numHits() > 3) {
?>			
				<div class='allLink'><?php print caNavLink($this->request, 'See '.($qr_results->numHits() - 3)." more ".$va_block_info['displayName'].($qr_results->numHits() == 4 ? ' result' : ' results'), '', '', 'Search', '{{{block}}}', array('search' => $vs_search));?></div>
<?php
			}
?>			
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#{{{block}}}Results').hscroll({
						name: '{{{block}}}',
						itemCount: <?php print $qr_results->numHits(); ?>,
						preloadCount: <?php print $vn_count; ?>,
						
						itemsPerColumn: <?php print $vn_items_per_column; ?>,
						itemWidth: jQuery('.{{{block}}}Set').outerWidth(true),
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
?>