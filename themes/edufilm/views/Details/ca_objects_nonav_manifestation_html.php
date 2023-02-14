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
				<!-- <H1>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H1> -->
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>

				<HR>
								
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier:</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.vhh_Title.TitleText"><div class="unit"><label>Title:</label>^ca_objects.vhh_Title.TitleText</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.vhh_MediaTypeTech">
					<div class="unit"><label>Media Technology Type:</label>
					<unit relativeTo="ca_objects.vhh_MediaTypeTech" delimiter="<br/>">
						^MTT_List
					</unit>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Language2">
					<div class="unit"><label>Language:</label>
					<unit relativeTo="ca_objects.vhh_Language2" delimiter="<br/>">
						^vhh_Language2
					</unit>
				</div></ifdef>}}}


				{{{<ifdef code="ca_objects.vhh_Description">
					<div class="unit"><label>Description</label>
					<div class='unit'>
						<span class="trimText">^vhh_Description</span>
					</div>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_URL">
					<div class="unit"><label>URL:</label>
					<unit relativeTo="ca_objects" delimiter="<br/>">
						<a href="ca_objects.vhh_URL" target="_blank">^ca_objects.vhh_URL</a>
					</unit>
				</div></ifdef>}}}	
				{{{<ifdef code="ca_objects.vhh_Note"><div class="unit"><label>Note:</label>^vhh_Note</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.vhh_Origin"><div class="unit"><label>Origin:</label>^vhh_Origin</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_PublicationStatus">
					<div class="unit"><label>Publication Status:</label>
					<unit relativeTo="ca_objects.vhh_PublicationStatus" delimiter="<br/>">
						^vhh_PublicationStatus
					</unit>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_PublicationType2">
					<div class="unit"><label>Publication Type:</label>
					<unit relativeTo="ca_objects.vhh_PublicationType2" delimiter="<br/>">
						^PublicationTypeList
					</unit>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_SourceType">
					<div class="unit"><label>Source Type:</label>
					<unit relativeTo="ca_objects.vhh_SourceType" delimiter="<br/>">
						^vhh_SourceType
					</unit>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_GenreNonAV">
					<div class="unit"><label>Genre (Non-AV):</label>
					<unit relativeTo="ca_objects.vhh_GenreNonAV" delimiter="<br/>">
						^GenreNonAV_List
					</unit>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_CarrierType2">
					<div class="unit"><label>Carrier Type:</label>
					<unit relativeTo="ca_objects.vhh_CarrierType2" delimiter="<br/>">
						^CarrierTypeList
					</unit>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_DigitalFormatAV">
					<div class="unit"><label>Digital Format:</label>
					<unit relativeTo="ca_objects.vhh_DigitalFormatAV" delimiter="<br/>">
						<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_Coding">(^digi_Coding)</ifdef>
						<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_CodingAudio">(^digi_CodingAudio)</ifdef>
						<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_MIME2">(^digi_MIME2)</ifdef>
					</unit>	
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_AspectRatio"><div class="unit"><label>Aspect Ratio:</label>^ca_objects.vhh_AspectRatio</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Extent">
					<div class="unit"><label>Extent:</label>
					<unit relativeTo="ca_objects.vhh_Extent" delimiter="<br/>">
						^ext_Value <ifdef code="ca_objects.vhh_Extent">(^ext_Unit)</ifdef>
					</unit>	
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Duration"><div class="unit"><label>Duration:</label>^ca_objects.vhh_Duration</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Sound">
					<div class="unit"><label>Sound</label>
					<ifdef code="ca_objects.vhh_Sound.snd_SystemName">System - (^ca_objects.vhh_Sound.snd_SystemName)</ifdef>
					<ifdef code="ca_objects.vhh_Sound.snd_HasSound">Has Sound? - (^ca_objects.vhh_Sound.snd_HasSound)</ifdef>
					<ifdef code="ca_objects.vhh_Sound.snd_Method">Method - (^ca_objects.vhh_Sound.snd_Method)</ifdef>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_ColorAV">
					<div class="unit"><label><?= _t('Color:'); ?></label>
					<ifdef code="ca_objects.vhh_ColorAV.colAV_HasColor">Has Color? - (^ca_objects.vhh_ColorAV.colAV_HasColor)</ifdef>
					<ifdef code="ca_objects.vhh_ColorAV.colAV_ColorDetail">Color Detail - (^ca_objects.vhh_ColorAV.colAV_ColorDetail)</ifdef>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Provenance"><div class="unit"><label>Provenance:</label>^ca_objects.vhh_Provenance</div></ifdef>}}}
						
				<hr></hr>

				{{{<ifcount code="ca_collections" min="1"><div class="unit"><ifcount code="ca_collections" min="1" max="1"><label><?= _t('Related Case Study'); ?></label></ifcount>
					<ifcount code="ca_collections" min="2"><label><?= _t('Related Case Studies'); ?></label></ifcount>
					<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
				
				{{{<ifcount code="ca_entities" min="1"><div class="unit"><ifcount code="ca_entities.related" min="1" max="1"><label><?= _t('Related Person/Organization'); ?></label></ifcount>
					<ifcount code="ca_entities.related" min="2"><label><?= _t('Related People/Organizations'); ?></label></ifcount>
					<unit relativeTo="ca_entities.related" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
				
				{{{<ifcount code="ca_collections" min="1"><div class="unit"><ifcount code="ca_occurrences" min="1" max="1"><label><?= _t('Related Event'); ?></label></ifcount>
					<ifcount code="ca_occurrences" min="2"><label><?= _t('Related Events'); ?></label></ifcount>
					<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
				
				{{{<ifcount code="ca_places" min="1"><div class="unit"><ifcount code="ca_places" min="1" max="1"><label><?= _t('Related Location'); ?></label></ifcount>
					<ifcount code="ca_places" min="2"><label><?= _t('Related Locations'); ?></label></ifcount>
					<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}				

				<div class="row">
					<div class="col-sm-12">		
						{{{<ifcount code="ca_objects.related" min="1"><label><?= _t('Related Items'); ?></label>
							<unit relativeTo="ca_objects.related" delimiter="<br/>">
							<l>^ca_objects.preferred_labels</l> (is part of) &rarr; (^ca_objects.type_id)
						</unit></div></ifcount>}}}
					</div><!-- end col -->				
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
