<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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

$t_object = 			$this->getVar("item");
$va_comments = 			$this->getVar("comments");
$va_tags = 				$this->getVar("tags_array");
$vn_comments_enabled = 	$this->getVar("commentsEnabled");
$vn_share_enabled = 	$this->getVar("shareEnabled");
$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
$vn_id =				$t_object->get('ca_objects.object_id');
$va_access_values = 	caGetUserAccessValues($this->request);

# --- get the placeholder graphic from the novamuse theme
$vn_rep_id = $this->getVar("representation_id");
$vs_placeholder = "";
if(!$vn_rep_id){		
	$va_themes = $t_object->get("novastory_category", array("returnAsArray" => true));
	if(sizeof($va_themes)){
		$t_list_item = new ca_list_items();
		foreach($va_themes as $k => $vs_list_item_id){
			$t_list_item->load($vs_list_item_id);
			if(caGetThemeGraphic($this->request, $t_list_item->get("idno").'.png')){
				$vs_placeholder = caGetThemeGraphic($this->request, $t_list_item->get("idno").'.png');
			}
		}
	}
	if(!$vs_placeholder){
		$vs_placeholder = caGetThemeGraphic($this->request, 'placeholders/placeholder.png');
	}
	$vs_placeholder = "<div class='detailPlaceholder'>".$vs_placeholder."</div>";
}


# --- get similar items by category
$va_categories = explode(",", $t_object->get('ns_category'));
$va_sim_items = array();

if(sizeof($va_categories)){
	$vn_category = trim($va_categories[0]);
	require_once(__CA_LIB_DIR__.'/Browse/ObjectBrowse.php');
	$o_browse = new ObjectBrowse();
	$o_browse->removeAllCriteria();
	$o_browse->addCriteria("category_facet", $vn_category);
	$o_browse->addCriteria("has_media_facet", 1);
	$o_browse->execute(array('checkAccess' => $va_access_values));
	$qr_sim_items = $o_browse->getResults();
	if($qr_sim_items->numHits()){
		# --- grab the first 50 items and shuffle array to randomize a bit
		$i = 0;
		while($qr_sim_items->nextHit() && $i < 50){
			if($qr_sim_items->get("ca_objects.object_id") != $vn_object_id){
				$va_labels = array();
				$va_labels = $qr_sim_items->getDisplayLabels($this->request);
				$vs_label = join("; ", $va_labels);
				$va_media_info = array();
				#$va_media_info = $qr_sim_items->getMediaInfo('ca_object_representations.media', 'iconlarge', null, array('checkAccess' => $va_access_values));
				$va_media_info = $qr_sim_items->getMediaInfo('ca_object_representations.media', 'widepreview', null, array('checkAccess' => $va_access_values));
				$vn_padding_top_bottom =  ((120 - $va_media_info["HEIGHT"]) / 2);
				#$va_sim_items[] = array("object_id" => $qr_sim_items->get("ca_objects.object_id"), "label" => $vs_label, "media" => $qr_sim_items->getMediaTag('ca_object_representations.media', 'iconlarge', array('checkAccess' => $va_access_values)), "idno" => $qr_sim_items->get("ca_objects.idno"), "padding" => $vn_padding_top_bottom);	
				$va_sim_items[] = array("object_id" => $qr_sim_items->get("ca_objects.object_id"), "label" => $vs_label, "media" => $qr_sim_items->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values)), "idno" => $qr_sim_items->get("ca_objects.idno"));	
				$i++;
			}				
		}
		# -- shuffle array
		shuffle($va_sim_items);
		# --- grab first 6 values in array
		$va_sim_items = array_slice($va_sim_items, 0, 6);
	}
}
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-7 '>
				<?php print $vs_placeholder; ?>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-4")); ?>
 				<div class="useRestrictions"><?= _t('Image use must be for education or personal purposes only.<br/>The contributing institution must be credited.'); ?></div>
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span><?= _t('Comments and tags'); ?> (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					#if ($vn_share_enabled) {
						#print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					#}
					print "<div class='detailTool'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavURL($this->request, '', 'Contact', 'form', array('object_id' => $vn_id))."\"); return false;' title='"._t('Ask the Curator')."'><span class='fa fa-question'></span>"._t('Ask a Curator')."</a></div><!-- end detailTool -->";

					print '</div><!-- end detailTools -->';
				}				

