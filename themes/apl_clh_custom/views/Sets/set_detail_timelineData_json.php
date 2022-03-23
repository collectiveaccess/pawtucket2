<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Sets/set_detail_timelineData_json.php : 
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
	
	$va_set_items = $this->getVar("set_items");
	$t_set = $this->getVar("set");
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_info = $va_views[$vs_current_view];
	$vn_hits_per_block 	= 40;

	$va_data = array(		
		"headline" => "",
		"type" => "default",
		"text" => "",
		"asset" => array(
			"media" => "",
			"credit" => "",
			"caption" => ""
		)
	);
	$va_set_object_ids;
	foreach($va_set_items as $va_set_item){
		$va_set_object_ids[] = $va_set_item["row_id"];
	}
	$qr_res = ca_objects::createResultSet($va_set_object_ids);
	$vn_c = 0;
	$qr_res->seek($vn_start);
	while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
		$vs_dates = $qr_res->get($va_view_info['data'], array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';'));
		$va_dates = explode(";", $vs_dates);
		
		$va_date_list = explode("/", $va_dates[0]);
		if (!$va_date_list[0] || !$va_date_list[1]) continue; 
		$va_timeline_dates = caGetDateRangeForTimelineJS($va_date_list);
		
	
		$va_data['date'][] = array(
			"startDate" => $va_timeline_dates['start'],
			"endDate" => $va_timeline_dates['end'],
			"headline" => $qr_res->getWithTemplate(caGetOption('title_template', $va_view_info['display'], null)),
			"text" => $qr_res->getWithTemplate(caGetOption('description_template', $va_view_info['display'], null)),
			"tag" => '',
			"classname" => '',
			"asset" => array(
				"media" => $qr_res->getWithTemplate(caGetOption('image', $va_view_info['display'], null), array('returnURL' => true)),
				"thumbnail" => $qr_res->getWithTemplate(caGetOption('icon', $va_view_info['display'], null), array('returnURL' => true)),
				"credit" => $qr_res->getWithTemplate(caGetOption('credit_template', $va_view_info['display'], null)),
				"caption" => $qr_res->getWithTemplate(caGetOption('caption_template', $va_view_info['display'], null))
			)
		);
		
		$vn_c++;
		if ($vn_c > 2000) { break; }
	}
			
	print json_encode(array('timeline' => $va_data));
?>