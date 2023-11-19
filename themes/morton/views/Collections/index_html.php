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
			print "<div class='col-sm-6'>".$qr_collections->getWithTemplate("<l><div class='collectionTile'><div class='title'>^ca_collections.preferred_labels.name (^ca_collections.idno)<if rule='^ca_collections.date.date_types =~ /Date created/'>, Created <unit relativeTo='ca_collections.date' delimiter=', '><ifdef code='ca_collections.date.date_value'>^ca_collections.date.date_value</ifdef></unit></if></l></div></div>")."</div>";	
			
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
