<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Keywords");
?>
<H1><?php print _t("Keywords"); ?></H1>
<div class="row">
	<div class="col-sm-12">
<?php
		$t_lists = new ca_lists();
		$va_terms = caExtractValuesByUserLocale($t_lists->getItemsForList("voc_6"));
		foreach($va_terms as $va_term){
			if($va_term["access"] > 0){
				print "<p><b>".caNavLink($this->request, $va_term["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_term["item_id"]))."</b><br/>".$va_term["description"]."</p>";
			}
		}
?>
	</div>
</div>