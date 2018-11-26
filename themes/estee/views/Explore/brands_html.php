<?php
	$va_brands = $this->getVar("brands");
	$qr_brands = $this->getVar("brands_search");
	$va_access_values = $this->getVar("access_values");
	
	$o_browse = caGetBrowseInstance('ca_objects');
	#$o_browse->execute(array('checkAccess' => $va_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => true));
	$va_available_ids = array_keys($o_browse->getFacet("brand_facet", array("checkAccess" => $va_access_values)));
 				
?>
	<div class='row'>
		<div class="col-sm-12 col-md-8 col-md-offset-1">
			<H1>Browse the Archives</H1>
			<p class="linkUnderline">{{{browse_intro_text}}}</p>
			<br/>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="text-center">
<?php
				print "<p><div class='exploreBrowseLink'>".caNavLink($this->request, _t("Browse All"), "btn-default", "", "Browse", "objects")."</div><div class='exploreBrowseLink'>".caNavLink($this->request, _t("Browse Products"), "btn-default", "", "Browse", "products")."</div><div class='exploreBrowseLink'>".caNavLink($this->request, _t("Browse Archival Items"), "btn-default", "", "Browse", "archival")."</div></p><br/>";
?>
			</div>
		</div>
	</div>
<?php
	if($qr_brands && $qr_brands->numHits()){
		$vn_i = 0;
		$vn_cols = 5;
		while($qr_brands->nextHit()){
			if(!in_array($qr_brands->get("ca_list_items.item_id"), $va_available_ids)){
				continue;
			}
			$vs_hide_brand = strToLower($qr_brands->get("ca_list_items.hide_brand", array("convertCodesToDisplayText" => true)));
			if($vs_hide_brand == "no"){
				# --- yes no values switched
				continue;
			}
			$vs_img = $qr_brands->get("ca_list_items.icon.square400");
			if($vs_img == "No media available"){
				$vs_img = $qr_brands->get("ca_list_items.icon.original");
			}
			if(!$vs_img){
				$vs_img = caGetThemeGraphic($this->request, 'logoPlaceholder.png');
			}
			#$vs_logo = $qr_brands->get("ca_list_items.logo.original");
			#if(!$vs_logo){
				$vs_logo = "<div class='exploreBrand'>".$qr_brands->get("ca_list_items.preferred_labels.name_plural")."</div>";
			#}
			if($vn_i == 0){
				print "<div class='row exploreBrandGrid'>";
			}
			print "<div class='col-sm-3 col-xs-12'><div class='exploreBrandContainer'>".
						"<div class='exploreImgContainer'>".caNavLink($this->request, $vs_img."<br/>".$vs_logo, "", "", "browse", "objects", array("facet" => "brand_facet", "id" => $qr_brands->get("ca_list_items.item_id")))."</div>
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
