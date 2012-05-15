<?php
	$va_city_sets = $this->getVar('city_sets');
	$va_first_items_from_city_sets = $this->getVar('first_items_from_city_sets');
	$va_village_sets = $this->getVar('village_sets');
	$va_first_items_from_village_sets = $this->getVar('first_items_from_village_sets');

if (!$this->request->isAjax()) {
?>
<h1><?php print _t("Places"); ?></H1>

<div id="featuresLanding">
	<div id="placesText">
<?php
		print $this->render('places_text_nav_html.php');
?>
	</div>
<?php
}	

?>
<div id="featuresBox">
<?php
	$t_set_item = new ca_objects();
	print "<div class='placesHeading'>"._t("Media coverage of the events in 1989/1990 was limited to a few larger cities. Many images from theses places can also be found in the internet archive...")."</div>";
	
	if (is_array($va_city_sets)) {
		foreach($va_city_sets as $vn_set_id => $va_set_info){
			$va_item = $va_first_items_from_city_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_city_sets[$vn_set_id]))];
			print "<div class='setInfo'>";
			print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 32 ? substr($va_set_info["name"], 0, 29)."..." : $va_set_info["name"]), '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item["object_id"]))."</div>";
	?>
			<table cellpadding="0" cellspacing="0" class="bg"><tr><td valign="middle" align="center" class="imageContainer" id="imageContainerForSet_<?php print $vn_set_id; ?>">
	<?php
			print $va_set_info['map'];
	?>
			</td></tr></table>
	
	<?php
			print "<div class='setCount'>"._t("%1 images", $va_set_info["item_count"])."</div>";
			print "<div class='setViewLink'>".caNavLink($this->request, _t("view")." &rsaquo;", '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item["object_id"]))."</div>";
			print "</div><!-- end setInfo -->";
		}
	}
	
	print "<div class='placesHeading' style='clear:left;'>"._t("...but the general public also documented the changes in numerous smaller cities and villages that (till now) are hardly known...")."</div>";
	
	if (is_array($va_village_sets)) {
		foreach($va_village_sets as $vn_set_id => $va_set_info){
			$va_item = $va_first_items_from_village_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_village_sets[$vn_set_id]))];
			print "<div class='setInfo'>";
			print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 32 ? substr($va_set_info["name"], 0, 29)."..." : $va_set_info["name"]), '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item["object_id"]))."</div>";
	?>
			<table cellpadding="0" cellspacing="0" class="bg"><tr><td valign="middle" align="center" class="imageContainer" id="imageContainerForSet_<?php print $vn_set_id; ?>">
	<?php
			$t_set_item->load($va_item["object_id"]);
			print $va_set_info['map'];
	?>
			</td></tr></table>
	
	<?php
			print "<div class='setCount'>"._t("%1 images", $va_set_info["item_count"])."</div>";
			print "<div class='setViewLink'>".caNavLink($this->request, _t("view &rsaquo;"), '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item["object_id"]))."</div>";
			print "</div><!-- end setInfo -->";
		}
	}

?>
	</div><!-- end featuresBox -->
<?php
	if (!$this->request->isAjax()) {
?>
</div><!-- end featuresLanding -->
<?php
	}
?>