<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$vs_open_default = $this->getVar('open_by_default');
	#AssetLoadMananger::register('readmore');
	AssetLoadManager::register("readmore");
	
	$qr_top_level_collections = ca_collections::find(array('type_id' => 119), array('returnAs' => 'searchResult', 'sort' => 'ca_collection_labels.name'));
 
?>
	<h1><?php print $vs_page_title; ?></h1>
	<div class='findingIntro'><?php print $vs_intro_text; ?></div>
	<div id='findingAidCont'>
<?php	
	if ($qr_top_level_collections) {
		while($qr_top_level_collections->nextHit()) { 
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id', array('checkAccess' => caGetUserAccessValues($this->request)));
			$va_hierarchy = $t_collection->hierarchyWithTemplate($ps_template, array('collection_id' => $vn_top_level_collection_id));
			foreach($va_hierarchy as $vn_i => $va_hierarchy_item) {
				$t_collection_item = new ca_collections($va_hierarchy_item['id']);
				if ($t_collection_item->get('ca_collections.fa_access') != 261) {
					print "<div class='collHeader' >";
					#if (($va_hierarchy_item['level']) == 0 && ($qr_top_level_collections->get('ca_collections.children.collection_id'))) {
					#	print "<a href='#'><i class='fa fa-angle-double-down finding-aid down{$vn_top_level_collection_id}'></i></a>";
					#} elseif ($va_hierarchy_item['level'] == 0) {
						print "<i class='fa fa-square-o finding-aid' {$va_opacity}></i>";
					#} else {
					#	$va_opacity = "style='opacity: .".(90 - ($va_hierarchy_item['level'] * 20))."' ";
					#	print "<i class='fa fa-angle-right finding-aid' {$va_opacity}></i>";
					#}
					if ($t_collection_item->get('ca_collections.fa_access') == 262) {
						print "<div class='text'>".caNavLink($this->request, $t_collection_item->get('ca_collections.preferred_labels')." (".$t_collection_item->get('ca_collections.idno').")", '', '', 'Detail', 'collections/'.$va_hierarchy_item['id'])."</div><br/>";
					} else {
						print "<div class='text'>".caNavLink($this->request, $t_collection_item->get('ca_collections.preferred_labels.name')." (".$t_collection_item->get('ca_collections.idno').")", '', '', 'Detail', 'collections/'.$va_hierarchy_item['id'])." <br/><div style='font-weight:200; width: 500px; margin-left: 30px;' class='trimText'>".$t_collection_item->get('ca_collections.abstract')."</div></div><br/>";
					}
					print "</div><!-- end collHeader-->";
				}
				if ($va_hierarchy_item['level'] == 0) {
					if ($vs_open_default == true) {
						$vs_open_style = "style='display:none';";
					}
				
					print "<div class='collBlock".$vn_top_level_collection_id."' {$vs_open_style}>";
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
			print "</div><!-- collBlock -->";
		}
	} else {
		print _t('No collections available');
	}
?>
	</div><!-- findingAid Cont-->
	
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 100
		});
	});
</script>	
