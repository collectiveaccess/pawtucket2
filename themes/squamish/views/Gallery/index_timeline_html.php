<?php
	$config = caGetGalleryConfig();
	$vs_title = "";
	$vs_landing_page_format = "";
	$vs_set_type = $this->getVar("set_type");
	$vn_set_id_to_show = $this->getVar("set_id");
	$t_set = $this->getVar("set");
		
	
?>

			<div class="row bg_dark_eye pageHeaderRow">
				<div class="col-sm-12">
					<H1>Timelines</H1>
<?php
					if($vs_intro_global_value = $config->get("gallery_intro_text_global_value_".$vs_set_type)){
						if($vs_tmp = $this->getVar($vs_intro_global_value)){
							print "<p>".$vs_tmp."</p>";
						}
					}
?>
				</div>
			</div>
			<div class="row"><div class="col-sm-12">
<?php

				$va_sets = $this->getVar("sets");
				$va_first_items_from_set = $this->getVar("first_items_from_sets");
				if(is_array($va_sets) && sizeof($va_sets)){
					# --- main area with info about selected set loaded via Ajax
?>
					<div class="container">
						<div class="row">
							<div class='col-sm-9'>
								<div id="gallerySetInfo">
									set info here
								</div><!-- end gallerySetInfo -->
							</div><!-- end col -->
							<div class='col-sm-3'>
								<div class="jcarousel-wrapper">
									<!-- Carousel -->
									<div class="jcarousel"><ul>
<?php
										$i = 0;
										foreach($va_sets as $vn_set_id => $va_set){
											if(!$vn_set_id_to_show){
												$vn_set_id_to_show = $vn_set_id;
											}
											if($i == 0){
												print "<li>";
											}
											$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);

											print "<div class='galleryItem".(($vn_set_id_to_show == $vn_set_id) ? " selected" : "")."'>
														".caNavLink($this->request, "<h3>".$va_set["name"]."</h3>
															<p><small class='uppercase'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</small></p>
														", "", "", "Gallery", "Index", array("set_type" => "timelines", "set_id" => $vn_set_id))."<div style='clear:both;'><!-- empty --></div>
													</div>\n";
											$i++;
											if($i == 6){
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
									if(sizeof($va_sets) > 6){
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
						</div><!-- end row -->
					</div><!-- end container -->
					<script type='text/javascript'>
						jQuery(document).ready(function() {		
							jQuery("#gallerySetInfo").load("<?php print caNavUrl($this->request, '', 'Gallery', $vn_set_id_to_show); ?>");
						});
					</script>
<?php
				}
?>
			</div><!-- end col --></div><!-- end row -->
