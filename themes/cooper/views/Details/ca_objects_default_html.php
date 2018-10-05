<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$va_access_values = 	$this->getVar("access_values");
	$vb_ajax			= (bool)$this->request->isAjax();
	
	# --- get content category list item ids for Text and Transcript so can separate from images
	$t_list = new ca_lists();
	$vn_content_category_text = $t_list->getItemIDFromList("content_categories", "Text");
	$vn_content_category_transcript = $t_list->getItemIDFromList("content_categories", "Transcript");
	
	require_once(__CA_LIB_DIR__.'/Search/ObjectSearch.php');
if($vb_ajax){
	# --- display media for child record on ajax load
	print $this->getVar("representationViewer");
}else{

?>
<div class="continer">
	<div class="row">
		<div class="col-sm-12" id="imageHere"></div>
	</div>
</div>

		<div class="container">
			<div class="row">
				<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
					{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
			</div>
			<div class="row">
				<div class='col-sm-12 col-md-offset-2 col-md-8'>
<?php
				$va_child_ids = $t_object->get("ca_objects.children.object_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
				if(is_array($va_child_ids) && sizeof($va_child_ids)){
					$qr_children = caMakeSearchResult("ca_objects", $va_child_ids);
					$va_children = array();
					$va_children_author_texts = array();
					$va_children_captions = array();
					$vn_first_img_id = null;
					if($qr_children->numHits()){
						while($qr_children->nextHit()){
							if($vs_icon = $qr_children->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values))){
								$va_content_cat = $qr_children->get("content_category", array("returnAsArray" => true));
								if(!is_array($va_content_cat)){
									$va_content_cat = array();
								}
								if(in_array($vn_content_category_text, $va_content_cat) || in_array($vn_content_category_transcript, $va_content_cat)){
									$va_children_author_texts[$qr_children->get("object_id")] = array("icon" => $vs_icon, "label" => $qr_children->get("ca_objects.preferred_labels.name"), "representation_id" => $qr_children->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values)));
								}else{
									$va_children[$qr_children->get("object_id")] = array("icon" => $vs_icon, "large" => $qr_children->get("ca_object_representations.media.page", array("checkAccess" => $va_access_values)));
								}
	
//								$vs_photographer = "";
//								$va_photographers = $qr_children->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("photographer")));
// 								$va_entity_display = array();
// 								if(is_array($va_photographers) && sizeof($va_photographers)){
// 									foreach($va_photographers as $va_entity){
// 										$vs_ent_name = $va_entity["surname"].(($va_entity["surname"] && $va_entity["forename"]) ? ", " : "").$va_entity["forename"];
// 										$va_entity_display[$vs_ent_name] = caNavLink($this->request, $vs_ent_name, "", "", "Browse", "projects", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]));
// 									}
// 									ksort($va_entity_display);
// 									$vs_photographer = join($va_entity_display, ", ");
// 									if($vs_photographer){
// 										$vs_photographer = " Photography by: ".$vs_photographer;
// 									}	
// 								}
//								$va_children_captions[$qr_children->get("object_id")] = ((!in_array($qr_children->get("ca_objects.preferred_labels.name"), array("[BLANK]", "[]"))) ? $qr_children->get("ca_objects.preferred_labels.name") : "").$vs_photographer;
								if(!$vn_first_img_id){
									$vn_first_img_id = $qr_children->get("object_id");
								}
							}
						}
					}
?>
					<div class="row detailImages">
						<div class="col-sm-2 detailImagesThumbs">
<?php
							foreach($va_children as $vn_child_object_id => $va_child){
								print "<a href='#' id='iconLink".$vn_child_object_id."' onclick='showMainImg($vn_child_object_id); return false;' ".(($vn_first_img_id == $vn_child_object_id) ? "class='active'" : "").">".$va_child["icon"]."</a>";
							}
?>
						</div>
						<div class="col-sm-10">
							<div id="detailObjectImageLarge"></div>
<?php
							if(is_array($va_children) && (sizeof($va_children) > 1)){
?>
								<div class="detailImageNav">
									<a href="#" class="detailPreviousImageLink" onClick="showNextPreviousImg('p'); return false;"><i class="fa fa-angle-left"></i> Prev</a>
									<a href="#" class="detailNextImageLink" onClick="showNextPreviousImg('n'); return false;">Next <i class="fa fa-angle-right"></i></i></a>
								</div>
<?php
							}
?>							
						</div>
					</div>
					<script type="text/javascript">
