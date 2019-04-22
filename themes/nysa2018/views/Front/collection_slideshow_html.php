<?php
	$o_collection_config = caGetCollectionsConfig();
	$va_access_values = caGetUserAccessValues($this->request);

	$t_list = new ca_lists();
	$vn_collection_type_id = $t_list->getItemIDFromList("collection_types", ($o_collection_config->get("landing_page_collection_type")) ? $o_collection_config->get("landing_page_collection_type") : "topic_collection");
	$vs_sort = ($o_collection_config->get("landing_page_sort")) ? $o_collection_config->get("landing_page_sort") : "ca_collections.preferred_labels.name";
	$qr_collections = ca_collections::find(array('type_id' => $vn_collection_type_id, 'preferred_labels' => ['is_preferred' => 1]), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values, 'sort' => $vs_sort));
	
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
?>
		<div class="row">
			<div class="col-sm-12"><h2>Featured Topics</h2></div>
		</div>
		<div class="row">

<?php
		while($qr_collections->nextHit()) {
			$vs_img = $qr_collections->get("ca_object_representations.media.widepreview", array("primaryOnly" => 1));
?>
			<div class="col-sm-3">
				<div class="homeTile attica">				
					<div class="img"><?php print caDetailLink($this->request, $vs_img, "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));?><div class="title"><?php print caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));?></div></div>
				</div>
			</div>
<?php			
			$vn_i++;
			if($vn_i == 8){
				break;
			}
		}
?>
		</div><!-- end row -->
<?php
	}
?>