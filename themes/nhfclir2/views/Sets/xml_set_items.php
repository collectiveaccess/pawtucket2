<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Sets/xml_set_items.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
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