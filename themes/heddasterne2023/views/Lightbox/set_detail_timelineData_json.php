<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Sets/set_detail_timelineData_json.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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
	
	$qr_res	 						= $this->getVar("result");
	$t_set 							= $this->getVar("set");
	$va_views						= $this->getVar('views');
	$vs_current_view				= $this->getVar('view');
	
	$va_view_info 					= $va_views[$vs_current_view];
	$vn_hits_per_block 				= 40;

	// title slide
	$va_data = [
		'title' => [
			'text' => [
				'headline' => '',
				'text' => '',
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
	$qr_res->seek($vn_start);
	while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
		$vs_dates = $qr_res->get($va_view_info['data'], array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';'));
		$va_dates = explode(";", $vs_dates);
		
		$va_date_list = explode("/", $va_dates[0]);
		if (!$va_date_list[0] || !$va_date_list[1]) continue; 
		$va_timeline_dates = caGetDateRangeForTimelineJS($va_date_list);

		$va_data['events'][] = [
			'text' => [
				'headline' => $qr_res->getWithTemplate(caGetOption('title_template', $va_view_info['display'], null)),
				'text' => $qr_res->getWithTemplate(caGetOption('description_template', $va_view_info['display'], null)),
			],
			'media' => [
				'url' => $qr_res->getWithTemplate(caGetOption('image', $va_view_info['display'], null), array('returnURL' => true)),
				'thumbnail' => $qr_res->getWithTemplate(caGetOption('icon', $va_view_info['display'], null), array('returnURL' => true)),
				'credit' => $qr_res->getWithTemplate(caGetOption('credit_template', $va_view_info['display'], null)),
				'caption' => $qr_res->getWithTemplate(caGetOption('caption_template', $va_view_info['display'], null))
			],
			'start_date' => $va_timeline_dates['start_date'],
			'end_date' => $va_timeline_dates['end_date'],
		];

		$vn_c++;
		if ($vn_c >= 250) { break; }
	}

	print json_encode($va_data);
