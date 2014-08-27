<?php
	$t_place = $this->getVar('item');
	$va_access_values = $this->getVar('access_values');
	$t_lists = new ca_lists();
	$va_place_type_ids_to_exclude = array($t_lists->getItemIDFromList("place_types", "city"), $t_lists->getItemIDFromList("place_types", "basin"), $t_lists->getItemIDFromList("place_types", "other"), $t_lists->getItemIDFromList("place_types", "locality"));
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
		<h1><?php print ($t_place->get('idno')) ? "<b>"._t("Locality Number")."</b>: ".$t_place->get('idno')."<!-- end unit -->" : ""; ?></h1>
		<div id="leftCol">
<?php
			if(sizeof($va_related_tracks) == 0){
				# --- hierarchy
				$va_hierarchy_ids = array();
				if(is_array($va_hierarchy = caExtractValuesByUserLocale($t_place->getHierarchyAncestors($va_locality["place_id"], array("additionalTableToJoin" => "ca_place_labels", "additionalTableSelectFields" => array("name")))))){
					$va_hierarchy = array_reverse($va_hierarchy);
					array_shift($va_hierarchy);
					foreach($va_hierarchy as $va_hier_locality){
						if(!in_array($va_hier_locality["type_id"], $va_place_type_ids_to_exclude)){
							$vs_locality_path .= $va_hier_locality["name"]." / ";
						}
						$va_hierarchy_ids[] = $va_hier_locality["place_id"];
					}
					$vs_locality_path = $vs_locality_path.$t_place->get("idno");				
					print "<div class='unit'>".$vs_locality_path."</div><!-- end unit -->";
				}
			}
			# --- attributes
			if($vs_value = $t_place->get("ca_places.era", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				print "<div class='unit'><b>".$t_place->getDisplayLabel("ca_places.era").":</b> ".caReturnDefaultIfBlank($vs_value)."</div><!-- end unit -->";
			}
			if(($t_place->get("ca_places.period.period_main", array("convertCodesToDisplayText" => true))) && (($t_place->get("ca_places.period.period_main", array("convertCodesToDisplayText" => true)) != "-") || ($t_place->get("ca_places.period.stage", array("convertCodesToDisplayText" => true)) != "-"))){
				print "<div class='unit'><b>".$t_place->getDisplayLabel("ca_places.period").":</b> ";
				$va_tmp = array();
				if(($t_place->get("ca_places.period.period_main", array("convertCodesToDisplayText" => true)) != "-")){
					$va_tmp[] = $t_place->get("ca_places.period.period_main", array("convertCodesToDisplayText" => true));
				}
				if(($t_place->get("ca_places.period.stage", array("convertCodesToDisplayText" => true)) != "-")){
					$va_tmp[] = $t_place->get("ca_places.period.stage", array("convertCodesToDisplayText" => true));
				}
				print implode("; ", $va_tmp);
				print "</div><!-- end unit -->";
			}
			if(($t_place->get("ca_places.epoch", array("convertCodesToDisplayText" => true))) && (($t_place->get("ca_places.epoch.epoch_main", array("convertCodesToDisplayText" => true)) != "-") || ($t_place->get("ca_places.epoch.stage_epoch", array("convertCodesToDisplayText" => true)) != "-"))){
				print "<div class='unit'><b>".$t_place->getDisplayLabel("ca_places.epoch").":</b> ";
				$va_tmp = array();
				if(($t_place->get("ca_places.epoch.epoch_main", array("convertCodesToDisplayText" => true)) != "-")){
					$va_tmp[] = $t_place->get("ca_places.epoch.epoch_main", array("convertCodesToDisplayText" => true));
				}
				if(($t_place->get("ca_places.epoch.stage_epoch", array("convertCodesToDisplayText" => true)) != "-")){
					$va_tmp[] = $t_place->get("ca_places.epoch.stage_epoch", array("convertCodesToDisplayText" => true));
				}
				print implode("; ", $va_tmp);
				print "</div><!-- end unit -->";
			}
			$va_attributes = array("ageNALMA", "formation", "member");
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_place->get("ca_places.{$vs_attribute_code}", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
						print "<div class='unit'><b>".$t_place->getDisplayLabel("ca_places.{$vs_attribute_code}").":</b> ".caReturnDefaultIfBlank($vs_value)."</div><!-- end unit -->";
					}
				}
			}
			
			
			# --- objects
			$va_objects = $t_place->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_objects) > 0){
?>
				<div class="unit"><h2><?php print _t("Other UCM Specimens From This Site"); ?></h2>
<?php
				foreach($va_objects as $va_object) {
					print "<div>".caDetailLink($this->request, $va_object["idno"], '', 'ca_objects', $va_object['object_id'], array("subsite" => $this->request->session->getVar("coloradoSubSite")))."</div>";
				}
				print "</div><!-- end unit -->";

			}
			
?>
	</div><!-- end leftCol -->
	<div id="rightColMap">
<?php
		# --- map
		# --- plot circle based on point for tracks and verts
		$o_config = caGetDetailConfig();
		$va_types = $o_config->getAssoc('detailTypes');
		$va_options = $va_types["place"]["options"];
		
		$vs_map_attribute = caGetOption('map_attribute', $va_options, false);
		if($vs_map_attribute && $t_place->get($vs_map_attribute)){
			$o_map = new GeographicMap((($vn_width = caGetOption('map_width', $va_options, false)) ? $vn_width : 285), (($vn_height = caGetOption('map_height', $va_options, false)) ? $vn_height : 200), 'map');
			$o_map->mapFrom($t_place, $vs_map_attribute);
			print $o_map->render('HTML', array("obscure" => true, "circle" => true, "radius" => 20000, "fillColor" => "#000000", "pathColor" => "#000000", "zoomLevel" => 5));
		}else{
			$qr_hits = ca_places::createResultSet($va_hierarchy_ids);
			if($qr_hits->numHits()){
				while($qr_hits->nextHit()){
					if($qr_hits->get($vs_map_attribute)){
						$t_place->load($qr_hits->get("place_id"));
						$o_map = new GeographicMap((($vn_width = caGetOption('map_width', $va_options, false)) ? $vn_width : 285), (($vn_height = caGetOption('map_height', $va_options, false)) ? $vn_height : 200), 'map');
						$o_map->mapFrom($t_place, $vs_map_attribute);
						print $o_map->render('HTML', array("obscure" => true, "circle" => true, "radius" => 20000, "fillColor" => "#000000", "pathColor" => "#000000", "zoomLevel" => 5));
						break;
					}
				}
			}
		}
?>
	</div><!-- end rightColMap -->
</div><!-- end detailBody -->