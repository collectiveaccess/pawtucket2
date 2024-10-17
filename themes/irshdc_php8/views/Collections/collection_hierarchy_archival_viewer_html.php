<?php
	# --- 2 pane hierarchy viewer on archival collection detail (fonds)
	
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$vs_desc_template = $o_collections_config->get("description_template_archival");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_non_linkable_collection_type_ids = $this->getVar("non_linkable_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");	
	$vb_show_right_panel = false;
	
	# --- get sub collections that are collection records
	if($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))){
		$vb_has_children = true;
		$qr_collection_children = caMakeSearchResult("ca_collections", $va_collection_children);
		if($qr_collection_children->numHits()){
			while($qr_collection_children->nextHit()){
				$vb_has_grandchildren = false;
				if($qr_collection_children->get("ca_collections.children.collection_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))){
					$vb_has_grandchildren = true;
					$vb_show_right_panel = true;
				}
				if($va_grand_children_file_ids = $qr_collection_children->get("ca_objects.object_id", array('restrictToTypes' => array('archival_file'), "restrictToRelationshipTypes" => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))){
					$vb_has_grandchildren = true;
					$vb_show_right_panel = true;
				}
				$vn_rel_object_count = sizeof($qr_collection_children->get("ca_objects.object_id", array('excludeTypes' => array('archival_file'), 'returnAsArray' => true, 'checkAccess' => $va_access_values)));
				$va_collection_contents[] = array("table" => "ca_collections", "id" => $qr_collection_children->get("ca_collections.collection_id"), "name" => $qr_collection_children->get("ca_collections.type_id", array("convertCodesToDisplayText" => true)).": ".$qr_collection_children->get("ca_collections.preferred_labels.name"), "type" => $qr_collection_children->get("ca_collections.type_id", array("convertCodesToDisplayText" => true)), "has_grandchildren" => $vb_has_grandchildren, "num_objects" => $vn_rel_object_count);
				
			}
		}
	}
	# --- get sub collections that are object records (archival files)
	if($va_collection_children = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('archival_file', 'archival'), "restrictToRelationshipTypes" => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_objects.idno_sort'))){
		$vb_has_children = true;
		$qr_collection_children = caMakeSearchResult("ca_objects", $va_collection_children);
		if($qr_collection_children->numHits()){
			while($qr_collection_children->nextHit()){
				$vb_has_grandchildren = false;
				$vn_rel_object_count = sizeof($qr_collection_children->get("ca_objects.related.object_id", array('excludeTypes' => array('archival_file'), 'returnAsArray' => true, 'checkAccess' => $va_access_values)));
				$va_collection_contents[] = array("table" => "ca_objects", "id" => $qr_collection_children->get("ca_objects.object_id"), "name" => $qr_collection_children->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)).": ".$qr_collection_children->get("ca_objects.preferred_labels.name"), "type" => $qr_collection_children->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)), "has_grandchildren" => $vb_has_grandchildren, "num_objects" => $vn_rel_object_count);				
			}
		}
	}
	# --- on series, sub-series records that are not the top level collection, we load the viewer showing the top level collection
	# --- but have it "opened" to the current record
	$current_collection_id = $this->request->getParameter("current_collection_id", pInteger);	
	$t_current_collection = new ca_collections($current_collection_id);
	$va_current_collection_ancestors = $t_current_collection->get("ca_collections.hierarchy.collection_id", array("returnAsArray" => true));	
	$right_col_id = null;
	if($vb_has_children){
?>					
			
				<div class="row" id="collectionsWrapper" <?php print ($o_collections_config->get("browser_closed")) ? "style='display:none;'" : ""; ?>>			
					<div class='col-sm-12'>
					
					
						<div class='unit row'>
							<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
								<hr class='divide' style='margin-bottom:0px; margin-top:3px;'></hr>
							</div>
						</div>
						<div class='unit row'>
							<div class='col-xs-12<?php print ($vb_show_right_panel) ? "col-sm-4 col-md-4 col-lg-4" : ""; ?>'>
								<div class='collectionsContainer'><div class='label'><?php print ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true))); ?> Contents</div>
<?php
					if(is_array($va_collection_contents) && sizeof($va_collection_contents)){
						foreach($va_collection_contents as $va_collection_content) {
							print "<div style='margin-left:0px;margin-top:5px;'>";
							# --- link open in panel or to detail
							$vb_link_sublist = false;
							if($va_collection_content["has_grandchildren"]){
								$vb_link_sublist = true;
							}
							$vs_record_count = "";
							if($va_collection_content["num_objects"] > 0){
								$vs_record_count = "<br/><small>(".$va_collection_content["num_objects"]." record".(($va_collection_content["num_objects"] == 1) ? "" : "s").")</small>";
							}
							if($vb_link_sublist){
								$vb_active = null;
								if(in_array($va_collection_content["id"], $va_current_collection_ancestors)){
									$right_col_id = $va_collection_content["id"];
									$vb_active = true;
								}
								print "<a href='#' class='".(($vb_active) ? "active " : "")."openCollection openCollection".$va_collection_content["id"]."'>".$va_collection_content["name"].$vs_record_count."</a>";
								
							}else{
								# --- there are no grandchildren to show in browser, so check if we should link to detail page instead
								$vb_link_to_detail = true;
								if(!$o_collections_config->get("always_link_to_detail")){
									if(!$va_collection_content["has_grandchildren"] && !$va_collection_content["num_objects"]){
										$vb_link_to_detail = false;
									}
								}
			
								if($vb_link_to_detail){
									print caDetailLink($this->request, $va_collection_content["name"]." ".(($o_collections_config->get("link_out_icon")) ? $o_collections_config->get("link_out_icon") : "").$vs_record_count, '', $va_collection_content["table"],  $va_collection_content["id"]);
								}else{
									print "<div class='listItem'>".$va_collection_content["name"].$vs_record_count."</div>";
								}
							}
							print "</div>";	
							
							

							if($vb_link_sublist){
?>													
								<script>
									$(document).ready(function(){
										$('.openCollection<?php print $va_collection_content["id"];?>').click(function(){
											$('#collectionLoad').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
											$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'Collections', 'ChildListArchivalViewer', array('collection_id' => $va_collection_content["id"])); ?>");
											//$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchyArchival', array('collection_id' => $va_collection_content["id"])); ?>");
											$('.openCollection').removeClass('active');
											$('.openCollection<?php print $va_collection_content["id"];?>').addClass('active');
											return false;
										}); 
									})
								</script>						
<?php								
							}
						}
					}
?>
								</div><!-- end findingAidContainer -->
							</div><!-- end col -->
<?php
					if($vb_show_right_panel){
?>
							<div id='collectionLoad' class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>
								<i class='fa fa-arrow-left'></i> Click a <?php print ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true))); ?> container to the left to see its contents.
							</div>
<?php
							if($right_col_id){
								# --- load panel open to show the ancestors of the current collection record
?>
								<script>
									$(document).ready(function(){
										$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'Collections', 'ChildListArchivalViewer', array('collection_id' => $right_col_id, 'current_collection_id' => $current_collection_id)); ?>");
									})
								</script>												
<?php								
							}
					}
?>
						</div><!--end row -->	
						<div class='unit row'>
							<div class='col-sm-12 col-md-12 col-lg-12'><hr class='divide' style='margin-top:0px; margin-bottom:25px;'></hr></div>
						</div><!-- end row -->
				
					</div><!-- end col -->
				</div><!-- end row -->						
<?php
	}
?>			