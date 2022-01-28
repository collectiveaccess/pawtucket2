<?php
	$qr_res = $this->getVar("featured_set_items_as_search_result");
?>
<div class="row">
	<div id="browseResultsContainer">
<?php
$va_ids = array();
if($qr_res->numHits()){
	while($qr_res->nextHit()) {
		$va_ids[] = $qr_res->get("ca_collections.collection_id");
	}
	$va_access_values = $this->getVar("access_values");
	$va_images = caGetDisplayImagesForAuthorityItems('ca_collections', $va_ids, array('version' => 'resultcrop', 'relationshipTypes' => ['cover'], 'checkAccess' => $va_access_values));

	$vn_c = 0;	
	$qr_res->seek(0);
	$vs_default_placeholder = caGetThemeGraphic($this->request, 'placeholder.jpg');

	
	if($qr_res->numHits() == 1){
		# --- when there is only 1 result print a spacer result so the news title will still display
		print "<div class='bResultItemCol col-xs-6 col-sm-3 col-md-3'></div>";
		$vn_c = 1;
	}
	while($qr_res->nextHit()) {
		$vn_id	= $qr_res->get("ca_collections.collection_id");
		$vs_label = "";
		if(!($vs_label = $qr_res->get("ca_collections.preferred_labels.displayname"))){
			$vs_label = $qr_res->get("ca_collections.preferred_labels.name");
		}
		$vs_label_detail_link 	= caDetailLink($this->request, $vs_label, '', "ca_collections", $vn_id);
		$vs_thumbnail = "";

		if($va_images[$vn_id]){
			$vs_thumbnail = $va_images[$vn_id];
		}else{
			$vs_thumbnail = $vs_default_placeholder;
		}
		$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_collections', $vn_id);			


		print "
<div class='bResultItemCol col-xs-6 col-sm-3 col-md-3'>
<div class='bResult'>
	{$vs_rep_detail_link}
	<div class='bResultText'>
		{$vs_label_detail_link}
	</div>
</div>
</div><!-- end col -->";

		$vn_c++;
		if($vn_c == 2){
			print "<div class='bResultItemCol col-sm-6 bTitleBlockContainer'><div class='bResult'><div class='bTitleBlock'>News</div><div class='row bStretchSpacer'><div class='col-xs-6'>$vs_default_placeholder</div><div class='col-xs-6'>$vs_default_placeholder</div></div></div></div>";
		}
	}	
}
?>
	</div>
</div>