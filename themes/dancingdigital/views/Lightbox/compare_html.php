<?php
$representations = $this->getVar('representations');
$start_times = $this->getVar('startTimes');
if(is_array($representations)) {
	$percent = "50";
?>
	<table style="width: 100%">
		<tr>
<?php
	foreach($representations as $i => $rep) {
		
		if(($i > 0) && (($i % 2) == 0))  {
			print "</tr><tr>";
		}
		print "<td style='width:{$percent}% !important;'>".$rep->getMediaTag('media', 'original', [
			'class' => '', 'width' => "{$percent}%", 'id' => 'comparePlayer_'.$i,
			'start' => $start_times[$i], 'autoplay' => true
		])."</td>";
	}
}
?>
		</tr>
	</table>