<div class="row"><div class="col-sm-12 collectionsList">
	<H4>{{{archives_featured_title}}}</H4>
		<p>
			{{{archives_featured_text}}}
		</p>
<?php	
	$va_access_values = caGetUserAccessValues($this->request);
	$o_config = $this->getVar("config");

	$va_featured_sets = $this->getVar("featured_sets");
?>
	<div class='row'>
		<div class='col-sm-5'><div class='collectionTile'>
		<div class='colImage'><?= caNavLink($this->request, caGetThemeGraphic($this->request, 'site_ecology.jpg'), "", "", "Featured", "index"); ?></div>
		<div class='title'><?= caNavLink($this->request, $this->getVar("archives_featured_site_ecology_title"), "", "", "Featured", "index"); ?></div>
		<div class='collectionDetail'>{{{archives_featured_site_ecology_text}}}</div>
		</div></div><div class='col-sm-1'></div>
	
	
<?php
	if(is_array($va_featured_sets) && sizeof($va_featured_sets)){
		$i = 1; # --- set to one to offset for the site ecology static link
		foreach($va_featured_sets as $vn_set_idno => $va_featured_set){
			$vn_set_id = $va_featured_set["set_id"];
			if($i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-5'><div class='collectionTile'>";
			print "<div class='colImage'>".caNavLink($this->request, $va_featured_set["imageWidePreview"], "", "", "Featured", "Detail", array("set_id" => $vn_set_id, "setMode" => "archives"))."</div>";
			print "<div class='title'>".caNavLink($this->request, $va_featured_set["title"], "", "", "Featured", "Detail", array("set_id" => $vn_set_id, "setMode" => "archives"))."</div>";
			print "<div class='collectionDetail'>".$va_featured_set["description"]."</div>";
			print "</div></div><div class='col-sm-1'></div>";
			$i++;
			if ($i == 2) {
				print "</div><!-- end row -->\n";
				$i = 0;
			}
		}
		if (($i < 2) && ($i != 0) ) {
			print "</div><!-- end row -->\n";
		}
	}
	
	
?>
</div></div>