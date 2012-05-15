<?php
$t_set = $this->getVar('t_set');
$va_items = $this->getVar('items');

$va_set_list = $this->getVar('sets');
$va_first_items_from_sets = $this->getVar('first_items_from_sets');
?>
<div id="featuresSetDetail">
<?php
# --- make column on right with all sets
	if(sizeof($va_set_list) > 1){
?>
	<div id="allSets"><H3><?php print _t("More Features"); ?></H3>
<?php
	foreach($va_set_list as $vn_set_id => $va_set_info){
		if($vn_set_id == $t_set->get("set_id")){ continue; }
		print "<div class='setInfo'>";
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
		print "<div class='setImage'>".caNavLink($this->request, $va_item["representation_tag"], '', 'Features', 'displaySet', '', array('set_id' => $vn_set_id))."</div><!-- end setImage -->";
		print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 120 ? substr($va_set_info["name"], 0, 120)."..." : $va_set_info["name"]), '', 'Features', 'displaySet', '', array('set_id' => $vn_set_id))."</div>";
		print "<div style='clear:left; height:1px;'><!-- empty --></div><!-- end clear --></div><!-- end setInfo -->";
	}
?>
	</div><!-- end allSets -->
<?php
	}
# --- selected set info - descriptiona dn grid of items with links to open panel with more info
?>
	<H1><?php print $t_set->getLabelForDisplay(); ?></H1>
<?php
	print "<div id='setItemsGrid'>";
	if($t_set->get('description')){
?>
		<div class="textContent"><?php print $t_set->get('description', array('convertLinkBreaks' => true)); ?></div>
<?php
	}
	foreach($va_items as $va_item) {
?>
		<div class="setItem" id="item<?php print $va_item['item_id']; ?>">
			<a href="#" onclick="caMediaPanel.showPanel('<?php print caNavUrl($this->request, 'Features', '', 'setItemInfo', array('set_item_id' => $va_item['item_id'], 'set_id' => $t_set->get("set_id"))); ?>'); return false;"><?php print $va_item['representation_tag_widepreview']; ?></a>
		</div>
<?php
		if($va_item['caption'] || $va_item['representation_tag_medium']){
			// set view vars for tooltip
			$this->setVar('tooltip_image_name', $va_item['name']);
			$this->setVar('tooltip_text', preg_replace('![\n\r]+!', '<br/><br/>', addslashes($va_item['caption'])));
			$this->setVar('tooltip_image', $va_item['representation_tag_medium']);
			TooltipManager::add(
				"#item{$va_item['item_id']}", $this->render('Features/features_tooltip_html.php')
			);
		}
	}
	print "</div><!-- end setItemsGrid -->";
?>