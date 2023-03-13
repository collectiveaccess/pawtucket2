<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
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
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	$va_options = $this->getVar("config_options");
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
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-md-6 col-md-offset-3 text-center'>
					<H1>{{{^ca_objects.preferred_labels.name}}} {{{<if rule='(^ca_objects.type_id =~ /audio|moving/)'><ifcount code="ca_occurrences" restrictToTypes="event" min="1"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event"><br/>Event/Broadcast: <l>^ca_occurrences.preferred_labels.name</l> <l><span class="small"><i class="fa fa-external-link" aria-hidden="true"></i></span></l></unit></div></ifcount></if>}}}</H1>
					<div class='unit'><H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2></div>			
				</div>
				<div class='col-sm-12 col-md-3 text-center'>
<?php
					print "<div class='inquireButton'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default btn-small", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
?>
				</div>
			</div>
			<div class="row text-center">			
				<div class='col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3'>
<?php
				if($vs_rep_viewer = trim($this->getVar("representationViewer"))){			
					print $vs_rep_viewer;
					print '<div id="detailAnnotations"></div>';
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-2 col-xs-2", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0));
				}
				if($t_object->get("ca_object_representations.representation_id", array("checkAccess" => array(0)))){
?>
					<div class="unit">
						<b>{{{restricted_media}}}</b>
					</div>
<?php
				}
				if($vs_rep_viewer && $this->request->user->hasRole("staff")){
					print '<br/><div class="unit">'.caNavLink($this->request, "<span class='glyphicon glyphicon-download'></span> "._t("Download High Resolution Media"), "btn-default", "", "Detail", "DownloadMedia", array("object_id" => $t_object->get("object_id"), "download" => 1, "version" => "original")).'</div>';
				}		 				
				

				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>
				{{{<ifdef code="ca_objects.date"><div class="unit"><unit relativeTo="ca_objects.date" delimiter=", ">^ca_objects.date.date_value <ifdef code="ca_objects.date.date_types">(^ca_objects.date.date_types)</ifdef></unit></div></ifdef>}}}
				{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="Dedicated,Related,Publisher,Donor,Subject,Depicted"><div class="unit"><unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="Dedicated,Related,Publisher,Donor,Subject,Depicted"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.material_techniques"><div class="unit">^ca_objects.material_techniques%delimiter=,_</div></ifdef>}}}
				

				</div>
			</div>
			<div class="row">
				<div class='col-sm-12 col-lg-8 col-lg-offset-2'><div class="bgOffWhiteLight bgPadding">
					<div class="row">
						<div class='col-sm-12 col-md-6'>
							{{{<ifdef code="ca_objects.description"><div class="unit"><label>Description</label>^ca_objects.description</div></ifdef>}}}
							{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
							{{{<ifcount code="ca_collections" min="1"><div class="unit"><label>Collection</label><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
							{{{<ifdef code="ca_objects.parent_id"><div class="unit"><label>Part of</label><unit relativeTo="ca_objects.parent"><l>^ca_objects.preferred_labels.name</l></unit></div></ifdef>}}}
							{{{<ifcount code="ca_objects.children" min="1"><div class="unit"><label>Contains</label><unit relativeTo="ca_objects.children" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></div></ifcount>}}}
							{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="Publisher"><div class="unit"><label>Publisher</label><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="Publisher"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}

				
							<!-- exent; spacial coverage: photos/artifacts/documents -->
							{{{<ifdef code="ca_objects.extent_text"><div class="unit"><label>Extent</label>^ca_objects.extent_text</div></ifdef>}}}
							{{{<ifdef code="ca_objects.coverageSpacial"><div class="unit"><label>Spacial Coverage</label>^ca_objects.coverageSpacial</div></ifdef>}}}
				
							<!-- Library fields -->
							{{{<ifdef code="ca_objects.isbn"><div class="unit"><label>ISBN</label>^ca_objects.isbn</div></ifdef>}}}
							{{{<ifdef code="ca_objects.edition_statement"><div class="unit"><label>Edition Statement</label>^ca_objects.edition_statement</div></ifdef>}}}
							{{{<ifdef code="ca_objects.rights_statement"><div class="unit"><label>Rights Statement</label>^ca_objects.rights_statement</div></ifdef>}}}
							{{{<ifdef code="ca_objects.publication_information"><div class="unit"><label>Publication & Distribution Information</label>^ca_objects.publication_information</div></ifdef>}}}
							{{{<ifdef code="ca_objects.physical_description"><div class="unit"><label>Physical Description</label>^ca_objects.physical_description</div></ifdef>}}}
							{{{<ifdef code="ca_objects.library_series"><div class="unit"><label>Series Statement</label>^ca_objects.library_series</div></ifdef>}}}
							<!-- end Library fields -->
							<!-- vol; issue: documents/library -->
							{{{<ifdef code="ca_objects.volume_number"><div class="unit"><label>Volume Number</label>^ca_objects.volume_number</div></ifdef>}}}
							{{{<ifdef code="ca_objects.issue_number"><div class="unit"><label>Issue Number</label>^ca_objects.issue_number</div></ifdef>}}}
				
							<!-- Format tab: Photo/Artifact/Art_arch -->
							{{{<ifdef code="ca_objects.dimensions.dimensions_length|ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_depth|ca_objects.dimensions.dimensions_weight|ca_objects.dimensions.dimension_notes"><div class="unit"><label>Dimensions</label>
								<unit relativeTo="ca_objects.dimensions" delimiter="<br/>">
									<ifdef code="ca_objects.dimensions.dimensions_length">Length: ^ca_objects.dimensions.dimensions_length<br/></ifdef>
									<ifdef code="ca_objects.dimensions.dimensions_width">Width: ^ca_objects.dimensions.dimensions_width<br/></ifdef>
									<ifdef code="ca_objects.dimensions.dimensions_height">Height: ^ca_objects.dimensions.dimensions_height<br/></ifdef>
									<ifdef code="ca_objects.dimensions.dimensions_depth">Depth: ^ca_objects.dimensions.dimensions_depth<br/></ifdef>
									<ifdef code="ca_objects.dimensions.dimensions_weight">Weight: ^ca_objects.dimensions.dimensions_weight<br/></ifdef>
									<ifdef code="ca_objects.dimensions.dimension_notes">Notes: ^ca_objects.dimensions.dimension_notes<br/></ifdef>
								</unit>
							</ifdef>}}}
							{{{<ifdef code="ca_objects.photograph_format"><div class="unit"><label>Photograph Format (AAT)</label>^ca_objects.photograph_format%delimiter=,_</div></ifdef>}}}
							{{{<ifdef code="ca_objects.object_work_type"><div class="unit"><label>Object Work/Type (AAT)</label>^ca_objects.object_work_type%delimiter=,_</div></ifdef>}}}
							{{{<ifdef code="ca_objects.components_parts"><div class="unit"><label>Components/Parts</label>^ca_objects.components_parts%delimiter=,_</div></ifdef>}}}
							{{{<ifdef code="ca_objects.classification"><div class="unit"><label>Classification (AAT)</label>^ca_objects.classification%delimiter=,_</div></ifdef>}}}
							{{{<ifdef code="ca_objects.style"><div class="unit"><label>Style</label>^ca_objects.style%delimiter=,_</div></ifdef>}}}
							{{{<ifdef code="ca_objects.inscriptions"><div class="unit"><label>Inscriptions & Markings</label>^ca_objects.inscriptions%delimiter=,_&convertLineBreaks=1</div></ifdef>}}}
						</div>
						<div class='col-sm-12 col-md-6'>
							<!-- Library fields -->
							{{{<if rule='(^ca_objects.rare_book =~ /Yes/)'>
								<ifdef code="ca_objects.rare_book_info"><div class="unit"><label>Rare Book Cataloging</label>
								<ifdef code="ca_objects.rare_book_info.binding"><b>Binding</b><br/>^ca_objects.rare_book_info.binding<br/><br/></ifdef>
								<ifdef code="ca_objects.rare_book_info.rarebook_transcription"><b>Transcription of the Title</b><br/>^ca_objects.rare_book_info.rarebook_transcription<br/><br/></ifdef>
								<ifdef code="ca_objects.rare_book_info.rarebook_marks"><b>Marks/Inscriptions/Signatures</b><br/>^ca_objects.rare_book_info.rarebook_marks<br/><br/></ifdef>
								<ifdef code="ca_objects.rare_book_info.rarebook_bibhistnote"><b>Bibliographic/Historical Note</b><br/>^ca_objects.rare_book_info.rarebook_bibhistnote<br/><br/></ifdef>
								<ifdef code="ca_objects.rare_book_info.rarebook_provenance"><b>Provenance</b><br/>^ca_objects.rare_book_info.rarebook_provenance<br/><br/></ifdef>
							</div></ifdef></if>}}}
							<!-- end Library fields -->
							{{{<ifdef code="ca_objects.url.link_url"><div class="unit"><label>External Link</label><unit delimiter="<br/>"><a href="^ca_objects.url.link_url" target="_blank"><ifdef code="ca_objects.url.link_text">^ca_objects.url.link_text</ifdef><ifnotdef code="ca_objects.url.link_text">^ca_objects.url.link_url</ifnotdef></a></div></ifdef>}}}
							{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="Dedicated,Related"><div class="unit"><label>Related People & Organizations</label><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="Dedicated,Related"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
							{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1"><div class="unit"><label>Related Event<ifcount code="ca_occurrences" min="2" restrictToTypes="event">s</ifcount>/Broadcast<ifcount code="ca_occurrences" min="2" restrictToTypes="event">s</ifcount></label><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event"><l>^ca_occurrences.preferred_labels.name</l></unit></div></ifcount>}}}
				
		<?php
							$va_all_subjects = array();
							#$va_LcshSubjects = $t_object->get("ca_objects.lcsh_terms", array("returnAsArray" => true));
							$va_LcshSubjects = $t_object->get('ca_objects.lcsh_terms', ['includeValueIDs' => true, 'returnWithStructure' => true]);
							$va_LcshSubjects = $va_LcshSubjects[$t_object->get("ca_objects.object_id")];
							$va_LcshSubjects_processed = array();
							if(is_array($va_LcshSubjects) && sizeof($va_LcshSubjects)){
								foreach($va_LcshSubjects as $vs_LcshSubject_info){
									$vs_LcshSubject = "";
									$vs_LcshSubjects = $vs_LcshSubject_info["lcsh_terms"];
									if($vs_LcshSubjects && (strpos($vs_LcshSubjects, " [") !== false)){
										$vs_LcshSubject = mb_substr($vs_LcshSubjects, 0, strpos($vs_LcshSubjects, " ["));
									}
									$va_all_subjects[strToLower($vs_LcshSubject)] = caNavLink($this->request, $vs_LcshSubject, "", "", "Browse", "objects", array("facet" => "lcsh_terms_facet", "id" => $vs_LcshSubject_info["lcsh_terms_value_id"]));
						
								}
								#$vs_LcshSubjects = join("<br/>", $va_LcshSubjects_processed);
							}
					
							$t_list_item = new ca_list_items;
							if($va_keywords = $t_object->get("ca_objects.internal_keywords", array("returnAsArray" => true))){
								$va_keyword_links = array();
								foreach($va_keywords as $vn_kw_id){
									$t_list_item->load($vn_kw_id);
									#$va_all_subjects[strToLower($t_list_item->get("ca_list_item_labels.name_singular"))] = caNavLink($this->request, $t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Search", "objects", array("search" => $t_list_item->get("ca_list_item_labels.name_singular")));
									$va_all_subjects[strToLower($t_list_item->get("ca_list_item_labels.name_singular"))] = caNavLink($this->request, $t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Browse", "objects", array("facet" => "keyword_facet", "id" => $vn_kw_id));
								}
								#$vs_keyword_links = join("<br/>", $va_keyword_links);
							}
							
							#$va_lc_names = $t_object->get("ca_objects.lc_names", array("returnAsArray" => true));
							$va_lc_names = $t_object->get('ca_objects.lc_names', ['includeValueIDs' => true, 'returnWithStructure' => true]);
							$va_lc_names = $va_lc_names[$t_object->get("ca_objects.object_id")];
							$va_lc_names_processed = array();
							if(is_array($va_lc_names) && sizeof($va_lc_names)){
								foreach($va_lc_names as $vs_lc_names_info){
									$vs_lc_name = "";
									$vs_lc_names = $vs_lc_names_info["lc_names"];
									if($vs_lc_names && (strpos($vs_lc_names, " [") !== false)){
										$vs_lc_name = mb_substr($vs_lc_names, 0, strpos($vs_lc_names, " ["));
									}
									$va_all_subjects[strToLower($vs_lc_name)] = caNavLink($this->request, $vs_lc_name, "", "", "Browse", "objects", array("facet" => "loc_names_facet", "id" => $vs_lc_names_info["lc_names_value_id"]));
						
								}
								#$vs_lc_names = join("<br/>", $va_lc_names_processed);
							}
							$va_entities = $t_object->get("ca_entities", array("restrictToRelationshipTypes" => array("Subject","Depicted"), "returnWithStructure" => true, "checkAccess" => $va_access_values));
							$va_entities_processed = array();
							if(is_array($va_entities) && sizeof($va_entities)){
								foreach($va_entities as $va_entity){
									$va_all_subjects[strToLower($va_entity["displayname"])] = caDetailLink($this->request, $va_entity["displayname"], "", "ca_entities", $va_entity["entity_id"]);
						
								}
							}
							if(is_array($va_all_subjects) && sizeof($va_all_subjects)){
								ksort($va_all_subjects);
								$vs_subjects = join("<br/>", $va_all_subjects);
								print "<div class='unit'><label>Subjects/Keywords</label>".$vs_subjects."</div>";	
							}
?>
							{{{<ifdef code="ca_objects.rights.copyrightStatement"><div class="unit"><label>Copyright Statement</label>^ca_objects.rights.copyrightStatement</div></ifdef>}}}
							{{{<ifdef code="ca_objects.credit_line"><div class="unit"><label>Credit</label>^ca_objects.credit_line</div></ifdef>}}}

<?php
							if($vs_rep_viewer){
?>
								<div class="unit"><label>Rights and Restrictions</label>
									{{{media_rights_restrictions}}}
								</div>
<?php				
							}
?>

						</div>
					</div></div><!-- end bgOffWhiteLight -->
				</div>
			</div>

<?php
$va_related_objects = $t_object->get("ca_objects.related.object_id", array("returnAsArray" => true));
$t_list_item = new ca_list_items();
if(is_array($va_related_objects) && sizeof($va_related_objects)){
	$qr_related_objects = caMakeSearchResult("ca_objects", $va_related_objects);
	if($qr_related_objects->numHits()){
?>
			<div class="row">
				<div id="browseResultsContainer">
<?php
		while($qr_related_objects->nextHit()){
			if(!($vs_thumbnail = $qr_related_objects->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values)))){
				$t_list_item->load($qr_related_objects->get("type_id"));
				$vs_typecode = $t_list_item->get("idno");
				if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
					$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
				}else{
					$vs_thumbnail = $vs_default_placeholder_tag;
				}
			}
			$vs_info = null;
			$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $qr_related_objects->get("ca_objects.object_id"));				

?>
					<div class="resultItemColImg col-xs-6 col-sm-6 col-md-3"><div class="resultContentImg">
							<l><div class="resultImageImg"><?php print $vs_rep_detail_link; ?></div>
							<div class="resultTextImg"><small><?php print $qr_related_objects->getWithTemplate("<l>^ca_objects.idno</l>"); ?></small><br><?php print $qr_related_objects->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>"); ?></div>
							<a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array('object_id' => $qr_related_objects->get("ca_objects.object_id"))); ?>"); return false;' title='<?php print $va_add_to_set_link_info['link_text']; ?>'><?php print $va_add_to_set_link_info['icon']; ?></a>
					</div></div>
<?php			
		}
?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
<?php
	}
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