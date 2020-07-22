<div class="row"><div class="col-sm-12">
	<H1><?php print $this->getVar("archives_section_name"); ?></H1>
</div></div>
<div class="row"><div class="col-sm-12 front">	
<?php	
	$va_access_values = caGetUserAccessValues($this->request);
	$o_config = $this->getVar("config");

	$va_featured_sets = $this->getVar("featured_sets");
	if($x && is_array($va_featured_sets) && sizeof($va_featured_sets)){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
			foreach($va_featured_sets as $vn_set_id => $va_featured_set){
						if($vs_media = $va_featured_set["imageLarge"]){
							print "<li><div class='frontSlide'>".caNavLink($this->request, $vs_media, "", "", "Featured", "Detail", array("set_id" => $vn_set_id, "setMode" => "archives"));
							print "<div class='frontSlideCaption'>".caNavLink($this->request, $va_featured_set["title"], "", "", "Featured", "Detail", array("set_id" => $vn_set_id, "setMode" => "archives"))."</div>";
							print "</div></li>";
							$vb_item_output = true;
						}
		
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if($vb_item_output){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		
			<!-- Pagination -->
			<p class="jcarousel-pagination">
			<!-- Pagination items will be generated in here -->
			</p>
<?php
			}
?>
		</div><!-- end jcarousel-wrapper -->
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.jcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular',
						
						animation: {
							duration: 400,
							easing:   'linear',
							
						}						
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
					*/
			});
		</script>
<?php
	}
?>	
	
</div></div>
<div class="row">
	<div class="col-sm-12">
		<H2>{{{archives_featured_title}}}</H2>
		<H3>
			{{{archives_featured_text}}}
		</H3>
		<HR/>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-md-10 col-md-offset-1">	
	
<?php
	if(is_array($va_featured_sets) && sizeof($va_featured_sets)){
		$i = 0;
		foreach($va_featured_sets as $vn_set_id => $va_featured_set){
			if($i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4'><div class='featuredItem'>";
			print caNavLink($this->request, $va_featured_set["imageWidePreview"], "", "", "Featured", "Detail", array("set_id" => $vn_set_id, "setMode" => "archives"));
			print "<div class='featuredItemTitle'>".caNavLink($this->request, $va_featured_set["title"], "", "", "Featured", "Detail", array("set_id" => $vn_set_id, "setMode" => "archives"))."</div>";
			print "</div></div>";
			$i++;
			if($i == 3){
				print "</div>";
				$i = 0;
			}
		}
		if($i){
			print "</div>";
		}
	}
	
	
?>
</div></div>