<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$va_open_by_default = $this->getVar('open_by_default');
	

?>
	<script src="/assets/jquery/js/readmore.min.js" type="text/javascript"></script>	

	<div class='row'>
		<div class='col-sm-12 hero'>
<?php
			print caGetThemeGraphic($this->request, 'findingaidHeader.jpg');
?>
			<h1 class="hero"><?php print $vs_page_title; ?></h1>
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-12'>
			{{{finding_aid_intro}}}
		</div>
	</div>
	<div id='findingAidCont'>
<?php	
	$qr_collections = ca_collections::find(array('type_id' => 140), array('returnAs' => 'searchResult'));

	if ($qr_collections->numHits()) {
		$va_collections_display = array();
		while ($qr_collections->nextHit()) {
			$va_collections_display[$qr_collections->get('ca_collections.preferred_labels')] = array("link" => caNavLink($this->request, $qr_collections->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$qr_collections->get('ca_collections.collection_id')), "desc" => $qr_collections->get('ca_collections.ISADG_scope'));
		}
		ksort($va_collections_display);
		foreach($va_collections_display as $va_collection_display){
			print "<div class='collectionsBlock'>";
			print "<div class='collHeader'>".$va_collection_display["link"]."</div>";
			print "<div class='trimText'>".$va_collection_display["desc"]."</div>";
			print "</div>";
		}
	} else {
		print _t('No collections available');
	}
?>
	</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 97
		});
	});
</script>	