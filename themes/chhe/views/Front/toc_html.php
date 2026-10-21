<?php
	$vs_list_code = $this->getVar("list_code");
	$va_list_items = array();
	if($vs_list_code){
		$t_list = ca_lists::find(array('list_code' => $vs_list_code), array('returnAs' => 'firstmodelinstance'));
		if($t_list){
			$va_list_items = $t_list->getItemsForList($vs_list_code, array('directChildrenOnly' => true, 'extractValuesByUserLocale' => true, 'enabledOnly' => true, 'sort' => __CA_LISTS_SORT_BY_RANK__));
			$vn_selected_top_level_item_id = array_shift(array_keys($va_list_items));
		}
	}
?>
<div class="container subhomebody">
	<div class="row">
		<div class="col-sm-3 mainmenu">
			<!--main menu will go here-->
			<ol id="tocMenu">
<?php
	foreach($va_list_items as $vn_i => $va_item) {
		if ($vn_i == $vn_selected_top_level_item_id) { $vs_selected = "class='selected'"; } else { $vs_selected = ''; }
		print "<li  {$vs_selected} id='item_{$va_item['item_id']}'><a href='#' onclick='return caFrontLoadSubList({$vn_i});'>".$va_item['name_plural']."</a></li>\n";
	}
	
	$va_selected_item = $va_list_items[$vn_selected_top_level_item_id];
?>
			</ol>
		</div><!-- end col -->
		<div class="col-sm-9"> <h1 id="tocTopTitle"><?php print $va_selected_item['name_plural']; ?></h1>
			<div class="row">
				<div class="col-sm-7 sectionpreview" id="tocTopDescription">
						
				</div><!-- end row -->
			
				<div class="col-sm-5 submenu">
					<ul id="tocSubMenu">
<?php
	
?>
						
					</ul>
				</div><!-- end col -->
			</div><!-- end row -->

		</div><!-- end col -->
	</div><!-- end row -->	
	
<script type="text/javascript">
	jQuery(document).ready(function() {
		caFrontLoadSubList(<?php print $vn_selected_top_level_item_id; ?>);
	});
</script>