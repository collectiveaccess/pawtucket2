<?php
/** ---------------------------------------------------------------------
 * themes/default/views/Compare/view_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016 Whirl-i-Gig
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
 * @subpackage Media
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 $ps_table = $this->getVar('table');
 $va_ids = $this->getVar('ids');
 
 if(sizeof($va_ids) > 0) {
	 // Calculate window geometry; for up to 3 windows place side-by-side,
	 // otherwise to to make something square-ish
	 $vn_num_windows = sizeof($va_ids);
	 if ($vn_num_windows <= 3) {
		$vs_layout = "1x{$vn_num_windows}";
	 } else {
		$vn_dim_width = ceil(sqrt($vn_num_windows));
		$vn_dim_height = ceil($vn_num_windows/$vn_dim_width);
		$vs_layout = "{$vn_dim_width}x{$vn_dim_height}";
	 }
 
	 $va_data = [];
	 $va_windows = [];
 
	 foreach($va_ids as $vn_id) {
		$va_data[] = [
			'manifestUri' =>  $vs_url = caNavUrl($this->request, '', 'Compare', 'Manifest', ['table' => $ps_table, 'id' => $vn_id])
		];
		$va_windows[] = [
			'loadedManifest' => $vs_url,
			'overlay' => false,
			'viewType' => "ImageView",
			'displayLayout' => false,
			'bottomPanel' => false,
			'bottomPanelAvailable' => false,
			'bottomPanelVisible' => false,
			'sidePanel' => false,
			'annotationLayer' => false,
			'annotationCreation' => false
		];
	 }
?>
<div style="width: 100%; height: 400px" id="comparison_viewer">

</div>

<script type="text/javascript">
	var _compareViewer = Mirador({  
		id: "comparison_viewer",
		layout: "<?php print $vs_layout; ?>",
		data: <?php print json_encode($va_data); ?>,  
		windowObjects: <?php print json_encode($va_windows); ?>,
		buildPath: '<?php print __CA_URL_ROOT__."/assets/mirador/"; ?>'
	});
	$("#comparison_viewer").height($(window).height() - $("nav").height() + "px");
</script>
<?php
	} else {
?>
	<h2>No images are selected</h2>
<?php
	}