<?php
	require_once(__CA_LIB_DIR__."/ca/Search/CollectionSearch.php");
 	
	# --- get all collections
	
 	$o_search = new CollectionSearch();
	$qr_collections = $o_search->search("ca_collections.access:1", array("sort" => "ca_collection_labels.name", "checkAccess" => array(1)));
	
?>
<div id="browseListBody"><a name="top"></a>
	<div id="title">Collections</div>
	<div id="introText">
		We care for approximately 800 moving image collections, which would take more than a year to watch. Of these, 300+ are described online at the collection level. To read about each collection, click on the collection name.

	</div><!-- end introText -->
<?php
	
	if($qr_collections->numHits() > 0){
		$va_collections_by_letter = array();
		$i = 0;
		while($qr_collections->nextHit()) {
			$vs_collection = "";
			$vs_letter = "";
			$vs_link = "";
			$vs_collection = join('; ', $qr_collections->getDisplayLabels($this->request));
			$vs_letter = mb_substr($vs_collection, 0, 1);
			if(($i != 0) && ($vs_letter != $vs_last_letter)){
				$va_collections_by_letter[$vs_last_letter] = $va_temp;
				$va_temp = array();
			}
			$vs_link = caNavLink($this->request, $vs_collection, '', 'Detail', 'Collection', 'Show', array('collection_id' => $qr_collections->get("collection_id")));
			$va_temp[] = $vs_link;
			$vs_last_letter = $vs_letter;
			$i++;
		}
		$va_letter = array_keys($va_collections_by_letter);
		print "<div id='letterBar'>Jump to: ";
		foreach($va_letter as $vs_letter){
			print "<a href='#".$vs_letter."'>".$vs_letter."</a>";
		}
		print "</div><!-- end letterBar -->";
		print "<div id='list'>";
		foreach($va_collections_by_letter as $vs_letter => $va_collections){
			print "<div class='letterHeading'><a name='".$vs_letter."'></a>".$vs_letter."</div>";
			$colLength = ceil(sizeof($va_collections) / 3);
			$c = 0;
			#print_r($va_collections);
			print "<div class='col'>";
			foreach($va_collections as $vs_link) {
				print "<div class='item'>".$vs_link."</div>\n";
				$c++;
				if($c == $colLength){
					print "</div><div class='col'>";
					$c = 0;
				}
			}
			print "</div><!-- end col -->";
			print "<a href='#top' class='top'>Back to top</a>";
		}
		print "</div><!-- end list -->";
	}
	
?>
<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end browseListBody -->