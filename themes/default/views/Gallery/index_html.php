<div>
	<H1><?php print _t("Featured Galleries"); ?></H1>
<?php
	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax
?>
		<div class="row"><div class='col-md-8 col-md-offset-2 col-small-12'>
			<div id="gallerySetInfo">
				set info here
			</div><!-- end gallerySetInfo -->
		</div><!-- end col --></div><!-- end row -->
		<p><p>
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					foreach($va_sets as $vn_set_id => $va_set){
						if(!$vn_first_set_id){
							$vn_first_set_id = $vn_set_id;
						}
						$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
						print "<li><div class='galleryItem'><a href='#' onclick='jQuery(\"#gallerySetInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetInfo', array('set_id' => $vn_set_id))."\"); return false;'>".$va_first_item["representation_tag"]."<br/>".$va_set["name"]."</a></div></li>";
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if(sizeof($va_sets) > 1){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
			<a href="#" class="jcarousel-control-next">&rsaquo;</a>
		
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
					
				
			});
			jQuery(document).ready(function() {		
				jQuery("#gallerySetInfo").load("<?php print caNavUrl($this->request, '*', 'Gallery', 'getSetInfo', array('set_id' => $vn_first_set_id)); ?>");
			});
		</script>
<?php
	}
?>
</div>