<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = "<div><l>^ca_collections.preferred_labels.name (^ca_collections.idno</l>)<br/><div style='font-size:9px; width: 500px; margin-left: 25px;'>^ca_collections.abstract  [^ca_collections.collection_id]</div></div><br/>";
	
	$qr_top_level_collections = ca_collections::find(array('parent_id' => null), array('returnAs' => 'searchResult'));
	
	if ($qr_top_level_collections) {
		while($qr_top_level_collections->nextHit()) {
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id');
			//print $qr_top_level_collections->get('ca_collections.preferred_labels.name')."<br>\n";
		
			$va_hierarchy = $t_collection->hierarchyWithTemplate($ps_template, array('collection_id' => $vn_top_level_collection_id));
		
			foreach($va_hierarchy as $vn_i => $va_hierarchy_item) {
				print "<div style='margin-left: ".($va_hierarchy_item['level'] * 25)."px'>{$va_hierarchy_item['display']}</div>\n";
			}
		}
	} else {
		print _t('No collections available');
	}
?>