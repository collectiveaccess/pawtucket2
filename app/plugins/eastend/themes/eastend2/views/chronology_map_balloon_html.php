<?php
/* ----------------------------------------------------------------------
 * app/plugins/NovaStory/themes/eastend/views/chronology_map_balloon_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
 
	$va_place_ids		= $this->getVar("place_ids");
	$t_place = new ca_places();
?>
	<div id="chronologyMapBalloonContainer">
<?php
	foreach($va_place_ids as $vn_place_id){
		
		$t_place->load($vn_place_id);
		# --- display the entities related to the place - this is what we searched up on since that is the curent data available
		print "<H1>".caNavLink($this->request, $t_place->getLabelForDisplay(), '', 'Detail', 'Place', 'Show', array('place_id' => $t_place->get("ca_places.place_id")))."</H1>";
		# --- entities
		$va_entities = $t_place->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
		if(sizeof($va_entities) > 0){	
			foreach($va_entities as $va_entity) {
				print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." (".$va_entity['relationship_typename'].")</div>";
			}
		}
		print "<p>".caNavLink($this->request, _t("More")." &rsaquo;", '', 'Detail', 'Place', 'Show', array('place_id' => $t_place->get("ca_places.place_id")))."</p>";
	}
?>
	</div><!-- end chronologyMapBalloonContainer -->