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
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
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
				<H4 data-toggle="popover" data-placement="left" data-trigger="hover" title="Source" data-content="{{{^ca_objects.ISADG_titleNote}}}">{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit><ifdef code="ca_objects.resource_type">^ca_objects.resource_type%useSingular=1</ifdef></unit>}}}</H6>
				{{{<ifdef code="ca_objects.parent_id"><H6>Part of: <unit relativeTo="ca_objects.hierarchy" delimiter=" &gt; "><l>^ca_objects.preferred_labels.name</l></unit></H6></ifdef>}}}
				{{{<ifdef code="ca_objects.displayDate"><div class='unit'>^ca_objects.displayDate</div></ifdef>}}}
				{{{<ifdef code="ca_objects.IRSHDC_identifier"><div class='unit'><h6>IRSHDC Identifier</h6>^ca_objects.IRSHDC_identifier</div></ifdef>}}} 
				
<?php
		include("curation_html.php");
?>				
				
				{{{<ifcount code="ca_entities.related" restrictToTypes="repository" min="1"><H6>Repository</H6><unit relativeTo="ca_entities.related" restrictToTypes="repository" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>}}}

				{{{<ifdef code="ca_objects.nonpreferred_labels.name"><HR/><H6>Alternate Title(s)</H6><unit relativeTo="ca_objects" delimiter="<br/>">^nonpreferred_labels.name</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.cdwa_display_creator"><H6>Display Creator</H6><unit delimiter="<br/>">^ca_objects.cdwa_display_creator</unit></ifdef>}}}
				{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="artist,author,composer,contributor,creator,curator,director,editor,filmmaker,funder,illustrator,interviewee,interviewer,narrator,organizer,performer,photographer,producer,repository,researcher" min="1"><H6>Creators and Contributors</H6><unit relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="artist,author,composer,contributor,creator,curator,director,editor,filmmaker,funder,illustrator,interviewee,interviewer,narrator,organizer,performer,photographer,producer,repository,researcher" delimiter=", "><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit></ifcount>}}}
				{{{<ifdef code="ca_objects.cdwa_displayMeasurements"><H6>Display Measurements</H6><unit delimiter=", ">^ca_objects.cdwa_displayMeasurements</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.classification"><H6>Classification</H6><unit delimiter=", ">^ca_objects.classification</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.material_tech"><H6>Materials/Techniques</H6><unit delimiter=", ">^ca_objects.material_tech</unit></ifdef>}}}
				
				{{{<ifcount code="ca_places" min="1" max="1"><hr/><H6>Related place</H6></ifcount>}}}
				{{{<ifcount code="ca_places" min="2"><hr/><H6>Related places</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
								
				{{{<ifdef code="ca_objects.history_use"><H6>History of Use</H6><unit delimiter="<br/>">^ca_objects.history_use</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.narrative"><H6>Narrative</H6><unit delimiter="<br/>">^ca_objects.narrative</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.cultural_context"><H6>Cultural Context</H6><unit delimiter="<br/>">^ca_objects.cultural_context</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.specific_techniques"><H6>Specific Techniques</H6><unit delimiter="<br/>">^ca_objects.specific_techniques</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.inscriptions"><H6>Inscriptions</H6><unit delimiter="<br/>">^ca_objects.inscriptions</unit></ifdef>}}}
				
				
				
				
				
				
						
				
								
			</div>
		</div>
		<div class="row">
			<div class='col-sm-12'>


				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#source" aria-controls="source" role="tab" data-toggle="tab">Source</a></li>
					<li role="presentation"><a href="#ownership" aria-controls="ownership" role="tab" data-toggle="tab">Ownership</a></li>
					<li role="presentation"><a href="#notes" aria-controls="notes" role="tab" data-toggle="tab">Notes</a></li>
					<li role="presentation"><a href="#related" aria-controls="related" role="tab" data-toggle="tab">Related</a></li>
					<li role="presentation"><a href="#rights" aria-controls="rights" role="tab" data-toggle="tab">Rights</a></li>
					<li role="presentation"><a href="#map-tab" aria-controls="map-tab" role="tab" data-toggle="tab">Map</a></li>
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="source">
						{{{<ifdef code="ca_objects.source_identifier"><div class='unit'><h6>Holding Repository Object Identifier</h6><unit delimiter=", ">^ca_objects.source_identifier</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.link"><div class='unit'><h6>Link to record in home repository</h6><a href="^ca_objects.link" target="_blank">^ca_objects.link</a></div></ifdef>}}}
						
					</div>
					<div role="tabpanel" class="tab-pane" id="ownership">
						{{{<ifdef code="ca_objects.ownership_provenance"><div class='unit'><h6>Provenance Description</h6><unit delimiter="<br/>">^ca_objects.ownership_provenance</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.ownership_credit"><div class='unit'><h6>Credit/caption</h6><unit delimiter="<br/>">^ca_objects.ownership_credit</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.internal_notes"><div class='unit'><h6>Notes</h6><unit delimiter="<br/>">^ca_objects.internal_notes</unit></div></ifdef>}}}
						
						{{{<ifdef code="ca_objects.ownership_transfer"><div class='unit'><h6>Transfer Mode</h6><unit delimiter="<br/>">^ca_objects.ownership_transfer</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.ownership_transfer_notes"><div class='unit'><h6>Note: Transfer Mode</h6><unit delimiter="<br/>">^ca_objects.ownership_transfer_notes</unit></div></ifdef>}}}
						
					</div>
					<div role="tabpanel" class="tab-pane" id="notes">
						{{{<ifdef code="ca_objects.language"><div class='unit'><h6>Language</h6><unit delimiter="<br/>">^ca_objects.language</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.language_note"><div class='unit'><h6>Local Note</h6><unit delimiter="<br/>">^ca_objects.language_note</unit></div></ifdef>}}}			
						
						{{{<ifdef code="ca_objects.alternate_text.alternate_desc_upload.url"><div class='unit icon'><h6>Transcriptions/Translations</h6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.alternate_text.alternate_desc_upload"><a href="^ca_objects.alternate_text.alternate_desc_upload.url%version=original">View file</a><br/></ifdef><ifdef code="ca_objects.alternate_text.alternate_text_type">^ca_objects.alternate_text.alternate_text_type<br/></ifdef><ifdef code="ca_objects.alternate_text.alternate_desc_note">^ca_objects.alternate_text.alternate_desc_note</ifdef></unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.ISADG_archNote"><div class='unit'><h6>Archivist's Note</h6><unit delimiter="<br/>">^ca_objects.ISADG_archNote</unit></div></ifdef>}}}			
				
					</div>
					<div role="tabpanel" class="tab-pane" id="related">
						{{{<ifcount code="ca_objects.related" restrictToTypes="work" min="1"><H6>Related Museum Works</H6><unit relativeTo="ca_objects_x_objects" restrictToTypes="work" delimiter=", "><unit relativeTo="ca_objects"><l>^ca_objects.preferred_labels.name</l></unit> (^relationship_typename)</unit></ifcount>}}}
						{{{<ifcount code="ca_objects.related" excludeTypes="work" min="1"><H6>Related Library Items, Survivors Testimonies, and Archival Items</H6><unit relativeTo="ca_objects_x_objects" excludeTypes="work" delimiter=", "><unit relativeTo="ca_objects"><l>^ca_objects.preferred_labels.name</l></unit> (^relationship_typename)</unit></ifcount>}}}

<?php
					include("related_html.php");
?>											
					</div>
					<div role="tabpanel" class="tab-pane" id="rights">
<?php
					include("rights_html.php");
?>						
					</div>
					<div role="tabpanel" class="tab-pane" id="map-tab">
						{{{map}}}
					</div>
				</div><!-- end tab-content -->
						
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
		
		$('[data-toggle="popover"]').popover();
		
		
		$("a[href='#map-tab']").on('shown.bs.tab', function(){
		  	google.maps.event.trigger(map, "resize");
		});
	});
</script>