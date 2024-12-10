<?php
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$vs_desc_template = $o_collections_config->get("description_template");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_non_linkable_collection_type_ids = $this->getVar("non_linkable_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");
	$vb_has_children = false;
	$vb_has_grandchildren = false;
	if($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))){
		$vb_has_children = true;
		$qr_collection_children = caMakeSearchResult("ca_collections", $va_collection_children);
		if($qr_collection_children->numHits()){
			while($qr_collection_children->nextHit()){
				if($qr_collection_children->get("ca_collections.children.collection_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))){
					$vb_has_grandchildren = true;
				}
			}
		}
		$qr_collection_children->seek(0);
	}
	if($vb_has_children){
?>					
				<hr/>
				<div class="row" id="collectionsWrapper">
					<div class='h-100 overflow-y-auto col-12<?php print ($o_collections_config->get("always_link_to_hierarchy_viewer_sublist") || $vb_has_grandchildren) ? " col-sm-4" : ""; ?>'>
						<div class='mx-3'>
							<div class='fw-medium fs-3'>Digital Objects</div>
<?php
					$first_sub_collection_id = null;
					if($qr_collection_children->numHits()){
						while($qr_collection_children->nextHit()) {
							$vs_icon = "";
							if(is_array($va_collection_type_icons)){
								$vs_icon = $va_collection_type_icons[$qr_collection_children->get("ca_collections.type_id")];
							}
							print "<div class='mt-2'>";
							# --- link open in panel or link to detail
							$va_grand_children_type_ids = $qr_collection_children->get("ca_collections.children.type_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
							$vb_link_sublist = false;
							if(sizeof($va_grand_children_type_ids)){
								$vb_link_sublist = true;
							}
							$vn_rel_object_count = sizeof($qr_collection_children->get("ca_objects.object_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values)));
							$vs_record_count = "";
							if($vn_rel_object_count){
								$vs_record_count = "<br/><small class='ms-2 fw-normal'>(".$vn_rel_object_count." image".(($vn_rel_object_count == 1) ? "" : "s").")</small>";
							}
							if($vb_link_sublist || $o_collections_config->get("always_link_to_hierarchy_viewer_sublist")){
								if(!$first_sub_collection_id){
									$first_sub_collection_id = $qr_collection_children->get("ca_collections.collection_id");
								}
								print "<a href='#' class='p-3 d-block bg-body-tertiary text-black fw-medium' hx-target='#collectionLoad' hx-get='".caNavUrl($this->request, '', 'Collections', 'childList', array('collection_id' => $qr_collection_children->get("ca_collections.collection_id")))."'>".$vs_icon." ".$qr_collection_children->get('ca_collections.preferred_labels').$vs_record_count."</a>";
							}else{
								# --- there are no grandchildren to show in browser, so check if we should link to detail page instead
								$vb_link_to_detail = true;
								if(is_array($va_non_linkable_collection_type_ids) && (in_array($qr_collection_children->get("ca_collections.type_id"), $va_non_linkable_collection_type_ids))){
									$vb_link_to_detail = false;
								}
								if(!$o_collections_config->get("always_link_to_detail")){
									if(!sizeof($va_grand_children_type_ids) && !$vn_rel_object_count){
										$vb_link_to_detail = false;
									}
								}
			
								if($vb_link_to_detail){
									print caDetailLink($this->request, $vs_icon." ".$qr_collection_children->get('ca_collections.preferred_labels')." ".(($o_collections_config->get("link_out_icon")) ? $o_collections_config->get("link_out_icon") : "").$vs_record_count, 'p-3 d-block bg-body-tertiary text-black fw-medium', 'ca_collections',  $qr_collection_children->get("ca_collections.collection_id"));
								}else{
									print "<div class='p-3 d-block bg-body-tertiary fw-medium'>".$vs_icon." ".$qr_collection_children->get('ca_collections.preferred_labels').$vs_record_count."</div>";
								}
							}
							print "</div>";	
							
						}
					}
?>
								</div><!-- end findingAidContainer -->
							</div><!-- end col -->
<?php
					if($o_collections_config->get("always_link_to_hierarchy_viewer_sublist") || $vb_has_grandchildren){
?>
							<div class='h-100 overflow-y-auto col-xs-12 col-sm-8 border-start'><div id='collectionLoad' class='mx-3'hx-trigger="load" hx-target="#collectionLoad" hx-get="<?php print caNavUrl($this->request, '', 'Collections', 'childList', array('collection_id' => $first_sub_collection_id)); ?>">
								Loading...
							</div></div>

<?php
					}
?>
						</div><!--end row -->
				<hr/>					
<?php
	}
?>			