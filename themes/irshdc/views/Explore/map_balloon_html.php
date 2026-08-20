<?php
/* ----------------------------------------------------------------------
 * app/plugins/NovaStory/themes/novastory/views/member_map_balloon_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2013 Whirl-i-Gig
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
 	$va_access_values = caGetUserAccessValues($this->request);
 	#print_r($va_entity_ids);
 	$va_entity_ids		= $this->getVar("entity_ids");
	$t_entity = new ca_entities();
?>
	<div id="exploreMapBalloonContainer">
<?php
	foreach($va_entity_ids as $vn_entity_id){
		print "<div class='mapItem'>";
		$t_entity->load($vn_entity_id);
		$vs_image = $t_entity->getWithTemplate("<unit relativeTo='ca_objects' length='1' restrictToRelationshipTypes='featured'>^ca_object_representations.media.iconlarge</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
								
		
		if(!$vs_image){
			$vs_image = $t_entity->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
		}
		if($vs_image){
			print "<div class='mapImage'>".caDetailLink($this->request, $vs_image, '', 'ca_entities', $t_entity->get("entity_id"))."</div>";
		}
		print "<H1>".caDetailLink($this->request, $t_entity->getLabelForDisplay(), '', 'ca_entities', $t_entity->get("ca_entities.entity_id"))."</H1>";
		
		if($t_entity->get("ca_entities.school_dates.school_dates_value")){
			print "<H6>Dates of Operation</H6>".$t_entity->get("ca_entities.school_dates.school_dates_value", array("delimiter" => ", "));
		}
		
		if($t_entity->get("ca_places.place_id")){
			print "<H6>Location</H6>";
			$t_list = new ca_lists();
 		 	$vn_city_id = $t_list->getItemIDFromList('place_types', 'city');
 		 	
 		 	$t_place = new ca_places($t_entity->get("ca_places.place_id"));
			$va_hier = $t_place->getHierarchyAsList(array("restrictToTypes" => array("city")));
			foreach($va_hier as $va_place){
				if($va_place["NODE"]["type_id"] == $vn_city_id){
					$t_place->get($va_place["NODE"]["place_id"]);
					print $t_place->get("ca_places.preferred_labels");
					break;
				}
			}
		}
		#print "<div><br/>".caNavLink($this->request, _t("More"), 'btn-default btn-sm', '', 'Detail', 'entities/'.$t_entity->get("ca_entities.entity_id"), array(), array("target" => "_blank"))."</div>";
		print "<div><br/>".caNavLink($this->request, _t("More"), 'btn-default btn-sm', '', 'Detail', 'entities/'.$t_entity->get("ca_entities.entity_id"), array())."</div>";
		print "<div style='clear:both;'></div>";
		print "</div><!-- end mapItem -->";
	}
?>
	<div style="clear:both"><!-- empty --></div></div><!-- end memberMapBalloonContainer -->
