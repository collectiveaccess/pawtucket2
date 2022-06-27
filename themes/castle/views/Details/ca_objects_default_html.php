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
	
	$va_access_values = caGetUserAccessValues($this->request);

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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
						print "<div class='detailTool'><div class='sharethis-inline-share-buttons'></div></div>";
					}
					print '</div><!-- end detailTools -->';
				}				
?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
				if ($va_accession = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Accession Number</h6>".$va_accession."</div>";
				}
				if ($va_altname = $t_object->get('ca_objects.nonpreferred_labels')) {
					print "<div class='unit'><h6>Alternate Name</h6>".$va_altname."</div>";
				}
				if ($va_description = $t_object->get('ca_objects.description')) {
					print "<div class='unit'><h6>Description</h6>".$va_description."</div>";
				}
				if ($va_narrative = $t_object->get('ca_objects.narrative')) {
					print "<div class='unit'><h6>Narrative</h6>".$va_narrative."</div>";
				}
				if ($va_use_history = $t_object->get('ca_objects.use_history')) {
					print "<div class='unit'><h6>History of Use</h6>".$va_use_history."</div>";
				}						
				if ($va_date = $t_object->get('ca_objects.date', array('delimiter' => ', '))) {
					print "<div class='unit'><h6>Date</h6>".$va_date."</div>";
				}	
				if ($va_dimensions = $t_object->getWithTemplate('<ifcount min="1" code="ca_objects.dimensions.display_dimensions"><unit><ifdef code="ca_objects.dimensions.display_dimensions">^ca_objects.dimensions.display_dimensions</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"><br/>^ca_objects.dimensions.dimensions_notes</ifdef></unit></ifcount>')) {
					print "<div class='unit'><h6>Dimensions</h6>".$va_dimensions."</div>";
				}	
				if (($va_material = $t_object->get('ca_objects.material', array('convertCodesToDisplayText' => true, 'delimiter' => '; ')))) {
					print "<div class='unit'><h6>Material</h6>".$va_material."</div>";
				}
				if ($va_artist = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist', 'photographer'), 'delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><h6>Artist/Photographer</h6>".$va_artist."</div>";
				}
				if ($va_manufacturer = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('manufacturer'), 'delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><h6>Manufacturer</h6>".$va_manufacturer."</div>";
				}
				if ($va_brand_name = $t_object->get('ca_objects.brand_name')) {
					print "<div class='unit'><h6>Brand Name</h6>".$va_brand_name."</div>";
				}
				if ($va_serial_number = $t_object->get('ca_objects.serial_number')) {
					print "<div class='unit'><h6>Serial Number</h6>".$va_serial_number."</div>";
				}
				if ($va_patent_number = $t_object->get('ca_objects.patent_number')) {
					print "<div class='unit'><h6>Patent Number</h6>".$va_patent_number."</div>";
				}																
				if ($va_title = $t_object->get('ca_objects.title')) {
					print "<div class='unit'><h6>Artwork Title</h6>".$va_title."</div>";
				}					
				if ($va_phototype = $t_object->get('ca_objects.photograph_type', array('convertCodesToDisplayText' => true, 'delimiter' => '; '))) {
					print "<div class='unit'><h6>Photograph Type</h6>".$va_phototype."</div>";
				}
				if ($va_subject = $t_object->get('ca_objects.subject_image')) {
					print "<div class='unit'><h6>Subject/Image</h6>".$va_subject."</div>";
				}
				if ($va_medium = $t_object->get('ca_objects.medium', array('convertCodesToDisplayText' => true, 'delimiter' => '; '))) {
					print "<div class='unit'><h6>Medium</h6>".$va_medium."</div>";
				}				
				if ($va_support = $t_object->get('ca_objects.support', array('convertCodesToDisplayText' => true, 'delimiter' => '; '))) {
					print "<div class='unit'><h6>Support</h6>".$va_support."</div>";
				}	
				if ($va_technique = $t_object->get('ca_objects.technique', array('convertCodesToDisplayText' => true, 'delimiter' => '; '))) {
					print "<div class='unit'><h6>Technique</h6>".$va_technique."</div>";
				}	
				if ($va_school = $t_object->get('ca_objects.school_style')) {
					print "<div class='unit'><h6>School/Style</h6>".$va_school."</div>";
				}	
				if ($va_inscription = $t_object->get('ca_objects.inscription')) {
					print "<div class='unit'><h6>Inscription</h6>".$va_inscription."</div>";
				}
				if ($va_country = $t_object->get('ca_objects.country_origin')) {
					print "<div class='unit'><h6>Country of Origin</h6>".$va_country."</div>";
				}																																																																														
?>
				<hr></hr>
					<div class="row">
						<div class="col-sm-12">		
							{{{<ifcount code="ca_entities" excludeRelationshipTypes="source_name" min="1" max="1"><H6>Related person/business/organization</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" excludeRelationshipTypes="source_name" min="2"><H6>Related people/businesses/organizations</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" excludeRelationshipTypes="source_name" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit>}}}
							
							{{{<ifcount code="ca_occurrences" restrictToTypes="associations" min="1" max="1"><H6>Related Association</H6></ifcount>}}}
							{{{<ifcount code="ca_occurrences" restrictToTypes="associations" min="2"><H6>Related Associations</H6></ifcount>}}}
							{{{<unit relativeTo="ca_occurrences" restrictToTypes="associations" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</unit>}}}

							{{{<ifcount code="ca_occurrences" restrictToTypes="publications" min="1" max="1"><H6>Related Publications</H6></ifcount>}}}
							{{{<ifcount code="ca_occurrences" restrictToTypes="publications" min="2"><H6>Related Publications</H6></ifcount>}}}
							{{{<unit relativeTo="ca_occurrences" restrictToTypes="publications" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</unit>}}}
<?php
							#if ($va_related_associations = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('associations'), 'returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
							#	print "<div class='unit'><h6>Related Associations</h6>".$va_related_associations."</div>";
							#}
							#if ($va_related_publications = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('publications'), 'returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
							#	print "<div class='unit'><h6>Related Publications</h6>".$va_related_publications."</div>";
							#}
							if ($va_related_objects = $t_object->get('ca_objects.related', array('returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values, 'returnWithStructure' => true))) {
								print "<div class='unit'><h6>Related Objects</h6>";
								foreach ($va_related_objects as $va_id => $va_related_object) {
									print "<p>".caNavLink($this->request, $va_related_object['name'].', '.$va_related_object['idno'], '', '', 'Detail', 'objects/'.$va_related_object['object_id'])." (".$va_related_object['relationship_typename'].")</p>";
								}
								print "</div>";
							}														
?>
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-12 ">
							{{{map}}}
						</div>
					</div><!-- end row -->
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