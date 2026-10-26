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
<div class="container">
	<div class="row">
		<div class="col-sm-7 col-sm-offset-1 col-md-7 col-lg-8">
			<h1><?php print _t("Contributors"); ?></h1>
			<div class="bodytext">
				<div class="row">
		<?php
				$i == 0;
				foreach($va_member_inst_by_region as $vs_region => $va_inst_by_region){
					$i++;
					print "<div class='memberInstList col-sm-6'><b>".$vs_region." Region</b><br/>";
					print join("<br/>", $va_inst_by_region);
					print "</div>";
					if ($i==2) {
						print "</div><div class='row'>";
					}
				}
		?>
				</div>
			</div><!-- end textContent -->
		</div><!-- end col -->
		<div class="col-sm-3 col-md-3 col-lg-2">
			<div class='sideMenu'>
				<div class="aboutMenu"><?php print caNavLink($this->request, _t('About Novamuse'), '', '', 'About', 'Index');?></div>
				<div class="aboutMenu"><?php print caNavLink($this->request, _t('Support Us'), '', '', 'About', 'support');?></div>
				<div class="aboutMenu"><?php print caNavLink($this->request, _t('Contributors'), '', '', 'About', 'contributors');?></div>
				<div class="aboutMenu"><?php print caNavLink($this->request, _t('Site Stats'), '', 'NovaMuse', 'Dashboard', 'Index');?></div>
			</div>
		</div>
	</div><!-- end row -->	
</div><!-- end container -->	