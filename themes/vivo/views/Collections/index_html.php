<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");	
?>
	<div class="row">
		<div class='col-md-12 col-lg-12'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
<?php
	if($vs_intro_global_value = $o_collections_config->get("collections_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='collectionIntro'>".$vs_tmp."</div>";
		}
	}
	$vs_sves_id = $o_collections_config->get("sves_idno");
	if($vs_sves_id){
		$t_sves_collection = new ca_collections(array("idno" => $vs_sves_id));
		if($t_sves_collection->get("ca_collections.collection_id")){
			print "<div class='row'><div class='col-sm-12 col-md-9 col-lg-7 col-lg-offset-2'>";
			print "<div class='sves-img'>".caDetailLink($this->request, $t_sves_collection->get("ca_object_representations.media.page"), "", "ca_collections",  $t_sves_collection->get("ca_collections.collection_id"))."</div>";
			print caDetailLink($this->request, "<div class='sves-block-wrapper'><div class='sves-info-block'><H2>".$t_sves_collection->get("ca_collections.preferred_labels")."</H2><p>".$t_sves_collection->getWithTemplate($o_collections_config->get("description_template"))."</p></div></div>", "", "ca_collections",  $t_sves_collection->get("ca_collections.collection_id"));
			print "</div>";
			print "<div class='col-sm-12 col-md-3 col-lg-3'>".caDetailLink($this->request, "Browse SVES →", "btn btn-default btn-sves", "ca_collections",  $t_sves_collection->get("ca_collections.collection_id"))."</div>";
			
			print "</div>"; 
			
		}
	}

	
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		print "<H3>All Collections & Fonds</H3>";
		while($qr_collections->nextHit()) {
			if($qr_collections->get("ca_collections.idno") == $vs_sves_id){
				continue;
			}
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print caDetailLink($this->request, "<div class='col-sm-6'><div class='activation-block-wrapper'>".$qr_collections->get("ca_object_representations.media.iconlarge")."<div class='activation-info-block'><label>".$qr_collections->get("ca_collections.preferred_labels")."</label></div></div></div>", "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));
			$vn_i++;
			if ($vn_i == 2) {
				print "</div><!-- end row -->\n";
				$vn_i = 0;
			}
		}
		if ($vn_i) {
			print "</div><!-- end row -->\n";
		}
	} else {
		print _t('No collections available');
	}
?>
		</div>
	</div>
