<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>
	
	<div class='row'>
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<h1>Guides to the Archives</h1>
			<p class="linkUnderline">{{{collections_intro_text}}}</p>
			<br/>
		</div>
	</div>

<?php	

	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
?>


	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
<?php			
			while($qr_collections->nextHit()) {
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				$vs_collection_image = $qr_collections->get("ca_object_representations.media.medium");
				$vn_collection_title = $qr_collections->get("ca_collections.preferred_labels");
				$vn_collection_id = $qr_collections->get("ca_collections.collection_id");
				print "<div class='col-xs-12 col-sm-6'><div class='collectionTile'>
							<div class='row collectionBlock'>
								<div class='col-xs-12 col-sm-3'><div class='collectionGraphic'>".caDetailLink($this->request, $vs_collection_image, "", "ca_collections",  $vn_collection_id)."</div></div><!-- end col -->
								<div class='col-xs-12 col-sm-8 collectionText'><div class='collectionTitle'>".caDetailLink($this->request, $vn_collection_title, "", "ca_collections",  $vn_collection_id)."</div>	
								</div>
							</div></div>
						</div>";
				$vn_i++;
				if ($vn_i == 2) {
					print "</div><!-- end row -->\n";
					$vn_i = 0;
				}
			}
			if (($vn_i < 2) && ($vn_i != 0) ) {
				print "</div><!-- end row -->\n";
			}
?>

		</div>
	</div>
<?php

	}


?>