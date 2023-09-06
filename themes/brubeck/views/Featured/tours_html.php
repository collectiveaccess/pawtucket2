<?php
	$qr_tours = $this->getVar("tours_results");
?>
<div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		<H1>Featured Tours</H1>
	</div>
</div>
<div class="container"><div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		<div class="row bgDarkBlue featuredCallOut">
			<div class="col-sm-12 col-md-6 featuredHeaderImage">
				<?php print caGetThemeGraphic($this->request, 'tours_landing.jpg', array("alt" => "Tours image")); ?>
			</div>
			<div class="col-sm-12 col-md-6 text-center">
				<div class="featuredIntro">{{{tours_intro_text}}}</div>
			</div>
		</div>
		
	</div>
</div></div>
<div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">		
		<div class="featuredList">	
<?php	
				$vn_i = 0;
				if($qr_tours && $qr_tours->numHits()) {
					while($qr_tours->nextHit()) {
						if ( $vn_i == 0) { print "<div class='row'>"; } 
						$vs_tmp = "<div class='col-sm-4'>";
						$vs_tmp .= "<div class='featuredTile'>";
						$vs_image = "";
						if ($vs_image = $qr_tours->getWithTemplate("<unit relativeTo='ca_occurrences.related' restrictToTypes='appearance' restrictToRelationshipTypes='included' limit='1'><unit relativeTo='ca_objects' restrictToTypes='still_image' limit='1'>^ca_object_representations.media.iconlarge</unit></unit>")) {
							$vs_tmp .= "<div class='featuredImage'>".$vs_image."</div>";
						}
						$vs_tmp .= "<div class='title'>".$qr_tours->get("ca_occurrences.preferred_labels")."</div>";	
						$vs_tmp .= "</div>";
						print caDetailLink($this->request, $vs_tmp, "", "ca_occurrences", $qr_tours->get("ca_occurrences.occurrence_id"));

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
					print _t('No tours available');
				}
?>		
		</div>
	</div>
</div>