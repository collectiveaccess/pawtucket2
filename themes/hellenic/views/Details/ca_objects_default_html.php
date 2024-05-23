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
	$vn_type_id = 			$t_object->get('ca_objects.type_id');
	$t_list = new ca_lists();
	$vn_oh_id = $t_list->getItemIDFromList("object_types", "oral_history");
	$vn_book_id = $t_list->getItemIDFromList("object_types", "book");
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-12'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?= caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "basic", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", 'version' => 'iconlarge', "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
				<hr/>
								
			</div><!-- end col -->
			
			<div class='col-sm-12'>
<?php
				if ($vs_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Object ID</h6><div class='data'>".$vs_idno."</div></div>";
				}
				if ($vs_call = $t_object->get('ca_objects.call_number')) {
					print "<div class='unit'><h6>Call Number</h6><div class='data'>".$vs_call."</div></div>";
				}
				if ($vs_name = $t_object->get('ca_objects.preferred_labels')) {
					print "<div class='unit'><h6>Object Name</h6><div class='data'>".$vs_name."</div></div>";
				}	
				if ($vs_title = $t_object->get('ca_objects.title')) {
					print "<div class='unit'><h6>Title</h6><div class='data'>".$vs_title."</div></div>";
				}				
				if ($vs_author = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', ', 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Author</h6><div class='data'>".$vs_author."</div></div>";
				}
				if ($vs_language = $t_object->get('ca_objects.language', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Language</h6><div class='data'>".$vs_language."</div></div>";
				}					
				if ($va_collection = $t_object->getWithTemplate('<ifcount code="ca_collections" min="1"><unit delimiter="<br/>"><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit></unit></ifcount>')) {
					print "<div class='unit'><h6>Object Collection</h6><div class='data'>".$va_collection."</div></div>";
				}
				if ($va_date = $t_object->get('ca_objects.date_created', array('returnAsArray' => true))) {
					# --- clear out empty values
					$va_date_clean = array();
					foreach($va_date as $vs_date){
						if(trim($vs_date)){
							$va_date_clean[] = trim($vs_date); 
						}
					}
					$vs_date = join(", ", $va_date_clean);
					if($vs_date){
						if ($vn_type_id == $vn_oh_id) {
							print "<div class='unit'><h6>Date of Interview</h6><div class='data'>".$vs_date."</div></div>";
						} else {
							print "<div class='unit'><h6>Date Created</h6><div class='data'>".$vs_date."</div></div>";
						}
					}
				}
				if ($vs_alt_name = $t_object->get('ca_objects.alternate_object_name', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Alternative Name</h6><div class='data'>".$vs_alt_name."</div></div>";
				}	
				if ($vs_credit_line = $t_object->get('ca_objects.credit_line', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Donor</h6><div class='data'>".$vs_credit_line."</div></div>";
				}	
				if ($vs_restrictions = $t_object->get('ca_objects.restrictions', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Restrictions</h6><div class='data'>".$vs_restrictions."</div></div>";
				}					
				if ($vs_format = $t_object->get('ca_objects.format', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Format</h6><div class='data'>".$vs_format."</div></div>";
				}
				if ($vs_event = $t_object->get('ca_objects.event', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Event</h6><div class='data'>".$vs_event."</div></div>";
				}
				if ($va_dims_array = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
					$vs_buf_dims = "";
					$va_dims_info = array();
					foreach ($va_dims_array as $va_key => $va_dims_t) {
						foreach ($va_dims_t as $va_key => $vs_dims) {
							if ($vs_dims['dimensions_height']) {
								$va_dims_info[] = $vs_dims['dimensions_height']." H";
							}
							if ($vs_dims['dimensions_width']) {
								$va_dims_info[] = $vs_dims['dimensions_width']." W";
							}							
							if ($vs_dims['dimensions_depth']) {
								$va_dims_info[] = $vs_dims['dimensions_depth']." D";
							}							
							if ($vs_dims['dimensions_length']) {
								$va_dims_info[] = $vs_dims['dimensions_length']." L";
							}
							if ($vs_dims['dimensions_diameter']) {
								$va_dims_info[] = $vs_dims['dimensions_diameter']." Diameter";
							}
							$vs_buf_dims.= join(" x ", $va_dims_info);							
							if ($vs_dims['measurement_notes']) {
								$vs_buf_dims.= " ".$vs_dims['measurement_notes'];
							}	
							if ($vs_dims['measurement_type']) {
								$vs_buf_dims.= ", ".$vs_dims['measurement_type'];
							}														
						}
					}
					
					if (sizeof($va_dims_info) > 0) {
						print "<div class='unit'><h6>Measurements</h6><div class='data'>".$vs_buf_dims."</div></div>";
					}
				}											
				if ($vs_medium = $t_object->get('ca_objects.medium', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Medium</h6><div class='data'>".$vs_medium."</div></div>";
				}
				if ($vs_material = $t_object->get('ca_objects.material', array('delimiter' => '; '))) {
					print "<div class='unit'><h6>Material</h6><div class='data'>".$vs_material."</div></div>";
				}
				if ($va_entities = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_entities" excludeRelationshipTypes="interviewer,interviewee,author"><l>^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</l> (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Object Entities</h6><div class='data'>".$va_entities."</div></div>";
				}
				if ($va_interviewer = $t_object->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities" restrictToRelationshipTypes="interviewer"><l>^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</l></unit>')) {
					print "<div class='unit'><h6>Interviewer</h6><div class='data'>".$va_interviewer."</div></div>";
				}
				if ($va_interviewee = $t_object->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities" restrictToRelationshipTypes="interviewee"><l>^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</l></unit>')) {
					print "<div class='unit'><h6>Interviewee</h6><div class='data'>".$va_interviewee."</div></div>";
				}								
				if ($va_object = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_objects.related"><l>^ca_objects.preferred_labels, ^ca_objects.idno</l></unit></unit>')) {
					print "<div class='unit'><h6>Related Items</h6><div class='data'>".$va_object."</div></div>";
				}
				# --- access points
				$va_access_points = array();
				$va_subjects = $t_object->get('ca_list_items.preferred_labels', array('returnAsArray' => true));
				$va_getty = $t_object->get('ca_objects.aat', array('returnAsArray' => true));
				$va_lcsh = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true));
				$va_access_points = array_merge($va_subjects, $va_getty, $va_lcsh);
				if (sizeof($va_access_points)) {
					$va_access_points_sorted = array();
					foreach($va_access_points as $vs_access_point){
						$vs_access_point = trim(preg_replace("/\[[^\]]*\]/", "", $vs_access_point));
						if($vs_access_point){
							$va_access_points_sorted[$vs_access_point] = caNavLink($this->request, $vs_access_point, "", "", "MultiSearch",  "Index", array('search' => $vs_access_point));
						}
					}
					ksort($va_access_points_sorted, SORT_NATURAL | SORT_FLAG_CASE);
					print "<div class='unit'><h6>Access Points</h6><div class='data'>";
					print join("<br/>", $va_access_points_sorted);
					print "</div></div>";
				}
				
				$va_lc_names = $t_object->get('ca_objects.lc_names', array('returnAsArray' => true));
				if (sizeof($va_lc_names)) {
					$va_lc_names_sorted = array();
					foreach($va_lc_names as $lc_name){
						$lc_name = trim(preg_replace("/\[[^\]]*\]/", "", $lc_name));
						if($lc_name){
							$va_lc_names_sorted[$lc_name] = caNavLink($this->request, $lc_name, "", "", "MultiSearch",  "Index", array('search' => $lc_name));
						}
					}
					ksort($va_lc_names_sorted, SORT_NATURAL | SORT_FLAG_CASE);
					print "<div class='unit'><h6>Names</h6><div class='data'>";
					print join("<br/>", $va_lc_names_sorted);
					print "</div></div>";
				}
				
				
				#if ($vs_subjects = $t_object->get('ca_list_items.preferred_labels', array('delimiter' => '; '))) {
				#	print "<div class='unit'><h6>Access Points</h6><div class='data'>".$vs_subjects."</div></div>";
				#}
				#if ($vs_lcsh = $t_object->get('ca_objects.lcsh_terms', array('delimiter' => '; '))) {
				#	print "<div class='unit'><h6>Library of Congress Subject Headings</h6><div class='data'>".$vs_lcsh."</div></div>";
				#}
				#if ($vs_getty = $t_object->get('ca_objects.aat', array('delimiter' => '; '))) {
				#	print "<div class='unit'><h6>Getty AAT</h6><div class='data'>".$vs_getty."</div></div>";
				#}												
				if ($vs_description = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
					print "<div class='unit text'><h6>Object Description</h6><div class=''>".$vs_description."</div></div>";
				}
				if ($vs_prov = $t_object->get('ca_objects.provenance', array('delimiter' => '<br/>'))) {
					print "<div class='unit text'><h6>Origin</h6><div class=''>".$vs_prov."</div></div>";
				}																																																					
?>
				
				<div class='unit text'><H6>Rights and Reproduction</H6>
					<div>{{{rightsrepro}}}</div>
				</div>
				<div class='unit'><h6>Citation</h6><div>
<?php
					$va_citation_parts = array();
					if($vn_type_id == $vn_book_id){
						#Book citation: Last Name, First Name. Title of Book. Publisher City: Publisher Name, Year Published.
						if ($vs_author = $t_object->getWithTemplate('<unit delimiter="; " relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="author" delimiter="; ">^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</unit>')) {
							$va_citation_parts[] = $vs_author;
						}
						if($vs_tmp = $t_object->get('ca_objects.title')){
							$va_citation_parts[] = $vs_tmp;
						}
						$vs_tmp = "";
						if($vs_tmp = $t_object->get('ca_objects.pubplace')){
							$vs_tmp = $vs_tmp.": ";
						}
						if ($vs_publisher = $t_object->getWithTemplate('<unit delimiter="; " relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="publisher" delimiter="; ">^ca_entities.preferred_labels.displayname</unit>')) {
							$vs_tmp .= $vs_publisher;
						}
						if($va_date = $t_object->get('ca_objects.date_created', array('returnAsArray' => true))){
							# --- clear out empty values
							$va_date_clean = array();
							foreach($va_date as $vs_date){
								if(trim($vs_date)){
									$va_date_clean[] = trim($vs_date); 
								}
							}
							if($vs_publisher){
								$vs_tmp .= ", ";
							}
							$vs_tmp .= join($va_date_clean, ", ");
						}
						if($vs_tmp){
							$va_citation_parts[] = $vs_tmp;
						}
						$vs_citation_part1 = join(". ", $va_citation_parts).". ";
					}else{
						#Artifacts/Photos
						#Object Name, Date, Collection Title (if applicable), National Hellenic Museum, Link to object. Accessed [Today’s date].
 
						#Oral Histories:
						#Oral History interview with First name Last name, Date of interview, Collection Title (if applicable), National Hellenic Museum, Link to oral history. Accessed [Today’s date].
 
						switch($vn_type_id){
							case $vn_oh_id:
								if ($vs_interviewee = $t_object->getWithTemplate('<unit delimiter="; " relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="interviewee">^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</unit>')) {
									$va_citation_parts[] = "Oral History interview with ".$vs_interviewee;
								}
							break;
							# --------------------
							default:
					
								if($vs_tmp = trim($t_object->get('ca_objects.preferred_labels'))){
									$va_citation_parts[] = $vs_tmp;
								}
							break;
							# --------------------
						}
						if($va_tmp = $t_object->get('ca_objects.date_created', array('returnAsArray' => true))){
							foreach($va_tmp as $vs_date){
								if(trim($vs_date)){
									$va_citation_parts[] = trim($vs_date); 
								}
							}
						}
						if($vs_tmp = trim($t_object->getWithTemplate('<ifcount code="ca_collections" min="1"><unit delimiter=". "><unit relativeTo="ca_collections">^ca_collections.preferred_labels</unit></unit></ifcount>'))){
							$va_citation_parts[] = $vs_tmp;
						}
						$vs_citation_part1 = join(", ", $va_citation_parts).", ";
					}
					print $vs_citation_part1."<i>National Hellenic Museum</i>, ".$this->request->config->get("site_host").caDetailUrl($this->request, "ca_objects", $vn_id).". Accessed ".date("m/d/y").".";
?>
				</div></div>
				{{{map}}}
								
<?php	
				# Comment/ Share / pdf / ask archivist tools
						
					print '<div id="detailTools">';
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Inquire About This Item", "", "", "Contact",  "form", array('table' => 'ca_objects', 'id' => $vn_id))."</div>";
					
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
				
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}					

					print '</div><!-- end detailTools -->';				

?>										
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
