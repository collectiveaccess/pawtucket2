<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_entities_full_html.php :
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
 
 	
$vo_result 				= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');
$va_access_values	= $this->getVar('access_values');

$va_entity_results = array();

?>	
	<div id="rightcol_featured"></div><!-- rightcol_featured -->	
<?php



if($vo_result) {
	$t_entity = new ca_entities();
	while($vo_result->nextHit()) {
		$vn_entity_id = $vo_result->get('ca_entities.entity_id');
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_surname = $vo_result->get("ca_entity_labels.surname");
		$vs_letter = mb_strtoupper(mb_substr($vs_surname, 0, 1));
		$va_entity_results[$vs_letter]["entities"][] = caNavLink($this->request, join($va_labels, "; "), '', 'Detail', 'Entity', 'Show', array('entity_id' => $vn_entity_id));
		if(!$va_entity_results[$vs_letter]["image"]){
			$t_entity->load($vn_entity_id);
			$va_portraits = $t_entity->get("ca_objects", array("restrictToRelationshipTypes" => array("portrait"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			foreach($va_portraits as $va_portrait){
				$t_object = new ca_objects($va_portrait["object_id"]);
				if($va_portrait = $t_object->getPrimaryRepresentation(array('abHeadShot'), null, array('return_with_access' => $va_access_values))){
					$va_entity_results[$vs_letter]["image"] = caNavLink($this->request, $va_portrait['tags']['abHeadShot'], '', 'Detail', 'Entity', 'Show', array('entity_id' => $vn_entity_id), array("title" => $t_entity->get("ca_entity_labels.displayname")));
					break;
				}
			}
		}
	}
	# --- how many to put in each column?
	$vn_num_results = $vo_result->numHits();
	$vn_num_per_col = ceil($vn_num_results/5);
	$vn_i = 0;
	$vn_i_total = 0;
	foreach($va_entity_results as $vs_letter => $va_results_by_letter){
		if($vn_i == 0){
			print "<div class='ab_col'>"; 
		}
		print "<span class='listhead'>".$vs_letter."</span>";
		if($va_results_by_letter["image"]){
			print "<br />".$va_results_by_letter["image"];
		}
		print "<ul>";
		foreach($va_results_by_letter["entities"] as $k => $vs_entity_result){
			print "<li>".$vs_entity_result."</li>";
			$vn_i++;
			$vn_i_total++;
		}
		if($vn_i >= $vn_num_per_col){
			$vn_i = 0;
		}
		print "</ul>";
		if($vn_i == 0 || $vn_i_total == $vn_num_results){
			print "</div><!-- end ab_col -->"; 
		}		
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	//load featured artist slideshow
	jQuery("#rightcol_featured").load("<?php print caNavUrl($this->request, 'eastend', 'ArtistBrowser', 'getFeaturedArtistSlideshow'); ?>");
});
</script>
