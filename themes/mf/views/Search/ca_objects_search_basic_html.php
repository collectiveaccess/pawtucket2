<?php
	$o_result = $this->getVar('result');
	
	print "Got ". $o_result->numHits()." for ".$o_result->tableName()."<br>\n";
	
	
	while($o_result->nextHit()) {
		print $o_result->get('ca_objects.preferred_labels.name');
		print $o_result->getTagForPrimaryRepresentation('icon');
		print "<br>\n";
	}
?>