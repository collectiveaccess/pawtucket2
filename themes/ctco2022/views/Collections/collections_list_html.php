<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$vs_source_name = $this->getVar("source_name");
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<div class="pull-right"><?php print caNavLink($this->request, "Back", "", "",  "Collections", "Index"); ?></div>
			<h1><?php print $this->getVar("section_name").(($vs_source_name) ? ": ".$vs_source_name : ""); ?></h1>
<?php
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			$vs_tmp = "<div class='col-sm-6'><div class='collectionTile'><div class='title'>".$qr_collections->get("ca_collections.preferred_labels")."</div>";	

			if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
				if(mb_strlen($vs_scope) > 300){
					$vs_scope = strip_tags(mb_substr($vs_scope, 0, 300))."...";
				}
				$vs_tmp .= "<div>".$vs_scope."</div>";
			}
			$vs_tmp .= "<div class='text-right'>".caDetailLink($this->request, "View", "btn btn-default btn-small", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";
			

			$vs_tmp .= "</div>";
			print caDetailLink($this->request, $vs_tmp, "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));

			print "</div>";
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
