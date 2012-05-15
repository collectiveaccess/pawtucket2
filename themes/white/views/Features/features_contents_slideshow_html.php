<?php
	$t_set = $this->getVar('t_set');
	$va_items = caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersion' => 'medium', 'returnItemAttributes' => array('set_item_description'))));
?>
	<div class="settitle"><?php print $t_set->getLabelForDisplay(); ?></div>
	<div id="featuresDescription"><?php print $t_set->getSimpleAttributeValue('set_description'); ?></div>


	<table>
		<tr valign="top">
			<td class='featuresSlideshowScrollControl'><a href="#" onclick="featuresSlideshowScroller.scrollToPreviousImage(); return false;" class="featuresSlideshowScrollControlLink"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browse_arrow_large_gr_lt.gif' width='20' height='31' border='0'></a></td>
			<td>
				<div id='featuresSlideshowScrollingViewerCounter'><!-- empty --></div>
				<div id="featuresSlideshow">
					<div id="featuresSlideshowScrollingViewer">
						<div id="featuresSlideshowScrollingViewerContainer">
							<div id="featuresSlideshowScrollingViewerImageContainer"></div>
						</div>
					</div>
					<br/>
					<div id='featuresSlidehowScrollingViewerItemText'><!-- empty --></div>
				</div>
			</td>
			<td class='featuresSlideshowScrollControl'><a href="#" onclick="featuresSlideshowScroller.scrollToNextImage(); return false;" class="featuresSlideshowScrollControlLink"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browse_arrow_large_gr_rt.gif' width='20' height='31' border='0'></a></td>
		</tr>
	</table>

<script type="text/javascript">
<?php
	$va_imgs = array();
	foreach($va_items as $va_item) {
		$vs_caption_text = "";
		$vs_caption_text = addslashes("<b>".preg_replace("![\n\r]+!", "<br/><br/>", $va_item['set_item_label'])."</b><br>".preg_replace("![\n\r]+!", "<br/><br/>", $va_item['ca_attribute_set_item_description']));
		$va_imgs[] = "{url:'".$va_item['representation_url']."', width: ".$va_item['representation_width'].", height: ".
		$va_item['representation_height'].", link: '".caNavUrl($this->request, 'Detail', 'Object', 'Show', array('object_id' => $va_item["object_id"]))."', title:' $vs_caption_text'}";
	}
?>
	var featuresSlideshowScroller = caUI.initImageScroller([<?php print join(",", $va_imgs); ?>], 'featuresSlideshowScrollingViewerImageContainer', {
		containerWidth: 560, containerHeight: 400,
		imageCounterID: 'featuresSlideshowScrollingViewerCounter',
		scrollingImageClass: 'featuresSlideshowScrollerImage',
		scrollingImagePrefixID: 'featuresSlideshow',
		imageTitleID: 'featuresSlidehowScrollingViewerItemText'
	});
</script>