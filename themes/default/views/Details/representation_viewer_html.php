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
$media_viewer_overlays = $this->getVar('media_viewer_overlays');
?>
<style>
	.mediaviewer-control {
		opacity: 1.0;	
	}
	.mediaviewer-control-disabled {
		opacity: 0.5;
	}
	
	.mediaviewer-selector-control {
		padding-right: 5px;
	}
	
	div.mediaviewer-overlay {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		background: #fff;
		opacity: 1.0;
		z-index: 50000;
	}
	
	div.mediaviewer-overlay-display {
		width: 100%;
		height: 100%;
		background-color: #fff;
		display: none;
	}
	
	div.mediaviewer-overlay-content {
		display: block;
		width: 100%;
		height: 100%;
	}
	
	div.mediaviewer-overlay-close {
		position: fixed;
		
		right: 10px;
		top: 10px;
		background-color: rgba(255, 255, 255, 0.1);
		z-index: 150000;
		font-size: 24px;
	}
	
	#mediaviewer-container {
		width: 100%;
		height: 400px;
	}
</style>
<a href="#" id="mediaviewer-previous" class="mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderPrevious();'><i class="bi bi-arrow-left"></i></a>
<a href="#" id="mediaviewer-next" class="mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderNext();'><i class="bi bi-arrow-right"></i></a>
<a href="#" id="mediaviewer-show-overlay" class="mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].showOverlay();'><i class="bi bi-window-fullscreen"></i></i></a>
<div id="mediaviewer-container">
<?php 
	foreach($media_viewers as $display_class => $media_viewer) {
?>
		<div id="mediaviewer_<?= $display_class; ?>" style="display: none; width: 100%; height: 100%;"><?= $media_viewer; ?></div>
<?php
	}
?>
</div>
<?php
	$media_icons = [];
	foreach($media_list as $i => $m) {
		$media_icons[] = "<a href='#' class='mediaviewer-selector-control' hx-on:click='window.mediaViewerManagers[\"mediaviewer\"].render({$i});'>".caHTMLImage($m['icon'], ['width' => '72', 'height' => '72', 'class' => 'mediaIcon']).'</a>';
	}
?>
<div id="mediaviewer-selector" class='mediaviewer-selector' style="width: 500px; height: 72px; margin-top: 10px;"><?= join(" ", $media_icons); ?></div>

<script>
	document.onreadystatechange = function() {
		if (document.readyState === "complete") {
			window.mediaViewerManagers['mediaviewer'].render(0);
		}
	};
</script>

<div id="mediaviewer-overlay" class="mediaviewer-overlay">
	<div class="mediaviewer-overlay-close">
		<a href="#" hx-on:click='window.mediaViewerManagers["mediaviewer"].hideOverlay();'><i class="bi bi-x-lg"></i></a>
	</div>
	<div id="mediaviewer-overlay-content" class="mediaviewer-overlay-content">
<?php 
	foreach($media_viewer_overlays as $display_class => $media_viewer_overlay) {
?>
		<div id="mediaviewer-overlay-<?= $display_class; ?>" class="mediaviewer-overlay-display"><?= $media_viewer_overlay; ?></div>
<?php
	}
?>		
	</div>
</div>

