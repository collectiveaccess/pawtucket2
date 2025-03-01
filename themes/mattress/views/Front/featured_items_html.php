<?php
/** ---------------------------------------------------------------------
 * themes/mf/Front/featured_items.php : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
$qr_res = $this->getVar('featured_set_items_as_search_result');

$t_featured = new ca_sets();
$t_featured->load(array('set_code' => 'featuredSet'));

$va_set_items = $t_featured->getItems();

?>

<div id="featuredSlideshow">

	<div class='blockTitle'>Featured Items</div>
	<div class='blockFeatured scrollBlock' >
		<div class='scrollingDiv'><div class='scrollingDivContent'>
<?php
		
		foreach ($va_set_items as $va_set_id => $va_set_item_a) {
			foreach ($va_set_item_a as $va_set_item_id => $va_set_item) {
			$va_object_id = $va_set_item['row_id'];

			$t_object = new ca_objects($va_object_id);
			
			$va_image_width = $t_object->get('ca_object_representations.media.mediumlarge.width');

			print "<div class='featuredObject' style='width:{$va_image_width}px;'>";
			print "<div class='featuredObjectImg'>";
			print caNavLink($this->request, $t_object->get('ca_object_representations.media.mediumlarge'), '', '', 'Detail', 'objects/'.$va_object_id);
			print "</div>";
		
			print "<div class='artwork'>";
			print $va_set_item['caption'];
			print "</div>";
		
			print "</div>";
			}
		}
?>
		</div><!-- scrollingDivContent --></div><!-- scrollingdiv -->
	</div><!-- block Featured -->
	
	<div class='clearfix'></div>
</div>