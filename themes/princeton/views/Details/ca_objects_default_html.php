<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
$va_access_values = 	$this->getVar("access_values");

$iiif_manifest_url = caNavUrl($this->request, 'service.php', 'IIIF', 'manifest/ca_objects:'.$t_object->getPrimaryKey(), [], ['absolute' => true]);

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
	<div class="container">
		<div class="row">
			<div class='col-sm-12 col-md-10 col-lg-8 col-lg-offset-1'>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
			</div>
			<div class='col-sm-12 col-md-2 inquireCol'>
				<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id"))); ?>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
				<HR>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "basic", "bsColClasses" => "smallpadding col-sm-3 col-md-2 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span><?= _t('Comments and Tags'); ?> (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
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
				{{{<ifcount code="ca_collections" min="1">
					<div class="unit"><label>Collection</label><unit relativeTo="ca_collections" delimiter="<br>"><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></unit>
					</div>
				</ifcount>}}}
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.item_type"><div class="unit"><label>Object Type</label><unit relativeTo="ca_objects.item_type" delimiter=", ">^ca_objects.item_type</unit></div></ifdef>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="contributor,creator">
					<div class="unit"><label>Creator<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="contributor,creator">s</ifcount></label>
					<unit relativeTo="ca_entities" restrictToRelationshipTypes="contributor,creator" delimiter="<br>">
						<l>^ca_entities.preferred_labels.displayname</l>
					</unit>
				</div></ifcount>}}}
				{{{<if rule='^ca_objects.unknown =~ /Yes/'><div class="unit"><label>Creator</label>Unknown</div></if>}}}
				{{{<ifdef code="ca_objects.date.sort_date|ca_objects.date.display_date">
					<div class="unit"><label>Date</label>
						<unit relativeTo="ca_objects.date" delimiter="<br>">
							<ifdef code="ca_objects.date.date_display">^ca_objects.date.date_display</ifdef><ifnotdef code="ca_objects.date.date_display">^ca_objects.date.sort_date</ifnotdef><ifdef code="ca_objects.date.date_note">, ^ca_objects.date.date_note</ifdef>
						</unit>
					</div>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><label>Description</label>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.transcription">
					<div class='unit'><label>Transcription</label>
						<span class="trimText">^ca_objects.transcription</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.materials_techniques"><div class="unit"><label>Materials and Techniques</label>^ca_objects.materials_techniques%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions_container.display_dimensions"><div class="unit"><label>Dimensions</label>^ca_objects.dimensions_container.display_dimensions</div></ifdef>}}}
				{{{<ifdef code="ca_objects.scale"><div class="unit"><label>Scale</label>^ca_objects.scale%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.duration"><div class="unit"><label>Duration</label>^ca_objects.duration%delimiter=,_</div></ifdef>}}}
				
						
				<div class="unit"><label>IIIF Manifest</label> <a href="<?= $iiif_manifest_url; ?>"><?= $iiif_manifest_url; ?></a></unit></div>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{map}}}
			</div>
			<div class='col-sm-6 col-md-6 col-lg-5'>		
				{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="work">
					<div class="unit"><label>Work<ifcount code="ca_occurrences" min="2" restrictToTypes="work">s</ifcount></label>
					<unit relativeTo="ca_occurrences" restrictToTypes="work" delimiter="<br>">
						<l>^ca_occurrences.preferred_labels.name</l>
					</unit>
				</div></ifcount>}}}
				{{{<ifcount code="ca_objects.related" min="1">
					<div class="unit"><label>Related Object<ifcount code="ca_objects.related" min="2">s</ifcount></label>
					<unit relativeTo="ca_objects.related" delimiter=" ">
						<div class="unit"><l><div class="row relatedObjects"><ifdef code="ca_object_representations.media.small"><div class="col-sm-4 col-md-3">^ca_object_representations.media.small</div></ifdef><div class="col-sm-8 col-md-9">^ca_objects.preferred_labels.name</div></l></div>
					</unit>
				</div></ifcount>}}}
				{{{<ifdef code="ca_objects.view"><div class="unit"><label>View</label>^ca_objects.view%delimiter=,_</div></ifdef>}}}
<?php
				$va_subjects = $t_object->get("ca_objects.subjects", array("returnAsArray" => 1));
				if(is_array($va_subjects) && sizeof($va_subjects)){
					$va_subjects_formatted = array();
					foreach($va_subjects as $vs_subject){
						$vn_pos = $vs_link = "";
						if($vn_pos = strpos($vs_subject, "[")){
							$vs_link = mb_substr($vs_subject, ($vn_pos + 1), -1);
							$vs_subject = mb_substr($vs_subject, 0, $vn_pos);
							$va_subjects_formatted[] = "<a href='".$vs_link."' target='_blank'>".$vs_subject."</a>";
						}
					}
					if(is_array($va_subjects_formatted) && sizeof($va_subjects_formatted)){
						print "<div class='unit'><label>Subjects</label>".join(", ", $va_subjects_formatted)."</div>";
					}
				}
?>
				{{{<ifdef code="ca_objects.verbatim_location"><div class="unit"><label>Verbatim Location</label>^ca_objects.verbatim_location%delimiter=,_</div></ifdef>}}}
				{{{<ifcount code="ca_places" min="1">
					<div class="unit"><label>Place<ifcount code="ca_places" min="2">s</ifcount></label><unit relativeTo="ca_places" delimiter="<br>"><l>^ca_places.preferred_labels.name</l></unit>
					</div>
				</ifcount>}}}							
			</div><!-- end col -->				
			
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
				<hr>
<?php
				$vs_rights_text = $this->getVar("rights_text");
				if($tmp = $t_object->get("ca_objects.rights_container.rights")){
					$vs_rights_text = $tmp;
				}
?>
				<div class="unit"><label>Rights Statement</label><?php print $vs_rights_text; ?></div>
<?php
				$vs_use_reproduction = "<div class='copyRightIcon'><a href='https://creativecommons.org/licenses/by-sa/4.0/' target='_blank' title='Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)'>".caGetThemeGraphic($this->request, 'by-sa.png', array("alt" => "Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)"))."</a></div>";
				if($tmp = $t_object->get("ca_objects.rights_container.use_reproduction")){
					if($tmp != "Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)"){
						$vs_use_reproduction = $tmp;
					}
				}
?>
				<div class="unit"><label>Use and Reproduction Conditions</label><?php print $vs_use_reproduction; ?></div>

				{{{<ifdef code="ca_objects.credit"><div class="unit"><label>Credit</label>^ca_objects.credit</div></ifdef>}}}
			</div>
		</div>
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
