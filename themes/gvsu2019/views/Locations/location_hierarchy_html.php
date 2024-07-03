<?php
	$va_access_values = $this->getVar("access_values");
	$o_locations_config = $this->getVar("locations_config");
	$vs_desc_template = $o_locations_config->get("description_template");
	$t_item = $this->getVar("item");
	$vn_location_id = $this->getVar("location_id");
	$va_exclude_location_type_ids = $this->getVar("exclude_location_type_ids");
	$va_non_linkable_location_type_ids = $this->getVar("non_linkable_location_type_ids");
	$va_location_type_icons = $this->getVar("location_type_icons");
	$vb_has_children = false;
	$vb_has_grandchildren_or_obejcts = false;
	if($va_location_children = $t_item->get('ca_storage_locations.children.location_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_storage_locations.preferred_labels.name'))){
		$vb_has_children = true;
		$qr_location_children = caMakeSearchResult("ca_storage_locations", $va_location_children);
		if($qr_location_children->numHits()){
			while($qr_location_children->nextHit()){
				if($qr_location_children->get("ca_storage_locations.children.location_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_storage_locations.preferred_labels.name')) || $qr_location_children->get("ca_objects.object_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values))){
					$vb_has_grandchildren_or_obejcts = true;
				}
			}
		}
		$qr_location_children->seek(0);
	}
	if($vb_has_children){
?>					
			<div class='text-right'><a href='#' onclick='$("#collectionsWrapper").toggle(300);return false;' class='showHide'>Show/Hide Location Browser</a></div>
				<div class="row" id="collectionsWrapper">			
					<div class='col-sm-12'>
					
					
						<div class='unit row'>
							<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
								<hr class='divide' style='margin-bottom:0px; margin-top:3px;'></hr>
							</div>
						</div>
						<div class='unit row'>
							<div class='col-xs-12<?php print ($vb_has_grandchildren_or_obejcts) ? "col-sm-4 col-md-4 col-lg-4" : ""; ?>'>
								<div class='collectionsContainer'><div class='label'><?php print ucFirst($t_item->get("ca_storage_locations.type_id", array('convertCodesToDisplayText' => true))); ?> Contents</div>
<?php
					if($qr_location_children->numHits()){
						while($qr_location_children->nextHit()) {
							$vs_icon = "";
							if(is_array($va_location_type_icons)){
								$vs_icon = $va_location_type_icons[$qr_location_children->get("ca_storage_locations.type_id")];
							}
							print "<div style='margin-left:0px;margin-top:5px;'>";
							# --- link open in panel or to detail
							$va_grand_children_type_ids = $qr_location_children->get("ca_storage_locations.children.type_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
							$vb_link_sublist = false;
							$vn_rel_object_count = sizeof($qr_location_children->get("ca_objects.object_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values)));
							if(sizeof($va_grand_children_type_ids) || $vn_rel_object_count){
								$vb_link_sublist = true;
							}
							$vs_record_count = "";
							if($vn_rel_object_count){
								$vs_record_count = "<br/><small>(".$vn_rel_object_count." artwork".(($vn_rel_object_count == 1) ? "" : "s").")</small>";
							}
							if($vb_link_sublist){
								print "<a href='#' class='openCollection openCollection".$qr_location_children->get("ca_storage_locations.location_id")."'>".$vs_icon." ".$qr_location_children->get('ca_storage_locations.preferred_labels').$vs_record_count."</a>";
							}else{
								# --- there are no grandchildren locations or related objects to show in browser, so check if we should link to detail page instead
								$vb_link_to_detail = true;
								if(is_array($va_non_linkable_location_type_ids) && (in_array($qr_location_children->get("ca_storage_locations.type_id"), $va_non_linkable_location_type_ids))){
									$vb_link_to_detail = false;
								}
								if(!$o_locations_config->get("always_link_to_detail")){
									if(!sizeof($va_grand_children_type_ids) && !$vn_rel_object_count){
										$vb_link_to_detail = false;
									}
								}
			
								if($vb_link_to_detail){
									print caDetailLink($this->request, $vs_icon." ".$qr_location_children->get('ca_storage_locations.preferred_labels')." ".(($o_locations_config->get("link_out_icon")) ? $o_locations_config->get("link_out_icon") : ""), '', 'ca_storage_locations',  $qr_location_children->get("ca_storage_locations.location_id")).$vs_record_count;
								}else{
									print "<div class='listItem'>".$vs_icon." ".$qr_location_children->get('ca_storage_locations.preferred_labels').$vs_record_count."</div>";
								}
							}
							print "</div>";	
							if($vb_link_sublist){
?>													
								<script>
									$(document).ready(function(){
										$('.openCollection<?php print $qr_location_children->get("ca_storage_locations.location_id");?>').click(function(){
											$('#collectionLoad').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
											$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'Locations', 'childList', array('location_id' => $qr_location_children->get("ca_storage_locations.location_id"))); ?>");
											$('.openCollection').removeClass('active');
											$('.openCollection<?php print $qr_location_children->get("ca_storage_locations.location_id");?>').addClass('active');
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
					if($vb_has_grandchildren_or_obejcts){
?>
							<div id='collectionLoad' class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>
								<i class='fa fa-arrow-left'></i> Click a location to the left to see its contents.
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