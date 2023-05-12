<?php
	$va_set_item = $this->getVar("set_item");
	$vs_rep = $va_set_item["representation_tag"];
	if(!$vs_rep){
		$vs_rep = "<div class='galleryPlaceholder'>".caGetThemeGraphic($this->request, 'eye.png', array("alt" => "No media available"))."</div>";
	}
?>
<div class="row">
	<div class='col-xs-12 col-sm-6'>
		<?php print caNavLink($this->request, $vs_rep, "", "", "Gallery", $this->getVar("set_id")); ?>
		<div class="caption"><?php print $va_set_item["set_item_label"]; ?></div>
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-6'>
<?php
		print "<H2>".caNavLink($this->request, $this->getVar("label"), "", "", "Gallery", $this->getVar("set_id"))."</H2>";
		print "<p><small class='uppercase'>".$this->getVar("num_items")." ".(($this->getVar("num_items") == 1) ? _t("item") : _t("items"))."</small></p>";
		print "<p>".$this->getVar("description")."</p>";
		
		print "<br/>".caNavLink($this->request, "<span class='glyphicon glyphicon-th-large' aria-label='View gallery'></span> "._t("view"), "btn btn-default", "", "Gallery", $this->getVar("set_id"));
?>
	</div><!-- end col -->
</div><!-- end col --></div><!-- end row -->