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
				<H6>{{{<unit><ifdef code="ca_objects.resource_type">^ca_objects.resource_type</ifdef></unit>}}}</H6>
				{{{<ifdef code="ca_objects.parent_id"><H6>Part of: <unit relativeTo="ca_objects.hierarchy" delimiter=" &gt; "><l>^ca_objects.preferred_labels.name</l></unit></H6></ifdef>}}}
				{{{<ifdef code="ca_objects.displayDate"><div class='unit'>^ca_objects.displayDate</div></ifdef>}}}
				{{{<ifdef code="ca_objects.IRSHDC_identifier"><div class='unit'><h6>IRSHDC Identifier</h6>^ca_objects.IRSHDC_identifier</div></ifdef>}}} 
				
<?php
		include("curation_html.php");
?>				
				{{{<ifcount code="ca_entities.related" restrictToTypes="repository" min="1"><H6>Holding Repository</H6><unit relativeTo="ca_entities.related" restrictToTypes="repository" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>}}}
				{{{<ifdef code="ca_objects.nonpreferred_labels.name"><HR/><H6>Alternate Title(s)</H6><unit relativeTo="ca_objects" delimiter="<br/>">^nonpreferred_labels.name</unit></ifdef>}}}
				
				{{{<ifdef code="ca_objects.record_group_id"><H6>Record group Identifier</H6><unit delimiter=", ">^ca_objects.record_group_id</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.file_series"><H6>Series (Short title)</H6><unit delimiter=", ">^ca_objects.file_series</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.record_type"><H6>Record Type</H6><unit delimiter=", ">^ca_objects.record_type</unit></ifdef>}}}
				{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="original_source" min="1"><H6>Original Source</H6><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="original_source" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>}}}
				{{{<ifdef code="ca_objects.alternate_text.alternate_desc_upload.url"><div class='unit icon transcription'><h6>Transcriptions/Translations</h6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.alternate_text.alternate_desc_upload"><a href="^ca_objects.alternate_text.alternate_desc_upload.url%version=original">View ^ca_objects.alternate_text.alternate_text_type</a></ifdef><ifdef code="ca_objects.alternate_text.alternate_desc_note">^ca_objects.alternate_text.alternate_desc_note</ifdef></unit></div></ifdef>}}}
						
				<div style='background-color:#EDEDED; padding:10px; margin:10px 0px 10px 0px;'>
					{{{<ifdef code="ca_objects.microfilm_reel"><H6>Microfilm Reel</H6><unit delimiter="<br/>">^ca_objects.microfilm_reel</unit></ifdef>}}}
					{{{<ifdef code="ca_objects.volume"><H6>Volume</H6><unit delimiter="<br/>">^ca_objects.volume</unit></ifdef>}}}
					{{{<ifdef code="ca_objects.file_number"><H6>File Number</H6><unit delimiter="<br/>">^ca_objects.file_number</unit></ifdef>}}}
					{{{<ifdef code="ca_objects.part"><H6>Part</H6><unit delimiter="<br/>">^ca_objects.part</unit></ifdef>}}}
				
				</div>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-12'>


				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#LAC" aria-controls="LAC" role="tab" data-toggle="tab">LAC</a></li>
					<li role="presentation"><a href="#NCTR" aria-controls="NCTR" role="tab" data-toggle="tab">NCTR</a></li>
					<li role="presentation"><a href="#koerner" aria-controls="koerner" role="tab" data-toggle="tab">Koerner</a></li>
					<li role="presentation"><a href="#notes" aria-controls="notes" role="tab" data-toggle="tab">Notes</a></li>
					<li role="presentation"><a href="#related" aria-controls="related" role="tab" data-toggle="tab">Related</a></li>
					<li role="presentation"><a href="#rights" aria-controls="rights" role="tab" data-toggle="tab">Rights</a></li>
					<li role="presentation"><a href="#map-tab" aria-controls="map-tab" role="tab" data-toggle="tab">Map</a></li>
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="LAC">
						{{{<ifdef code="ca_objects.mikan_number"><div class='unit'><h6>Mikan Number</h6><unit delimiter=", ">^ca_objects.mikan_number</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.file_series_full"><div class='unit'><h6>Series (Full Title)</h6><unit delimiter=", ">^ca_objects.file_series_full</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.RAD_scopecontent"><div class='unit'><h6>Series Scope and Content</h6><unit delimiter=", ">^ca_objects.RAD_scopecontent</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.lac_URL"><div class='unit'><h6>LAC URL</h6><unit delimiter=", "><a href="^ca_objects.lac_URL" target="_blank">^ca_objects.lac_URL</a></unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.rg_source"><div class='unit'><h6>Source note</h6><unit delimiter="<br/>">^ca_objects.rg_source</unit></div></ifdef>}}}
					</div>
					<div role="tabpanel" class="tab-pane" id="NCTR">
						{{{<ifdef code="ca_objects.NCTR_site_ID"><div class='unit'><h6>NCTR Site ID</h6><unit delimiter=", ">^ca_objects.NCTR_site_ID</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.NCTR_container_ID"><div class='unit'><h6>NCTR Container ID</h6><unit delimiter=", ">^ca_objects.NCTR_container_ID</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.NCTR_document_ID"><div class='unit'><h6>NCTR Document ID</h6><unit delimiter=", ">^ca_objects.NCTR_document_ID</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.NCTR_URL"><div class='unit'><h6>NCTR URL</h6><unit delimiter=", "><a href="^ca_objects.NCTR_URL" target="_blank">^ca_objects.NCTR_URL</a></unit></div></ifdef>}}}						
					</div>
					<div role="tabpanel" class="tab-pane" id="koerner">
						{{{<ifdef code="ca_objects.Koerner_URL"><div class='unit'><h6>Koerner URL</h6><unit delimiter=", "><a href="^ca_objects.Koerner_URL" target="NCTR_URL">^ca_objects.Koerner_URL</a></unit></div></ifdef>}}}						
					</div>
					<div role="tabpanel" class="tab-pane" id="notes">
						{{{<ifdef code="ca_objects.language"><div class='unit'><h6>Language</h6><unit delimiter="<br/>">^ca_objects.language</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.language_note"><div class='unit'><h6>Language Note</h6><unit delimiter="<br/>">^ca_objects.language_note</unit></div></ifdef>}}}			
						{{{<ifdef code="ca_objects.MARC_generalNote"><div class='unit'><h6>Note</h6>^ca_objects.MARC_generalNote</div></ifdef>}}}
						{{{<ifdef code="ca_objects.ISADG_archNote"><div class='unit'><h6>Note on Description</h6>^ca_objects.ISADG_archNote</div></ifdef>}}}
<!--					{{{<ifdef code="ca_objects.ISADG_rules"><div class='unit'><h6>Rules or Conventions</h6>^ca_objects.ISADG_rules</div></ifdef>}}}
						{{{<ifdef code="ca_objects.description_date"><div class='unit'><h6>Date(s) of Description(s)</h6>^ca_objects.description_date</div></ifdef>}}}
-->
					</div>
					<div role="tabpanel" class="tab-pane" id="related">
						{{{<ifcount code="ca_objects.related" restrictToTypes="file" min="1"><H6>Related RG10 File</H6><unit relativeTo="ca_objects_x_objects" restrictToTypes="file" delimiter=", "><unit relativeTo="ca_objects"><l>^ca_objects.preferred_labels.name</l></unit> (^relationship_typename)</unit></ifcount>}}}
						{{{<ifcount code="ca_objects.related" excludeTypes="file" min="1"><H6>Related Museum Works, Library Items, Survivors Testimonies, and Archival Items</H6><unit relativeTo="ca_objects_x_objects" excludeTypes="file" delimiter=", "><unit relativeTo="ca_objects"><l>^ca_objects.preferred_labels.name</l></unit> (^relationship_typename)</unit></ifcount>}}}

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