?>
			</div><!-- end col -->
			
			<div class='col-sm-5' style='padding-left:25px;'>
				<h6><?php print $t_object->get("ca_entities", array("restrictToRelationshipTypes" => array("repository"), "returnAsLink" => true, "checkAccess" => $va_access_values));?></h6>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<HR>
<?php				
				# --- identifier
				if($t_object->get('idno')){
					print "<div class='unit'><span class='name'>"._t("Accession number").": </span><span class='data'>".$t_object->get('idno')."</span></div>";
				}
				if($va_alt_name = $t_object->get('ca_objects.nonpreferred_labels', array('delimiter' => '<br/>'))){
					print "<div class='unit'><span class='name'>"._t("Alternate Title").": </span><span class='data'>".$va_alt_name."</span></div>";
				}
				# --- parent hierarchy info
				if($t_object->get('parent_id')){
					print "<div class='unit'><span class='name'>"._t("Part Of").":</span><span class='data'> ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', '', 'Detail', 'objects/'.$t_object->get('parent_id'))."</span></div>";
				}
				# --- category
				if($t_object->get('ns_category')){
					print "<div class='unit'><span class='name'>"._t("Category").": </span><span class='data'>".caNavLink($this->request, $t_object->get('ns_category', array('convertCodesToDisplayText' => true)), "", "", "Browse/objects", "facet/category_facet/id/".$t_object->get('ns_category'))."</span></div>";
				}
				if ($t_object->get('ns_objectType')) {
					print "<div class='unit'><span class='name'>"._t("Object type").": </span><span class='data'>".$t_object->get('ns_objectType')."</span></div>"; 
				}
				if ($t_object->get('ns_objectSubType')) {
					print "<div class='unit'><span class='name'>"._t("Object subtype").": </span><span class='data'>".$t_object->get('ns_objectSubType')."</span></div>"; 
				}				
				if ($va_entities = $t_object->getWithTemplate("<ifcount min='1' relativeTo='ca_objects_x_entities'><div class='unit'><unit relativeTo='ca_objects_x_entities' delimiter='<br/>' excludeRelationshipTypes='repository,source,conservator'><span class='upper name'>^relationship_typename<span>:</span> </span><span class='data'><unit relativeTo='ca_entities'><l>^ca_entities.preferred_labels</l></span></unit></unit></div></ifcount>")){
					print 	$va_entities;
				}
				
				if ($vs_date = $t_object->get('ca_objects.date')) {
					print "<div class='unit'><span class='name'>"._t("Date").": </span><span class='data'>".$vs_date."</span></div>";
				}
				if ($vs_materials = $t_object->get('ca_objects.materials')) {
					print "<div class='unit'><span class='name'>"._t("Materials").": </span><span class='data'>".$vs_materials."</span></div>";
				}
				if ($va_measurements = $t_object->get('ca_objects.measurements', array("returnWithStructure" => true, "units"=>"metric"))) {
					$va_meas = array();
					foreach ($va_measurements as $va_key => $va_measurements_t) {
						foreach ($va_measurements_t as $va_key => $va_measurement) {
							if ($va_measurement['dimensions_length']) {
								$va_meas[] = $va_measurement['dimensions_length']." L";
							}
							if ($va_measurement['dimensions_width']) {
								$va_meas[] = $va_measurement['dimensions_width']." W";
							}	
							if ($va_measurement['dimensions_height']) {
								$va_meas[] = $va_measurement['dimensions_height']." H";
							}	
							if ($va_measurement['dimensions_thick']) {
								$va_meas[] = $va_measurement['dimensions_thick']." Thick";
							}
							if ($va_measurement['dimensions_diam']) {
								$va_meas[] = $va_measurement['dimensions_diam']." Diameter";
							}
							if ($va_measurement['dimensions_depth']) {
								$va_meas[] = $va_measurement['dimensions_depth']." Depth";
							}
							if (sizeof($va_meas) > 0 ) {
								print "<div class='unit'><span class='name'>"._t("Measurements").": </span><span class='data'>".join(' x ', $va_meas);
								if ($va_measurement['dimensions_remarks']) {
									print $va_measurement['dimensions_remarks'];
								}
								print "</span></div>";	
							}																																	
						}
					}
				}							
				if ($vs_manuTech = $t_object->get('ca_objects.manuTech')) {
					print "<div class='unit'><span class='name'>"._t("Manufacturing Technique").": </span><span class='data'>".$vs_manuTech."</span></div>";
				}	
				if ($vs_brand = $t_object->get('ca_objects.brand')) {
					print "<div class='unit'><span class='name'>"._t("Brand").": </span><span class='data'>".$vs_brand."</span></div>";
				}
				if ($vs_model = $t_object->get('ca_objects.model')) {
					print "<div class='unit'><span class='name'>"._t("Model").": </span><span class='data'>".$vs_model."</span></div>";
				}
				if ($vs_signature = $t_object->get('ca_objects.signature')) {
					print "<div class='unit'><span class='name'>"._t("Signature").": </span><span class='data'>".$vs_signature."</span></div>";
				}
				if ($vs_marksLabel = $t_object->get('ca_objects.marksLabel')) {
					print "<div class='unit'><span class='name'>"._t("Marks/Label").": </span><span class='data'>".$vs_marksLabel."</span></div>";
				}
				if ($vs_serialNos = $t_object->get('ca_objects.serialNos')) {
					print "<div class='unit'><span class='name'>"._t("Serial Numbers").": </span><span class='data'>".$vs_serialNos."</span></div>";
				}
				if ($vs_patent = $t_object->get('ca_objects.patent')) {
					print "<div class='unit'><span class='name'>"._t("Patent").": </span><span class='data'>".$vs_patent."</span></div>";
				}	
				if ($vs_group = $t_object->get('ca_objects.group')) {
					print "<div class='unit'><span class='name'>"._t("Group").": </span><span class='data'>".$vs_group."</span></div>";
				}
				if ($vs_militUnit = $t_object->get('ca_objects.militUnit')) {
					print "<div class='unit'><span class='name'>"._t("Military Unit").": </span><span class='data'>".$vs_militUnit."</span></div>";
				}
				if ($vs_vesName = $t_object->get('ca_objects.vesName')) {
					print "<div class='unit'><span class='name'>"._t("Vessel Name").": </span><span class='data'>".$vs_vesName."</span></div>";
				}
				if ($vs_culture = $t_object->get('ca_objects.culture')) {
					print "<div class='unit'><span class='name'>"._t("Culture").": </span><span class='data'>".$vs_culture."</span></div>";
				}	
				if ($vs_fondsTitle = $t_object->get('ca_objects.fondsTitle')) {
					print "<div class='unit'><span class='name'>"._t("Fonds Title").": </span><span class='data'>".$vs_fondsTitle."</span></div>";
				}
				if ($vs_series = $t_object->get('ca_objects.series')) {
					print "<div class='unit'><span class='name'>"._t("Series").": </span><span class='data'>".$vs_series."</span></div>";
				}
				if ($vs_subSeries = $t_object->get('ca_objects.subSeries')) {
					print "<div class='unit'><span class='name'>"._t("Subseries").": </span><span class='data'>".$vs_subSeries."</span></div>";
				}
				if ($vs_file = $t_object->get('ca_objects.file')) {
					print "<div class='unit'><span class='name'>"._t("File").": </span><span class='data'>".$vs_file."</span></div>";
				}
				if ($vs_scopeContent = $t_object->get('ca_objects.scopeContent')) {
					print "<div class='unit'><span class='name'>"._t("Scope & Content").": </span><span class='data'>".$vs_scopeContent."</span></div>";
				}
				if ($vs_subject = $t_object->get('ca_objects.subject', array("delimiter" => ", "))) {
					print "<div class='unit'><span class='name'>"._t("Subject").": </span><span class='data'>".$vs_subject."</span></div>";
				}																																																																	
				if($t_object->get("narrative")){
?>
					<div class='unit'><span class='name'><?php print _t("Narrative"); ?>: </span><span class='data'><?php print $t_object->get("narrative", array("convertHTMLBreaks" => true)); ?></span></div>
<?php
				}
				if($t_object->get("description")){
?>
					<div class='unit'><span class='name'><?php print _t("Description"); ?>: </span><span class='data'><?php print $t_object->get("description", array("convertHTMLBreaks" => true)); ?></span></div>
<?php
				}
				if($t_object->get("historyUse")){
?>
					<div class='unit'><span class='name'><?php print _t("History of Use"); ?>: </span><span class='data'><?php print $t_object->get("historyUse", array("convertHTMLBreaks" => true)); ?></span></div>
<?php
				}
				if($t_object->get("cataloguerRem")){
?>
					<div class='unit'><span class='name'><?php print _t("Notes"); ?>: </span><span class='data'><?php print $t_object->get("cataloguerRem", array("convertHTMLBreaks" => true)); ?></span></div>
<?php
				}
				if ($va_manufacturer = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'restrictToRelationshipTypes' => 'manufacturer'))) {
					print "<div class='unit'><span class='name'>"._t("Manufacturer").": </span><span class='data'>".$va_manufacturer."</span></div>";
				}
				
				
				if ($edu = $t_object->get('ca_occurrences.occurrence_id', ['returnAsSearchResult' => true])) {
					
					while($edu->nextHit()) {
						$res[] = "<span class='data'>".$edu->get('ca_occurrences.preferred_labels.name', ['returnAsLink' => true, 'checkAccess' => $va_access_values])."</span>";
					}
					print "<div class='unit'><span class='name'>"._t("Educational resources").": </span>".join(", ", $res)."</div>\n";
				}
