<?php
	$config = caGetGalleryConfig();
	switch($config->get("landing_page_format")){
		case "grid":

	$t_set = new ca_sets();
	$va_access_values = caGetUserAccessValues($this->request);
 	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	#if(is_array($va_sets) && sizeof($va_sets)){
	#	$va_first_items_from_set = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
	#}
?>
<div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		<H1><?php print $this->getVar("section_name"); ?></H1>
	</div>
</div>
<div class="container"><div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		<div class="row bgDarkBlue featuredCallOut">
			<div class="col-sm-12 col-md-6 featuredHeaderImage">
				<?php print caGetThemeGraphic($this->request, 'gallery_landing.jpg', array("alt" => "Gallery image")); ?>
			</div>
			<div class="col-sm-12 col-md-6 text-center">
				<div class="featuredIntro">
<?php
					if($vs_intro_global_value = $config->get("gallery_intro_text_global_value")){
						if($vs_tmp = $this->getVar($vs_intro_global_value)){
							print $vs_tmp;
						}
					}
?>
				</div>
			</div>
		</div>
		
	</div>
</div></div>
<div class="row">
	<div class="col-sm-12 col-lg-10 col-lg-offset-1">		
		<div class="featuredList">	
<?php	
				$vn_i = 0;
				if(is_array($va_sets) && sizeof($va_sets)){
					foreach($va_sets as $vn_set_id => $va_set){
						if ( $vn_i == 0) { print "<div class='row'>"; } 
						$vs_tmp = "<div class='col-sm-4'>";
						$vs_tmp .= "<div class='featuredTile'>";
						$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
						$vs_image = "";
						if ($vs_image = $va_first_item["representation_tag"]) {
							$vs_tmp .= "<div class='featuredImage'>".$vs_image."</div>";
						}
						
						$vs_tmp .= "<div class='title'>".$va_set["name"]."</div>";	
						$vs_tmp .= "</div>";
						print caNavLink($this->request, $vs_tmp, "", "", "Gallery", $vn_set_id);

						print "</div><!-- end col-4 -->";
						$vn_i++;
						if ($vn_i == 3) {
							print "</div><!-- end row -->\n";
							$vn_i = 0;
						}
					}
					if ($vn_i > 0) {
						print "</div><!-- end row -->\n";
					}
				} else {
					print "No ".$this->getVar("section_name")." available";
				}
?>		
		</div>
	</div>
</div>
		
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
