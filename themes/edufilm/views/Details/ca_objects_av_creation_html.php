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
					
					{{{<ifdef code="ca_objects.idno"><div class="unit"><label><t>Identifier</t></label>^ca_objects.idno</div></ifdef>}}}

					{{{<ifdef code="ca_objects.vhh_Title">
						<div class="unit"><label><t>Title</t></label>
						<unit relativeTo="ca_objects.vhh_Title" delimiter="<br/>">
						<ifdef code="ca_objects.vhh_Title.TitleText">
							^ca_objects.vhh_Title.TitleText 
							<ifdef code="ca_objects.vhh_Title.TitleType">(^ca_objects.vhh_Title.TitleType)</ifdef>
						</ifdef>

						
							<ifdef code="ca_objects.vhh_Title.TitleTemporalScope|ca_objects.vhh_Title.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_Title.TitleTemporalScope">
									<br/>
									<small>Title Temporal Scope:</small>
									<small>^ca_objects.vhh_Title.TitleTemporalScope</small>
								</ifdef>
								<ifdef code="ca_objects.vhh_Title.__source__">
									<br/>
									<small><t>Source</t>:</small>
									<small>^ca_objects.vhh_Title.__source__</small>
								</ifdef>
							</div>
						</unit>
						
						</div>
					</ifdef>}}}
					
					{{{<ifdef code="ca_objects.vhh_Identifier">
						<div class="unit"><label><t>External Identifier</t></label>
						
							<unit relativeTo="ca_objects.vhh_Identifier" delimiter="<br/>">
								<ifdef code="ca_objects.vhh_Identifier.IdentifierScheme">^IdentifierScheme</ifdef>
								<if rule='^ca_objects.vhh_Identifier.IdentifierValue !~ /\?/'>
									(^ca_objects.vhh_Identifier.IdentifierValue)
								</if>

								<ifdef code="ca_objects.vhh_Identifier.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
								<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
									<ifdef code="ca_objects.vhh_Identifier.__source__">
										<br/>
										<small><t>Source</t>:</small>
										<small>^ca_objects.vhh_Identifier.__source__</small>
									</ifdef>
								</div>
							</unit>
						</div>
					</ifdef>}}}	

					{{{<ifdef code="ca_objects.vhh_CountryOfReference">
						<div class="unit"><label><t>Country of Reference</t></label>
						<unit relativeTo="ca_objects.vhh_CountryOfReference" delimiter="<br/>">
							^CountryPlace (^Reference)

							<ifdef code="ca_objects.vhh_CountryOfReference.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_CountryOfReference.__source__">
									<br/>
									<small><t>Source</t>:</small>
									<small>^ca_objects.vhh_CountryOfReference.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div></ifdef>}}}	

					{{{<ifdef code="ca_objects.vhh_Date" >
						<div class="unit"><label><t>Date</t></label>
						<unit relativeTo="ca_objects.vhh_Date" delimiter="<br/>">
							^date_Date <ifdef code="ca_objects.vhh_Date.date_Type">(^date_Type)</ifdef>

							<ifdef code="ca_objects.vhh_Date.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_Date.__source__">
									<br/>
									<small><t>Source</t>:</small>
									<small>^ca_objects.vhh_Date.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div></ifdef>}}}				
					
					{{{<ifdef code="ca_objects.vhh_Description">
						<div class='unit'>
							<label><t>Description</t></label>
							<span class="trimText">^ca_objects.vhh_Description.DescriptionText</span>

							<unit relativeTo="ca_objects.vhh_Description" delimiter="<br/>">

								<ifdef code="ca_objects.vhh_Description.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
								<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
									<ifdef code="ca_objects.vhh_Description.__source__">
										<br/>
										<small><t>Source</t>:</small>
										<small>^ca_objects.vhh_Description.__source__</small>
									</ifdef>
								</div>
							</unit>
						</div>
					</ifdef>}}}
				
					{{{<ifdef code="ca_objects.vhh_URL">
						<div class="unit"><label><t>URL</t></label>
						<unit relativeTo="ca_objects" delimiter="<br/>">
							<a href="^ca_objects.vhh_URL" target="_blank">^ca_objects.vhh_URL</a>

							<ifdef code="ca_objects.vhh_URL.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_URL.__source__">
									<br/>
									<small><t>Source</t>:</small>
									<small>^ca_objects.vhh_URL.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_objects.vhh_Note">
						<div class="unit"><label><t>Note</t></label>
						<unit relativeTo="ca_objects" delimiter="<br/>">							
							<span class="trimText">^ca_objects.vhh_Note.vhh_NoteText</span>
							<ifdef code="^ca_objects.vhh_Note.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_objects.vhh_Note.__source__">
									<br/>
									<small><t>Source</t>:</small>
									<small>^ca_objects.vhh_Note.__source__</small>
								</ifdef>
							</div>
						</unit>
						</div>
					</ifdef>}}}


					{{{<ifdef code="ca_objects.vhh_GenreAV">
						<div class="unit"><label><t>Genre(AV)</t></label>
						<unit relativeTo="ca_objects.vhh_GenreAV" delimiter="<br/>">
							^GenreAV_List

							<ifdef code="^ca_objects.vhh_GenreAV"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_objects.vhh_GenreAV">
									<br/>
									<small><t>Source</t>:</small>
									<small>^ca_objects.vhh_GenreAV.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_objects.edu_FilmDevices">
						<div class="unit"><label><t>Devices</t></label>
						<unit relativeTo="ca_objects" delimiter="<br/>">
							^ca_objects.edu_FilmDevices

						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_objects.edu_KnowledgeField">
						<div class="unit"><label><t>Field of Knowledge</t></label>
						<unit relativeTo="ca_objects.edu_KnowledgeField" delimiter="<br/>">
							^edu_KnowlegdeFieldType

							<ifdef code="^ca_objects.edu_KnowledgeField"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_objects.edu_KnowledgeField">
									<br/>
									<small><t>Source</t>:</small>
									<small>^ca_objects.edu_KnowledgeField.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_objects.edu_EducationType">
						<div class="unit"><label><t>Education Type</t></label>
						<unit relativeTo="ca_objects.edu_EducationType" delimiter="<br/>">

							<ifdef code="ca_objects.edu_EducationType.edu_EducationTypeType|ca_objects.edu_EducationType.edu_EducationTypeText"><t>Type</t> &mdash; (<b>^ca_objects.edu_EducationType.edu_EducationTypeType</b><ifdef code="ca_objects.edu_EducationType.edu_EducationTypeText,ca_objects.edu_EducationType.edu_EducationTypeType"> - </ifdef>^ca_objects.edu_EducationType.edu_EducationTypeText)</ifdef>
							<ifdef code="ca_objects.edu_EducationType.edu_EducationTypeGrade"><b><t>Grade</t></b> &mdash; (^ca_objects.edu_EducationType.edu_EducationTypeGrade)</ifdef>
							<ifdef code="ca_objects.edu_EducationType.edu_EducationTypeAge"><b><t>Age</t></b> &mdash; (^ca_objects.edu_EducationType.edu_EducationTypeAge)</ifdef>

							<ifdef code="^ca_objects.edu_EducationType"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_objects.edu_EducationType">
									<br/>
									<small><t>Source</t>:</small>
									<small>^ca_objects.edu_EducationType.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}
							
					<!-- <hr></hr> -->

					{{{<ifcount code="ca_collections" min="1"><div class="unit"><ifcount code="ca_collections" min="1" max="1"><label><t>Case Study</t></label></ifcount>
						<ifcount code="ca_collections" min="2"><label><t>Case Studies</t></label></ifcount>
						<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
									
					{{{<ifcount code="ca_occurrences" min="1"><div class="unit"><ifcount code="ca_occurrences" min="1" max="1"><div class="unit"><label><t>Event</t></label></ifcount>
						<ifcount code="ca_occurrences" min="2"><label><t>Events</t></label></ifcount>
						<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_places" min="1"><div class="unit"><ifcount code="ca_places" min="1" max="1"><label><t>Location</t></label></ifcount>
						<ifcount code="ca_places" min="2"><label><t>Locations</t></label></ifcount>
						<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}				

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
				</div>

				<div class="col-sm-6 col-md-6 col-lg-5">
					{{{<ifcount code="ca_objects.related" min="1"><div class="unit"><label><t>Manifestations and Items</t></label>

						<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToTypes="av_manifestation">
						^ca_objects.preferred_labels (^ca_objects.type_id)
						
						<a href="#" class="itemInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
						<div class="itemInfo" style="padding-left: 20px !important;display: none !important;">

							<ifdef code="ca_objects.idno">
								<br/>
								<t>Identifier</t>: ^ca_objects.idno
								<br/>
							</ifdef>

							<ifdef code="ca_objects.vhh_MediaTypeTech">
								<br/>
								<t>Media Technology Type</t>:
								<unit relativeTo="ca_objects.vhh_MediaTypeTech" delimiter=",">
									^MTT_List
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_MediaTypeTech">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_MediaTypeTech.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_Language">
								<br/>
								<t>Language</t>:
								<unit relativeTo="ca_objects.vhh_Language" delimiter="</br>">
									^lang_Name <ifdef code="ca_objects.vhh_Language">(^lang_Usage)</ifdef>
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_Language">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_Language.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_Description">
								<br/>
								<t>Description</t>:
								<div class='unit'>
									<span class="trimText">^ca_objects.vhh_Description.DescriptionText</span>
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_Description">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_Description.__source__</small>
										</ifdef>
									</p>
								</div>
							</ifdef>

							<ifdef code="ca_objects.vhh_URL">
								<br/>
								<t>URL</t>:
								<unit relativeTo="ca_objects.vhh_URL">
									<a href="^ca_objects.vhh_URL" target="_blank">^ca_objects.vhh_URL</a>
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_URL">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_URL.__source__</small>
										</ifdef>
									</p>
								</unit>							
							</ifdef>

							<ifdef code="ca_objects.vhh_Note">
								<br/>
								<t>Note</t>:
								<unit relativeTo="ca_objects" delimiter="<br/>">							
									<span class="trimText">^ca_objects.vhh_Note.vhh_NoteText</span>
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_Note">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_Note.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>		

							<ifdef code="ca_objects.vhh_Origin">
								<br/>
								<t>Origin</t>:
								^ca_objects.vhh_Origin
								<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
									<ifdef code="ca_objects.vhh_Origin">
										<small><t>Source</t>:</small>
										<small>^ca_objects.vhh_Origin.__source__</small>
									</ifdef>
								</p>
							</ifdef>

							<ifdef code="ca_objects.vhh_CarrierType2">
								<br/>
								<t>Carrier Type</t>:
								<unit relativeTo="ca_objects.vhh_CarrierType2" delimiter="<br/>">
									^CarrierTypeList
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_CarrierType2">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_CarrierType2.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_DigitalFormatAV">
								<br/>
								<t>Digital Format</t>:
								<unit relativeTo="ca_objects.vhh_DigitalFormatAV" delimiter=",">
									<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_Coding">(^digi_Coding)</ifdef>
									<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_CodingAudio">(^digi_CodingAudio)</ifdef>
									<ifdef code="ca_objects.vhh_DigitalFormatAV.digi_MIME2">(^digi_MIME2)</ifdef>
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_DigitalFormatAV">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_DigitalFormatAV.__source__</small>
										</ifdef>
									</p>
								</unit>	
							</ifdef>

							<ifdef code="ca_objects.vhh_Gauge">
								<br/>
								<t>Gauge</t>:
								<unit relativeTo="ca_objects.vhh_Gauge" delimiter=",">
									^ca_objects.vhh_Gauge
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_Gauge">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_Gauge.__source__</small>
										</ifdef>
									</p>
								</unit>	
							</ifdef>

							<ifdef code="ca_objects.vhh_AspectRatio">
								<br/>
								<t>Aspect Ratio</t>:
								^ca_objects.vhh_AspectRatio
								<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
									<ifdef code="ca_objects.vhh_AspectRatio">
										<small><t>Source</t>:</small>
										<small>^ca_objects.vhh_AspectRatio.__source__</small>
									</ifdef>
								</p>
							</ifdef>

							<ifdef code="ca_objects.vhh_Extent">
								<br/>
								<t>Extent</t>:
								<unit relativeTo="ca_objects.vhh_Extent" delimiter="<br/>">
									^ext_Value <ifdef code="ca_objects.vhh_Extent">^ext_Unit</ifdef>
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_Extent">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_Extent.__source__</small>
										</ifdef>
									</p>
								</unit>	
							</ifdef>

							<ifdef code="ca_objects.vhh_Duration">
								<br/>
								<t>Duration</t>:
								<unit relativeTo="ca_objects.vhh_Duration" delimiter=",">
									^ca_objects.vhh_Duration
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_Duration">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_Duration.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_Sound">
								<br/>
								<t>Sound</t>: 
								<ifdef code="ca_objects.vhh_Sound.snd_SystemName">^ca_objects.vhh_Sound.snd_SystemName</ifdef>
								<ifdef code="ca_objects.vhh_Sound.snd_HasSound">^ca_objects.vhh_Sound.snd_HasSound</ifdef>
								<ifdef code="ca_objects.vhh_Sound.snd_Method"> (^ca_objects.vhh_Sound.snd_Method)</ifdef>
								<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
									<ifdef code="ca_objects.vhh_Sound">
										<small><t>Source</t>:</small>
										<small>^ca_objects.vhh_Sound.__source__</small>
									</ifdef>
								</p>
							</ifdef>

							<ifdef code="ca_objects.vhh_ColorAV">
								<br/>
								<t>Color</t>: 
								<ifdef code="ca_objects.vhh_ColorAV.colAV_ColorDetail">(^ca_objects.vhh_ColorAV.colAV_ColorDetail)</ifdef>
								<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
									<ifdef code="ca_objects.vhh_ColorAV">
										<small><t>Source</t>:</small>
										<small>^ca_objects.vhh_ColorAV.__source__</small>
									</ifdef>
								</p>
							</ifdef>

							<ifdef code="ca_objects.vhh_Provenance">
								<br/>
								<t>Provenance</t>:
								^ca_objects.vhh_Provenance
								<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
									<ifdef code="ca_objects.vhh_Provenance">
										<small><t>Source</t>:</small>
										<small>^ca_objects.vhh_Provenance.__source__</small>
									</ifdef>
								</p>
							</ifdef>
						</div>
					</unit><br/>

					<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToTypes="item">
						^ca_objects.preferred_labels (^ca_objects.type_id)
						<a href="#" class="itemInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
						<div class="itemInfo" style="padding-left: 20px !important;display: none !important;">

							<ifdef code="ca_objects.idno">
								<br/>
								<t>Identifier</t>: ^ca_objects.idno
							</ifdef>

							<ifdef code="ca_objects.vhh_TitleItem.TitleTextI">
								<br/>
								<t>Title</t>:
								^ca_objects.vhh_TitleItem.TitleTextI
								<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
									<ifdef code="ca_objects.vhh_TitleItem">
										<small><t>Source</t>:</small>
										<small>^ca_objects.vhh_TitleItem.__source__</small>
									</ifdef>
								</p>
							</ifdef>	

							<ifdef code="ca_objects.vhh_Identifier">
								<br/>
								<t>External Identifier</t>:
								<unit relativeTo="ca_objects.vhh_Identifier" delimiter="<br/>">
									^IdentifierScheme 
									<if rule='^ca_objects.vhh_Identifier.IdentifierValue !~ /\?/'>(^ca_objects.vhh_Identifier.IdentifierValue)</if>
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_Identifier.__source__">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_Identifier.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_ItemSpecifics">
								<br/>
								<t>Item Specifics</t>:
								<unit relativeTo="ca_objects.vhh_ItemSpecifics" delimiter="<br/>">
									^vhh_ItemSpecifics
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_ItemSpecifics.__source__">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_ItemSpecifics.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_AccessStatus2.AS_List">
								<br/>
								<t>Access Status</t>:
								<unit relativeTo="ca_objects.vhh_AccessStatus2.AS_List" delimiter="<br/>">
									^ca_objects.vhh_AccessStatus2.AS_List
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_AccessStatus2.__source__">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_AccessStatus2.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>				
				
							<ifdef code="ca_objects.vhh_Extent">
								<br/>
								<t>Extent</t>:
								<unit relativeTo="ca_objects.vhh_Extent.ext_Value" delimiter="<br/>">
									^ca_objects.vhh_Extent.ext_Value
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_Extent.__source__">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_Extent.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>
						
							<ifdef code="ca_objects.vhh_URL">
								<br/>
								<t>URL</t>:
								<unit relativeTo="ca_objects" delimiter="<br/>">
									<a href="^ca_objects.vhh_URL">^ca_objects.vhh_URL</a>
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_URL.__source__">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_URL.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>

							<ifdef code="ca_objects.vhh_Note">
								<br/>
								<t>Note</t>:
								<unit relativeTo="ca_objects.vhh_Note" delimiter="<br/>">							
									<span class="trimText">^ca_objects.vhh_Note.vhh_NoteText</span>
									<p style="padding-left: 20px !important; margin-bottom: 0px !important;">
										<ifdef code="ca_objects.vhh_Note.__source__">
											<small><t>Source</t>:</small>
											<small>^ca_objects.vhh_Note.__source__</small>
										</ifdef>
									</p>
								</unit>
							</ifdef>

						</div>
					</unit></div></ifcount>}}}

					{{{<ifcount code="ca_objects.related" excludeTypes="av_manifestation, item" min="1"><div class="unit"><label><t>Objects</t></label>
						<unit relativeTo="ca_objects.related" delimiter="<br/>" excludeTypes="av_manifestation, item">
						<l>^ca_objects.preferred_labels</l> (^relationship_typename)
						</unit></div></ifcount>}}}

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


