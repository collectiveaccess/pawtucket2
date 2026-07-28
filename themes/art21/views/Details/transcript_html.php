<?php
$transcript = $this->getVar('transcript');
$rep_id = $this->getVar('representation_id');
$closed = false;
$i = 1;
print "<div class='mb-3 text-indent'>\n";
foreach($transcript as $t) {	
	$w = $t['word'];
	$s = $t['start'];
	print "<a href='#viewerContainer' style='text-decoration: none;' onclick='seek(this, {$rep_id},{$s});'>{$w}</a>";
	if(substr($w, -1, 1) == '.') {
		print "</div>";
		if($i < sizeof($transcript)){
			print "<div class='mb-3 text-indent'>\n";
			$closed = false;
		}else{
			$closed = true;
		}
	} else {
		print ' ';
		$closed = false;
	}
	$i++;
}
if(!$closed){
	print "</div>\n";
}