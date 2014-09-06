<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$t_item = $this->getVar("item");
	$ps_view = $this->request->getParameter("view", pString);	#works, exhibitions, bio
	if(!$ps_view){
		$ps_view = "works";
	}
	# --- rep id of related image to cue slideshow to
	$pn_representation_id = $this->request->getParameter("id", pInteger);
	# --- get related object_ids in array
	$va_objects = $t_item->get("ca_objects", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	$va_object_ids = array();
	if(is_array($va_objects) && sizeof($va_objects)){
		foreach($va_objects as $va_object){
			$va_object_ids[] = $va_object["object_id"];
		}
	}
?>	
	<div class="row contentbody_sub">

		<div class="col-sm-3 subnav">
			<H5><?php print $t_item->get("ca_entity_labels.displayname"); ?></H5>	
			<ul>
				<li<?php print ($ps_view == "works") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Selected Works"), '', 'ca_entities', $t_item->get("entity_id"), null, null, array("type_id" => $t_item->get("type_id"))); ?></li>
				<li<?php print ($ps_view == "exhibitions") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Exhibitions"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "exhibitions"), null, array("type_id" => $t_item->get("type_id"))); ?></li>
				<li<?php print ($ps_view == "bio") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Biography"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "bio"), null, array("type_id" => $t_item->get("type_id"))); ?></li>
				<li><?php print caNavLink($this->request, _t("Request Information"), "", "", "Contact", "Form"); ?></li>
			</ul>
		</div>
			
		<div class="col-sm-9 subnavOffset">			
			<div class="row">
				<div class="col-sm-12">
<?php			
		switch($ps_view){	
			case "bio":
?>		
			<div class="row">
				<div class="col-sm-7">
					<?php print $t_item->get("display_bio"); ?>
				</div><!-- end col -->
				<div class="col-sm-4 col-sm-offset-1">
					{{{<ifcount code="ca_objects" min="1">
						<unit relativeTo="ca_objects" delimiter=" " restrictToRelationshipTypes="creator_website">
							<div class="thumbnail">^ca_object_representations.media.medium
							<div class="caption">^ca_objects.caption</div>
							</div>
						</unit>
					</ifcount>}}}
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			break;
			# -------------------------------------------------------------------------------
			case "exhibitions":
?>		
			<div class="row">
				<div class="col-sm-7">
<?php
				$va_exhibitions = $t_item->get("ca_occurrences", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("exhibited"), "sort" => array("ca_occurrences.opening_closing"), "sortDirection" => "desc"));
				$t_occurrence = new ca_occurrences();
				if(sizeof($va_exhibitions) > 0){
					foreach($va_exhibitions as $va_exhibition){
						$t_occurrence->load($va_exhibition["occurrence_id"]);
						print "<h2>".caDetailLink($this->request, $t_occurrence->get("ca_occurrences.preferred_labels.name"), '', 'ca_occurrences', $va_exhibition["occurrence_id"], null, null, array("type_id" => $t_occurrence->get("ca_occurrences.type_id")))."</h2>";
						print "<h2>".$t_occurrence->get("ca_occurrences.exhibition_subtitle")."</h2>";
						print "<h4>".$t_occurrence->get("ca_occurrences.opening_closing")."</h4>";
						print "<br/>";
					}
				}else{
					print "<h2>No exhibitions</h2>";
				}
?>
				</div><!-- end col -->
				<div class="col-sm-4 col-sm-offset-1">
					{{{<ifcount code="ca_objects" min="1">
						<unit relativeTo="ca_objects" delimiter=" " restrictToRelationshipTypes="creator_website">
							<div class="thumbnail">^ca_object_representations.media.medium
							<div class="caption">^ca_objects.caption</div>
							</div>
						</unit>
					</ifcount>}}}
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			break;
			# ----------------------------------------------
			case "works":
			default:
				$q_objects = caMakeSearchResult('ca_objects', $va_object_ids);
				if($q_objects->numHits()){
					$vn_i = 1;
?>
					<div class="jcarousel-wrapper">
						<!-- Carousel -->
						<div class="jcarousel">
							<ul>
<?php
							while($q_objects->nextHit()){
?>
								<li id="slide<?php print $q_objects->get("object_id"); ?>">
									<div class="thumbnail">
										<?php print $q_objects->get("ca_object_representations.media.mediumlarge"); ?>
										<div class="caption text-center captionSlideshow">(<?php print $vn_i."/".$q_objects->numHits(); ?>)<br/><?php print $q_objects->get("ca_objects.caption"); ?></div>
									</div><!-- end thumbnail -->
								</li>
<?php
								$vn_i++;
							}
?>
							</ul>
						</div><!-- end jcarousel -->
<?php
					if($q_objects->numHits() > 1){
?>
						<a href="#" class="jcarousel-control-prev"><i class="fa fa-long-arrow-left"></i></a>
						<a href="#" class="jcarousel-control-next"><i class="fa fa-long-arrow-right"></i></a>
<?php
					}
?>
					</div><!-- end jcarousel-wrapper -->
<?php
					if($q_objects->numHits() > 0){
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
						if($pn_object_id){
?>
							$('.jcarousel').jcarousel('scroll', $('#slide<?php print $pn_object_id; ?>'));
<?php
						}
?>
						});
					</script>
<?php
					}
				}
			break;
			# -------------------------------------------------------------------------------
			case "thumbnails":
?>
				<div class="row">
<?php
				$q_objects = caMakeSearchResult('ca_objects', $va_object_ids);
				if($q_objects->numHits()){
					while($q_objects->nextHit()){
						print "<div class='col-xs-4 col-sm-4 gridImg'>".caDetailLink($this->request, $q_objects->get("ca_object_representations.media.thumbnail300square"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "images", "id" => $q_objects->get("object_id")), null, array("type_id" => $t_item->get("type_id")))."</div>";
					}
				}
?>
				</div><!-- end row -->
<?php
			break;
			# -------------------------------------------------------------------------------
		}
		if(in_array($ps_view, array("works", "thumbnails"))){
?>
			<div id="imageNav">
<?php
				print caDetailLink($this->request, _t("slideshow"), (($ps_view == "works") ? "active" : ""), 'ca_entities', $t_item->get("entity_id"), array("view" => "works"), null, array("type_id" => $t_item->get("type_id")))." | ".caDetailLink($this->request, _t("thumbnails"), (($ps_view == "thumbnails") ? "active" : ""), 'ca_entities', $t_item->get("entity_id"), array("view" => "thumbnails"), null, array("type_id" => $t_item->get("type_id")));
?>
			</div>
<?php
		}
?>
				</div><!--end col-sm-12-->
			</div><!--end row-->
		</div><!--end col-sm-9-->
		<div class="row">
			<div class="col-sm-3 btmsubnav">
				<H5><?php print $t_item->get("ca_entity_labels.displayname"); ?></H5>	
				<ul>
					<li<?php print ($ps_view == "works") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Selected Works"), '', 'ca_entities', $t_item->get("entity_id"), null, null, array("type_id" => $t_item->get("type_id"))); ?></li>
					<li<?php print ($ps_view == "exhibitions") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Exhibitions"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "exhibitions"), null, array("type_id" => $t_item->get("type_id"))); ?></li>
					<li<?php print ($ps_view == "bio") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Biography"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "bio"), null, array("type_id" => $t_item->get("type_id"))); ?></li>
					<li><?php print caNavLink($this->request, _t("Request Information"), "", "", "Contact", "Form"); ?></li>
				</ul>			
			</div><!-- end col -->
		</div><!-- end row -->				
	</div><!--end row contentbody-->
	
