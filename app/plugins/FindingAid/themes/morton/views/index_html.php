<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$va_open_by_default = $this->getVar('open_by_default');
	
	$qr_top_level_collections = ca_collections::find(array('parent_id' => null), array('returnAs' => 'searchResult', 'sort' => 'ca_collections.rank'));
	
	if (!$va_open_by_default) {
		$vs_hierarchy_style = "style='display:none;'";
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
				print "<div class='collHeader' style='margin-left: ".($va_hierarchy_item['level'] * 35)."px'>";
				if (($va_hierarchy_item['level']) == 0 && ($qr_top_level_collections->get('ca_collections.children.collection_id'))) {
					print "<a href='#'><i class='fa fa-angle-double-down finding-aid down{$vn_top_level_collection_id}'></i></a>";
				} elseif ($va_hierarchy_item['level'] == 0) {
					print "<i class='fa fa-square-o finding-aid' {$va_opacity}></i>";
				} else {
					$va_opacity = "style='opacity: .".(90 - ($va_hierarchy_item['level'] * 20))."' ";
					print "<i class='fa fa-angle-right finding-aid' {$va_opacity}></i>";
				}
				print "{$va_hierarchy_item['display']}</div>\n";
				if ($va_hierarchy_item['level'] == 0) {
				
					print "<div class='collBlock".$vn_top_level_collection_id."' ".$vs_hierarchy_style.">";
?>				
					<script>
						$(function() {
						  $('.down<?php print $vn_top_level_collection_id;?>').click(function() {
							  if ($('.collBlock<?php print $vn_top_level_collection_id;?>').css('display') == 'none') {
							  	 $('.down<?php print $vn_top_level_collection_id;?>').css('-webkit-transform', 'rotate(0deg)');
							     $('.collBlock<?php print $vn_top_level_collection_id;?>').fadeIn("300"); 
							  } else {
							  	$('.down<?php print $vn_top_level_collection_id;?>').css('-webkit-transform', 'rotate(180deg)');
							    $('.collBlock<?php print $vn_top_level_collection_id;?>').fadeOut("300");
							  }
							  return false;
						  });
						})
					</script>
<?php	
				}	
				$v_i++;			
			}
		print "</div>";
		}
	} else {
		print _t('No collections available');
	}
?>
	</div>
