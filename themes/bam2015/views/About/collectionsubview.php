<?php
require_once(__CA_MODELS_DIR__."/ca_collections.php");
$va_access_values = caGetUserAccessValues($this->request);

$vn_collection_id = $this->request->getParameter('collection_id', pString);

if ($vn_collection_id) {
	$t_item = new ca_collections($vn_collection_id);
	$vs_type = $t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
	print "<div class='colContainer label'>".(($vs_type != 'Folder') ? caNavLink($this->request, $t_item->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_item->get('ca_collections.collection_id')) : $t_item->get('ca_collections.preferred_labels'))."</div>";
	if ($vs_scope_content = $t_item->get('ca_collections.scopeContent')) {
		print "<p>".$vs_scope_content."</p>";
	}
	#first level
	if ($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
		foreach ($va_collection_children as $va_key => $va_collection_children_id) {
			$t_item_level_2 = new ca_collections($va_collection_children_id);
			
			$vs_type = $t_item_level_2->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
			if ($vs_type == 'Box') {
				$vs_icon = "<span class='icon-box'></span>&nbsp;";
			} else if ($vs_type == 'Folder') {
				$vs_icon = "<span class='icon-folder'></span>&nbsp;";
			} else {
				$vs_icon = null;
			}
			print "<div>".(($vs_type != 'Folder') ? caNavLink($this->request, $vs_icon.$t_item_level_2->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_collection_children_id) : $vs_icon.$t_item_level_2->get('ca_collections.preferred_labels'))."</div>";
			if ($vs_scope_content_leveltwo = $t_item_level_2->get('ca_collections.scopeContent')) {
				print "<p>".$vs_scope_content_leveltwo."</p>";
			}
			#next level
			if ($va_collection_level_three = $t_item_level_2->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_collection_level_three as $va_key2 => $va_collection_level_three_id) {
					$t_item_level_3 = new ca_collections($va_collection_level_three_id);
					$vs_type = $t_item_level_3->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
					if ($vs_type == 'Box') {
						$vs_icon = "<span class='icon-box'></span>&nbsp;";
					} else if ($vs_type == 'Folder') {
						$vs_icon = "<span class='icon-folder'></span>&nbsp;";
					} else {
						$vs_icon = null;
					}
					print "<div style='margin-left:30px;'>".(($vs_type != 'Folder') ? caNavLink($this->request, $vs_icon.$t_item_level_3->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_collection_level_three_id) : $vs_icon.$t_item_level_3->get('ca_collections.preferred_labels'))."</div>";
					if ($vs_scope_content_levelthree = $t_item_level_3->get('ca_collections.scopeContent')) {
						print "<p style='margin-left:30px;'>".$vs_scope_content_levelthree."</p>";
					}
					#next level
					if ($va_collection_level_four = $t_item_level_3->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						foreach ($va_collection_level_four as $va_key3 => $va_collection_level_four_id) {
							$t_item_level_4 = new ca_collections($va_collection_level_four_id);
							$vs_type = $t_item_level_4->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
							if ($vs_type == 'Box') {
								$vs_icon = "<span class='icon-box'></span>&nbsp;";
							} else if ($vs_type == 'Folder') {
								$vs_icon = "<span class='icon-folder'></span>&nbsp;";
							} else {
								$vs_icon = null;
							}							
							
							print "<div style='margin-left:60px;'>".(($vs_type != 'Folder') ? caNavLink($this->request, $vs_icon.$t_item_level_4->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_collection_level_four_id) : $vs_icon.$t_item_level_4->get('ca_collections.preferred_labels'))."</div>";
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


?>

