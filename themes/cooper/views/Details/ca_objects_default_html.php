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
				<div class='col-sm-12'>
					{{{representationViewer}}}
				
				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>


				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row topRow">
				<div class='col-lg-offset-1 col-lg-3'>
					<H6>Abstract</H6><div class='unitAbstract'>{{{<ifdef code="ca_objects.abstract">^ca_objects.abstract</ifdef>}}}{{{<ifnotdef code="ca_objects.abstract">N/A</ifnotdef>}}}</div>
				</div>
				<div class='col-lg-offset-1 col-lg-6'>
					<div class="row">
						<div class="col-sm-7">
							<H6>Title</H6><div class='unitTop'>{{{<ifdef code="ca_objects.preferred_labels.name">^ca_objects.preferred_labels.name</ifdef>}}}{{{<ifnotdef code="ca_objects.preferred_labels.name">N/A</ifnotdef>}}}</div>
							<H6>Author</H6><div class='unitTop'>{{{<case><ifcount code="ca_entities" min="1" restrictToRelationshipTypes="author"><unit relativeTo="ca_entities" restrictToRelationshipTypes="author"><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount><ifcount code="ca_entities" max="0" restrictToRelationshipTypes="author">N/A</ifcount></case>}}}
							</div>
							<H6>Course</H6><div class='unitTop'>
							{{{<case><ifcount code="ca_occurrences" min="1"><unit relativeTo="ca_occurrences">^ca_occurrences.preferred_labels.name</unit></ifcount><ifcount code="ca_occurrences" max="0">N/A</ifcount></case>}}}
							</div>
						</div>
						<div class="col-sm-5">
							<H6>Acedemic Year</H6><div class='unitTop'>{{{<ifdef code="ca_objects.acedemic_year">^ca_objects.acedemic_year</ifdef>}}}{{{<ifnotdef code="ca_objects.acedemic_year">N/A</ifnotdef>}}}</div>
							<H6>Semester</H6><div class='unitTop'>{{{<ifdef code="ca_objects.semester">^ca_objects.semester</ifdef>}}}{{{<ifnotdef code="ca_objects.semester">N/A</ifnotdef>}}}</div>
							<H6>Faculty</H6><div class='unitTop'>{{{<case><ifcount code="ca_entities" min="1" restrictToRelationshipTypes="faculty"><unit relativeTo="ca_entities" restrictToRelationshipTypes="faculty"><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount><ifcount code="ca_entities" max="0" restrictToRelationshipTypes="faculty">N/A</ifcount></case>}}}</div>
						</div>
					</div><!-- end row -->
				</div>
			</div>
			<div class="row bottomRow">
				<div class='col-lg-offset-1 col-lg-3'>
					{{{map}}}
				</div>
				<div class='col-lg-offset-1 col-lg-6'>
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
									<H7>Program Type</H7><div class='unitBottom'>{{{<ifdef code="ca_objects.program_type">^ca_objects.program_type</ifdef>}}}{{{<ifnotdef code="ca_objects.program_type">N/A</ifnotdef>}}}</div>
									<H7>Problem Type</H7><div class='unitBottom'>{{{<ifdef code="ca_objects.problem_type">^ca_objects.problem_type</ifdef>}}}{{{<ifnotdef code="ca_objects.problem_type">N/A</ifnotdef>}}}</div>
									<H7>Architectural Elements</H7><div class='unitBottom'>{{{<ifdef code="ca_objects.architectural_element">^ca_objects.architectural_element</ifdef>}}}{{{<ifnotdef code="ca_objects.architectural_element">N/A</ifnotdef>}}}</div>
								</div>
								<div class="col-sm-4">
						
								</div>
								<div class="col-sm-4">
									<H7>Photographer</H7><div class='unitBottom'>
									{{{<case>
											<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="photographer"><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer"><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>
											<ifcount code="ca_entities" max="0" restrictToRelationshipTypes="photographer">N/A</ifcount>
										</case>
									}}}
									</div>
									<H7>Subjects</H7><div class='unitBottom'>
									{{{<case>
											<ifcount code="ca_list_items" min="1"><unit relativeTo="ca_list_items"><l>^ca_list_items.preferred_labels.name_plural</l></unit></ifcount>
											<ifcount code="ca_list_items" max="0">N/A</ifcount>
										</case>	
									}}}
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
		</div><!-- end container -->