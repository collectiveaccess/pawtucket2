<?php
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$o_browse			= $this->getVar('browse');
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= 100; //(int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results

	$vb_ajax			= (bool)$this->request->isAjax();
	
	$va_browse_description = array();
	if (sizeof($va_criteria) > 0) {
		foreach($va_criteria as $va_criterion) {
			if ($va_criterion['facet_name'] == '_search') { continue; }
			$va_browse_description[] = "<em>".$va_criterion['value']."</em>";
		}
	}
	$vs_browse_description = sizeof($va_browse_description) ? "Chronology for ".join(", ", $va_browse_description) : "";
	
		$va_data = array(		
			"headline" => __CA_APP_DISPLAY_NAME__." Timeline",
			"type" => "default",
			"text" => "<p>{$vs_browse_description}</p>",
			"asset" => array(
				"media" => "",
				"credit" => "",
				"caption" => ""
			)
        );
		
		$vn_c = 0;
		$qr_res->seek($vn_start);
		$va_results = array();
		while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
			$vs_object_idno = $qr_res->get('ca_objects.idno');
			$va_related_objects = $qr_res->get('ca_objects.object_id', array('returnAsArray' => true));
			$va_first_object_id = $va_related_objects[ceil(rand(0, sizeof($va_related_objects) - 1))];
			$t_object = new ca_objects($va_first_object_id);
			
			$vn_object_id = caUseIdentifiersInUrls() ? $t_object->get('idno') : $va_first_object_id;
			$vn_object_id = caUseIdentifiersInUrls() ? $qr_res->get('ca_objects.idno') : $qr_res->get('ca_objects.object_id');
			
			$va_rep = $t_object->getPrimaryRepresentation(array('small', 'preview170', 'icon'), null, array("checkAccess" => $va_access_values));
			$va_rep_id = $va_rep['representation_id'];

			$vs_dates = $qr_res->get('ca_objects.dateSet.setDisplayValue', array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';'));
			$va_dates = explode(";", $vs_dates);
			
			$va_date_list = explode("/", $va_dates[0]);
			if (!$va_date_list[0] || !$va_date_list[1]) continue; 
			$va_timeline_dates = caGetDateRangeForTimelineJS($va_date_list);
			
		
			if (is_array($va_series = $qr_res->get('ca_objects.series', array('convertCodesToDisplayText' => true, 'returnAsArray' => true)))) {
				$vs_tag = array_shift($va_series);
				$vs_tag = $vs_tag['series'];
			} else {
				$vs_tag = '';
			}
		
		
			$va_data['date'][] = array(
				"startDate" => $va_timeline_dates['start'],
                "endDate" => $va_timeline_dates['end'],
                "headline" => caDetailLink($this->request, $qr_res->get('ca_objects.preferred_labels.name'), '', 'ca_objects', $vn_object_id),
                "text" => $qr_res->getWithTemplate("<unit delimiter='<br/>' relativeTo='ca_objects'><ifdef code='ca_objects.series'>^ca_objects.series<br/></ifdef>
<ifdef code='ca_objects.venue'>^ca_objects.venue<br/></ifdef>
<unit delimiter=', ' relativeTo='ca_entities' restrictToRelationshipTypes='principal_artist'><em><l>^ca_entities.preferred_labels.displayname</l></em></unit></unit>"),
                "tag" => $vs_tag,
                "classname" => "",
                "asset" => array(
                    "media" => $va_rep['urls']['small'],
                    "thumbnail" => $va_rep['urls']['icon'],
                    "credit" => "<i>".$t_object->get("ca_objects.rightsStatement.rightsStatement_text")."</i>",
                    "caption" => "<i>".caDetailLink($this->request, $t_object->get("ca_objects.preferred_labels.name")." (".$t_object->get("ca_objects.idno").")", '', 'ca_objects', $vn_object_id)."</i>"
                )
			);
			//caDetailLink($po_request, $ps_content, $ps_classname, $ps_table, $pn_id,
			$vn_c++;
			if ($vn_c > 2000) { break; }
		}
		
		
		print json_encode(array('timeline' => $va_data));
?>