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


?>

		<div class="container">
			<div class="row">
				<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
					{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
			</div>
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-offset-2 col-lg-8'>
<?php
				$va_child_ids = $t_object->get("ca_objects.children.object_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
				if(is_array($va_child_ids) && sizeof($va_child_ids)){
					$qr_children = caMakeSearchResult("ca_objects", $va_child_ids);
					$va_children = array();
					$va_children_captions = array();
					if($qr_children->numHits()){
						while($qr_children->nextHit()){
							if($vs_icon = $qr_children->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values))){
								$va_children[$qr_children->get("object_id")] = array("icon" => $vs_icon, "large" => $qr_children->get("ca_object_representations.media.page", array("checkAccess" => $va_access_values)));
								$vs_photographer = "";
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
								$va_children_captions[$qr_children->get("object_id")] = ((!in_array($qr_children->get("ca_objects.preferred_labels.name"), array("[BLANK]", "[]"))) ? $qr_children->get("ca_objects.preferred_labels.name") : "").$vs_photographer;
							}
						}
					}
?>
					<div class="row detailImages">
						<div class="col-sm-2 detailImagesThumbs">
<?php
							foreach($va_children as $vn_child_object_id => $va_child){
								print "<span onClick=\"showMainImg('".$vn_child_object_id."');\">".$va_child["icon"]."</span><br/><br/>";
							}
?>
						</div>
						<div class="col-sm-10">
<?php
							foreach($va_children as $vn_child_object_id => $va_child){
								if(!$vn_first_img_id){
									$vn_first_img_id = $vn_child_object_id;
								}
								print "<div id='large".$vn_child_object_id."' class='detailImagesMain'>".$va_child["large"]."<div class='detailCaption'>".$va_children_captions[$vn_child_object_id]."</div></div>";
							}
?>
						</div>
					</div>
					<script type="text/javascript">
						showMainImg(<?php print $vn_first_img_id; ?>);
						function showMainImg(childID){
							$(".detailImagesMain").hide();
							$("#large" + childID).show();
							//alert($("#large" + childID + " img").width() / $("#large" + childID + " img").height());
							//var ratio = $("#large" + childID + " img").width() / $("#large" + childID + " img").height();
							//if(ratio < 1.2){
							if($("#large" + childID + " img").height() > $("#large" + childID + " img").width()){
								if(!$("#large" + childID + " img").hasClass("vertical")){
									$("#large" + childID + " img").addClass("vertical");
								}
							}else{
								if(!$("#large" + childID + " img").hasClass("horizontal")){
									$("#large" + childID + " img").addClass("horizontal");
								}
							}
						}
					</script>
<?php
				}
				#$vs_image = $qr_set_items->getWithTemplate("<unit relativeTo='ca_objects.children'>^ca_object_representations.media.widethumbnail</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
										
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
								<li role="presentation"><a href="#author" aria-controls="author" role="tab" data-toggle="tab">Author Text</a></li>
								<li role="presentation"><a href="#faculty" aria-controls="faculty" role="tab" data-toggle="tab">Faculty Text</a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="md">
									<div class="row">
										<div class="col-sm-4">
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
										<div class="col-sm-4">
						
										</div>
										<div class="col-sm-4">
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
												if(sizeof($va_list_items)){
													$va_terms = array();
		 											foreach($va_list_items as $va_list_item){
		 												$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "projects", array("facet" => "student_project_subjects_facet", "id" => urlencode($va_list_item["item_id"])));
		 											}
		 											print join($va_terms, "; ");
												}else{
													print "N/A";
												}
		?>
											</div>
										</div>
									</div><!-- end row -->
								</div>
								<div role="tabpanel" class="tab-pane" id="author">
		<?php
									$vs_author_bio = $t_object->get("ca_entities.biography", array("restrictToRelationshipTypes" => array("author"), "checkAccess" => $va_access_values));
		?>
									<div class='unitBottom'><div class='unitBottom'><?php print ($vs_author_bio) ? $vs_author_bio : "N/A"; ?></div></div>
								</div>
								<div role="tabpanel" class="tab-pane" id="faculty">
		<?php
									$vs_faculty_bio = $t_object->get("ca_entities.biography", array("restrictToRelationshipTypes" => array("faculty"), "checkAccess" => $va_access_values));
		?>
									<div class='unitBottom'><div class='unitBottom'><?php print ($vs_faculty_bio) ? $vs_faculty_bio : "N/A"; ?></div></div>

								</div>
							</div><!-- end tab-content -->
					
					
					
					
					
						</div>
					</div><!-- end row -->
					
					
				</div>
			</div>

		</div><!-- end container -->