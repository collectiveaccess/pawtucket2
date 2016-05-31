<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$t_item = $this->getVar("item");
	$ps_view = $this->request->getParameter("view", pString);
	if(!$ps_view){
		$ps_view = "info";
	}
	# --- object id/representation of related image to cue slideshow to
	$pn_object_rep_id = $this->request->getParameter("id", pInteger);
	# --- array of images to display
	$va_images = array();
	# --- get related object_ids in array
	$va_objects = $t_item->get("ca_objects", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("used_website", "used")));
	$va_object_ids = array();
	if(is_array($va_objects) && sizeof($va_objects)){
		foreach($va_objects as $va_object){
			$va_object_ids[] = $va_object["object_id"];
		}
		if(in_array($ps_view, array("images", "thumbnails"))){
			$q_objects = caMakeSearchResult('ca_objects', $va_object_ids);
			if($q_objects->numHits()){
				while($q_objects->nextHit()){
					$va_images[$q_objects->get("object_id")] = array("image" => $q_objects->get("ca_object_representations.media.mediumlarge"), "thumbnail" => $q_objects->get("ca_object_representations.media.thumbnail300square"), "id" => $q_objects->get("object_id"), "label" => sefaFormatCaption($this->request, $q_objects));
				}
			}
		}
	}
	# --- representations are installation shots
	$o_representations = $t_item->getRepresentationsAsSearchResult(array("checkAccess" => $va_access_values));
	if(in_array($ps_view, array("installations", "installationThumbnails"))){
		if(is_object($o_representations) && $o_representations->numHits()){
			while($o_representations->nextHit()){
				$va_images[$o_representations->get("representation_id")] = array("image" => $o_representations->get("ca_object_representations.media.mediumlarge"), "thumbnail" => $o_representations->get("ca_object_representations.media.thumbnail300square"), "id" => $o_representations->get("representation_id"), "label" => ($o_representations->get("ca_object_representations.preferred_labels.name") == "[BLANK]") ? "" : $o_representations->get("ca_object_representations.preferred_labels.name"));
			}
		}
	}
	# --- get related object_id of catalog
	$vn_catalog_id = $t_item->get("ca_objects.object_id", array("checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("related"), "restrictToTypes" => array("catalog"), "limit" => 1));

?>	
	<div class="row contentbody_sub">

		<div class="col-sm-3 subnav">
<?php 
			print $this->render("SubNav/exhibitions_html.inc");
?>
		</div>
			
		<div class="col-sm-9">			
			<div class="row">
				<div class="col-sm-12">
					<ul class="nav nav-pills">
<?php
						print "<li".(($ps_view == "info") ? " class='active'" : "").">".caDetailLink($this->request, _t("exhibition main"), '', 'ca_occurrences', $t_item->get("occurrence_id"), null, null, array("type_id" => $t_item->get("type_id")))."</li>";
						if(sizeof($va_object_ids) > 1){
							print "<li".((in_array($ps_view, array("images", "thumbnails"))) ? " class='active'" : "").">".caDetailLink($this->request, _t("works"), '', 'ca_occurrences', $t_item->get("occurrence_id"), array("view" => "images"), null, array("type_id" => $t_item->get("type_id")))."</li>";
						}
						if(is_object($o_representations) && $o_representations->numHits()){
							print "<li".((in_array($ps_view, array("installations", "installationThumbnails"))) ? " class='active'" : "").">".caDetailLink($this->request, _t("installation views"), '', 'ca_occurrences', $t_item->get("occurrence_id"), array("view" => "installations"), null, array("type_id" => $t_item->get("type_id")))."</li>";
						}
						if($vs_pr_link = $t_item->get("press_release", array("version" => "original", "return" => "url"))){
?>
							<li><a href="<?php print $vs_pr_link; ?>">press release</a></li>	
<?php
						}
						if($vn_catalog_id){
							print "<li>".caDetailLink($this->request, _t("catalog"), '', 'ca_objects', $vn_catalog_id, null, null)."</li>";
						}
?>
					</ul>
			
				</div><!--end col-sm-12-->
			</div><!--end row-->
			<div class="row">
				<div class="col-sm-12">
<?php			
		switch($ps_view){	
			case "info":
			default:
?>		
			
			<div class="thumbnail thumbnailImgLeft">
<?php
				$va_objects = $t_item->get("ca_objects", array("restrictToRelationshipTypes" => array("used_website"), "returnWithStructure" => true, "checkAccess" => $va_access_values));
				foreach($va_objects as $va_object){
					$t_object = new ca_objects($va_object["object_id"]);
					print $t_object->get("ca_object_representations.media.mediumlarge");
?>
					<div class="caption"><?php print sefaFormatCaption($this->request, $t_object); ?></div>
<?php
				}
?>
			</div> <!--end thumbnail-->
				<p>
					<h1>{{{ca_occurrences.preferred_labels.name}}}</h1>
					{{{<ifdef code="ca_occurrences.exhibition_subtitle">
						<h2>^ca_occurrences.exhibition_subtitle</h2>
					</ifdef>}}}
					<h4>{{{^ca_occurrences.opening_closing}}}{{{<ifdef code="ca_occurrences.opening_reception"> | Opening Reception: ^ca_occurrences.opening_reception</ifdef>}}}</h4>
					{{{^ca_occurrences.description}}}
				</p>
				<br/><strong>
				{{{<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="exhibited">
					Artists: 
				</ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="exhibited">
					Artist: 
				</ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="exhibited">
					<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="exhibited"><l>^ca_entities.preferred_labels.displayname</l></unit>
				</ifcount>}}}
				</strong>
<?php
			break;
			# ----------------------------------------------
			case "images":
			case "installations":
				if(sizeof($va_images)){
					$vn_i = 1;
?>
					<div class="jcarousel-wrapper">
						<!-- Carousel -->
						<div class="jcarousel">
							<ul>
<?php
							foreach($va_images as $va_image){
?>
								<li id="slide<?php print $va_image["id"]; ?>">
									<div class="thumbnail">
										<?php print $va_image["image"]; ?>
										<div class="caption text-center captionSlideshow">(<?php print $vn_i."/".sizeof($va_images); ?>)<br/><?php print $va_image["label"]; ?></div>
									</div><!-- end thumbnail -->
								</li>
<?php
								$vn_i++;
							}
?>
							</ul>
						</div><!-- end jcarousel -->
<?php
					if(sizeof($va_images) > 1){
?>
						<a href="#" class="jcarousel-control-prev"><i class="fa fa-long-arrow-left"></i></a>
						<a href="#" class="jcarousel-control-next"><i class="fa fa-long-arrow-right"></i></a>
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
			break;
			# -------------------------------------------------------------------------------
			case "thumbnails":
			case "installationThumbnails":
?>
				<div class="row">
<?php
				if(sizeof($va_images)){
					foreach($va_images as $va_image){
						print "<div class='col-xs-4 col-sm-4 gridImg'>".caDetailLink($this->request, $va_image["thumbnail"], '', 'ca_occurrences', $t_item->get("occurrence_id"), array("view" =>(($ps_view == "thumbnails") ? "images" : "installations"), "id" => $va_image["id"]), null, array("type_id" => $t_item->get("type_id")))."</div>";
					}
				}
?>
				</div><!-- end row -->
<?php
			break;
			# -------------------------------------------------------------------------------
		}
		if(in_array($ps_view, array("images", "thumbnails"))){
?>
			<div id="imageNav">
<?php
				print caDetailLink($this->request, _t("slideshow"), (($ps_view == "images") ? "active" : ""), 'ca_occurrences', $t_item->get("occurrence_id"), array("view" => "images"), null, array("type_id" => $t_item->get("type_id")))." | ".caDetailLink($this->request, _t("thumbnails"), (($ps_view == "thumbnails") ? "active" : ""), 'ca_occurrences', $t_item->get("occurrence_id"), array("view" => "thumbnails"), null, array("type_id" => $t_item->get("type_id")));
?>
			</div>
<?php
		}		
		if(in_array($ps_view, array("installations", "installationThumbnails"))){
?>
			<div id="imageNav">
<?php
				print caDetailLink($this->request, _t("slideshow"), (($ps_view == "installations") ? "active" : ""), 'ca_occurrences', $t_item->get("occurrence_id"), array("view" => "installations"), null, array("type_id" => $t_item->get("type_id")))." | ".caDetailLink($this->request, _t("thumbnails"), (($ps_view == "installationThumbnails") ? "active" : ""), 'ca_occurrences', $t_item->get("occurrence_id"), array("view" => "installationThumbnails"), null, array("type_id" => $t_item->get("type_id")));
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
<?php 
			print $this->render("SubNav/exhibitions_html.inc");
?>			
			</div><!-- end col -->
		</div><!-- end row -->				
	</div><!--end row contentbody-->
	
