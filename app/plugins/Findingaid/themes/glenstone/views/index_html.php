<?php
	$t_collection = $this->getVar('t_collection');
	
	$o_search = new CollectionSearch();
	$qr_res = $o_search->search("*", array('sort' =>'ca_collections.preferred_labels.name'));
	
	while($qr_res->nextHit()) {
		print $qr_res->get('ca_collections.preferred_labels.name')."<br>\n";
		
		$va_ids = $t_collection->getHierarchyAsList($qr_res->get('ca_collections.collection_id'), array('idsOnly' => false, 'includeSelf' => false));
		
		print_R($va_ids);
		//$qr_sub_collections = caMakeSearchResult('ca_collections', $va_ids);
		//while($qr_sub_collections->nextHit()) {
		//	print str_repeat("--", 2).$qr_sub_collections->get('ca_collections.preferred_labels.name')."<br>";
		//}
	}
?>


ca_collections::getDisplayHierarchy($pn_collection, $ps_template, $pa_options);