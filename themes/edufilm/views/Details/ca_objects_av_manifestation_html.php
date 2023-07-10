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
								
				{{{<ifdef code="ca_objects.idno">
					<label><t>Identifier:</t></label>
					^ca_objects.idno
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Title.TitleText">
					<label><t>Title:</t></label>
					^ca_objects.vhh_Title.TitleText

					<unit relativeTo="ca_objects.vhh_Title" delimiter="<br/>">
						<ifdef code="ca_objects.vhh_Title.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_objects.vhh_Title.TitleTemporalScope">
								<br/>
								<small>Title Temporal Scope:</small>
								<small>^ca_objects.vhh_Title.TitleTemporalScope</small>
							</ifdef>
							<ifdef code="ca_objects.vhh_Title.__source__">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.vhh_Title.__source__</small>
							</ifdef>
						</div>
					</unit>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.vhh_MediaTypeTech">
					<label><t>Media Technology Type:</t></label>
					<unit relativeTo="ca_objects.vhh_MediaTypeTech" delimiter="<br/>">
						^MTT_List

					</unit>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Language">
					<label><t>Language:</t></label>
					<unit relativeTo="ca_objects.vhh_Language" delimiter="<br/>">
						^lang_Name <ifdef code="ca_objects.vhh_Language">(^lang_Usage)</ifdef>

					</unit>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Description">
					<label><t>Description</t></label>
					<div class='unit'>
						<span class="trimText">^ca_objects.vhh_Description.DescriptionText</span>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_URL">
					<div class="unit"><label><t>URL</t></label>
					<unit relativeTo="ca_objects.vhh_URL" delimiter="<br/>">
						<a href="^ca_objects.vhh_URL" target="_blank">^ca_objects.vhh_URL</a>
						<ifdef code="ca_objects.vhh_URL.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_objects.vhh_URL.__source__">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.vhh_URL.__source__</small>
							</ifdef>
						</div>
					</unit></div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Note">
					<label><t>Note:</t></label>
					<unit relativeTo="ca_objects" delimiter="<br/>">							
						<span class="trimText">^ca_objects.vhh_Note.vhh_NoteText</span>
					</unit>
				</ifdef>}}}		

				{{{<ifdef code="ca_objects.vhh_Origin"><label><t>Origin:</t></label>^ca_objects.vhh_Origin<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_CarrierType2">
					<label><t>Carrier Type:</t></label>
					<unit relativeTo="ca_objects.vhh_CarrierType2" delimiter="<br/>">
						^CarrierTypeList
					</unit>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_DigitalFormatAV">
					<label><t>Digital Format:</t></label>
					<unit relativeTo="ca_objects.vhh_DigitalFormatAV" delimiter="<br/>">
						<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_Coding">(^digi_Coding)</ifdef>
						<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_CodingAudio">(^digi_CodingAudio)</ifdef>
						<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_MIME2">(^digi_MIME2)</ifdef>
					</unit>	
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_AspectRatio"><label><t>Aspect Ratio:</t></label>^ca_objects.vhh_AspectRatio<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Extent">
					<label><t>Extent:</t></label>
					<unit relativeTo="ca_objects.vhh_Extent" delimiter="<br/>">
						^ext_Value <ifdef code="ca_objects.vhh_Extent">^ext_Unit</ifdef>
					</unit>	
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Duration"><label><t>Duration:</t></label>^ca_objects.vhh_Duration<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Sound">
					<label><t>Sound</t></label>
					<ifdef code="ca_objects.vhh_Sound.snd_SystemName">System - (^ca_objects.vhh_Sound.snd_SystemName)</ifdef>
					<ifdef code="ca_objects.vhh_Sound.snd_HasSound">Has Sound? - (^ca_objects.vhh_Sound.snd_HasSound)</ifdef>
					<ifdef code="ca_objects.vhh_Sound.snd_Method">Method - (^ca_objects.vhh_Sound.snd_Method)</ifdef>
					<br/>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_ColorAV">
					<label><t>Color:</t></label>
					<ifdef code="ca_objects.vhh_ColorAV.colAV_HasColor">Has Color? - (^ca_objects.vhh_ColorAV.colAV_HasColor)</ifdef>
					<ifdef code="ca_objects.vhh_ColorAV.colAV_ColorDetail">Color Detail - (^ca_objects.vhh_ColorAV.colAV_ColorDetail)</ifdef>
					<br/>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Provenance"><label><t>Provenance:</t></label>^ca_objects.vhh_Provenance<br/></ifdef>}}}
						
				<hr></hr>

				{{{<ifcount code="ca_collections" min="1" max="1"><label><t>Case Study</t></label></ifcount>}}}
				{{{<ifcount code="ca_collections" min="2"><label><t>Case Studies</t></label></ifcount>}}}
				{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit>}}}
				
				{{{<ifcount code="ca_entities.related" min="1"><div class="unit"><ifcount code="ca_entities.related" min="1" max="1"><label><t>Person/Organization</t></label></ifcount>
						<ifcount code="ca_entities.related" min="2"><label><t>People/Organizations</t></label></ifcount>

						<unit relativeTo="ca_objects_x_entities" delimiter="<br/>">
						<l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)
					
						<ifdef code="ca_objects_x_entities.vhh_HasAgent.HA_CreditText|ca_objects_x_entities.vhh_HasAgent.HA_NameUsed|ca_objects_x_entities.vhh_HasAgent.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_objects_x_entities.vhh_HasAgent.HA_CreditText">
								<br/>
								<small>Agent Credit:</small>
								<unit relativeTo="ca_objects_x_entities.vhh_HasAgent.HA_CreditText" delimiter=",">
									<small>^ca_objects_x_entities.vhh_HasAgent.HA_CreditText</small>
								</unit>
							</ifdef>
							<ifdef code="ca_objects_x_entities.vhh_HasAgent.HA_NameUsed">
								<br/>
								<small>Name Used:</small>
								<unit relativeTo="ca_objects_x_entities.vhh_HasAgent.HA_NameUsed" delimiter=",">
									<small>^ca_objects_x_entities.vhh_HasAgent.HA_NameUsed</small>
								</unit>
							</ifdef>
							<ifdef code="ca_objects_x_entities.vhh_HasAgent.__source__">
								<br/>
								<small><t>Source</t>:</small>
								<unit relativeTo="ca_objects_x_entities.vhh_HasAgent.__source__" delimiter="</br>">
									<small id="copy-text">^ca_objects_x_entities.vhh_HasAgent.__source__</small>
									<button class="copy-btn btn" style="padding: 0px 3px 0px 3px !important;"><i class="fa fa-clipboard" aria-hidden="true"></i></button>
								</unit>
							</ifdef>
						</div>
					</unit></div></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="1" max="1"><label><t>Event</t></label></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="2"><label><t>Events</t></label></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit>}}}
				
				{{{<ifcount code="ca_places" min="1" max="1"><label><t>Location</t></label></ifcount>}}}
				{{{<ifcount code="ca_places" min="2"><label><t>Locations</t></label></ifcount>}}}
				{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit>}}}				

				<div class="row">
					<div class="col-sm-12">		
						{{{<ifdef code="ca_objects.related"><label><t>Items</label></ifdef>}}}
						{{{<unit relativeTo="ca_objects.related" delimiter="<br/>">
							<l>^ca_objects.preferred_labels</l> (^ca_objects.type_id)
						</unit>}}}
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
