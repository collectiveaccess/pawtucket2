<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$t_item = $this->getVar("item");
	$ps_view = $this->request->getParameter("view", pString);	#works, exhibitions, bio
	if(!$ps_view){
		$ps_view = "thumbnails";
	}
	# --- object id of related image to cue slideshow to
	$pn_object_id = $this->request->getParameter("id", pInteger);
	# --- show images grouped by type?
	$vb_group_images_by_type = false;
	if($t_item->get("ca_entities.group_by_type", array("convertCodesToDisplayText" => true)) == "Yes"){
		$va_type_ids = array_unique($t_item->get("ca_objects.type_id", array("restrictToRelationshipTypes" => array("creator", "creator_website"), "returnWithStructure" => true, "checkAccess" => $va_access_values)));
		$vb_group_images_by_type = true;
		$ps_artwork_type = $this->request->getParameter("artworkType", pString);
		$va_artwork_types = array();
		foreach($va_type_ids as $vn_type_id){
			$t_list_item = new ca_list_items($vn_type_id);
			$va_artwork_types[$t_list_item->get("ca_list_items.idno")] = array("type_id" => $vn_type_id, "idno" => $t_list_item->get("ca_list_items.idno"), "name" => $t_list_item->get("ca_list_item_labels.name_plural"));
			if(!$ps_artwork_type){
				$ps_artwork_type = $t_list_item->get("ca_list_items.idno");
			}
		}
	}
	# --- get related object_ids in array
	if($vb_group_images_by_type && $ps_artwork_type){
		$va_objects = $t_item->get("ca_objects", array("restrictToTypes" => array($ps_artwork_type), "restrictToRelationshipTypes" => array("creator", "creator_website"), "returnWithStructure" => true, "checkAccess" => $va_access_values));
	}else{
		$va_objects = $t_item->get("ca_objects", array("restrictToRelationshipTypes" => array("creator", "creator_website"), "returnWithStructure" => true, "checkAccess" => $va_access_values));
	}
	$va_object_ids = array();
	if(is_array($va_objects) && sizeof($va_objects)){
		foreach($va_objects as $va_object){
			$va_object_ids[] = $va_object["object_id"];
			#print $va_object["object_id"]." - ";
		}
	}
?>	
	<div class="row contentbody_sub">

		<div class="col-sm-3 subnav">
			<H1><?php print $t_item->get("ca_entities.preferred_labels.displayname"); ?></H1>	
			<ul>
				<li<?php print ($ps_view == "works") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Selected Works"), '', 'ca_entities', $t_item->get("entity_id"), null, null, array("type_id" => $t_item->get("type_id"))); ?></li>
				<li<?php print ($ps_view == "exhibitions") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Exhibitions"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "exhibitions"), null, array("type_id" => $t_item->get("type_id"))); ?></li>
				<li<?php print ($ps_view == "bio") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Biography"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "bio"), null, array("type_id" => $t_item->get("type_id"))); ?></li>
				<li><?php print caNavLink($this->request, _t("Request Information"), "", "", "Contact", "Form"); ?></li>
			</ul>
		</div>
			
		<div class="col-sm-9 subnavOffset">			
<?php
		if($vb_group_images_by_type && (($ps_view == "thumbnails") || ($ps_view == "works"))){
?>
			<div class="row">
				<div class="col-sm-12" role="navigation" aria-label="Artwork navigation">
					<ul class="nav nav-pills">
<?php
						foreach($va_artwork_types as $va_artwork_type){
							print "<li".(($va_artwork_type["idno"] == $ps_artwork_type) ? " class='active'" : "").">".caDetailLink($this->request, $va_artwork_type["name"], "", 'ca_entities', $t_item->get("entity_id"), array("view" => $ps_view, "artworkType" => $va_artwork_type["idno"]), null, array("type_id" => $t_item->get("type_id")))."</li>";
						}
?>
					</ul>			
				</div>
			</div>
<?php
}
?>			
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
<?php
				$va_objects = $t_item->get("ca_objects", array("restrictToRelationshipTypes" => array("creator_website"), "returnWithStructure" => true, "checkAccess" => $va_access_values));
				foreach($va_objects as $va_object){
					$t_featured_object = new ca_objects($va_object["object_id"]);
?>
					<div class="thumbnail"><?php print $t_featured_object->get("ca_object_representations.media.medium"); ?>
						<div class="caption"><?php print sefaFormatCaption($this->request, $t_featured_object); ?></div>
					</div>
<?php
				}
?>
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
				$va_exhibitions = $t_item->get("ca_occurrences", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("exhibited"), "sort" => array("ca_occurrences.opening_closing"), "sortDirection" => "desc"));
				$t_occurrence = new ca_occurrences();
				if(sizeof($va_exhibitions) > 0){
					foreach($va_exhibitions as $va_exhibition){
						$t_occurrence->load($va_exhibition["occurrence_id"]);
						print "<h2><i>".caDetailLink($this->request, $t_occurrence->get("ca_occurrences.preferred_labels.name"), '', 'ca_occurrences', $va_exhibition["occurrence_id"], null, null, array("type_id" => $t_occurrence->get("ca_occurrences.type_id")))."</i></h2>";
						if($t_occurrence->get("ca_occurrences.exhibition_subtitle")){
							print "<h3>".$t_occurrence->get("ca_occurrences.exhibition_subtitle")."</h3>";
						}
						print "<div class='date'>".$t_occurrence->get("ca_occurrences.opening_closing")."</div>";
						print "<br/>";
					}
				}else{
					print "<h2>No exhibitions</h2>";
				}
