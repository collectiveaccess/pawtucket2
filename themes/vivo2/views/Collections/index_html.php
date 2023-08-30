<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$vs_placeholder = "<div class='placeholderImage'>".caGetThemeGraphic($this->request, 'placeholder.jpg', array("alt" => "Placeholder"))."</div>";
?>
<div class="hero heroCollections">
	<div class="heroIntroContainer"><div class="heroIntro">
		<H1>
			<?php print $this->getVar("section_name"); ?>
		</H1>
<?php
	if($vs_intro_global_value = $o_collections_config->get("collections_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print $vs_tmp;
		}
	}
?>
	</div></div>
</div>
<div class="container">
	<div class="row">
		<div class='col-md-12 col-lg-12'>
<?php
	
	$vs_sves_id = $o_collections_config->get("sves_idno");
	if($vs_sves_id){
		$t_sves_collection = new ca_collections(array("idno" => $vs_sves_id));
		if($t_sves_collection->get("ca_collections.collection_id")){
?>
			<div class="bgLightGray">
				<div class='row'>
					<div class='col-sm-12 col-md-6'>
						<div class='highlightImg'><?php print caDetailLink($this->request, $t_sves_collection->get("ca_object_representations.media.page"), "", "ca_collections",  $t_sves_collection->get("ca_collections.collection_id")); ?></div>
					</div>
					<div class='col-sm-12 col-md-6'><div class="highlightIntroContainer">
<?php
						print caDetailLink($this->request, "<H2>".$t_sves_collection->get("ca_collections.preferred_labels")."</H2>", "", "ca_collections",  $t_sves_collection->get("ca_collections.collection_id"));
						print "<div class='highlightIntro'>".$this->getVar("SVES_intro")."</div>";
						print caDetailLink($this->request, "Browse SVES →", "btn btn-default btn-sves", "ca_collections",  $t_sves_collection->get("ca_collections.collection_id"));
?>
					</div></div>
				</div>
			</div>
<?php		
		}
	}

	
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		print "<H3>All Collections & Fonds</H3>";
		while($qr_collections->nextHit()) {
			if($qr_collections->get("ca_collections.idno") == $vs_sves_id){
				continue;
			}
			$vs_image = $qr_collections->get("ca_object_representations.media.iconlarge");
			
			if(!$vs_image){
				$vs_image = $vs_placeholder;
			}
			$vs_lang = "";
			if($vs_tmp = $qr_collections->get("ca_collections.RAD_langMaterial", array("delimiter" => "; "))){
				$vs_lang = "<div><label>Language</label>".$vs_tmp."</div>";
			}
			
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='col-sm-6'>".caDetailLink($this->request, "<div class='bgLightGray imgTile'><div class='row'><div class='col-sm-5 col-md-4 col-lg-3'>".$vs_image."</div><div class='col-sm-7 col-md-8 col-lg-9'><div class='imgTileText'><div class='imgTileTextTitle'>".$qr_collections->get("ca_collections.preferred_labels")."</div>".$vs_lang."</div></div></div></div>", "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";
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
</div>
