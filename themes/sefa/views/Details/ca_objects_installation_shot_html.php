<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$t_item = $this->getVar("item");
	
	# --- object id/representation of related image to cue slideshow to
	$pn_object_rep_id = $this->request->getParameter("id", pInteger);
	# --- array of images to display
	$va_images = array();
	
	# --- get all reps since not using media viewer
	$o_representations = $t_item->getRepresentationsAsSearchResult(array("checkAccess" => $va_access_values));	
	if(is_object($o_representations) && $o_representations->numHits()){
		while($o_representations->nextHit()){
			$vs_caption = $o_representations->get("ca_object_representations.preferred_labels.name");
			if(!$vs_caption || ($vs_caption == "[BLANK]")){
				$vs_caption = $t_item->get("ca_objects.caption");
			}
			$va_images[$o_representations->get("representation_id")] = array("image" => $o_representations->get("ca_object_representations.media.mediumlarge", array("alt" => "Installation View of ".$t_item->get("ca_objects.preferred_labels.name"))), "thumbnail" => $o_representations->get("ca_object_representations.media.thumbnail300square"), "id" => $o_representations->get("representation_id"), "label" => $vs_caption);
		}
	}
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Art In Situ: ".$t_item->get("ca_object.preferred_labels.name"));


?>	
<div class="row contentbody artinsitu">
	<div class='col-sm-8'>	
<?php
				if(sizeof($va_images)){
					$vn_i = 1;
?>
					<div class="jcarousel-wrapper">
						<!-- Carousel -->
						<div class="jcarousel">
							<ul>
<?php
							foreach($va_images as $va_image){
								if($va_image["image"]){
?>
									<li id="slide<?php print $va_image["id"]; ?>">
										<div class="thumbnail">
											<?php print $va_image["image"]; ?>
											<div class="caption text-center captionSlideshow"><?php print (sizeof($va_images) > 1) ? "(".$vn_i."/".sizeof($va_images).")<br/>" : ""; ?><?php print $va_image["label"]; ?></div>
										</div><!-- end thumbnail -->
									</li>
<?php
									$vn_i++;
								}
							}
?>
							</ul>
						</div><!-- end jcarousel -->
<?php
					if(sizeof($va_images) > 1){
?>
						<a href="#" class="jcarousel-control-prev"><i class="fa fa-long-arrow-left" aria-label="previous"></i></a>
						<a href="#" class="jcarousel-control-next"><i class="fa fa-long-arrow-right" aria-label="next"></i></a>
<?php
					}
?>
					</div><!-- end jcarousel-wrapper -->
<?php
					if(sizeof($va_images) > 0){
?>
					<script type='text/javascript'>
						jQuery(document).ready(function() {
							/* width of li */
							$('.jcarousel li').width($('.jcarousel').width());
							$( window ).resize(function() { $('.jcarousel li').width($('.jcarousel').width()); });
							/*
							Carousel initialization
							*/
							$('.jcarousel').jcarousel({
								animation: {
									duration: 0 // make changing image immediately
								},
								wrap: 'circular'
							});
					
							// make fadeIn effect
							$('.jcarousel').on('jcarousel:animate', function (event, carousel) {
								$(carousel._element.context).find('li').hide().fadeIn(350);
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

<?php
						if($pn_object_rep_id){
?>
							$('.jcarousel').jcarousel('scroll', $('#slide<?php print $pn_object_rep_id; ?>'));
<?php
						}
?>
						});
					</script>
<?php
					}
				}
?>
	
	</div><!-- end col -->
	<div class='col-sm-4'>
		{{{<ifdef code="ca_objects.preferred_labels.name">
			<h1>^ca_objects.preferred_labels.name</h1>
		</ifdef>}}}
		{{{<ifdef code="ca_objects.description">
			<p>^ca_objects.description</p>
		</ifdef>}}}
		
		{{{<ifcount code="ca_entities" min="2">
			<br/><strong>Artists: </strong>
		</ifcount>}}}
		{{{<ifcount code="ca_entities" min="1" max="1">
			<br/><strong>Artist: </strong>
		</ifcount>}}}
		{{{<ifcount code="ca_entities" min="1">
			<unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit><br/>
		</ifcount>}}}
		
		{{{<ifcount code="ca_occurrences" min="1">
			<unit relativeTo="ca_occurrences" delimiter=" ">
				<br/><h2><l><i><b>^ca_occurrences.preferred_labels.name</b></i></l></h2>
				<ifdef code="ca_occurrences.exhibition_subtitle"><h2>^ca_occurrences.exhibition_subtitle</h2></ifdef>
				<div class='date'>^ca_occurrences.opening_closing</div>
			</unit>
		</ifcount>}}}
	</div><!--end col-sm-4-->				
</div><!--end row contentbody-->
	
