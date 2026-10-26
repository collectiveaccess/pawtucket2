<?php
	$vs_map = $this->getVar("map");
	$qr_contributors = $this->getVar("contributor_results");
	$o_config = $this->getVar("config");
?>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<H1>Institutions</H1>
			<br/>
			<div class="contributorIntro">{{{contributors_intro}}}</div>
			<div class="contributorsList">	
<?php	
	if($qr_contributors && $qr_contributors->numHits()) {
		while($qr_contributors->nextHit()) {
			$vs_tmp = "<div class='row'><div class='col-sm-12'>";
			$vs_tmp .= "<div class='contributorTile'><div class='row'>";
			$vs_image = "";
			if (($o_config->get("contributor_list_image_template")) && ($vs_image = $qr_contributors->getWithTemplate($o_config->get("contributor_list_image_template")))) {
				$vs_tmp .= "<div class='col-sm-4 col-md-3'><div class='contributorImage'>".$vs_image."</div></div>
							<div class='col-sm-8 col-md-9'>";
			}else{
				$vs_tmp .= "<div class='col-sm-12'>";
			}
			$vs_tmp .= "<div class='title'>".$qr_contributors->get("ca_entities.preferred_labels")."</div>";	
			if (($o_config->get("contributor_list_description_template")) && ($vs_description = $qr_contributors->getWithTemplate($o_config->get("contributor_list_description_template")))) {
				if(mb_strlen($vs_description) > 300){
					$vs_description = strip_tags(mb_substr($vs_description, 0, 400))."...";
				}
				$vs_tmp .= "<div class='description'>".$vs_description."</div>";
			}
			$vs_tmp .= "<br/><div class='text-right'>".caDetailLink($this->request, "View", "btn btn-default btn-small", "ca_entities",  $qr_contributors->get("ca_entities.entity_id"))."</div>";
			$vs_tmp .= "</div></div><!-- end col 9/12 --></div><!-- end row -->";
			print caDetailLink($this->request, $vs_tmp, "", "ca_entities",  $qr_contributors->get("ca_entities.entity_id"));

			print "</div><!-- end col-6 --></div><!-- end row -->";
		}
	} else {
		print _t('No contributors available');
	}
?>
			</div>
		</div>
	</div>