<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$va_types = $this->getVar('restrict_to_types');
	
	if ($va_types) {
		$qr_top_level_collections = ca_collections::find(array('parent_id' => null, 'type_id' => array($va_types)), array('returnAs' => 'searchResult'));	
	} else {
		$qr_top_level_collections = ca_collections::find(array('parent_id' => null), array('returnAs' => 'searchResult'));
	}
?>
	<h1><?php print $vs_page_title; ?></h1>
	<div class='findingIntro'><?php print $vs_intro_text; ?></div>
	<div id='findingAidCont'>
<?php	
	if ($qr_top_level_collections) {
		while($qr_top_level_collections->nextHit()) {
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id');
			//print $qr_top_level_collections->get('ca_collections.preferred_labels.name')."<br>\n";
		
			$va_hierarchy = $t_collection->hierarchyWithTemplate($ps_template, array('collection_id' => $vn_top_level_collection_id));
		
			foreach($va_hierarchy as $vn_i => $va_hierarchy_item) {
				print "<div class='collHeader' style='margin-left: ".($va_hierarchy_item['level'] * 25)."px'>{$va_hierarchy_item['display']}</div>\n";
			}
		}
	} else {
		print _t('No collections available');
	}
?>
	</div>