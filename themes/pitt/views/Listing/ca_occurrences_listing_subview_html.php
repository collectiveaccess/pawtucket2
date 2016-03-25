<?php
/** ---------------------------------------------------------------------
 * themes/default/Listings/listing_html : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 	$va_lists = $this->getVar('lists');
 	$va_type_info = $this->getVar('typeInfo');
 	$va_listing_info = $this->getVar('listingInfo');
 	$va_criteria = $this->getVar('criteria');
 	 	
 	$va_future_exhibitions = array();
 	$va_current_exhibitions = array();
 	$va_past_exhibitions = array();
?>
	<div class="listingContent col-sm-8">
<?php	
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
	
		while($qr_list->nextHit()) {					
			print "<div class='listRow row'>".$qr_list->getWithTemplate('<div class="listLeft col-xs-3 col-md-2 col-lg-2"><l><unit relativeTo="ca_object_representations" length="1">^ca_object_representations.media.iconlarge</unit></l></div><div class="listRight col-xs-9 col-md-10 col-lg-10"><p><l>^ca_occurrences.preferred_labels.name</l></p><ifcount min="1" code="ca_entities.preferred_labels" restrictToRelationshipTypes="curator"><p>Curated By: <unit relativeTo="ca_entities_x_occurrences" restrictToRelationshipTypes="curator">^ca_entities.preferred_labels</p></unit></ifcount><p>^ca_occurrences.exh_dates</p><p>^ca_occurrences.exh_location</p></div>')."</div>";
					
		}
	}
	
	
?>	
	</div>
<?php
	if ($va_listing_info['code'] == "past") {
?>	
		<div class="listingTags col-sm-4">
		<div class='listingPanel'>
			<h2>Filter By: </h2>
<?php
		foreach($this->getVar('facets') as $vs_facet => $va_facet_info) {
?>
			<div class='<?php print $vs_facet;?>Block'>
				<div class='listTitle'><?php print $va_facet_info['label_plural']; ?></div>
<?php
				foreach($va_facet_info['content'] as $vn_item_id => $va_item) {
					print "<p>";
					if (isset($va_criteria[$vs_facet]) && ($va_criteria[$vs_facet] == $va_item['id'])) {
						print "<span style='color:red;'>".$va_item['label']."</span>";		// Selected facet
					} else {
						print caNavLink($this->request, $va_item['label'], '', '*', '*', '*', array('facet' => $vs_facet, 'id' => $va_item['id']));
					}
					print "</p>\n";
				}
?>
			</div>
<?php
		}
		if ($this->getVar('hasCriteria')) {
			$va_criteria = $this->getVar('criteria');
?>
			<?php print caNavLink($this->request, _t('Clear'), '', '*', '*', '*'); ?>
<?php
		}
?>
		</div>
		</div>		
<?php
	}
?>