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
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id<ifdef code="ca_objects.resource_type">: ^ca_objects.resource_type</ifdef></unit>}}}</H6>
				{{{<ifdef code="ca_objects.displayDate"><div class='unit'><h6>Date</h6>^ca_objects.displayDate</div></ifdef>}}}
				
<?php
		include("curation_html.php");
?>				
				
				{{{<ifcount code="ca_entities.related" restrictToTypes="repository" min="1"><H6>Repository</H6><unit relativeTo="ca_entities.related" restrictToTypes="repository" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>}}}

				{{{<ifdef code="ca_objects.nonpreferred_labels.name"><HR/><H6>Alternate Title(s)</H6><unit relativeTo="ca_objects" delimiter="<br/>">^nonpreferred_labels.name</unit></ifdef>}}}
				
				{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="artist,author,composer,contributor,creator,curator,director,editor,filmmaker,funder,illustrator,interviewee,interviewer,narrator,organizer,performer,photographer,producer,repository,researcher" min="1"><H6>Creators and Contributors</H6><unit relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="artist,author,composer,contributor,creator,curator,director,editor,filmmaker,funder,illustrator,interviewee,interviewer,narrator,organizer,performer,photographer,producer,repository,researcher" delimiter=", "><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit></ifcount>}}}
				
				{{{<ifdef code="ca_objects.RAD_statement"><div class='unit'><h6>Statement of Responsibility</h6>^ca_objects.RAD_statement</div></ifdef>}}}
				{{{<ifdef code="ca_objects.RAD_extent"><div class='unit'><h6>Extent and Medium</h6>^ca_objects.RAD_extent</div></ifdef>}}}
				
			</div>
		</div>
		<div class="row">
			<div class='col-sm-12'>


				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#source_allied" aria-controls="source_allied" role="tab" data-toggle="tab">Source/ Allied Materials</a></li>
					<li role="presentation"><a href="#context_content" aria-controls="context_content" role="tab" data-toggle="tab">Context/ Content and Structure</a></li>
					<li role="presentation"><a href="#conditions_access" aria-controls="conditions_access" role="tab" data-toggle="tab">Conditions of Access and Use</a></li>
					<li role="presentation"><a href="#notes_desc" aria-controls="notes_desc" role="tab" data-toggle="tab">Notes/ Description Control</a></li>
					<li role="presentation"><a href="#related" aria-controls="related" role="tab" data-toggle="tab">Related</a></li>
					<li role="presentation"><a href="#rights" aria-controls="rights" role="tab" data-toggle="tab">Rights</a></li>
					<li role="presentation"><a href="#map-tab" aria-controls="map-tab" role="tab" data-toggle="tab">Map</a></li>
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="source_allied">
						{{{<ifdef code="ca_objects.source_identifier"><div class='unit'><h6>Source Object Identifier</h6>^ca_objects.source_identifier</div></ifdef>}}}
						{{{<ifcount code="ca_collections.related" restrictToTypes="source" min="1"><H6>Source Fonds or Collection</H6><unit relativeTo="ca_collections.related" restrictToTypes="source" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></ifcount>}}}
						{{{<ifdef code="ca_objects.link"><div class='unit'><h6>Link to record in home repository</h6><a href="^ca_objects.link" target="_blank">^ca_objects.link</a></div></ifdef>}}}
						{{{<ifdef code="ca_objects.RAD_originals"><div class='unit'><h6>Existence and Location of Originals</h6><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.RAD_originals.RAD_originals_text<ifdef code="ca_objects.RAD_originals.RAD_originals_Url"><br/>^ca_objects.RAD_originals.RAD_originals_Url</ifdef></div></ifdef>}}}
						{{{<ifdef code="ca_objects.RAD_availability"><div class='unit'><h6>Existence and Location of Copies, including Digital Surrogates</h6><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.RAD_availability.RAD_availability_text<ifdef code="ca_objects.RAD_availability.RAD_availability_Url"><br/>^ca_objects.RAD_availability.RAD_availability_Url</ifdef></div></ifdef>}}}
						{{{<ifdef code="ca_objects.RAD_material"><div class='unit'><h6>Related Units of Description</h6><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.RAD_material.RAD_material_text<ifdef code="ca_objects.RAD_material.RAD_material_Url"><br/>^ca_objects.RAD_material.RAD_material_Url</ifdef></div></ifdef>}}}
						{{{<ifdef code="ca_objects.RAD_pubDesc"><div class='unit'><h6>Publication Note</h6><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.RAD_pubDesc.RAD_pubDesc_text<ifdef code="ca_objects.RAD_pubDesc.RAD_pubDesc_Url"><br/>^ca_objects.RAD_pubDesc.RAD_pubDesc_Url</ifdef></div></ifdef>}}}
					</div>
					<div role="tabpanel" class="tab-pane" id="context_content">
						{{{<ifdef code="ca_objects.RAD_pubName"><div class='unit'><h6>Publisher, Distributor, Producer, etc.</h6>^ca_objects.RAD_pubName</div></ifdef>}}}
						{{{<ifdef code="ca_objects.RAD_admin_hist"><div class='unit'><h6>Administrative/ Biographical History</h6>^ca_objects.RAD_admin_hist</div></ifdef>}}}
						{{{<ifdef code="ca_objects.archival_history"><div class='unit'><h6>Object Archival History</h6>^ca_objects.archival_history</div></ifdef>}}}
						{{{<ifdef code="ca_objects.RAD_scopecontent"><div class='unit'><h6>Scope and Content</h6>^ca_objects.RAD_scopecontent</div></ifdef>}}}
						{{{<ifdef code="ca_objects.RAD_caption"><div class='unit'><h6>Caption, Signatures and Inscriptions</h6>^ca_objects.RAD_caption</div></ifdef>}}}
					</div>
					<div role="tabpanel" class="tab-pane" id="conditions_access">
