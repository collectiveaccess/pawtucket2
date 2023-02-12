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
		<div class="container">
			<div class="row">
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
							<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<t>Comments and tags</t>"></span><t>Comments and Tags</t> (<?= sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
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
					
					{{{<ifdef code="ca_objects.idno"><label><t>Identifier</t>:</label>^ca_objects.idno<br/></ifdef>}}}

					{{{<ifdef code="ca_objects.vhh_Title">
						<label><t>Title</t>:</label>
						<ifdef code="ca_objects.vhh_Title.TitleText">^ca_objects.vhh_Title.TitleText</ifdef>

						<unit relativeTo="ca_objects.vhh_Title" delimiter="<br/>">
							<a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
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
						
						<br/>
					</ifdef>}}}
					
					{{{<ifdef code="ca_objects.vhh_Identifier">
						<label><t>External Identifier</t>:</label>
						<unit relativeTo="ca_objects.vhh_Identifier" delimiter="<br/>">
							<ifdef code="ca_objects.vhh_Identifier.IdentifierScheme">^IdentifierScheme</ifdef>
							<if rule='^ca_objects.vhh_Identifier.IdentifierValue !~ /\?/'>(^ca_objects.vhh_Identifier.IdentifierValue)</if>
						</unit>
					</ifdef>}}}	

					{{{<ifdef code="ca_objects.vhh_CountryOfReference">
						<label><t>Country of Reference</t>:</label>
						<unit relativeTo="ca_objects.vhh_CountryOfReference" delimiter="<br/>">
							^CountryPlace (^Reference)
						</unit>
					</ifdef>}}}	

					{{{<ifdef code="ca_objects.vhh_Date" >
						<label><t>Date</t>:</label>
						<unit relativeTo="ca_objects.vhh_Date" delimiter="<br/>">
							^date_Date <ifdef code="ca_objects.vhh_Date.date_Type">(^date_Type)</ifdef>
						</unit>
					</ifdef>}}}				
					
					{{{<ifdef code="ca_objects.vhh_Description">
						<div class='unit'>
							<label><t>Description</t></label>
							<span class="trimText">^ca_objects.vhh_Description.DescriptionText</span>
						</div>
					</ifdef>}}}
				
					{{{<ifdef code="ca_objects.vhh_URL">
						<label><t>URL</t>:</label>
						<unit relativeTo="ca_objects" delimiter="<br/>">
							<l>^ca_objects.vhh_URL</l>
						</unit>
					</ifdef>}}}

					{{{<ifdef code="ca_objects.vhh_Note">
						<label><t>Note</t>:</label>
						<unit relativeTo="ca_objects" delimiter="<br/>">							
							<span class="trimText">^ca_objects.vhh_Note.vhh_NoteText</span>
							<a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_objects.vhh_Note.vhh_NoteReference">
									<br/>
									<small>Reference:</small>
									<small>^ca_objects.vhh_Note.vhh_NoteReference</small>
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_Note.vhh_NoteReference.__source__</small>
								</ifdef>
							</div>
						</unit>
						
					</ifdef>}}}

					{{{<ifdef code="ca_objects.vhh_MediaType">
						<label><t>Media Type</t>:</label>
						<unit relativeTo="ca_objects.vhh_MediaType" delimiter="<br/>">
							^MT_List
						</unit>
					</ifdef>}}}

					{{{<ifdef code="ca_objects.vhh_GenreAV">
						<label><t>Genre(AV)</t>:</label>
						<unit relativeTo="ca_objects.vhh_GenreAV" delimiter="<br/>">
							^GenreAV_List
						</unit>
					</ifdef>}}}

					{{{<ifdef code="ca_objects.edu_FilmDevices">
						<label><t>Devices</t>:</label>
						<unit relativeTo="ca_objects" delimiter="<br/>">
							^ca_objects.edu_FilmDevices
						</unit>
					</ifdef>}}}

					{{{<ifdef code="ca_objects.edu_KnowledgeField">
						<label><t>Field of Knowledge</t>:</label>
						<unit relativeTo="ca_objects.edu_KnowledgeField" delimiter="<br/>">
							^edu_KnowlegdeFieldType
						</unit>
					</ifdef>}}}
							
					<!-- <hr></hr> -->

					{{{<ifcount code="ca_collections" min="1" max="1"><label><t>Related Case Study</t>></label></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><label><t>Related Case Studies</t>/label></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit>}}}
									
					{{{<ifcount code="ca_occurrences" min="1" max="1"><label><t>Related Event</t></label></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><label><t>Related Events</t></label></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><label><t>Related Location</t></label></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><label><t>Related Locations</t></label></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit>}}}				

					<div class="row">
						<div class="col-sm-12">		
							<!-- {{{<ifdef code="ca_objects.related"><label>Related Items</label></ifdef>}}}
							{{{<unit relativeTo="ca_objects.related" delimiter="<br/>">
								<l>^ca_objects.preferred_labels</l> (^ca_objects.type_id)
							</unit>}}}	 -->
						</div><!-- end col -->				
					</div><!-- end row -->
							
				</div><!-- end col -->
			</div><!-- end row -->

			<hr></hr>

			<div class="row">

				<div class="col-sm-6 col-md-6 col-lg-5 col-lg-offset-1">

					{{{<ifcount code="ca_entities.related" min="1" max="1"><label><t>Related Person/Organization</t></label></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><label><t>Related People/Organizations</t></label></ifcount>}}}

					{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>">
						<l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)
					
						<a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
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
								<small>Source:</small>
								<unit relativeTo="ca_objects_x_entities.vhh_HasAgent.__source__" delimiter="</br>">
									<small id="copy-text">^ca_objects_x_entities.vhh_HasAgent.__source__</small>
									<button class="copy-btn btn" style="padding: 0px 3px 0px 3px !important;"><i class="fa fa-clipboard" aria-hidden="true"></i></button>
								</unit>
							</ifdef>
						</div>
						<br/>
					</unit>}}}
				</div>

				<div class="col-sm-6 col-md-6 col-lg-5">
					{{{<ifdef code="ca_objects.related"><label><t>Related Manifestations and Items</t></label></ifdef>}}}

					{{{<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToTypes="av_manifestation">
						^ca_objects.preferred_labels (^ca_objects.type_id)
						
						<a href="#" class="itemInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
						<div class="itemInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_objects.idno">
								<br/>
								<small>Identifier: ^ca_objects.idno</small>
							</ifdef>
							<ifdef code="ca_objects.vhh_MediaTypeTech">
								<br/>
								<small>Media Technology Type:</small>
								<unit relativeTo="ca_objects.vhh_MediaTypeTech" delimiter=",">
									<small>^MTT_List</small>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.vhh_Language">
								<br/>
								<small>Language:</small>
								<unit relativeTo="ca_objects.vhh_Language" delimiter=",">
									<small>^lang_Name <ifdef code="ca_objects.vhh_Language">(^lang_Usage)</ifdef></small>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_Description">
								<br/>
								<small>Description</small>
								<div class='unit'>
									<span class="trimText">^ca_objects.vhh_Description.DescriptionText</span>
								</div>
							</ifdef>

							<ifdef code="ca_objects.vhh_URL"><small>URL:</small><unit relativeTo="ca_objects.vhh_URL"><a href="ca_objects.vhh_URL" target="_blank">^ca_objects.vhh_URL</a></unit><br/></ifdef>

							<ifdef code="ca_objects.vhh_Note">
								<br/>
								<small>Note:</small>
								<unit relativeTo="ca_objects" delimiter="<br/>">							
									<span class="trimText">^ca_objects.vhh_Note.vhh_NoteText</span>
								</unit>
							</ifdef>		

							<ifdef code="ca_objects.vhh_Origin">
								<br/>
								<small>Origin:</small>
								^ca_objects.vhh_Origin
							</ifdef>

							<ifdef code="ca_objects.vhh_CarrierType2">
								<br/>
								<small>Carrier Type:</small>
								<unit relativeTo="ca_objects.vhh_CarrierType2" delimiter="<br/>">
									^CarrierTypeList
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_DigitalFormatAV">
								<br/>
								<small>Digital Format:</small>
								<unit relativeTo="ca_objects.vhh_DigitalFormatAV" delimiter=",">
									<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_Coding"><small>(^digi_Coding)</small></ifdef>
									<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_CodingAudio"><small>(^digi_CodingAudio)</small></ifdef>
									<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_MIME2"><small>(^digi_MIME2)</small></ifdef>
								</unit>	
							</ifdef>

							<ifdef code="ca_objects.vhh_AspectRatio">
								<br/>
								<small>Aspect Ratio:</small>
								^ca_objects.vhh_AspectRatio
							</ifdef>

							<ifdef code="ca_objects.vhh_Extent">
								<br/>
								<small>Extent:</small>
								<unit relativeTo="ca_objects.vhh_Extent" delimiter="<br/>">
									^ext_Value <ifdef code="ca_objects.vhh_Extent">(^ext_Unit)</ifdef>
								</unit>	
							</ifdef>

							<ifdef code="ca_objects.vhh_Duration">
								<br/>
								<small>Duration:</small>
								<unit relativeTo="ca_objects.vhh_Duration" delimiter=",">
									<small>^ca_objects.vhh_Duration</small>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_Sound">
								<br/>
								<small>Sound</small>
								<ifdef code="ca_objects.vhh_Sound.snd_SystemName">System - (^ca_objects.vhh_Sound.snd_SystemName)</ifdef>
								<ifdef code="ca_objects.vhh_Sound.snd_HasSound">Has Sound? - (^ca_objects.vhh_Sound.snd_HasSound)</ifdef>
								<ifdef code="ca_objects.vhh_Sound.snd_Method">Method - (^ca_objects.vhh_Sound.snd_Method)</ifdef>
							</ifdef>

							<ifdef code="ca_objects.vhh_ColorAV">
								<br/>
								<small>Color:</small>
								<ifdef code="ca_objects.vhh_ColorAV.colAV_HasColor">Has Color? - (^ca_objects.vhh_ColorAV.colAV_HasColor)</ifdef>
								<ifdef code="ca_objects.vhh_ColorAV.colAV_ColorDetail">Color Detail - (^ca_objects.vhh_ColorAV.colAV_ColorDetail)</ifdef>
							</ifdef>

							<ifdef code="ca_objects.vhh_Provenance">
								<br/>
								<small>Provenance:</small>
								^ca_objects.vhh_Provenance
							</ifdef>
						</div>
					</unit>}}}

					<br/>

					{{{<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToTypes="item">
						^ca_objects.preferred_labels (^ca_objects.type_id)
						<a href="#" class="itemInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
						<div class="itemInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_objects.idno">
								<br/>
								<small>Identifier: ^ca_objects.idno</small>
							</ifdef>

							<ifdef code="ca_objects.measurementSet.measurements">
								^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)
							</ifdef>
							<ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef>
							<ifdef code="ca_objects.measurementSet.measurements2">
								^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)
							</ifdef>

							<ifdef code="ca_objects.vhh_Title.TitleText">
								<br/>
								<small>Title:</small>
								^ca_objects.vhh_Title.TitleText
							</ifdef>	

							<ifdef code="ca_objects.vhh_Identifier">
								<br/>
								<small>External Identifier:</small>
								<unit relativeTo="ca_objects.vhh_Identifier" delimiter="<br/>">
								^IdentifierScheme <if rule='^ca_objects.vhh_Identifier.IdentifierValue !~ /\?/'>(^ca_objects.vhh_Identifier.IdentifierValue)</if>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_CountryOfReference">
								<br/>
								<small>Country of Reference:</small>
								<unit relativeTo="ca_objects.vhh_CountryOfReference" delimiter="<br/>">
									^CountryPlace (^Reference)
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_Date">
								<br/>
								<small>Date:</small>
								<unit relativeTo="ca_objects.vhh_Date" delimiter="<br/>">
									^date_Date <ifdef code="ca_objects.vhh_Date.date_Type">(^date_Type)</ifdef>
								</unit>
							</ifdef>				
				
							<ifdef code="ca_objects.vhh_Description">
								<br/>
								<small>Description</small>
								<div class='unit'>
									<span class="trimText">^ca_objects.vhh_Description.DescriptionText</span>
								</div>
							</ifdef>
						
							<ifdef code="ca_objects.vhh_URL">
								<br/>
								<small>URL:</small>
								<unit relativeTo="ca_objects" delimiter="<br/>">
									<l>^ca_objects.vhh_URL</l>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_Note">
								<br/>
								<small>Note:</small>
								<unit relativeTo="ca_objects" delimiter="<br/>">							
									<span class="trimText">^ca_objects.vhh_Note.vhh_NoteText</span>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_MediaType">
								<br/>
								<small>Media Type:</small>
								<unit relativeTo="ca_objects.vhh_MediaType" delimiter=",">
									<small>^MT_List</small>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_GenreAV">
								<br/>
								<small>Genre(AV):</small>
								<unit relativeTo="ca_objects.vhh_GenreAV" delimiter=",">
									<small>^GenreAV_List</small>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.edu_FilmDevices">
								<br/>
								<small>Devices:</small>
								<unit relativeTo="ca_objects.edu_FilmDevices" delimiter=",">
									<small>^edu_FilmDevices</small>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.edu_KnowledgeField">
								<br/>
								<small>Field of Knowledge:</small>
								<unit relativeTo="ca_objects.edu_KnowledgeField" delimiter="<br/>">
									^edu_KnowlegdeFieldType
								</unit>
							</ifdef>

							<ifdef code="ca_objects.dateSet.setDisplayValue">
								<br/>
								<small>Date:</small>
								^ca_objects.dateSet.setDisplayValue
							</ifdef>
						</div>
					</unit>}}}

					<br/>

					{{{<unit relativeTo="ca_objects.related" delimiter="<br/>" excludeTypes="av_manifestation, item">
						<ifdef code="ca_objects.related"><label><t>Related Objects</t></label></ifdef>
						<l>^ca_objects.preferred_labels</l> (^ca_objects.type_id)
					</unit>}}}

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

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script> -->
<script script-src="https://cdn.jsdelivr.net/npm/clipboard@2.0.10/dist/clipboard.min.js"></script>
<script type='text/javascript'>
	$(document).ready(function() {
		// Trim text
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
		
		// Show-hide handlers
		$(".entityInfoButton").on('click', function(e) {
			$(e.currentTarget).next(".entityInfo").slideToggle(250);
			e.preventDefault();		
		});

		$(".itemInfoButton").on('click', function(e) {
			$(e.currentTarget).next(".itemInfo").slideToggle(250);
			e.preventDefault();		
		});
	});

	$('.copy-btn').on('click', function() {
		// store the text you want to copy in variable
		var text = $('#copy-text').text();
		console.log(text);
		// move the text to input tag to execute copy command
		var tempElement = $('<input>').val(text).appendTo('body').select();
		document.execCommand('copy');
		tempElement.remove();

		alert(`Text Copied, ${text}`);
	});
</script>


