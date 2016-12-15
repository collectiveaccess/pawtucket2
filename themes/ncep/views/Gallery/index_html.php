<div>
<?php
	$va_sets = $this->getVar("sets");
	$t_set = new ca_sets();
	if(is_array($va_sets) && sizeof($va_sets)){
?>

			<div class="row">
				<div class='col-sm-4'>
					<div class="detailBox">
						<p>
							Our "Network Picks" are sets of modules specially selected and annotated by the NCEP community—staff, experts, and educators like yourself! Sets may focus on a theme or type of module—for example, climate change or field-based exercises—or can simply be a collection of favorites. Set curators provide a brief overview of each module or component and how they can be used together in the classroom, or for curriculum development.
						</p>
 						<p>
							If you are interested in contributing to Network Picks, please email us at <a href="mailto:ncep@amnh.org">ncep@amnh.org</a>.
						</p>
					</div>
				</div>
				<div class='col-sm-8'>
					<H1><?php print $this->getVar("section_name"); ?></H1>
<?php
				foreach($va_sets as $vn_set_id => $va_set){
					$t_set->load($vn_set_id);
					print "<div class='bResItem'><div class='row'>";
					$vs_thumbnail = $t_set->get("set_image", array("version" => "small"));
					if($vs_thumbnail){
						print "<div class='col-xs-2 col-md-3 galleryIcon'>".$vs_thumbnail."</div>";
						print "<div class='col-xs-10 col-md-9'>";
					}else{
						print "<div class='col-sm-12'>";
					}	
					print "<div class='pull-right'>".caNavLink($this->request, "<i class='fa fa-arrow-circle-right'></i>", "", "", "Gallery", $vn_set_id)."</div>";
					print "<H1>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id)."<H1>
						<div class='bResContent'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("module") : _t("modules"));
					if($vs_description = $t_set->get("set_description")){
						if(strlen($vs_description) > 240){
							$vs_description = mb_substr($vs_description, 0, 240)."...";
						}
						print "<br/><br/>".$vs_description;
					}
					print "</div><!-- end col --></div><!-- end row --></div><!-- end bResContent -->
					</div><!-- end bResItem -->";
					print "<br/>";
				}
?>					
				</div><!-- end col -->
			</div><!-- end row -->
<?php
	}
?>
</div>