<?php
							if(is_array($va_children) && sizeof($va_children)){
?>
								showMainImg(<?php print $vn_first_img_id; ?>);
								function showMainImg(childID){
									$("#detailObjectImageLarge").load("<?php print caNavUrl($this->request, '', 'Detail', 'objects'); ?>/" + childID);
									$(".detailImagesThumbs a").removeClass("active");
									$("#iconLink" + childID).addClass("active");
							
								}
								if(is_array($va_children) && (sizeof($va_children) > 1)){
									function showNextPreviousImg(direction){
										var currentId = parseInt($(".detailImagesThumbs a.active").attr('id').replace('iconLink', ''));
									
										//var allIds = <?php print json_encode(array_keys($va_children))?>;
										var allIds = [<?php print join(", ", array_keys($va_children))?>];
									
										var arrayLength = allIds.length;
										for (var i = 0; i < arrayLength; i++) {
											if(allIds[i] == currentId){
												if(direction == "p"){
													if(i > 0){
														showMainImg(allIds[i-1]);
													}else{
														showMainImg(allIds[arrayLength-1]);
													}
												}else{
													if(i < (arrayLength - 1)){
														showMainImg(allIds[i+1]);
													}else{
														showMainImg(allIds[0]);
													}
												}
											}
										}
									
										//var allIds = <?php print json_encode(array_keys($va_children))?>;
										//$.each(allIds, function(attr, value) {
										//  console.log( attr + ' == ' + value );
									   //});
									}
								}
<?php
							}
?>							

					</script>
<?php
				}
										
?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-md-offset-2 col-md-8'>
					<div class="row topRow">
						<div class='col-md-4'>
							<H6>Abstract</H6><div class='unitAbstract'>{{{<ifdef code="ca_objects.abstract">^ca_objects.abstract</ifdef>}}}{{{<ifnotdef code="ca_objects.abstract">N/A</ifnotdef>}}}</div>
						</div>
						<div class='col-md-8'>
							<div class="row">
								<div class="col-md-5">
									<H6>Title</H6><div class='unitTop'>{{{<ifdef code="ca_objects.preferred_labels.name">^ca_objects.preferred_labels.name</ifdef>}}}{{{<ifnotdef code="ca_objects.preferred_labels.name">N/A</ifnotdef>}}}</div>
									<H6>Author</H6><div class='unitTop'>
<?php
									$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("author")));
									if(sizeof($va_entities)){
										$va_entity_display = array();
										foreach($va_entities as $va_entity){
											$vs_ent_name = $va_entity["surname"].(($va_entity["surname"] && $va_entity["forename"]) ? ", " : "").$va_entity["forename"];
											$va_entity_display[$vs_ent_name] = caNavLink($this->request, $vs_ent_name, "", "", "Browse", "projects", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]));
										}
										ksort($va_entity_display);
										print join($va_entity_display, "<br/>");
									}else{
										print "N/A";
									}
?>
									</div>
									<H6>Course</H6><div class='unitTop'>
<?php
									$va_courses = $t_object->get("ca_occurrences", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("course")));
									if(sizeof($va_courses)){
										$va_course_display = array();
										foreach($va_courses as $va_course){
											$va_course_display[] = caNavLink($this->request, $va_course["name"], "", "", "Browse", "projects", array("facet" => "course_facet", "id" => $va_course["occurrence_id"]));
										}
										print join($va_course_display, "; ");
									}else{
										print "N/A";
									}
?>
									</div>
								</div>
								<div class="col-md-7">
									<H6>Academic Year</H6>
									<div class='unitTop'>
<?php
									$va_years = $t_object->get("ca_occurrences", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("academic_year")));
									if(sizeof($va_years)){
										$va_year_display = array();
										foreach($va_years as $va_year){
											$va_year_display[] = caNavLink($this->request, $va_year["name"], "", "", "Browse", "projects", array("facet" => "year_facet", "id" => $va_year["occurrence_id"]));
										}
										print join($va_year_display, "; ");
									}else{
										print "N/A";
									}
?>
									</div>
									<H6>Semester</H6><div class='unitTop'>{{{<ifdef code="ca_objects.semester">^ca_objects.semester</ifdef>}}}{{{<ifnotdef code="ca_objects.semester">N/A</ifnotdef>}}}</div>
									<H6>Faculty</H6><div class='unitTop'>
<?php
									$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("faculty")));
									if(sizeof($va_entities)){
										$va_entity_display = array();
										foreach($va_entities as $va_entity){
											$vs_ent_name = $va_entity["surname"].(($va_entity["surname"] && $va_entity["forename"]) ? ", " : "").$va_entity["forename"];
											$va_entity_display[$vs_ent_name] = caNavLink($this->request, $vs_ent_name, "", "", "Browse", "projects", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]));
										}
										ksort($va_entity_display);
										print join($va_entity_display, "<br/>");
									}else{
										print "N/A";
									}
