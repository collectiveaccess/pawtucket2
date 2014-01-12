<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_occurrences_search_subview_html.php : 
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

	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<div class='blockTitle'>
				<?php print $va_block_info['displayName']; ?>
				
				<div class="blockSortControl">{{{sortByControl}}}</div>
			</div>
			<div class='blockResults'>
				<div id='{{{block}}}Results'>
					<div class='blockResultsScroller'>
<?php
		}
		$vn_count = 0;
		$vn_i = 0;
		$vb_div_open = false;
		while($qr_results->nextHit()) {
			if ($vn_i == 0) { print "<div class='{{{block}}}Set'>"; $vb_div_open = true; }
?>
			<div class='{{{block}}}Result'>
				<div>
					<?php print caNavLink($this->request, $qr_results->get('ca_occurrences.preferred_labels.name'), '', '', 'Detail', '{{{block}}}/'.$qr_results->getIdentifierForUrl()); ?>
				</div>
			</div>
<?php
			$vn_count++;
			$vn_i++;
			if ($vn_i == $vn_items_per_column) {
				print "</div>";
				$vb_div_open = false;
				$vn_i = 0;
			}
			if ($vn_count >= $vn_hits_per_block) {break;}
		}
		
		if ($vb_div_open) {print "</div>";}
		
		if (!$this->request->isAjax()) {
?>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				jQuery('#{{{block}}}Results').hscroll({
						itemCount: <?php print $qr_results->numHits(); ?>,
						itemsPerColumn: <?php print $vn_items_per_column; ?>,
						itemWidth: 230,
						itemsPerLoad: <?php print $vn_hits_per_block; ?>,
						itemLoadURL: '<?php print ($vb_has_more ? caNavUrl($this->request, '*', '*', '*', array('block' => $vs_block, 'search'=> $vs_search)) : ''); ?>',
						itemContainerSelector: '.blockResultsScroller',
						sortParameter: '{{{block}}}Sort',
						sortControlSelector: '#{{{block}}}_sort'
					});
			</script>
<?php
		}
	}
?>