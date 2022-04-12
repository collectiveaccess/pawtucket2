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
$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("checkAccess" => $va_access_values)));
$t_set_item = new ca_set_items();
$va_set_item_descriptions = array();
$va_set_item_captions = array();
foreach($va_set_items as $vn_set_item_id => $va_set_item_info){
	$t_set_item->load($vn_set_item_id);
	$va_set_item_descriptions[$va_set_item_info["row_id"]] = ($t_set_item->get("ca_set_items.set_item_description")) ? $t_set_item->get("ca_set_items.set_item_description") : " ";
	$va_set_item_captions[$va_set_item_info["row_id"]] = ($t_set_item->get("ca_set_items.preferred_labels") != "[BLANK]") ? caDetailLink($this->request, $t_set_item->get("ca_set_items.preferred_labels"), "", "ca_occurrences", $va_set_item_info["row_id"]) : "";

}

// title slide
if($va_view_info['title']['headline_template'] || $va_view_info['title']['introduction_template']){
	$va_data = [
		'title' => [
			'text' => [
				'headline' => $t_set->getWithTemplate($va_view_info['title']['headline_template'] ? '^ca_sets.preferred_labels.name' : ''),
				'text' => $t_set->getWithTemplate($va_view_info['title']['introduction_template'] ? $vs_set_description : ''),
			],
			'media' => [
				'url' => '',
				'credit' => '',
				'caption' => ''
			]
		],
		'scale' => 'human'
	];
}else{
	$va_data = [
		'scale' => 'human'
	];

}

$vn_c = 0;

while($qr_res->nextHit()) {
	$vs_dates = $qr_res->get($va_view_info['data'], array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';'));
	$va_dates = explode(";", $vs_dates);

	$va_date_list = explode("/", $va_dates[0]);
	if (!$va_date_list[0] || !$va_date_list[1]) continue;
	$va_timeline_dates = caGetDateRangeForTimelineJS($va_date_list);

	$va_data['events'][] = [
		'text' => [
			'headline' => ($va_set_item_captions[$qr_res->get("ca_occurrences.occurrence_id")]) ? $va_set_item_captions[$qr_res->get("ca_occurrences.occurrence_id")] : $qr_res->getWithTemplate($va_view_info['display']['title_template']),
			'text' => ($va_set_item_descriptions[$qr_res->get("ca_occurrences.occurrence_id")]) ? $va_set_item_descriptions[$qr_res->get("ca_occurrences.occurrence_id")] : $qr_res->getWithTemplate($va_view_info['display']['description_template']),
		],
		'media' => [
			'url' => $qr_res->getWithTemplate($va_view_info['display']['image'], array('returnURL' => true, 'checkAccess' => $va_access_values)),
			'thumbnail' => $qr_res->getWithTemplate($va_view_info['display']['icon'], array('returnURL' => true, 'checkAccess' => $va_access_values)),
			'credit' => $qr_res->getWithTemplate($va_view_info['display']['credit_template']),
			'caption' => $qr_res->getWithTemplate($va_view_info['display']['caption_template'])
		],
		'start_date' => $va_timeline_dates['start_date'],
		'end_date' => $va_timeline_dates['end_date'],
	];

	$vn_c++;
	if ($vn_c >= 250) { break; }
}

print json_encode($va_data);
