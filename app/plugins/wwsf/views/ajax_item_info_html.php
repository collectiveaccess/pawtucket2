<?php
$va_item = $this->getVar("item_info");
$vn_set_id = $this->getVar("set_id");
$vn_text_height = 100 + (450 - $va_item["image_height"]);
?>
	<div id="featuresOverlayNextPrevious">
<?php
	if($va_item['previous_id']){
		print "<a href='#' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, 'Features', '', 'setItemInfo', array('set_item_id' => $va_item['previous_id'], 'set_id' => $vn_set_id))."'); return false;\">"._t("&lsaquo; Previous")."</a>";
	}else{
		print _t("&lsaquo; Previous");
	}
	print "&nbsp;&nbsp;|&nbsp;&nbsp;";
	if($va_item['next_id']){
		print "<a href='#' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, 'Features', '', 'setItemInfo', array('set_item_id' => $va_item['next_id'], 'set_id' => $vn_set_id))."'); return false;\">"._t("Next &rsaquo;")."</a>";
	}else{
		print _t("Next &rsaquo;");
	}
	print "</div>";	
	if($va_item['image']){
		print "<div id='featuresOverlayImage'>".caNavLink($this->request, $va_item['image'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))."</div>";
	}
	if($va_item['object_label']){
		print "<div id='featuresOverlayImageCaption'>".caNavLink($this->request, $va_item['object_label'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))."</div>";
	}
	if($va_item['label'] || $va_item['description']){
?> 	
		<div class="featuresOverlayContent" style='height:<?php print $vn_text_height; ?>px;'>
<?php
			if($va_item['label']){
				print "<div><b>".$va_item['label']."</b></div>";
			}
			if($va_item['description']){
				print "<div>";
				print $va_item['description'];
				print "<br/><br/>".caNavLink($this->request, _t('See this object in the archive'), '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))." &rsaquo";
				print "</div>";				
			}
?>
		</div>
<?php
	}
?>