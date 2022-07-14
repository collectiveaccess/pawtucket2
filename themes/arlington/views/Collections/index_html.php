<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList '>
			<h1><?php print $this->getVar("section_name"); ?></h1>
			</br>

			<?php
				if($vs_intro_global_value = $o_collections_config->get("collections_intro_text_global_value")){
					if($vs_tmp = $this->getVar($vs_intro_global_value)){
						print "<div class='collectionIntro'>".$vs_tmp."</div>";
					}
				}
				$vn_i = 0;
				if($qr_collections && $qr_collections->numHits()) {
					while($qr_collections->nextHit()) {
						if ( $vn_i == 0) { print "<div class='row'>"; }

						$vs_tmp = "<div class='col-sm-6'>
									<div class='collectionTile'>

											".$qr_collections->getWithTemplate("
											<ifcount code='ca_objects' restrictToRelationshipTypes='featured'>
												<unit relativeTo='ca_objects' restrictToRelationshipTypes='featured' length='1'>
													^ca_object_representations.media.iconlarge
												</unit>
											</ifcount>")."

										<div class='title'>".$qr_collections->get("ca_collections.preferred_labels")."</div>";	


						if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
							$vs_scope = strip_tags($vs_scope);
							$vs_tmp .= "<div>".$vs_scope."</div>". "<div class='collectionTileViewBtn text-right'>".caDetailLink($this->request, "View", "btn btn-default btn-small", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";
;
						}
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
