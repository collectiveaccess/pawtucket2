<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Gallery/set_detail_storymap_json.php :
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
 * ----------------------------------------------------------------------
 */


header('Content-type: text/json');
/** @var SearchResult $qr_res */
$qr_res	 						= $this->getVar("result");
/** @var ca_sets $t_set */
$t_set 							= $this->getVar("set");
$va_views						= $this->getVar('views');
$vs_current_view				= $this->getVar('view');
$vs_set_description				= $this->getVar('description');
$vs_table						= $this->getVar('table');

$va_view_info 					= $va_views[$vs_current_view][$vs_table];
$va_access_values = caGetUserAccessValues($this->request);

$t_list = new ca_lists();
$vn_digital_exhibit_object_type_id = $t_list->getItemIDFromList('object_types', 'digitalExhibitObject'); 	
 
$va_item_ids = array_keys($t_set->getItemIds());
if(is_array($va_item_ids) && sizeof($va_item_ids)){
	$qr_set_items = caMakeSearchResult('ca_set_items', $va_item_ids);
	$va_set_items = array();
	if($qr_set_items->numHits()){
		while($qr_set_items->nextHit()){
			$va_set_items[$qr_set_items->get("row_id")] = array("title" => $qr_set_items->get("ca_set_items.preferred_labels"), "description" => $qr_set_items->get("ca_set_items.set_item_description"), "georeference" => $qr_set_items->get("ca_set_items.georeference"));
		}
	}
}

$va_data = [
	'width' => ($va_view_info["width"]) ? $va_view_info["width"] : '100%',
	'height' => ($va_view_info["height"]) ? $va_view_info["height"] : '500px',
//    'font_css' => string,              // optional; font set
    'calculate_zoom' => true,              // optional; defaults to true.
    'storymap' => [
        'language' => 'en',
        'map_type' => ($va_view_info['map_tiles']) ? $va_view_info['map_tiles'] : 'stamen:toner-lite',
        'slides' => []
    ]
];








// title slide
$va_data['storymap']['slides'][] = [
    'type' => 'overview',
//    'location' => [            // required for all slides except "overview" slide
//        'lat' => decimal,      // latitude of point on map
//        'lon' => decimal       // longitude of point on map
//    ],
    'text' => [                // optional if media present
        'headline' => $t_set->getWithTemplate($va_view_info['title']['headline_template'] ?: '^ca_sets.preferred_labels.name'),
		'text' => $t_set->getWithTemplate($va_view_info['title']['introduction_template'] ?: $vs_set_description),
    ],
//    media: {               // optional if text present
//        url: string,       // url for featured media
//        caption: string,   // optional; brief explanation of media content
//        credit: string     // optional; creator of media content
];	
	



$vn_c = 0;

while($qr_res->nextHit()) {
	# --- use set item title/desc/georeference if available otherwise fall back to configured title_template/description_template/location from object
	# --- don't link to detail when title entered on set item
	$vb_link_to_detail = true;
	$vs_title = $va_set_items[$qr_res->get("ca_objects.object_id")]["title"];
	if($vs_title == "[BLANK]"){
		$vs_title = "";
	}
	if($vs_title){
		$vb_link_to_detail = false;
	}else{
		$vs_title = $qr_res->getWithTemplate($va_view_info['display']['title_template']);
	}
	if($vb_link_to_detail && (($qr_res->get("ca_objects.type_id") != $vn_digital_exhibit_object_type_id) || (($qr_res->get("ca_objects.type_id") == $vn_digital_exhibit_object_type_id) && ($qr_res->get("ca_objects.display_detail_page", array("convertCodesToDisplayText" => true)) == "Yes")))){
		$vs_title = caDetailLink($this->request, $vs_title, '', "ca_objects", $qr_res->get("ca_objects.object_id"));
	}
	
	
	$vs_set_item_description = $va_set_items[$qr_res->get("ca_objects.object_id")]["description"];
	$vs_set_item_georeference = $va_set_items[$qr_res->get("ca_objects.object_id")]["georeference"];

	$vs_georeference = ($vs_set_item_georeference) ? $vs_set_item_georeference : $qr_res->getWithTemplate($va_view_info['display']['location']);
	if($vs_georeference){
		$vs_georeference = str_replace(array("[", "]"), array("", ""), $vs_georeference);
		$va_coordinates = explode(",", $vs_georeference);
		$va_data['storymap']['slides'][] = [
			//'date' => '1820',
			'location' => [
				//'name' => 'name',
				'lat' => floatval(trim($va_coordinates[0])),
				'lon' => floatval(trim($va_coordinates[1])),
				'line' => true
			],
			'text' => [
				'headline' => $vs_title,
				'text' => ($vs_set_item_description) ? $vs_set_item_description : $qr_res->getWithTemplate($va_view_info['display']['description_template']),
			],
			'media' => [
				'url' => $qr_res->getWithTemplate($va_view_info['display']['image'], array('returnURL' => true, 'checkAccess' => $va_access_values)),
				'credit' => $qr_res->getWithTemplate($va_view_info['display']['credit_template']),
				'caption' => $qr_res->getWithTemplate($va_view_info['display']['caption_template'])
			]
		];	

		$vn_c++;
		if ($vn_c >= 250) { break; }
	}
}

print json_encode($va_data);
