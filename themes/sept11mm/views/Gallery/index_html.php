<div>
<?php
	$t_set = new ca_sets();
	$va_sets = $this->getVar("sets");
	#$va_first_items_from_set = $this->getVar("first_items_from_sets");
	$va_first_items_from_set = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => caGetUserAccessValues($this->request)));
					
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax
?>
		<div class="container">
			<div class="row">
				<div class='col-sm-12'><H1><?php print $this->getVar("section_name"); ?></H1></div>
			</div>
			<div class="row">
				<div class='col-sm-8'>
					<div class="row galleryLinks">
<?php
							$i = 0;
							foreach($va_sets as $vn_set_id => $va_set){
								$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
								print "<div class='col-xs-12 col-sm-6'>";
								$vs_box = "<div class='galleryItem'>
												<div class='galleryItemImg'>".$va_first_item["representation_tag"]."</div>
												<h5>".$va_set["name"]." &raquo;</h5>
												<small>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</small>
											<div style='clear:both;'><!-- empty --></div>
										</div>";
								print caNavLink($this->request, $vs_box, "", "", "Gallery", $vn_set_id);
								print "</div>\n";
								$i++;
							}
?>

					</div><!-- end row -->
				</div><!-- end col -->
				<div class='col-sm-4'>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris dolor purus, facilisis vitae orci at, egestas iaculis turpis. Aliquam ut vestibulum tellus. Nam nec nisi tellus. Phasellus imperdiet risus pulvinar, varius justo sed, egestas turpis. Integer porta tempus lobortis. Ut luctus ac est nec sagittis. Nam aliquam vel ante at blandit. Phasellus neque massa, vulputate a mattis eu, blandit convallis tellus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut dignissim dui quam. Duis interdum mauris eget augue scelerisque elementum. Etiam condimentum nibh eget mi rutrum condimentum.</p>
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
<?php
	}
?>
</div>