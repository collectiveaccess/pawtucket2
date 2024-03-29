<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/representation_viewer_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
$media_list = $this->getVar('media_list');
$media_viewers = $this->getVar('media_viewers');
?>
<div id="mediaViewer">
<?php 
	foreach($media_viewers as $display_class => $media_viewer) {
?>
	<div id="mediaviewer_<?= $display_class; ?>" style="display: none;"><?= $media_viewer; ?></div>
<?php
	}
?>
</div>
<?php
	$media_icons = [];
	foreach($media_list as $i => $m) {
		$media_icons[] = "<a href='#' onclick='window.mediaViewerManager.render(\"mediaviewer\", {$i});'>".caHTMLImage($m['icon'], ['width' => '72', 'height' => '72', 'class' => 'mediaIcon']).'</a>';
	}
?>
<div class='mediaSelector' style="width: 500px; height: 72px;"><?= join(" ", $media_icons); ?></div>

<script>
	document.onreadystatechange = function() {
		  if (document.readyState === "complete") {
			window.mediaViewerManager.render('mediaviewer', 0);
		  }
		};
</script>
