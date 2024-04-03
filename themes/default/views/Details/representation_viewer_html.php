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
	
	.mediaviewer-selector-control-active img {
		border: 2px solid #cc0000;
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
		background-color: #aaa;
		display: none;
	}
	
	div.mediaviewer-overlay-controls {
		display: flex;
  		align-items: center;
  		justify-content: space-evenly;
  		
		width: 100%;
		height: 40px;
		color: #fff;
		background-color: #000;
		
		padding: 7px 10px; 7px 10px;
	}
	
	div.mediaviewer-overlay-content {
		display: block;
		width: 100%;
		height: 100%;
	}
	
	div.mediaviewer-overlay-close {
		position: fixed;
		
		color: #fff;
		
		right: 10px;
		top: 5px;
		z-index: 150000;
		font-size: 20px;
	}
	
	div.mediaviewer-overlay-navigation {
		position: fixed;
		
		color: #fff;
		
		left: 10px;
		top: 5px;
		z-index: 150000;
		font-size: 20px;
	}
	
	#mediaviewer-container {
		width: 100%;
		height: 400px;
	}
	
	div.mediaviewer-selector {
		width: 100%; 
		height: 72px; 
		margin-top: 10px;
	}
	
	div.mediaviewer-caption {
		color: #fff;
		font-size: 16px;
	}
</style>

<!-- START: Primary media display <div>'s -->
<div id="mediaviewer-container">
<?php 
	foreach($media_viewers as $display_class => $media_viewer) {
?>
		<div id="mediaviewer_<?= $display_class; ?>" style="display: none; width: 100%; height: 100%;"><?= $media_viewer; ?></div>
<?php
	}
?>
</div>
<!-- END: Primary media display <div>'s -->

<!-- START: Media viewer controls -->
<a href="#" id="mediaviewer-previous" class="mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderPrevious();'><i class="bi bi-arrow-left"></i></a>
<a href="#" id="mediaviewer-next" class="mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderNext();'><i class="bi bi-arrow-right"></i></a>
<a href="#" id="mediaviewer-show-overlay" class="mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].showOverlay();'><i class="bi bi-window-fullscreen"></i></i></a>
<a href="#" id="mediaviewer-download" class="mediaviewer-control"><i class="bi bi-download"></i></i></a>
<span id="mediaviewer-caption"></span>
<!-- END: Media viewer controls -->

<!-- START: Media selector bar -->
<?php
	if(sizeof($media_list) > 1) {
		$media_icons = [];
		foreach($media_list as $i => $m) {
			$media_icons[] = "<a class='mediaviewer-selector-control' hx-on:click='window.mediaViewerManagers[\"mediaviewer\"].render({$i});'>".caHTMLImage($m['icon'], ['width' => '72', 'height' => '72', 'class' => 'mediaIcon']).'</a>';
		}
?>
<div id="mediaviewer-selector" class='mediaviewer-selector'><?= join(" ", $media_icons); ?></div>
<?php
	}
?>
<!-- END: Media selector bar -->

<!-- START: Full-window media overlay display <div>'s -->
<div id="mediaviewer-overlay" class="mediaviewer-overlay">
	<div class="mediaviewer-overlay-controls">
		<div class="mediaviewer-overlay-navigation">
			<a href="#" id="mediaviewer-overlay-previous" class="mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderPrevious(true);'><i class="bi bi-arrow-left"></i></a>
			<a href="#" id="mediaviewer-overlay-next" class="mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderNext(true);'><i class="bi bi-arrow-right"></i></a>
		</div>
		<div id="mediaviewer-overlay-caption" class="mediaviewer-caption"></div>
		<div class="mediaviewer-overlay-close">
			<a href="#" hx-on:click='window.mediaViewerManagers["mediaviewer"].hideOverlay();'><i class="bi bi-x-lg"></i></a>
		</div>
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
<!-- END: Full-window media overlay display <div>'s -->

<!-- START: Initialize viewer on completion of page load -->
<script>
	document.onreadystatechange = function() {
		if (document.readyState === "complete") {
			window.mediaViewerManagers['mediaviewer'].setup();
		}
	};
</script>
<!-- END: Initialize viewer on completion of page load -->