<!--  change to language after next run 11/21 -->{{{<ifdef code="ca_objects.RAD_langMaterial"><div class='unit'><h6>Language/Scripts of Material</h6><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.RAD_langMaterial</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.language_note"><div class='unit'><h6>Language Note</h6><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.language_note</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.alternate_text.alternate_desc_upload.url"><div class='unit icon'><h6>Alternate Text</h6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.alternate_text.alternate_desc_upload"><a href="^ca_objects.alternate_text.alternate_desc_upload.url%version=original">View file</a><br/></ifdef><ifdef code="ca_objects.alternate_text.alternate_text_type">^ca_objects.alternate_text.alternate_text_type<br/></ifdef><ifdef code="ca_objects.alternate_text.alternate_desc_note">^ca_objects.alternate_text.alternate_desc_note</ifdef></unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.RAD_condition"><div class='unit'><h6>Physical Characteristics and Technical Requirements</h6>^ca_objects.RAD_condition</div></ifdef>}}}
					</div>
					<div role="tabpanel" class="tab-pane" id="notes_desc">
						{{{<ifdef code="ca_objects.ISADG_titleNote"><div class='unit'><h6>Title Note</h6>^ca_objects.ISADG_titleNote</div></ifdef>}}}
						{{{<ifdef code="ca_objects.ISADG_dateNote"><div class='unit'><h6>Date Note</h6>^ca_objects.ISADG_dateNote</div></ifdef>}}}
<!-- change to MARC_generalNote  after next data revision 11/21-->{{{<ifdef code="ca_objects.RAD_generalNote"><div class='unit'><h6>Notes</h6>^ca_objects.RAD_generalNote</div></ifdef>}}}
						{{{<ifdef code="ca_objects.ISADG_archNote"><div class='unit'><h6>Note on Description</h6>^ca_objects.ISADG_archNote</div></ifdef>}}}
						{{{<ifdef code="ca_objects.ISADG_rules"><div class='unit'><h6>Rules or Conventions</h6>^ca_objects.ISADG_rules</div></ifdef>}}}
						{{{<ifdef code="ca_objects.description_date"><div class='unit'><h6>Date(s) of Description(s)</h6>^ca_objects.description_date</div></ifdef>}}}
					</div>
					<div role="tabpanel" class="tab-pane" id="related">
						{{{<ifcount code="ca_objects.related" restrictToTypes="archival_external,archival_internal" min="1"><H6>Related Archival Items</H6><unit relativeTo="ca_objects.related" restrictToTypes="archival_external,archival_internal" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifcount>}}}
						{{{<ifcount code="ca_objects.related" excludeTypes="archival_external,archival_internal" min="1"><H6>Related Library Items, Museum Works, and Testimonies</H6><unit relativeTo="ca_objects.related" excludeTypes="archival_external,archival_internal" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifcount>}}}
				
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