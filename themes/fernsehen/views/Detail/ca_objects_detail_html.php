<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/ca_objects_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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

	require_once(__CA_MODELS_DIR__."/ca_occurrences.php");

	$t_object = 						$this->getVar('t_item');
	$vn_object_id = 					$t_object->get('object_id');
	$vs_title = 						$this->getVar('label');
	
	$va_access_values = 				$this->getVar('access_values');
	$t_rep = 							$this->getVar('t_primary_rep');
	$vn_num_reps = 						$t_object->getRepresentationCount(array("return_with_access" => $va_access_values));
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');
?>	
	<div id="detailBody">
		<div id="leftCol">
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
<?php
		if($vs_content = getAttributeFromAVWork($t_object,"content_description_front")){
?>
			<b>Inhalt</b>
			<div id="objDescription">
				<?php print $vs_content; ?>
			</div>
<?php
		}
?>
		</div><!-- end leftCol-->
		<div id="rightCol">
<?php
			
			if ($t_rep && $t_rep->getPrimaryKey()) {
?>
				<div id="objDetailImage"><?php
				if($va_display_options['no_overlay']){
					$va_options = $this->getVar('primary_rep_display_options');
					$va_options["viewer_base_url"] = __CA_URL_ROOT__;
					print $t_rep->getMediaTag('media', $vs_display_version, $va_options);
				}else{
					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'))."</a>";
				}
				?></div><!-- end objDetailImage -->
<?php
			}
?>			
			<br style="clear: both; "/>
			<div id="info">
			<h1><?php print $vs_title; ?></h1>
			<div id="EntityInfo">
<?php
			# --- list items
			$vs_list_items = $t_object->get("ca_list_items.preferred_labels.name_singular",array("delimiter" => ", "));

			if(strlen(trim($vs_list_items))>0){
?>

				<div class="unit">Stichworte:&nbsp;&nbsp;&nbsp;<?php print $vs_list_items; ?></div>

<?php
			}


			# --- entities displayed by type
			$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){
				$va_entities_by_type = array();
				foreach($va_entities as $va_entity_info){
					if($va_entity_info["relationship_type_code"]=="dummy") continue;
					$va_entities_by_type[$va_entity_info['relationship_typename']][] = $va_entity_info['displayname'];
				}
				
				if(isset($va_entities_by_type["Regie"]) && is_array($va_entities_by_type["Regie"])){
					printRelatedEntitiesForType("Regie", $va_entities_by_type["Regie"]);
				}
				
				unset($va_entities_by_type["Regie"]);
				
				foreach($va_entities_by_type as $vs_relationship_typename => $va_entities_for_type){
					if(is_array($va_entities_for_type)){
						printRelatedEntitiesForType($vs_relationship_typename, $va_entities_for_type);
					}
				}
			}			
			
			
			

?>
		</div><!-- end EntityInfo --></div><!-- end info --></div><!-- end rightCol -->
	</div><!-- end detailBody -->

<?php

	function printRelatedEntitiesForType($ps_type_code,$va_entities){
?>
		<div class="unit" id='<?php print $ps_type_code; ?>List'><?php print $ps_type_code; ?>:&nbsp;&nbsp;&nbsp;
<?php
		if(sizeof($va_entities) > 5){
			print implode(", ", array_slice($va_entities, 0, 5));
			TooltipManager::add(
				"#".$ps_type_code."List", "<div class='detailMoreList'><b>".$ps_type_code."</b><br/>".implode(", ", $va_entities)."</div>"
			);
			print "... <span class='detailMore'>Mehr &gt;</span>";
		}else{
			print implode(", ", $va_entities);
		}
?>
		</div><!-- end unit -->
<?php
	}

	function getAttributeFromAVWork($t_object,$vs_attribute){
		$va_related = $t_object->getRelatedItems(
				"ca_occurrences",
				array(
					'restrict_to_relationship_types' => array(
						'exemplar'
					)
				)
		);
		foreach($va_related as $va_rel_info){
			$vn_manifest_id = $va_rel_info["occurrence_id"];
		}

		$t_manifest = new ca_occurrences($vn_manifest_id);

		$va_related = $t_manifest->getRelatedItems(
                        "ca_occurrences",
                        array(
                                'restrict_to_types' => array(
                                       	'av_work'
                              	)
                        )
                );

		foreach($va_related as $va_rel_info){
                        $vn_work_id = $va_rel_info["occurrence_id"];
                }

		$t_work = new ca_occurrences($vn_work_id);

		return $t_work->get($vs_attribute);
	}

?>
