<?php
	$theme = $this->getVar("theme_name");
	$access_values = caGetUserAccessValues($this->request);
	$qr_res = $this->getVar("results");
?>	
	<div class="row justify-content-center">
		<div class="col-md-10 my-5 py-2">
<?php
	print "<H1>".$theme."</H1>";
	if($qr_res->numHits()){
?>		
			<div class="row text-center">
<?php
		while($qr_res->nextHit()){
			$img = $qr_res->get("ca_object_representations.media.large", array("class" => "object-fit-cover w-100 shadow rounded-3"));
			if(!$img){
				$img = caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "theme image", "class" => "object-fit-cover w-100 shadow rounded-3"));
			}
			print '<div class="col-md-4 mb-4">'.caDetailLink($this->request, "<div class='linkBox position-relative rounded-3'>".$img."<div class='position-absolute top-0 w-100 h-100 display-3 fs-3 text-white rounded-3'>".$qr_res->get("ca_occurrences.preferred_labels")."</div></div>", "", "ca_occurrences", $qr_res->get("ca_occurrences.occurrence_id")).'</div>';				
		}
?>
			</div>
<?php

	}
?>
		</div>
	</div>
