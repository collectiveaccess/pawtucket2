<?php
	$va_access_values = $this->getVar("access_values");
	$va_featured_ids = $this->getVar('featured_set_item_ids');
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$t_set = $this->getVar("featured_set");
?>
<div class="row">
	<div class="col-sm-12">
<?php
	if($qr_res && $qr_res->numHits()){
?>   
		<div class="front"><div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					$va_tmp = array();
					while($qr_res->nextHit()){
						$vs_tmp = "";
						if($vs_media = $qr_res->getWithTemplate('<l><unit relativeTo="ca_objects" length="1">^ca_object_representations.media.large</unit></l>', array("checkAccess" => $va_access_values))){
							$vs_tmp = "<li><div class='frontSlide'>".$vs_media;
							$vs_caption = $qr_res->getWithTemplate("<l>^ca_entities.preferred_labels.displayname</l>");
							if($vs_caption){
								$vs_tmp .= "<div class='frontSlideCaption'>".$vs_caption."</div>";
							}
							$vs_tmp .= "</div></li>";
							$vb_item_output = true;
							$va_tmp[] = $vs_tmp;
						}
					}
					if(is_array($va_tmp) && sizeof($va_tmp)){
						shuffle($va_tmp);
						print join("\n", $va_tmp);
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if($vb_item_output){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left" aria-label="<?php print _t("Previous"); ?>"></i></a>
			<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right" aria-label="<?php print _t("Next"); ?>"></i></a>
		
			<!-- Pagination -->
			<p class="jcarousel-pagination">
			<!-- Pagination items will be generated in here -->
			</p>
<?php
			}
?>
		</div><!-- end jcarousel-wrapper --></div>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.jcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
				$('.jcarousel').jcarouselAutoscroll({
					autostart: true
				});
		
				/*
				 Prev control initialization
				 */
				$('.jcarousel-control-prev')
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
				$('.jcarousel-control-next')
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
		
				/*
				 Pagination initialization
				 */
				$('.jcarousel-pagination')
					.on('jcarouselpagination:active', 'a', function() {
						$(this).addClass('active');
					})
					.on('jcarouselpagination:inactive', 'a', function() {
						$(this).removeClass('active');
					})
					.jcarouselPagination({
						// Options go here
					});
			});
		</script>
<?php
	}
?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 text-center">
		<H1><?php print caGetThemeGraphic($this->request, 'leaf_left_black.jpg', array("alt" => "leaf detail", "class" => "imgLeft")); ?><?php print $t_set->getLabelForDisplay(); ?><?php print caGetThemeGraphic($this->request, 'leaf_right_black.jpg', array("alt" => "leaf right detail", "class" => "imgRight")); ?></H1>	
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-md-8 col-md-offset-2">
<?php
		if($vs_intro = $t_set->get("ca_sets.description")){
			print "<p class='introduction text-center'>".$vs_intro."</p>";
		}
$qr_res->seek(0);
		if($qr_res && $qr_res->numHits()){
			$i = 0;
			while($qr_res->nextHit()){
				if($i == 0){
					print "<div class='row'>";
				}
				$vs_media = $qr_res->getWithTemplate('<l><unit relativeTo="ca_objects" length="1">^ca_object_representations.media.iconlarge</unit></l>', array("checkAccess" => $va_access_values));
?>
				<div class="col-sm-12 col-md-6">
					<div class="exhibitionItem">
						<div class="row exhibitionItemRow">
							<div class="col-xs-4">
								<div class="exhibitionItemImage"><?php print $vs_media; ?></div>
							</div>
							<div class="col-xs-8">
								<div class="exhibitionItemText"><?php print $qr_res->getWithTemplate("<l>^ca_entities.preferred_labels.displayname</l>"); ?></div>
							</div>
						</div>
					</div>
				</div><!-- end col -->
<?php
				$i++;
				if($i == 2){
					print "</div><!-- end row -->";
					$i = 0;
				}
			}
			if($i > 0){
				print "</div><!-- end row -->";
			}
			print "</div><!-- end row -->";
		}
?>
		
	</div>
</div>

