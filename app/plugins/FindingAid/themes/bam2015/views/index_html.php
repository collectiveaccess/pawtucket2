<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$va_open_by_default = $this->getVar('open_by_default');
	$va_access_values = caGetUserAccessValues($this->request);
		
	$vn_collection_type = $t_collection->getTypeIDForCode('collection');
	$qr_top_level_collections = ca_collections::find(array('type_id' => $vn_collection_type), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values));
	
	if (!$va_open_by_default) {
		$vs_hierarchy_style = "style='display:none;'";
	}
?>

				
	<div class="row">
		<div class='col-xs-12 col-sm-10 col-sm-offset-1'>
			<div class='detailHead'>
				<div class='leader'>Finding Aids</div>
				<h2>Archival and Manuscript Collections</h2> 
				<p style='margin-top:15px;'>The BAM Hamm Archives contains the collections listed below. Most of the collections are digitized, and can be searched online. Some, for instance the BAM Board Files and Harvey Lichtenstein President’s Records, can be searched only physically, on site.</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class='col-xs-12'>
			<hr class='divide'>
		</div><!-- end col -->
	</div><!-- end row -->
	<div class="row">
		<div class='col-xs-12'>

	
<?php	
	if ($qr_top_level_collections) {
		$vn_c = 0;
		while($qr_top_level_collections->nextHit()) { 
			if($vn_c == 0){
				print "<div class='row'>";
			}
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id');
			#$vn_collection_image = $qr_top_level_collections->getWithTemplate('<unit relativeTo="ca_objects" length="1"><unit relativeTo="ca_object_representations" length="1">^ca_object_representations.media.widepreview</unit></unit>', array('checkAccess' => $va_access_values));
			//print $qr_top_level_collections->get('ca_collections.preferred_labels.name')."<br>\n";
			$vn_collection_image = $qr_top_level_collections->get("ca_collections.collection_thumbnail", array("version" => "iconlarge"));
			print "<div class='col-xs-12 col-sm-6'>";
			print "<div class='row'>";
			print "<div class='col-xs-12 col-sm-3'><div class='collectionGraphic'>".$vn_collection_image."</div></div><!-- end col -->";
			print "<div class='col-xs-12 col-sm-8'><div class='collectionName'>";
			print $qr_top_level_collections->get('ca_collections.preferred_labels', array('returnAsLink' => true));
			print "</div>\n";
			if (strlen($qr_top_level_collections->get('ca_collections.collection_description')) > 250) {
				print "<div class='collectionDescription'>".substr($qr_top_level_collections->get('ca_collections.collection_description'), 0, 247)."...</div>";				
			} else {
				print "<div class='collectionDescription'>".$qr_top_level_collections->get('ca_collections.collection_description')."</div>";
			}
			print "</div><!-- end col -->\n";
			print "</div><!-- end row -->\n";
			print "</div><!-- end col -->\n";	
			$vn_c++;
			if($vn_c == 2){
				print "</div><!-- end row -->";
				$vn_c = 0;
			}
		}
		if($vn_c == 1){
			print "</div><!-- end row -->";
		}
	} else {
		print _t('No collections available');
	}
?>
</div><!-- end col --></div><!-- end row-->	
	
	
	
	
