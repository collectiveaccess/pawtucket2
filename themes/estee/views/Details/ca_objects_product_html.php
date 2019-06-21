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
					print "<div class='detailTool'><i class='material-icons inline'>mail_outline</i>".caNavLink($this->request, "Inquire About this Item", "", "", "contact", "form", array('object_id' => $vn_id, 'contactType' => 'inquiry'))."</div>";
					print "<div class='detailTool'><i class='material-icons inline'>bookmark</i><a href='#' onClick='caMediaPanel.showPanel(\"".caNavUrl($this->request, "", "Lightbox", "addItemForm", array('context' => $this->request->getAction(), 'object_id' => $vn_id))."\"); return false;'> Add to My Projects</a></div>";
				
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
						print "<div class='detailProductPlaceholder'><i class='material-icons inline'>photo</i></div>";
						print "<br/><div class='detailTool text-center'><i class='material-icons inline'>mail_outline</i>".caNavLink($this->request, "Request Digitiztion", "", "", "contact", "form", array('object_id' => $vn_id, 'contactType' => 'digitizationRequest'))."</div>";
					}	
?>				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
			
				</div><!-- end col -->
			
				<div class='col-sm-6 col-md-6'>
					<!--{{{<ifdef code="ca_objects.type_id"><div class="unit"><H6 class="objectType">^ca_objects.type_id</H6></div></ifdef>}}}
					{{{<ifdef code="ca_objects.brand"><div class="unit"><H6 class="objectType"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.brand</unit></H6></div></ifdef>}}}
					{{{<ifdef code="ca_objects.sub_brand"><div class="unit"><H6 class="objectType"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.sub_brand</H6></unit></div></ifdef>}}}
					
					<HR>-->
					{{{<ifdef code="ca_objects.idno"><div class="unit text-center">Object ID: ^ca_objects.idno</div></ifdef>}}}
<?php
					$va_product_info = array();
					if($vs_type = $t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))){
						$va_product_info[] = $vs_type;
					}
					if($vs_brand = $t_object->get("ca_objects.brand", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
						$va_product_info[] = $vs_brand;
					}
					if($vs_sub_brand = $t_object->get("ca_objects.sub_brand", array("delimiter" => ", "))){
						if(!preg_match("/[a-z]/", $vs_sub_brand)){
							$vs_sub_brand = ucwords(strtolower($vs_sub_brand));
						}
						$vs_sub_brand = "<span class='notransform'>".$vs_sub_brand."</span>";
						$va_product_info[] = $vs_sub_brand;
					}
					if(sizeof($va_product_info)){
						print "<div class='unit productInfo'><H6 class='objectType'>";
						print join(" &rsaquo; ", $va_product_info);
						print "</H6></div>";
					}
?>
					
					{{{<ifdef code="ca_objects.preferred_labels.name"><H4 class="mainTitle">^ca_objects.preferred_labels.name</H4></ifdef>}}}
					
					<hr/>
					{{{<if rule="^ca_objects.type_id !~ /Component/">
						<div class="row">
							<div class="col-sm-4">
								<ifdef code="ca_objects.codes.product_code"><div class="unit"><H6>Product Code</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.codes.product_code</unit></div></ifdef>
								<ifnotdef code="ca_objects.codes.product_code"><div class="unit"><H6>Product Code</H6>Not Available</div></ifnotdef>
							</div>
							<ifdef code="ca_objects.codes.batch_code"><div class="col-sm-4"><div class="unit"><H6>Batch Code</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.codes.batch_code</unit></div></div></ifdef>
							<ifdef code="ca_objects.codes.packaging_code"><div class="col-sm-4"><div class="unit"><H6>Packaging Code</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.codes.product_code</unit></div></div></ifdef>
						</div>
						<ifdef code="ca_objects.codes.product_code|ca_objects.codes.batch_code|ca_objects.codes.packaging_code"><HR></ifdef>
					</if>}}}
<?php
					if($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)) != "Component"){
						if($va_tmp = $t_object->get("ca_objects.shade", array("returnAsArray" => true))){
							$va_tmp_formatted = array();
							foreach($va_tmp as $vs_tmp){
								if(!preg_match("/[a-z]/", $vs_tmp)){
									$vs_tmp = ucwords(strtolower($vs_tmp));
								}
								$va_tmp_formatted[] = $vs_tmp;
							}
							print "<div class='unit'><H6>Shade</H6>".join("<br/>", $va_tmp_formatted)."</div>";
						}
						if($va_tmp = $t_object->get("ca_objects.fragrance", array("returnAsArray" => true))){
							$va_tmp_formatted = array();
							foreach($va_tmp as $vs_tmp){
								if($vs_tmp){
									if(!preg_match("/[a-z]/", $vs_tmp)){
										$vs_tmp = ucwords(strtolower($vs_tmp));
									}
									$va_tmp_formatted[] = $vs_tmp;
								}
							}
							if(sizeof($va_tmp_formatted)){
								print "<div class='unit'><H6>Fragrance</H6>".join("<br/>", $va_tmp_formatted)."</div>";
							}
						}
					}
