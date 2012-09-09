<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Sets/xml_set_items.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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