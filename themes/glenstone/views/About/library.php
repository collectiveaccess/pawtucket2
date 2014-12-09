<?php

require_once(__CA_MODELS_DIR__."/ca_sets.php");
$va_access_values = caGetUserAccessValues($this->request);

	if($vs_set_code = $this->request->config->get("featured_library_set")){
	 	AssetLoadManager::register("carousel");
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
		}
		if(is_array($va_item_ids) && sizeof($va_item_ids)){
			$t_object = new ca_objects();
			$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("slideshowsmall"), array('checkAccess' => caGetUserAccessValues($this->request)));
		}
	}
	if($vs_set_code = $this->request->config->get("new_library_set")){
		$t_set_new = new ca_sets();
		$t_set_new->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set_new->get("access"), $va_access_values))){
			$va_item_new_ids = array_keys(is_array($va_tmp = $t_set_new->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
		}
		if(is_array($va_item_ids) && sizeof($va_item_ids)){
			$t_object_new = new ca_objects();
			$va_item_new_media = $t_object_new->getPrimaryMediaForIDs($va_item_new_ids, array("thumbnail"), array('checkAccess' => caGetUserAccessValues($this->request)));
		}
	}	
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
<?php
			if(is_array($va_item_media) && sizeof($va_item_media)){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					foreach($va_item_media as $vn_object_id => $va_media){
						print "<li>".caDetailLink($this->request, $va_media["tags"]["slideshowsmall"], '', 'ca_objects', $vn_object_id)."</li>";
					}  
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if(sizeof($va_item_media) > 1){
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
		<hr>				
		</div><!--end col-sm-12-->
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-8">
			<div class="col-sm-8">
				<h1>Library Advanced Search coming soon.</h1>
			</div>
			<div class="col-sm-4" style='border-left:1px solid #ddd;'>
				<h1>Glenstone Library Resources</h1>
				<h3>Library Databases</h3>
				<p><a href='http://www.jstor.org/' target="_blank">JSTOR</a></p>
				<p><a href='http://www.artstor.org/index.shtml' target="_blank">ARTstor</a></p>
				<p><a href='https://www.worldcat.org/' target="_blank">WorldCat</a></p>
				<h3>Other Museum Library Catalogs</h3>
				<p><a href='https://library.nga.gov/' target="_blank">National Gallery of Art</a></p>
				<p><a href='http://library.phillipscollection.org:8080/?Config=ysm&section=search&term=#section=home' target="_blank">Phillips Collection</a></p>
				<p><a href='http://library.si.edu/research' target="_blank">Smithsonian Libraries</a></p>
				<p><a href='http://arcade.nyarc.org/' target="_blank">New York Art Resources Consortium</a></p>
				<p><a href='http://primo.getty.edu/primo_library/libweb/action/search.do?vid=GRI' target="_blank">Getty Research Institute</a></p>
			</div>
		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;'>
			<h1>New Library Acquisitions</h1>
<?php
		if ($va_item_new_media) {
			foreach($va_item_new_media as $vn_object_id => $va_media){
				print "<div class='newLibrary'>".caDetailLink($this->request, $va_media["tags"]["thumbnail"], '', 'ca_objects', $vn_object_id)."</div>";
			}
		}
?>	
			<div class='clearfix'></div>	
		</div>
</div> <!--end container-->