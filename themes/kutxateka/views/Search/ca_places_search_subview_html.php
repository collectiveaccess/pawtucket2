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
	$vn_init_with_start	= (int)$this->getVar('initializeWithStart');
	
	if ($qr_results->numHits() > 0) {
?>
				<div class="filters scrollArea2">
                            
					<p><?php print $va_block_info["displayName"]; ?></p>
                            
					<ul>
<?php
		while($qr_results->nextHit()) {
			print '<li>'.caNavLink($this->request, $qr_results->get('ca_places.preferred_labels.displayname'), 'azul', '', 'Search', 'objects', array('search' => $qr_results->get('ca_places.preferred_labels.displayname'))).'</li>';
		}
?>
					</ul>
				</div>
<?php
	}
?>