?>				
				

				{{{map}}}

				<div class="sharethis-inline-share-buttons"></div>	
<?php
			/*	if ($va_related_contributors = $t_object->get('ca_entities.entity_id', array('restrictToTypes' => array('member_institution'), 'returnAsArray' => true))) {
					foreach ($va_related_contributors as $va_key => $va_related_contributor) {
						$t_entity = new ca_entities($va_related_contributor);
						print "<div class='repository'>";
						print "<p class='label'>From the collection</p>";
						print "<p>".$t_entity->get('ca_entities.preferred_labels')."</p>";
						print "<p>".$t_entity->get('ca_entities.address.city').", ".$t_entity->get('ca_entities.address.stateprovince')."</p>";
						print "<div>".$t_entity->get('ca_entities.mem_inst_image', array('version' => 'medium', 'checkAccess' => $va_access_values))."</div>";
						print "<p>".caNavLink($this->request, 'More information', '', '', 'Detail', 'entities/'.$va_related_contributor)."</p>";
						print "</div>";
					}
				} */
?>							
						
			</div><!-- end col -->
		</div><!-- end row -->
		<hr style="margin-top:50px;">
		<div class="row" style="margin-bottom:50px;">
			<div class='col-sm-12'><h4 style="margin-bottom:30px;"><?= _t('Similar Items'); ?></h4></div>
