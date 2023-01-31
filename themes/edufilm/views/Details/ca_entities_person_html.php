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
					{{{<ifcount code="ca_entities.vhh_PersonName" min="1">
						<label>Name</label>
						<unit relativeTo="ca_entities.vhh_PersonName" delimiter="<br/>">
							^PN_DisplayName

							<a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_entities.vhh_PersonName.PN_TempScope">
									<br/>
									<small>Name Temporal Scope:</small>
									<small>^ca_entities.vhh_PersonName.PN_TempScope</small>
								</ifdef>
								<ifdef code="ca_entities.vhh_PersonName.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_entities.vhh_PersonName.__source__</small>
								</ifdef>
							</div>
						</unit>

					</ifcount>}}}
					
					{{{<ifcount code="ca_entities.vhh_Date" min="1">
						<label>Date</label>
						<unit relativeTo="ca_entities.vhh_Date" delimiter="<br/>">
							^ca_entities.vhh_Date.date_Date <ifdef code="ca_entities.vhh_Date.date_Type">(^ca_entities.vhh_Date.date_Type)</ifdef>
						</unit>
					</ifcount>}}}

					{{{<ifdef code="ca_entities.vhh_Sex"><div class='unit'><label>Gender</label>^ca_entities.vhh_Sex</div></ifdef>}}}
					
					{{{<ifcount code="ca_entities.vhh_TypeOfActivity2" min="1">
						<label>Type of Activity</label>

						<unit relativeTo="ca_entities.vhh_TypeOfActivity2" delimiter="<br/>">
							^ActivityList.preferred_labels.name_singular 
							<a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="ca_entities.vhh_TypeOfActivity2.TOA_TempScope">
									<br/>
									<small>Temporal Scope:</small>
									<small>^ca_entities.vhh_TypeOfActivity2.TOA_TempScope</small>
								</ifdef>
								<ifdef code="ca_entities.vhh_TypeOfActivity2.__source__">
									<br/>
									<small>Source:</small>
									<small>^ca_entities.vhh_TypeOfActivity2.__source__</small>
								</ifdef>
							</div>
						</unit>
					</ifcount>}}}
					
					
					{{{<ifdef code="ca_entities.vhh_Description">
						<label>Description</label>
						<unit relativeTo="ca_entities.vhh_Description">^ca_entities.vhh_Description</unit>
					</ifdef>}}}

					{{{<ifdef code="ca_entities.vhh_URL"><div class='unit'><label>URL</label><unit relativeTo="ca_entities.vhh_URL" delimiter="<br/>"><a href="ca_entities.vhh_URL" target="_blank">^ca_entities.vhh_URL</a></unit></div></ifdef>}}}

					{{{<ifdef code="ca_entities.vhh_Note">
						<label>Notes</label>
						<unit relativeTo="ca_entities.vhh_Note" delimiter="<br/>">							
							<span class="trimText">^vhh_NoteText</span>

							<a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_entities.vhh_Note.vhh_NoteReference">
									<br/>
									<small>Reference:</small>
									<small>^ca_entities.vhh_Note.vhh_NoteReference</small>
									<br/>
									<small>Source:</small>
									<small>^ca_entities.vhh_Note.vhh_NoteReference.__source__</small>
								</ifdef>
							</div>
						</unit>
					</ifdef>}}}

					{{{<ifdef code="ca_entities.edu_EduOrgType"><div class='unit'><label>Educational Organization Type</label>^ca_entities.edu_EduOrgType</div></ifdef>}}}
					{{{<ifdef code="ca_entities.edu_KnowledgeFieldAct"><div class='unit'><label>Knowledge Field of Activity</label>^ca_entities.edu_KnowledgeFieldAct</div></ifdef>}}}
					

				</div><!-- end col -->

				<div class='col-sm-6 col-md-6 col-lg-6'>		
			
					{{{<ifcount code="ca_collections" min="1" max="1"><label><?= _t('Related Case Study'); ?></label></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><label><?= _t('Related Case Studies'); ?></label></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><label><?= _t('Related Event'); ?></label></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><label><?= _t('Related Events'); ?></label></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>">
						<l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)
						<a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_entities_x_occurrences.vhh_TemporalScope">
								<br/>
								<small>Temporal Scope:</small>
								<unit relativeTo="ca_entities_x_occurrences.vhh_TemporalScope" delimiter=",">
									<small>^ca_entities_x_occurrences.vhh_TemporalScope</small>
								</unit>
							</ifdef>

							<ifdef code="ca_entities_x_occurrences.vhh_Note.vhh_NoteText">
								<br/>
								<small>Note:</small>
								<unit relativeTo="ca_entities_x_occurrences.vhh_Note.vhh_NoteText" delimiter=",">
									<small>^ca_entities_x_occurrences.vhh_Note.vhh_NoteText</small>
									<br/>
									<small>Reference:</small>
									<small>^ca_entities_x_occurrences.vhh_Note.vhh_NoteReference</small>
									<br/>
									<small>Source:</small>
									<small>^ca_entities_x_occurrences.vhh_Note.vhh_NoteReference.__source__</small>
								</unit>
							</ifdef>
						</div>
						<br/>
					</unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><label><?= _t('Related Location'); ?></label></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><label><?= _t('Related Locations'); ?></label></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>">
						<l>^ca_places.preferred_labels.name</l> (^relationship_typename)
						<a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_entities_x_places.vhh_TemporalScope">
								<br/>
								<small>Temporal Scope:</small>
								<unit relativeTo="ca_entities_x_places.vhh_TemporalScope" delimiter=",">
									<small>^ca_entities_x_places.vhh_TemporalScope</small>
								</unit>
							</ifdef>

							<ifdef code="ca_entities_x_places.vhh_Note.vhh_NoteText">
								<br/>
								<small>Note:</small>
								<unit relativeTo="ca_entities_x_places.vhh_Note.vhh_NoteText" delimiter=",">
									<small>^ca_entities_x_places.vhh_Note.vhh_NoteText</small>
									<br/>
									<small>Reference:</small>
									<small>^ca_entities_x_places.vhh_Note.vhh_NoteReference</small>
									<br/>
									<small>Source:</small>
									<small>^ca_entities_x_places.vhh_Note.vhh_NoteReference.__source__</small>
								</unit>
							</ifdef>
						</div>
						<br/>
					</unit>}}}
					
					</br>
					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><label><?= _t('Related Person/Organization'); ?></label></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><label><?= _t('Related People/Organizations'); ?></label></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter="<br/>">
						<l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)
						<a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_entities_x_entities.vhh_TemporalScope">
								<br/>
								<small>Temporal Scope:</small>
								<unit relativeTo="ca_entities_x_entities.vhh_TemporalScope" delimiter=",">
									<small>^ca_entities_x_entities.vhh_TemporalScope</small>
								</unit>
							</ifdef>

							<ifdef code="ca_entities_x_entities.vhh_Note.vhh_NoteText">
								<br/>
								<small>Note:</small>
								<unit relativeTo="ca_entities_x_entities.vhh_Note.vhh_NoteText" delimiter=",">
									<small>^ca_entities_x_entities.vhh_Note.vhh_NoteText</small>
									<br/>
									<small>Reference:</small>
									<small>^ca_entities_x_entities.vhh_Note.vhh_NoteReference</small>
									<br/>
									<small>Source:</small>
									<small>^ca_entities_x_entities.vhh_Note.vhh_NoteReference.__source__</small>
								</unit>
							</ifdef>
						</div>
						<br/>
					</unit>}}}
					
					</br></br>

					<!-- TODO: where do we stick the visualization? -->
					<?= $this->render('Details/entity_viz_html.php'); ?>
					{{{map}}}
					</br>
				</div><!-- end col -->
			</div><!-- end row -->
			
			<br/> 
			
{{{<ifcount code="ca_objects.related" min="1">
			<H1><?= _t('Related Films, Texts and Images'); ?></H1>

			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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


	// jQuery(document).ready(function() {
	// 	$('.trimText').readmore({
	// 	  speed: 75,
	// 	  maxHeight: 120
	// 	});
	// });
</script>
