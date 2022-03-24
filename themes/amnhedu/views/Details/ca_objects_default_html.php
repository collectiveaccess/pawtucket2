<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">

			<div class='col-sm-6 col-md-6 col-lg-5'>
				<br/><h1>{{{^ca_objects.object_types}}}{{{ca_objects.preferred_labels.name}}}</h1><br/><br/>
				{{{<ifdef code="ca_objects.idno"><p><b>Identifier: </b>^ca_objects.idno</p></ifdef>}}}
				{{{<ifdef code="ca_objects.description"><p><b>Description: </b><span class="trimText">^ca_objects.description</span><br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.division"><p><b>Division: </b>^ca_objects.division<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.specimen_category"><p><b>Category: </b>^ca_objects.specimen_category<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.artifact_category"><p><b>Category: </b>^ca_objects.artifact_category<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.location_description"><p><b>Location Description: </b>^ca_objects.location_description<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.dimensions_text"><p><b>Dimensions: </b>^ca_objects.dimensions_text<br/></p></ifdef>}}}		
				{{{<ifdef code="ca_objects.anthro_culture"><p><b>Culture: </b>^ca_objects.anthro_culture<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.anthro_material"><p><b>Material: </b>^ca_objects.anthro_material<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.anthro_technique"><p><b>Technique: </b>^ca_objects.anthro_technique<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.anthro_period"><p><b>Period: </b>^ca_objects.anthro_period<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.anthro_locale"><p><b>Locale: </b>^ca_objects.anthro_locale<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.specimen_locale"><p><b>Locale: </b>^ca_objects.specimen_locale<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.anthro_state_province"><p><b>State/Province: </b>^ca_objects.anthro_state_province<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.anthro_country"><p><b>Country: </b>^ca_objects.anthro_country<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.administrative_remarks"><p><b>Administrative Remarks: </b>^ca_objects.administrative_remarks<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.admin_condition_criteria"><p><b>Condition Criteria: </b>^ca_objects.admin_condition_criteria<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.current_condition_dropdown"><p><b>Current Condition: </b>^ca_objects.current_condition_dropdown<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.current_condition"><p><b>Condition Notes: </b>^ca_objects.current_condition<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.restrictions"><p><b>Restrictions: </b>^ca_objects.restrictions<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.rights_restrictions"><p><b>Rights & Restrictions: </b>^ca_objects.rights_restrictions<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.use_for_education"><p><b>Use for Education: </b>^ca_objects.use_for_education<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.use_for_programs"><p><b>Use for Programs: </b>^ca_objects.use_for_programs<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.use_for_education_materials"><p><b>Use for Education Materials: </b>^ca_objects.use_for_education_materials<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.use_online"><p><b>Use Online: </b>^ca_objects.use_online<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_objects.use_for_outreach"><p><b>Use for Outreach: </b>^ca_objects.use_for_outreach<br/></p></ifdef>}}}				
				{{{<ifdef code="ca_storage_locations.preferred_labels"><p><b>Storage Location: </b>^ca_storage_locations.hierarchy.preferred_labels%delimiter=_➜_%removeFirstItems=1<br/></p></ifdef>}}}				
			
				<hr></hr>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><p><b>Related Entity: </b></p></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><p><b>Related Entities: </b></p></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><p>^ca_entities.preferred_labels</p></unit></unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter="<br/>"><unit relativeTo="ca_list_items"><l>^ca_list_items.preferred_labels.name_plural</l></unit> (^relationship_typename)</unit>}}}
							
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
						
			</div><!-- end col -->
					<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
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