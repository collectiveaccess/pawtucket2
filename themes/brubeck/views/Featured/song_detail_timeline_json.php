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
header('Content-type: text/json');

AssetLoadManager::register('timeline');

/** @var SearchResult of occurrences to show on timeline $qr_timeline_occss */
$qr_timeline_occs	 						= $this->getVar("timeline_occs");

$t_song 							= $this->getVar("song");
$va_access_values = caGetUserAccessValues($this->request);

// title slide
$va_data = [
	'title' => [
		'text' => [
			'headline' => $t_song->getWithTemplate('A timeline of "^ca_occurrences.preferred_labels.name"'),
			'text' => "",
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

while($qr_timeline_occs->nextHit()) {
	$vs_dates = $qr_timeline_occs->get("ca_occurrences.date_occurrence_container.date_occurrence", array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';'));
	$va_dates = explode(";", $vs_dates);

	$va_date_list = explode("/", $va_dates[0]);
	if (!$va_date_list[0] || !$va_date_list[1]) continue;
	$va_timeline_dates = caGetDateRangeForTimelineJS($va_date_list);

	$va_data['events'][] = [
		'text' => [
			'headline' => $qr_timeline_occs->getWithTemplate('<b>^ca_occurrences.type_id<ifdef code="^ca_occurrences.appearance_type">, ^ca_occurrences.appearance_type</ifdef></b><br/>^ca_occurrences.preferred_labels.name<ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><br/><unit relativeTo="ca_occurrences.related" restrictToTypes="venue" delimiter="<br/>">^ca_occurrences.preferred_labels.name</unit></ifcount>'),
			'text' => $qr_timeline_occs->getWithTemplate('^ca_occurrences.description'),
		],
		'media' => [
			'url' => $qr_timeline_occs->getWithTemplate("<unit relativeTo='ca_objects' limit='1'>^ca_object_representations.media.large.url</unit>", array('checkAccess' => $va_access_values)),
			'thumbnail' => $qr_timeline_occs->getWithTemplate("<unit relativeTo='ca_objects' limit='1'>^ca_object_representations.media.iconlarge.url</unit>", array('checkAccess' => $va_access_values)),
			'credit' => $qr_timeline_occs->getWithTemplate("<unit relativeTo='ca_objects' length='1'>^ca_objects.credit</unit>"),
			'caption' => $qr_timeline_occs->getWithTemplate("<unit relativeTo='ca_objects' length='1'><l>^ca_objects.preferred_labels.name</l></unit>")

		],
		'start_date' => $va_timeline_dates['start_date'],
		'end_date' => $va_timeline_dates['end_date'],
	];

	$vn_c++;
	if ($vn_c >= 250) { break; }
}

print json_encode($va_data);
