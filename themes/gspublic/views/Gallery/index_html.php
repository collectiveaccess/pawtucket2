<div class="row">
	
<?php
	$va_sets = $this->getVar("sets");
	#$va_first_items_from_set = $this->getVar("first_items_from_sets");
	$va_access_values = $this->getVar("access_values");
	$t_set = new ca_sets();
	$va_first_items_from_set = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "wideslide", "checkAccess" => $va_access_values));
					
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax
?>

				<div class='col-sm-12'>
<?php				
					print "<div class='bannerImg'>".caGetThemeGraphic($this->request, 'gallery.png')."</div>";
?>				
					<H1><?php print $this->getVar("section_name"); ?></H1>
					<p style="margin-bottom:35px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc fermentum in mi pellentesque ornare. Mauris bibendum ipsum nec massa pharetra, consectetur tempor felis elementum. Fusce nec magna sodales, convallis sem id, tempus libero. Proin gravida ut neque eget vehicula. Aliquam pulvinar arcu sit amet viverra imperdiet. Nullam semper risus nec dapibus efficitur. Praesent a justo ut lorem luctus aliquet. Quisque ac felis eleifend, varius eros eu, tincidunt sapien. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec sagittis orci cursus sagittis viverra. Nunc non rhoncus magna. Maecenas iaculis scelerisque tellus, ut rhoncus lectus ornare a. Fusce in leo et magna maximus hendrerit eleifend id dui.</p>
					<!--<div id="gallerySetInfo">
						set info here
					</div>-->
				</div><!-- end col -->
<?php
				if(sizeof($va_sets) > 1){
?>
			</div><!-- end row -->
			<div class="row">	
				

<?php
							$i = 1;
							foreach($va_sets as $vn_set_id => $va_set){
			#					if(!$vn_first_set_id){
			#						$vn_first_set_id = $vn_set_id;
			#					}
													
								#if ($i == 1) {continue;}
								$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
								$t_set = new ca_sets($vn_set_id);
								if ($i % 2 == 0) {
									print "<div class='col-sm-12'><div class='container galleryContainer'><div class='galleryItem item".$i." row'>
													<div class='col-sm-8' style='padding-left:0px;'><div class='galleryItemImg'>".caNavLink($this->request, $va_first_item["representation_tag"], '', '', 'Gallery', $vn_set_id)."</div></div>
													<div class='col-sm-4'><div class='galleryText'><h5>".caNavLink($this->request, $va_set["name"], '', '', 'Gallery', $vn_set_id)."</h5>
													<p class='setDesc'>".(strlen($t_set->get('ca_sets.set_description')) > 210 ? substr($t_set->get('ca_sets.set_description'), 0, 207)."..." : $t_set->get('ca_sets.set_description'))."</p>
													<p class='count'>".caNavLink($this->request, $va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items")), 'smallLink', '', 'Gallery', $vn_set_id)."</p>
													</div></div></div>
											</div></div>\n";
								} else {
									print "<div class='col-sm-12'><div class='container galleryContainer'><div class='galleryItem item".$i."'>
												<div class='col-sm-4'><div class='galleryText right'>
													
													<h5>".caNavLink($this->request, $va_set["name"], '', '', 'Gallery', $vn_set_id)."</h5>
													<p class='setDesc'>".(strlen($t_set->get('ca_sets.set_description')) > 210 ? substr($t_set->get('ca_sets.set_description'), 0, 207)."..." : $t_set->get('ca_sets.set_description'))."</p>
													<p class='count'>".caNavLink($this->request, $va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items")), 'smallLink', '', 'Gallery', $vn_set_id)."</p>
												</div></div><!-- end col-4 -->
												<div class='col-sm-8' style='padding-right:0px;'>
													<div class='galleryItemImg right'>".caNavLink($this->request, $va_first_item["representation_tag"], '', '', 'Gallery', $vn_set_id)."</div>
												</div><!-- end col-8 -->
												<div style='clear:both;width:100%'></div>
												</div><!-- end galleryItem --></div><!-- end container -->
											</div><!-- end col-12 -->\n";								
								}	
								$i++;
								if ($i==5) {
									$i = 1;
								}				
							}


				}else{
					$va_first_set = array_shift($va_sets);
					$vn_first_set_id = $va_first_set["set_id"];
				}
?>

<!--		<script type='text/javascript'>
			jQuery(document).ready(function() {		
				jQuery("#gallerySetInfo").load("<?php print caNavUrl($this->request, '*', 'Gallery', 'getSetInfo', array('set_id' => $vn_first_set_id)); ?>");
			});
		</script> -->
<?php
	}
?>
</div><!-- end row -->