?>
				</div><!-- end col -->
				<div class="col-sm-4 col-sm-offset-1">
<?php
				$va_objects = $t_item->get("ca_objects", array("restrictToRelationshipTypes" => array("creator_website"), "returnWithStructure" => true, "checkAccess" => $va_access_values));
				foreach($va_objects as $va_object){
					$t_featured_object = new ca_objects($va_object["object_id"]);
?>
					<div class="thumbnail"><?php print $t_featured_object->get("ca_object_representations.media.medium"); ?>
						<div class="caption"><?php print sefaFormatCaption($this->request, $t_featured_object); ?></div>
					</div>
<?php
				}
?>
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			break;
			# ----------------------------------------------
			case "works":
				$q_objects = caMakeSearchResult('ca_objects', $va_object_ids);
				if($q_objects->numHits()){
					$va_images = array();
					while($q_objects->nextHit()){
						$vs_image = "";
						$vs_image = $q_objects->get("ca_object_representations.media.mediumlarge", array("checkAccess" => $va_access_values));
						if($vs_image){
							$va_images[$q_objects->get("ca_objects.date_created").".".$q_objects->get("ca_objects.object_id")] = array("object_id" => $q_objects->get("ca_objects.object_id"), "image" => $vs_image, "caption" => sefaFormatCaption($this->request, $q_objects));
						}
					}
					krsort($va_images);
?>
					<div class="jcarousel-wrapper">
						<!-- Carousel -->
						<div class="jcarousel">
							<ul>
<?php
							$vn_i = 1;
							foreach($va_images as $key => $va_image){
?>
								<li id="slide<?php print $va_image["object_id"]; ?>">
									<div class="thumbnail">
										<?php print $va_image["image"]; ?>
										<div class="caption text-center captionSlideshow">(<?php print $vn_i."/".sizeof($va_images); ?>)<br/><?php print $va_image["caption"]; ?>
											<br/><br/><?php print caNavLink($this->request, _t("Inquire"), "btn btn-default", "", "Contact", "Form", array("table" => "ca_objects", "id" => $va_image["object_id"])); ?>
										</div>
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
						<a href="#" class="jcarousel-control-prev"><i class="fa fa-long-arrow-left" aria-label="previous"></i></a>
						<a href="#" class="jcarousel-control-next"><i class="fa fa-long-arrow-right" aria-label="next"></i></a>
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
			default:
?>
				<div class="row">
<?php
				$q_objects = caMakeSearchResult('ca_objects', $va_object_ids);
				if($q_objects->numHits()){
					while($q_objects->nextHit()){
						if($q_objects->get("ca_object_representations.media.thumbnail300square")){
							$va_images[$q_objects->get("ca_objects.date_created").".".$q_objects->get("ca_objects.object_id")] = "<div class='col-xs-4 col-sm-4 gridImg'>".caDetailLink($this->request, $q_objects->get("ca_object_representations.media.thumbnail300square"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "works", "id" => $q_objects->get("object_id"), "artworkType" => $ps_artwork_type), null, array("type_id" => $t_item->get("type_id")))."</div>";
						}
					}
					krsort($va_images);
					print join(" ", $va_images);
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
				print caDetailLink($this->request, _t("slideshow"), (($ps_view == "works") ? "active" : ""), 'ca_entities', $t_item->get("entity_id"), array("view" => "works", "artworkType" => $ps_artwork_type), null, array("type_id" => $t_item->get("type_id")))." | ".caDetailLink($this->request, _t("thumbnails"), (($ps_view == "thumbnails") ? "active" : ""), 'ca_entities', $t_item->get("entity_id"), array("view" => "thumbnails", "artworkType" => $ps_artwork_type), null, array("type_id" => $t_item->get("type_id")));
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
				<H5><?php print $t_item->get("ca_entities.preferred_labels.displayname"); ?></H5>	
				<ul>
					<li<?php print ($ps_view == "works") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Selected Works"), '', 'ca_entities', $t_item->get("entity_id"), null, null, array("type_id" => $t_item->get("type_id"))); ?></li>
					<li<?php print ($ps_view == "exhibitions") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Exhibitions"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "exhibitions"), null, array("type_id" => $t_item->get("type_id"))); ?></li>
					<li<?php print ($ps_view == "bio") ? " class='active'" : ""; ?>><?php print caDetailLink($this->request, _t("Biography"), '', 'ca_entities', $t_item->get("entity_id"), array("view" => "bio"), null, array("type_id" => $t_item->get("type_id"))); ?></li>
					<li><?php print caNavLink($this->request, _t("Request Information"), "", "", "Contact", "Form"); ?></li>
				</ul>			
			</div><!-- end col -->
		</div><!-- end row -->				
	</div><!--end row contentbody-->	
