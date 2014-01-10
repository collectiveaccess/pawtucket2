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

	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<div class='blockTitle'>
				<?php print $va_block_info['displayName']; ?>
			</div>
			<div class='blockResults'>
				<div style='width:100000px' id='{{{block}}}Result'>
<?php
		}
		$vn_count = 0;
		$vn_i = 0;
		while($qr_results->nextHit()) {
			if ($vn_i == 0) {print "<div class='{{{block}}}Result'>";}
			print "<div class='{{{block}}}Result'>";
			print "<div>".caNavLink($this->request, $qr_results->get('ca_occurrences.preferred_labels.name'), '', '', 'Detail', 'Occurrences/'.$qr_results->getIdentifierForUrl())."</div>";
			print "</div>";
			$vn_count++;
			$vn_i++;
			if ($vn_i == 5) {
				print "</div>";
				$vn_i = 0;
			}
			if ($vn_count >= $vn_hits_per_block) {break;}
		}
		print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'block' => $vs_block));
		
		if (!($qr_results->nextHit()) && ($vn_i < 5)) {print "</div>";}
		
		if (!$this->request->isAjax()) {
?>
		</div>
	</div>
<?php
		}
	}
?>