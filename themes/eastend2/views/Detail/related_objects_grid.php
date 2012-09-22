<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/related_objects_grid.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
	$qr_hits = $this->getVar('browse_results');
	$vn_c = 0;
	$vn_itemc = 0;
	$vn_numCols = 2;
	
	$va_access_values	= $this->getVar('access_values');
	if($qr_hits->numHits()){	
		# --- loop through all results and build 3 columns to output later
		$va_col1 = array();
		$va_col2 = array();
		$va_col3 = array();
		$vn_col = 1;
		while($qr_hits->nextHit()){
			$vn_object_id = $qr_hits->get('object_id');
			$vs_caption = join("; ", $qr_hits->getDisplayLabels());
			${"va_col".$vn_col}[] = caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')), array("id" => "searchThumbnail".$qr_hits->get('ca_objects.object_id')));
				
			// set view vars for tooltip
			$this->setVar('tooltip_representation', $qr_hits->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values)));
			$this->setVar('tooltip_title', $vs_caption);
			$this->setVar('tooltip_idno', $qr_hits->get('idno'));
			TooltipManager::add(
				"#searchThumbnail{$vn_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
			);
	
			$vn_col++;
			if($vn_col > $vn_numCols){
				$vn_col = 1;
			}
		}
?>
		<div class="ad_thumbs">	
<?php
			$i = 1;
			while($i <= $vn_numCols ){
				print '<div class="col">'.join("<br/>", ${"va_col".$i}).'</div>';
				$i++;
			}
?>
		</div><!--end ad_thumbs-->
<?php
	}
?>