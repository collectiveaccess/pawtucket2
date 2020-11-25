<?php
	$o_config = $this->getVar("config");
	$va_types = $this->getVar("types");
	$vs_type_name_plural = $this->getVar("type_name_plural");
	$vs_type_name_singular = $this->getVar("type_name_singular");
	$vn_type_id = $this->getVar("type_id");
	$qr_type_items = $this->getVar("type_items_as_search_result");
?>
<div class="row"><div class="col-sm-12">
	<H1 class="text-center">Explore <?php print $vs_type_name_plural; ?></H1>
</div></div>
<?php
	$i = 0;
	if($qr_type_items->numHits()){
		while($qr_type_items->nextHit()){
			if($i == 0){
				print '<div class="row">';
			}
			print "<div class='col-sm-2 exploreTypeItem'>".$qr_type_items->getWithTemplate("<l>^ca_object_representations.media.iconlarge<br/>^ca_objects.preferred_labels</l>")."</div>";
			$i++;
			if($i == 6){
				print '</div>';
				$i = 0;
			}
		}
		if($i > 0){
			print "</div>";
		}
	}
?>
</div>
<?php
	print "<br/><div class='text-center'>".caNavLink($this->request, "Browse All ".$vs_type_name_plural, "btn btn-default", "", "Browse", "objects", array("facet" => "type_facet", "id" => $vn_type_id))."</div>";
?>
