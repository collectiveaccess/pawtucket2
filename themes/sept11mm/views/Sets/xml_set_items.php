<?php
	$vn_set_id = $this->getVar('set_id');
	$t_set = $this->getVar('t_set');
	$va_items = $this->getVar('items');
	
	print '<?xml version="1.0" encoding="UTF-8"?>';
?>
<imageSet>
	<setInfo set_id="<?php print $vn_set_id; ?>">
		<name><![CDATA[<?php print $t_set->getLabelForDisplay(); ?>]]></name>
		<description><![CDATA[<?php print $t_set->getAttributesForDisplay("description"); ?>]]></description>
	</setInfo>
	<setImages>
<?php
	if(sizeof($va_items)){
		foreach($va_items as $vn_item_id => $va_item) {
			$vs_large_image = caEscapeForXML($va_item['representation_url']);
			$vs_thumbnail_image = '';
			$vs_maker = '';
			$vs_credit = '';
			$vs_title = caEscapeForXML($va_item['label']['name']);
?>
			<image large="<?php print $vs_large_image; ?>" thumbnail="<?php print $vs_thumbnail_image; ?>" title="<?php print $vs_title; ?>" maker="<?php print $vs_maker; ?>" credit="<?php print $vs_credit; ?>"/>
<?php
		}
	}
?>
	</setImages>
</imageSet>