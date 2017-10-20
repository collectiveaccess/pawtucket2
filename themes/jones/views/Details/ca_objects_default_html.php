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
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10 contentArea'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
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
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<HR>
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><h6>Description</h6>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}	
<?php				
				if ($va_date = $t_object->getWithTemplate('<unit>^ca_objects.date.date_value (^ca_objects.date.date_types)</unit>')) {
					print "<div class='unit'><h6>Date</h6>".$va_date."</div>";
				}
				if ($va_entity_rels = $t_object->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true, 'excludeRelationshipTypes' => array('publisher')))) {
					$va_entities_by_type = array();
					foreach ($va_entity_rels as $va_key => $va_entity_rel) {
						$t_rel = new ca_objects_x_entities($va_entity_rel);
						$vn_type_id = $t_rel->get('ca_relationship_types.preferred_labels');
						$va_entities_by_type[$vn_type_id][] = caNavLink($this->request, $t_rel->get('ca_entities.preferred_labels'), '', '', 'Detail', 'entities/'.$t_rel->get('ca_entities.entity_id'));
					}
					print "<div class='unit'>";
					foreach ($va_entities_by_type as $va_type => $va_entity_id) {
						print "<h6>".$va_type."</h6>";
						foreach ($va_entity_id as $va_key => $va_entity_link) {
							print "<p>".$va_entity_link."</p>";
						} 
					}
					print "</div>";
				}
				if ($va_collections = $t_object->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', '))) {
					print "<div class='unit'><h6>Related Collection</h6>".$va_collections."</div>";
				}
				if ($vs_format = $t_object->get('ca_objects.original_format', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Original Format</h6>".$vs_format."</div>";
				}				
				if ($va_dimensions = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true))) {
					$va_dims = array();
					$va_dimsnotes = "";
					foreach ($va_dimensions as $va_key => $va_dimension_t) {
						foreach ($va_dimension_t as $va_key => $va_dimension) {
							if ($va_dimension['dimensions_length']) {
								$va_dims[] = $va_dimension['dimensions_length']." L";
							}
							if ($va_dimension['dimensions_width']) {
								$va_dims[] = $va_dimension['dimensions_width']." W";
							}
							if ($va_dimension['dimensions_height']) {
								$va_dims[] = $va_dimension['dimensions_height']." H";
							}
							if ($va_dimension['dimensions_thickness']) {
								$va_dims[] = $va_dimension['dimensions_thickness']." D";
							}
							if ($va_dimension['dimensions_weight']) {
								$va_dimsnotes.= "<br/>".$va_dimension['dimensions_weight']." (weight)";
							}
							if ($va_dimension['measurement_notes']) {
								$va_dimsnotes.= "<br/>".$va_dimension['measurement_notes'];
							}																																		
						}
					}
					print "<div class='unit'><h6>Dimensions</h6>".join(" X ", $va_dims ).$va_dimsnotes."</div>";
				}
				if ($vs_duration = $t_object->get('ca_objects.duration', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Duration</h6>".$vs_duration."</div>";
				}
				if ($vs_source = $t_object->get('ca_objects.source')) {
					print "<div class='unit'><h6>Source</h6>".$vs_source."</div>";
				}
				if ($vs_language = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Language</h6>".$vs_language."</div>";
				}																
				if ($vs_rights = $t_object->get('ca_objects.rights', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Rights</h6>".$vs_rights."</div>";
				}							
?>
				{{{<ifdef code="ca_objects.idno"><H6>Identifier:</H6>^ca_objects.idno<br/></ifdef>}}}
<?php
				if ($vs_subjects = $t_object->get('ca_list_items.item_id', array('returnAsArray' => true, 'restrictToLists' => array('subjects')))) {
					print "<div class='unit'><h6>Subjects</h6>";
					foreach ($vs_subjects as $va_key => $vs_subject_id) {
						print "<p>".caNavLink($this->request, caGetListItemByIDForDisplay($vs_subject_id, true), '', '', 'Search', 'objects', array('search' => 'ca_list_items.item_id:'.$vs_subject_id))."</p>"; 
					}
					print "</div>";
				}
				if ($vs_keywords = $t_object->get('ca_list_items.item_id', array('returnAsArray' => true, 'restrictToLists' => array('keywords')))) {
					print "<div class='unit'><h6>Keywords</h6>";
					foreach ($vs_keywords as $va_key2 => $vs_keyword_id) {
						print "<p>".caNavLink($this->request, caGetListItemByIDForDisplay($vs_keyword_id, true), '', '', 'Search', 'objects', array('search' => 'ca_list_items.item_id:'.$vs_keyword_id))."</p>"; 
					}					
					print "</div>";
				}
				
/*								

				if ($vs_condition = $t_object->get('ca_objects.condition', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Condition</h6>".$vs_condition."</div>";
				}
				if ($vs_provenance = $t_object->get('ca_objects.provenance')) {
					print "<div class='unit'><h6>Provenance</h6>".$vs_provenance."</div>";
				}	
				if ($vs_text = $t_object->get('ca_objects.text', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Text</h6>".$vs_text."</div>";
				}	
				if ($vs_duration = $t_object->get('ca_objects.duration', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Duration</h6>".$vs_duration."</div>";
				}

				if ($vs_lcsh = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true))) {
					print "<div class='unit'><h6>Library of Congress Subject Headings</h6>";
					foreach ($vs_lcsh as $va_key2 => $vs_lcsh_name) {
						$vs_lcsh_name_term = explode('[',$vs_lcsh_name);
						print "<p>".caNavLink($this->request, $vs_lcsh_name_term[0], '', '', 'Search', 'objects', array('search' => 'ca_objects.lcsh_terms:"'.$vs_lcsh_name_term[0].'"'))."</p>"; 
					}					
					print "</div>";
				}
*/																																									
?>			
				<hr></hr>

				{{{map}}}
						
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