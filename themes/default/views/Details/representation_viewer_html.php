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
$subject = $this->getVar("subject");
?>
<style>
	.mediaviewer-selector-control, .mediaviewer-selector-control-active{
		border: 0px;
		padding: 0px;
		background-color: transparent;
	}
  	.mediaviewer-selector-control-active img {
		border: 2px solid #000 !important;
	}
	.mediaviewer-selector-control img{
		border:2px solid transparent;
	}
	.mediaviewer-overlay:focus {
		box-shadow:inset 0 0 3px 3px rgba(0,0,0,.5)
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
		height: 85%;
	}
	
	div.mediaviewer-overlay-close {
		position: fixed;
		
		color: #fff;
		
		right: 10px;
		top: 0px;
		z-index: 150000;
		font-size: 20px;
	}
	
	div.mediaviewer-overlay-navigation {
		position: fixed;
		
		color: #fff;
		
		left: 10px;
		top: 0px;
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
	.mediaviewer-overlay-controls .btn:focus{
		box-shadow:0 0 2px 2px #FFFFFF;
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
		<button class='btn btn-md btn-white ps-0 ms-0 pe-2 me-1 mediaviewer-control' id="mediaviewer-show-overlay" hx-on:click='window.mediaViewerManagers["mediaviewer"].showOverlay();' aria-label='enlarge'><i class="bi bi-zoom-in"></i></button>
		<button class='btn btn-md btn-white ps-0 ms-0 mediaviewer-control' id="mediaviewer-download" aria-label="download" hx-on:click="window.location='<?= caNavUrl($this->request, '*', '*', 'DownloadMedia/'.$this->request->getAction(), ['t' => $subject->tableName(), 'id' => $subject->getPrimaryKey()]); ?>'"><i class="bi bi-download"></i></button>
	</div>
	<div class="col-6 text-end">
		<button class='btn btn-lg btn-white ms-0 ps-0 pe-1 me-0 mediaviewer-control' id="mediaviewer-previous" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderPrevious();' aria-label='previous slide'><i class="bi bi-arrow-left"></i></button>
		<button class='btn btn-lg btn-white ps-1 ms-0 pe-0 me-0 mediaviewer-control' id="mediaviewer-next" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderNext();' aria-label='next slide'><i class="bi bi-arrow-right"></i></button>
	</div>
</div>
<!-- END: Media viewer controls -->

<!-- START: Media selector bar -->
<?php
	if(sizeof($media_list) > 12){
		$group_size = 4;
		$media_icons = [];
		$g = -1;
		foreach($media_list as $i => $m) {
			if(($i % $group_size) === 0) { 
				$g++; 
				$media_icons[$g] = ['g' => $g, 'items' => []];	
			};
			$media_icons[$g]['items'][] = "<div class='col-3 img-fluid'><button class='mediaviewer-selector-control mediaIcon' id='mediaviewer-selector-control".$i."' hx-on:click='window.mediaViewerManagers[\"mediaviewer\"].render({$i});'>".$m['icon_tag'].'</button></div>';
		}
		$media_icons = array_map(function($v) {
			return "<div class='carousel-item gx-12 row ".(($v['g'] == 0) ? 'active' : '')."'>".join('', $v['items'])."</div>";
		}, $media_icons);
?>
<div id="mediaviewer-selector" class='mx-auto my-3 justify-content-center'>
	<div id="multiCarousel" class="carousel slide multiSlideCarousel">
        <div class="row">
        	<div class="col-2 col-sm-1 align-content-center">
        		<a class="btn btn-white p-2" href="#multiCarousel" role="button" data-bs-slide="prev" aria-label="previous slide">
					<i class="bi bi-arrow-left"></i>
				</a>
			</div>
			<div class="col-8 col-sm-10">
				<div class="carousel-inner" role="listbox"><?= join(" ", $media_icons); ?></div>
        	</div>
        	<div class="col-2 col-sm-1 align-content-center">
				<a class="btn btn-white p-2" href="#multiCarousel" role="button" data-bs-slide="next" aria-label="next slide" onClick="return false;">
					<i class="bi bi-arrow-right"></i>
				</a>
    		</div>
    	</div>
    </div>
</div>
<style>
	.multiSlideCarousel .carousel-inner .carousel-item.active,
	.multiSlideCarousel .carousel-inner .carousel-item-next,
	.multiSlideCarousel .carousel-inner .carousel-item-prev {
		display: flex;
	}
	
		
		.multiSlideCarousel .carousel-inner .carousel-item-end.active,
		.multiSlideCarousel .carousel-inner .carousel-item-next {
			transform: translateX(100%);
		}
		
		.multiSlideCarousel .carousel-inner .carousel-item-start.active, 
		.multiSlideCarousel .carousel-inner .carousel-item-prev {
			transform: translateX(-100%);
		}
	
	.multiSlideCarousel .carousel-inner .carousel-item-end,
	.multiSlideCarousel .carousel-inner .carousel-item-start { 
		transform: translateX(0);
	}
</style>
<?php
	}elseif(sizeof($media_list) > 1){
		$media_icons = [];
		foreach($media_list as $i => $m) {
			$media_icons[] = "<div class='col-2 img-fluid mb-3'><button class='mediaviewer-selector-control mediaIcon' hx-on:click='window.mediaViewerManagers[\"mediaviewer\"].render({$i});'>".$m['icon_tag'].'</button></div>';
		}
?>
<div id="mediaviewer-selector" class='row my-3 gx-3 justify-content-center'><?= join(" ", $media_icons); ?></div>
<?php
	}
?>
<!-- END: Media selector bar -->

<!-- START: Full-window media overlay display <div>'s -->
<dialog id="mediaviewer-overlay" class="mediaviewer-overlay position-fixed w-100 h-100 mw-100 mh-100 top-0 start-0 bg-white bg-opacity-75 p-0 m-0 overflow-hidden">
	<div class="mediaviewer-overlay-controls bg-dark">
		<div class="mediaviewer-overlay-navigation">
			<button type="button" id="mediaviewer-overlay-previous" class="btn btn-link btn-lg p-0 text-light mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderPrevious(true);' role='button' aria-label='previous slide'><i class="bi bi-arrow-left"></i></button>
			<button type="button" id="mediaviewer-overlay-next" class="btn btn-link btn-lg p-0 text-light mediaviewer-control" hx-on:click='window.mediaViewerManagers["mediaviewer"].renderNext(true);' role='button' aria-label='next slide'><i class="bi bi-arrow-right"></i></button>
			<span id="media-count" class="fs-5 ps-3"></span>
		</div>
		<div id="mediaviewer-overlay-caption" class="mediaviewer-caption"></div>
		<div class="mediaviewer-overlay-close">
			<button type="button" class="btn btn-link btn-lg p-0 text-light" hx-on:click='window.mediaViewerManagers["mediaviewer"].hideOverlay();' role='button' aria-label='close dialog'><i class="bi bi-x-lg"></i></button>
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
</dialog>
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
