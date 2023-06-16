<?php
	$qr_repositories = $this->getVar("collection_results");
	$va_access_values = $this->getVar("access_values");
?>
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">
			<H1>Collections</H1>
			<div class="row bgTurq">
				<div class="col-sm-12 col-md-6 collectionHeaderImage">
					<?php print caGetThemeGraphic($this->request, 'Collections.jpg', array("alt" => "Collections")); ?>
				</div>
				<div class="col-sm-12 col-md-6 text-center">
					<div class="collectionIntro">{{{collections_intro}}}</div>
					<div class="collectionSearch"><form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'Collections_all'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="collectionSearchInput" placeholder="<?php print _t("Search Collections"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
							</div>
							<button type="submit" class="btn-search" id="collectionSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</form></div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="peopleFeaturedList">
				<div class="row">
					<div class='col-sm-12 col-md-6 col-md-offset-3'>
						<H2>Browse by Repository</H2>
					</div>
				</div>
<?php	
	if($qr_repositories->numHits()) {
		while($qr_repositories->nextHit()) {
				print "\n<div class='row repositoryRow'><div class='col-sm-12 col-md-6 col-md-offset-3'>".caDetailLink($this->request, $qr_repositories->get("ca_collections.preferred_labels"), "", "ca_collections", $qr_repositories->get("ca_collections.collection_id"))."</div></div>";
		}
	}
	print "\n<div class='row repositoryRow'><div class='col-sm-12 col-md-6 col-md-offset-3'><hr/><br/>".caNavLink($this->request, "Browse All Collections <i class='fa fa-arrow-right'></i>", "", "", "Browse", "Collections")."</div></div>";
		
	
?>		
			</div>
		</div>
	</div>
<?php	
	$qr_res = $this->getVar('featured_collections_as_search_result');
	
	if($qr_res && $qr_res->numHits()){
?>
<div class="row"><div class="col-sm-12 col-md-6 col-md-offset-3"><H3 class="featuredItems">Featured Collections</H3>  
		<div class="jcarousel-wrapper featuredItemsSlideShow">
			<!-- Carousel -->
			<div class="jcarousel featured featuredItemsSlide">
				<ul>
<?php
					while($qr_res->nextHit()){
						$vs_media = $qr_res->get("ca_object_representations.media.large", array("checkAccess" => $va_access_values));
						if(!$vs_media){
							$vs_media = $qr_res->getWithTemplate("<unit relativeTo='ca_objects' limit='1'>^ca_object_representations.media.large</unit>", array("checkAccess" => $va_access_values));
						}
						if($vs_media){
							$vs_media = "<div class='featuredItemMedia'>".$vs_media."</div>";
						}
						$vs_description = $qr_res->getWithTemplate("<div class='featuredItemTitle'><l>^ca_collections.preferred_labels.name</l></div>");
						$vs_button = $qr_res->getWithTemplate("<div class='text-center'><l><button class='btn btn-default'>Learn More</button></l></div>");
						print "<li class='bgLightGray'><div class='row'><div class='col-sm-4'>".$vs_media."</div><div class='col-sm-8'>".$vs_description.$vs_button."</div></div></li>";
						$vb_item_output = true;
						
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if($vb_item_output){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev featured"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="jcarousel-control-next featured"><i class="fa fa-angle-right"></i></a>
		
			<!-- Pagination -->
			<p class="jcarousel-pagination featured">
			<!-- Pagination items will be generated in here -->
			</p>
<?php
			}
?>
		</div><!-- end jcarousel-wrapper -->
</div></div>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.featuredItemsSlide li').width($('.featuredItemsSlideShow').width());
				$( window ).resize(function() {
				  $('.featuredItemsSlide li').width($('.featuredItemsSlideShow').width());
				});
				
				$('.jcarousel.featured')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
					$('.jcarousel.featured').jcarouselAutoscroll({
					autostart: false,
					interval: 8000
				});
		
				/*
				 Prev control initialization
				 */
				$('.jcarousel-control-prev.featured')
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
				$('.jcarousel-control-next.featured')
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
				$('.jcarousel-pagination.featured')
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