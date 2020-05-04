<?php
	$va_set_item = $this->getVar("set_item");
	$va_set_id = $this->getVar("set_id");
	$t_set = new ca_sets($va_set_id);
	$vs_set_theme = $t_set->get('ca_sets.set_theme', array('convertCodesToDisplayText' => true));
?>
<div class="row">
	<div class='col-xs-12 col-sm-6'>
<?php 	
			if ($vs_set_theme == "Theme guided slideshow") {
				print caNavLink($this->request, $va_set_item["representation_tag"], "", "", "Gallery", $this->getVar("set_id"), array('theme' => 1)); 
			} else {
				print caNavLink($this->request, $va_set_item["representation_tag"], "", "", "Gallery", $this->getVar("set_id")); 
			}
?>
		<div class="caption"><?php print $va_set_item["set_item_label"]; ?></div>
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-6'>
<?php
	if ($vs_set_theme == "Theme guided slideshow") {
		print "<H4>".caNavLink($this->request, $this->getVar("label"), "setlabel", "", "Gallery", $this->getVar("set_id"), array('theme' => 1))."</H4>";
	} else {
		print "<H4>".caNavLink($this->request, $this->getVar("label"), "setlabel", "", "Gallery", $this->getVar("set_id"))."</H4>";	
	}	
		print "<p><small class='uppercase'>".$this->getVar("num_items")." ".(($this->getVar("num_items") == 1) ? _t("item") : _t("items"))."</small></p>";
		if ($va_set_teaser = $t_set->get('ca_sets.set_teaser')) {
			print "<div class='setItemDescription background'>".$va_set_teaser."</div>";
		}
		print "<div class='setItemDescriptionWrapper'>";
		print "<p class='galleryDescription'>".$this->getVar("description")."</p></div>";
		if ($vs_set_theme == "Theme guided slideshow") {
			print "<br/>".caNavLink($this->request, "<span class='glyphicon glyphicon-th-large'></span>", "", "", "Gallery", $this->getVar("set_id"))."&nbsp;&nbsp;&nbsp;".caNavLink($this->request, _t("view %1", $this->getVar("section_item_name")), "", "", "Gallery", $this->getVar("set_id"), array('theme' => 1));		
		} else {
			print "<br/>".caNavLink($this->request, "<span class='glyphicon glyphicon-th-large'></span>", "", "", "Gallery", $this->getVar("set_id"))."&nbsp;&nbsp;&nbsp;".caNavLink($this->request, _t("view %1", $this->getVar("section_item_name")), "", "", "Gallery", $this->getVar("set_id"));
		}
?>
	</div><!-- end col -->
</div><!-- end col --></div><!-- end row -->