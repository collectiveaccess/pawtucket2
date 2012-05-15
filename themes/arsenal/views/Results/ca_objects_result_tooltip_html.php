<?php
	$vo_result 			= $this->getVar('result');
	global $g_ui_locale;
?>


<div class="tooltipImage">
	<?php print $this->getVar('tooltip_representation'); ?>
</div>
<div class="tooltipCaption">
<?php
	if($this->getVar('tooltip_title')){
		print "<div><b>TITLE:</b> ";
		print (unicode_strlen($this->getVar('tooltip_title')) > 200) ? substr(strip_tags($this->getVar('tooltip_title')), '0', '200')."..." : $this->getVar('tooltip_title');
		print "</div>";
	}
	if(sizeof($vo_result->get("ca_entities"))>0){
		print "<div><b>".($g_ui_locale=="de_DE" ? "Regie" : "Director")."</b> ";
		$va_entities = $vo_result->get('ca_entities', array('returnAsArray' => true));
		$va_entity_labels = array();
		foreach($va_entities as $va_entity){
			$va_entity_labels[] = $va_entity["displayname"];
		}
		print join(', ', $va_entity_labels);
		print "</div>";
	}
	if($vo_result->get("ca_objects.country")){
		print "<div><b>".($g_ui_locale=="de_DE" ? "Land" : "Country")."</b> ";
		print $vo_result->get("ca_objects.country", array('convertCodesToDisplayText' => true));
		print "</div>";
	}
	if($vo_result->get("ca_objects.production_year")){
		print "<div><b>".($g_ui_locale=="de_DE" ? "Jahr" : "Year")."</b> ";
		print $vo_result->get("ca_objects.production_year");
		print "</div>";
	}
	if($vo_result->get("ca_objects.format")){
		print "<div><b>".($g_ui_locale=="de_DE" ? "Format" : "Format")."</b> ";
		print $vo_result->get("ca_objects.format", array('convertCodesToDisplayText' => true));
		print "</div>";
	}

	if($this->request->config->get("dont_enforce_access_settings")){
		if($vo_result->get("ca_objects.idno")){
			print "<div><b>OA3 ID</b> ";
			print $vo_result->get("ca_objects.idno");
			print "</div>";
		}
	}
?>
</div>