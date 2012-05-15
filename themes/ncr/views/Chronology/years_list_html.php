<div id="title"><?php print _t("Years"); ?></div>
<div class="browseSelectPanelContentArea">
	<div class="browseSelectPanelList">
		<table class='browseSelectPanelListTable'>

<?php
	$i = 1;
	for($vn_year = 1904; $vn_year <= 1988; $vn_year++){
		if($i == 1){
			print "<tr>";
		}
		print "<td>".caNavLink($this->request, $vn_year, 'browseSelectPanelLink', 'Chronology', 'Detail', '', array('year' => $vn_year))."</td>";
		if($i == 5){
			print "</tr>";
			$i = 0;
		}
		$i++;
	}
	if($i > 1){
		while($i <=5){
			print "<td>x</td>";
			$i++;
		}
		print "</tr>";
	}
?>	
	</table></div><!-- end browseSelectPanelList -->
</div><!-- end browseSelectPanelContentArea -->