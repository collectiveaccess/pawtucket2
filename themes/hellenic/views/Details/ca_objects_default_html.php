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
	$vs_type_id = 			$t_object->get('ca_objects.type_id');
	$t_list = new ca_lists();
	$vs_oh_id = $t_list->getItemIDFromList("object_types", "oral_history");
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
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2", 'version' => 'iconlarge')); ?>

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
				if ($va_collection = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Object Collection</h6><div class='data'>".$va_collection."</div></div>";
				}
				if ($vs_date = $t_object->get('ca_objects.date_created', array('delimiter' => '; '))) {
					if ($vs_type_id == $vs_oh_id) {
						print "<div class='unit'><h6>Date of Interview</h6><div class='data'>".$vs_date."</div></div>";
					} else {
						print "<div class='unit'><h6>Date Created</h6><div class='data'>".$vs_date."</div></div>";
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
				if ($va_entities = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</l> (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Object Entities</h6><div class='data'>".$va_entities."</div></div>";
				}
				if ($va_interviewer = $t_object->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="interviewer"><l>^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</l></unit>')) {
					print "<div class='unit'><h6>Interviewer</h6><div class='data'>".$va_interviewer."</div></div>";
				}
				if ($va_interviewee = $t_object->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="interviewee"><l>^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</l></unit>')) {
					print "<div class='unit'><h6>Interviewee</h6><div class='data'>".$va_interviewee."</div></div>";
				}								
				if ($va_collection = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Related Collections</h6><div class='data'>".$va_collection."</div></div>";
				}	
				if ($va_object = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_objects.related"><l>^ca_objects.preferred_labels, ^ca_objects.idno</l></unit></unit>')) {
					print "<div class='unit'><h6>Related Items</h6><div class='data'>".$va_object."</div></div>";
				}
				if ($vs_subjects = $t_object->get('ca_list_items.preferred_labels', array('delimiter' => '; '))) {
					print "<div class='unit'><h6>Access Points</h6><div class='data'>".$vs_subjects."</div></div>";
				}
				if ($vs_lcsh = $t_object->get('ca_objects.lcsh_terms', array('delimiter' => '; '))) {
					print "<div class='unit'><h6>Library of Congress Subject Headings</h6><div class='data'>".$vs_lcsh."</div></div>";
				}
				if ($vs_getty = $t_object->get('ca_objects.aat', array('delimiter' => '; '))) {
					print "<div class='unit'><h6>Getty AAT</h6><div class='data'>".$vs_getty."</div></div>";
				}												
				if ($vs_description = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
					print "<div class='unit text'><h6>Object Description</h6><div class=''>".$vs_description."</div></div>";
				}
				if ($vs_prov = $t_object->get('ca_objects.provenance', array('delimiter' => '<br/>'))) {
					print "<div class='unit text'><h6>Origin</h6><div class=''>".$vs_prov."</div></div>";
				}																																																					
?>
				<div class='unit text'><a href="#" onclick="$('#rightsRepro').slideToggle(); return false;"><H6>Rights and Reproduction <i class="fa fa-chevron-down" aria-hidden="true"></i></H6></a>
					<div style="display:none;" id="rightsRepro">{{{rightsrepro}}}</div>
				</div>
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