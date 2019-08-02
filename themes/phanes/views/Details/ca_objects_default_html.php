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
	$t_list = new ca_lists();
	$vn_obverse_type_id = $t_list->getItemIDFromList("object_representation_types", "obverse");
	$vn_reverse_type_id = $t_list->getItemIDFromList("object_representation_types", "reverse");
		
	# --- get representations
	$va_reps_obverse = $t_object->getRepresentations(array("large"), null, array("restrictToTypes" => array("obverse"), "checkAccess" => $va_access_values));
	$va_reps_reverse = $t_object->getRepresentations(array("large"), null, array("restrictToTypes" => array("reverse"), "checkAccess" => $va_access_values));
	$va_reps = array();
	if(is_array($va_reps_obverse) && sizeof($va_reps_obverse)){
		foreach($va_reps_obverse as $vn_rep_id => $va_rep_info){
			$va_reps[$vn_rep_id] = array("media" => $va_rep_info["tags"]["large"], "type" => "Obverse");
		}
	}
	if(is_array($va_reps_reverse) && sizeof($va_reps_reverse)){
		foreach($va_reps_reverse as $vn_rep_id => $va_rep_info){
			$va_reps[$vn_rep_id] = array("media" => $va_rep_info["tags"]["large"], "type" => "Reverse");
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
		<div class="container detailMainArea">
			<div class="row">
				<div class='col-sm-12 col-md-8 col-lg-7 col-lg-offset-1'>
<?php
			$va_title_fields = array("mint", "authority", "denomination", "date");
			$va_title_parts = array();
			foreach($va_title_fields as $vs_title_field){
				if($vs_tmp = $t_object->get("ca_objects.".$vs_title_field)){
					$va_title_parts[] = $vs_tmp;
				}
			}
			print "<H4>".join(", ", $va_title_parts)."</H4>";
?>
				</div>
				<div class='col-sm-12 col-md-4 col-lg-3'>
<?php
					print '<div id="detailTools">';
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
					if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						print "<div class='detailTool'>".$va_add_to_set_link_info["icon"]."<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array('object_id' => $t_object->get("object_id")))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>Add to ".$va_add_to_set_link_info["name_singular"]."</a></div>";
					}
					print '</div><!-- end detailTools -->';			
?>					
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
					<HR>
				</div>
			</div>

<?php
		if(is_array($va_reps) && sizeof($va_reps)){
?>
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>

<?php
					$t_rep = new ca_object_representations();
					$vn_col = 0;
					foreach($va_reps as $vn_rep_id => $va_rep){
						if($vn_col == 0){
							print "<div class='row detailMedia'>\n";
						}
						print "<div class='col-xs-12 col-sm-6'>";
						$t_rep->load($vn_rep_id);
						print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, "Detail", "GetMediaOverlay", null, array("id" => $t_object->get("object_id"), "representation_id" => $vn_rep_id, "display" => "detail", "context" => "coins", "overlay" => 1))."\"); return false;'>".$va_rep["media"]."</a>";
						print "<div class='detailMediaCaption'>".$va_rep["type"]."</div>";
						print caRepToolbar($this->request, $t_rep, $t_object, array("display" => "detail", "context" => "coins"));
						print "</div>\n";
						if($vn_col == 1){
							$vn_col = 0;
							print "</div><!-- end row-->\n";
						}else{
							$vn_col++;
						}
					}
					if($vn_col > 0){
						print "</div><!-- end row-->\n";
					}
?>				
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
					<hr></hr>
				</div>
			</div>
<?php
		}
?>

			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
					<div class="row">
						<div class="col-sm-4">
