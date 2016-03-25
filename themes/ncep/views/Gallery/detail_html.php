<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$va_set_objects = array();
	$va_set_object_captions = array();
	foreach($pa_set_items as $vn_item_id => $pa_set_item){
		$va_set_objects[] = $pa_set_item["row_id"];
		$va_set_object_captions[$pa_set_item["row_id"]] = $pa_set_item["caption"];
	}
	$q_modules = caMakeSearchResult("ca_objects", $va_set_objects);
?>
<div class="row">
	<div class='col-xs-12'>
		<div class="detailBox detailBoxTop">
			<div class='galleryBackLink'>
				<?php print caNavLink($this->request, "<i class='fa fa-arrow-circle-up'></i>", "", "", "Gallery", "Index"); ?>
			</div>
			<H1><?php print $this->getVar("section_name"); ?>: <?php print $this->getVar("label")."</H1>"; ?>
<?php
			$vs_thumbnail = $t_set->get("set_image", array("version" => "small"));

			if($vs_thumbnail){
				print "<div class='galleryIconDetail'>".$vs_thumbnail."</div>";
			}
			if($ps_description){
?>
				<?php print "<p>".$ps_description."</p>"; ?>
<?php
			}
?>	
			<div style="clear:both;"></div>
		</div>
	</div>
</div>		
<div class="row">
	<div class='col-xs-12'>
		<?php print ($this->request->isLoggedIn()) ? "" : "<div class='galleryLoginMessage'>* "._("Educators please login to download all components")."</div>"; ?>
		<H1><?php print sizeof($va_set_objects)." Modules"; ?></H1>
	</div>
</div>
<?php
if($q_modules->numHits()){
	while($q_modules->nextHit()){
		print "
		<div class='row'><div class='col-xs-12'>
			<div class='bResItem'>
				<div class='pull-right'>".caNavLink($this->request, _t("Download All".(!$this->request->isLoggedIn() ? "*" : ""))."&nbsp; <i class='fa fa-download'></i>", 'btn-default btn-orange btn-icon', 'Detail', 'DownloadMedia', '', array("object_id" => $q_modules->get("object_id"), "download" => 1), array("title" => ($this->request->isLoggedIn()) ? _t("Download All") : _("Educators please login to download all components"))).caDetailLink($this->request, "<i class='fa fa-arrow-circle-right'></i>", "blueButton", "ca_objects", $q_modules->get("object_id"), null, array("title" => _t("View Module")))."</div>
				<H1>".caDetailLink($this->request, $q_modules->get("ca_objects.preferred_labels"), "", "ca_objects", $q_modules->get("object_id"))."<H1>
				<div class='bResContent'>".
					$q_modules->getWithTemplate("<ifdef code='ca_objects.language'>"._t("Language").": ^ca_objects.language%delimiter=,_</ifdef>", array("convertCodesToDisplayText" =>true, 'checkAccess' => caGetUserAccessValues($this->request)))
				."<br/>"._t("Authors").": ".
					$q_modules->getWithTemplate("<unit relativeTo='ca_objects.children' restrictToTypes='Synthesis,CaseStudies,Exercise,Presentation' aggregateUnique='1' unique='1'><unit relativeTo='ca_entities' restrictToRelationshipTypes='author'>^ca_entities.preferred_labels.displayname</unit></unit>", array("delimiter" => ", ", 'checkAccess' => caGetUserAccessValues($this->request)))
				.(($va_set_object_captions[$q_modules->get("object_id")]) ? "<br/><br/>Curator comment: ".$va_set_object_captions[$q_modules->get("object_id")] : "")
				."</div><!-- end bResContent -->
			</div><!-- end bResItem -->
		</div><!-- end col --></div><!-- end row -->\n";
	}
}
?>