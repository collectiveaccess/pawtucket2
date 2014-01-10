<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_collections_search_subview_html.php : 
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
		while($qr_results->nextHit()) {
			$va_related_object_ids = $qr_results->get('ca_objects.object_id', array('returnAsArray' => true));

			print "<div class='{{{block}}}Result'>";
			$va_images = caGetPrimaryRepresentationsForIDs($va_related_object_ids, array('versions' => array('widepreview'), 'return' => 'tags'));
			if (sizeof($va_images) > 0){
				foreach ($va_images as $image_id => $va_image) {
					print caNavLink($this->request, "<div class='objectImage'>".$va_image."</div>", '', '', 'Detail', 'Collections/'.$qr_results->getIdentifierForUrl());
					break;
				} 
			} else {
				print "<div class='objectImage'></div>";
			}
			print "<div>".caNavLink($this->request, $qr_results->get('ca_collections.preferred_labels.name'), '', '', 'Detail', 'Collections/'.$qr_results->getIdentifierForUrl())."</div>";
			print "</div>";
			$vn_count++;
			if ($vn_count == 25) {break;}
		}
		print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'block' => $vs_block));
		
		if (!$this->request->isAjax()) {
?>
				</div>
			</div>
<?php
		}
	}
?>