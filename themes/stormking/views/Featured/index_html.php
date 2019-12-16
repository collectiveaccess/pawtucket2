<div class="row"><div class="col-sm-12">
	<H1><?php print $this->getVar("section_name"); ?></H1>
</div></div>
<div class="row"><div class="col-sm-12 front">	
	
	
	
	
	
	
	
	
<?php	
	$va_access_values = caGetUserAccessValues($this->request);
	$o_config = $this->getVar("config");

	$qr_res = $this->getVar("featured_set_results");

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
	$va_themes = $this->getVar("themes");
	if(is_array($va_themes) && sizeof($va_themes)){
		$i = 0;
		foreach($va_themes as $vn_theme_id => $va_theme){
			if($i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4'><div class='featuredItem'>";
			print caNavLink($this->request, $va_theme["media"], "", "", "Featured", "Theme", array("theme_id" => $vn_theme_id));
			print "<div class='featuredItemTitle'>".caNavLink($this->request, $va_theme["name"], "", "", "Featured", "Theme", array("theme_id" => $vn_theme_id))."</div>";
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