<?php
	$vs_map = $this->getVar("map");
	$qr_communities = $this->getVar("communities_results");
	$o_config = $this->getVar("config");
?>
<div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		<div class="row">
			<div class="col-sm-12">
				<H1>Communities</H1>
				<div class="communitiesMap"><?php print $vs_map; ?></div>
				<div class="communitiesIntro">{{{communities_intro}}}</div>
				
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="communitiesList">	
	<?php	
		$vn_i = 0;
		if($qr_communities && $qr_communities->numHits()) {
			while($qr_communities->nextHit()) {
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				$vs_tmp = "<div class='col-sm-4'>";
				$vs_tmp .= "<div class='communitiesTile'>";
				$vs_image = "";
				if (($o_config->get("communities_list_image_template")) && ($vs_image = $qr_communities->getWithTemplate($o_config->get("communities_list_image_template")))) {
					$vs_tmp .= "<div class='communitiesImage'>".$vs_image."</div>";
				}
				$vs_tmp .= "<div class='title'>".$qr_communities->get("ca_places.preferred_labels")."</div>";	
				$vs_tmp .= "</div>";
				#print caDetailLink($this->request, $vs_tmp, "", "ca_places",  $qr_communities->get("ca_places.place_id"));
				print caNavLink($this->request, $vs_tmp, "", "", "Browse", "objects", array("facet" => "place_facet", "id" => $qr_communities->get("ca_places.place_id")));

				print "</div><!-- end col-4 -->";
				$vn_i++;
				if ($vn_i == 3) {
					print "</div><!-- end row -->\n";
					$vn_i = 0;
				}
			}
			if ($vn_i > 0) {
				print "</div><!-- end row -->\n";
			}
		} else {
			print _t('No communities available');
		}
	?>		
				</div>
			</div>
		</div>
	</div>
</div>