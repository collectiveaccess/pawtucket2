<?php
	$va_set_item = $this->getVar("set_item");
	$t_set = $this->getVar("set");
	$this->opo_config = caGetLightboxConfig();
	$vn_under_review_access = $this->opo_config->get('lightbox_under_review_access');
?>
<div class="row">
	<div class='col-xs-12 col-sm-6'>
		<?php print caNavLink($this->request, $va_set_item["representation_tag"], "", "", "Gallery", $this->getVar("set_id")); ?>
		<div class="caption"><?php print $va_set_item["set_item_label"]; ?></div>
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-6'>
<?php
		if($t_set->get("ca_sets.access") == $vn_under_review_access){
			print "<div class='alert alert-warning' role='alert'>Under review for publication.  Only visable by logged in Administrators.</div>";
		}
		print "<H2>".caNavLink($this->request, $this->getVar("label"), "", "", "Gallery", $this->getVar("set_id"))."</H2>";
		#print "<p><small class='uppercase'>".$this->getVar("num_items")." ".(($this->getVar("num_items") == 1) ? _t("item") : _t("items"))."</small></p>";
		print "<p>".$this->getVar("description")."</p>";
		
		print "<br/>".caNavLink($this->request, "<span class='glyphicon glyphicon-th-large' aria-label='View gallery'></span> "._t("view %1", $this->getVar("section_item_name")), "btn btn-default", "", "Gallery", $this->getVar("set_id"));
?>
	</div><!-- end col -->
</div><!-- end col --></div><!-- end row -->