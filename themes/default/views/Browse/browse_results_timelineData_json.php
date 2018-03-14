<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_images_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
	
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();

	$va_view_info = $va_views[$vs_current_view];
	

	// title slide
	$va_data = [
		// 'title' => [
// 			'text' => [
// 				'headline' => '',
// 				'text' => '',
// 			],
// 			'media' => [
// 				'url' => '',
// 				'credit' => '',
// 				'caption' => ''
// 			]
// 		],
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
				"url" => $qr_res->getWithTemplate(caGetOption('image', $va_view_info['display'], null), array('returnURL' => true, 'checkAccess' => $va_access_values)),
				"thumbnail" => $qr_res->getWithTemplate(caGetOption('icon', $va_view_info['display'], null), array('returnURL' => true, 'checkAccess' => $va_access_values)),
				"credit" => $qr_res->getWithTemplate(caGetOption('credit_template', $va_view_info['display'], null)),
				"caption" => $qr_res->getWithTemplate(caGetOption('caption_template', $va_view_info['display'], null))
			],
			"display_date" => $qr_res->get($va_view_info['data'], array('delimiter' => '; ')),
			'start_date' => $va_timeline_dates['start_date'],
			'end_date' => $va_timeline_dates['end_date'],
		];

		$vn_c++;
		if ($vn_c >= 250) { break; }
	}

	print json_encode($va_data);
