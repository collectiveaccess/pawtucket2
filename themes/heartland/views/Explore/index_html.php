<?php
	$o_config = $this->getVar("config");
	$va_type_icons = $o_config->get("type_icons");
	$va_types = $this->getVar("types");
?>
<div class="row"><div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
	<H1>Explore</H1>
<?php
			if($vs_intro = $this->getVar("explore_intro")){
				print "<p class='exploreIntro'>".$vs_intro."</p><br/>";
			}
?>
</div></div>
<div class="row exploreTypes">
<?php
	$i = 1;
	foreach($va_types as $va_type){
		$va_type = $va_type[1];
		print "<div class='col-sm-2".(($i == 1) ? " col-sm-offset-1" : "")."'>";
		print caNavLink($this->request, "<div class='exploreType'>".$va_type_icons[$va_type["idno"]]."<br/>".$va_type["name_plural"]."</div>", "", "", "Explore", "type", array("type_id" => $va_type["item_id"]));
		print "</div>";
		$i++;
	}
?>
</div>
<div class="row"><div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
	<H1>Browse</H1>
<?php
			if($vs_intro = $this->getVar("explore_browse_intro")){
				print "<p class='exploreIntro'>".$vs_intro."</p><br/>";
			}
?>
</div></div>
<div class="row exploreBrowseTypes">
<?php
	$i = 0;
	foreach($va_types as $va_type){
		$va_type = $va_type[1];
		$vs_buf = "";
		if($va_type["idno"] == "interactive"){
			$vs_buf = "<div class='col-sm-12 col-md-6 col-md-offset-3'>";
		}else{
			$vs_buf = "<div class='col-sm-12 col-md-6'>";
		}
		$vs_buf .= "<div class='exploreBrowse'>
						<div class='row'>
							<div class='col-sm-6'>".caNavLink($this->request, caGetThemeGraphic($this->request, 'explore_'.$va_type["idno"].'.jpg', array("alt" => "Explore ".$va_type["name_plural"])), "", "", "Browse", "objects", array("facet" => "type_facet", "id" => $va_type["item_id"]))."</div>
							<div class='col-sm-6'>".caNavLink($this->request, $va_type["name_plural"], "exploreBrowseTitle", "", "Browse", "objects", array("facet" => "type_facet", "id" => $va_type["item_id"]))."
								<p>".$this->getVar("explore_browse_".$va_type["idno"])."</p>
							</div>
						</div>
						<br/><div class='text-center'>".caNavLink($this->request, "Browse ".$va_type["name_plural"], "btn btn-default", "", "Browse", "objects", array("facet" => "type_facet", "id" => $va_type["item_id"]))."</div>
						</div>
					</div>";	

		if($va_type["idno"] == "interactive"){
			# --- put interactive resource at the bottom - centered
			$vs_interactive = $vs_buf;
		}else{
			if($i == 0){
				print "<div class='row'>";
			}
			print $vs_buf;
			$i++;
			if($i == 2){
				print "</div>";
				$i = 0;
			}
		}
	}
	if($i > 1){
		print "</div>";
	}
	if($vs_interactive){
		print "<div class='row'>".$vs_interactive."</div>";
	}
?>
</div>