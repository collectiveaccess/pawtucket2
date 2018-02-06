<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>
	<div class="container">
		<div class="row">
			<div class='col-md-12 col-lg-12 collectionsList'>
<?php			
	$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/research/";
	$vn_filecount = 0;
	$va_files = glob($vs_directory . "*");
	if ($va_files){
	 $vn_filecount = count($va_files);
	}

	print "<div class='bannerImg'>".caGetThemeGraphic($this->request, 'research/'.rand(1,$vn_filecount).'.jpg')."</div>";
?>
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
