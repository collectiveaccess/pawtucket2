<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$va_featured = array();
	$va_archival = array();
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			# --- yes no values are switched
			if($qr_collections->get("featured_collection", array("convertCodesToDisplayText" => true)) == "no"){
				$va_featured[$qr_collections->get("collection_id")] = array("image" => $qr_collections->get("ca_object_representations.media.medium"), "title" => $qr_collections->get("ca_collections.preferred_labels"));
			}else{
				$va_archival[$qr_collections->get("collection_id")] = array("image" => $qr_collections->get("ca_object_representations.media.medium"), "title" => $qr_collections->get("ca_collections.preferred_labels"));
			}
		}
	}
?>
	
	<div class='row'>
		<div class="col-sm-12 col-md-8 col-md-offset-1">
			<h1>Guides to the Archives</h1>
			<p class="linkUnderline">{{{collections_intro_text}}}</p>
			<br/>
		</div>
	</div>

<?php	
	$vn_i = 0;
	if(is_array($va_featured) && sizeof($va_featured)) {
?>
		<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<br/><H2>{{{curated_collections_heading}}}</H2>
			<p class="linkUnderline">{{{curated_collections_intro_text}}}</p>

<?php
		foreach($va_featured as $vn_collection_id => $va_collection_info) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			$vs_collection_image = $va_collection_info["image"];
			$vn_collection_title = $va_collection_info["title"];
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
		
			<br/><hr/><br/>
			</div>
		</div>
<?php
	}
	$vn_i = 0;
	if(is_array($va_archival) && sizeof($va_archival)) {
?>


	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<H2>{{{archival_collections_heading}}}</H2>
			<p class="linkUnderline">{{{archival_collections_intro_text}}}</p>
<?php	

		foreach($va_archival as $vn_collection_id => $va_collection_info) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			$vs_collection_image = $va_collection_info["image"];
			$vn_collection_title = $va_collection_info["title"];
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