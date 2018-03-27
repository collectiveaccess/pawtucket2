<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$va_collections = array();
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			$va_collections[$qr_collections->get('ca_collections.collection_id')] = array("rank" => $qr_collections->get('ca_collections.collection_rank'), "id" => $qr_collections->get("ca_collections.collection_id"), "media" => $qr_collections->get("ca_object_representations.media.widepreview", array('primaryOnly' => true)), "title" => $qr_collections->get("ca_collections.preferred_labels"), "abstract" => $qr_collections->get("ca_collections.abstract")); 
			#if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
			#	$va_collections[$qr_collections->get('ca_collections.collection_rank')]["description"] = $vs_scope;
			#}
		}
	}
	ksort($va_collections);
	usort($va_collections, "rank_sort");
	// Define the custom sort function
	function rank_sort($a,$b) {
		return $a['rank']>$b['rank'];
	}
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<h4><?php print $this->getVar("section_name"); ?></h4>
			<p><?php print $o_collections_config->get("collections_intro_text"); ?></p>
<?php						

	$vn_i = 0;
	if(is_array($va_collections) && sizeof($va_collections)) {
		foreach($va_collections as $va_collection) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='col-sm-5'><div class='collectionTile'>";
			print "<div class='colImage'>".caDetailLink($this->request, $va_collection["media"], "", "ca_collections",  $va_collection["id"])."</div>";
			print "<div class='title'>".caDetailLink($this->request, $va_collection["title"], "", "ca_collections",  $va_collection["id"])."</div>";	
			if ($va_collection["abstract"]) {
				print "<div class='collectionDetail'>".$va_collection["abstract"]."</div>";
			}
			print "</div></div><div class='col-sm-1'></div>";
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
