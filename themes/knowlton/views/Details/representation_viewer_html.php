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
	.mediaviewer-selector-control-active img {
		border: 2px solid #000 !important;
	}
	
	div.mediaviewer-overlay {
		z-index: 50000;	
	}
	
	div.mediaviewer-overlay-display {
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
		z-index:1;
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
		/*width: 100%;
		height: 100%;*/
	}
	
	div.mediaviewer-caption {
		color: #fff;
		font-size: 16px;
	}
</style>

<!-- START: Primary media display <div>'s -->
<div id="mediaviewer-container" class="w-100">
<?php 
	foreach($media_viewers as $display_class => $media_viewer) {
?>
		<div id="mediaviewer_<?= $display_class; ?>" style="display: none; width: 100%; height: 100%;"><?= $media_viewer; ?></div>
<?php
	}
?>
</div>
<!-- END: Primary media display <div>'s -->
<!-- START: Media viewer caption -->
<div id="mediaviewer-caption"></div>
<!-- END: Media viewer caption -->
<!-- START: Media viewer controls -->
<div class="row">
	<div class="col-6">
		<button class='btn btn-md btn-white ps-0 ms-0 pe-2 me-1 mediaviewer-control' id="mediaviewer-show-overlay" hx-on:click='window.mediaViewerManagers["mediaviewer"].showOverlay();'><i class="bi bi-zoom-in"></i></button>
		<button class='btn btn-md btn-white ps-0 ms-0 mediaviewer-control' id="mediaviewer-download"><i class="bi bi-download"></i></button>
	</div>
	<div class="col-6 text-end">
		<button class='btn btn-lg btn-white ms-0 ps-0 pe-1 me-0 mediaviewer-control' id="mediaviewer-previous" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderPrevious();'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 59 40" width="25px" height="100%" style="transform: rotate(180deg);"><path fill="inherit" fill-rule="evenodd" d="M58.69 19.7l-3.7-3.7-16-16-3.7 3.7 13.39 13.38H0v5.24h48.68L35.29 35.7l3.7 3.7 16-16 3.7-3.7z"/></svg></button>
		<button class='btn btn-lg btn-white ps-1 ms-0 pe-0 me-0 mediaviewer-control' id="mediaviewer-next" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderNext();'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 59 40" width="25px" height="100%"><path fill="inherit" fill-rule="evenodd" d="M58.69 19.7l-3.7-3.7-16-16-3.7 3.7 13.39 13.38H0v5.24h48.68L35.29 35.7l3.7 3.7 16-16 3.7-3.7z"/></svg></button>
	</div>
</div>
<!-- END: Media viewer controls -->

<!-- START: Media selector bar -->
<?php
	if(sizeof($media_list) > 1) {
		$media_icons = [];
		foreach($media_list as $i => $m) {
			$media_icons[] = "<div class='col-2 img-fluid mb-3'><a class='mediaviewer-selector-control' hx-on:click='window.mediaViewerManagers[\"mediaviewer\"].render({$i});'>".caHTMLImage($m['icon'], ['class' => 'mediaIcon border border-white border-2']).'</a></div>';
		}
?>
<div id="mediaviewer-selector" class='row my-3 gx-3 justify-content-center'><?= join(" ", $media_icons); ?></div>
<?php
	}
?>
<!-- END: Media selector bar -->

<!-- START: Full-window media overlay display <div>'s -->
<div id="mediaviewer-overlay" class="mediaviewer-overlay position-fixed w-100 h-100 top-0 start-0 bg-white bg-opacity-75">
	<div class="mediaviewer-overlay-controls bg-dark">
		<div class="mediaviewer-overlay-navigation">
			<a href="#" id="mediaviewer-overlay-previous" class="text-light mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderPrevious(true);'><i class="bi bi-arrow-left"></i></a>
			<a href="#" id="mediaviewer-overlay-next" class="text-light mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderNext(true);'><i class="bi bi-arrow-right"></i></a>
		</div>
		<div id="mediaviewer-overlay-caption" class="mediaviewer-caption"></div>
		<div class="mediaviewer-overlay-close pt-1">
			<a href="#" class="text-light" hx-on:click='window.mediaViewerManagers["mediaviewer"].hideOverlay();'><i class="bi bi-x-lg"></i></a>
		</div>
	</div>
	<div id="mediaviewer-overlay-content" class="mediaviewer-overlay-content">
<?php 
	foreach($media_viewer_overlays as $display_class => $media_viewer_overlay) {
?>
		<div id="mediaviewer-overlay-<?= $display_class; ?>" class="mediaviewer-overlay-display w-100 h-100 display-none"><?= $media_viewer_overlay; ?></div>
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
