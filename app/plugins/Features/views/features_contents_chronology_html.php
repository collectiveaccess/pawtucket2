<?php
	require_once(__CA_LIB_DIR__.'/ca/Browse/ObjectBrowse.php');
	require_once(__CA_LIB_DIR__.'/core/Parsers/TimeExpressionParser.php');
	
	$t_set = $this->getVar('t_set');
	$o_tep = new TimeExpressionParser();	// we use this to normalize exhibition dates to years
	
	// The "set_chronology_type" set attribute is the ca_list_items.item_id of the occurrence type
	// for which we need to list out occurrences (aka "subject programs" in Perry-speak)
	$va_chronology_types = $t_set->getAttributesByElement("set_chronology_type");
	
	// Pull the raw item_id of the type out of the first value (it doesn't repeat)
	$va_values = $va_chronology_types[0]->getValues();
	$vn_chronology_type_id = $va_values[0]->getDisplayValue();
	
	// Ok... now generate an object browse on the occurrence facet for the specified type
	// This will give us a complete list of occurrences with the date attached (since the
	// facet supports grouping by year - yay!). It's also pretty fast since the BrowseEngine
	// does caching. Yay again!
	$o_browse = new ObjectBrowse();
	$va_facet = $o_browse->getFacet('occurrence_facet_'.$vn_chronology_type_id);
?>
<div id="featuresTitle"><?php print $t_set->getLabelForDisplay(); ?></div>
<div id="featuresDescription"><?php print $t_set->getSimpleAttributeValue('set_introduction'); ?></div>
<div style="clear: both;"><!-- empty --></div>
<div>
<?php
	// Run through the facet and sort out occurrences by year
	$va_exhibition_list_by_year = array();
	foreach($va_facet as $vn_id => $va_item) {
		$va_v = $va_item['ca_attribute_51'][0];		// 51=the element_id of the "dates" attribute attached to each occurrence
		$va_normalized_v =  $o_tep->normalizeDateRange($va_v['value_decimal1'], $va_v['value_decimal2'], 'years');	// convert the exhibition date from a day-specific date range to a year
		$vn_year = array_shift($va_normalized_v);
		$va_exhibition_list_by_year[$vn_year][$va_v['value_decimal1']][$va_item['label']] = $va_item['id'];		// array is key'ed by year, then by occurrence title; the value is the occurrence_id
	}
//print_r($va_exhibition_list_by_year);
	// Output occurrences
	ksort($va_exhibition_list_by_year);	// sort by year
	
	# --- public programs should be ordered in reverse chronological order
	# --- see if we're displaying public programs by testing the vn_chronology_type_id (set above) against the occurrence type_id for public programs
	# --- if they match, reverse the array
	$t_list = new ca_lists();
	$vn_public_program_type_id = $t_list->getItemIDFromList('occurrence_types', 'public_program');
	if($vn_public_program_type_id == $vn_chronology_type_id){
		$va_exhibition_list_by_year = array_reverse($va_exhibition_list_by_year, true);
	}
	$t_list = new ca_lists();
	$vn_public_program_type_id = $t_list->getItemIDFromList('occurrence_types', 'exhibitions');
	if($vn_public_program_type_id == $vn_chronology_type_id){
		$va_exhibition_list_by_year = array_reverse($va_exhibition_list_by_year, true);
	}
	$t_list = new ca_lists();
	$vn_public_program_type_id = $t_list->getItemIDFromList('occurrence_types', 'publication');
	if($vn_public_program_type_id == $vn_chronology_type_id){
		$va_exhibition_list_by_year = array_reverse($va_exhibition_list_by_year, true);
	}
	foreach($va_exhibition_list_by_year as $vn_year => $va_exhibitions_by_date) {
		if (!$vn_year) { continue; }	// year=0 means no date; don't show these... (should be catalogued but you know how it goes)
		ksort($va_exhibitions_by_date);
		print '<div id="featuresChronTitle">'.$vn_year."</div>\n";
			
		foreach($va_exhibitions_by_date as $vn_date => $va_exhibitions) {
			foreach($va_exhibitions as $vs_exhibition_name => $vn_occurrence_id) {
				// Link the occurrence name to an occurrence detail
				print caNavLink($this->request, $vs_exhibition_name, '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id))."<br/>\n";
			}
		}
	}
?>
</div>