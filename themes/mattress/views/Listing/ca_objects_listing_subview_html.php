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
?> 	

	<div id="pageTitle">The Space I'm In</div>
	<div id="contentArea" class="rightCol">
<?php 
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }		
		
		print "<h2>Lesson Plans</h2>\n";
		print "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis mi volutpat, dapibus enim in, sagittis dui. Cras ac tortor tortor. Nullam consequat semper se</p>";
		
		while($qr_list->nextHit()) {
			print "<div class='lessonInfo'>";
			print "<div class='lessonImage'>".$qr_list->get('ca_object_representations.media.small')."</div>";
			print "<div class='lessonText'>";
			print "<h3>".$qr_list->getWithTemplate('<l>^ca_objects.preferred_labels.name</l>')."</h3>\n";
			print "<div class='artist'>".$qr_list->get('ca_entities.preferred_labels.displayname', array('restrictToRelationshipTypes' => array('subject'), 'delimiter' => ', '))."</div>\n";
			if ($qr_list->get('ca_list_items.preferred_labels')) {
				print "<div class='tags'><div class='tagtitle'>Tags</div>".$qr_list->get('ca_list_items.preferred_labels', array('delimiter' => ', '))."</div>\n";
			}
			print "</div>";
			print "<div class='clearfix'></div>";
			print "</div>";
		}

	}
?>
	</div>
	<div id="listingTags">
		<div class='tagBlock'>
			<div class='listTitle'>Tags</div>
			<p>painting</p>
			<p>sculpture</p>
		</div>
		<div class='themeBlock'>
			<div class='listTitle'>Themes</div>
			<p>environment</p>
			<p>color</p>
		</div>
		<div class='artistBlock'>
			<div class='listTitle'>Artists</div>
			<p>James Turrel</p>
		</div>
	
	</div>