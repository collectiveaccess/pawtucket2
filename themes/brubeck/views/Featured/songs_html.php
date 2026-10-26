<?php
	$va_access_values = $this->getVar("access_values");
	$qr_songs = $this->getVar("songs_results");
	$vn_image_object_id = $this->getVar("image_object_id");
	if($vn_image_object_id){
		$t_object = new ca_objects($vn_image_object_id);
		$t_object->get("ca_objects.object_id");
		$vs_image = $t_object->get("ca_object_representations.media.large", array("checkAccess" => $va_access_values));
	}
	if(!$vs_image){
		$vs_image = caGetThemeGraphic($this->request, 'songs_landing.jpg', array("alt" => "Songs image"));
	}
?>
<div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		<H1>Featured Songs</H1>
	</div>
</div>
<div class="container"><div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		<div class="row bgDarkBlue featuredCallOut">
			<div class="col-sm-12 col-md-6 featuredHeaderImage">
				<?php print $vs_image; ?>
			</div>
			<div class="col-sm-12 col-md-6 text-center">
				<div class="featuredIntro">{{{songs_intro_text}}}</div>
				<div class="featuredSearch"><form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'songs'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="songsSearchInput" placeholder="<?php print _t("Search All Songs"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
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
				if($qr_songs && $qr_songs->numHits()) {
					while($qr_songs->nextHit()) {
						if ( $vn_i == 0) { print "<div class='row'>"; } 
						$vs_tmp = "<div class='col-sm-4'>";
						$vs_tmp .= "<div class='featuredTile'>";
						#$vs_image = "";
						#if ($vs_image = $qr_songs->getWithTemplate("<unit relativeTo='ca_objects' restrictToTypes='still_image' limit='1'>^ca_object_representations.media.iconlarge</unit>")) {
						#	$vs_tmp .= "<div class='featuredImage'>".$vs_image."</div>";
						#}
						$vs_tmp .= "<div class='title noImage'>".$qr_songs->get("ca_occurrences.preferred_labels")."</div>";	
						$vs_tmp .= "</div>";
						print caDetailLink($this->request, $vs_tmp, "", "ca_occurrences", $qr_songs->get("ca_occurrences.occurrence_id"));

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
					print _t('No songs available');
				}
?>		
		</div>
	</div>
</div>