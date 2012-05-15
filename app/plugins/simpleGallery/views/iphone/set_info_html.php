<?php
/* ----------------------------------------------------------------------
 * app/plugins/simpleGallery/set_info_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
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
 
$t_set = $this->getVar('t_set');
$va_items = $this->getVar('items');
?>
<div id="gallerySetDetail">
<?php
# --- selected set info - descriptiona dn grid of items with links to open panel with more info
?>
	<div id="back"><?php print caNavLink($this->request, _t("Back &rsaquo;"), "", "simpleGallery", "Show", "Index"); ?></div>
	<H1><?php print $t_set->getLabelForDisplay(); ?></H1>
<?php
	if($vs_set_description = $this->getVar('set_description')) {
?>
		<div class="textContent" id="setText"><?php print $vs_set_description; ?></div>
		
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#setText').expander({
					slicePoint: 250,
					expandText: '<?php print _t('more &rsaquo;'); ?>',
					userCollapse: false
				});
			});
		</script>
<?php
	}
	$va_first_set_item = array_shift($va_items);
?>
	<div id='setItem'></div><!-- end setItem -->
<script type="text/javascript">
	jQuery(document).ready(function() { 
		jQuery("#setItem").load("<?php print caNavUrl($this->request, 'simpleGallery', 'Show', 'setItemInfo', array('set_item_id' => $va_first_set_item['item_id'], 'set_id' => $t_set->get("set_id"))); ?>");
	});
</script>