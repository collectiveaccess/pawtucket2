<?php	
 	require_once(__CA_LIB_DIR__."/ca/Search/EntitySearch.php");
 	$o_entity_search = new EntitySearch();
 	$t_list = new ca_lists();
 	$vn_member_institution_id = $t_list->getItemIDFromList('entity_types', 'member_institution');
 	$qr_member_institutions = $o_entity_search->search("ca_entities.access:1 AND ca_entities.type_id:{$vn_member_institution_id}", array("sort" => "ca_entity_labels.displayname"));
	# -- put in an array based on the region
	$va_member_inst_by_region = array();
	if($qr_member_institutions->numHits() > 0){
		while($qr_member_institutions->nextHit()){
			$va_member_inst_by_region[$qr_member_institutions->get("mem_inst_region", array('convertCodesToDisplayText' => true))][$qr_member_institutions->get("entity_id")] = caNavLink($this->request, join("; ", $qr_member_institutions->getDisplayLabels()), '', '', 'Detail', 'entities/'.$qr_member_institutions->get("entity_id"));
		}
	}
	ksort($va_member_inst_by_region);

?>
<div id='pageBody'>
	<div class="imageRightCol">
<?php
	print $this->render("About/sideNav.php");
?>
<?php
		print caGetThemeGraphic($this->request, 'hope-digby.jpg');
?>
		<div class="caption">Photo credit: Sheryl Stanton, Admiral Digby Museum</div><br/>
<?php
		print caGetThemeGraphic($this->request, 'AntigonishHeritageMuseum.jpg');
?>		
		<div class="caption">Antigonish Heritage Museum</div><br/>
<?php
		print caGetThemeGraphic($this->request, 'quilt.jpg');
?>		
		<div class="caption">Halifax Citadel Army Museum</div><br/>
<?php
		print caGetThemeGraphic($this->request, 'MacDonalHouseMuseum.jpg');
?>		
		<div class="caption">MacDonald House Museum</div>
	</div>
	<h1><?php print _t("Contributors"); ?></h1>
	<div class="textContent">
		<div>
<?php
		$i == 0;
		foreach($va_member_inst_by_region as $vs_region => $va_inst_by_region){
			$i++;
			print "<div class='memberInstList'".(($i == 3) ? " style='clear:left;'" : "")."><b>".$vs_region." Region</b><br/>";
			print join("<br/>", $va_inst_by_region);
			print "</div>";
			
		}
?>
		</div>
	</div><!-- end textContent -->
</div><!-- end pageBody -->