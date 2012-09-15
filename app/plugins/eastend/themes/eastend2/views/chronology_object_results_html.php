<?php
	$va_period_data = $this->getVar("period_data");
	$q_objects = $va_period_data["objects"];
	$pn_entity_id = $this->getVar("entity_id");
	$ps_entity_name = $this->getVar("entity_name");
	$pn_occurrence_id = $this->getVar("occurrence_id");
	$ps_occurrence_name = $this->getVar("occurrence_name");

	if($pn_entity_id){
		print "<div id='chronoRefineCriteria'>";
		print "<div id='chronoRefineCriteriaText'>".$ps_entity_name."</div><!-- end chronoRefineCriteriaText -->";
		print "<div id='chronoRefineCriteriaLink'>".caNavLink($this->request, _t("Artist Info >"), "", "Detail", "Entity", "Show", array("entity_id" => $pn_entity_id))."</div><!-- end chronoRefineCriteriaLink -->";
		print "<div style='clear:both;'><!-- empty --></div></div><!-- end chronoRefineCriteria -->";
	}

	if($pn_occurrence_id){
		print "<div id='chronoRefineCriteria'>";
		print "<div id='chronoRefineCriteriaText'>".$ps_occurrence_name."</div><!-- end chronoRefineCriteriaText -->";
		print "<div id='chronoRefineCriteriaLink'>".caNavLink($this->request, _t("Occurrence Info >"), "", "Detail", "Occurrence", "Show", array("occurrence_id" => $pn_occurrence_id))."</div><!-- end chronoRefineCriteriaLink -->";
		print "<div style='clear:both;'><!-- empty --></div></div><!-- end chronoRefineCriteria -->";
	}

	if($q_objects->numHits()){
		$vs_col1 = "";
		$vs_col2 = "";
		$vs_date = "";
		$vs_link = "";
		$vn_i = 0;
		while($q_objects->nextHit()){
			if($vs_image = $q_objects->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values))){
				$vn_i++;
				$vs_link = "";
				$vs_link = caNavLink($this->request, $vs_image, "", "Detail", "Object", "Show", array("object_id" => $q_objects->get("object_id")))."<br/>";
				if($vs_date != $q_objects->get("creation_date")){
					$vs_date = $q_objects->get("creation_date");
					$vs_link = $vs_date."<br/>".$vs_link;
				}
				if($vn_i == 1){
					$vs_col1 .= $vs_link;
				}else{
					$vs_col2 .= $vs_link;
					$vn_i = 0;
				}
			}
		}
		print "<div class='col'>".$vs_col1."</div>";
		print "<div class='col'>".$vs_col2."</div>";
	}
?>