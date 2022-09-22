<?php
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$vs_desc_template = $o_collections_config->get("description_template");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_non_linkable_collection_type_ids = $this->getVar("non_linkable_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");
	$va_collection_contents = array();
	# --- get sub collections that are collection records
	if($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))){
		$vb_has_children = true;
		$qr_collection_children = caMakeSearchResult("ca_collections", $va_collection_children);
		if($qr_collection_children->numHits()){
			while($qr_collection_children->nextHit()){
				$vb_has_grandchildren = false;
				if($qr_collection_children->get("ca_collections.children.collection_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))){
					$vb_has_grandchildren = true;
				}
				if($va_grand_children_file_ids = $qr_collection_children->get("ca_objects.object_id", array('restrictToTypes' => array('archival_file'), "restrictToRelationshipTypes" => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))){
					$vb_has_grandchildren = true;
				}
				$vn_rel_object_count = sizeof($qr_collection_children->get("ca_objects.object_id", array('excludeTypes' => array('archival_file'), 'returnAsArray' => true, 'checkAccess' => $va_access_values)));
				$va_collection_contents[] = array("table" => "ca_collections", "id" => $qr_collection_children->get("ca_collections.collection_id"), "name" => $qr_collection_children->get("ca_collections.type_id", array("convertCodesToDisplayText" => true)).": ".$qr_collection_children->get("ca_collections.preferred_labels.name"), "type" => $qr_collection_children->get("ca_collections.type_id", array("convertCodesToDisplayText" => true)), "has_grandchildren" => $vb_has_grandchildren, "num_objects" => $vn_rel_object_count);
				
			}
		}
	}
	# --- get sub collections that are object records (archival files)
	if($va_collection_children = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('archival_file'), "restrictToRelationshipTypes" => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_objects.idno_sort'))){
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
	if($vb_has_children){
				if(is_array($va_collection_contents) && sizeof($va_collection_contents)){
					foreach($va_collection_contents as $va_collection_content) {
						$vs_icon = '<span class="glyphicon glyphicon-chevron-right"></span> ';
						$vs_icon_open = '<span class="glyphicon glyphicon-chevron-down"></span> ';
						$vs_icon_not_expand = '<span class="glyphicon glyphicon-minus"></span> ';
						#if(is_array($va_collection_type_icons)){
						#	$vs_icon .= $va_collection_type_icons[$qr_collection_children->get("ca_collections.type_id")];
						#}
						print "<div style='margin-left:0px;margin-top:5px;'>";
						# --- link open in panel or to detail
						$vb_link_sublist = false;
						if($va_collection_content["has_grandchildren"]){
							$vb_link_sublist = true;
						}
						$vs_record_count = "";
						if($va_collection_content["num_objects"] > 0){
							$vs_record_count = " <small>(".$va_collection_content["num_objects"]." record".(($va_collection_content["num_objects"] == 1) ? "" : "s").")</small>";
						}
						if($vb_link_sublist){
							print "<div style='position:relative;'>";
							print "<a href='#' class='openCollection openCollection".$va_collection_content["id"]."'><span class='collapseIcon'>".$vs_icon."</span> ".$va_collection_content["name"].$vs_record_count."</a>";
							print caDetailLink($this->request, "<small>View ".$va_collection_content["type"]."</small> ".(($o_collections_config->get("link_out_icon")) ? $o_collections_config->get("link_out_icon") : "detail"), 'linkoutRight', $va_collection_content["table"],  $va_collection_content["id"]);
							print "</div><div id='collectionLoad".$va_collection_content["id"]."' class='collectionLoad'></div>";
						}else{
							# --- there are no grandchildren to show in browser, so check if we should link to detail page instead
							$vb_link_to_detail = true;
							if(!$o_collections_config->get("always_link_to_detail")){
								if(!$va_collection_content["has_grandchildren"] && !$va_collection_content["num_objects"]){
									$vb_link_to_detail = false;
								}
							}

							if($vb_link_to_detail){
								print "<div style='position:relative;'>";
								print $vs_icon_not_expand." ".$va_collection_content["name"].$vs_record_count;
								print caDetailLink($this->request, "<small>View ".$va_collection_content["type"]."</small> ".(($o_collections_config->get("link_out_icon")) ? $o_collections_config->get("link_out_icon") : "detail"), 'linkoutRight', $va_collection_content["table"],  $va_collection_content["id"]);
								print "</div>";
							}else{
								print "<div class='listItem'>".$vs_icon_not_expand." ".$va_collection_content["name"].$vs_record_count."</div>";
							}
						}
						print "</div>";	
						if($vb_link_sublist){
		?>													
							<script>
								$(document).ready(function(){
									$('.openCollection<?php print $va_collection_content["id"];?>').click(function(){
										if($('.openCollection<?php print $va_collection_content["id"];?>').hasClass("active")){
											$('.openCollection<?php print $va_collection_content["id"];?> .collapseIcon').html('<?php print $vs_icon; ?>');
											$('.openCollection<?php print $va_collection_content["id"];?>').removeClass('active');
											$('.openCollection<?php print $va_collection_content["id"];?> .openCollection').removeClass('active');
											
											$('#collectionLoad<?php print $va_collection_content["id"];?>').hide();
										}else{
											//$('.collectionLoad').hide();
											$('#collectionLoad<?php print $va_collection_content["id"]; ?>').show();
											if($('#collectionLoad<?php print $va_collection_content["id"]; ?>').html() == ""){
												$('#collectionLoad<?php print $va_collection_content["id"]; ?>').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
												//$('#collectionLoad<?php print $va_collection_content["id"]; ?>').load("<?php print caNavUrl($this->request, '', 'Collections', 'childListArchival', array('collection_id' => $va_collection_content["id"])); ?>");
												$('#collectionLoad<?php print $va_collection_content["id"]; ?>').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchyArchival', array('collection_id' => $va_collection_content["id"])); ?>");
													
											}
											//$('.openCollection .collapseIcon').html('<?php print $vs_icon; ?>');
											$('.openCollection<?php print $va_collection_content["id"];?> .collapseIcon').html('<?php print $vs_icon_open; ?>');
											//$('.openCollection').removeClass('active');
											$('.openCollection<?php print $va_collection_content["id"];?>').addClass('active');
										}
										return false;
									}); 
								})
							</script>						
		<?php								
						}
					}
				}

	}
?>			