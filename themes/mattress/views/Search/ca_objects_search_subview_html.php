<?php
/* ----------------------------------------------------------------------
 * themes/mattress/views/Search/ca_objects_search_subview_html.php : 
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

	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<small class="pull-right sortMenu">
				<?php print caNavLink($this->request, _t('Full results'), 'fullResults', '', 'Search', '{{{block}}}', array('search' => $vs_search)); ?> <span class='sortBy'> |&nbsp;&nbsp;Sort By</span> {{{sortByList}}}
			</small>
			<div class='blockTitle'><?php print $va_block_info['displayName']; ?></div>
			<div class='blockResults'><div id="{{{block}}}scrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div><div id="{{{block}}}scrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id='{{{block}}}Results' class='scrollBlock'>
					<div class='blockResultsScroller'>
<?php
		}
		$vn_count = 0;
		while($qr_results->nextHit()) {
?>
			<div class='{{{block}}}Result'>
				<?php print caNavLink($this->request, "<div class='objImage'>".$qr_results->get('ca_object_representations.media.resultthumb')."</div>", '', 'Detail', 'objects', $qr_results->get('ca_objects.object_id')); ?>
<?php
			if ($qr_results->get('ca_objects.nonpreferred_labels.type_id') == '515') {
				print $qr_results->get('ca_objects.nonpreferred_labels.name', array('returnAsLink' => true));				
			} else {
				print $qr_results->get('ca_objects.preferred_labels.name', array('returnAsLink' => true));
			} 
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
						scrollPreviousControlSelector: '#{{{block}}}scrollButtonPrevious',
						scrollNextControlSelector: '#{{{block}}}scrollButtonNext',
						scrollControlDisabledOpacity: 0,
						cacheKey: '{{{cacheKey}}}'
					});
				});
			</script>
<?php
		}
	}
?>