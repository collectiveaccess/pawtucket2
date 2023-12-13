<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
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
 
 $t_item = $this->getVar("item");
 $stops = $t_item->getStops($this->request, [
 	'bundles' => [
 		'ca_tour_stops.tour_stop_description',
 		'ca_tour_stops.date',
 		'ca_tour_stops.tour_stop_georeference'
 	]
 ]);
 
 
 // Generate slides
 $slides = [];
 foreach($stops as $stop) {
 	if(!strlen($stop['tour_stop_georeference'])) { continue; }
 	
 	$coordinates = preg_replace("/[\[\]]+/", "", $stop['tour_stop_georeference']);
 	$coord_bits = explode(',', $coordinates);
 	
 	$t_stop = new ca_tour_stops($stop['stop_id']);

	$t_object = $t_stop->getRelatedItems('ca_objects', ['returnAs' => 'firstModelInstance']);
	
	$media_url = $t_object ? $t_object->get('ca_object_representations.media.medium.url') : null;
	$media_caption = $t_object ? $t_object->get('ca_objects.preferred_labels.name') : null;
 	array_push($slides, [
 		//"type" => "overview",
 		"location" => [
 			"lat" => (float)$coord_bits[0],
 			"lon" => (float)$coord_bits[1],
 		],
 		"text" => [
 			"headline" => $stop['name'],
 			"text" => $stop['tour_stop_description']
 		],
 		"media" => [             
        	"url" => $media_url,       // url for featured media
        	"caption" => $media_caption,  
        	"credit" => ""
    	]
 	]);
 }
 
 // Generate StoryMap Data
 $data = [
 	"width" => 500,
 	"height" => 600,
 	"calculate_zoom" => true,
 	"storymap" => [
 		"language" => "en",
 		"map_type" => "osm:standard",
 		"map_as_image" => false,
 		"slides" => $slides,
 	]
 ];
 
// print_R(json_encode($data));die;
 ?>
<main data-barba="container" data-barba-namespace="journey" class="barba-main-container journey-section">
	<div class="general-page">
		<div class="container">
			<div class="row justify-content-center">
				<h1 class="page-heading heading-size-2 ps-0"><?= $t_item->get('ca_tours.preferred_labels'); ?></h1>
				<div class="col-auto">
					<p class="page-content content-size-2 mb-5">
						<?= $t_item->get('ca_tours.tour_description'); ?>
					</p>
				</div>

				<button type="button" onclick="openmodal()" style="padding: 10px; font-size: 20pt; width: auto;font-family:Forum,sans-serif;" class="btn btn-light btn-lg mt-5" data-bs-toggle="modal" data-bs-target="#journeyModal">
					View Gesel's Journey
				</button>

				<div class="modal" id="journeyModal" tabindex="-1" aria-labelledby="journeyModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" style="position: unset; max-width: unset;">
						<div class="modal-content">
							<div class="modal-header">
								<h1 class="modal-title" id="journeyModalLabel" style="color: #000;font-family:Forum,sans-serif;">Gesel's Journey</h1>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div id="mapdiv" style="width: 100%; height: 80vh;"></div>
							</div>
						</div>
					</div>
				</div>

				<script>
					// Variable to track whether the script has already run
					var scriptExecuted = false;

					function openmodal() {
						if (!scriptExecuted) {
							runScript();
							scriptExecuted = true;
						}
					}

					function runScript() {
						var storymap_data = <?= json_encode($data); ?>;
						var storymap_options = {};
						var storymap = new KLStoryMap.StoryMap('mapdiv', storymap_data, storymap_options);
						window.onresize = function(event) {
							storymap.updateDisplay();
						}
					}
				</script>
			</div>
		</div>
	</div>
</main>