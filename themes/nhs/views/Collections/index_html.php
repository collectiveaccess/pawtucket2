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
			/*******  REMOVE THIS HACK TO HIDE BY ACCESS WHEN START ENFORCING ACCESS *****/
			if(!$qr_collections->get("access")){
				continue;
			}
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='col-sm-6'><div class='collectionTile'><div class='title'>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";	
			if (($o_collections_config->get("description_template")) && ($vs_scope = strip_tags($qr_collections->getWithTemplate($o_collections_config->get("description_template"))))) {
				if(mb_strlen($vs_scope) > 230){
					$vs_scope = substr($vs_scope, 0, 250)."...";
				}
				print "<div>".$vs_scope."</div>";
			}
			print "<div class='viewCollectionLink'>".caDetailLink($this->request, "View <span class='glyphicon glyphicon-circle-arrow-right'></span>", "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";
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
