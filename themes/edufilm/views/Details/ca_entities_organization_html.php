<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_default_html.php : 
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
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H2>
				</div><!-- end col -->
			</div><!-- end row -->
<?php
		if($this->request->getParameter("mode", pString) == "visualization"){
?>
			<div class="row">
				<div class="col-sm-12 enlargedViz">
<?php
			print "<div class='unit'>".caDetailLink($this->request, _t("Back"), "btn btn-default", "ca_entities", $t_item->get("ca_entities.entity_id"))."</div>";
			print $this->render('Details/entity_viz_html.php');
?>
				</div>
			</div>
<?php
		}else{
?>
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					
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

					{{{<ifdef code="ca_entities.vhh_GroupName">
						<div class="unit">
							<label><t>Name</t></label>

							<unit relativeTo="ca_entities.vhh_GroupName" delimiter="<br/>">
								^GN_Name 
								<ifdef code="ca_entities.vhh_GroupName.GN_Type">(^GN_Type)</ifdef> 

								<ifdef code="ca_entities.vhh_GroupName.GN_TempScope|ca_entities.vhh_GroupName.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
								<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
									<ifdef code="ca_entities.vhh_GroupName.GN_TempScope">
										<br/>
										<small><t>Temporal Scope:</t></small>
										<small>^ca_entities.vhh_GroupName.GN_TempScope</small>
									</ifdef>
									<ifdef code="ca_entities.vhh_GroupName.__source__">
										<br/>
										<small><t>Source:</t></small>
										<small>^ca_entities.vhh_GroupName.__source__</small>
									</ifdef>
								</div>
							</unit>
						</div>
					</ifdef>}}}

					{{{<ifdef code="ca_entities.vhh_Date">
						<div class="unit">
							<label><t>Date</t></label>
							<unit relativeTo="ca_entities.vhh_Date" delimiter="<br/>">
								^ca_entities.vhh_Date.date_Date <ifdef code="ca_entities.vhh_Date.date_Type">(^ca_entities.vhh_Date.date_Type)</ifdef>
								<ifdef code="ca_entities.vhh_Date.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
								<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
									<ifdef code="ca_entities.vhh_Date.__source__">
										<br/>
										<small><t>Source:</t></small>
										<small>^ca_entities.vhh_Date.__source__</small>
									</ifdef>
								</div>
							</unit>
						</div>
					</ifdef>}}}

					{{{<ifdef code="ca_entities.vhh_TypeOfActivity2"><div class="unit">
						<label><t>Type of Activity</t></label>

						<unit relativeTo="ca_entities.vhh_TypeOfActivity2" delimiter="<br/>"><ifdef code="ca_entities.vhh_TypeOfActivity2.ActivityList|ca_entities.vhh_TypeOfActivity2.ActivityText">
							<b>^ActivityList.preferred_labels.name_singular</b><ifdef code="ca_entities.vhh_TypeOfActivity2.ActivityList,ca_entities.vhh_TypeOfActivity2.ActivityText"> &mdash; </ifdef>^ca_entities.vhh_TypeOfActivity2.ActivityText
							<ifdef code="ca_entities.vhh_TypeOfActivity2.TOA_TempScope|ca_entities.vhh_TypeOfActivity2.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_entities.vhh_TypeOfActivity2.TOA_TempScope">
									<br/>
									<small><t>Temporal Scope:</t></small>
									<small>^ca_entities.vhh_TypeOfActivity2.TOA_TempScope</small>
								</ifdef>
								<ifdef code="ca_entities.vhh_TypeOfActivity2.__source__">
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_entities.vhh_TypeOfActivity2.__source__</small>
								</ifdef>
							</div>
						</ifdef></unit>
					</ifdef></ifdef>}}}
					
					{{{<ifdef code="ca_entities.vhh_Description">
							<unit relativeTo="ca_entities.vhh_Description" delimiter=" ">
								<if rule='^ca_entities.vhh_Description.DescriptionType !~ /(history|Geschichte)/i'>
								<div class="unit"><label><t>Description</t></label>
									<div><ifdef code="ca_entities.vhh_Description.DescriptionType"><b>^ca_entities.vhh_Description.DescriptionType</b> &mdash;</ifdef>^ca_entities.vhh_Description.DescriptionText
										<ifdef code="ca_entities.vhh_Description.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
										<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
											<ifdef code="ca_entities.vhh_Description.__source__">
												<br/>
												<small><t>Source:</t></small>
												<small>^ca_entities.vhh_Description.__source__</small>
											</ifdef>
										</div>
									</div>
								</div>
								</if>
							</unit>
					</ifdef>}}}

					{{{<ifdef code="ca_entities.vhh_URL">
						<div class='unit'>
							<label><t>URL</t></label>
							<unit relativeTo="ca_entities.vhh_URL" delimiter="<br/>">
								<a href="^ca_entities.vhh_URL" target="_blank">^ca_entities.vhh_URL</a>
								<ifdef code="ca_entities.vhh_URL.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
								<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
									<ifdef code="ca_entities.vhh_URL.__source__">
										<br/>
										<small><t>Source:</t></small>
										<small>^ca_entities.vhh_URL.__source__</small>
									</ifdef>
								</div>
							</unit>
						</div>
					</ifdef>}}}

					{{{<ifdef code="ca_entities.vhh_Description">			
						<unit relativeTo="ca_entities.vhh_Description" delimiter=" ">
							<if rule='^ca_entities.vhh_Description.DescriptionType =~ /(history|Geschichte)/i'>
								<div class="unit"><label><t>Historical overview</t></label>
									<span class="trimText">^ca_entities.vhh_Description.DescriptionText</span>
									<ifdef code="ca_entities.vhh_Description.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
									<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
										<ifdef code="ca_entities.vhh_Description.__source__">
											<br/>
											<small><t>Source:</t></small>
											<small>^ca_entities.vhh_Description.__source__</small>
										</ifdef>
									</div>
								</div>
							</if>
						</unit>
					</ifdef>}}}
					
					{{{<ifdef code="ca_entities.vhh_Note">
						<div class='unit'><label><t>Notes</t></label>

						<unit relativeTo="ca_entities.vhh_Note" delimiter="<br/>">							
							<span class="trimText">^vhh_NoteText%convertLineBreaks=1</span>
							<ifdef code="^ca_entities.vhh_Note.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_entities.vhh_Note.">
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_entities.vhh_Note.__source__</small>
								</ifdef>
							</div>
						</unit>
					</div></ifdef>}}}

					{{{<ifdef code="ca_entities.edu_EduOrgType">
						<div class="unit"><label><t>Education Type</t></label>
						<unit relativeTo="ca_entities.edu_EduOrgType" delimiter="<br/>">

							<ifdef code="ca_entities.edu_EduOrgType.edu_EduOrgTypeType">^edu_EduOrgTypeType</ifdef>
							<ifdef code="ca_entities.edu_EduOrgType.edu_EduOrgTypeText"> - ^edu_EduOrgTypeText</ifdef>

							<ifdef code="^ca_entities.edu_EduOrgType"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_entities.edu_EduOrgType">
									<br/>
									<small>Source:</small>
									<small>^ca_entities.edu_EduOrgType.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}
					
				</div><!-- end col -->

				<div class='col-sm-6 col-md-6 col-lg-6'>
					
					{{{<ifdef code="ca_entities.description"><div class='unit'><label><t>Biography</t></label>^ca_entities.description</div></ifdef>}}}
					
					{{{<ifcount code="ca_collections" min="1"><div class="unit"><ifcount code="ca_collections" min="1" max="1"><label><t>Case Study</t></label></ifcount>
						<ifcount code="ca_collections" min="2"><label><t>Case Studies</t></label></ifcount>
						<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_occurrences" min="1"><div class="unit"><ifcount code="ca_occurrences" min="1" max="1"><label><t>Event</t></label></ifcount>
						<ifcount code="ca_occurrences" min="2"><label><t>Events</t></label></ifcount>
						<unit relativeTo="ca_entities_x_occurrences" delimiter="<br/>">
						<l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)
						<ifdef code="ca_entities_x_occurrences.vhh_TemporalScope|ca_entities_x_occurrences.vhh_Note.vhh_NoteText"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_entities_x_occurrences.vhh_TemporalScope">
								<br/>
								<small><t>Temporal Scope:</t></small>
								<unit relativeTo="ca_entities_x_occurrences.vhh_TemporalScope" delimiter=",">
									<small>^ca_entities_x_occurrences.vhh_TemporalScope</small>
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_entities_x_occurrences.vhh_TemporalScope.__source__</small>
								</unit>
							</ifdef>

							<ifdef code="ca_entities_x_occurrences.vhh_Note.vhh_NoteText">
								<br/>
								<small><t>Note:</t></small>
								<unit relativeTo="ca_entities_x_occurrences.vhh_Note.vhh_NoteText" delimiter=",">
									<small>^ca_entities_x_occurrences.vhh_Note.vhh_NoteText</small>
									<br/>
									<small><t>Source:</t></small>
									<small>^ca_entities_x_occurrences.vhh_Note.__source__</small>
								</unit>
							</ifdef>
						</div>
					</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_places" min="1"><div class="unit"><ifcount code="ca_places" min="1" max="1"><label><t>Location</t></label></ifcount>
						<ifcount code="ca_places" min="2"><label><t>Locations</t></label></ifcount>
						<unit relativeTo="ca_entities_x_places" delimiter="<br/>">
						<l>^ca_places.preferred_labels.name</l> (^relationship_typename)
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
					</unit></div></ifcount>}}}
<?php
$va_related_entities = $t_item->get("ca_entities.related", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
if(is_array($va_related_entities) && sizeof($va_related_entities)){
?>
	<div class="unit">
<?php
	if(sizeof($va_related_entities) > 1){
		print "<label>"._t("People/Organizations")."</label>";
	}else{
		print "<label>"._t("Person/Organization")."</label>";
	}
	foreach($va_related_entities as $va_related_entity){
		print caDetailLink($this->request, $va_related_entity['displayname'], '', 'ca_entities', $va_related_entity['entity_id'])." (".$va_related_entity["relationship_typename"].") ";
		$t_relation = new ca_entities_x_entities($va_related_entity['relation_id']);
		print $t_relation->getWithTemplate('<ifdef code="ca_entities_x_entities.vhh_TemporalScope|ca_entities_x_entities.vhh_TemporalScope.__source__|ca_entities_x_entities.vhh_Note.vhh_NoteText|ca_entities_x_entities.vhh_Note.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_entities_x_entities.vhh_TemporalScope|ca_entities_x_entities.vhh_TemporalScope.__source__">
								<br/>
								<small><t>Temporal Scope:</t></small>
								<unit relativeTo="ca_entities_x_entities.vhh_TemporalScope" delimiter=",">
									
									<ifdef code="ca_entities_x_entities.vhh_TemporalScope"><small>^ca_entities_x_entities.vhh_TemporalScope</small><br/></ifdef>
									<small><t>Source:</t></small>
									<small>^ca_entities_x_entities.vhh_TemporalScope.__source__</small>
								</unit>
							</ifdef>

							<ifdef code="ca_entities_x_entities.vhh_Note.vhh_NoteText|ca_entities_x_entities.vhh_Note.__source__">
								<br/>
								<unit relativeTo="ca_entities_x_entities.vhh_Note.vhh_NoteText" delimiter=",">
									<ifdef code="ca_entities_x_entities.vhh_Note.vhh_NoteText">
										<small><t>Note:</t></small><br/>
										<small>^ca_entities_x_entities.vhh_Note.vhh_NoteText</small><br/>
									</ifdef>
									<small><t>Source:</t></small>
									<small>^ca_entities_x_entities.vhh_Note.__source__</small>
								</unit>
							</ifdef>
						</div>');
		print "<br/>";
	}
?>
	</div>
<?php
}
?>

					<!-- TODO: where do we stick the visualization? -->
					<?= $this->render('Details/entity_viz_html.php'); ?>
					
					<br/><br/>
					{{{map}}}
				</div><!-- end col -->
			</div><!-- end row -->

<?php
	$va_related_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	
	$o_related_object = caMakeSearchResult("ca_objects", $va_related_object_ids, array("checkAccess" => $va_access_values));
	$vb_show_tabs = $vb_films = $vb_texts = $vb_images = false;
	if($o_related_object){
		while($o_related_object->nextHit()){
			switch($o_related_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))){
				case "AVCreation":
					$vb_films = true;
					$vb_show_tabs = true;
				break;
				# -----------------------
				case "NonAVManifestation":
					switch($o_related_object->get("ca_objects.vhh_MediaType.MT_List", array("convertCodesToDisplayText" => true))){
						case "still image (photographic)":
						case "still image (other)":
							$vb_images = true;
							$vb_show_tabs = true;
						break;
						# ------------------
						case "text":
						case "imagetext":
							$vb_texts = true;
							$vb_show_tabs = true;
						break;
						# ------------------
					}
				break;
				# -----------------------
				
			}
			if($vb_films && $vb_texts && $vb_images){
				break;
			}
		}
	}
		if($vb_show_tabs){
?>
			<div class="row">
				<div class="col-sm-12">
						<div class="relatedBlock">
							<div class="relatedBlockTabs">
<?php
								$vs_firstTab = "";
								if($vb_films){
									print "<div id='relFilmsButton' class='relTabButton' onClick='toggleTag(\"relFilms\");'>"._t("Films")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relFilms";
									}
								}
								if($vb_images){
									print "<div id='relImagesButton' class='relTabButton' onClick='toggleTag(\"relImages\");'>"._t("Images")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relImages";
									}
								}
								if($vb_texts){
									print "<div id='relTextsButton' class='relTabButton' onClick='toggleTag(\"relTexts\");'>"._t("Texts")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relTexts";
									}
								}
