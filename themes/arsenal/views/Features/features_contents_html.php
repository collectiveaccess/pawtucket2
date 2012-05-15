<?php
	$t_set = $this->getVar('t_set');
	$va_set_presentation_types = $this->getVar('set_presentation_types');
	
	$vn_presentation_type = $t_set->getSimpleAttributeValue('set_presentation_type',0);
	
	$vs_presentation_type = '';
	if (isset($va_set_presentation_types[$vn_presentation_type])) {
		$vs_presentation_type = $va_set_presentation_types[$vn_presentation_type]['item_value'];
	}
	
	switch($vs_presentation_type) {
		case 'small_image_list':
			print $this->render('Features/features_contents_small_image_list_html.php');
			break;
		default:		// slideshow
			print $this->render('Features/features_contents_slideshow_html.php');
			break;
	}
?>