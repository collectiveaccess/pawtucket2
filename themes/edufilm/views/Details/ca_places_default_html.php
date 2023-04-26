<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_placess_default_html.php : 
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
 
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_places.preferred_labels.name}}}</H1>
					<H2>{{{^ca_places.type_id}}}{{{<ifdef code="ca_places.idno">, ^ca_places.idno</ifdef>}}}</H2>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
					
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
					{{{representationViewer}}}
				
				
					<div id="detailAnnotations"></div>
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
					
					{{{map}}}
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>

					{{{<ifdef code="ca_places.vhh_TitlePlace">
						<div class="unit"><label><t>Name</t></label>
						<unit relativeTo="ca_places.vhh_TitlePlace" delimiter="<br/>">
							^TP_Name
							<ifdef code="ca_places.vhh_TitlePlace.TP_Type">(^TP_Type)</ifdef> 
							
							<ifdef code="ca_places.vhh_TitlePlace.TP_TempScope|ca_places.vhh_TitlePlace.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_places.vhh_TitlePlace.TP_TempScope">
									<br/>
									<small><t>Temporal Scope:</t></small>
									<small>^ca_places.vhh_TitlePlace.TP_TempScope</small>
								</ifdef>
								<ifdef code="ca_places.vhh_TitlePlace.__source__">
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_places.vhh_TitlePlace.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div></ifdef>}}}
					
					{{{<ifdef code="ca_places.vhh_Date">
						<div class="unit">
							<label><t>Date</t></label>
							<unit relativeTo="ca_places.vhh_Date" delimiter="<br/>">
								^date_Date <ifdef code="ca_places.vhh_Date.date_Type">(^date_Type)</ifdef><ifdef code="ca_places.vhh_Date.edu_DateText"> - ^ca_places.vhh_Date.edu_DateText</ifdef>						
								<ifdef code="ca_places.vhh_Date.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
								<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
									<ifdef code="ca_places.vhh_Date.__source__">
										<br/>
										<small><t>Source:</t></small>
										<small>^ca_places.vhh_Date.__source__</small>
									</ifdef>
								</div>
							</unit>
						</div>
					</ifdef>}}}		

					{{{<ifdef code="ca_places.vhh_Address">
						<div class="unit"><label><t>Address</t></label>
							<unit relativeTo="ca_places.vhh_Address" delimiter="<br/>">
								<ifdef code="ca_places.vhh_Address.A_Street">^A_Street</ifdef>
								<ifdef code="ca_places.vhh_Address.A_StreetNo">^A_StreetNo,</ifdef>
								<ifdef code="ca_places.vhh_Address.A_Zipcode">^A_Zipcode</ifdef>
								<ifdef code="ca_places.vhh_Address.A_City">^A_City,</ifdef>
								<ifdef code="ca_places.vhh_Address.A_Country">^A_Country</ifdef>
								<ifdef code="ca_places.vhh_Address.A_TempScope">(^A_TempScope)</ifdef>

								<ifdef code="^ca_places.vhh_Address"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
								<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
									<ifdef code="^ca_places.vhh_Address">
										<br/>
										<small>Source:</small>
										<small>^ca_places.vhh_Address.__source__</small>
									</ifdef>
								</div>
							</unit>
						</div>
					</ifdef>}}}		
					
					{{{<ifdef code="ca_places.vhh_UseOfSpace">
						<div class="unit"><label><t>Use Of Space</t></label>
							<unit relativeTo="ca_places.vhh_UseOfSpace" delimiter="<br/>">
								<b>^UOS_TypeList.preferred_labels.name_singular</b>
								<ifdef code="ca_places.vhh_UseOfSpace.UOS_TypeText"> - ^ca_places.vhh_UseOfSpace.UOS_TypeText</ifdef>
								
								<ifdef code="^ca_places.vhh_UseOfSpace"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
								<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
									<ifdef code="^ca_places.vhh_UseOfSpace">
										<br/>
										<small>Source:</small>
										<small>^ca_places.vhh_UseOfSpace.__source__</small>
									</ifdef>
								</div>
							</unit>
						</div>
					</ifdef>}}}

					{{{<ifdef code="ca_places.edu_EduPlaceType">
						<div class="unit"><label><t>Educational Place Type</t></label>
						<unit relativeTo="ca_places.edu_EduPlaceType" delimiter="<br/>">
							<b>^edu_EduPlaceTypeType</b>
							<ifdef code="ca_places.edu_EduPlaceType.edu_EduPlaceTypeText"> &mdash; ^ca_places.edu_EduPlaceType.edu_EduPlaceTypeText</ifdef>

							<ifdef code="^ca_places.edu_EduPlaceType"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_places.edu_EduPlaceType">
									<br/>
									<small>Source:</small>
									<small>^ca_places.edu_EduPlaceType.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_places.edu_VenueCapacity">
						<div class="unit"><label><t>Capacity</t></label>
						<unit relativeTo="ca_places.edu_VenueCapacity" delimiter="<br/>">
							<ifdef code="ca_places.edu_VenueCapacity.edu_VenueSeatsNumber">^ca_places.edu_VenueCapacity.edu_VenueSeatsNumber</ifdef><ifdef code="ca_places.edu_VenueCapacity.edu_VenueCapacityText"> ^ca_places.edu_VenueCapacity.edu_VenueCapacityText</ifdef>
							<ifdef code="ca_places.edu_VenueCapacity.edu_TemporalScope|ca_places.edu_VenueCapacity"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_places.edu_VenueCapacity.edu_TemporalScope">
									<br/>
									<small><t>Temporal Scope:</t></small>
									<small>^ca_places.edu_VenueCapacity.edu_TemporalScope</small>
								</ifdef>
								<ifdef code="ca_places.edu_VenueCapacity">
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_places.edu_VenueCapacity.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_places.description">
						<div class="unit">
							<label><t>About</t></label>
							^ca_places.description
							<ifdef code="^ca_places.description"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_places.description">
									<br/>
									<small>Source:</small>
									<small>^ca_places.description.__source__</small>
								</ifdef>
							</div>
							<br/>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_places.vhh_Description">
						<div class="unit"><label><t>Description</t></label>
							<unit relativeTo="ca_places.vhh_Description" delimiter=" ">
								
									<div><ifdef code="ca_places.vhh_Description.DescriptionType"><b>^ca_places.vhh_Description.DescriptionType</b> &mdash;</ifdef>^ca_places.vhh_Description.DescriptionText
									<ifdef code="ca_places.vhh_Description.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
									<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
										<ifdef code="ca_places.vhh_Description.__source__">
											<br/>
											<small><t>Source:</t></small>
											<small>^ca_places.vhh_Description.__source__</small>
										</ifdef>
									</div>
									</div>
							</unit>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_places.vhh_URL">
						<div class="unit"><label><t>URL</t></label>
						<unit relativeTo="ca_places.vhh_URL" delimiter="<br/>">
							<a href="^ca_places.vhh_URL" target="_blank">^ca_places.vhh_URL</a>
							<ifdef code="^ca_places.vhh_URL"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_places.vhh_URL">
									<br/>
									<small>Source:</small>
									<small>^ca_places.vhh_URL.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_places.vhh_Note">
						<div class="unit"><label><t>Note</t></label>
						<unit relativeTo="ca_places.vhh_Note" delimiter="<br/>">
							^vhh_NoteText
							<ifdef code="^ca_places.vhh_Note.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_places.vhh_Note.__source__">
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_places.vhh_Note.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}

					{{{<ifcount code="ca_collections" min="1"><div class="unit"><ifcount code="ca_collections" min="1" max="1"><label><t>Case Study</t></label></ifcount>
						<ifcount code="ca_collections" min="2"><label><t>Case Studies</t></label></ifcount>
						<unit relativeTo="ca_collections" delimiter="<br/>">
						<l>^ca_collections.preferred_labels.name</l> (^relationship_typename)
					</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_entities" min="1"><div class="unit"><ifcount code="ca_entities" min="1" max="1"><label><t>Person/Organization</t></label></ifcount>
						<ifcount code="ca_entities" min="2"><label><t>People/Organizations</t></label></ifcount>

						<unit relativeTo="ca_entities_x_places" delimiter="<br/>">
						<l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)

						<ifdef code="ca_entities_x_places.vhh_TemporalScope|ca_entities_x_places.vhh_Note.vhh_NoteText"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_entities_x_places.vhh_TemporalScope">
								<br/>
								<small><t>Temporal Scope:</t></small>
								<unit relativeTo="ca_entities_x_places.vhh_TemporalScope" delimiter=",">
									<small>^ca_entities_x_places.vhh_TemporalScope</small>
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_entities_x_places.vhh_TemporalScope.__source__</small>
								</unit>
							</ifdef>
							<br/>
							<ifdef code="ca_entities_x_places.vhh_Note.vhh_NoteText">
								<br/>
								<small><t>Note:</t></small>
								<unit relativeTo="ca_entities_x_places.vhh_Note.vhh_NoteText" delimiter=",">
									<small>^ca_entities_x_places.vhh_Note.vhh_NoteText</small>
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_entities_x_places.vhh_Note.__source__</small>
								</unit>
							</ifdef>
						</div>
						<br/>
					</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_occurrences" min="1"><div class="unit"><ifcount code="ca_occurrences" min="1" max="1"><label><t>Event</t></label></ifcount>
						<ifcount code="ca_occurrences" min="2"><label><t>Events</t></label></ifcount>
						<unit relativeTo="ca_places_x_occurrences" delimiter="<br/>">
						<l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)
						<ifdef code="ca_places_x_occurrences.vhh_TemporalScope|ca_places_x_occurrences.vhh_Note.vhh_NoteText"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_places_x_occurrences.vhh_TemporalScope">
								<br/>
								<small><t>Temporal Scope:</t></small>
								<unit relativeTo="ca_places_x_occurrences.vhh_TemporalScope" delimiter=",">
									<small>^ca_places_x_occurrences.vhh_TemporalScope</small>
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_entities_x_places.vhh_TemporalScope.__source__</small>
								</unit>
							</ifdef>

							<ifdef code="ca_places_x_occurrences.vhh_Note.vhh_NoteText">
								<br/>
								<small><t>Note:</t></small>
								<unit relativeTo="ca_places_x_occurrences.vhh_Note.vhh_NoteText" delimiter=",">
									<small>^ca_places_x_occurrences.vhh_Note.vhh_NoteText</small>
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_places_x_occurrences.vhh_Note.__source__</small>
								</unit>
							</ifdef>
						</div>
						<br/>
					</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_places.related" min="1"><div class="unit"><ifcount code="ca_places.related" min="1" max="1"><label><t>Location</t></label></ifcount>
						<ifcount code="ca_places.related" min="2"><label><t>Locations</t></label></ifcount>
					<unit relativeTo="ca_places.related" delimiter="<br/>">
						<l>^ca_places.preferred_labels.name</l> (^relationship_typename) 
					</unit></div></ifcount>}}}	

				</div><!-- end col -->
			</div><!-- end row -->
			{{{<ifcount code="ca_objects.related" min="1">
				<H1><t>Related Films, Texts and Images</t></H1>

				<div class="row">
					<div id="browseResultsContainer">
						<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
					</div><!-- end browseResultsContainer -->
				</div><!-- end row -->
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'place_id:^ca_places.place_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
							jQuery('#browseResultsContainer').jscroll({
								autoTrigger: true,
								loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
								padding: 20,
								nextSelector: 'a.jscroll-next'
							});
						});
					});
				</script>
			</ifcount>}}}		
	</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

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
