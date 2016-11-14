<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	
	$vs_home = caNavLink($this->request, "City Readers", '', '', '', '');
	$vs_type = caNavLink($this->request, "Finding Aids", '', '', 'Collections', 'Index');
	MetaTagManager::setWindowTitle($vs_home." > ".$vs_type);
	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='margin-top:15px;'>

						<h4><?php print $this->getVar("section_name"); ?></h4>
						<div class='findingIntro'><?php print $o_collections_config->get("collections_intro_text"); ?></div>
						<div id='findingAidCont'>
<?php	
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) { 
			print "<div class='collHeader' >";
			print "<H3>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</H3>";	
			if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
				print "<div>".$vs_scope."</div>";
			}
			print "</div>";

		}
	} else {
		print _t('No collections available');
	}
?>
						</div>
					</div> <!-- end col-->	
				</div> <!-- end container--></div> <!-- end row-->	
			</div> <!-- end content-inner -->
		</div> <!-- end content-wrapper -->	
	</div> <!-- end wrapper -->	
</div> <!-- end page -->