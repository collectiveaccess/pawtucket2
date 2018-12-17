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
				<div class='col-sm-6 col-md-6'>
<?php
					print '<div id="detailTools">';
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Inquire About this Item", "", "", "contact", "form", array('object_id' => $vn_id, 'contactType' => 'inquiry'))."</div>";
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span><a href='#' onClick='caMediaPanel.showPanel(\"".caNavUrl($this->request, "", "Lightbox", "addItemForm", array('context' => $this->request->getAction(), 'object_id' => $vn_id))."\"); return false;'> Add to My Projects</a></div>";
				
					print "</div>";
					if($vs_rep_viewer = trim($this->getVar("representationViewer"))){
						print $vs_rep_viewer;
						$vs_use_statement = trim($t_object->get("ca_objects.use_statement"));
						if(!$vs_use_statement){
							$vs_use_statement = $this->getVar("use_statement");
						}
						print "<H6>".$vs_use_statement."</H6>";
?>
						<script type="text/javascript">
							jQuery(document).ready(function() {
								$('.dlButton').on('click', function () {
									return confirm('<?php print $vs_use_statement; ?>');
								});
							});
						</script>
<?php
					}else{
						if(strToLower($t_object->get("type_id", array("convertCodesToDisplayText" => true))) == "archival folder"){
							# --- folder
							# -- yes no values are switched in this configuration :(
							if(strToLower($t_object->get("completely_digitized", array("convertCodesToDisplayText" => true))) != "no"){
								print "<div class='detailArchivalPlaceholder'><span class='glyphicon glyphicon-folder-open'></span>";
								print "<br/><small>The full contents of this folder have not been digitized</small></div>";
								print "<br/><div class='detailTool text-center'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Request Scan Of Full Contents of Folder", "", "", "contact", "form", array('object_id' => $vn_id, 'contactType' => 'folderScanRequest'))."</div>";
							}
						}else{
							print "<div class='detailArchivalPlaceholder'><span class='glyphicon glyphicon-file'></span></div>";
							#print "<br/><div class='detailTool text-center'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Request Scan or Image", "", "", "contact", "form", array('object_id' => $vn_id, 'contactType' => 'digitizationRequest'))."</div>";
						}
						
					}	
?>				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>

				</div><!-- end col -->
			
				<div class='col-sm-6 col-md-6'>
					<!--{{{<ifdef code="ca_objects.type_id"><div class="unit"><H6 class="objectType">^ca_objects.type_id<ifdef code="ca_objects.archival_types"> - ^ca_objects.archival_types%delimiter=;_</ifdef></H6></div></ifdef>}}}
					{{{<ifdef code="ca_objects.brand"><div class="unit"><H6 class="objectType"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.brand</unit></H6></div></ifdef>}}}
					{{{<ifdef code="ca_objects.sub_brand"><div class="unit"><H6 class="objectType"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.sub_brand</H6></unit></div></ifdef>}}}-->
					
					
					{{{<ifdef code="ca_objects.idno"><div class="unit text-center">Object ID: ^ca_objects.idno</div></ifdef>}}}
					
					{{{<ifdef code="ca_objects.type_id|ca_objects.archival_types|ca_objects.brand|ca_objects.sub_brand"><div class="unit productInfo"><H6 class="objectType">^ca_objects.type_id<ifdef code="ca_objects.archival_types"> &rsaquo; ^ca_objects.archival_types%delimiter=,_</ifdef><ifdef code="ca_objects.brand"><br/><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.brand</unit></ifdef><ifdef code="ca_objects.sub_brand"> &rsaquo; <unit relativeTo="ca_objects" delimiter=", ">^ca_objects.sub_brand</unit></ifdef></H6></div></ifdef>}}}
					
					
					{{{<ifdef code="ca_objects.preferred_labels.name"><H4 class="mainTitle">^ca_objects.preferred_labels.name</H4></ifdef>}}}
					<HR>
					{{{<ifdef code="ca_objects.manufacture_date"><div class="unit"><H6>Date</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit></div></ifdef>}}}

<?php
					$va_entities = $t_object->get("ca_entities", array('returnWithStructure' => true, 'checkAccess' => $va_access_values));
					if(is_array($va_entities) && sizeof($va_entities)){
						$va_entities_by_type = array();
						$va_entities_sort = array();
						foreach($va_entities as $va_entity){
							$va_entities_sort[$va_entity["relationship_typename"]][] = $va_entity["displayname"];	
						}
						foreach($va_entities_sort as $vs_entity_type => $va_entities_by_type){
							print "<div class='unit'><H6>".ucfirst($vs_entity_type)."</H6>";
							print join(", ", $va_entities_by_type);
							print "</div>";
						}					
						print "<hr/>";
					}
					
					$vb_notes_output = false;
					$va_notes_filtered = array();
					$va_notes = $t_object->get("ca_objects.general_notes", array("returnWithStructure" => true, "convertCodesToDisplayText" => true));
					if(is_array($va_notes) && sizeof($va_notes)){
						$va_notes = array_pop($va_notes);
						foreach($va_notes as $va_note){
							$va_note["general_notes_text"] = trim($va_note["object_note_value"]);
							if($va_note["general_notes_text"] && strToLower($va_note["internal_external"]) == "unrestricted"){
								$va_notes_filtered[] = $va_note["general_notes_text"];
							}
						}
						if(sizeof($va_notes_filtered)){
							print '<div class="unit"><H6>Notes</H6>';
							print join("<br/>", $va_notes_filtered);
							print '</div>';
							$vb_notes_output = true;
						}
					}
					if($vb_notes_output){
						print "<HR/>";
					}

					#  parent - displayed as collection hierarchy and folder if available
					$vs_collection_hier = $t_object->getWithTemplate('<ifcount min="1" code="ca_collections.related"><unit relativeTo="ca_collections.related"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></unit></ifcount>', array("checkAccess" => $va_access_values));	
					if ($vn_parent_object_id = $t_object->get('ca_objects.parent_id', array("checkAccess" => $va_access_values))) {
						$t_parent = new ca_objects($vn_parent_object_id);
						$vs_caption = "";
						$vs_caption .= $t_parent->get("ca_objects.preferred_labels");
						if($t_parent->get("ca_objects.manufacture_date")){
							$vs_caption .= ", ".$t_parent->get("ca_objects.manufacture_date");
						}
						$vs_parent_folder = caDetailLink($this->request, $vs_caption, '', 'ca_objects', $t_parent->get('ca_objects.object_id'));
					}
					if($vs_collection_hier || $vs_parent_folder){
						print "<div class='unit parentObject'><h6>This ".$t_object->get('ca_objects.type_id', array("convertCodesToDisplayText" => true))." Is Part Of</h6>";
						print $vs_collection_hier;
						if($vs_parent_folder && $vs_collection_hier){
							print " > "; 
						}
						print $vs_parent_folder;
						print "</div><HR/>";
					}
					
					# --- collection parent display