<?php
							$va_materiality_fields = array(
								#"Identifier" => "idno",
								"Weight" => "weight",
								"Material" => "material",
								"Diameter" => "diameter",
								"Measurements" => "measurements",
								"Axis" => "axis",
								"Object Attributes" => "object_attributes",
								"Original Intended Use" => "original_intended_use",
								"authenticity" => "Authenticity",
								"Post Manufacture Alterations" => "post_manufacture_alterations",
						/*		"Countermarks" => "ca_list_items", */
								"Materiality notes" => "materiality_notes",
							);
							$va_descriptive_fields = array(	
								"Obverse" => "obverse",
								"Reverse" => "reverse",
								"Obverse Inscription" => "obverse_inscription",
								"Reverse Inscription" => "reverse_inscription",
								"Obverse Symbol" => "obverse_symbol",
								"Reverse Symbol" => "reverse_symbol",
								"Inscriptions" => "inscriptions",
								"Monograms" => "monograms",
						/*		"Iconographic Classifications" => "ca_list_items", */
								"Mint" => "mint",
								"Region" => "region",
								"Denomination" => "denomination",
								"Weight Standard" => "weight_standard",
								"Authority" => "authority",
								"Dynasty" => "dynasty",
								"Person" => "person",
								"Magistrate" => "magistrate",
							);
							$va_classification_fields = array(	
								"Date" => "date",
								"Date On Object" => "dob",
								"Period" => "period",
								"Type (PELLA)" => "type",
								"Type (SCO)" => "type_sco",
								"Type" => "type_text",
								"Type URL" => "type_url",
								"Hoard" => "hoard",
								"Findspot" => "findspot"
							);
	
							print "<div class='unit'><H6>Identifier</H6>".$t_object->get("idno")."</div>";
							$vs_materiality = "";
							foreach($va_materiality_fields as $vs_label => $vs_field){
								if($vs_tmp = $t_object->get($vs_field, array("delimiter" => ", "))){
									$vs_materiality .= "<div class='unit'><H6>".$vs_label."</H6>".$vs_tmp."</div>";
								}
							}
							$va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("obverse_countermark")));
							if(is_array($va_list_items) && sizeof($va_list_items)){
								$va_terms = array();
								foreach($va_list_items as $va_list_item){
									$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "coins", array("facet" => "icon_facet", "id" => $va_list_item["item_id"]));
								}
								$vs_materiality .= "<div class='unit'><H6>Countermarks</H6>".join($va_terms, ", ")."</div>";	
							}
							if($vs_materiality){
								print "<h4>Materiality</h4>".$vs_materiality;
							}

	
							$vs_classification = "";
							foreach($va_classification_fields as $vs_label => $vs_field){
								if($vs_tmp = $t_object->get($vs_field, array("delimiter" => ", "))){
									$vs_classification .= "<div class='unit'><H6>".$vs_label."</H6>".$vs_tmp."</div>";
								}
							}
							if($vs_classification){
								print "<h4>Classification</h4>".$vs_classification;
							}

							$vs_descriptive = "";
							foreach($va_descriptive_fields as $vs_label => $vs_field){
								if($vs_tmp = $t_object->get($vs_field, array("delimiter" => ", "))){
									$vs_descriptive .= "<div class='unit'><H6>".$vs_label."</H6>".$vs_tmp."</div>";
								}
							}
							$va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true));
							if(is_array($va_list_items) && sizeof($va_list_items)){
								$va_terms = array();
								foreach($va_list_items as $va_list_item){
									$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "coins", array("facet" => "icon_facet", "id" => $va_list_item["item_id"]));
								}
								$vs_descriptive .= "<div class='unit'><H6>Iconographic Classification</H6>".join($va_terms, ", ")."</div>";	
							}
							if($vs_descriptive){
								print "<h4>Descriptive</h4>".$vs_descriptive;
							}
	
	
							
?>	
						</div>
						<div class="col-sm-4">
