<?php
	$this->setVar('list_code', $vs_list_code = $this->getVar('config')->get('front_page_toc_list_code_CJF'));
	
	print $this->render("Front/toc_functions_html.php"); 
	if ($this->request->isAjax()) { return; }
?>
<div id="frontPage" class="subhomeslide">
<?php

	$va_access_values = caGetUserAccessValues($this->request);
	$this->config = caGetFrontConfig();
	if($vs_set_code = $this->config->get("front_page_set_code_CJF")){
 		$t_set = new ca_sets();
 		$t_set->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
		}
 	}
	if(is_array($va_item_ids) && sizeof($va_item_ids)){
		$t_object = new ca_objects();
		$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("mediumlarge"), array('checkAccess' => $va_access_values));
		$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
	}
	if(is_array($va_item_media) && sizeof($va_item_media)){
?>   
		<div class="jcarousel-wrapper slidecontainer">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					foreach($va_item_media as $vn_object_id => $va_media){
						print "<li>".caDetailLink($this->request, $va_media["tags"]["mediumlarge"], '', 'ca_objects', $vn_object_id)."</li>";
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if(sizeof($va_item_media) > 1){
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

		<div class="container"><div class="container"><div class="row">
			<div class="col-sm-3 subintro"><?php print caGetThemeGraphic($this->request, "cjflogo_int.png", array("width" => 200)); ?></div>     
			<div class="col-sm-9 subintro">The Cincinnati Judaica Fund is dedicated to the preservation and use of historic Judaica for educational purposes. </div>      
		</div><!-- end row --></div><!-- end container --></div><!-- end container -->
	</div><!-- end subhomeslide -->
<?php 
	print $this->render("Front/toc_html.php"); 
?>
	</div> <!--end container subhomebody-->	