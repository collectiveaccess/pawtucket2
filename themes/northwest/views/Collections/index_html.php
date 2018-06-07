<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
			<p>{{{collections_intro_text}}}</p>
<?php	
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='col-sm-12 col-lg-6'><div class='collectionTile'><div class='title'>".caNavLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "",  "Collections", "CollectionList", array("collection_id" => $qr_collections->get("collection_id")))."</div>";	
			$vs_desc = "";
			if (($o_collections_config->get("landing_description_template")) && ($vs_desc = $qr_collections->getWithTemplate($o_collections_config->get("landing_description_template")))) {
				print "<div>".$vs_desc."</div>";
			}
			print "</div></div>";
			$vn_i++;
			if ($vn_i == 2) {
				print "</div><!-- end row -->\n";
				$vn_i = 0;
			}
		}
		# --- add in the link to special collections
		if ( $vn_i == 0) { print "<div class='row'>"; } 
		$vs_special_collection_title = $this->getVar("special_collections_title");
		$vs_special_collection_description = $this->getVar("special_collections_description_text");
		print "<div class='col-sm-12 col-lg-6'><div class='collectionTile'><div class='title'>".caNavLink($this->request, $vs_special_collection_title, "", "",  "Collections", "SpecialCollectionsList")."</div>";	
		if ($vs_special_collection_description) {
			print "<div>".$vs_special_collection_description."</div>";
		}
		print "</div></div>";
		$vn_i++;
		if ($vn_i == 2) {
			print "</div><!-- end row -->\n";
			$vn_i = 0;
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
