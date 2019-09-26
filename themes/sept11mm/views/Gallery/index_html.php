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
					<p>
						The collection houses more than 20,000 artifacts, including three-dimensional objects, ephemera, textiles, artwork, and books and manuscripts. On this site, examples of the Museum’s holdings include salvaged remnants of the World Trade Center buildings, personal effects and memorabilia, expressions of tribute and remembrance, and much more.
					</p>
					<p>
						The feature galleries on this page bring together objects based on a variety of themes, material type, scale, and exhibition area. Click on the features to explore more about a topic and browse through related objects in the collection.
					</p>
					<p>
						Features on this page are continually expanded to include a larger representation of the Museum’s holdings. Check back frequently for recently added content.</p> d
					</p>
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
<?php
	}
?>
</div>
