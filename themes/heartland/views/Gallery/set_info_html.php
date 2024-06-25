<?php
	$va_set_item = $this->getVar("set_item");
	$t_set =  $this->getVar('set');
	
	$access_values = caGetUserAccessValues($this->request);
	$items = $t_set->getItems(['checkAccess' => $access_values, 'thumbnailVersions' => ['page']]);

	if(($num_images = (int)$t_set->get('gallery_image_count')) <= 0) {
		$num_items = 1;
	}
	$items = caExtractValuesByUserLocale(array_slice($items, 0, $num_images));

	$images = array_map(function($v) {
		return ['tag' => $v['representation_tag_page'], 'caption' => $v['set_item_label']];
	}, $items);
?>
<div class="row">
	<div class='col-xs-12 col-sm-6'>
<?php
	foreach($images as $image) {
?>
		<?php print caNavLink($this->request, $image['tag'], "", "", "Gallery", $this->getVar("set_id")); ?>
		<div class="caption"><?php print $image["caption"]; ?></div>
<?php
	}
?>
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-6'>
<?php
		print "<H2>".caNavLink($this->request, $this->getVar("label"), "", "", "Gallery", $this->getVar("set_id"))."</H2>";
		print "<p><small class='uppercase'>".$this->getVar("num_items")." ".(($this->getVar("num_items") == 1) ? _t("item") : _t("items"))."</small></p>";
		print "<p>".$this->getVar("description")."</p>";
		
		print "<br/>".caNavLink($this->request, "<span class='glyphicon glyphicon-th-large' aria-label='View gallery'></span> "._t("view %1", $this->getVar("section_item_name")), "btn btn-default", "", "Gallery", $this->getVar("set_id"));
?>
	</div><!-- end col -->
</div><!-- end col --></div><!-- end row -->
