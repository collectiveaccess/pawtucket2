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
	# --- if this is a project, label the child list as "Shoots"
	$type = strToLower($t_item->get("ca_collections.type_id", array("convertCodesToDisplayText" => true)));
	$child_list_heading = "";
	$right_window_text = "";
	switch($type){
		case "project":
			$child_list_heading = "Shoots in this project";
			$right_window_text_left = "Click a shoot at left to get more information";
			$right_window_text_top = "Click a shoot above to get more information";
		break;
		# ------------------------
	}
	if($vb_has_children){
?>					
				<hr/>
				<div class="row" id="collectionsWrapper">
					<div class='overflow-y-auto col-12<?php print ($o_collections_config->get("always_link_to_hierarchy_viewer_sublist") || $vb_has_grandchildren) ? " col-sm-4" : ""; ?>'>
						<div class='mx-3'>
							<div class='fw-medium fs-3'><?php print $child_list_heading; ?></div>
<?php
					if($qr_collection_children->numHits()){
						print "<ul class='list-unstyled' role='tablist' aria-orientation='vertical'>";
						$c = 1;
						while($qr_collection_children->nextHit()) {
							$vs_icon = "";
							if(is_array($va_collection_type_icons)){
								$vs_icon = $va_collection_type_icons[$qr_collection_children->get("ca_collections.type_id")];
							}
							print "<li class='mt-2'>";
							# --- link open in panel or link to detail
							$va_grand_children_type_ids = $qr_collection_children->get("ca_collections.children.type_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
							$vb_link_sublist = false;
							if(sizeof($va_grand_children_type_ids)){
								$vb_link_sublist = true;
							}
							$vn_rel_object_count = sizeof($qr_collection_children->get("ca_objects.object_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values)));
							$vs_record_count = "";
							if($vn_rel_object_count){
								$vs_record_count = "<br aria-hidden='true' /><small class='ms-2 fw-normal'>(".$vn_rel_object_count." record".(($vn_rel_object_count == 1) ? "" : "s").")</small>";
							}
							if($vb_link_sublist || $o_collections_config->get("always_link_to_hierarchy_viewer_sublist")){
								print "<button data-bs-toggle='pill' type='button' role='tab' aria-selected='".(($c == 1) ? "true" : "false")."' aria-controls='#collectionLoad' class='btn w-100 text-start p-3 d-block bg-body-tertiary text-black fw-medium' hx-target='#collectionLoad' hx-get='".caNavUrl($this->request, '', 'Collections', 'childList', array('collection_id' => $qr_collection_children->get("ca_collections.collection_id")))."'>".$vs_icon." ".$qr_collection_children->getWithTemplate('<ifdef code="ca_collections.work_date"><div class="fs-6">^ca_collections.work_date</div></ifdef>^ca_collections.preferred_labels').$vs_record_count."</a>";
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
									print caDetailLink($this->request, $vs_icon." ".$qr_collection_children->getWithTemplate('<ifdef code="ca_collections.work_date"><div class="fs-6">^ca_collections.work_date</div></ifdef>^ca_collections.preferred_labels')." ".(($o_collections_config->get("link_out_icon")) ? $o_collections_config->get("link_out_icon") : "").$vs_record_count, 'p-3 d-block bg-body-tertiary text-black fw-medium', 'ca_collections',  $qr_collection_children->get("ca_collections.collection_id"));
								}else{
									print "<div class='p-3 d-block bg-body-tertiary fw-medium'>".$vs_icon." ".$qr_collection_children->getWithTemplate('<ifdef code="ca_collections.work_date"><div class="fs-6">^ca_collections.work_date</div></ifdef>^ca_collections.preferred_labels').$vs_record_count."</div>";
								}
							}
							print "</li>";	
							$c++;
						}
						print "</ul>";
					}
?>
								</div><!-- end findingAidContainer -->
							</div><!-- end col -->
<?php
					if($o_collections_config->get("always_link_to_hierarchy_viewer_sublist") || $vb_has_grandchildren){
?>
							<div class='mt-4 mt-sm-0 overflow-y-auto col-xs-12 col-sm-8 border-start '><div id='collectionLoad' class='mx-3'>
								<div class="d-none d-sm-block"><i class="bi bi-arrow-left"></i> <?php print $right_window_text_left; ?></div>
								<div class="d-block d-sm-none"><i class="bi bi-arrow-up"></i> <?php print $right_window_text_top; ?></div>
							</div></div>
<?php
					}
?>
						</div><!--end row -->
				<hr/>					
<?php
	}
?>			