?>					
					{{{<if rule="^ca_objects.type_id !~ /Component/">
						<ifdef code="ca_objects.shade|ca_objects.fragrance"><HR></ifdef>
						<ifdef code="ca_objects.size"><div class="unit"><H6>Size/Weight</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.size</unit></div></ifdef>
						<ifdef code="ca_objects.application"><div class="unit"><H6>Application</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.application</unit></div></ifdef>
						<ifdef code="ca_objects.size|ca_objects.application"><HR></ifdef>
					
					</if>}}}
					{{{<ifdef code="ca_objects.marketing"><div class="unit"><H6>Marketing Category</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.marketing</unit></div></ifdef>}}}
					
<?php
					$vb_close_row = false;
					if($t_object->get("ca_objects.season_list") || $t_object->get("ca_objects.manufacture_date") || $t_object->get("ca_objects.launch_display_date") || $t_object->get("ca_objects.launch_date.launch_date_value")){
						print "<div class='row'>";
						$vb_close_row = true;
					}
?>
					{{{<ifdef code="ca_objects.season_list|ca_objects.manufacture_date"><div class="col-sm-6"><div class="unit"><H6>Date</H6>^ca_objects.season_list<ifdef code="ca_objects.season_list,ca_objects.manufacture_date"> </ifdef>^ca_objects.manufacture_date</div></div></ifdef>}}}
					{{{<ifdef code="ca_objects.launch_display_date|ca_objects.launch_date.launch_date_value"><div class="col-sm-6"><div class="unit"><H6>Launch Date</H6>^ca_objects.launch_display_date<ifdef code="ca_objects.launch_display_date,ca_objects.launch_date.launch_date_value"> </ifdef>^ca_objects.launch_date.launch_date_value</div></div></ifdef>}}}
<?php
					if($vb_close_row){
						print "</div>";
					}
