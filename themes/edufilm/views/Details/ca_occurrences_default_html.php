<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
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
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					<H2>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>}}}</H2>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifcount code="ca_objects" min="1" max="1">
						<div class='unit'><unit relativeTo="ca_objects" delimiter=" ">
							<l>^ca_object_representations.media.large</l>
							<!-- <div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div> -->
						</unit></div>
					</ifcount>}}}

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
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>

					{{{<ifdef code="ca_occurrences.idno">
						<div class="unit"><label>Event Identifier</label>
						<unit relativeTo="ca_occurrences.idno" delimiter="<br/>">
							^idno
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_occurrences.vhh_EventName">
						<div class="unit"><label>Event Name</label>
						<unit relativeTo="ca_occurrences.vhh_EventName" delimiter="<br/>">
							^TitleTextE
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_occurrences.vhh_DateEvent"><div class="unit"><label>Event Date</label>^ca_occurrences.vhh_DateEvent</div></ifdef>}}}

					{{{<ifdef code="ca_occurrences.vhh_Description">
						<div class="unit"><label>Description</label>
						<unit relativeTo="ca_occurrences.vhh_Description" delimiter="<br/>">
							^DescriptionText
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_occurrences.vhh_URL">
						<label>URL:</label>
						<unit relativeTo="ca_occurrences.vhh_URL" delimiter="<br/>">
							<a href="ca_occurrences.vhh_URL" target="_blank">^ca_occurrences.vhh_URL</a>
						</unit>
					</ifdef>}}}

					{{{<ifdef code="ca_occurrences.vhh_Note">
						<div class="unit"><label>Note:</label>
						<unit relativeTo="ca_occurrences.vhh_Note" delimiter="<br/>">
							^vhh_NoteText
						</unit>
						<unit relativeTo="ca_occurrences.vhh_Note" delimiter="<br/>">
							<ifdef code="^ca_occurrences.vhh_Note.vhh_NoteReference"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
							<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
								<ifdef code="^ca_occurrences.vhh_Note.vhh_NoteReference">
									<br/>
									<small>Reference:</small>
									<small>^ca_occurrences.vhh_Note.vhh_NoteReference</small>
									<br/>
									<small>Source:</small>
									<small>^ca_occurrences.vhh_Note.vhh_NoteReference.__source__</small>
								</ifdef>
							</div>
						</unit></div>
					</ifdef>}}}

					{{{<ifcount code="ca_collections" min="1"><div class="unit"><ifcount code="ca_collections" min="1" max="1"><label><?= _t('Related collection'); ?></label></ifcount>
						<ifcount code="ca_collections" min="2"><label><?= _t('Related collections'); ?></label></ifcount>
						<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_entities" min="1"><div class="unit"><ifcount code="ca_entities" min="1" max="1"><label><?= _t('Related Entity'); ?></label></ifcount>
						<ifcount code="ca_entities" min="2"><label><?= _t('Related Entities'); ?></label></ifcount>
						<unit relativeTo="ca_entities_x_occurrences" delimiter="<br/>">
						<l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)
						<ifdef code="ca_entities_x_occurrences.vhh_TemporalScope|ca_entities_x_occurrences.vhh_Note.vhh_NoteText"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
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
					</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_occurrences.related" min="1"><ifcount code="ca_occurrences.related" min="1" max="1"><label><?= _t('Related occurrence'); ?></label></ifcount>
						<ifcount code="ca_occurrences.related" min="2"><label><?= _t('Related occurrences'); ?></label></ifcount>
						<unit relativeTo="ca_occurrences_x_occurrences" delimiter="<br/>">
						<l>^ca_occurrences.related.preferred_labels.name</l> (^relationship_typename)
						<ifdef code="ca_occurrences_x_occurrences.vhh_TemporalScope|ca_occurrences_x_occurrences.vhh_Note.vhh_NoteText"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_occurrences_x_occurrences.vhh_TemporalScope">
								<br/>
								<small>Temporal Scope:</small>
								<unit relativeTo="ca_occurrences_x_occurrences.vhh_TemporalScope" delimiter=",">
									<small>^ca_occurrences_x_occurrences.vhh_TemporalScope</small>
								</unit>
							</ifdef>

							<ifdef code="ca_occurrences_x_occurrences.vhh_Note.vhh_NoteText">
								<br/>
								<small>Note:</small>
								<unit relativeTo="ca_occurrences_x_occurrences.vhh_Note.vhh_NoteText" delimiter=",">
									<small>^ca_occurrences_x_occurrences.vhh_Note.vhh_NoteText</small>
									<br/>
									<small>Reference:</small>
									<small>^ca_occurrences_x_occurrences.vhh_Note.vhh_NoteReference</small>
									<br/>
									<small>Source:</small>
									<small>^ca_occurrences_x_occurrences.vhh_Note.vhh_NoteReference.__source__</small>
								</unit>
							</ifdef>
						</div>
						
					</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_places" min="1"><div class="unit"><ifcount code="ca_places" min="1" max="1"><label><?= _t('Related place'); ?></label></ifcount>
						<ifcount code="ca_places" min="2"><label><?= _t('Related places'); ?></label></ifcount>
						<unit relativeTo="ca_places_x_occurrences" delimiter="<br/>">
						<l>^ca_places.preferred_labels.name</l> (^relationship_typename)
						<ifdef code="ca_places_x_occurrences.vhh_TemporalScope|ca_places_x_occurrences.vhh_Note.vhh_NoteText"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
						<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
							<ifdef code="ca_places_x_occurrences.vhh_TemporalScope">
								<br/>
								<small>Temporal Scope:</small>
								<unit relativeTo="ca_places_x_occurrences.vhh_TemporalScope" delimiter=",">
									<small>^ca_places_x_occurrences.vhh_TemporalScope</small>
								</unit>
							</ifdef>

							<ifdef code="ca_places_x_occurrences.vhh_Note.vhh_NoteText">
								<br/>
								<small>Note:</small>
								<unit relativeTo="ca_places_x_occurrences.vhh_Note.vhh_NoteText" delimiter=",">
									<small>^ca_places_x_occurrences.vhh_Note.vhh_NoteText</small>
									<br/>
									<small>Reference:</small>
									<small>^ca_places_x_occurrences.vhh_Note.vhh_NoteReference</small>
									<br/>
									<small>Source:</small>
									<small>^ca_places_x_occurrences.vhh_Note.vhh_NoteReference.__source__</small>
								</unit>
							</ifdef>
						</div>
					</unit></div></ifcount>}}}	
					{{{map}}}				
				</div><!-- end col -->
			</div><!-- end row -->

{{{<ifcount code="ca_objects.related" min="1">
			<H1><?= _t('Related Films, Texts and Images'); ?></H1>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}		</div><!-- end container -->
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
