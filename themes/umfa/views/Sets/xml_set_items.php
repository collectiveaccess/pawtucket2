<?php
	$vn_set_id = $this->getVar('set_id');
	$t_set = $this->getVar('t_set');
	$va_items = $this->getVar('items');
	
	print '<?xml version="1.0" encoding="UTF-8"?>';
?>
<imageSet>
	<setInfo set_id="<?php print $vn_set_id; ?>" detailUrl="<?php print caNavUrl($this->request, 'Detail', 'Object', 'Index', array('object_id' => '')); ?>">
		<name><![CDATA[<?php print $t_set->getLabelForDisplay(); ?>]]></name>
		<description><![CDATA[<?php print $t_set->get("ca_sets.description"); ?>]]></description>
	</setInfo>
	<setImages>
<?php
	if(sizeof($va_items)){
		if (!($va_display_flds = $this->request->config->getList('ca_objects_set_slideshow_display_attributes'))) {
			$va_display_flds = array('ca_objects.preferred_labels.name');
		}
		foreach($va_items as $vn_item_id => $va_item) {
			$t_object = new ca_objects($va_item['row_id']);
			$va_display_values = array();
			foreach($va_display_flds as $vs_display_fld) {
				if ($vs_val = trim($t_object->get($vs_display_fld))) { $va_display_values[] = $vs_val; }
			}
		
			$vs_large_image = caEscapeForXML($va_item['representation_url']);
			$vs_title = caEscapeForXML(join("\n", $va_display_values));
?>
			<image large="<?php print $vs_large_image; ?>" title="<?php print $vs_title; ?>" item_id="<?php print $va_item['object_id'];?>"/>
<?php
		}
	}
?>
	</setImages>
</imageSet>