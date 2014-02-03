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
			"headline" => "BAM Production Timeline",
			"type" => "default",
			"text" => "<p>{$vs_browse_description}</p>",
			"asset" => array(
				"media" => "http://s3.amazonaws.com/assets.bam.org/Stage/images/bam_logo.gif",
				"credit" => "",
				"caption" => ""
			)
        );
		
		$vn_c = 0;
		$qr_res->seek($vn_start);
		$va_results = array();
		while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
			$vs_occurrence_idno = $qr_res->get('ca_occurrences.idno');
			$va_related_objects = $qr_res->get('ca_objects.object_id', array('returnAsArray' => true));
			$va_first_object_id = $va_related_objects[ceil(rand(0, sizeof($va_related_objects) - 1))];
			$t_object = new ca_objects($va_first_object_id);
			
			$vn_object_id = caUseIdentifiersInUrls() ? $t_object->get('idno') : $va_first_object_id;
			$vn_occurrence_id = caUseIdentifiersInUrls() ? $qr_res->get('ca_occurrences.idno') : $qr_res->get('ca_occurrences.occurrence_id');
			
			$va_rep = $t_object->getPrimaryRepresentation(array('small', 'preview170', 'icon'), null, array("checkAccess" => $va_access_values));
			$va_rep_id = $va_rep['representation_id'];

			$vs_dates = $qr_res->get('ca_occurrences.productionDate', array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';'));
			$va_dates = explode(";", $vs_dates);
			
			$va_timeline_dates = caGetDateRangeForTimelineJS(explode("/", $va_dates[0]));
			
		
			if (is_array($va_series = $qr_res->get('ca_occurrences.series', array('convertCodesToDisplayText' => true, 'returnAsArray' => true)))) {
				$vs_tag = array_shift($va_series);
				$vs_tag = $vs_tag['series'];
			} else {
				$vs_tag = '';
			}
		
		
			$va_data['date'][] = array(
				"startDate" => $va_timeline_dates['start'],
                "endDate" => $va_timeline_dates['end'],
                "headline" => caDetailLink($this->request, $qr_res->get('ca_occurrences.preferred_labels.name'), '', 'ca_occurrences', $vn_occurrence_id),
                "text" => $qr_res->getWithTemplate("<unit delimiter='<br/>' relativeTo='ca_occurrences'><ifdef code='ca_occurrences.series'>^ca_occurrences.series<br/></ifdef>
<ifdef code='ca_occurrences.venue'>^ca_occurrences.venue<br/></ifdef>
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
			//if ($vn_c > 2000) { break; }
		}
		
		
		print json_encode(array('timeline' => $va_data));
?>