<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
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
 
 	
$vo_result 					= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');
$va_access_values 		= $this->getVar('access_values');
$o_rc = new ResultContext($this->request, 'ca_objects', 'basic_search');
$o_rc->setParameter('collection_list_search', 0);
$o_rc->saveContext();

# --- get the object types for collection and series so can display different into for item results
$o_lists = new ca_lists;
$vn_collection_type_id = $o_lists->getItemIDFromList('object_types', 'collection');
$vn_series_type_id = $o_lists->getItemIDFromList('object_types', 'series');

$t_object = new ca_objects();
$t_parent = new ca_objects();
$t_work = new ca_occurrences();

if($vo_result) {
	$vn_item_count = 0;
	$va_tooltips = array();
	$t_list = new ca_lists();
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		print "<div class='resultUnit'>";
		$vs_idno = $vo_result->get('ca_objects.idno');
		
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_title = join('<br/>', $va_labels);
		$vs_media = $vo_result->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values));
?>
		<div><?php print caNavLink($this->request, $vs_title, 'listHeading', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></div>
<?php
		if($vs_media){
			print "<div class='listMedia'>".caNavLink($this->request, $vs_media, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
			if($vo_result->get("ca_object_representations.caption")){
				print "<div class='imagecaption'>".$vo_result->get("ca_object_representations.caption")."</div>";
			}
			print "</div>";
		}
		if(in_array($vo_result->get('ca_objects.type_id'), array($vn_collection_type_id, $vn_series_type_id))){
?>
			<div><?php print $vo_result->get("ca_objects.cfaAbstract"); ?></div>		
<?php
		}else{
			print "<div class='itemResultText'>";
			$t_object->load($vo_result->get("ca_objects.object_id"));
			if($vs_idno){
				print "<div>"._t("Identifier").": ".$vs_idno."</div>";
			}
			# --- get collection name - might need to go up to levels if item is in a series
			$vs_collection_title = "";
			$vn_collection_id = "";
			if($vo_result->get("ca_objects.parent.type_id") == $vn_collection_type_id){
				$vn_collection_id = $vo_result->get("ca_objects.parent.object_id");
				$vs_collection_title = $vo_result->get("ca_objects.parent.preferred_labels");
			}else{
				$t_parent->load($vo_result->get("ca_objects.parent.object_id"));
				$vn_collection_id = $t_parent->get("ca_objects.parent.object_id");
				$vs_collection_title = $t_parent->get("ca_objects.parent.preferred_labels");
			}
			if($vs_collection_title){
				print "<div>"._t("Collection").": ".caNavLink($this->request, $vs_collection_title, 'listLink', 'Detail', 'Object', 'Show', array('object_id' => $vn_collection_id))."</div>";
			}
			$va_works = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array("instantiation")));
			if(sizeof($va_works) > 0){
				# -- assume there is one related work, just load the first one in the array
				foreach($va_works as $vn_rel_id => $va_work_info){
					$t_work->load($va_work_info['occurrence_id']);
					break;
				}
				# --- creator
				$va_entities = $t_work->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname', 'restrict_to_relationship_types' => array("creator")));
				if(sizeof($va_entities) > 0){
					$va_creator_for_display = array();
					foreach($va_entities as $va_entity) {
						$va_creator_for_display[] = $va_entity["label"];
					}
					print "<div>"._t("Creator").": ".join(", ", $va_creator_for_display)."</div>";
				}
				# --- filmmaker
				$va_entities = $t_work->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname', 'restrict_to_relationship_types' => array("filmmaker")));
				if(sizeof($va_entities) > 0){
					$va_filmmaker_for_display = array();
					foreach($va_entities as $va_entity) {
						$va_filmmaker_for_display[] = $va_entity["label"];
					}
					print "<div>"._t("Filmmaker").": ".join(", ", $va_filmmaker_for_display)."</div>";
				}			
			}
			print "</div><!-- end itemResulttext -->";
		}
?>
		</div><!-- end resultUnit -->
<?php		
		$vn_item_count++;
		
	}
}
?>
