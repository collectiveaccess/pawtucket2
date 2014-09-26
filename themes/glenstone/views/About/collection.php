<?php

require_once(__CA_MODELS_DIR__."/ca_sets.php");
include_once(__CA_LIB_DIR__."/ca/Search/OccurrenceSearch.php");
include_once(__CA_MODELS_DIR__."/ca_occurrences.php");

$va_access_values = caGetUserAccessValues($this->request);

	if($vs_set_code = $this->request->config->get("featured_art_set")){
	 	AssetLoadManager::register("carousel");
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
		}
		if(is_array($va_item_ids) && sizeof($va_item_ids)){
			$t_object = new ca_objects();
			$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("slideshowsmall"), array('checkAccess' => caGetUserAccessValues($this->request)));
		}
	}	
?>
<div class="container">
	<div class="row collection">
		<div class="col-sm-6">
			<h1>Collection Advanced Search coming soon.</h1>
		</div><!--end col-sm-8-->
		<div class="col-sm-6">
			<div class="exhibitions">
				<h1>Glenstone Exhibitions</h1>
<?php
	$o_exhibition_search = new OccurrenceSearch();
	$o_exhibition_search->setTypeRestrictions(array('exhibition'));
	$qr_exhibitions = $o_exhibition_search->search("*", array('checkAccess' => $va_access_values, 'sort' => 'ca_occurrences.exh_dates', 'sort_direction' => 'desc'));

	if ($qr_exhibitions->numHits()) {
		while($qr_exhibitions->nextHit()) {
			print "<div class='exhibition'>".caNavLink($this->request, $qr_exhibitions->get('ca_occurrences.preferred_labels'), '', '', 'Detail', 'occurrences/'.$qr_exhibitions->get('ca_occurrences.occurrence_id'))."</div>";
		}
	}
?>			
			</div>
		</div> <!--end col-sm-4-->	
	</div><!--end row-->
</div> <!--end container-->