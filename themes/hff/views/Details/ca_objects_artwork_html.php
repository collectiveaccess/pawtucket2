<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_artwork_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
	$va_access_values = caGetUserAccessValues($this->request);
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
			<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download Printable PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				<div class="unit">
					<small>{{{ca_objects.idno}}}</small>
					{{{<ifdef code="ca_objects.art_numbers.id_value"><unit relativeTo="ca_objects" delimiter="; "><if rule="^ca_objects.art_numbers.id_types =~ /Studio/"><br/>^ca_objects.art_numbers.id_value</if></unit></ifdef>}}}
					<br/>{{{<unit>^ca_objects.type_id</unit>}}}
				</div>
				<HR>
				<div class="unit">
<?php
					$va_artists = $t_object->get("ca_entities", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToRelationshipTypes" => array("artist")));
					if(is_array($va_artists) && sizeof($va_artists)){
						$va_tmp = array();
						foreach($va_artists as $va_artist){
							$va_tmp[] = caNavLink($this->request, $va_artist["displayname"], "", "", "MultiSearch", "Index", array("search" => $va_artist["displayname"]));
						}
						print join(", ",$va_tmp)."<br/>";
					}
					$vs_title = $t_object->get("ca_objects.preferred_labels.name");
					if($vs_title){
						print italicizeTitle($vs_title)."<br/>";
					}
					$vs_alt_title = $t_object->get("ca_objects.nonpreferred_labels.name", array("delimiter" => ", "));
					if($vs_alt_title){
						print "<small>".italicizeTitle($vs_alt_title)."</small><br/>";
					}
?>
					{{{<ifdef code="ca_objects.common_date">^ca_objects.common_date<br/></ifdef>}}}				
					{{{<ifdef code="ca_objects.medium_notes.medium_notes_text">^ca_objects.medium_notes.medium_notes_text<br/></ifdef>}}}				
<?php
					$vs_dimensions = trim(str_replace("artwork", "", $t_object->get("ca_objects.dimensions.display_dimensions")));
					if($vs_dimensions){
						print $vs_dimensions."<br/>";
					}
?>
					{{{<ifdef code="ca_objects.recto_inscriptions.inscriptions_text">^ca_objects.recto_inscriptions.inscriptions_text<br/></ifdef>}}}				
					{{{<ifdef code="ca_objects.verso_inscriptions.verso_text">^ca_objects.verso_inscriptions.verso_text<br/></ifdef>}}}				
				</div>
				<HR>
				
<?php
				if($va_provenance = $t_object->get("ca_occurrences", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToTypes" => array("provenance")))){
					$t_obj_x_occ = new ca_objects_x_occurrences();
					$va_current_collection = array();
					$va_provenance_display = array();
					foreach($va_provenance as $va_provenance_info){
						$t_obj_x_occ->load($va_provenance_info["relation_id"]);
						$vs_date = $t_obj_x_occ->get("effective_date");
						$vs_credit_accession = $t_obj_x_occ->get("interstitial_notes");
						# --- yes no values are switched in this list
						if(strToLower($t_obj_x_occ->get("ca_objects_x_occurrences.current_collection", array("convertCodesToDisplayText" => true))) == "no"){
							$va_current_collection[] = $va_provenance_info["name"].(($vs_date) ? ", ".$vs_date : "").(($vs_credit_accession) ? ", ".$vs_credit_accession : "");
							
						}else{
							$va_provenance_display[] = $va_provenance_info["name"].(($vs_date) ? ", ".$vs_date : "").(($vs_credit_accession) ? ", ".$vs_credit_accession : "");
							#$va_provenance_display[] = $va_provenance_info["name"].(($vs_date) ? ", ".$vs_date : "")." (".$va_provenance_info["relationship_typename"].")";
						}
					}
					if(sizeof($va_current_collection)){
						print "<div class='unit'><H6>Current Collection</H6>".join("<br/>", $va_current_collection)."</div>";
					}
					if(sizeof($va_provenance_display)){
						print "<div class='unit'><H6>Provenance</H6>".join("<br/>", $va_provenance_display)."</div>";
					}
				}
				if($va_exhibitions = $t_object->get("ca_occurrences", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToTypes" => array("exhibition"), "sort" => "ca_occurrences.common_date"))){
					$t_occ = new ca_occurrences();
					print "<div class='unit'><H6>Exhibition History</H6>";
					$t_objects_x_occurrences = new ca_objects_x_occurrences();
					foreach($va_exhibitions as $va_exhibition){
						$t_occ->load($va_exhibition["occurrence_id"]);
						$vs_originating_venue 	= $t_occ->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='originator' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values));
						$vs_title = italicizeTitle($va_exhibition["name"]);
						$vs_date = $t_occ->get("ca_occurrences.exhibition_dates_display", array("delimiter" => "<br/>"));
						if(!$vs_date){
							$vs_date = $t_occ->get("ca_occurrences.common_date");
						}
						# --- interstitial
						$va_relations = $t_occ->get("ca_objects_x_occurrences.relation_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
						foreach($va_relations as $vn_relationship_id){
							$t_objects_x_occurrences->load($vn_relationship_id);
							if($t_objects_x_occurrences->get("object_id") == $t_object->get("ca_objects.object_id")){
								break;
							}
						}
						$va_interstitial = array();
						$vs_interstitial = "";
						if($vs_tmp = $t_objects_x_occurrences->get("checklist_number")){
							$va_interstitial[] = $vs_tmp;
						}
						if($vs_tmp = $t_objects_x_occurrences->get("exhibition_title")){
							$va_interstitial[] = $vs_tmp;
						}
						if($vs_tmp = $t_objects_x_occurrences->get("citation")){
							$va_interstitial[] = $vs_tmp;
						}
						if($vs_tmp = $t_objects_x_occurrences->get("exh_remarks")){
							$va_interstitial[] = $vs_tmp;
						}
						if($vs_tmp = $t_objects_x_occurrences->get("source")){
							$va_interstitial[] = $vs_tmp;
						}
						if(sizeof($va_interstitial)){
							$vs_interstitial = ", ".join(", ", $va_interstitial);
						}
						print caDetailLink($this->request, (($vs_originating_venue) ? $vs_originating_venue.", " : "").$vs_title.(($vs_date) ? ", ".$vs_date : ""), '', 'ca_occurrences', $va_exhibition["occurrence_id"]).$vs_interstitial."<br/>";
					}
					print "</div>";
				}
				if($va_literatures = $t_object->get("ca_occurrences", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToTypes" => array("literature")))){
					$t_occ = new ca_occurrences();
					print "<div class='unit'><H6>Literature References</H6>";
					$t_objects_x_occurrences = new ca_objects_x_occurrences();
					foreach($va_literatures as $va_literature){
						$t_occ->load($va_literature["occurrence_id"]);
						$vs_title = "";
						if($vs_tmp = $t_occ->get("ca_occurrences.lit_citation")){
							$vs_title = $vs_tmp;
						}else{
							$vs_title = $t_occ->get("ca_occurrences.preferred_labels");
						}
						# --- interstitial
						$va_relations = $t_occ->get("ca_objects_x_occurrences.relation_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
						foreach($va_relations as $vn_relationship_id){
							$t_objects_x_occurrences->load($vn_relationship_id);
							if($t_objects_x_occurrences->get("object_id") == $t_object->get("ca_objects.object_id")){
								break;
							}
						}
						$vs_interstitial = "";
						if($vs_tmp = $t_objects_x_occurrences->get("source")){
							$vs_interstitial = ", ".$vs_tmp;
						}
						print caDetailLink($this->request, $vs_title, '', 'ca_occurrences', $va_literature["occurrence_id"]).$vs_interstitial."<br/>";
					}
					print "</div>";
				}
?>
				{{{<ifdef code="ca_objects.remarks"><div class='unit'><h6>Remarks</h6>^ca_objects.remarks</div></ifdef>}}}
				
						
			</div><!-- end col -->
		</div><!-- end row -->
		
		
		
<?php
				$va_rel_artworks = $t_object->get("ca_objects.related.object_id", array("checkAccess" => $va_access_values, "restrictToTypes" => array("artwork", "art_HFF", "edition_HFF", "art_nonHFF", "edition_nonHFF"), "returnAsArray" => true));
				if(is_array($va_rel_artworks) && sizeof($va_rel_artworks)){
					$qr_res = caMakeSearchResult("ca_objects", $va_rel_artworks);
					$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'><i class='fa fa-picture-o fa-2x'></i></div>";
?>
					<div class="row">
						<div class="col-sm-12">
							<br/><hr/><br/><H5>Related Works</H5>
						</div>
					</div>
					<div class='row'>
<?php
					while($qr_res->nextHit()){
						$vn_id = $qr_res->get("ca_objects.object_id");
						$vs_idno_detail_link 	= "<small>".caDetailLink($this->request, $qr_res->get("ca_objects.idno"), '', 'ca_objects', $vn_id)."</small><br/>";
						$vs_label_detail_link 	= caDetailLink($this->request, italicizeTitle($qr_res->get("ca_objects.preferred_labels")), '', 'ca_objects', $vn_id).(($qr_res->get("ca_objects.common_date")) ? ", ".$qr_res->get("ca_objects.common_date") : "");
						if(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values)))){
							$vs_thumbnail = $vs_default_placeholder_tag;
						}
						$vs_info = null;
						$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $vn_id);				

						print "<div class='bResultItemCol col-xs-12 col-sm-6 col-md-3'>
			<div class='bResultItem' id='row{$vn_id}' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
				<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
				<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
					<div class='bResultItemText'>
						{$vs_idno_detail_link}{$vs_label_detail_link}
					</div><!-- end bResultItemText -->
				</div><!-- end bResultItemContent -->
			</div><!-- end bResultItem -->
		</div><!-- end col -->";

						
					}
					print "</div><!-- end row -->";
					
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