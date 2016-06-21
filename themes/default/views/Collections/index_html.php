<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>
	<div class="container">
		<div class="row">
			<div class='col-md-12 col-lg-12 collectionsList'>
				<h1><?php print $this->getVar("section_name"); ?></h1>
				<p><?php print $o_collections_config->get("collections_intro_text"); ?></p>
<?php	
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) { 
			print "<p><div>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";	
			if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
				print "<div>".$vs_scope."</div>";
			}
			print "</p>";

		}
	} else {
		print _t('No collections available');
	}
?>
					</div>
				</div>
			</div>
		</div>
