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
/** @var SearchResult $qr_appearances */
$t_tour	 						= $this->getVar("tour");
$qr_appearances	 				= $this->getVar("appearances");
$va_access_values = caGetUserAccessValues($this->request);

$va_data = [
	'width' => '100%',
	'height' => '500px',
//    'font_css' => string,              // optional; font set
    'calculate_zoom' => true,              // optional; defaults to true.
    'storymap' => [
        'language' => 'en',
        'map_type' => 'osm:standard',
        'slides' => []
    ]
];

// title slide - comes from the tour
$va_data['storymap']['slides'][] = [
    'type' => 'overview',
//    'location' => [            // required for all slides except "overview" slide
//        'lat' => decimal,      // latitude of point on map
//        'lon' => decimal       // longitude of point on map
//    ],
    'text' => [                // optional if media present
        'headline' => $t_tour->getWithTemplate('^ca_occurrences.preferred_labels.name'),
		'text' => $t_tour->getWithTemplate('^ca_occurrences.description'),
    ],
//    media: {               // optional if text present
//        url: string,       // url for featured media
//        caption: string,   // optional; brief explanation of media content
//        credit: string     // optional; creator of media content
];	
	


// Slides are for each appearance
// the media is from the appearance's related objects 
// georeference is from the venue related to the appearance
$vn_c = 0;
while($qr_appearances->nextHit()) {
	$vs_image = $vs_caption = $vs_credit = "";
	$vs_georeference = $qr_appearances->getWithTemplate("<unit relativeTo='ca_occurrences.related' restrictToTypes='venue'>^ca_occurrences.georeference</unit>");
	$vs_image = $qr_appearances->getWithTemplate("^ca_object_representations.media.large.url", array("checkAccess" => $va_access_values));
	if($vs_image){
		$vs_caption = $qr_appearances->getWithTemplate("^ca_object_representations.preferred_labels", array("checkAccess" => $va_access_values));
	}
	if(!$vs_image){
		$vs_image = $qr_appearances->getWithTemplate("<ifcount code='ca_objects' min='1' restrictToRelationshipTypes='featured'><unit relativeTo='ca_objects' restrictToRelationshipTypes='featured' limit='1'>^ca_object_representations.media.large.url</unit></ifcount>", array("checkAccess" => $va_access_values));
		$vs_caption = $qr_appearances->getWithTemplate("<ifcount code='ca_objects' min='1' restrictToRelationshipTypes='featured'><unit relativeTo='ca_objects' restrictToRelationshipTypes='featured' limit='1'><l>^ca_objects.preferred_labels.name</l></unit></ifcount>", array("checkAccess" => $va_access_values));
		$vs_credit = $qr_appearances->getWithTemplate("<ifcount code='ca_objects' min='1' restrictToRelationshipTypes='featured'><unit relativeTo='ca_objects' restrictToRelationshipTypes='featured' limit='1'>^ca_objects.credit</unit></ifcount>", array("checkAccess" => $va_access_values));
	}
	if(!$vs_image){
		$vs_image = $qr_appearances->getWithTemplate("<unit relativeTo='ca_objects' limit='1'>^ca_object_representations.media.large.url</unit>", array('checkAccess' => $va_access_values));
		$vs_caption = $qr_appearances->getWithTemplate("<unit relativeTo='ca_objects' limit='1'><ifdef code='ca_object_representations.media'><l>^ca_objects.preferred_labels.name</ifdef></l></unit>", array("checkAccess" => $va_access_values));
		$vs_credit = $qr_appearances->getWithTemplate("<unit relativeTo='ca_objects' limit='1'><ifdef code='ca_object_representations.media'>^ca_objects.credit</ifdef></unit>", array("checkAccess" => $va_access_values));
	}
	
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
				'headline' => $qr_appearances->getWithTemplate('<l>^ca_occurrences.preferred_labels.name<br/><ifdef code="ca_occurrences.date_occurrence_container.date_occurrence">^ca_occurrences.date_occurrence_container.date_occurrence</ifdef></l>'),
				'text' => $qr_appearances->getWithTemplate('<ifdef code="ca_occurrences.description">^ca_occurrences.description</ifdef>'),
			],
			'media' => [
				'url' => $vs_image,
				'credit' => $vs_credit,
				'caption' => $vs_caption
			]
		];	

		$vn_c++;
		if ($vn_c >= 250) { break; }
	}
}

print json_encode($va_data);
