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
	$va_criteria = $this->getVar('criteria');
?> 	

	<div id="pageTitle">
		<span class='pageTitle'>Limited Editions</span>
<?php	
		print "<p class='toolkit'></p>";
?>		
	</div>
	<div id="contentArea" class="rightCol listing">
<?php 
	foreach($va_lists as $vs_heading => $qr_list) {
		if(!$qr_list) { continue; }		
		

		
		while($qr_list->nextHit()) {
			$va_subjects = array();
			$va_theme = array();
			print "<div class='lessonInfo'>";

			$va_object_id = $qr_list->get('ca_objects.object_id');
			print "<div class='lessonImage'>".caNavLink($this->request, $qr_list->get('ca_object_representations.media.exsingle'), '', '', 'Detail','objects/'.$va_object_id)."</div>";
			print "<div class='lessonText'>";
			print "<h3>".$qr_list->get('ca_objects.preferred_labels.name', array('returnAsLink' => true))."</h3>\n";
			print "<div class='artist'>".$qr_list->get('ca_entities.preferred_labels.displayname', array('restrictToRelationshipTypes' => array('creator'), 'delimiter' => ', '))."</div>\n";
			print "<p>".$qr_list->get('ca_objects.materials', array('delimiter' => ', '))."</p>";			
			print "</div>";
			print "<div class='clearfix'></div>";
			print "</div>";
		}

	}
?>
	</div>
	<div id="listingTags">
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