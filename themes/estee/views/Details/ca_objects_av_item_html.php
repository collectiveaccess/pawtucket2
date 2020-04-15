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
 
 /* AV ITEMS */
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	
	$va_access_values = caGetUserAccessValues($this->request);

	$ps_last_tab = $this->request->getParameter("last_tab", pString);
	if($ps_last_tab){
		$this->request->user->setVar("last_tab", $ps_last_tab);
	}else{
		$ps_last_tab = $this->request->user->getVar("last_tab");
	}
	$va_options = $this->getVar("config_options");
	$vs_result_link = $this->getVar("resultsLink");
	$vs_previous_link = $this->getVar("previousLink");
	$vs_next_link = $this->getVar("nextLink");
	if($ps_last_tab && (strpos($vs_result_link, "collections") !==false)){
		$va_params = array();
 		$va_params["row_id"] = $t_object->getPrimaryKey();
 		$va_params["last_tab"] = $ps_last_tab;
		$vs_result_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', caGetOption('resultsLink', $va_options, _t('Back')), null, $va_params, ['aria-label' => _t('Back')]);	
		if(!$vs_previous_link && !$vs_next_link){
			# --- try to get it from the var set in estee/views/Collections/child_list_html.php
			$va_guide_result_ids = $this->request->user->getVar("guide_ids");
			if($va_guide_result_ids && sizeof($va_guide_result_ids)){
				if(in_array($t_object->get("object_id"), $va_guide_result_ids)){
					$vn_index = array_search($t_object->get("object_id"), $va_guide_result_ids);
					if($vn_index !== false){
						if($vn_index > 0){
							$vs_previous_link = caDetailLink($this->request, caGetOption('previousLink', $va_options, _t('Previous')), "", "ca_objects", $va_guide_result_ids[$vn_index - 1]);
						}
						if($vn_next_id = $va_guide_result_ids[$vn_index + 1]){
							$vs_next_link = caDetailLink($this->request, caGetOption('nextLink', $va_options, _t('Next')), "", "ca_objects", $vn_next_id);
						}
					}
				}
			}
		}
	}

?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		<?php print $vs_previous_link.$vs_result_link.$vs_next_link; ?>
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			<?php print $vs_previous_link.$vs_result_link; ?>
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-sm-6 col-md-6'>
<?php
					print '<div id="detailTools">';
					print "<div class='detailTool'><i class='material-icons inline'>mail_outline</i>".caNavLink($this->request, "Inquire About this Item", "", "", "contact", "form", array('object_id' => $vn_id, 'contactType' => 'inquiry'))."</div>";
					print "<div class='detailTool'><i class='material-icons inline'>bookmark</i><a href='#' onClick='caMediaPanel.showPanel(\"".caNavUrl($this->request, "", "Lightbox", "addItemForm", array('context' => $this->request->getAction(), 'object_id' => $vn_id))."\"); return false;'> Add to My Projects</a></div>";
				
					print "</div>";
					if($vs_rep_viewer = trim($this->getVar("representationViewer"))){
						$vs_use_statement = trim($t_object->get("ca_objects.use_statement"));
						if(!$vs_use_statement){
							$vs_use_statement = $this->getVar("use_statement");
						}
						print "<H6 class='detailUseStatement text-center'>".$vs_use_statement."</H6>";
						print $vs_rep_viewer;
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
						print "<div class='detailArchivalPlaceholder'><i class='material-icons inline'>file_copy</i></div>";
						print "<br/><div class='detailTool text-center'><i class='material-icons inline'>mail_outline</i>".caNavLink($this->request, "Request Digitization", "", "", "contact", "form", array('object_id' => $vn_id, 'contactType' => 'avScanRequest'))."</div>";

					}	
?>				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>

				</div><!-- end col -->
			
				<div class='col-sm-6 col-md-6'>
					{{{<ifdef code="ca_objects.idno"><div class="unit text-center">Object ID: ^ca_objects.idno</div></ifdef>}}}					
