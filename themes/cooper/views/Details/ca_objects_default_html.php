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
				<div class='col-sm-12 col-md-12 col-lg-offset-2 col-lg-8'>
<?php
				$va_child_ids = $t_object->get("ca_objects.children.object_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
				if(is_array($va_child_ids) && sizeof($va_child_ids)){
					$qr_children = caMakeSearchResult("ca_objects", $va_child_ids);
					$va_children = array();
					if($qr_children->numHits()){
						while($qr_children->nextHit()){
							if($vs_icon = $qr_children->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values))){
								$va_children[$qr_children->get("object_id")] = array("icon" => $vs_icon, "large" => $qr_children->get("ca_object_representations.media.page", array("checkAccess" => $va_access_values)));
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
								print "<span id='large".$vn_child_object_id."' class='detailImagesMain'>".$va_child["large"]."</span>";
							}
?>
						</div>
					</div>
					<script type="text/javascript">
						$(".detailImagesMain:first").show();
						function showMainImg(childID){
							$(".detailImagesMain").hide();
							$("#large" + childID).show();
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
								<div class="col-md-7">
									<H6>Title</H6><div class='unitTop'>{{{<ifdef code="ca_objects.preferred_labels.name">^ca_objects.preferred_labels.name</ifdef>}}}{{{<ifnotdef code="ca_objects.preferred_labels.name">N/A</ifnotdef>}}}</div>
									<H6>Author</H6><div class='unitTop'>{{{<case><ifcount code="ca_entities" min="1" restrictToRelationshipTypes="author"><unit relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels.displayname</unit></ifcount><ifcount code="ca_entities" max="0" restrictToRelationshipTypes="author">N/A</ifcount></case>}}}
									</div>
									<H6>Course</H6><div class='unitTop'>
									{{{<case><ifcount code="ca_occurrences" restrictToTypes="course" min="1"><unit relativeTo="ca_occurrences" restrictToTypes="course">^ca_occurrences.preferred_labels.name</unit></ifcount><ifcount code="ca_occurrences" restrictToTypes="course" max="0">N/A</ifcount></case>}}}
									</div>
								</div>
								<div class="col-md-5">
									<H6>Academic Year</H6><div class='unitTop'>{{{<ifcount code="ca_occurrences" restrictToTypes="academic_year" min="1"><unit relativeTo="ca_occurrences" restrictToTypes="academic_year" delimiter="; ">^ca_occurrences.preferred_labels.name</unit></ifcount>}}}</div>
									<H6>Semester</H6><div class='unitTop'>{{{<ifdef code="ca_objects.semester">^ca_objects.semester</ifdef>}}}{{{<ifnotdef code="ca_objects.semester">N/A</ifnotdef>}}}</div>
									<H6>Faculty</H6><div class='unitTop'>{{{<case><ifcount code="ca_entities" min="1" restrictToRelationshipTypes="faculty"><unit relativeTo="ca_entities" restrictToRelationshipTypes="faculty">^ca_entities.preferred_labels.displayname</unit></ifcount><ifcount code="ca_entities" max="0" restrictToRelationshipTypes="faculty">N/A</ifcount></case>}}}</div>
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
		// $va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("problem_types")));
		// if(sizeof($va_list_items)){
		// 	print "<H6>Program Type".((sizeof($va_list_items) > 1) ? "s" : "")."</H6>";
		// 	$va_terms = array();
		// 	foreach($va_list_items as $va_list_item){
		// 		//$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "projects", array("facet" => "program_type_facet", "id" => urlencode($va_list_item["item_id"])));
		// 		$va_terms[] = $va_list_item["name_singular"];
		// 	}
		// 	print join($va_terms, "; ");
		// }
											$va_vocs = array("problem_types" => "Problem Type", "program_types" => "Program Types", "architectural_elements" => "Architectural Elements");
											foreach($va_vocs as $vs_list_code => $vs_voc_name){
												$vs_list_items = $t_object->get("ca_list_items", array("delimiter" => "; ", "restrictToLists" => array($vs_list_code)));
												print "<H7>".$vs_voc_name."</H7><div class='unitBottom'>";
												if($vs_list_items){
													print $vs_list_items;
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
											{{{<case>
													<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="photographer"><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer">^ca_entities.preferred_labels.displayname</unit></ifcount>
													<ifcount code="ca_entities" max="0" restrictToRelationshipTypes="photographer">N/A</ifcount>
												</case>
											}}}
											</div>
											<H7>Subjects</H7><div class='unitBottom'>
		<?php
												$vs_list_items = $t_object->get("ca_list_items", array("delimiter" => "; ", "restrictToLists" => array("student_work_subjects")));
												if($vs_list_items){
													print $vs_list_items;
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