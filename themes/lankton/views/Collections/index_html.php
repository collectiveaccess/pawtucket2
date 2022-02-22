<?php
	AssetLoadManager::register("readmore");
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	# --- get id of Greer collection so can link to finding aid
	$t_collection = new ca_collections(array("idno" => "GL", "deleted" => 0));
	$vn_greer_lankton_collection_id = $t_collection->get("ca_collections.collection_id");
	$va_access_values = caGetUserAccessValues($this->request);
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
<?php
	if($vn_greer_lankton_collection_id){
		print "<div class='detailButton'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download Collection Finding Aid", "", "ca_collections",  $vn_greer_lankton_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
	}
?>
			<h1><?php print $this->getVar("section_name"); ?></h1>
			<p class="trimText">{{{collection_guide_intro}}}</p>
<?php	
	$vn_i = 0;
	$vn_c = 1;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if($qr_collections->getWithTemplate("<unit relativeTo='ca_collections.parent'>^ca_collections.idno</unit>") == "GL"){
				$vs_img_url = $qr_collections->get("ca_object_representations.media.large.url", array("checkAccess" => $va_access_values, "limit" => 1));
				if(!$vs_img_url){
					$vs_img_url = caGetThemeGraphicUrl($this->request, 'front_1.jpg', "", "", "","");
				}
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				print "<div class='col-sm-6 col-md-4'>";
				if($qr_collections->getWithTemplate("<unit relativeTo='ca_collections.children'>^ca_collections.collection_id</unit>")){
					print caNavLink($this->request, 
							"<div class='collectionTile'>
								<div class='collectionImg' style='background-image: url(\"".$vs_img_url."\")'></div>
								<div class='title'>".$qr_collections->get("ca_collections.preferred_labels")."</div>
							</div>", "", "", "Search",  "collections", array("search" => "ca_collections.parent_id:".$qr_collections->get("ca_collections.collection_id")));				
				}else{
					print caDetailLink($this->request, 
							"<div class='collectionTile'>
								<div class='collectionImg' style='background-image: url(\"".$vs_img_url."\")'></div>
								<div class='title'>".$qr_collections->get("ca_collections.preferred_labels")."</div>
							</div>", "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));
				}
				print "</div>";
				$vn_i++;
				$vn_c++;
				if ($vn_i == 3) {
					print "</div><!-- end row -->\n";
					$vn_i = 0;
				}
			}
		}
		if ($vn_i > 0) {
			print "</div><!-- end row -->\n";
		}
	} else {
		print _t('No collections available');
	}
?>
		</div>
	</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 95,
		  moreLink: '<a href="#">> More</a>',
		  lessLink: '<a href="#">> Less</a>'
		});
	});
</script>