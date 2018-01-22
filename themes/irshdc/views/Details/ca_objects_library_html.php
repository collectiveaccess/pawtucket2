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
				{{{<ifdef code="ca_objects.indexingDatesSet"><div class='unit'>^ca_objects.indexingDatesSet</div></ifdef>}}}
				{{{<ifdef code="ca_objects.MARC_copyrightDate"><div class='unit'>&copy; ^ca_objects.MARC_copyrightDate</div></ifdef>}}}
				{{{<ifdef code="ca_objects.contributors|ca_objects.creators"><H6>Creators and Contributors</H6><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.contributors</unit><ifdef code="ca_objects.contributors,ca_objects.creators"><br/></ifdef><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.creators</unit></ifdef>}}}

<?php
		include("curation_html.php");
?>
				
				{{{<ifdef code="ca_objects.nonpreferred_labels.name"><HR/><H6>Alternate Title(s)</H6><unit relativeTo="ca_objects" delimiter="<br/>">^nonpreferred_labels.name</unit></ifdef>}}}
				
				
<!--				{{{<ifdef code="ca_objects.MARC_volume"><div class='unit'><h6>Series and Volume</h6>^ca_objects.MARC_volume%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.MARC_edition"><div class='unit'><h6>Edition</h6>^ca_objects.MARC_edition</div></ifdef>}}} -->
				<!--{{{<ifdef code="ca_objects.RAD_pubPlace"><div class='unit'><h6>Published/Distributed</h6>^RAD_pubPlace</div></ifdef>}}}-->
				
			</div>
		</div>
		<div class="row">	
			<div class='col-sm-12'>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#source" aria-controls="source" role="tab" data-toggle="tab">Source</a></li>
					<li role="presentation"><a href="#notes" aria-controls="notes" role="tab" data-toggle="tab">Notes</a></li>
					<li role="presentation"><a href="#subjects" aria-controls="subjects" role="tab" data-toggle="tab">Subjects</a></li>
					<li role="presentation"><a href="#related" aria-controls="related" role="tab" data-toggle="tab">Related</a></li>
					<li role="presentation"><a href="#rights" aria-controls="rights" role="tab" data-toggle="tab">Rights</a></li>
					<li role="presentation"><a href="#map-tab" aria-controls="map-tab" role="tab" data-toggle="tab">Map</a></li>
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="source">
						{{{<ifcount code="ca_entities.related" restrictToTypes="repository" min="1"><H6>Holding Library</H6><unit relativeTo="ca_entities.related" restrictToTypes="repository" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>}}}
				
<!--						{{{<ifdef code="ca_objects.internal_external"><div class='unit'><h6>Internal/External</h6>^ca_objects.internal_external</div></ifdef>}}} -->
						{{{<ifdef code="ca_objects.link"><div class='unit'><h6>Link to Record in Holding Library</h6><a href="^ca_objects.link" target="_blank">^ca_objects.link</a></div></ifdef>}}}
						{{{<ifdef code="ca_objects.electronic_URL"><div class='unit'><h6>Electronic Location</h6><a href="^ca_objects.electronic_URL" target="_blank">^ca_objects.electronic_URL</a></div></ifdef>}}}
						
<!--					{{{<ifdef code="ca_objects.call_number"><div class='unit'><h6>^ca_objects.call_number.call_number_source Call Number</h6>^ca_objects.call_number.call_number_value</div></ifdef>}}}
						{{{<ifdef code="ca_objects.MARC_physical"><div class='unit'><h6>Physical Description</h6>^ca_objects.MARC_physical</div></ifdef>}}}
-->
					</div>
					<div role="tabpanel" class="tab-pane" id="notes">
						{{{<ifdef code="ca_objects.MARC_isbn"><div class='unit'><h6>ISBN</h6><unit delimiter="<br/>">^ca_objects.MARC_isbn</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.MARC_issn"><div class='unit'><h6>ISSN</h6><unit delimiter="<br/>">^ca_objects.MARC_issn</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.MARC_generalNote"><div class='unit'><h6>General Note</h6>^ca_objects.MARC_generalNote</div></ifdef>}}}
						{{{<ifdef code="ca_objects.local_note"><div class='unit'><h6>Local Note</h6>^ca_objects.local_note</div></ifdef>}}}				
						<!--{{{<ifdef code="ca_objects.bibliography"><div class='unit'><h6>Bibliography, etc. Note</h6>^ca_objects.bibliography</div></ifdef>}}}	-->		
						{{{<ifdef code="ca_objects.MARC_formattedContents"><div class='unit'><h6>Contents</h6>^ca_objects.MARC_formattedContents</div></ifdef>}}}			
						{{{<ifdef code="ca_objects.ISADG_titleNote"><div class='unit'><h6>Title Note</h6>^ca_objects.ISADG_titleNote</div></ifdef>}}}			
						{{{<ifdef code="ca_objects.participant_performer"><div class='unit'><h6>Participant or Performer Note</h6>^ca_objects.participant_performer</div></ifdef>}}}			
						<!--{{{<ifdef code="ca_objects.additional_form"><div class='unit'><h6>Additional Physical Form Note</h6>^ca_objects.additional_form</div></ifdef>}}}			
						{{{<ifdef code="ca_objects.system_note"><div class='unit'><h6>System Details Note</h6>^ca_objects.system_note</div></ifdef>}}}		-->	
						
						{{{<ifdef code="ca_objects.language"><div class='unit'><h6>Language</h6>^ca_objects.language</div></ifdef>}}}		
						
					</div>
					<div role="tabpanel" class="tab-pane" id="subjects">
						{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="subject" min="1"><H6>Subject Entity</H6><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="subject" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>}}}
						{{{<ifdef code="ca_objects.LOC_text"><div class='unit'><h6>Subject Access - Topical</h6>^ca_objects.LOC_text%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.tgn"><div class='unit'><H6>Subject Access - Geographical</H6>^ca_objects.tgn%delimiter=,_</div></ifcount>}}}					
						{{{<ifdef code="ca_objects.local_subject"><div class='unit'><h6>Subject Access - Local</h6>^ca_objects.local_subject%delimiter=,_</div></ifdef>}}}
									
					</div>
					<div role="tabpanel" class="tab-pane" id="related">
						{{{<ifcount code="ca_objects.related" restrictToTypes="library" min="1"><H6>Related Library Items</H6><unit relativeTo="ca_objects.related" restrictToTypes="library" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifcount>}}}
						{{{<ifcount code="ca_objects.related" excludeTypes="library" min="1"><H6>Related Archival Items, Museum Works, and Testimonies</H6><unit relativeTo="ca_objects.related" excludeTypes="library" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifcount>}}}			
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