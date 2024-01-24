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
 
	$va_entity_ids		= $this->getVar("entity_ids");
	$t_entity = new ca_entities();
?>
	<div id="memberMapBalloonContainer">
<?php
	foreach($va_entity_ids as $vn_entity_id){
		$t_entity->load($vn_entity_id);
		print "<H1>".$t_entity->getLabelForDisplay()."</H1>";
		$vs_image = "";
		if($vs_image = $t_entity->get("mem_inst_image", array("version" => "thumbnail", "return" => "tag"))){
			print "<div class='memberImage'>".$vs_image."</div>";
		}
		if($t_entity->get("biography")){
			print "<p>";
			print $t_entity->get("biography");
			print "</p>";
		}
		if($t_entity->get("ca_entities.external_link.url_entry")){
			print "<p>";
			print "<a href='".$t_entity->get("ca_entities.external_link.url_entry")."' target='_blank'>".$t_entity->get("ca_entities.external_link.url_entry")."</a>";
			print "</p>";
		}
		print "<p>".caNavLink($this->request, _t("See the collection")." &rsaquo;", '', 'Detail', 'Entity', 'Show', array('entity_id' => $t_entity->get("ca_entities.entity_id")))."</p>";
	}
?>
	<div style="clear:both"><!-- empty --></div></div><!-- end memberMapBalloonContainer -->