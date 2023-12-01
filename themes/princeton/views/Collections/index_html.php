<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>
	<div class="row">
		<div class="col-md-12 col-lg-10 col-md-offset-1 collectionsList">
			<h1><?php print $this->getVar("section_name"); ?></h1>
<?php
	if($vs_intro_global_value = $o_collections_config->get("collections_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='collectionIntro'>".$vs_tmp."</div>";
		}
	}
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			$vs_image = $qr_collections->getWithTemplate("<unit relativeTo='ca_objects' limit='1'><ifdef code='ca_object_representations.media'>^ca_object_representations.media.widepreview</ifdef></unit>");
			if($vs_image){
				$vs_image = "<div class='collectionImage'>".$vs_image."</div>";
			}
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			$vs_tmp = "<div class='col-sm-6'>
				<div class='collectionTile'><div class='row'><div class='col-sm-4'>".$vs_image."</div><div class='col-sm-8'><div class='title'>".$qr_collections->get("ca_collections.preferred_labels")."</div>";	
			if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
				$vs_tmp .= "<div>".$vs_scope."</div>";
			}
			$vs_tmp .= "</div></div></div></div>";
			print caDetailLink($this->request, $vs_tmp, "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));
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
		print _t('No collections available');
	}
?>
		</div>
	</div>
