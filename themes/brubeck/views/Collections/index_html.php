<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>

<div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		<H1>Collection</H1>
	</div>
</div>
<div class="container"><div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		<div class="row bgDarkBlue featuredCallOut">
			<div class="col-sm-12 col-md-6 featuredHeaderImage">
				<?php print caGetThemeGraphic($this->request, 'collection_landing.jpg', array("alt" => "Collections image")); ?>
			</div>
			<div class="col-sm-12 col-md-6 text-center">
				<div class="featuredIntro">{{{collection_intro_text}}}</div>
				<div class="featuredSearch"><form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'collections'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="collectionsSearchInput" placeholder="<?php print _t("Search for Collections"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
						</div>
						<button type="submit" class="btn-search" id="featuredSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
					</div>
				</form></div>
			</div>
		</div>
		
	</div>
</div></div>
<div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">		
		<div class="featuredList">	
<?php	
				$vn_i = 0;
				if($qr_collections && $qr_collections->numHits()) {
					while($qr_collections->nextHit()) {
						if ( $vn_i == 0) { print "<div class='row'>"; } 
						$vs_tmp = "<div class='col-sm-4'>";
						$vs_tmp .= "<div class='featuredTile'>";
						$vs_image = "";
						if ($vs_image = $qr_collections->getWithTemplate("<unit relativeTo='ca_objects' restrictToTypes='still_image' limit='1'>^ca_object_representations.media.iconlarge</unit>")) {
							$vs_tmp .= "<div class='featuredImage'>".$vs_image."</div>";
						}
						$vs_tmp .= "<div class='title ".((!$vs_image) ?  "noImage" : "")."'>".$qr_collections->get("ca_collections.preferred_labels.name")."</div>";	
						if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
							$vs_tmp .= "<div>".$vs_scope."</div>";
						}
						$vs_tmp .= "</div>";
						print caDetailLink($this->request, $vs_tmp, "", "ca_collections", $qr_collections->get("ca_collections.collection_id"));

						print "</div><!-- end col-4 -->";
						$vn_i++;
						if ($vn_i == 3) {
							print "</div><!-- end row -->\n";
							$vn_i = 0;
						}
					}
					if ($vn_i > 0) {
						print "</div><!-- end row -->\n";
					}
				} else {
					print _t('No collections available');
				}
?>		
		</div>
	</div>
</div>