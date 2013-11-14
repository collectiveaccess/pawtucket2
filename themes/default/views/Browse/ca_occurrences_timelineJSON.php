<?php
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= 100; //(int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results

	$vb_ajax			= (bool)$this->request->isAjax();
	
	
		$va_data = array(		
			"headline" => "BAM Production Timeline",
			"type" => "default",
			"text" => "<p>Intro body text goes here, some HTML is ok</p>",
			"asset" => array(
				"media" => "http://s3.amazonaws.com/assets.bam.org/Stage/images/bam_logo.gif",
				"credit" => "Credit Name Goes Here",
				"caption" => "Caption text goes here"
			)
        );
		
		$vn_c = 0;
		$qr_res->seek($vn_start);
		
		$va_results = array();
		while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
			$vs_occurrence_idno = $qr_res->get('ca_occurrences.idno');
			$va_related_objects = $qr_res->get('ca_objects.object_id', array('returnAsArray' => true));
			$va_first_object_id = $va_related_objects[0];
			$t_object = new ca_objects($va_first_object_id);
			
			$va_rep = $t_object->getPrimaryRepresentation('small', null, array("checkAccess" => $va_access_values));
			$va_rep_id = $va_rep['representation_id'];
			//$t_object_representation = new ca_object_representations($va_rep_id);
			//$va_image_width = $t_object_representation->getMediaInfo('ca_object_representations.media', 'small', 'WIDTH');

			$vs_dates = $qr_res->get('ca_occurrences.productionDate', array('sortable' => true, 'returnAsArray'=> false, 'delimiter' => ';'));
			$va_dates = explode(";", $vs_dates);
			
			$va_timeline_dates = caGetDateRangeForTimelineJS(explode("/", $va_dates[0]));
			$va_data['date'][] = array(
				"startDate" => $va_timeline_dates['start'],
                "endDate" => $va_timeline_dates['end'],
                "headline" => $qr_res->get('ca_occurrences.preferred_labels.name'),
                "text" => $qr_res->get('ca_occurrences.description'),
                "tag" => "",
                "classname" => "",
                "asset" => array(
                    "media" => $va_rep['urls']['preview170'],
                    "thumbnail" => $va_rep['urls']['icon'],
                    "credit" => "<i>Credit</i>",
                    "caption" => "<i>Caption</il>"
                )
			);
			
			$vn_c++;
			//if ($vn_c > 2000) { break; }
		}
		
		
		print json_encode(array('timeline' => $va_data));
?>