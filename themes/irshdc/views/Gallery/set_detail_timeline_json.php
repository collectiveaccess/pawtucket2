<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Gallery/set_detail_timeline_json.php :
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

AssetLoadManager::register('timeline');
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
			$va_set_items[$qr_set_items->get("row_id")] = array("title" => $qr_set_items->get("ca_set_items.preferred_labels"), "description" => $qr_set_items->get("ca_set_items.set_item_description"), "caption" => $qr_set_items->get("ca_set_items.caption"), "georeference" => $qr_set_items->get("ca_set_items.georeference"), "date" => $qr_set_items->get("ca_set_items.indexingDatesSet", array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';')), "date_display" => $qr_set_items->get("ca_set_items.indexingDatesSet"));
		}
	}
}

// title slide
$va_data = [
	'title' => [
		'text' => [
			'headline' => $t_set->getWithTemplate($va_view_info['title']['headline_template'] ?: '^ca_sets.preferred_labels.name'),
			'text' => $t_set->getWithTemplate($va_view_info['title']['introduction_template'] ?: $vs_set_description),
		],
		'media' => [
			'url' => '',
			'credit' => '',
			'caption' => ''
		]
	],
	'scale' => 'human'
];


$vn_c = 0;

while($qr_res->nextHit()) {
	# --- object and entity sets show set item info and fall back to object/entity
	switch($vs_table){
		case "ca_entities":
			$vs_primary_key = "ca_entities.entity_id";
		break;
		case "ca_objects":
			$vs_primary_key = "ca_objects.object_id";
		break;
		case "ca_occurrences":
			$vs_primary_key = "ca_occurrences.occurrence_id";
		break;
	}
	$vs_dates = $va_set_items[$qr_res->get($vs_primary_key)]["date"];
	$vs_date_display = $va_set_items[$qr_res->get($vs_primary_key)]["date_display"];
	if(!$vs_dates){
		$vs_dates = $qr_res->get($va_view_info['data'], array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';'));
	}
	if(!$vs_date_display){
		$vs_date_display = $qr_res->get($va_view_info['data']);
	}
	$va_dates = explode(";", $vs_dates);

	$va_date_list = explode("/", $va_dates[0]);
	if (!$va_date_list[0] || !$va_date_list[1]) continue;
	$va_timeline_dates = caGetDateRangeForTimelineJS($va_date_list);

	if($vs_table == "ca_occurrences"){
		$va_data['events'][] = [
			'text' => [
				'headline' => $qr_res->getWithTemplate($va_view_info['display']['title_template'] ?: '^ca_objects.preferred_labels.name'),
				'text' => $qr_res->getWithTemplate($va_view_info['display']['description_template']),
			],
			'media' => [
				'url' => $qr_res->getWithTemplate($va_view_info['display']['image'], array('returnURL' => true, 'checkAccess' => $va_access_values)),
				'thumbnail' => $qr_res->getWithTemplate($va_view_info['display']['icon'], array('returnURL' => true, 'checkAccess' => $va_access_values)),
				'credit' => $qr_res->getWithTemplate($va_view_info['display']['credit_template']),
				'caption' => $va_set_items[$qr_res->get($vs_primary_key)]["caption"]
			],
			'start_date' => $va_timeline_dates['start_date'],
			'end_date' => $va_timeline_dates['end_date'],
		];
		
	}else{
		# --- don't link to detail when title entered on set item
		$vb_link_to_detail = true;
		$vs_title = $va_set_items[$qr_res->get($vs_primary_key)]["title"];
		if($vs_title == "[BLANK]"){
			$vs_title = "";
		}
		if($vs_title){
			$vb_link_to_detail = false;
		}else{
			$vs_title = $qr_res->getWithTemplate($va_view_info['display']['title_template']);
		}
		if($vs_table == "ca_objects"){
			if($vb_link_to_detail && (($qr_res->get("ca_objects.type_id") != $vn_digital_exhibit_object_type_id) || (($qr_res->get("ca_objects.type_id") == $vn_digital_exhibit_object_type_id) && ($qr_res->get("ca_objects.display_detail_page", array("convertCodesToDisplayText" => true)) == "Yes")))){
				$vs_title = caDetailLink($this->request, $vs_title, '', "ca_objects", $qr_res->get("ca_objects.object_id"));
			}
		}		
		$vs_set_item_description = $va_set_items[$qr_res->get($vs_primary_key)]["description"];

		$va_data['events'][] = [
			'text' => [
				'headline' => "<div class='galleryTimelineDate'>".$vs_date_display."</div>".$vs_title,
				'text' => ($vs_set_item_description) ? $vs_set_item_description : $qr_res->getWithTemplate($va_view_info['display']['description_template']),
			],
			'media' => [
				'url' => $qr_res->getWithTemplate($va_view_info['display']['image'], array('returnURL' => true, 'checkAccess' => $va_access_values)),
				'thumbnail' => $qr_res->getWithTemplate($va_view_info['display']['icon'], array('returnURL' => true, 'checkAccess' => $va_access_values)),
				'credit' => $qr_res->getWithTemplate($va_view_info['display']['credit_template']),
				'caption' => $va_set_items[$qr_res->get($vs_primary_key)]["caption"]
			],
			'start_date' => $va_timeline_dates['start_date'],
			'end_date' => $va_timeline_dates['end_date'],
		];
	}
	$vn_c++;
	if ($vn_c >= 250) { break; }
}

print json_encode($va_data);
