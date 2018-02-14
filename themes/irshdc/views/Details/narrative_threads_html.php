<hr/><div class='unit'><h3><i class="fa fa-random" aria-hidden="true"></i> Narrative Thread</h3>					
<?php
$t_object = $this->getVar("item");
$va_threads = $t_object->get("ca_objects.narrative_thread", array("returnAsArray" => true));
if(is_array($va_threads) && sizeof($va_threads)){
	$qr_threads = caMakeSearchResult('ca_list_items', $va_threads);
 				
	$t_set = new ca_sets();
	if($qr_threads->numHits()){
		while($qr_threads->nextHit()){
			# --- is there a set of featured items to pull from?
			$vs_image = "";
			$t_set->load(array("set_code" => str_replace(" ", "_", $qr_threads->get("ca_list_items.idno"))));
			if($t_set->get("set_id")){
				$va_set_reps = $t_set->getRepresentationTags("widepreview", array("checkAccess" => $va_access_values));
				shuffle($va_set_reps);
				$vs_image = $va_set_reps[0];
			}
			print "<div class='narrativeThreadContainer'><div class='narrativeThreadImgContainer'>".caNavLink($this->request, $vs_image, "", "", "Explore", "narrativethreads", array("id" => $qr_threads->get("ca_list_items.item_id")))."</div>".
						"<div class='narrativeThreadDesc'><H2>".caNavLink($this->request, $qr_threads->get("ca_list_items.preferred_labels.name_singular"), "", "", "Explore", "narrativethreads", array("id" => $qr_threads->get("ca_list_items.item_id")))."</H2>".
						"</div></div>";
		}
	}
}
?>
</div>