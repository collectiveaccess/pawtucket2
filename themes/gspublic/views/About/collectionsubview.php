<?php
require_once(__CA_MODELS_DIR__."/ca_collections.php");
function printLevel($va_collection_ids, $vn_level) {
	$vs_output = "";
	$qr_children = caMakeSearchResult("ca_collections", $va_collection_ids);
	if($qr_children->numHits()){
		while($qr_children->nextHit()) {
			$vs_output .= "<div style='margin-left:".(20*$vn_level)."px;'>".$qr_children->get("ca_collections.preferred_labels")."</div>";
			$va_grandchildren_ids = $qr_children->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
			if(sizeof($va_grandchildren_ids)) {
				$vs_output .=  printLevel($va_grandchildren_ids, $vn_level + 1);
			}
		}
	}
	return $vs_output;
}


$va_access_values = caGetUserAccessValues($this->request);

$vn_collection_id = $this->request->getParameter('collection_id', pString);

if ($vn_collection_id) {
	$t_item = new ca_collections($vn_collection_id);
	$vs_type = $t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
	print "<div class='colContainer label'>".(($vs_type != 'File') ? caDetailLink($this->request, $t_item->get('ca_collections.preferred_labels'), '', 'ca_collections',  $t_item->get("ca_collections.collection_id")) : $t_item->get('ca_collections.preferred_labels'))."</div>";
	if ($vs_scope_content = $t_item->get('ca_collections.scopeContent')) {
		print "<p>".$vs_scope_content."</p>";
	}
	$va_collection_children_ids = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values));
	print printLevel($va_collection_children_ids, 1);
	
	#first level
	if ($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
		foreach ($va_collection_children as $va_key => $va_collection_children_id) {
			$t_item_level_2 = new ca_collections($va_collection_children_id);
			
			$vs_type = $t_item_level_2->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
			if ($vs_type == 'box') {
				$vs_icon = "<span class='fa fa-archive'></span>&nbsp;";
			} else if ($vs_type == 'File') {
				$vs_icon = "<span class='fa fa-folder'></span>&nbsp;";
			} else {
				$vs_icon = null;
			}
			# --- if this is a file, only make it a link if there are children
			if($vs_type != "File" || ($vs_type == "File" && $t_item_level_2->get('ca_objects.object_id'))){
				print "<div>".caNavLink($this->request, $vs_icon.$t_item_level_2->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_collection_children_id)."</div>";
			}else{
				print  "<div>".$vs_icon.$t_item_level_2->get('ca_collections.preferred_labels')."</div>";
			}
			if ($vs_scope_content_leveltwo = $t_item_level_2->get('ca_collections.scopeContent')) {
				print "<p>".$vs_scope_content_leveltwo."</p>";
			}
			#next level
			if ($va_collection_level_three = $t_item_level_2->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_collection_level_three as $va_key2 => $va_collection_level_three_id) {
					$t_item_level_3 = new ca_collections($va_collection_level_three_id);
					$vs_type = $t_item_level_3->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
					$vs_icon = null;
					if($vs_type != 'File'){
						if ($vs_type == 'box') {
							$vs_icon = "<span class='fa fa-archive'></span>&nbsp;";
						}
						print "<div style='margin-left:30px;'>".caNavLink($this->request, $vs_icon.$t_item_level_3->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_collection_level_three_id)."</div>";
						if ($vs_scope_content_levelthree = $t_item_level_3->get('ca_collections.scopeContent')) {
							print "<p style='margin-left:30px;'>".$vs_scope_content_levelthree."</p>";
						}
						#next level
						if ($va_collection_level_four = $t_item_level_3->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
							foreach ($va_collection_level_four as $va_key3 => $va_collection_level_four_id) {
								$t_item_level_4 = new ca_collections($va_collection_level_four_id);
								$vs_type = $t_item_level_4->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
								$vs_icon = null;
								if($vs_type != 'File'){
									if ($vs_type == 'box') {
										$vs_icon = "<span class='fa fa-archive'></span>&nbsp;";
									}							
									print "<div style='margin-left:60px;'>".caNavLink($this->request, $vs_icon.$t_item_level_4->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_collection_level_four_id)."</div>";
									if ($vs_scope_content_levelfour = $t_item_level_4->get('ca_collections.scopeContent')) {
										print "<p style='margin-left:60px;'>".$vs_scope_content_levelfour."</p>";
									}						
								}
							}
						}
					}					
				}
			}
			
		}
	}
}


?>

