<?php
	$va_categories = $this->getVar("categories");
	$qr_categories = $this->getVar("categories_search");
	$va_access_values = $this->getVar("access_values");
?>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
<?php
	if($qr_categories->numHits()){
		$vn_i = 0;
		$vn_cols = 3;
		while($qr_categories->nextHit()){
			$vs_desc = $qr_categories->get("ca_list_items.description");
			if(mb_strlen($vs_desc) > 250){
				$vs_desc = substr($vs_desc, 0, 250)."...";
			}
			if($vn_i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4'><div class='narrativeThreadContainer'>".
						"<div class='narrativeThreadDesc'><H2>".caNavLink($this->request, $qr_categories->get("ca_list_items.preferred_labels.name_singular"), "", "", "browse", "objects", array("facet" => "category_facet", "id" => $qr_categories->get("ca_list_items.item_id")))."</H2>".
						"<p>".$vs_desc."
						</p><p class='text-center'>".caNavLink($this->request, "Learn More", "btn-default btn-md", "", "browse", "objects", array("facet" => "category_facet", "id" => $qr_categories->get("ca_list_items.item_id")))."</p>
						</div></div></div>";
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