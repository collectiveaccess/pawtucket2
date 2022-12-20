
	<div class="row">
		<div class='col-md-12 col-lg-12'>
			<h1>Activations</h1>
		</div>
	</div>
	<div class="row">
		<div class='col-md-8 activations-intro'>
			{{{activations_intro}}}
		</div>
		<div class='col-md-4'>
			<a href="#" class="btn btn-default btn-activations">News →</a>
			<a href="#" class="btn btn-default btn-activations">Events →</a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<H2><?php print caNavLink($this->request, "Selections From the Archive", "", "", "Gallery", "Index"); ?></H2>
<?php
	$t_set = new ca_sets();
	$va_access_values = caGetUserAccessValues($this->request);
 	$va_sets = $this->getVar("sets");
 	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		$i = 0;
		foreach($va_sets as $vn_set_id => $va_set){
			$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
			$t_set->load($vn_set_id);
			$vs_set_desc = $t_set->get("ca_sets.set_description");
			if(strlen($vs_set_desc) > 125){
				$vs_set_desc = mb_substr($vs_set_desc, 0, 125)."...";
			}
			print caNavLink($this->request, "<div class='activation-block-wrapper'>".$va_first_item["representation_tag"]."<div class='activation-info-block'><label>".$va_set["name"]."</label><p>".$vs_set_desc."</p></div><div style='clear:both;'></div></div>", '', '', 'Gallery', $vn_set_id);
			if($i == 3){
				break;
			}
		}
		print caNavLink($this->request, "View All Selections", "btn btn-default btn-activations", "", "Gallery", "Index");
	}

?>
		</div>
		<div class="col-sm-6">
			<H2><?php print caNavLink($this->request, "Subject Guides", "", "", "Listing", "subject_guides"); ?></H2>
<?php
	$q_subject_guides = $this->getVar("subject_guides");
 	if($q_subject_guides->numHits()){
 		$i = 0;
		while($q_subject_guides->nextHit()){
			$vs_desc = $q_subject_guides->get("ca_occurrences.content_description");
			if(strlen($vs_desc) > 125){
				$vs_desc = mb_substr($vs_desc, 0, 125)."...";
			}
			print $q_subject_guides->getWithTemplate("<l><div class='activation-block-wrapper'><unit relativeTo='ca_objects' restrictToRelationshipTypes='feature' length='1'>^ca_object_representations.media.large</unit><div class='activation-info-block'><label>^ca_occurrences.preferred_labels.name</label><p>".$vs_desc."</p></div><div style='clear:both;'></div></div></l>");
			$i++;
			if($i == 3){
				break;
			}
		}
		print caNavLink($this->request, "View All Subject Guides", "btn btn-default btn-activations", "", "Listing", "subject_guides");
	}

?>

		</div>
	</div>