?>									
									</div>
								</div>
							</div><!-- end row -->
						</div>
					</div><!-- end toprow -->
					
					
					
					<div class="row bottomRow">
						<div class='col-md-4'>
							{{{map}}}
						</div>
						<div class='col-md-8'>
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#md" aria-controls="md" role="tab" data-toggle="tab">Additional Metadata</a></li>
<?php
							if(is_array($va_children_author_texts) && sizeof($va_children_author_texts)){
?>
								<li role="presentation"><a href="#author" aria-controls="author" role="tab" data-toggle="tab">Author Text</a></li>
<?php
							}
?>
								<li role="presentation"><a href="#faculty" aria-controls="faculty" role="tab" data-toggle="tab">Faculty Text</a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="md">
									<div class="row">
										<div class="col-sm-5">
<?php
											$va_vocs = array("problem_types" => array("name" => "Problem Type", "facet" => "problem_facet"), "program_types" => array("name" => "Program Types", "facet" => "program_types_facet"), "architectural_elements" => array("name" => "Architectural Elements", "facet" => "architectural_elements_facet"));
											foreach($va_vocs as $vs_list_code => $va_voc){
												$va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array($vs_list_code)));
												print "<H7>".$va_voc["name"]."</H7><div class='unitBottom'>";
												if(sizeof($va_list_items)){
													$va_terms = array();
		 											foreach($va_list_items as $va_list_item){
		 												$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "projects", array("facet" => $va_voc["facet"], "id" => urlencode($va_list_item["item_id"])));
		 											}
		 											print join($va_terms, "; ");
												}else{
													print "N/A";
												}
												print "</div>";						
											}
		?>
										</div>
										<div class="col-sm-7">
											<H7>Photographer</H7><div class='unitBottom'>
<?php
											$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("photographer")));
											if(sizeof($va_entities)){
												$va_entity_display = array();
												foreach($va_entities as $va_entity){
													$vs_ent_name = $va_entity["surname"].(($va_entity["surname"] && $va_entity["forename"]) ? ", " : "").$va_entity["forename"];
													$va_entity_display[$vs_ent_name] = caNavLink($this->request, $vs_ent_name, "", "", "Browse", "projects", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]));
												}
												ksort($va_entity_display);
												print join($va_entity_display, "<br/>");
											}else{
												print "N/A";
											}