?>
					{{{<ifdef code="ca_objects.marketing|ca_objects.season_list|ca_objects.manufacture_date|ca_objects.launch_display_date|ca_objects.launch_date.launch_date_value"><HR></ifdef>}}}
					{{{<if rule="^ca_objects.type_id !~ /Component/">
						<ifdef code="ca_objects.price"><div class="unit"><H6>Sold for</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.price</unit></div></ifdef>
						<ifdef code="ca_objects.packaging"><div class="unit"><H6>Packaging Note</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.packaging</unit></div></ifdef>
					</if>}}}
					
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
					$va_notes = $t_object->get("ca_objects.object_notes", array("returnWithStructure" => true, "convertCodesToDisplayText" => true));
					if(is_array($va_notes) && sizeof($va_notes)){
						$va_notes = array_pop($va_notes);
						foreach($va_notes as $va_note){
							$va_note["object_note_value"] = trim($va_note["object_note_value"]);
							if($va_note["object_note_value"] && strToLower($va_note["object_note_status"]) == "unrestricted"){
								$va_notes_filtered[] = ucfirst(strtolower($va_note["object_note_value"]));
							}
						}
						if(sizeof($va_notes_filtered)){
							print '<div class="unit"><H6>Notes</H6>';
							print join("<br/>", $va_notes_filtered);
							print '</div>';
							$vb_notes_output = true;
						}
					}
					if(strToLower($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))) == "product"){
						if($vb_notes_output || $t_object->get("ca_objects.price")  || $t_object->get("ca_objects.packaging")){
							print "<hr/>";
						}	
					}else{
						if($vb_notes_output){
							print "<hr/>";
						}
					}

					#  parent
				
					if ($vn_parent_object_id = $t_object->get('ca_objects.parent.object_id', array('checkAccess' => $va_access_values))) {
						$t_parent = new ca_objects($vn_parent_object_id);
						# - if this is a product child of another product, label it part
						$vs_part_label = "Component";
						if(strToLower($t_object->get("ca_objects.type_id")) != "component"){
							$vs_part_label = "Part";
						}
						print "<div class='parentObject'><h6>Is A ".$vs_part_label." Of</h6>";
						$vs_caption = "";
						$vs_caption .= $t_parent->get("ca_objects.preferred_labels").". ";
						$vs_shade = $t_parent->get("ca_objects.shade");
						if(!preg_match("/[a-z]/", $vs_shade)){
							$vs_shade = ucwords(strtolower($vs_shade));
						}
						if($vs_shade){
							$vs_caption .= $vs_shade;
						}
						$vs_fragrance = $t_parent->get("ca_objects.fragrance");
						if(!preg_match("/[a-z]/", $vs_fragrance)){
							$vs_fragrance = ucwords(strtolower($vs_fragrance));
						}
						if($vs_fragrance){
							if($vs_shade){
								$vs_caption .= "; ";
							}
							$vs_caption .= $vs_fragrance;
						}
						if($vs_shade || $vs_fragrance){
							$vs_caption .= ". ";
						}
						if($vs_man_date = trim($t_parent->get("ca_objects.season_list")." ".$t_parent->get("ca_objects.manufacture_date"))){
							$vs_caption .= $vs_man_date." ";
						}
						if($vs_product_code = $t_parent->get("ca_objects.codes.product_code")){
							$vs_caption .= "(".$vs_product_code.")";
						}
						
						print caDetailLink($this->request, $vs_caption, '', 'ca_objects', $t_parent->get('ca_objects.object_id'));
						print "</div><hr/>";
					}
					
					#  child components (can be product or product component)
				
					if ($va_child_object_ids = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						$qr_children = caMakeSearchResult('ca_objects', $va_child_object_ids);
						
						$va_child_info_fields = array("shade", "fragrance", "codes.product_code");
						if($qr_children->numHits()){
							$vb_heading_output = false;
							while ($qr_children->nextHit()) {
								if(!$vb_heading_output){
									$t_list_item = new ca_list_items($qr_children->get("type_id"));
									$vs_tmp = "";
									switch($t_list_item->get("idno")){
										case "component":
											$vs_tmp = "Component".((sizeof($va_child_object_ids) > 1) ? "s" : "");
										break;
										# -------------------
										case "product":
											$vs_tmp = "Includes";
										break;
										# -------------------
									}
									print "<div class='childObjects'><h4>".$vs_tmp."</h4><br/>";
									$vb_heading_output = true;
								}
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
										if(in_array($vs_child_info_field, array("fragrance", "shade"))){
											if(!preg_match("/[a-z]/", $vs_tmp)){
												$vs_tmp = ucwords(strtolower($vs_tmp));
											}
											$va_child_info[] = $vs_tmp;
										}else{
											$va_child_info[] = $vs_tmp;
										}
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
							if($vs_tmp = $qr_related->get("ca_objects.archival_types", array("convertCodesToDisplayText" => true))){
								$vs_caption .= " - ".$vs_tmp;
							}
							$vs_caption .= "<br/>";
							$vs_subbrand = $qr_related->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true));
							if(!preg_match("/[a-z]/", $vs_subbrand)){
								$vs_subbrand = ucwords(strtolower($vs_subbrand));
							}
							if(($vs_brand = $qr_related->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || $vs_subbrand){
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