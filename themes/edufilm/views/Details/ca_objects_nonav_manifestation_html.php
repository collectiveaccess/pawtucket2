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
	$va_access_values = caGetUserAccessValues($this->request);
	
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
<?php
			if($vn_item_id = $t_object->get("ca_objects.related.object_id", array("restrictToTypes" => "item", "restrictToRelationshipTypes" => "IsItemOfNonAV", "limit" => 1, "checkAccess" => $va_access_values))){
				$t_item = new ca_objects($vn_item_id);
				# --- MEDIA IS FROM THE ITEM RELATED WITH REL TYPE IsItemOfNonAV  NO MEDIA ON THE MANIFESTATION
				$config = caGetDetailConfig();
				$detail_types = $config->getAssoc('detailTypes');
				$options = $detail_types['objects'];
				$t_representation = $t_item->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values));
				if(!$t_representation || !is_array($media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE')))) { $media_display_info = []; }
			
				$vs_rep_viewer = caRepresentationViewer(
					$this->request, 
					$t_item, 
					$t_object,
					array_merge($options, $media_display_info, 
						[
							'display' => 'detail',
							'showAnnotations' => true, 
							'primaryOnly' => caGetOption('representationViewerPrimaryOnly', $options, false), 
							'dontShowPlaceholder' => caGetOption('representationViewerDontShowPlaceholder', $options, false), 
							#'captionTemplate' => caGetOption('representationViewerCaptionTemplate', $options, false),
							'captionTemplate' => "<div class='small text-left'><if rule='^ca_object_representations.preferred_labels.name !~ /(LEER|BLANK)/'>^ca_object_representations.preferred_labels.name</if><ifdef code='ca_object_representations.vhh_mmsi_processed.__source__'><br/>^ca_object_representations.vhh_mmsi_processed.__source__</ifdef></div>",
							'checkAccess' => $va_access_values
						]
					)
				);
				print $vs_rep_viewer;
			}
				
?>				
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
					<div class="unit">
						<label><t>Identifier</t></label>
						^ca_objects.idno
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Title">
					<div class="unit">
						<label><t>Title</t></label>
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
									<small>Source:</small>
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
									<small>Source:</small>
									<small>^ca_objects.vhh_Identifier.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div>
				</ifdef>}}}
					
					
					{{{<ifdef code="ca_objects.vhh_DigitalFormat.digi_MIME" >
						<div class="unit"><label><t>Digital Format</t></label>
						<unit relativeTo="ca_objects.vhh_DigitalFormat" delimiter="<br/>">
							^ca_objects.vhh_DigitalFormat.digi_MIME

							<ifdef code="ca_objects.vhh_DigitalFormat.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_DigitalFormat.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_DigitalFormat.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div></ifdef>}}}
					{{{<ifdef code="ca_objects.vhh_PhysicalFormat">
						<div class="unit"><label><t>Physical Format</t></label>
						<unit relativeTo="ca_objects.vhh_PhysicalFormat" delimiter="<br/>">
							^ca_objects.vhh_PhysicalFormat.PF_SizeList<ifdef code="ca_objects.vhh_PhysicalFormat.PF_SizeText,ca_objects.vhh_PhysicalFormat.PF_SizeList"> - </ifdef><ifdef code="ca_objects.vhh_PhysicalFormat.PF_SizeText">^ca_objects.vhh_PhysicalFormat.PF_SizeText</ifdef>

							<ifdef code="ca_objects.vhh_PhysicalFormat.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_PhysicalFormat.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_PhysicalFormat.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div></ifdef>}}}
					
					
					
					
					
				{{{<ifdef code="ca_objects.vhh_MediaTypeTech">
					<div class="unit">
						<label><t>Media Technology Type</t></label>
						<unit relativeTo="ca_objects.vhh_MediaTypeTech" delimiter="<br/>">
							^MTT_List

							<ifdef code="^ca_objects.vhh_MediaTypeTech"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_objects.vhh_MediaTypeTech">
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_MediaTypeTech.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.vhh_Date" >
						<div class="unit"><label><t>Date</t></label>
						<unit relativeTo="ca_objects.vhh_Date" delimiter="<br/>">
							^date_Date <ifdef code="ca_objects.vhh_Date.date_Type">(^date_Type)</ifdef>

							<ifdef code="ca_objects.vhh_Date.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_Date.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_Date.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Language2">
					<div class="unit"><label><t>Language</t></label>
					<unit relativeTo="ca_objects.vhh_Language2" delimiter="<br/>">
						^vhh_Language2
						<ifdef code="^ca_objects.vhh_Language2"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="^ca_objects.vhh_Language2">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.vhh_Language2.__source__</small>
							</ifdef>
						</div>
					</unit>
				</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.vhh_Extent">
					<div class="unit"><label><t>Extent</t></label>
					<unit relativeTo="ca_objects.vhh_Extent" delimiter="<br/>">
						^ext_Value <ifdef code="ca_objects.vhh_Extent">^ext_Unit</ifdef>
						<ifdef code="ca_objects.vhh_Extent.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_Extent.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_Extent.__source__</small>
								</ifdef>
							</div>
					</unit></div>	
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Description">
					<div class='unit'>
						<label><t>Description</t></label>
						
						<unit relativeTo="ca_objects.vhh_Description" delimiter="<br/>">
							<span class="trimText">^ca_objects.vhh_Description.DescriptionText</span>

							<ifdef code="ca_objects.vhh_Description.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_Description.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_Description.__source__</small>
								</ifdef>
							</div>
						</unit>
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
					<div class="unit"><label><t>Note</t></label>
					<unit relativeTo="ca_objects.vhh_Note" delimiter="<br/>">							
						<span class="trimText">^ca_objects.vhh_Note.vhh_NoteText</span>
						<ifdef code="^ca_objects.vhh_Note.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="^ca_objects.vhh_Note.__source__">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.vhh_Note.__source__</small>
							</ifdef>
						</div>
					</unit>
					</div>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.vhh_Origin">
					<div class="unit">
						<label><t>Origin</t></label>
						<unit relativeTo="ca_objects.vhh_Origin" delimiter="<br/>">							
							^vhh_Origin
							<ifdef code="ca_objects.vhh_Origin.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_Origin.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_Origin.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_PublicationStatus">
					<div class="unit"><label><t>Publication Status</t></label>
					<unit relativeTo="ca_objects.vhh_PublicationStatus" delimiter="<br/>">
						^vhh_PublicationStatus
						<ifdef code="ca_objects.vhh_PublicationStatus.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_objects.vhh_PublicationStatus.__source__">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.vhh_PublicationStatus.__source__</small>
							</ifdef>
						</div>
					</unit>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_PublicationType2">
					<div class="unit"><label><t>Publication Type</t></label>
					<unit relativeTo="ca_objects.vhh_PublicationType2" delimiter="<br/>">
						^PublicationTypeList
						<ifdef code="ca_objects.PublicationTypeList.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_objects.PublicationTypeList.__source__">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.PublicationTypeList.__source__</small>
							</ifdef>
						</div>
					</unit>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_GenreNonAV">
					<div class="unit"><label><t>Genre (Non-AV)</t></label>
					<unit relativeTo="ca_objects.vhh_GenreNonAV" delimiter="<br/>">
						^GenreNonAV_List

						<ifdef code="ca_objects.vhh_GenreNonAV.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_objects.vhh_GenreNonAV.__source__">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.vhh_GenreNonAV.__source__</small>
							</ifdef>
						</div>
					</unit>
				</div></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_CarrierType2">
					<div class="unit"><label><t>Carrier Type</t></label>
					<unit relativeTo="ca_objects.vhh_CarrierType2" delimiter="<br/>">
						^CarrierTypeList
						<ifdef code="ca_objects.vhh_CarrierType2.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_objects.vhh_CarrierType2.__source__">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.vhh_CarrierType2.__source__</small>
							</ifdef>
						</div>
					</unit>
				</div></ifdef>}}}
				
				

				{{{<ifdef code="ca_objects.edu_KnowledgeField">
					<div class="unit"><label><t>Field of Knowledge</t></label>
					<unit relativeTo="ca_objects.edu_KnowledgeField" delimiter="<br/>">
						^edu_KnowlegdeFieldType

						<ifdef code="^ca_objects.edu_KnowledgeField"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="^ca_objects.edu_KnowledgeField">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.edu_KnowledgeField.__source__</small>
							</ifdef>
						</div>
					</unit></div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.edu_EducationType">
					<div class="unit"><label><t>Education Type</t></label>
					<unit relativeTo="ca_objects.edu_EducationType" delimiter="<br/>">

						<ifdef code="ca_objects.edu_EducationType.edu_EducationTypeType|ca_objects.edu_EducationType.edu_EducationTypeText"><t>Type</t> &mdash; (<b>^ca_objects.edu_EducationType.edu_EducationTypeType</b><ifdef code="ca_objects.edu_EducationType.edu_EducationTypeText,ca_objects.edu_EducationType.edu_EducationTypeType"> - </ifdef>^ca_objects.edu_EducationType.edu_EducationTypeText)</ifdef>
						<ifdef code="ca_objects.edu_EducationType.edu_EducationTypeGrade"><t>Grade</t> - (^ca_objects.edu_EducationType.edu_EducationTypeGrade)</ifdef>
						<ifdef code="ca_objects.edu_EducationType.edu_EducationTypeAge"><t>Age</t> - (^ca_objects.edu_EducationType.edu_EducationTypeAge)</ifdef>

						<ifdef code="^ca_objects.edu_EducationType"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="^ca_objects.edu_EducationType">
								<br/>
								<small>Source:</small>
								<small>^ca_objects.edu_EducationType.__source__</small>
							</ifdef>
						</div>
					</unit></div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_ColorNonAV">
					<div class="unit">
						<label><t>Color</t></label>
						<unit relativeTo="ca_objects.vhh_ColorNonAV" delimiter="<br/>">

							<ifdef code="ca_objects.vhh_ColorNonAV.colNAV_HasColor"><t>Has Color?</t> - (^ca_objects.vhh_ColorNonAV.colNAV_HasColor)</ifdef>
							<ifdef code="ca_objects.vhh_ColorNonAV.colNAV_ColorDetail"><t>Color Detail</t> - (^ca_objects.vhh_ColorNonAV.colNAV_ColorDetail)</ifdef>
							<ifdef code="ca_objects.vhh_ColorNonAV.colNAV_ColorSpace"><t>Color Space</t> - (^ca_objects.vhh_ColorNonAV.colNAV_ColorSpace)</ifdef>
							<ifdef code="ca_objects.vhh_ColorNonAV.colNAV_Depth"><t>Color Depth</t> - (^ca_objects.vhh_ColorNonAV.colNAV_Depth)</ifdef>

							<ifdef code="ca_objects.vhh_ColorNonAV.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_ColorNonAV.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_ColorNonAV.__source__</small>
								</ifdef>
							</div>
						</unit>	
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.vhh_Provenance">
					<div class="unit"><label><t>Provenance</t></label>
					<unit relativeTo="ca_objects.vhh_Provenance" delimiter="<br/>">
						^ca_objects.vhh_Provenance
						<ifdef code="ca_objects.vhh_Provenance.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_objects.vhh_Provenance.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_objects.vhh_Provenance.__source__</small>
								</ifdef>
							</div>
					</unit></div>	
				</ifdef>}}}
						
				<hr></hr>

				{{{<ifcount code="ca_collections" min="1"><div class="unit"><ifcount code="ca_collections" min="1" max="1"><label><t>Case Study</t></label></ifcount>
					<ifcount code="ca_collections" min="2"><label><t>Case Studies</t></label></ifcount>
					<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
				
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
					
				{{{<ifcount code="ca_collections" min="1"><div class="unit"><ifcount code="ca_occurrences" min="1" max="1"><label><t>Event</t></label></ifcount>
					<ifcount code="ca_occurrences" min="2"><label><t>Events</t></label></ifcount>
					<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
				
				{{{<ifcount code="ca_places" min="1"><div class="unit"><ifcount code="ca_places" min="1" max="1"><label><t>Location</t></label></ifcount>
					<ifcount code="ca_places" min="2"><label><t>Locations</t></label></ifcount>
					<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}				

				<div class="row">
					<div class="col-sm-12">		
						{{{<ifcount code="ca_objects.related" excludeTypes="item" min="1"><div class="unit"><label><t>Objects</t></label>
							<unit relativeTo="ca_objects.related" excludeTypes="item" delimiter="<br/>">
							<l>^ca_objects.preferred_labels</l> (^relationship_typename) &rarr; (^ca_objects.type_id)
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