?>
							</div>
							<div class="relatedBlockContent">							
<?php
									if($vb_films){
?>							
										<div class="row relTab" id="relFilms">
											<div id="browseResultsContainerFilms">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerFilms").load("<?php print caNavUrl($this->request, '', 'Browse', 'films', array('facet' => 'entity_facet', 'id' => $t_item->get('ca_entities.entity_id'), 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerFilms').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
									if($vb_images){
?>
										<div class="row relTab" id="relImages">
											<div id="browseResultsContainerImages">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerImages").load("<?php print caNavUrl($this->request, '', 'Search', 'images', array('search' => 'entity_id:'.$t_item->get('ca_entities.entity_id'), 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerImages').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
									if($vb_texts){
?>										
										<div class="row relTab" id="relTexts">
											<div id="browseResultsContainerTexts">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerTexts").load("<?php print caNavUrl($this->request, '', 'Search', 'texts', array('search' => 'entity_id:'.$t_item->get('ca_entities.entity_id'), 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerTexts').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
?>

								
								
							</div>
						</div>
				</div>
			</div>


						<script type="text/javascript">
							function toggleTag(ID){
								$('.relTab').css('display', 'none');
								$('#' + ID).css('display', 'block');
								$('.relTabButton').removeClass('selected');
								$('#' + ID + 'Button').addClass('selected');
							}
							jQuery(document).ready(function() {
								toggleTag("<?php print $vs_firstTab; ?>");
							});
						</script>


<?php
			}
?>	
		
<?php
		}
?>
		
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
