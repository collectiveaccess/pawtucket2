<?php
	
	//
	// Handle AJAX request
	//
	if ($this->request->isAjax()) {
		$vn_item_id = $this->request->getParameter('item_id', pInteger);
		$t_list = new ca_lists();
		$va_list_sub_items = $t_list->getItemsForList($this->getVar('list_code'), array('includeSelf' => true, 'item_id' => $vn_item_id, 'extractValuesByUserLocale' => true, 'enabledOnly' => true, 'sort' => __CA_LISTS_SORT_BY_RANK__));
		
		$va_resp = array();
		
		if (is_array($va_list_sub_items)) {
			foreach($va_list_sub_items as $vn_i => $va_item) {
				if ($va_item['item_id'] == $vn_item_id) { 
					$va_resp['selectedTitle'] = $va_item['name_plural'];
					$va_resp['selectedDescription'] = $va_item['description'] . "<br/><br>" . caNavLink($this->request, _t('View'), '', '', 'Browse', 'Objects', array('facet' => 'term_facet', 'id' => $vn_i));
					continue;
				}
				$va_resp['subList'] .= "<li>".caNavLink($this->request, $va_item['name_plural'], '', '', 'Browse', 'Objects', array('facet' => 'term_facet', 'id' => $vn_i))."</li>\n";
			}
		}
		print json_encode($va_resp);
		return;
	}
?>

<script type="text/javascript">
	function caFrontLoadSubList(item_id) {
		jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', '*'); ?>', {item_id: item_id}, function(data) {
			console.log("data", data);
			jQuery("#tocTopTitle").html(data['selectedTitle']);
			
			if (data['selectedDescription']) {
				jQuery("#tocTopDescription").html(data['selectedDescription']);
			} else {
				jQuery("#tocTopDescription").empty();
			}
			if (data['subList']) {
				jQuery("#tocSubMenu").html(data['subList']);
			} else {
				jQuery("#tocSubMenu").empty();
			}
			
			jQuery("#tocMenu li").removeClass("selected");
			jQuery("#item_" + item_id).addClass("selected");
		});
		
		return false;
	}
</script>
