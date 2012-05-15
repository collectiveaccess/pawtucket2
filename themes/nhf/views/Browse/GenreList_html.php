<?php
	$o_browse = $this->getVar('browse');
	$vs_facet_name = 'genre_facet';
?>
<div id="browseListBody">
	<div id="title">Genres</div>
	<div id="introText">
		For collections that contain moving images classified by style and intended audience, click on a genre.
	</div><!-- end introText -->
<?php
	$o_browse->removeAllCriteria();
	$o_browse->execute(array('checkAccess' => array(1)));
	
	$va_facet = $o_browse->getFacet($vs_facet_name, array('checkAccess' => array(1)));
	//print_r($va_facet);
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