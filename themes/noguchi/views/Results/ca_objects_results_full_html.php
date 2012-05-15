<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2009 Whirl-i-Gig
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
 
 	
$vo_result 				= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');

if($vo_result) {
	$vn_item_count = 0;
	$t_object = new ca_objects();
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		if (!$vs_idno = $vo_result->get('ca_objects.idno')) {
			$vs_idno = "???";
		}
		
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		$t_object->load($vn_object_id);
		print "<div class='searchFullImageContainer'>";
		print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media','small'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		print "</div><!-- END searchFullImageContainer -->";
		print "<div class='searchFullText'>";
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_caption = join('<br/>', $va_labels);
		print "<div class='searchFullTitle'>".caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
		if($vo_result->get("ca_objects.image_id")){
			print "<div class='searchFullTextTextBlock'><b>"._t("Image ID").":</b> \n".$vo_result->get("ca_objects.image_id")."</div>";
		}
		if($vo_result->get("ca_objects.idno")){
			print "<div class='searchFullTextTextBlock'><b>"._t("ID").":</b> \n".$vo_result->get("ca_objects.idno")."</div>";
		}
		$va_photographer = $vo_result->get('ca_entities', array('restrict_to_relationship_types' => array('photographer'), 'checkAccess' => $va_access_values, 'returnAsArray' => 1));
		if(sizeof($va_photographer) > 0){
			print "<div class='searchFullTextTextBlock'><b>"._t("Photographer").((sizeof($va_photographer) > 1) ? "s" : "").":</b> ";
			$c = 0;
			foreach ($va_photographer as $photographer) {
				print $photographer["label"];
				$c++;
				if($c < sizeof($va_photographer)){
					print ", ";
				}
			}
			print "</div><!-- end searchFullTextTextBlock -->";
		}
		if($vo_result->get("ca_objects.object_date")){
			print "<div class='searchFullTextTextBlock'><b>"._t("Date").":</b>".$vo_result->get("ca_objects.object_date")."</div>";
		}
		if($t_object->get('ca_objects.archive_category')){
			print "<div class='searchFullTextTextBlock'><b>"._t("Archive Category").":</b> ".$t_object->get('ca_objects.archive_category')."</div><!-- end searchFullTextTextBlock -->";
		}
		# --- Typename
		if($this->getVar('typename')){
			print "<div class='searchFullTextTextBlock'><b>"._t("Format").":</b> ".$this->getVar('typename')."</div><!-- end unit -->";
		}
		if($t_object->get('ca_objects.physical_location')){
			print "<div class='searchFullTextTextBlock'><b>"._t("Object Location").":</b> ".$t_object->get('ca_objects.physical_location')."</div><!-- end searchFullTextTextBlock -->";
		}

		if($t_object->get('ca_objects.content_location')){
			print "<div class='searchFullTextTextBlock'><b>"._t("Location shown").":</b> ".$t_object->get('ca_objects.content_location')."</div><!-- end searchFullTextTextBlock -->";
		}
		
		print "</div><!-- END searchFullText -->\n";
		$vn_item_count++;
		if($vn_item_count < $vn_items_per_page){
			print "<div class='divide' style='clear:left;'><!-- empty --></div>\n";
		}
		
	}
}
?>