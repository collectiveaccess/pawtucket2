<?php
	$va_themes = $this->getVar("themes");
	$qr_themes = $this->getVar("themes_search");
	$va_access_values = $this->getVar("access_values");
?>
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
			<H1>Themes</H1>
			<p>
				{{{themes_introduction}}}
			</p>
		</div>
	</div>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12 themesList">
<?php
	if($qr_themes->numHits()){
		$vn_i = 0;
		$vn_cols = 3;
		while($qr_themes->nextHit()){
			if($vn_i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4'>".caNavLink($this->request, "<div class='themesContainer'>".$qr_themes->get("ca_list_items.preferred_labels.name_singular")."</div>", "", "", "Browse", "objects", array("facet" => "academic_themes_facet", "id" => $qr_themes->get("ca_list_items.item_id")))."</div>";
			$vn_i++;
			if($vn_i == $vn_cols){
				$vn_i = 0;
				print "</div><!-- end row -->";
			}
		}
		if($vn_i > 0){
			print "</div><!-- end row -->";
		}
	}
?>
		</div><!-- end col -->
	</div><!-- end row -->