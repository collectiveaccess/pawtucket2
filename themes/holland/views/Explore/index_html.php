<?php
	$va_categories = $this->getVar("categories");
	$qr_categories = $this->getVar("categories_search");
	$va_access_values = $this->getVar("access_values");
	
	$o_browse = caGetBrowseInstance('ca_objects');
	#$o_browse->execute(array('checkAccess' => $va_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => true));
	$va_available_ids = array_keys($o_browse->getFacet("category_facet", array("checkAccess" => $va_access_values)));
	$o_search = caGetSearchInstance("ca_objects");
 				
?>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
<?php
	if($qr_categories->numHits()){
		$vn_i = 0;
		$vn_cols = 4;
		while($qr_categories->nextHit()){
			if(!in_array($qr_categories->get("ca_list_items.item_id"), $va_available_ids)){
				continue;
			}
			$vs_img = $qr_categories->get("ca_list_items.cat_image.iconlarge");
			if(!$vs_img){
				# --- get one object with this category
				$qr_res = $o_search->search("ca_objects.object_category:".$qr_categories->get("ca_list_items.item_id"), array("checkAccess" => $va_access_values, "limit" => 50));
				if($qr_res->numHits()){
					$i = 0;
					while(!$vs_img && ($i < $qr_res->numHits())){
						$qr_res->seek(rand(1,$qr_res->numHits()));
						$qr_res->nextHit();
						$vs_img = $qr_res->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values));
						$i++;
					}
				}
			}
			if(!$vs_img){
				$vs_img = "<div class='explorePlaceholder'><i class='fa fa-picture-o fa-2x'></i></div>";
			}
			if($vn_i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-3'><div class='exploreCategoryContainer'>".
						"<H2>".caNavLink($this->request, $qr_categories->get("ca_list_items.preferred_labels.name_plural"), "", "", "browse", "objects", array("facet" => "category_facet", "id" => $qr_categories->get("ca_list_items.item_id")))."</H2>".
						"<div class='exploreImgContainer'>".caNavLink($this->request, $vs_img, "", "", "browse", "objects", array("facet" => "category_facet", "id" => $qr_categories->get("ca_list_items.item_id")))."</div>
						<p class='text-center'>".caNavLink($this->request, "View Items", "btn-default btn-sm", "", "browse", "objects", array("facet" => "category_facet", "id" => $qr_categories->get("ca_list_items.item_id")))."</p>
						</div></div>";
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
<script>
	jQuery("#test").load("<?php print caNavUrl($this->request, "", "Browse", "objects", array("facet" => "category_facet", "getFacet" => "1")); ?>");
</script>	
