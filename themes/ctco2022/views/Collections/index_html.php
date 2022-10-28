<?php
	$o_collections_config = $this->getVar("collections_config");
	$va_collection_sources = $this->getVar("collection_sources");
?>
	<div class="row">
		<div class='col-sm-12 col-md-8 col-md-offset-2 collectionsList'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
			<br/>
<?php

	if($vs_intro_global_value = $o_collections_config->get("collections_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='collectionIntro'>".$vs_tmp."</div><br/>";
		}
	}

	$vn_i = 0;
	if(is_array($va_collection_sources) && sizeof($va_collection_sources)) {
		foreach($va_collection_sources as $vn_source_id => $vs_collection_source) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			$vs_tmp = "<div class='col-sm-6'><div class='collectionTile'><div class='title'>".$vs_collection_source."</div>";	

			$vs_tmp .= "</div>";
			print caNavLink($this->request, $vs_tmp, "", "", "Collections",  "Collections", array("source_id" => $vn_source_id));
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
		print _t('No contributors');
	}
?>
		</div>
	</div>
