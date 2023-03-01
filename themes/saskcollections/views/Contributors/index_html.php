<?php
	$vs_map = $this->getVar("map");
	$qr_contributors = $this->getVar("contributor_results");
	$o_config = $this->getVar("config");
	
	global $g_ui_locale;
	$vs_lang_suffix = "_en";
	if($g_ui_locale == "fr_CA"){
		$vs_lang_suffix = "_fr";
	}
?>
	<div class="row">
		<div class="col-sm-12">
			<H1><?php print _t("Participating Institutions"); ?></H1>
			<div class="contributorIntro">{{{contributors_intro<?php print $vs_lang_suffix; ?>}}}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<div class="contributorMap"><?php print $vs_map; ?></div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="contributorsList">	
<?php	
	$vn_i = 0;
	if($qr_contributors && $qr_contributors->numHits()) {
		while($qr_contributors->nextHit()) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			$vs_tmp = "<div class='col-sm-6'>";
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
					$vs_description = strip_tags(mb_substr($vs_description, 0, 300))."...";
				}
				$vs_tmp .= "<div class='description'>".$vs_description."</div>";
			}
			$vs_tmp .= "<br/><div class='text-right'>".caDetailLink($this->request, "View", "btn btn-default btn-small", "ca_entities",  $qr_contributors->get("ca_entities.entity_id"))."</div>";
			$vs_tmp .= "</div></div><!-- end col 9/12 --></div><!-- end row -->";
			print caDetailLink($this->request, $vs_tmp, "", "ca_entities",  $qr_contributors->get("ca_entities.entity_id"));

			print "</div><!-- end col-6 -->";
			$vn_i++;
			if ($vn_i == 2) {
				print "</div><!-- end row -->\n";
				$vn_i = 0;
			}
		}
		if (($vn_i < 2) && ($vn_i != 0) ) {
			print "</div><!-- end row -->\n";
		}
	} else {
		print _t('No contributors available');
	}
?>		
			</div>
		</div>
	</div>