<?php
					$va_product_info = array();
					if($vs_type = $t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))){
						$va_product_info[] = $vs_type;
					}
					if($vs_brand = $t_object->get("ca_objects.brand", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
						$va_product_info[] = $vs_brand;
					}
					if(sizeof($va_product_info)){
						print "<div class='unit productInfo'><H6 class='objectType'>";
						print join(" &rsaquo; ", $va_product_info);
						print "</H6></div>";
					}
?>					
					
					{{{<ifdef code="ca_objects.preferred_labels.name"><H4 class="mainTitle">^ca_objects.preferred_labels.name</H4></ifdef>}}}
					<HR>
					{{{<div class="unit"><H6>Date</H6>^ca_objects.season_list ^ca_objects.manufacture_date<ifnotdef code="ca_objects.manufacture_date">Undated</ifnotdef></div>}}}
					{{{<ifdef code="ca_objects.archival_formats"><div class="unit"><H6>Archival Format</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.archival_formats</unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.select_categories"><div class="unit"><H6>Select Categories</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.select_categories</unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.language"><div class="unit"><H6>Language</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.language</unit></div></ifdef>}}}

					{{{<ifdef code="ca_objects.run_time"><div class="unit"><H6>Run Time</H6>^ca_objects.run_time</div></ifdef>}}}
					
<?php
					if($vs_av_format = $t_object->get("ca_objects.av_format", array("delimiter" => ", ", "convertCodesToDisplayText" => true))){
						print '<div class="unit"><H6>Format</H6>'.$vs_av_format.'</div>';
					}
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
							$va_note["general_notes_text"] = trim($va_note["general_notes_text"]);
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

					#  collection hierarchy
					$va_collection_hier_ids = array_pop($t_object->get("ca_collections.hierarchy.collection_id", array("returnAsArray" => true)));
					$vs_collection_hier = "";
					if($vs_tmp = $t_object->getWithTemplate('<ifcount min="1" code="ca_collections.related"><unit relativeTo="ca_collections.related"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></unit></ifcount>', array("checkAccess" => $va_access_values))){
						$vs_collection_hier = caDetailLink($this->request, $vs_tmp, '', 'ca_collections', $va_collection_hier_ids[0]);	
					}
					if($vs_collection_hier){
						print "<div class='unit parentObject'><h6>This ".strToLower($t_object->get('ca_objects.type_id', array("convertCodesToDisplayText" => true)))." is part of</h6>";
						print $vs_collection_hier."</div><HR/>";
					}
					
					if ($vn_pdf_enabled) {
						print "<div class='detailTools'><div class='detailTool'><i class='material-icons inline'>save_alt</i>".caDetailLink($this->request, "Download Summary", "", "ca_objects", $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div></div>";
					}
	?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
<?php				
				#  related objects
				
				if ($va_related_object_ids = $t_object->get('ca_objects.related.object_id', array('excludeTypes' => array('bulk', 'digital_media'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
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
							if($vs_tmp = $qr_related->get("ca_objects.archival_formats", array("convertCodesToDisplayText" => true))){
								$vs_caption .= " - ".$vs_tmp;
							}
							$vs_caption .= "<br/>";
							if(($vs_brand = $qr_related->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || ($vs_subbrand = $qr_related->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true)))){
								$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? ", " : "").$vs_subbrand."<br/>";
							}
							$vs_caption .= "<b>".$qr_related->get('ca_objects.preferred_labels')."</b>";
							$vs_tmp = $qr_related->getWithTemplate('<if rule="^ca_objects.type_id =~ /Container/">
																<div class="unit"><ifdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.display_date</unit></ifdef><ifnotdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit></ifnotdef><ifnotdef code="ca_objects.display_date,ca_objects.manufacture_date">Undated</ifnotdef></div>
															</if>
															<if rule="^ca_objects.type_id !~ /Container/">
																<div class="unit"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit><ifnotdef code="ca_objects.manufacture_date">Undated</ifnotdef></div>
															</if>');
							if($vs_tmp){
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
			<?php print $vs_next_link; ?>
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