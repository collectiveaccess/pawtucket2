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
		while($q_objects->nextHit()){
			print "<div class='chronoThumbnail'>".caNavLink($this->request, $q_objects->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), "", "Detail", "Object", "Show", array("object_id" => $q_objects->get("object_id")))."<br/>".$q_objects->get("creation_date")."</div>";
		}
	}
?>