<?php
				foreach ($va_sim_items as $va_key => $va_sim_item){
					print "<div class='col-sm-2'><div class='objTile'>";
					print "<div class='objImage'>".caNavLink($this->request, $va_sim_item['media'], '', '', 'Detail', 'objects/'.$va_sim_item['object_id'])."</div>";
					print caNavLink($this->request, $va_sim_item['label'], '', '', 'Detail', 'objects/'.$va_sim_item['object_id']);
					print "</div>";
					print "</div>";
				}
?>	
		</div>		
<?php
		$vs_in_set = "";
		$t_set = new ca_sets();
		$va_sets = $t_set->getSetsForItem("ca_objects", $t_object->get("object_id"), array('checkAccess' => $va_access_values));
		if (sizeof($va_sets) > 0) {
			foreach($va_sets as $vn_set_id => $va_set_t){
				foreach ($va_set_t as $va_id => $va_set) {
					$va_set_id = array($vn_set_id);
					#$va_items = $t_set->getPrimaryItemsFromSets($va_set_id, array("version" => "iconlarge", "checkAccess" => $va_access_values));
					$va_items = $t_set->getPrimaryItemsFromSets($va_set_id, array("version" => "medium", "checkAccess" => $va_access_values));
					$t_this_set = new ca_sets($vn_set_id);
					$t_user = new ca_users($t_this_set->get('ca_sets.user_id'));
					$vs_in_set.= "<div class='col-sm-3'><div class='setItemTile'>";
					foreach ($va_items as $vn_set_id => $va_item) {
						foreach ($va_item as $va_set_item_id => $va_set_item) {
							$vs_in_set.= "<div class='objImage'>".caNavLink($this->request, $va_set_item['representation_tag'], "", "", "Lightbox", "SetDetail", array("set_id" => $vn_set_id))."</div>";
						}
					}
					$vs_in_set.= caNavLink($this->request, $va_set["name"], "", "", "Lightbox", "SetDetail", array("set_id" => $vn_set_id));
					$vs_in_set.= "<p>"._t('created by: %1', $t_user->get('ca_users.user_name'))."</p>";
					$vs_in_set.= "</div>";
				}
			}
			print '<hr><div class="row" style="margin-bottom:30px;"><div class="col-sm-12"><h4 style="margin-bottom:30px;">'._t('Included in Galleries').'</h4></div>';
			print $vs_in_set;
			print '	</div><!-- end col --></div><!-- end row -->';
		}
?>	
</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>