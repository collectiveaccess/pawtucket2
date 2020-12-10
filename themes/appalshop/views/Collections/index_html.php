<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
			<p><?php print $o_collections_config->get("collections_intro_text"); ?></p>
<?php	
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='col-sm-6'><div class='collectionTile'>";
			print $qr_collections->getWithTemplate("<ifcount code='ca_objects' restrictToRelationshipTypes='featured'><unit relativeTo='ca_objects' restrictToRelationshipTypes='featured'>^ca_object_representations.media.iconlarge</unit></ifcount>");
			print "<div class='title'>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";	
			if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
				print "<div>".$vs_scope."</div>";
			}
			print "</div></div>";
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