?>
					<!--{{{<ifcount min="1" code="ca_collections.related"><div class='parentObject'><H4>This ^ca_objects.type_id Is Part Of</H4><br/><unit relativeTo="ca_collections.related"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></unit></div></ifcount>}}}-->
<?php				
					#  child archival items if this is a folder
				
					if ($va_child_object_ids = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						$qr_children = caMakeSearchResult('ca_objects', $va_child_object_ids);
						print "<div class='unit childObjects'><h4>Folder Contents</h4><br/>";
						$va_child_info_fields = array("shade", "fragrance", "codes.product_code");
						if($qr_children->numHits()){
							while ($qr_children->nextHit()) {
								$vs_icon = $qr_children->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values));
								print "<div class='unit row'>";
								if($vs_icon){
									print "<div class='col-xs-3'>";
									print caDetailLink($this->request, $vs_icon, '', 'ca_objects', $qr_children->get('ca_objects.object_id'));
									print "</div><div class='col-xs-9'>";
								}else{
									print "<div class='col-xs-12'>";
								}
								print $qr_children->get('ca_objects.preferred_labels', array('returnAsLink' => true));
								$va_child_info = array();
								foreach($va_child_info_fields as $vs_child_info_field){
									if($vs_tmp = $qr_children->get("ca_objects.".$vs_child_info_field, array("delimiter" => ", ")) ){
										$va_child_info[] = $vs_tmp;
									}
								}
								if(sizeof($va_child_info)){
									print "<br/>".join("; ", $va_child_info);
								}
								print "</div></div>";
							}
						}
						print "</div><hr/>";
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTools'><div class='detailTool'><span class='glyphicon glyphicon-download'></span>".caDetailLink($this->request, "Download Summary", "", "ca_objects", $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div></div>";
					}
	?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
<?php				
				#  related objects
				
				if ($va_related_object_ids = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
					$qr_related = caMakeSearchResult('ca_objects', $va_related_object_ids);
					print "<br/><hr></hr><div class='relatedObjects'><h4>Related Item".((sizeof($va_related_object_ids) > 1) ? "s" : "")."</h4><br/>";
					$va_related_info_fields = array("shade", "fragrance", "codes.product_code");
					if($qr_related->numHits()){
						$vn_c = 0;
						while ($qr_related->nextHit()) {
							$vn_c++;
							if($vn_c == 1){
								print "<div class='unit row'>";
							}
							print "<div class='col-xs-6 col-sm-3'>";
							if($vs_icon = $qr_related->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values))){
								print caDetailLink($this->request, $qr_related->get('ca_object_representations.media.iconlarge'), '', 'ca_objects', $qr_related->get('ca_objects.object_id'));
								print "<br/><br/>";
							}
							$vs_caption = "";
							$vs_caption .= $qr_related->get('ca_objects.type_id', array('returnAsLink' => true, 'convertCodesToDisplayText' => true));
							if($vs_tmp = $qr_related->get("ca_objects.archival_types", array("convertCodesToDisplayText" => true))){
								$vs_caption .= " - ".$vs_tmp;
							}
							$vs_caption .= "<br/>";
							if(($vs_brand = $qr_related->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || ($vs_subbrand = $qr_related->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true)))){
								$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? ", " : "").$vs_subbrand."<br/>";
							}
							$vs_caption .= "<b>".$qr_related->get('ca_objects.preferred_labels')."</b>";
							if($vs_tmp = $qr_related->getWithTemplate('<ifdef code="ca_objects.season_list|ca_objects.manufacture_date">^ca_objects.season_list<ifdef code="ca_objects.season_list,ca_objects.manufacture_date"> </ifdef>^ca_objects.manufacture_date</ifdef>')){
								$vs_caption .= " (".$vs_tmp.")";
							}
							print caDetailLink($this->request, $vs_caption, '', 'ca_objects', $qr_related->get('ca_objects.object_id'));
							
							
							print "</div>";
							
							
							if($vn_c == 4){
								print "</div><!-- end row -->";
								$vn_c = 0;
							}
						}
						if($vn_c > 0){
							print "</div><!-- end row -->";
						}
					}
					print "</div>";
				}
?>
				</div>
			</div><!-- end row -->
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