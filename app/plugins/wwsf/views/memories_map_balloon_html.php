<?php
/* ----------------------------------------------------------------------
 * views/memories_map_balloon_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
 
$qr_data 						= $this->getVar('data');		// this is a search result row
$va_access_values 		= $this->getVar('access_values');
$vn_set_id = $qr_data->get("ca_sets.set_id");

# --- get the forst item from the set - need object_id of forst item for the link to the detail page
$t_set = new ca_sets();
$va_first_items_from_sets = $t_set->getFirstItemsFromSets(array($vn_set_id), array("checkAccess" => $va_access_values));
$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
?>
<div class="memoriesMapBalloon">
	<div class="memoriesMapBalloonText">
	<?php print caNavLink($this->request, $qr_data->get("ca_sets.preferred_labels"), '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item["row_id"])); ?>
	</div><!-- end memoriesMapBalloonText -->
</div><!-- end memoriesMapBalloon -->