<?php
							# citation format: [Author].[Publicaton Date].[Publication Name], p.[Page Number(s)], [Item Number(s)]. Then, this is followed by the notes field from the edited coin Literature relationship
							$vs_literature_template = '<unit relativeTo="ca_occurrences"><ifcount code="ca_entities" restrictToRelationshipTypes="author" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=", ">^ca_entities.preferred_labels.displayname</unit>. </ifcount></unit>
														<ifdef code="ca_occurrences.date">^ca_occurrences.date. </ifdef>
														<ifdef code="ca_occurrences.preferred_labels.name">^ca_occurrences.preferred_labels.name</ifdef><unit relativeTo="ca_objects_x_occurrences"><ifdef code="ca_objects_x_occurrences.page_number">, ^ca_objects_x_occurrences.page_number</ifdef><ifdef code="ca_objects_x_occurrences.item_number">, ^ca_objects_x_occurrences.item_number</ifdef></unit><ifdef code="ca_occurrences.preferred_labels.name">. </ifdef>
														<unit relativeTo="ca_objects_x_occurrences"><ifdef code="ca_objects_x_occurrences.comments"><p>^ca_objects_x_occurrences.comments</p></ifdef></unit>';
							$vs_rel_publication = $t_object->getWithTemplate('<ifcount code="ca_occurrences" min="1" restrictToTypes="literature" restrictToRelationshipTypes="publication">
																				<div class="unit">
																					<H6>Publication<ifcount code="ca_occurrences" min="2" restrictToTypes="literature" restrictToRelationshipTypes="publication">s</ifcount></H6>
																					<unit relativeTo="ca_objects_x_occurrences" delimiter="<br/><br/>" restrictToTypes="literature" restrictToRelationshipTypes="publication">
																						'.$vs_literature_template.'
																					</unit>
																				</div>
																			</ifcount>');
							$vs_rel_crossreference = $t_object->getWithTemplate('<ifcount code="ca_occurrences" min="1" restrictToTypes="literature" restrictToRelationshipTypes="crossreference">
																				<div class="unit">
																					<H6>Cross-reference<ifcount code="ca_occurrences" min="2" restrictToTypes="literature" restrictToRelationshipTypes="crossreference">s</ifcount></H6>
																					<unit relativeTo="ca_objects_x_occurrences" delimiter="<br/><br/>" restrictToTypes="literature" restrictToRelationshipTypes="crossreference">
																						'.$vs_literature_template.'
																					</unit>
																				</div>
																			</ifcount>');
							$vs_rel_historical = $t_object->getWithTemplate('<ifcount code="ca_occurrences" min="1" restrictToTypes="literature" restrictToRelationshipTypes="reference">
																				<div class="unit">
																					<H6>Historical Literature</H6>
																					<unit relativeTo="ca_objects_x_occurrences" delimiter="<br/><br/>" restrictToTypes="literature" restrictToRelationshipTypes="reference">
																						'.$vs_literature_template.'
																					</unit>
																				</div>
																			</ifcount>');
							if($vs_rel_publication || $vs_rel_crossreference || $vs_rel_historical){
								print "<h4>Literature</h4>".$vs_rel_publication.$vs_rel_crossreference.$vs_rel_historical;
							}
?>
							{{{<ifcount min="1" code="ca_occurrences" restrictToTypes="sale,collection"><H4>Collection History</H4></ifcount>}}}
							{{{<ifcount min="1" code="ca_occurrences" restrictToTypes="sale"><div class='unit'><h6>Auction<ifcount min="2" code="ca_occurrences" restrictToTypes="sale">s</ifcount></h6>
									<unit relativeTo='ca_objects_x_occurrences' delimiter=' ' restrictToTypes='sale' sort='ca_occurrences.date' sortDirection='DESC'>
										<div class='unitSub'>^ca_occurrences.preferred_labels<ifdef code='ca_occurrences.sale_number'>, ^ca_occurrences.sale_number<ifdef code='ca_occurrences.date'>, ^ca_occurrences.date</ifdef><ifdef code='ca_objects_x_occurrences.lot_number'>, ^ca_objects_x_occurrences.lot_number</ifdef></ifdef>
										</div>
									</unit>
								</ifcount>}}}
<?php
							$va_collections = $t_object->get("ca_occurrences", array("returnWithStructure" => true, "restrictToTypes" => array("collection")));
							if(is_array($va_collections) && sizeof($va_collections)){
								$va_tmp = array();
								foreach($va_collections as $va_collection){
									$va_tmp[] = caNavLink($this->request, $va_collection["label"], "", "", "Browse", "coins", array("facet" => "collection_facet", "id" => $va_collection["occurrence_id"]));
								}
								print "<div class='unit'><h6>Collection".((sizeof($va_tmp) > 1) ? "s" : "")."</h6>".join($va_tmp, ", ")."</div>";	
							}
?>
						</div>
						<div class="col-sm-4">
<?php
							$va_fields_authorities = array(
								"Material" => "material_link",
								"Mint" => "mint_link",
								"Region" => "region_link",
								"Denomination" => "denomination_link",
								"Authority" => "authority_link",
								"Person" => "person_link",
								"Magistrate" => "magistrate_link",
								"Series" => "series",
								"Hoard" => "hoard_link"
							);
														
							$vs_authority = "";
							foreach($va_fields_authorities as $vs_label => $vs_field){
								$vs_nomisma_id = "";
								$vs_tmp = "";
								if($va_authority_terms = $t_object->get($vs_field, array("returnAsArray" => true))){
									$va_tmp = array();
									foreach($va_authority_terms as $vs_term){
										if($vs_term = trim($vs_term)){
											$vn_start = strpos($vs_term, "[");
											if($vn_start !== false){
												$vs_nomisma_id = substr($vs_term, $vn_start + 1);
												$vs_nomisma_id = str_replace("]", "", $vs_nomisma_id);
												if($vs_nomisma_id){
													$va_tmp[] = "<a href='http://www.nomisma.org/id/".$vs_nomisma_id."' target='_blank'>".$vs_term." <span class='glyphicon glyphicon-new-window'></span></a>";
												}
											}else{
												$va_tmp[] = $vs_term;
											}
											$vs_authority .= "<div class='unit'><H6>".$vs_label."</H6>".join("<br/>",$va_tmp)."</div>";
										}
									}
								}
							}
							if($vs_authority){
								print "<div class='authoritySection'><h4>Nomisma Authority Links</h4>".$vs_authority."</div>";
							}

?>
							{{{<ifdef code="ca_objects.historical_notes"><div class='notesSection'><h4>Historical Notes</h4>^ca_objects.historical_notes</div></ifdef>}}}	
						
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							{{{map}}}
						</div>
					</div>
				</div>
			</div>
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