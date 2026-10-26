<?php
/* ----------------------------------------------------------------------
 * app/plugins/NovaMuse/themes/newvamuse/views/place_map_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2023 Whirl-i-Gig
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
 
$names		= $this->getVar('names');
?>
<div class="container textContent">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h1><?php print _t("Nova Scotia Place Names"); ?></H1>
			<p style='padding-bottom:15px;'>
				<?php print _t("Nova Scotia's colonial history means that community place names have changed over time. Click on a pin to learn more about each location."); ?> 
			</p>
			<div style="clear:both; margin-top:10px;">
				<?php print $this->getVar("map"); ?>
<?php
	foreach($this->getVar('layers') as $hier_id => $hier) {
?>				
			<span style="margin-right: 10px;"><input type="checkbox" name="hier_<?= $hier_id; ?>" checked='1'  id="hier_<?= $hier_id; ?>" value="<?= $hier_id; ?>" class="layerToggle"/> <?= $hier; ?></span>
<?php
	}
?>
			</div>
		</div>	
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.layerToggle').on('click', function(e) {
				let hier_id = e.target.value;
				if(e.target.checked) {
					map.addLayer(itemGroupsmap[hier_id]);
				} else {
					map.removeLayer(itemGroupsmap[hier_id]);
				}
			})
		});
	</script>
</div>