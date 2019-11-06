<div class="row"><div class="col-sm-12">
	<H1><?php print $this->getVar("section_name"); ?></H1>
<?php
	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax
?>
		<div class="container">
			<div class="row">
<?php
				if(sizeof($va_sets) > 1){
?>
				<div class='col-sm-12'>
					<div class="jcarousel-wrapper">
						<!-- Carousel -->
						<div class="jcarousel"><div class="card-columns">
<?php
							$i = 0;
							foreach($va_sets as $vn_set_id => $va_set){
								if(!$vn_first_set_id){
									$vn_first_set_id = $vn_set_id;
								}
								if($i == 0){
									print "<div class='card'>";
								}
								$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
								print "<div class='galleryItem'>
											<a href='".caNavUrl($this->request, '', 'Gallery', $vn_set_id)."'>
												<div class='galleryItemImg'>".$va_first_item["representation_tag"]."</div>
												<h4>".$va_set["name"]."</h4>
												<p>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</p>
											</a>
											<div style='clear:both;'><!-- empty --></div>
										</div>\n";
								$i++;
								if($i == 4){
									print "</div>";
									$i = 0;
								}
							}
							if($i){
								print "</div>";
							}
?>
						</div></div><!-- end jcarousel -->
<?php
						if(sizeof($va_sets) > 4){
?>
							<!-- Prev/next controls -->
						<!--	<a href="#" class="galleryPrevious"><i class="fa fa-angle-left"></i></a> -->
							<!-- <a href="#" class="galleryNext"><i class="fa fa-angle-right"></i></a> --->
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