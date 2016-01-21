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
							Intro text here.  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque euismod lorem in dolor elementum, in commodo libero molestie. Nunc tempor leo eget porttitor molestie. Vivamus commodo nibh lacus, eget efficitur erat molestie id. Phasellus pretium dolor eu massa tristique tincidunt. Donec in ligula commodo, ornare massa id, auctor turpis. Duis sit amet lectus quis arcu accumsan interdum. Donec ultrices ante magna, eu rhoncus justo ultrices in. Fusce vestibulum, nisl vestibulum condimentum pulvinar, turpis leo placerat dolor, sed luctus tortor ligula vel tortor. Praesent pulvinar vitae neque quis hendrerit.						
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

