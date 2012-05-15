<?php
	$va_jumpToList = $this->getVar("jumpToList");
?>
<div id="title"><?php print _t("Periods"); ?></div>
<div class="browseSelectPanelContentArea">
	<div class="browseSelectPanelList">
		<table class='browseSelectPanelListTable'>
<?php
	$i = 1;
	foreach($va_jumpToList as $vs_label => $vn_year){
		if($i == 1){
			print "<tr>";
		}
		print "<td><br/>".caNavLink($this->request, $vs_label, '', 'Chronology', 'Detail', '', array('year' => $vn_year))."</td>";
		if($i == 4){
			print "</tr>";
			$i = 0;
		}
		$i++;
	}
	if($i > 1){
		while($i <=4){
			print "<td><!-- empty --></td>";
			$i++;
		}
		print "</tr>";
	}
?>	
	</table></div><!-- end browseSelectPanelList -->
</div><!-- end browseSelectPanelContentArea -->