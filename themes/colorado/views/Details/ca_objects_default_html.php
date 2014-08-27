<?php
	$t_object = $this->getVar("item");
	$t_lists = new ca_lists();
	$va_eggshell_type_ids = array($t_lists->getItemIDFromList("object_types", "fossil"), $t_lists->getItemIDFromList("object_types", "recent"), $t_lists->getItemIDFromList("object_types", "pseudo"), $t_lists->getItemIDFromList("object_types", "associated"));
	$va_vertebrate_type_ids = array($t_lists->getItemIDFromList("object_types", "vertebrate"), $t_lists->getItemIDFromList("object_types", "vertebrate_item"), $t_lists->getItemIDFromList("object_types", "vertebrate_cast"), $t_lists->getItemIDFromList("object_types", "ost_specimen"));
	$va_track_type_ids = array($t_lists->getItemIDFromList("object_types", "track"), $t_lists->getItemIDFromList("object_types", "track_item"), $t_lists->getItemIDFromList("object_types", "tracing"), $t_lists->getItemIDFromList("object_types", "cast"));
	$va_access_values = $this->getVar('access_values');
?>
	<div id="detailBody">
		<div id="pageNav">
<?php
			if ($this->getVar('resultsLink') || $this->getVar("previousLink") || $this->getvar("nextLink")) {
				if ($this->getVar('previousLink')) {
					print $this->getVar('previousLink');
				}else{
					print "&lsaquo; "._t("Previous");
				}
				if($this->getVar('resultsLink')){
					print "&nbsp;&nbsp;&nbsp;".$this->getVar('resultsLink')."&nbsp;&nbsp;&nbsp;";
				}else{
					print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				if ($this->getVar('nextLink')) {
					print $this->getVar('nextLink');
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
		<h1><?php print unicode_ucfirst($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))).': '.caReturnDefaultIfBlank($t_object->get('idno')); ?></h1>
		<div id="leftCol">
<?php



		if (in_array($t_object->get('ca_objects.type_id'), $va_eggshell_type_ids)) {			
			# --- Eggshells
?>
			<br><div class="unit"><h2>Taxonomy</h2></div>
<?php
			# --- attributes
			$va_taxonomy = array("group", "order", "family", "genus", "species");
			foreach($va_taxonomy as $vs_attribute_code){
				if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}")){
					print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}").":</b> ".caReturnDefaultIfBlank($vs_value)."</div><!-- end unit -->";
				}
			}

			$vs_era = $t_object->get('ca_places.era', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_period = $t_object->get('ca_places.period', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_epoch = $t_object->get('ca_places.epoch', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_ageNALMA = $t_object->get('ca_places.ageNALMA', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_formation = $t_object->get('ca_places.formation', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
?>
			<br><div class="unit"><h2>Stratigraphy</h2></div>
<?php

			print "<div class='unit'><b>"._t('Era').": </b>".caReturnDefaultIfBlank($vs_era)."</div>";
			print "<div class='unit'><b>"._t('Period').": </b>".caReturnDefaultIfBlank(str_replace(", -", "", $vs_period))."</div>";
			print "<div class='unit'><b>"._t('Epoch').": </b>".caReturnDefaultIfBlank($vs_epoch)."</div>";
			print "<div class='unit'><b>"._t('Age').": </b>".caReturnDefaultIfBlank($vs_ageNALMA)."</div>";
			print "<div class='unit'><b>"._t('Formation').": </b>".caReturnDefaultIfBlank($vs_formation)."</div>";
			
			
			$vs_citation = $t_object->get('ca_objects.citation', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
				
			$vs_nestStructure = $t_object->get('ca_objects.nestStructure', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			
?>
<br><div class="unit"><h2>General</h2></div>
<?php

			print "<div class='unit'><b>"._t('Citation').": </b>".caReturnDefaultIfBlank($vs_citation)."</div>";
			print "<div class='unit'><b>"._t('Nest structure').": </b>".caReturnDefaultIfBlank($vs_nestStructure)."</div>";
			
		} elseif ((in_array($t_object->get('ca_objects.type_id'), $va_vertebrate_type_ids))) {
			print "<br/>";
			# --- Vertebrates
			$vs_other = $t_object->get("ca_objects.other_catalog_number");
			print "<div class='unit'><b>"._t('Alternate Catalog Number').":</b> ".caReturnDefaultIfBlank($vs_other)."</div><!-- end unit -->";
			$vs_track_type_status = $t_object->get('ca_objects.track_type_status' , array('convertCodesToDisplayText' => true));
			if (substr($vs_track_type_status, -1) == 's'){ $vs_track_type_status = substr($vs_track_type_status, 0, -1);}
			print "<div class='unit'><b>"._t('Type Status').":</b> ".caReturnDefaultIfBlank($vs_track_type_status)."</div>";
			$vs_cast = $t_object->get("ca_objects.cast_model", array("convertCodesToDisplayText" => true));
			print "<div class='unit'><b>"._t('Cast').":</b> ".(($vs_cast) ? $vs_cast : "No")."</div>";
			#if($va_taxonomy = $t_object->get('ca_objects.taxonomic_rank' , array('convertCodesToDisplayText' => true))){
			#	print "<div class='unit'><b>"._t('Taxonomy').":</b> ".$va_taxonomy."</div>";
			#}		
			if($vn_taxonomy = $t_object->get('ca_objects.taxonomic_rank', array('idsOnly' => true))){
?>
				<br><div class="unit"><h2>Taxonomy</h2></div>
<?php
				$t_list_item = new ca_list_items();
				$va_hierarchy = caExtractValuesByUserLocale($t_list_item->getHierarchyAncestors($vn_taxonomy, array("includeSelf" => true, "additionalTableToJoin" => "ca_list_item_labels", "additionalTableSelectFields" => array("name_singular"))));
				$va_hierarchy = array_reverse($va_hierarchy);					
				foreach($va_hierarchy as $va_hier_taxonomy){
					if($va_hier_taxonomy["parent_id"]){
						print "<div class='unit'><b>".$t_lists->getItemFromListForDisplayByItemID("list_item_types", $va_hier_taxonomy["type_id"]).": </b>".$va_hier_taxonomy["name_singular"]."</div>";
					}
				}
			}
			if($vs_description = $t_object->get("ca_objects.description")){
				print "<div class='unit'><b>"._t('Description').":</b> {$vs_description}</div><!-- end unit -->";
			}				
			
			$vs_era = $t_object->get('ca_places.era', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_period = $t_object->get('ca_places.period', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_epoch = $t_object->get('ca_places.epoch', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_ageNALMA = $t_object->get('ca_places.ageNALMA', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_unit = $t_object->get('ca_places.unit', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_group = $t_object->get('ca_places.group', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_formation = $t_object->get('ca_places.formation', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_member = $t_object->get('ca_places.member', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
?>
			<br><div class="unit"><h2>Stratigraphy</h2></div>
<?php

			print "<div class='unit'><b>"._t('Era').": </b>".caReturnDefaultIfBlank($vs_era)."</div>";
			print "<div class='unit'><b>"._t('Period').": </b>".caReturnDefaultIfBlank(str_replace(", -", "", $vs_period))."</div>";
			print "<div class='unit'><b>"._t('Epoch').": </b>".caReturnDefaultIfBlank($vs_epoch)."</div>";
			print "<div class='unit'><b>"._t('Age').": </b>".caReturnDefaultIfBlank($vs_ageNALMA)."</div>";
			print "<div class='unit'><b>"._t('Zone').": </b>".caReturnDefaultIfBlank($vs_unit)."</div>";
			print "<div class='unit'><b>"._t('Group').": </b>".caReturnDefaultIfBlank($vs_group)."</div>";	
			print "<div class='unit'><b>"._t('Formation').": </b>".caReturnDefaultIfBlank($vs_formation)."</div>";	
			print "<div class='unit'><b>"._t('Member').": </b>".caReturnDefaultIfBlank($vs_member)."</div>";				
								
		} elseif((in_array($t_object->get('ca_objects.type_id'), $va_track_type_ids))) {
			# --- Tracks, Tracings
			if($vs_other = $t_object->get("ca_objects.other_catalog_number")){
				print "<div class='unit'><b>"._t('Other Catalog Number').":</b> {$vs_other}</div><!-- end unit -->";
			}
			if($vn_taxonomy = $t_object->get('ca_objects.taxonomic_rank', array('idsOnly' => true))){
				$t_list_item = new ca_list_items();
				$va_hierarchy = caExtractValuesByUserLocale($t_list_item->getHierarchyAncestors($vn_taxonomy, array("includeSelf" => true, "additionalTableToJoin" => "ca_list_item_labels", "additionalTableSelectFields" => array("name_singular"))));
				$va_hierarchy = array_reverse($va_hierarchy);					
				foreach($va_hierarchy as $va_hier_taxonomy){
					if($va_hier_taxonomy["parent_id"]){
						print "<div class='unit'><b>".$t_lists->getItemFromListForDisplayByItemID("list_item_types", $va_hier_taxonomy["type_id"]).": </b>".$va_hier_taxonomy["name_singular"]."</div>";
					}
				}
			}
			if($va_ichnogenus = $t_object->get('ca_objects.ichnogenus' , array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t('Ichnogenus').":</b> ".$va_ichnogenus."</div>";
			}
			if($vs_ichnospecies = $t_object->get("ca_objects.ichnospecies")){
				print "<div class='unit'><b>"._t('Ichnospecies').":</b> {$vs_ichnospecies}</div><!-- end unit -->";
			}
			if($vs_clade = $t_object->get("ca_objects.clade", array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<div class='unit'><b>"._t('Trackmaker clade').":</b> {$vs_clade}</div><!-- end unit -->";
			}
			if($va_trace_type = $t_object->get('ca_objects.trace_type' , array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t('Track Type').":</b> ".$va_trace_type."</div>";
			}			
			if($vs_related_tracing = $t_object->get('ca_objects', array('delimiter' => ', ', "template" => "<l>^ca_objects.idno</l>", "returnAsLink" => true, "restrictToTypes" => array("tracing")))){
				print "<div class='unit'><b>"._t('Tracing Number').":</b> ".$vs_related_tracing."</div>";
			}								
			if($vs_related_track = $t_object->get('ca_objects', array('delimiter' => ', ', "template" => "<l>^ca_objects.idno</l>", "returnAsLink" => true, "restrictToTypes" => array("track", "track_item")))){
				print "<div class='unit'><b>"._t('Track').":</b> ".$vs_related_track."</div>";
			}									
			if($vs_related_cast = $t_object->get('ca_objects', array('delimiter' => ', ', "template" => "<l>^ca_objects.idno</l>", "returnAsLink" => true, "restrictToTypes" => array("cast")))){
				print "<div class='unit'><b>"._t('Cast').":</b> ".$vs_related_cast."</div>";
			}								
			if($va_original = $t_object->get('ca_objects.original' , array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t('Original').":</b> ".$va_original."</div>";
			}	
			if($va_plaster = $t_object->get('ca_objects.plaster' , array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t('Plaster').":</b> ".$va_plaster."</div>";
			}	
			if($va_latex = $t_object->get('ca_objects.latex' , array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t('Latex').":</b> ".$va_latex."</div>";
			}	
			if($va_fiberglass = $t_object->get('ca_objects.fiberglass' , array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t('Fiberglass').":</b> ".$va_fiberglass."</div>";
			}	
			if($va_natura_true = $t_object->get('ca_objects.natura_true' , array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t('Natural Cast or True Track').":</b> ".$va_natura_true."</div>";
			}
			if($va_owner = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('owned'), 'delimiter' => ','))){
				print "<div class='unit'><b>"._t('Owner').":</b> ".$va_owner."</div>";
			}																					
			if($va_identifier = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('identifier'), 'delimiter' => ','))){
				print "<div class='unit'><b>"._t('Identifier').":</b> ".$va_identifier."</div>";
			}			
			if($vs_idDate = $t_object->get("ca_objects.idDate")){
				print "<div class='unit'><b>"._t('ID Date').":</b> {$vs_idDate}</div><!-- end unit -->";
			}	
			if($va_collector = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('collector'), 'delimiter' => ','))){
				print "<div class='unit'><b>"._t('Collector').":</b> ".$va_collector."</div>";
			}				
			if($vs_collectionDate = $t_object->get("ca_objects.collectionDate")){
				print "<div class='unit'><b>"._t('Collection Date').":</b> {$vs_collectionDate}</div><!-- end unit -->";
			}				
			if($va_track_type_status = $t_object->get('ca_objects.track_type_status' , array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t('Type Status').":</b> ".$va_track_type_status."</div>";
			}				
			if($vs_description = $t_object->get("ca_objects.description")){
				print "<div class='unit'><b>"._t('Description').":</b> {$vs_description}</div><!-- end unit -->";
			}			
			if($va_photographs = $t_object->get('ca_objects.photographs' , array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t('Photographs').":</b> ".$va_photographs."</div>";
			}

		}	#end if statement			
			
		if($va_citations = $t_object->get('ca_occurrences', array('returnAsArray' => true, 'checkAccess' => $va_access_values))){
			if(sizeof($va_citations)){
				$t_occurrence = new ca_occurrences();
				print "<br><div class='unit'><h2>".((sizeof($va_citations) > 1) ? "Citations" : "Citation")."</h2>";			
				foreach($va_citations as $va_citation){
					$t_occurrence->load($va_citation["occurrence_id"]);
					$vs_citation = "";
					$vs_citation .= $t_occurrence->get("ca_entities.preferred_labels.displayname", array("restrict_to_relationship_types" => array("author"), "convertCodesToDisplayText" => true, "delimiter" => "; ")).". ";
					$vs_citation .= "\"".$va_citation["name"].".\" ";
					if($t_occurrence->get("ca_occurrences.journal")){
						$vs_citation .= "<i>".$t_occurrence->get("ca_occurrences.journal")."</i> ";
					}
					if($t_occurrence->get("ca_occurrences.month_volume")){
						$vs_citation .= $t_occurrence->get("ca_occurrences.month_volume")." ";
					}
					if($t_occurrence->get("year")){
						$vs_citation .= "(".$t_occurrence->get("year").") ";
					}
					if($t_occurrence->get("ca_occurrences.pages")){
						$vs_citation .= ": ".$t_occurrence->get("ca_occurrences.pages");
					}
					$vs_citation .= ".";
					print caDetailLink($this->request, $vs_citation, '', 'ca_occurrences', $va_citation["occurrence_id"], array("subsite" => $this->request->session->getVar("coloradoSubSite")));
				}
				print "</div>";
			}
		}
			
		# --- places
		$va_locality_list = $t_object->get("ca_places", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
		$va_locality_display = array();
		$va_place_type_ids_to_exclude = array($t_lists->getItemIDFromList("place_types", "city"), $t_lists->getItemIDFromList("place_types", "basin"), $t_lists->getItemIDFromList("place_types", "other"), $t_lists->getItemIDFromList("place_types", "locality"));
		if(sizeof($va_locality_list)){
			$t_place = new ca_places();
			print "<br><div class='unit'><h2>UCM ".((sizeof($va_places) > 1) ? "Localities" : "Locality")."</h2>";			
			foreach($va_locality_list as $va_locality){
				$vs_locality_path = "";
				$va_hierarchy = caExtractValuesByUserLocale($t_place->getHierarchyAncestors($va_locality["place_id"], array("additionalTableToJoin" => "ca_place_labels", "additionalTableSelectFields" => array("name"))));
				$va_hierarchy = array_reverse($va_hierarchy);
				array_shift($va_hierarchy);
				foreach($va_hierarchy as $va_hier_locality){
					if(!in_array($va_hier_locality["type_id"], $va_place_type_ids_to_exclude)){
						$vs_locality_path .= $va_hier_locality["name"]." / ";
					}
				}
				$vs_locality_path = caDetailLink($this->request, $va_locality["idno"], '', 'ca_places', $va_locality["place_id"], array("subsite" => $this->request->session->getVar("coloradoSubSite")))."<br/>".$vs_locality_path.$va_locality["idno"];			
				$va_locality_display[] = $vs_locality_path;
			}
			print join("<br/>", $va_locality_display);
			print "</div><!-- end unit -->";
		}			
?>
		</div><!-- end leftCol-->
		<div id="rightCol">
<?php
			if($this->getVar("representationViewer")){
				print $this->getVar("representationViewer");
			}
?>
		</div><!-- end rightCol -->
	</div><!-- end detailBody -->
<?php
