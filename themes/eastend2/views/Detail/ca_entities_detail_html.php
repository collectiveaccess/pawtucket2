<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_entities_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
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
 	require_once(__CA_LIB_DIR__."/ca/Search/PlaceSearch.php");
	$t_entity 			= $this->getVar('t_item');
	$vn_entity_id 		= $t_entity->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');
	
	JavascriptLoadManager::register('smoothDivScrollVertical');

if (!$this->request->isAjax()) {		
?>
<div id="subnav">
<?php
	if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_entities', _t("Back"), ''))) {
		print "<ul><li>";
		if ($this->getVar('previous_id')) {
			print caNavLink($this->request, "&laquo; "._t("Previous"), '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('previous_id')), array('id' => 'previous'));
		}else{
			print "&laquo; "._t("Previous");
		}
		print "</li>";
		print "<li>&nbsp;&nbsp;&nbsp;".$vs_back_link."</li>";
		print "<li>";
		if ($this->getVar('next_id') > 0) {
			print caNavLink($this->request, "&raquo; "._t("Next"), '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('next_id')), array('id' => 'next'));
		}else{
			print "&raquo; "._t("Next");
		}
		print "</li></ul>";
	}else{
		print "<ul><li>".caNavLink($this->request, "&laquo; "._t("Artist Browser"), "", "eastend", "ArtistBrowser", "Index")."</li></ul>";
	}
?>
</div><!--end subnav-->

<div id="ad_content">
	<div id="ad_portrait">
		<span class="listhead caps">
			<?php print $vs_title; ?>
<?php
			if($t_entity->get("lifespans_date")){
				print "<br />".$t_entity->get("lifespans_date");
			}
?>
		</span><br />
<?php
		# --- get portrait of entity
		$va_portraits = $t_entity->get("ca_objects", array("restrictToRelationshipTypes" => array("portrait"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
		foreach($va_portraits as $va_portrait){
			$t_object = new ca_objects($va_portrait["object_id"]);
			if($t_object->get("object_status") != 348){
				$this->setVar('exclude_object_id', $va_portrait["object_id"]);
				if($va_portrait = $t_object->getPrimaryRepresentation(array('small'), null, array('return_with_access' => $va_access_values))){
					if($t_object->get("object_status") == 349){
						$vs_vaga_class = " vagaDisclaimer";
					}
					print "<span class='portraitImgTT".$vs_vaga_class."'>".$va_portrait['tags']['small']."</span><br/>";
					if($t_object->get("ca_objects.caption")){
						TooltipManager::add(
							".portraitImgTT", "<div style='width:300px;'>".$t_object->get("ca_objects.caption").(($vs_vaga_class) ? "Reproduction of this image, including downloading, is prohibited without written authorization from VAGA, 350 Fifth Avenue, Suite 2820, New York, NY 10118. Tel: 212-736-6666; Fax: 212-736-6767; e-mail:info@vagarights.com; web: <a href='www.vagarights.com' target='_blank'>www.vagarights.com</a>" : "")."</div>"
						);					
					}
					break;
				}
			}
		}
		if($t_entity->get("nationality")){
			print "<span class='caption'>".$t_entity->get("nationality")."</span><!-- end caption --><br />";
		}
		if($t_entity->get("style_school")){
			print "<span class='caption'>".$t_entity->get("style_school", array("convertCodesToDisplayText" => true, "delimiter" => ", "))."</span><!-- end caption --><br />";
		}
		if($t_entity->get("fields_mediums")){
			print "<span class='caption'>".$t_entity->get("fields_mediums", array("convertCodesToDisplayText" => true, "delimiter" => ", "))."</span><!-- end caption --><br />";
		}
?>
	</div><!--end ad_portrait -->

	<div id="ad_maincontent">
		<div id="ad_maincontentCol1"><div>
<?php
		# --- not sure if indexing notes or scope notes has the descriptive text for entities
		if($t_entity->get("ca_entities.scope_notes")){
			print "<div class='bio'>".$t_entity->get("ca_entities.scope_notes")."</div><!-- end bio -->";
		}
		if($t_entity->get("ca_entities.indexing_notes")){
			print "<div class='bio'>".$t_entity->get("ca_entities.indexing_notes")."</div><!-- end bio -->";
		}
?>
		</div></div><!--end ad_maincontentCol1-->
		<div id="ad_maincontentCol2">
<?php
}
		// set parameters for paging controls view
		$this->setVar('other_paging_parameters', array(
			'entity_id' => $vn_entity_id,
			'detail_type' => 'entity_detail'
		));
		print $this->render('related_objects_grid.php');

if (!$this->request->isAjax()) {
?>
		</div><!--end ad_maincontentCol2-->
	</div><!--end ad_maincontent-->

	<div class="clear padded"></div>
<?php

	# --- coorporations
	$va_corps = $t_entity->get("ca_entities", array("restrictToTypes" => array("corporation"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
	# --- occurrences
	$va_occurrences = $t_entity->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
	if((sizeof($va_occurrences) > 0) || (sizeof($va_corps) > 0)){	
?>
		<div class="ad_col"><div>
			<span class="listhead caps"><?php print _t("Organizations and Events"); ?></span>
			<ul>
<?php
		foreach($va_corps as $va_corp) {
			print "<li>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_corp["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_corp["entity_id"])) : $va_corp["label"])."<br/>(".$va_corp['relationship_typename'].")</li>";		
		}
		foreach($va_occurrences as $va_occurrence) {
			print "<li>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_occurrence["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_occurrence["occurrence_id"])) : $va_occurrence["label"])."<br/>(".$va_occurrence['relationship_typename'].")</li>";		
		}
?>
			</ul>
		</div></div><!--end ad_col 1 -->
<?php
	}

	# --- entities
	$va_entities = $t_entity->get("ca_entities", array("restrictToTypes" => array("individual"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
	if(sizeof($va_entities) > 0){	
?>
		<div class="ad_col"><div>
			<span class="listhead caps"><?php print _t("Social Networks"); ?></span>
			<ul>
<?php
			foreach($va_entities as $va_entity) {
				print "<li>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])."<br/>(".$va_entity['relationship_typename'].")</li>";		
			}
?>
			</ul>
		</div></div><!--end ad_col 2 -->
<?php
	}

	# --- list of artists from the same movements
	if($va_style_ids = caExtractValuesByUserLocale($t_entity->get("ca_entities.style_school", array('returnAsArray' => true, 'delimeter' => ', ', 'checkAccess' => $va_access_values)))){
		$va_search_parts = "";
		$vs_search_text = "";
		foreach($va_style_ids as $vn_style_id){
			$va_search_parts[] = "ca_entities.style_school: ".$vn_style_id;
		}
		$vs_search_text = join(" OR ", $va_search_parts);
		$o_ent_search = new EntitySearch();
		# -- exclude the current entity from list
		$o_ent_search->addResultFilter("ca_entities.entity_id", "!=", $vn_entity_id);
		#print_r($o_ent_search->getResultFilters());
		$qr_entities = $o_ent_search->search($vs_search_text, array("sort" => "ca_entity_labels.lname", "checkAccess" => $va_access_values));
		if($qr_entities->numHits()){
			print "<div class='ad_col'><div><span class='listhead caps'>"._t("Artists from same movement")."</span><br/><ul>";
			while($qr_entities->nextHit()){
				print "<li>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, join(", ", $qr_entities->getDisplayLabels()), '', 'Detail', 'Entity', 'Show', array('entity_id' => $qr_entities->get("ca_entities.entity_id"))) : join(", ", $qr_entities->getDisplayLabels()))."</li>";
			}
			print "</ul></div></div><!--end ad_col 3 -->";
		}
	}

	$o_place_search = new PlaceSearch();
	$qr_places = $o_place_search->search("ca_entities.entity_id: ".$vn_entity_id, array("checkAccess" => $va_access_values));
	#while($qr_places->nextHit()){
	#	print $qr_places->get("ca_place_labels.name");
	#}
	if($qr_places->numHits()){
		$o_map = new GeographicMap(355, 225, 'map');
		$va_map_stats = $o_map->mapFrom($qr_places, "georeference", array("request" => $this->request, "checkAccess" => $va_access_values));
		if($va_map_stats['points'] > 0){
			print '<div class="ad_gmap">'.$o_map->render('HTML', array('delimiter' => "<br/>")).'</div><!-- end ad_gmap -->';
		}
	}				
?>
<div class="clear padded"></div>
<div id="ad_comments">
<?php
	$va_comments = $this->getVar("comments");
	if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
	<div id="ad_comments_list"><div class="ad_comments_list_bg">
<?php
		# --- user data --- comments --- images
?>
			<div id="numComments" style="float:right;">(<?php print sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment")); ?>)</div>
			<div class="listhead caps"><?php print _t("User Comments"); ?></div>
<?php
			foreach($va_comments as $va_comment){
				if($va_comment["media1"]){
?>
					<div class="commentImage" id="commentMedia<?php print $va_comment["comment_id"]; ?>">
						<?php print $va_comment["media1"]["tiny"]["TAG"]; ?>							
					</div><!-- end commentImage -->
<?php
					TooltipManager::add(
						"#commentMedia".$va_comment["comment_id"], $va_comment["media1"]["large_preview"]["TAG"]
					);
				}
				if($va_comment["comment"]){
?>					
				<div class="comment">
					<?php print $va_comment["comment"]; ?>
				</div>
<?php
				}
?>					
				<div class="byLine">
					<?php print $va_comment["author"].", ".$va_comment["date"]; ?>
				</div>
<?php
			}
?>
	</div></div>
<?php
	}
?>
	<div id="ad_comments_form">
<?php
	if($this->request->isLoggedIn()){
?>

		<div class="ad_comments_form_bg">
			<div class="listhead caps"><?php print _t("Contribute your story to the community archive"); ?></div>
			<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Entity', 'saveCommentRanking', array('entity_id' => $vn_entity_id)); ?>" name="comment" enctype='multipart/form-data'>
				<br/><?php print _t("Media"); ?><br/>
				<input type="file" name="media1"><br/><br/>
				<?php print _t("Comment"); ?><br/>
				<textarea name="comment" rows="5"></textarea><br/>
				<br><a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print _t("Save"); ?> &raquo;</a>
			</form>
		</div>
<?php
	}else{
		print "<div class='listhead'>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to share your story about this artist")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail', 'object_id' => $vn_object_id))."</div>";
	}
?>
	</div>
</div>
</div><!--end ad_content-->














	<script type="text/javascript">
		// Initialize the plugin
		$(document).ready(function () {
			$("div.ad_col").smoothDivScroll({
				visibleHotSpotBackgrounds: "always",
				hotSpotScrollingInterval: 45
			});
		
			$("div#ad_maincontentCol1").smoothDivScroll({
				visibleHotSpotBackgrounds: "always",
				hotSpotScrollingInterval: 45
			});
		});
	</script>
<?php
}
?>