<?php
	
	//
	// Handle AJAX request
	//
	if ($this->request->isAjax()) {
		$vn_item_id = $this->request->getParameter('item_id', pInteger);
		$t_list = new ca_lists();
		$va_list_sub_items = $t_list->getItemsForList($this->getVar('list_code'), array('directChildrenOnly' => true, 'item_id' => $vn_item_id, 'extractValuesByUserLocale' => true, 'enabledOnly' => true, 'sort' => __CA_LISTS_SORT_BY_RANK__));
		
		$va_resp = array();
		
		if (is_array($va_list_sub_items)) {
			foreach($va_list_sub_items as $vn_i => $va_item) {
				$va_list_sub_sub_items = caExtractValuesByUserLocale($t_list->getChildItemsForList($this->getVar('list_code'), $va_item['item_id'], array('directChildrenOnly' => true)));
				if(is_array($va_list_sub_sub_items) && sizeof($va_list_sub_sub_items)){
					$va_resp['subList'] .= "<li><a href='#' onClick='$(\"#tocSubList".$vn_i."\").toggle(); return false;'>+ ".$va_item['name_plural']."</a></li>\n";
					$va_resp['subList'] .= "<ul class='tocSubSubMenu' id='tocSubList".$vn_i."'>";
					foreach($va_list_sub_sub_items as $vn_sub_i => $va_subitem) {
						#$va_resp['subList'] .= "<li>".caNavLink($this->request, $va_subitem['name_plural'], '', '', 'Browse', 'Objects', array('facet' => 'term_facet', 'id' => $vn_sub_i))."</li>\n";
						$va_resp['subList'] .= "<li>".caNavLink($this->request, $va_subitem['name_plural'], '', '', 'MultiSearch', 'Index', array('search' => 'ca_list_items.item_id:'.$vn_sub_i))."</li>\n";
					}
					$va_resp['subList'] .= "</ul>";
				}else{
					#$va_resp['subList'] .= "<li>".caNavLink($this->request, $va_item['name_plural'], '', '', 'Browse', 'Objects', array('facet' => 'term_facet', 'id' => $vn_i))."</li>\n";
					$va_resp['subList'] .= "<li>".caNavLink($this->request, $va_item['name_plural'], '', '', 'MultiSearch', 'Index', array('search' => 'ca_list_items.item_id:'.$vn_i))."</li>\n";
				}
			}
		}
		require_once(__CA_MODELS_DIR__."/ca_list_items.php");
		$t_list_item = new ca_list_items($vn_item_id);
		$va_resp['selectedTitle'] = $t_list_item->get('ca_list_items.preferred_labels.name_plural');
		$va_resp['selectedDescription'] = $t_list_item->get('ca_list_items.preferred_labels.description') . "<br/><br>" . caNavLink($this->request, _t('View'), '', '', 'MultiSearch', 'Index', array('search' => 'ca_list_items.item_id:'.$vn_item_id));
		
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
