<div class="row"><div class="col-sm-12">
	<H1><?php print $this->getVar("section_name"); ?></H1>
<?php
	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax
?>
		<div class="container">
			
<?php
				if(sizeof($va_sets) > 1){
					foreach($va_sets as $vn_set_id => $va_set){
						$t_set = new ca_sets($va_set['set_id']);
						$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
						print "<div class='row featured gray'>
							<div class='col-sm-4'><div class='galleryItemImg'>".caNavLink($this->request, $va_first_item["representation_tag"], '', '', 'Gallery', $va_set['set_id'])."</div></div>
								<div class='col-sm-8'><h1>".caNavLink($this->request, $va_set["name"], '', '', 'Gallery', $va_set['set_id'])."</h1>";
								print "<p>".$t_set->get('ca_sets.set_description').'</p>';
								print caNavLink($this->request, "<div class='homeLink'>View ".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))." <i class='fa fa-arrow-right'></i></div>", '', '', 'Gallery', $va_set['set_id']);
							print "</div></div>\n";
					}
				}
?>
		</div><!-- end container -->

<?php
	}
?>
</div><!-- end col --></div><!-- end row -->