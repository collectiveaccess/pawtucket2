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
?> 	
	<div id="pageTitle">Research</div>
	<div id="contentArea" class="rightCol">
	<p class='researchInfo'>The Mattress Factory Archives is happy to accommodate researchers for on-site or virtual appointments.  Please contact <a href='mailto:mfarchives@mattress.org'>mfarchives@mattress.org for assistance. </p>
<?php 
	$va_lists = array_reverse($va_lists);
	foreach($va_lists as $vs_heading => $qr_list) {
		if(!$qr_list) { continue; }
		
		print "<div class='collectionUnit'>";
		
		print "<h2>{$vs_heading}</h2>\n";
		
		while($qr_list->nextHit()) {
			print "<div class='collectionInfo'>";
			print "<h3>".$qr_list->getWithTemplate('<l>^ca_collections.preferred_labels.name</l>')."</h3>\n";
			$va_collection_notes = $qr_list->get('ca_collections.collection_note', array('returnAsArray' => true));
			foreach ($va_collection_notes as $key_collection => $va_collection_note) {
				if ($va_collection_note['collectio_note_type'] == 309) {
					print "<p>".$va_collection_note['collection_note_content']."</p>\n";	
				}
			}
			print "</div>";
		}
		print "</div>";
	}
?>
	</div>
<?php	
	if ($this->request->config->get('use_facets_for_collections')) {
?>	
		<div id="listingTags">
<?php
		if ($this->getVar('hasCriteria')) {
			$va_criteria = $this->getVar('criteria');
?>
			<?php print caNavLink($this->request, _t('Reset'), '', '*', '*', '*'); ?>
<?php
		}
	
		foreach($this->getVar('facets') as $vs_facet => $va_facet_info) {
?>
			<div class='<?php print $vs_facet;?>Block'>
				<div class='listTitle'><?php print $va_facet_info['label_plural']; ?></div>
<?php
				foreach($va_facet_info['content'] as $vn_item_id => $va_item) {
					print "<p>";
					if (isset($va_criteria[$vs_facet]) && ($va_criteria[$vs_facet] == $va_item['id'])) {
						print "<strong>".$va_item['label']."</strong>";		// Selected facet
					} else {
						print caNavLink($this->request, $va_item['label'], '', '*', '*', '*', array('facet' => $vs_facet, 'id' => $va_item['id']));
					}
					print "</p>\n";
				}
?>
			</div>
<?php
		}
	}
?>
	</div>