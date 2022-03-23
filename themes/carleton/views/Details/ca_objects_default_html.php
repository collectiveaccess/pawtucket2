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
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
				<HR>
				
				{{{<ifcount code='ca_collections' min='1'><div class='unit'><label>Collection</label><unit relativeTo='ca_collections'><unit relativeTo='ca_collections.hierarchy' delimiter=' > '><l>^ca_collections.type_id ^ca_collections.idno ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates</ifdef></l></unit></unit></div></ifcount>}}}
				
				{{{<ifdef code="ca_objects.idno"><label>Identifier:</label>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><label>Box/series:</label>^ca_objects.containerID<br/></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.inclusive_dates">
					<div class='unit'><label>Inclusive Dates</label>^ca_objects.inclusive_dates%delimiter=,_
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.display_date">
					<div class='unit'><label>Display Date</label>^ca_objects.display_date%delimiter=,_
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.language">
					<div class='unit'><label>Language</label>^ca_objects.language%delimiter=,_
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.event_type">
					<div class='unit'><label>Event Type</label>^ca_objects.event_type%delimiter=,_
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.material">
					<div class='unit'><label>Material</label>^ca_objects.materials%delimiter=,_
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><label>Description</label>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.people_depicted">
					<div class='unit'><label>People Depicted</label>
						<span class="trimText">^ca_objects.people_depicted</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.related_publications">
					<div class='unit'><label>Related Publications</label>^ca_objects.related_publications
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.related_materials">
					<div class='unit'><label>Related Materials</label>^ca_objects.related_materials%delimiter=,_
					</div>
				</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><label>Date:</label>^ca_objects.dateSet.setDisplayValue<br/></ifdef>}}}
			
				{{{<ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
				
				
				{{{<ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount>}}}
				{{{<ifcount code="ca_places" min="2"><label>Related places</label></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
				
				{{{<ifcount code="ca_list_items" min="1" max="1"><label>Related Term</label></ifcount>}}}
				{{{<ifcount code="ca_list_items" min="2"><label>Related Terms</label></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter="<br/>"><unit relativeTo="ca_list_items"><l>^ca_list_items.preferred_labels.name_plural</l></unit> (^relationship_typename)</unit>}}}

						
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