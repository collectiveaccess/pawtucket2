<div class="row">
	
<?php
	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	$va_access_values = $this->getVar("access_values");
	$t_set = new ca_sets();
	$va_first_items_from_set = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "wideslide", "checkAccess" => $va_access_values));
					
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax
?>
				<div class='col-sm-12'>
<?php				
				$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/gallery/";
				$vn_filecount = 0;
				$va_files = glob($vs_directory . "*");
				if ($va_files){
				 $vn_filecount = count($va_files);
				}

				print "<div class='bannerImg'>".caGetThemeGraphic($this->request, 'gallery/'.rand(1,$vn_filecount).'.jpg')."</div>";

?>				
					<div class="quote">
						<div class="quoteText">
							<strong>Lines to a Golden Eaglet</strong><br/>
							I would wish you the range of the eaglet's eye<br/>
							And the strength of his wings, that your spirit may fly<br/>
							Over all of life's turmoil, your purpose held high.<br/>
							I would wish you the courage to walk unafraid,<br/>
							Wearing proudly the symbol of your accolade.
						</div>
						<div class="quoteCredit">
							&mdash; Birdsall Otis Edey, National Presidents of Girl Scouts of the USA 1930-1935,<br/>from Builders: Poems by Birdsall Otis Edey, 1940
						</div>
					</div>
					<H1><?php print $this->getVar("section_name"); ?></H1>
				</div><!-- end col -->
<?php
				if(sizeof($va_sets) > 1){
?>
</div><!-- end row -->
<div class="row">	
				

<?php
							$o_datamodel = Datamodel::load();
							$i = 1;
							$i_color = 1;
							foreach($va_sets as $vn_set_id => $va_set){
			#					if(!$vn_first_set_id){
			#						$vn_first_set_id = $vn_set_id;
			#					}
													
								#if ($i == 1) {continue;}
								$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
								$t_set = new ca_sets($vn_set_id);
								# --- if there isn't a rep tag in $va_first_item["representation_tag"], and this isn't an object based set, get the first item from the set and try to get objects linked to it
								if(!$va_first_item["representation_tag"] && ($t_set->get("table_num") != 57)){
									$t_first_set_item = $o_datamodel->getInstanceByTableNum($t_set->get("table_num"), true);
									$t_first_set_item->load($va_first_item["row_id"]);
									$va_first_item["representation_tag"] = $t_first_set_item->getWithTemplate("<unit relativeTo='ca_objects.related' length='1'>^ca_object_representations.media.wideslide</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
								}
								if ($i % 2 == 0) {
									print "<div class='col-sm-6 col-md-12'><div class='container galleryContainer'><div class='galleryItem item".$i_color." row'>
													<div class='col-md-8 col-md-8 noPaddingLeft'><div class='galleryItemImg'>".caNavLink($this->request, $va_first_item["representation_tag"], '', '', 'Gallery', $vn_set_id)."</div></div>
													<div class='col-md-4'><div class='galleryText'><h5>".caNavLink($this->request, $va_set["name"], '', '', 'Gallery', $vn_set_id)."</h5>
													<p class='setDesc'>".(strlen($t_set->get('ca_sets.set_description')) > 190 ? substr($t_set->get('ca_sets.set_description'), 0, 187)."..." : $t_set->get('ca_sets.set_description'))."</p>
													<p class='count'>".caNavLink($this->request, $va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items")), 'smallLink', '', 'Gallery', $vn_set_id)."</p>
													</div></div></div>
											</div></div>\n";
								} else {
									print "<div class='col-sm-6 col-md-12'><div class='container galleryContainer'><div class='galleryItem item".$i_color." row'>
												<div class='col-md-4'><div class='galleryText right'>
													
													<h5>".caNavLink($this->request, $va_set["name"], '', '', 'Gallery', $vn_set_id)."</h5>
													<p class='setDesc'>".(strlen($t_set->get('ca_sets.set_description')) > 190 ? substr($t_set->get('ca_sets.set_description'), 0, 187)."..." : $t_set->get('ca_sets.set_description'))."</p>
													<p class='count'>".caNavLink($this->request, $va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items")), 'smallLink', '', 'Gallery', $vn_set_id)."</p>
												</div></div><!-- end col-4 -->
												<div class='col-md-8 noPaddingRight'>
													<div class='galleryItemImg right'>".caNavLink($this->request, $va_first_item["representation_tag"], '', '', 'Gallery', $vn_set_id)."</div>
												</div><!-- end col-8 -->
												</div><!-- end galleryItem --></div><!-- end container -->
											</div><!-- end col-12 -->\n";								
								}	
								$i++;	
								$i_color++;
								if ($i==5) {
									$i = 1;
								}
								if ($i_color==6) {
									$i_color = 1;
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