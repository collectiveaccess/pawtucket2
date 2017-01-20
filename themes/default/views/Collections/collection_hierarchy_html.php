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
			<div class='text-right'><a href='#' onclick='$("#collectionsWrapper").toggle(300);return false;' class='showHide'>Show/Hide Collection Browser</a></div>
				<div class="row" id="collectionsWrapper" <?php print ($o_collections_config->get("browser_closed")) ? "style='display:none;'" : ""; ?>>			
					<div class='col-sm-12'>
					
					
						<div class='unit row'>
							<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
								<hr class='divide' style='margin-bottom:0px; margin-top:3px;'></hr>
							</div>
						</div>
						<div class='unit row'>
							<div class='col-xs-12<?php print ($vb_has_grandchildren) ? "col-sm-4 col-md-4 col-lg-4" : ""; ?>'>
								<div class='collectionsContainer'><div class='label'><?php print ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true))); ?> Contents</div>
<?php
					if($qr_collection_children->numHits()){
						while($qr_collection_children->nextHit()) {
							$vs_icon = "";
							if(is_array($va_collection_type_icons)){
								$vs_icon = $va_collection_type_icons[$qr_collection_children->get("ca_collections.type_id")];
							}
							print "<div style='margin-left:0px;margin-top:5px;'>";
							# --- link open in panel or to detail
							$va_grand_children_type_ids = $qr_collection_children->get("ca_collections.children.type_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
							$vb_link_sublist = false;
							if(sizeof($va_grand_children_type_ids)){
								$vb_link_sublist = true;
							}
							$vn_rel_object_count = sizeof($qr_collection_children->get("ca_objects.object_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values)));
							$vs_record_count = "";
							if($vn_rel_object_count){
								$vs_record_count = "<br/><small>(".$vn_rel_object_count." record".(($vn_rel_object_count == 1) ? "" : "s").")</small>";
							}
							if($vb_link_sublist){
								print "<a href='#' class='openCollection openCollection".$qr_collection_children->get("ca_collections.collection_id")."'>".$vs_icon." ".$qr_collection_children->get('ca_collections.preferred_labels').$vs_record_count."</a>";
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
									print caDetailLink($this->request, $vs_icon." ".$qr_collection_children->get('ca_collections.preferred_labels')." ".(($o_collections_config->get("link_out_icon")) ? $o_collections_config->get("link_out_icon") : ""), '', 'ca_collections',  $qr_collection_children->get("ca_collections.collection_id")).$vs_record_count;
								}else{
									print "<div class='listItem'>".$vs_icon." ".$qr_collection_children->get('ca_collections.preferred_labels').$vs_record_count."</div>";
								}
							}
							print "</div>";	
							if($vb_link_sublist){
?>													
								<script>
									$(document).ready(function(){
										$('.openCollection<?php print $qr_collection_children->get("ca_collections.collection_id");?>').click(function(){
											$('#collectionLoad').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
											$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'Collections', 'childList', array('collection_id' => $qr_collection_children->get("ca_collections.collection_id"))); ?>");
											$('.openCollection').removeClass('active');
											$('.openCollection<?php print $qr_collection_children->get("ca_collections.collection_id");?>').addClass('active');
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
					if($vb_has_grandchildren){
?>
							<div id='collectionLoad' class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>
								<i class='fa fa-arrow-left'></i> Click a <?php print ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true))); ?> container to the left to see its contents.
							</div>
<?php
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