<?php
	$t_rep 						= $this->getVar('t_object_representation');
	$vs_display_version 		= $this->getVar('rep_display_version');
	$va_display_options	 		= $this->getVar('rep_display_options');
	
	$va_item 					= $this->getVar("item_info");
	$vn_set_id 					= $this->getVar("set_id");
	# --- this layout is based on use of a mediumlarge image
	# --- get the height of the media being displayed - either the viewer height or the image height
	if($vs_display_version == 'mediumlarge'){
		$va_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
		$vn_media_height = $va_media_info["HEIGHT"];
	}else{
		$vn_media_height = $va_display_options['viewer_height'];
	}
	if($vn_media_height <= 450){
		$vn_text_height	= 100 + (450 - $vn_media_height);
	}
	$vs_media_tag 				= $t_rep->getMediaTag('media', $vs_display_version, $va_display_options);
?>
	<div id="featuresOverlayNextPrevious">
<?php
	if($va_item['previous_id']){
		print "<a href='#' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, '', 'Features', 'setItemInfo', array('set_item_id' => $va_item['previous_id'], 'set_id' => $vn_set_id))."'); return false;\">"._t("&lsaquo; Previous")."</a>";
	}else{
		print _t("&lsaquo; Previous");
	}
	print "&nbsp;&nbsp;|&nbsp;&nbsp;";
	if($va_item['next_id']){
		print "<a href='#' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, '', 'Features', 'setItemInfo', array('set_item_id' => $va_item['next_id'], 'set_id' => $vn_set_id))."'); return false;\">"._t("Next &rsaquo;")."</a>";
	}else{
		print _t("Next &rsaquo;");
	}
	print "</div>";	
	if($vs_media_tag){
		if ($va_display_options['no_overlay']) {
			print "<div id='featuresOverlayImage'>".$vs_media_tag."</div>";
		} else {
			print "<div id='featuresOverlayImage'>".caNavLink($this->request, $vs_media_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))."</div>";
		}
	}
	if($va_item['object_label']){
		print "<div id='featuresOverlayImageCaption'>".caNavLink($this->request, $va_item['object_label'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))."</div>";
	}
	if($va_item['label'] || $va_item['description']){
?> 	
		<div class="featuresOverlayContent" <?php print ($vn_text_height) ? "style='height:".$vn_text_height."px;'" : ""; ?>>
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