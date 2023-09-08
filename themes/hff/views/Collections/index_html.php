<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
<?php
	print "<div class='collectionsAdvancedSearch'>".caNavLink($this->request, _t("Archival Collections Advanced Search"), "btn btn-default btn-sm", "", "Search", "advanced/collections")."</div>";
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			$vs_coll_title = "";
			print "<div class='col-sm-6'><div class='collectionTile'>";
			if (($o_collections_config->get("title_template")) && ($vs_coll_title = $qr_collections->getWithTemplate($o_collections_config->get("title_template")))) {
				print "<div class='title'>".caDetailLink($this->request, $vs_coll_title, "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";			
			}else{
				print "<div class='title'>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";	
			}
			
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
