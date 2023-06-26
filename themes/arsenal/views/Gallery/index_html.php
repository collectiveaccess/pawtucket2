<?php
	$config = caGetGalleryConfig();
	global $g_ui_locale;
	switch($config->get("landing_page_format")){
		case "grid":

	$t_set = new ca_sets();
	$va_access_values = caGetUserAccessValues($this->request);
 	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $va_access_values));
					
	$vs_front_page_set = $config->get('front_page_set_code');
	$vb_omit_front_page_set = (bool)$config->get('omit_front_page_set_from_gallery');
	foreach($va_sets as $set_id => $va_set) {
		if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
			unset($va_sets[$set_id]); 
		}
		$first_item = $va_first_items_from_set[$set_id];
		$first_item = array_shift($first_item);
		$vn_item_id = $first_item["item_id"];
		# --- it there isn't a rep and this is not a set of objects, try to get a related object to show something
		if(!$va_first_items_from_set[$set_id][$vn_item_id]["representation_tag"]){
			if(Datamodel::getTableName($va_set['table_num']) != "ca_objects"){
				if (!($t_instance = Datamodel::getInstanceByTableNum($va_set['table_num']))) { throw new ApplicationException(_t('Invalid item')); }
				$t_instance->load($first_item["row_id"]);
				if($vs_thumbnail = $t_instance->getWithTemplate('<unit relativeTo="ca_objects.related" length="1">^ca_object_representations.media.widepreview</unit>', array("checkAccess" => $this->opa_access_values))){
					$va_first_items_from_set[$set_id][$vn_item_id] = array("representation_tag" => $vs_thumbnail);
				}
			}elseif(Datamodel::getTableName($va_set['table_num']) == "ca_objects"){
				if (!($t_instance = Datamodel::getInstanceByTableNum($va_set['table_num']))) { throw new ApplicationException(_t('Invalid item')); }
				$t_instance->load($first_item["row_id"]);
				if($vs_thumbnail = $t_instance->getWithTemplate('<unit relativeTo="ca_occurrences.related" length="1">^ca_object_representations.media.widepreview</unit>', array("checkAccess" => $this->opa_access_values))){
					$va_first_items_from_set[$set_id][$vn_item_id] = array("representation_tag" => $vs_thumbnail);
				}
			}
		}
	}
?>

<div class="row"><div class="col-sm-12">
	<H1><?php print ($g_ui_locale == "en_US") ? $config->get('gallery_section_name') : $config->get('gallery_section_name_german'); ?></H1>
<?php
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax				
			$i = 0;
			foreach($va_sets as $vn_set_id => $va_set){
				$i++;
				if($i == 1){
					print "<div class='row'>";
				}
				print "<div class='col-sm-3 col-md-3 col-lg-2'>";
				$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
				print "<div class='galleryList'>".caNavLink($this->request, $va_first_item["representation_tag"], '', '', 'Gallery', $vn_set_id).
							"<label>".caNavLink($this->request, $va_set["name"], '', '', 'Gallery', $vn_set_id)."</label>
							<div><small class='uppercase'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</small></div>
						</div>\n";
				print "</div><!-- end col -->";
				if($i == 4){
					print "</div><!-- end row -->";
					$i = 0;
				}
			}
			if($i){
				print "</div><!-- end row -->";
			}
	}
?>
</div><!-- end col --></div><!-- end row -->
		
<?php
		break;
		# -------------------------
		default:
		
?>


<div class="row"><div class="col-sm-12">
	<H1><?php print $this->getVar("section_name"); ?></H1>
<?php
	if($vs_intro_global_value = $config->get("gallery_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='setDescription'>".$vs_tmp."</div>";
		}
	}

	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax
?>
		<div class="container">
			<div class="row">
				<div class='col-sm-8'>
					<div id="gallerySetInfo">
						set info here
					</div><!-- end gallerySetInfo -->
				</div><!-- end col -->
<?php
				if(sizeof($va_sets) > 1){
?>
				<div class='col-sm-4'>
					<div class="jcarousel-wrapper">
						<!-- Carousel -->
						<div class="jcarousel"><ul>
<?php
							$i = 0;
							foreach($va_sets as $vn_set_id => $va_set){
								if(!$vn_first_set_id){
									$vn_first_set_id = $vn_set_id;
								}
								if($i == 0){
									print "<li>";
								}
								$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);

								print "<div class='galleryItem'>
											<a href='#' class='galleryItemSetInfoLink' onclick='jQuery(\"#gallerySetInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetInfo', array('set_id' => $vn_set_id))."\"); return false;'>
												<div class='galleryItemImg'>".$va_first_item["representation_tag"]."</div>
												<h3>".$va_set["name"]."</h3>
												<p><small class='uppercase'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</small></p>
											</a>
												".caNavLink($this->request, "<span class='glyphicon glyphicon-th-large' aria-label='View gallery'></span> "._t("view %1", $this->getVar("section_item_name")), "btn btn-default", "", "Gallery", $vn_set_id)."
											<div style='clear:both;'><!-- empty --></div>
										</div>\n";
								$i++;
								if($i == 4){
									print "</li>";
									$i = 0;
								}
							}
							if($i){
								print "</li>";
							}
?>
						</ul></div><!-- end jcarousel -->
<?php
						if(sizeof($va_sets) > 4){
?>
							<!-- Prev/next controls -->
							<a href="#" class="galleryPrevious"><i class="fa fa-angle-left" aria-label="previous"></i></a>
							<a href="#" class="galleryNext"><i class="fa fa-angle-right" aria-label="next"></i></a>
<?php
						}
?>
					</div><!-- end jcarousel-wrapper -->
					<script type='text/javascript'>
						jQuery(document).ready(function() {		
							/* width of li */
							$('.jcarousel li').width($('.jcarousel').width());
							$( window ).resize(function() { $('.jcarousel li').width($('.jcarousel').width()); });
							/*
							Carousel initialization
							*/
							$('.jcarousel')
								.jcarousel({
									// Options go here
								});
					
							/*
							 Prev control initialization
							 */
							$('.galleryPrevious')
								.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
								})
								.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
								})
								.jcarouselControl({
									// Options go here
									target: '-=1'
								});
					
							/*
							 Next control initialization
							 */
							$('.galleryNext')
								.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
								})
								.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
								})
								.jcarouselControl({
									// Options go here
									target: '+=1'
								});
								
							
						});
					</script>
				</div><!-- end col -->
<?php
				}else{
					$va_first_set = array_shift($va_sets);
					$vn_first_set_id = $va_first_set["set_id"];
				}
?>
			</div><!-- end row -->
		</div><!-- end container -->
		<script type='text/javascript'>
			jQuery(document).ready(function() {		
				jQuery("#gallerySetInfo").load("<?php print caNavUrl($this->request, '*', 'Gallery', 'getSetInfo', array('set_id' => $vn_first_set_id)); ?>");
			});
		</script>
<?php
	}
?>
</div><!-- end col --></div><!-- end row -->
<?php
		break;
	}
?>
