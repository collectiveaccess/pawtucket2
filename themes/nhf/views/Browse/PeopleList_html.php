<?php
	$o_browse = $this->getVar('browse');
	$vs_facet_name = 'entity_facet';
?>
<div id="browseListBody">
	<div id="title">People and Organizations</div>
	<div id="introText">
		For collections that were created by, depict, or were donated by these people and organizations, click on a name.
	</div><!-- end introText -->
<?php
	$o_browse->removeAllCriteria();
	$o_browse->execute(array('checkAccess' => array(1)));
	
	$va_facet = $o_browse->getFacet($vs_facet_name, array('checkAccess' => array(1)));
	
	$colLength = ceil(sizeof($va_facet) / 3);
	$c = 0;
	print "<div id='list'><div class='col'>";
	foreach($va_facet as $va_item) {
		print "<div class='item'>".caNavLink($this->request, $va_item['label'], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => $vs_facet_name, 'id' => $va_item['id']))."</div>\n";
		$c++;
		if($c == $colLength){
			print "</div><div class='col'>";
			$c = 0;
		}
	}
	print "</div><!-- end col --></div><!-- end list -->";
?>
<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end browseListBody -->