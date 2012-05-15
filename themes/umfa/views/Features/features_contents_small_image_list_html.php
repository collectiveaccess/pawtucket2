<?php
	$t_set 			= $this->getVar('t_set');
	$va_items 		= caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersions' => array('thumbnail', 'medium'), 'returnItemAttributes' => array('set_item_description'))));

?>
	<h1><?php print $t_set->getLabelForDisplay(); ?></h1>
	<div class="textContent"><?php print preg_replace("![\n\r]+!", "<br/><br/>", $t_set->getSimpleAttributeValue('set_description')); ?></div>

	<table border="0" cellpadding="0px" cellspacing="0px" width="100%">
<?php
	$vn_display_cols = 5;
	$vn_col = 0;
	$vn_item_count = 0;
	$va_overlays = array();
	$t_object = new ca_objects();
	
	foreach($va_items as $va_item) {
		$t_object->load($va_item["row_id"]);
		$va_artwork_info = array();
		if($t_object->get('ca_entities.preferred_labels.displayname')){
			$va_artwork_info[] = $t_object->get('ca_entities.preferred_labels.displayname', array('delimiter' => ', '));
		}
		if($va_item["name"]){
			$va_artwork_info[] = "<i>".$va_item["name"]."</i>";
		}
		if($t_object->get("ca_objects.object_type")){
			$va_artwork_info[] = $t_object->get("ca_objects.object_type");
		}
		if($va_item["idno"]){
			$va_artwork_info[] = $va_item["idno"];
		}
		$vs_artwork_info = "";
		if(sizeof($va_artwork_info) > 0){
			$vs_artwork_info = join(", ", $va_artwork_info)."<br/><br/>";
		}
		$vn_padding_top_bottom = ((120 - $va_item['representation_height_thumbnail'])/2) + 2;
		if($vn_col == 0){
			print "<tr>";
		}
		$vs_caption = "";
		if($vs_artwork_info){
			$vs_caption = $vs_artwork_info;
		}
		if($vs_artwork_info && $va_item['set_item_label']){
			$vs_caption = "<br/><br/>";
		}
		if($va_item['set_item_label']){
			$vs_caption .= $va_item['set_item_label'];
		}
?>
		<td align='center' valign='top' class='favResultTd setItem<?php print $va_item['item_id']; ?>'>
			<div class='searchThumbBg searchThumbnail<?php print $vn_item_count; ?>' style='padding: <?php print $vn_padding_top_bottom; ?>px 0px <?php print $vn_padding_top_bottom; ?>px 0px;'><a href="#" onclick="caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', 'Features', 'setItemInfo', array('set_item_id' => $va_item['item_id'], 'set_id' => $va_item["set_id"])); ?>'); return false;"><?php print $va_item['representation_tag_thumbnail']; ?></a></div>
			<div class='searchThumbCaption searchThumbnail<?php print $vn_item_count; ?>'>
				<a href="#" onclick="caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', 'Features', 'setItemInfo', array('set_item_id' => $va_item['item_id'], 'set_id' => $va_item["set_id"])); ?>'); return false;"><?php print (strlen($va_item["name"]) > 26) ? substr($va_item["name"], 0, 23)."..." : $va_item["name"]; ?></a>
			</div>
		</td>
<?php
		if($vs_caption){
			// set view vars for tooltip
			$this->setVar('tooltip_text', preg_replace('![\n\r]+!', '<br/><br/>', addslashes($vs_caption)));
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
				print "<td>&nbsp;</td>\n";
			}
		}
		print "</tr>\n";
	}
	
	print "\n</table>\n";
	
	if (sizeof($va_overlays)) {
		print join("\n", $va_overlays);
?>
		<script type='text/javascript'>
			jQuery("a[rel]").overlay({
				onBeforeLoad: function() {
					this.getOverlay().appendTo('body');	// hack to deal with UMFA's position:relative site container
				}
			});
		</script>
<?php
	}
?>