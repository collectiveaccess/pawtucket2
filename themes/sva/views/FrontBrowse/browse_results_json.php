<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_json.php : 
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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
 
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_row_id		 	= (int)$this->getVar('row_id');			// id of last visited detail item so can load to and jump to that result - passed in back button
	
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	$o_config 			= $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$facet = $this->getVar('facet');
	$facet_info = $this->getVar('facet_info');
	
	
	$letter = mb_strtolower($va_criteria[0]['id']);
	
	$data = [];
	if ($vn_start < $qr_res->numHits()) {
		$vn_results_output = 0;
		$qr_res->seek($vn_start);
		
		while($qr_res->nextHit()) {
			if($vn_results_output >= $vn_hits_per_block){
				break;
			}
			$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
			if($vn_id == $vn_row_id){
				$vb_row_id_loaded = true;
			}
			
			$label = $qr_res->get("{$vs_table}.preferred_labels");
		
			$vs_label_detail_link 	= caDetailLink($label, '', $vs_table, $vn_id);
			
			$date = null;
			
			if ($facet == 'decade') {
				$d = substr($letter, 0, 3);
				if(is_array($dates = $qr_res->get("ca_occurrences.dates.dates_value", ['returnAsArray' => true, 'filters' => ['dates_type' => 'exhibition_date']])) && sizeof($dates)) {
					if (is_array($ndates = caNormalizeDateRange(array_shift($dates), 'years', ['returnAsArray' => true]))) {
						$date = array_pop($ndates);
						if (substr($date, 0, 3) !== $d) { $date = array_shift($ndates); }
					}
				}
				if (!$date) { continue; }
			}
			
			$data[] = [
				'id' => $qr_res->getPrimaryKey(),
				'idno' => $idno,
				'label' => $label,
				'detail_link' => $vs_label_detail_link,
				'year' => $date
			];
						
			$vn_results_output++;
		}			
	}
	if ($facet === 'decade') {
		$data = caSortArrayByKeyInValue($data, ['year']);
	}
	print json_encode($data, true);
