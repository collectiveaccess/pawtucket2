en<?php

// do a search and print out the titles of all found objects
$o_search = new ObjectSearch();
$qr_results = $o_search->search("Park");    // ... or whatever text you like

$count = 1;
while($qr_results->nextHit()) {
  print "Hit ".$count.": ".$qr_results->get('ca_objects.preferred_labels.name')."<br/>\n";
  $count++;
}
?>
