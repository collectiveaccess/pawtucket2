<?php
	$va_sets = $this->getVar('sets');
	$t_item = $this->getVar('t_item');
	$va_first_items_from_sets = $this->getVar('first_items_from_sets');
?>
<div id='resultsNavBg'>
		<div id="resultsNav">
				<div style="float: right"><a href='#' onclick="jQuery('#memoriesList').show(); jQuery('#memoriesSearchList').hide(); return false;"><?php print _t('Close'); ?></a></div>
<?php
				switch($this->getVar('search_type')) {
					case 'tag':
						print "<strong>"._t('Memories for').' <em>'.$t_item->getLabelForDisplay()."</em></strong>";
						break;
					case 'date':
						print "<strong>"._t('Memories from').' <em>'.$this->getVar('date')."</em></strong>";
						break;
					default:
						print "<strong>"._t('Found These Memories')."</em></strong>";
				}
?>
		</div>
	</div>
	<div id="resultsOutline">
	<?php
		foreach($va_sets as $vn_set_id => $va_set_info){
			$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
			if ($va_set_info["numObjects"] == 0) { continue; }
			if (!$vs_name = $va_set_info["name"]) {
				$vs_name = "???";
			}
			$vs_name = ((unicode_strlen($vs_name) > 32) ?unicode_substr($vs_name, 0, 29)."..." : $vs_name);
			
			print "<div class='setInfo'>";
			print "<div class='setTitle'>".caNavLink($this->request, $vs_name, 'title', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item["object_id"]))."</div>";
	?>
			<table cellpadding="0" cellspacing="0" class="bg"><tr><td valign="middle" align="center" class="imageContainer" id="imageContainerForSet_<?php print $vn_set_id; ?>">
	<?php
			if($va_item["type_id"] == 5){
				# --- video so print out icon
				print "<div class='videoIconThemesMemories'><img src='".$this->request->getThemeUrlPath()."/graphics/video.gif' width='26' height='26' border='0'></div>";
			}
			print caNavLink($this->request, $va_item['representation_tag'], '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item["object_id"]), array('class' => 'imageSetImages', 'id' => 'imagesForSet_'.$vn_set_id));
	?>
			</td></tr></table>
	<?php
			print "<div class='setCount'>".$va_set_info["numObjects"]." ".(($va_set_info["numObjects"] == 1) ?  _t("image") : _t("images"))."</div>";
			print "</div><!-- end setInfo -->";
		}
?>
<div style="clear:both;"><!-- empty --></div></div><!-- end resultsOutline -->