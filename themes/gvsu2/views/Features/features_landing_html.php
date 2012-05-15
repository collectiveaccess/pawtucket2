<?php
	$va_set_list = $this->getVar('sets');
	$va_first_items_from_sets = $this->getVar('first_items_from_sets');
?>
<h1><?php print _t("Features"); ?></H1>
<div id="featuresLanding">
	<div class="textContent">
<?php
	print $this->render('Features/features_intro_text_html.php');
?>
	</div>
<?php
	foreach($va_set_list as $vn_set_id => $va_set_info){
		print "<div class='setInfo'>";
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
		print "<div class='setImage'>".caNavLink($this->request, $va_item["representation_tag"], '', 'Features', 'displaySet', '', array('set_id' => $vn_set_id))."</div><!-- end setImage -->";
		print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 60 ? substr($va_set_info["name"], 0, 60)."..." : $va_set_info["name"]), '', 'Features', 'displaySet', '', array('set_id' => $vn_set_id))."</div>";
		if($va_set_info["description"]){
			print "<div class='setText'>".$va_set_info["description"]."</div>";
		}
		print "<div class='setMoreLink'>".caNavLink($this->request, _t('More'), '', 'Features', 'displaySet', '', array('set_id' => $vn_set_id))." &rsaquo;</div>";
		print "<div style='clear:left; height:1px;'><!-- empty --></div><!-- end clear --></div><!-- end setInfo -->";
	}
?>
</div>
