<?php
	$t_item = $this->getVar('item');
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
		<h1><?php print ($t_item->get('ca_occurrences.preferred_labels.name')) ? "<b>".$t_item->get('ca_occurrences.preferred_labels.name')."</b><!-- end unit -->" : ""; ?></h1>
<?php
			# --- citation info
			if($vs_value = $t_item->get("ca_entities.preferred_labels.displayname", array("restrict_to_relationship_types" => array("author"), "convertCodesToDisplayText" => true, "delimiter" => "; "))){
				print "<div class='unit'><b>Author(s):</b> ".$vs_value."</div><!-- end unit -->";
			}
			if($vs_value = $t_item->get("ca_entities.preferred_labels.displayname", array("restrict_to_relationship_types" => array("editor"), "convertCodesToDisplayText" => true, "delimiter" => "; "))){
				print "<div class='unit'><b>Editor(s):</b> ".$vs_value."</div><!-- end unit -->";
			}
			if($vs_value = $t_item->get("ca_occurrences.year", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				print "<div class='unit'><b>Year:</b> ".$vs_value."</div><!-- end unit -->";
			}
			if($vs_value = $t_item->get("ca_occurrences.journal", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				print "<div class='unit'><b>Journal/Symposium:</b> ".$vs_value."</div><!-- end unit -->";
			}
			if($vs_value = $t_item->get("ca_occurrences.month_volume", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				print "<div class='unit'><b>Month/Volume #:</b> ".$vs_value."</div><!-- end unit -->";
			}
			if($vs_value = $t_item->get("ca_occurrences.pages", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				print "<div class='unit'><b>Pages:</b> ".$vs_value."</div><!-- end unit -->";
			}
			if($vs_value = $t_item->get("ca_occurrences.keywords", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				print "<div class='unit'><b>Keyword(s):</b> ".$vs_value."</div><!-- end unit -->";
			}
			if($vs_value = $t_item->get("ca_occurrences.other_info", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				print "<div class='unit'><b>Other Information(s):</b> ".$vs_value."</div><!-- end unit -->";
			}
			
			# --- objects
			$va_objects = $t_item->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_objects = array();
			if(sizeof($va_objects) > 0){
				$t_obj = new ca_objects();
				$va_item_types = $t_obj->getTypeList();
				foreach($va_objects as $va_object) {
					$t_obj->load($va_object['object_id']);
					$va_sorted_objects[$va_object['item_type_id']][$va_object['object_id']] = $va_object;
				}
				
				foreach($va_sorted_objects as $vn_object_type_id => $va_object_list) {
?>
						<div class="unit"><h2><?php print _t("Related")." ".$va_item_types[$vn_object_type_id]['name_singular'].((sizeof($va_object_list) > 1) ? "s" : ""); ?></h2>
<?php
					foreach($va_object_list as $vn_rel_object_id => $va_info) {
						print "<div>".caDetailLink($this->request, $va_info["idno"], '', 'ca_objects', $vn_rel_object_id, array("subsite" => $this->request->session->getVar("coloradoSubSite")))." (".$va_info['relationship_typename'].")</div>";
					}
					print "</div><!-- end unit -->";
				}
			}
			
?>
</div><!-- end detailBody -->