<?php
	$config = caGetGalleryConfig();
	$t_set = new ca_sets();
	$va_access_values = caGetUserAccessValues($this->request);
 	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
?>
<div class="hero heroCollections">
	<div class="heroIntroContainer"><div class="heroIntro">
		<H1>
			<?php print $this->getVar("section_name"); ?>
		</H1>
<?php
	if($vs_intro_global_value = $config->get("gallery_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print $vs_tmp;
		}
	}
?>
	</div></div>
</div>
<div class="container">
	<div class="row">
		<div class='col-md-12 col-lg-12'>



<?php
	print "<H2>All ".$this->getVar("section_name")."</H2>";
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax				
			$i = 0;
			foreach($va_sets as $vn_set_id => $va_set){
				$i++;
				
				$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				print "<div class='col-sm-6'>".caNavLink($this->request, "<div class='bgLightGray imgTile'><div class='row'><div class='col-sm-3'>".$va_first_item["representation_tag"]."</div><div class='col-sm-9'><div class='imgTileText'><div class='imgTileTextTitle'>".$va_set["name"]."</div>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</div></div></div></div>", "", "", "Gallery", $vn_set_id)."</div>";
				$vn_i++;
				if ($vn_i == 2) {
					print "</div><!-- end row -->\n";
					$vn_i = 0;
				}
			}
			if($i){
				print "</div><!-- end row -->";
			}
	}
?>
</div><!-- end col --></div><!-- end row --></div><!-- end container -->
