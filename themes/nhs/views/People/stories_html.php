<?php
	$qr_people = $this->getVar("set_items_as_search_result");
	$va_access_values = $this->getVar("access_values");
?>
	<div class="row"><div class="col-sm-12">
		<H1>Featured Stories</H1>
<?php
			if($vs_tmp = $this->getVar("people_stories")){
				print "<p>".$vs_tmp."</p>";
			}
?>			
	</div></div>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 col-md-12 col-md-offset-0 col-lg-10 col-lg-offset-1">		
			<div class="featuredList">	
	<?php	
					$vn_i = 0;
					if($qr_people && $qr_people->numHits()) {
						while($qr_people->nextHit()) {
							if ( $vn_i == 0) { print "<div class='row'>"; } 
							$vs_tmp = "<div class='col-sm-12 col-md-4'>";
							$vs_tmp .= "<div class='featuredTile'>";
							$vs_image = "";
							if ($vs_image = $qr_people->getWithTemplate("<unit relativeTo='ca_objects' limit='1'>^ca_object_representations.media.iconlarge</unit>", array("checkAccess" => $va_access_values))) {
								$vs_tmp .= "<div class='featuredImage'>".$vs_image."</div>";
							}
							$vs_tmp .= "<div class='title'>".$qr_people->get("ca_entities.preferred_labels.displayname")."</div>";	
							$vs_tmp .= "</div>";
							print caNavLink($this->request, $vs_tmp, "", "", "People", "Story", array('doRefSubstitution' => true, "story" => $qr_people->get("ca_entities.entity_id")));

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
						print _t('No featured people available');
					}
	?>		
			</div>
		</div>
	</div>
</div>