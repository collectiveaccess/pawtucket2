<?php
# select random objects to display
if($this->request->config->get("dont_enforce_access_settings")){
	$va_access_values = array();
}else{
	$va_access_values = caGetUserAccessValues($this->request);
}
$t_object = new ca_objects();
$va_random_items = $t_object->getRandomItems(36, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
$va_labels = $t_object->getPreferredDisplayLabelsForIDs(array_keys($va_random_items));
$va_media = $t_object->getPrimaryMediaForIDs(array_keys($va_random_items), array('small', 'thumbnail', 'preview','medium', 'widepreview'), array("checkAccess" => $va_access_values));
if (!$this->request->isAjax()) {
?>
	<div id="hpContentArea">
<?php
	print "<div id='rightMore'><a href='#' onclick='jQuery(\"#grid\").load(\"".caNavUrl($this->request, '', '', '')."\"); return false;'><img src='".$this->request->getThemeUrlPath()."/graphics/fernsehen/rightMore.gif' width='20' height='718' border='0'></a></div><!-- end rightMore -->";
	print "<div id='leftMore'><a href='#' onclick='jQuery(\"#grid\").load(\"".caNavUrl($this->request, '', '', '')."\"); return false;'><img src='".$this->request->getThemeUrlPath()."/graphics/fernsehen/leftMore.gif' width='20' height='718' border='0'></a></div><!-- end leftMore -->";
?>
		<div id="grid">
<?php
}				
	foreach($va_random_items as $vn_object_id => $va_object_info) {
		print "<div class='gridItem'>".caNavLink($this->request, $va_media[$vn_object_id]["tags"]["widepreview"], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
		#print "<div class='gridItem'>".caNavLink($this->request, $va_labels[$vn_object_id], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
	}
if (!$this->request->isAjax()) {
?>
	</div><!-- end grid --></div><!-- end hpContentArea -->
<?php
}
?>