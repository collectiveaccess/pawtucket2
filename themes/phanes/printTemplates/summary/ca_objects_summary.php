<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Object tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_object = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	


	$va_title_fields = array("mint", "authority", "denomination", "date");
	$va_title_parts = array();
	foreach($va_title_fields as $vs_title_field){
		if($vs_tmp = $t_object->get("ca_objects.".$vs_title_field)){
			$va_title_parts[] = $vs_tmp;
		}
	}

?>
	<div class="title">
		<h1 class="title"><?php print join(", ", $va_title_parts); ?></h1>
	</div>
	<div class="representationList">
		
<?php
	$va_reps = $t_object->getRepresentations(array("small", "medium"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print $va_rep['tags']['small']."\n";
		}else{
			# --- one rep - show medium rep
			print $va_rep['tags']['medium']."\n";
		}
	}
?>
	</div>
		<div class="column">
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
			print "<div class='unit'><H4>Identifier</H4>".$t_object->get("idno")."</div>";
			$vs_materiality = "";
			foreach($va_materiality_fields as $vs_label => $vs_field){
				if($vs_tmp = $t_object->get($vs_field, array("delimiter" => ", "))){
					$vs_materiality .= "<div class='unit'><H6>".$vs_label."</H6>".$vs_tmp."</div>";
				}
			}
			if($vs_tmp = $t_object->getWithTemplate('<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter=", " restrictToRelationshipTypes="obverse_countermark"><unit relativeTo="ca_list_items">^ca_list_items.preferred_labels.name_plural</unit></unit>')){
				$vs_materiality .= "<div class='unit'><H6>Countermarks</H6>".$vs_tmp."</div>";							
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
			if($vs_tmp = $t_object->getWithTemplate('<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter=", "><unit relativeTo="ca_list_items">^ca_list_items.preferred_labels.name_plural</unit></unit>')){
				$vs_descriptive .= "<div class='unit'><H6>Iconographic Classification</H6>".$vs_tmp."</div>";							
			}
			if($vs_descriptive){
				print "<h4>Descriptive</h4>".$vs_descriptive;
			}

?>				
		</div>
		<div class="column">
<?php
			$va_literature_fields = array(	
				"Cross-reference" => "crossreference",
				"Cross-reference Text" => "crossreference_text"
			);
			$vs_literature = "";
			foreach($va_literature_fields as $vs_label => $vs_field){
				if($vs_tmp = $t_object->get($vs_field, array("delimiter" => ", "))){
					$vs_literature .= "<div class='unit'><H6>".$vs_label."</H6>".$vs_tmp."</div>";
				}
			}
			$vs_rel_lit = $t_object->getWithTemplate('<ifcount code="ca_occurrences" min="1" restrictToTypes="literature"><div class="unit"><H6>Related Literature</H6><unit relativeTo="ca_objects_x_occurrences" delimiter="<br/><br/>" restrictToTypes="literature">^ca_occurrences.preferred_labels.name</unit></div></ifcount>');
			if($vs_literature || $vs_rel_lit){
				print "<h4>Literature</h4>".$vs_rel_lit.$vs_literature;
			}
?>
			{{{<ifcount min="1" code="ca_occurrences" restrictToTypes="sale,collection"><H4>Collection History</H4></ifcount>}}}
			{{{<ifcount min="1" code="ca_occurrences" restrictToTypes="sale"><div class='unit'><h6>Auction<ifcount min="2" code="ca_occurrences" restrictToTypes="sale">s</ifcount></h6><unit relativeTo='ca_occurrences' delimiter=' ' restrictToTypes='sale' sort='ca_occurrences.date' sortDirection='DESC'><div class='unitSub'>^ca_occurrences.preferred_labels<ifdef code='ca_occurrences.date'>, ^ca_occurrences.date</ifdef><ifdef code='ca_occurrences.sale_number'>, ^ca_occurrences.sale_number</ifdef></div></unit></ifcount>}}}
<?php
			$va_collections = $t_object->get("ca_occurrences", array("returnWithStructure" => true, "restrictToTypes" => array("collection")));
			if(is_array($va_collections) && sizeof($va_collections)){
				$va_tmp = array();
				foreach($va_collections as $va_collection){
					$va_tmp[] = $va_collection["label"];
				}
				print "<div class='unit'><h6>Collection".((sizeof($va_tmp) > 1) ? "s" : "")."</h6>".join($va_tmp, ", ")."</div>";	
			}
?>
		</div>
		<div class="column">
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
										$va_tmp[] = "<a href='http://www.nomisma.org/id/".$vs_nomisma_id."' target='_blank'>".$vs_term."</a>";
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
		
		</div>
<?php	
	print $this->render("pdfEnd.php");