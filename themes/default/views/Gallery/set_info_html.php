<?php
	$va_set_item = $this->getVar("set_item");
?>
<div class="row">
	<div class='col-xs-6'>
		<?php print $va_set_item["representation_tag"]; ?>
		<br/><small><?php print $va_set_item["set_item_label"]; ?></small>
	</div><!-- end col -->
	<div class='col-xs-6'>
<?php
		print "<H2>".$this->getVar("label")."</H2>";
		print "<p><small class='uppercase'>".$this->getVar("num_items")." ".(($this->getVar("num_items") == 1) ? _t("item") : _t("items"))."</small></p>";
		print "<p>".$this->getVar("description")."</p>";
		print "<br/>".caNavLink($this->request, "<span class='glyphicon glyphicon-th-large'></span>", "", "", "Gallery", $this->getVar("set_id"))."&nbsp;&nbsp;&nbsp;".caNavLink($this->request, _t("view gallery"), "", "", "Gallery", $this->getVar("set_id"));
?>
	</div><!-- end col -->
</div><!-- end col --></div><!-- end row -->