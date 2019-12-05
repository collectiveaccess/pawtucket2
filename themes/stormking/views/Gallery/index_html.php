<div class="row"><div class="col-sm-12">
	<H1><?php print $this->getVar("section_name"); ?></H1>
</div></div>
<div class="row"><div class="col-sm-12 front">	
	
	
	
	
	
	
	
	
<?php	
	$va_access_values = caGetUserAccessValues($this->request);
	$o_config = caGetGalleryConfig();


 			$vn_featured_set_id = "";
 			$va_featured_ids = array();
 			if($vs_set_code = $o_config->get("featured_set_code")){
 				$t_set = new ca_sets();
 				$t_set->load(array('set_code' => $vs_set_code));
 				$vn_featured_set_id = $t_set->get("ca_sets.set_id");
 				# Enforce access control on set
				if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
					$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
					$qr_res = caMakeSearchResult('ca_objects', $va_featured_ids);
				}
 			}






	$vs_caption_template = $o_config->get("featured_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
	if($qr_res && $qr_res->numHits()){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					while($qr_res->nextHit()){
						if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.large</l>', array("checkAccess" => $va_access_values))){
							print "<li><div class='frontSlide'>".$vs_media;
							$vs_caption = "";
							if(strpos(strToLower($qr_res->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))), "artwork") !== false){
								$vs_caption = $qr_res->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'checkAccess' => $va_access_values, 'delimiter' => ', '));
								if($vs_caption){
									$vs_caption .= "<br/>";
								}
								$vs_caption .= caDetailLink($this->request, ($qr_res->get('ca_objects.preferred_labels') == "Untitled" ? $qr_res->get('ca_objects.preferred_labels') : "<i>".$qr_res->get('ca_objects.preferred_labels')."</i>"), '', 'ca_objects', $qr_res->get('ca_objects.object_id'));
								if ($vs_art_date = $qr_res->get('ca_objects.display_date')) {
									$vs_caption .= ", ".$vs_art_date;
								}
							}else{
								$vs_caption = caDetailLink($this->request, ($qr_res->get('ca_objects.preferred_labels') == "Untitled" ? $qr_res->get('ca_objects.preferred_labels') : "<i>".$qr_res->get('ca_objects.preferred_labels')."</i>"), '', 'ca_objects', $qr_res->get('ca_objects.object_id'));
							}							
							
							if($vs_caption){
								print "<div class='frontSlideCaption'>".$vs_caption."</div>";
							}
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
		<H2>{{{featured_title}}}</H2>
		<H3>
			{{{featured_text}}}
		</H3>
		<HR/>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-md-10 col-md-offset-1">	
	
<?php
	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	$t_set = new ca_sets();
	$va_set_first_items_media = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $va_access_values));
	$va_set_descriptions = $t_set->getAttributeFromSets($o_config->get("gallery_set_description_element_code"), array_keys($va_sets));
	if(is_array($va_sets) && sizeof($va_sets)){
		$i = 0;
		foreach($va_sets as $vn_set_id => $va_set){
			if($vn_featured_set_id == $vn_set_id){
				continue;
			}
			if($i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4'><div class='featuredItem'>";
			$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
			$va_first_item_media = array_shift($va_set_first_items_media[$vn_set_id]);
			$vs_rep = $va_first_item_media["representation_tag"];
			print caNavLink($this->request, $vs_rep, "", "", "Gallery", $vn_set_id);
			print "<div class='featuredItemTitle'>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id)."</div>";
			if($va_tmp = $va_set_descriptions[$vn_set_id]){
				$vs_desc = "";
				$vs_desc = array_pop($va_tmp);
				print "<div>".((mb_strlen($vs_desc) > 160) ? substr(strip_tags($vs_desc), 0, 160)."..." : $vs_desc)."</div>";
			}
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