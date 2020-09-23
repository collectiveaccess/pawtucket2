<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
	require_once(__CA_MODELS_DIR__."/ca_entities.php");
?>
<div class="container"><div class="row"><div class="col-sm-12">

<H1><?php print _t("About"); ?></H1>
<div class="row">
	<div class="col-sm-12">
		{{{about_page}}}
		<?php print "<div style='width:300px;'>".caGetThemeGraphic($this->request, 'cthumanities.jpg')."</div>"; ?>
	</div>
</div>
<hr/ style='margin-top:30px;'>
<div class="row" style='padding-bottom:40px;margin-top:0px;margin-bottom:40px; '>
	<div class="col-sm-12"><h2 style='margin-bottom:25px;'>Participating Institutions</h2></div>
<?php
$qr_members = ca_entities::find(['type_id' => 'member'], ['returnAs' => 'searchResult']);
if ($qr_members) {
	while ($qr_members->nextHit()) {
		print "<div class='col-sm-4 col-lg-3'>
					<div class='frontTile'>";
		print "<div class='tileImageWrapper'><div class='tileImage'>".caDetailLink($this->request, $qr_members->get('ca_object_representations.media.small'), '', 'ca_entities', $qr_members->get('ca_entities.entity_id'))."</div></div>";
		print "<div class='titleCaption'>".$qr_members->get('ca_entities.preferred_labels', array('returnAsLink' => true))."</div>";
		print "	</div>
			</div>";
	}
}
?>									
</div><!-- end row -->	

</div></div></div>