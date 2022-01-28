<div class="row"><div class="col-sm-12">
	<H1><?php print $this->getVar("section_name").": ".$this->getVar("theme"); ?></H1>
<?php
	if($vs_theme_desc = $this->getVar("theme_description")){
		print "<p>".$vs_theme_desc."</p>";
	}
?>
</div></div>
<div class="row">
	<div class="col-sm-12 col-md-10 col-md-offset-1">	
	
<?php
	$va_sets = $this->getVar("sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		$i = 0;
		foreach($va_sets as $va_set){
			$vn_set_id = $va_set["set_id"];
			if($vn_featured_set_id == $vn_set_id){
				continue;
			}
			if($i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4'><div class='featuredItem'>";
			print caNavLink($this->request, $va_set["media"], "", "", "Featured", "Detail", array("set_id" => $vn_set_id, "setMode" => "exhibitions"));
			print "<div class='featuredItemTitle'>".caNavLink($this->request, $va_set["title"], "", "", "Featured", "Detail", array("set_id" => $vn_set_id, "setMode" => "exhibitions"))."</div>";
			if($vs_desc = $va_set["description"]){
				print "<div>".((mb_strlen($vs_desc) > 160) ? substr(strip_tags($vs_desc), 0, 160)."..." : $vs_desc)."</div>";
			}
			print "</div></div>";
			$i++;
			if($i == 3){
				print "</div>";
				$i = 0;
			}
		}
		if($i){
			print "</div>";
		}
	}
?>
</div></div>