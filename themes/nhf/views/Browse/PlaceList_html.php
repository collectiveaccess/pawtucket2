<?php
	$o_browse = $this->getVar('browse');
	$vs_facet_name = 'geoloc_facet';
?>
<div id="browseListBody">
	<div id="title">Places</div>
	<div id="introText">
		For collections that depict these geographic locations, click on a place name.
	</div><!-- end introText -->
<?php
	$o_browse->removeAllCriteria();
	$o_browse->execute(array('checkAccess' => array(1)));
	
	$va_facet = $o_browse->getFacet($vs_facet_name, array('checkAccess' => array(1)));
	
	$colLength = ceil(sizeof($va_facet) / 3);
	$c = 0;
	print "<div id='list'><div class='col'>";
	
	$va_places_by_state = array();
	foreach($va_facet as $va_item) {
		$vs_proc_label = str_replace(", Maine", ", ME",  $va_item['label']);
		$va_tmp = explode(',', $vs_proc_label);
		$va_places_by_state[$va_tmp[1]][$va_tmp[0]] = "<div class='item'>".caNavLink($this->request, $vs_proc_label, '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => $vs_facet_name, 'id' => $va_item['id']))."</div>\n";
	}
	
	ksort($va_places_by_state);
	
	foreach($va_places_by_state as $va_places) {
		ksort($va_places);
		foreach($va_places as $vs_link) {
			print $vs_link;
			$c++;
			if($c == $colLength){
				print "</div><div class='col'>";
				$c = 0;
			}
		}
	}
	print "</div><!-- end col --></div><!-- end list -->";
?>
<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end browseListBody -->