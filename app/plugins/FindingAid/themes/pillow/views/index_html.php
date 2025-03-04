<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$va_open_by_default = $this->getVar('open_by_default');
	
	$qr_top_level_collections = ca_collections::find(array('parent_id' => null), array('returnAs' => 'searchResult', 'sort' => 'ca_collections.preferred_labels', 'checkAccess' => caGetUserAccessValues($this->request)));
	
	if (!$va_open_by_default) {
		$vs_hierarchy_style = "style='display:none;'";
	}
?>
<div class="col-sm-1"></div>
<div class="col-sm-10 staticPageArea">
	<h4><?php print $vs_page_title; ?></h4>
	<div style="clear:both;width:100%"></div>
	<div class='findingIntro'><?php print $vs_intro_text; ?></div>
	<div id='findingAidCont'>
<?php	
	if ($qr_top_level_collections) {
		while($qr_top_level_collections->nextHit()) { 
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id');
			print "<div class='collHeader' style='margin-left: 0px'>";
			print $qr_top_level_collections->getWithTemplate($ps_template, array('collection_id' => $vn_top_level_collection_id, 'sort' => 'ca_collections.preferred_labels'));
			print "</div>\n";
		}
	} else {
		print _t('No collections available');
	}
?>