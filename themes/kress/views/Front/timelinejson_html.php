<?php
$va_access_values = caGetUserAccessValues($this->request);
# ---- return json for all occurrences of type timeline
$t_list_items = new ca_list_items(array("idno" => "timeline"));
$vn_timeline_list_id = $t_list_items->get("ca_list_items.item_id");

$o_db = new Db();
$q_timeline_entries = $o_db->query("SELECT DISTINCT o.occurrence_id 
					FROM ca_occurrences o 
					WHERE o.type_id = ? AND o.access IN (".join(", ", $va_access_values).")", $vn_timeline_list_id);



if($q_timeline_entries->numRows()){
	$va_data = [
	#	'title' => [
	#		'text' => [
	#			'headline' => "This is the Intro Slide",
	#			'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
	#		],
	#		'media' => [
	#			'url' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'history1.jpg'),
	#			'credit' => 'caption',
	#			'caption' => ''
	#		]
	#	],
		'scale' => 'human'
	];

	while($q_timeline_entries->nextRow()){
		$t_timeline = new ca_occurrences($q_timeline_entries->get("ca_occurrences.occurrence_id"));
		$vs_dates = $t_timeline->get("ca_occurrences.Doc_DateFilter", array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';'));
		$va_dates = explode(";", $vs_dates);

		$va_date_list = explode("/", $va_dates[0]);
		if (!$va_date_list[0] || !$va_date_list[1]) continue;
		$va_timeline_dates = caGetDateRangeForTimelineJS($va_date_list);

		if($va_timeline_dates['start_date'] && $va_timeline_dates['end_date']){
			$va_data['events'][] = ['text' => [
									'headline' => ($vs_tmp = $t_timeline->get("ca_occurrences.preferred_labels")) ? $vs_tmp : '',
									'text' => ($vs_tmp = $t_timeline->get("ca_occurrences.Doc_Note")) ? $vs_tmp : '',
								],
								'media' => [
									'url' => ($vs_tmp = $t_timeline->get("ca_object_representations.media.medium.url")) ? $vs_tmp : '',
									'thumbnail' => ($vs_tmp = $t_timeline->get("ca_object_representations.media.small.url")) ? $vs_tmp : '',
									'credit' => ($vs_tmp = $t_timeline->get("ca_object_representations.credit_line")) ? $vs_tmp : '',
									'caption' => ''
								],
								'start_date' => $va_timeline_dates['start_date'],
								'end_date' => $va_timeline_dates['end_date'],
								'display_date' => $t_timeline->get("ca_occurrences.Doc_DateFilter")								
			];	
		}	
	}

	print json_encode($va_data);
}
?>