?>
											</div>
											<H7>Subjects</H7><div class='unitBottom'>
		<?php
												$va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("student_project_subjects")));
												$va_lcsh_terms = $t_object->get("lcsh", array("returnWithStructure" => true));
												$va_aat_terms = $t_object->get("aat", array("returnWithStructure" => true));
	#print_r($va_aat_terms);
									
												if((is_array($va_list_items) && sizeof($va_list_items)) || (is_array($va_lcsh_terms) && sizeof($va_lcsh_terms))){
													$va_terms = array();
		 											if(is_array($va_list_items) && sizeof($va_list_items)){
														foreach($va_list_items as $va_list_item){
															$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "projects", array("facet" => "student_project_subjects_facet", "id" => urlencode($va_list_item["item_id"])));
														}
													}
													if(is_array($va_lcsh_terms) && sizeof($va_lcsh_terms)){
														$va_lcsh_terms = array_pop($va_lcsh_terms);
														foreach($va_lcsh_terms as $vn_term_id => $va_lcsh_term){
															$vs_tmp = substr($va_lcsh_term["lcsh"], 0, strpos($va_lcsh_term["lcsh"], " ["));
															$va_terms[] = caNavLink($this->request, $vs_tmp, "", "", "Browse", "projects", array("facet" => "lcsh_facet", "id" => urlencode($va_lcsh_term["lcsh"])));
														}
													}
													if(is_array($va_aat_terms) && sizeof($va_aat_terms)){
														$va_aat_terms = array_pop($va_aat_terms);
														foreach($va_aat_terms as $vn_term_id => $va_aat_term){
															$vs_tmp = substr($va_aat_term["aat"], 0, strpos($va_aat_term["aat"], " ["));
															$va_terms[] = caNavLink($this->request, $va_aat_term["aat"], "", "", "Browse", "projects", array("facet" => "aat_facet", "id" => urlencode($va_aat_term["aat"])));
														}
													}
													
		 											print join($va_terms, "<br/>");
												}else{
													print "N/A";
												}
		?>
											</div>
										</div>
									</div><!-- end row -->
								</div>
								<div role="tabpanel" class="tab-pane" id="author">
									<div class='unitBottom'>
		<?php
									if(is_array($va_children_author_texts) && sizeof($va_children_author_texts)){
										foreach($va_children_author_texts as $vn_child_text_id => $va_child){
											print '<a href="#" onclick="caMediaPanel.showPanel(\''.caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('id' => $vn_child_text_id, 'context' => 'objects', 'overlay' => 1, 'representation_id' => $va_child["representation_id"])).'\'); return false;" title="View Document">'.$va_child["label"].'</a><br/>';
										}
									}else{
										print "N/A";
									}
		?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="faculty">
		<?php
									$vs_faculty_bio = $t_object->get("ca_entities.biography", array("restrictToRelationshipTypes" => array("faculty"), "checkAccess" => $va_access_values));
		?>
									<div class='unitBottom'><?php print ($vs_faculty_bio) ? $vs_faculty_bio : "N/A"; ?></div>

								</div>
							</div><!-- end tab-content -->
					
					
					
					
					
						</div>
					</div><!-- end row -->
					
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 frontGalleries">
<?php
			$va_program_types = $t_object->get("ca_list_items.item_id", array("returnAsArray" => true, "restrictToLists" => array("program_types")));
			if(is_array($va_program_types) && sizeof($va_program_types)){
				$o_search = new ObjectSearch();
				if(is_array($this->opa_access_values) && sizeof($this->opa_access_values)){
					$o_search->addResultFilter("ca_object.access", "IN", join(',', $this->opa_access_values));
				}
				$qr_res = $o_search->search("ca_list_items.item_id:".$va_program_types[0]);
				$i = 0;
				if($qr_res->numHits() > 1){
?>
						<div class="frontGallerySlideLabel"><?php print caNavLink($this->request, _t("See All")." <i class='fa fa-caret-down'></i>", "btn-default", "", "Browse", "projects", array("facet" => "program_type_facet", "id" => $va_program_types[0])); ?>Related Projects <span class='frontGallerySlideLabelSub'>/ <?php print $qr_res->numHits() - 1; ?> projects</span></div>
						<div class="jcarousel-wrapper">
							<!-- Carousel -->
							<div class="jcarousel relatedItems">
								<ul>
<?php
									while($qr_res->nextHit()){
										if($qr_res->get("ca_objects.object_id") != $t_object->get("object_id")){
											$vs_image = $qr_res->getWithTemplate("<unit relativeTo='ca_objects.children'>^ca_object_representations.media.widepreview</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
											if($vn_c = strpos($vs_image, ";")){
												$vs_image = substr($vs_image, 0, $vn_c);
											}
											if(!$vs_image){
												$vs_image = caGetThemeGraphic($this->request, 'frontImage.jpg', array("style" => "opacity:.5;"));
											}
											print "<li><div class='slide'>".caDetailLink($this->request, $vs_image, "", "ca_objects", $qr_res->get("ca_objects.object_id"))."<div class='slideCaption'>".caDetailLink($this->request, $qr_res->get("ca_objects.preferred_labels.name"), "", "ca_objects", $qr_res->get("ca_objects.object_id"))."</div></div></li>";
											$i++;
											if($i > 25){
												break;
											}
										}
									}
?>
								</ul>
							</div><!-- end jcarousel -->
							<!-- Prev/next controls -->
							<a href="#" class="jcarousel-control-prev previousRelated"><i class="fa fa-caret-left"></i></a>
							<a href="#" class="jcarousel-control-next nextRelated"><i class="fa fa-caret-right"></i></a>
						</div><!-- end jcarousel-wrapper -->
						<script type='text/javascript'>
							jQuery(document).ready(function() {
								/*
								Carousel initialization
								*/
								$('.relatedItems')
									.jcarousel({
										// Options go here
										auto: 1,
										wrap: "circular",
										animation:"slow"
									}).jcarouselAutoscroll({
										interval: 0,
										target: '+=1',
										autostart: false
									});
									
									$('.relatedItems').jcarousel({
										animation: {
											duration: 1500, /* lower = faster animation */
											easing:   'linear',
											complete: function() {
											}
										}
									});
								/*
								 Prev control initialization
								 */
								$('.previousRelated')
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
								$('.nextRelated')
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
							
								$(".previousRelated").hover(function () {
									$('.relatedItems').jcarouselAutoscroll('reload', {
										interval: 0,
										target: '-=1',
										autostart: false
									});
									$(".relatedItems").jcarouselAutoscroll('start');
								},function () {
									$(".relatedItems").jcarouselAutoscroll('stop');
								});
								$(".nextRelated").hover(function () {
									$('.relatedItems').jcarouselAutoscroll('reload', {
										interval: 0,
										target: '+=1',
										autostart: false
									});
									$(".relatedItems").jcarouselAutoscroll('start');
								},function () {
									$(".relatedItems").jcarouselAutoscroll('stop');
								});
					
							});
						</script>
		<?php
					}
				
			} 			
?>
				</div>
			</div>
		</div><!-- end container -->
<?php
}
?>