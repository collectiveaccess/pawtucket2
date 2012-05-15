<?php
	$t_set = $this->getVar('t_set');
	$va_items = caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersions' => array('thumbnail', 'medium'), 'returnItemAttributes' => array('set_item_description'))));
?>
	<div class="settitle"><?php print $t_set->getLabelForDisplay(); ?></div>
	<div class="textContent"><?php print preg_replace("![\n\r]+!", "<br/><br/>", $t_set->getSimpleAttributeValue('set_description')); ?></div>

	<div id="featurethumbs"><table border="0" cellpadding="0px" cellspacing="0px" width="100%">
		<tr>
<?php
	$vn_display_cols = 4;
	$vn_col = 0;
	$vn_item_count = 0;
	$va_overlays = array();
		
	foreach($va_items as $va_item) {
		$vn_padding_left_right = (120 - $va_item['representation_width_thumbnail'])/2;
		$vn_padding_top_bottom = (110 - $va_item['representation_height_thumbnail'])/2;
?>
		<td align='center' valign='top' class='searchResultTd setItem<?php print $va_item['item_id']; ?>'>
			<div class='searchThumbBg searchThumbnail<?php print $vn_item_count; ?>' style='padding: <?php print $vn_padding_top_bottom; ?>px <?php print $vn_padding_left_right; ?>px <?php print $vn_padding_top_bottom; ?>px <?php print $vn_padding_left_right; ?>px;'><a href="#" rel='#searchThumbnail<?php print $vn_item_count; ?>'><?php print $va_item['representation_tag_thumbnail']; ?></a></div>
			<div class='searchThumbCaption searchThumbnail<?php print $vn_item_count; ?>'>
				<a href="#" rel='#searchThumbnail<?php print $vn_item_count; ?>'><?php print (strlen($va_item['set_item_label']) > 26) ? substr($va_item['set_item_label'], 0, 23)."..." : $va_item['set_item_label']; ?></a>
			</div>
		</td>
<?php
	if($va_item['set_item_label']){
		// set view vars for tooltip
		$this->setVar('tooltip_text', preg_replace('![\n\r]+!', '<br/><br/>', addslashes($va_item['set_item_label'])));
		TooltipManager::add(
			".setItem{$va_item['item_id']}", $this->render('Features/features_tooltip_html.php')
		);
	}
	
	$vs_left_arrow_nav = ($vn_item_count == 0) ? '' : '<a href="#" onclick="closeAllOverlays();" rel="#searchThumbnail'.($vn_item_count-1).'"><img src="'.$this->request->getThemeUrlPath().'/graphics/browse_arrow_large_gr_lt.gif" width="20" height="31" border="0" alt="Previous"></a>';
	$vs_right_arrow_nav = ($vn_item_count >= (sizeof($va_items) - 1)) ? '' : '<a href="#" onclick="closeAllOverlays();" rel="#searchThumbnail'.($vn_item_count+1).'"><img src="'.$this->request->getThemeUrlPath().'/graphics/browse_arrow_large_gr_rt.gif" width="20" height="31" border="0" alt="Next"></a>';
	$va_overlays[] = '<div class="featuresOverlay" id="searchThumbnail'.$vn_item_count.'"> 
 
    <table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" style="padding: 150px 20px 0px 0px;">'.$vs_left_arrow_nav.'</td><td valign="top">
    <!-- large image --> 
 	<div id="featuresOverlayImage">'.$va_item['representation_tag_medium'].'</div>
 	
    <!-- image details --> 
    <div class="featuresOverlayContent" style="width:'.$va_item['representation_width_large'].'px;">
        <div><b>'.$va_item['set_item_label'].'</b></div>
 		<div>'.$va_item['ca_attribute_set_item_description'].'</div> 
        <div>'.caNavLink($this->request, _t('See this object in the archive'), '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id'])).'</div>
    </div>
    </td><td valign="top" style="padding:150px 0px 0px 20px;">'.$vs_right_arrow_nav.'</td></tr></table>
 
</div> ';
		
		
		$vn_col++;
		if($vn_col < $vn_display_cols){
			print "<td align='center'>&nbsp;</td>\n";
		}
		if($vn_col == $vn_display_cols){
			print "</tr>\n";
			$vn_col = 0;
		}
		
		$vn_item_count++;
	}
	if($vn_col > 0){
		while($vn_col < $vn_display_cols){
			print "<td class='searchResultTd'><!-- empty --></td>\n";
			$vn_col++;
			if($vn_col < $vn_display_cols){
				print "<td><!-- empty --></td>\n";
			}
		}
		print "</tr>\n";
	}
	
	print "\n</table></div>\n";
	
	if (sizeof($va_overlays)) {
		print join("\n", $va_overlays);
?>
		<script type='text/javascript'>
			jQuery("a[rel]").overlay();
		</script>
<?php
	}
?>