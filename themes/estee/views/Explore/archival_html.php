<?php
	$va_archival_types = $this->getVar("archival_types");
	$qr_archival_types = $this->getVar("archival_types_search");
	$va_access_values = $this->getVar("access_values");
	
	$o_browse = caGetBrowseInstance('ca_objects');
	#$o_browse->execute(array('checkAccess' => $va_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => true));
	$va_available_ids = array_keys($o_browse->getFacet("archival_type_facet", array("checkAccess" => $va_access_values)));
	$o_search = caGetSearchInstance("ca_objects");
 				
?>
	<div class='row'>
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<H1>Archival Items</H1>
			<H2>Lorem ipsum dolor sit amet</H2>
			<p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
			<br/>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="text-center">
<?php
				print "<p>".caNavLink($this->request, _t("Browse All Archival Items"), "btn-default", "", "Browse", "archival")."</p><br/>";
?>
			</div>
		</div>
	</div>
<?php
	if($qr_archival_types->numHits()){
		$vn_i = 0;
		$vn_cols = 3;
		while($qr_archival_types->nextHit()){
			if(!in_array($qr_archival_types->get("ca_list_items.item_id"), $va_available_ids)){
				continue;
			}
			$vs_img = $qr_archival_types->get("ca_list_items.icon.original");
			// if(!$vs_img){
// 				# --- get one object with this brand
// 				$qr_res = $o_search->search("ca_objects.object_brand:".$qr_archival_types->get("ca_list_items.item_id"), array("checkAccess" => $va_access_values, "limit" => 50));
// 				if($qr_res->numHits()){
// 					$i = 0;
// 					while(!$vs_img && ($i < $qr_res->numHits())){
// 						$qr_res->seek(rand(1,$qr_res->numHits()));
// 						$qr_res->nextHit();
// 						$vs_img = $qr_res->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values));
// 						$i++;
// 					}
// 				}
// 			}
			if(!$vs_img){
				$vs_img = caGetThemeGraphic($this->request, 'logoPlaceholder.png');
			}
			$vs_logo = $qr_archival_types->get("ca_list_items.logo.original");
			if(!$vs_logo){
				$vs_logo = "<div class='exploreBrand'>".$qr_archival_types->get("ca_list_items.preferred_labels.name_plural")."</div>";
			}
			if($vn_i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4 col-xs-6'><div class='exploreBrandContainer'>".
						"<div class='exploreImgContainer'>".caNavLink($this->request, $vs_img."<br/>".$vs_logo, "", "", "browse", "archival", array("facet" => "archival_type_facet", "id" => $qr_archival_types->get("ca_list_items.item_id")))."</div>
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
